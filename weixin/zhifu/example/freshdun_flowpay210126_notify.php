<?php
ini_set('date.timezone', 'Asia/Shanghai');
// error_reporting(E_ERROR);

require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
require_once 'log.php';

//初始化日志
$logHandler = new CLogFileHandler("../logs/" . date('Y-m-d') . '.log');
$log = Log::Init($logHandler, 15);

// $testxml = file_get_contents("php://input");
// $jsonxml = json_encode(simplexml_load_string($testxml, 'SimpleXMLElement', LIBXML_NOCDATA));
// Log::DEBUG("wxLog:" . $jsonxml);
// Log::DEBUG("GLOBALS wxLog:" . $GLOBALS['HTTP_RAW_POST_DATA']);
//$jsonxml = '{"appid":"wx029d1989acb9f44c","attach":"{\"u_id\":\"22136\",\"f_id\":2,\"shebeihao\":\"551756\",\"type\":\"c\"}","bank_type":"ABC_DEBIT","cash_fee":"2400","fee_type":"CNY","is_subscribe":"Y","mch_id":"1454416802","nonce_str":"ogewqgaw29mc4jv141amow8kvaxtjqrx","openid":"oSPfHv9n6W5rBQLRjx7oP91DeSus","out_trade_no":"145441680220210222123600","result_code":"SUCCESS","return_code":"SUCCESS","sign":"B66102C0BDCA161399A95170734E5FB4","time_end":"20210222123606","total_fee":"2400","trade_type":"JSAPI","transaction_id":"4200000941202102220232251293"}';

// $result = json_decode($jsonxml, true); //转成数组
// echo '<pre>';
// var_dump($result);exit;

class PayNotifyCallBack extends WxPayNotify
{
    //查询订单
    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        Log::DEBUG("query:" . json_encode($result));
        if (array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS") {
            return true;
        }
        return false;
    }

    //重写回调处理函数
    public function NotifyProcess($data, &$msg)
    {
        Log::DEBUG("call back:" . json_encode($data));
        $notfiyOutput = array();

        if (!array_key_exists("transaction_id", $data)) {
            $msg = "输入参数不正确";
            Log::DEBUG("error: $msg " . json_encode($data));
            return false;
        }
        //查询订单，判断订单真实性
        if (!$this->Queryorder($data["transaction_id"])) {
            $msg = "订单查询失败";
            Log::DEBUG("error: $msg " . json_encode($data));
            return false;
        }

        if (isset($data['return_code']) && $data['return_code'] == 'SUCCESS') {
            $dbh = new PDO('mysql:host=rm-2ze3o57ph836pk46r.mysql.rds.aliyuncs.com;dbname=wlgl', 'test01', 'Pzg790915');
            $dbh->beginTransaction();

            $attach = json_decode($data['attach'], true);

            $sql = "select flow_type,daoqishijian,money from tb_device where shebeibianhao='{$attach['shebeihao']}'";
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $deviceResult = $sth->fetch(PDO::FETCH_ASSOC);
            if (!$deviceResult) {
                $dbh->rollBack();
                $msg = "设备套餐查询失败";
                Log::DEBUG("error: $msg, shebeibianhao={$attach['shebeihao']}");
                return false;
            }

            if ($deviceResult['flow_type'] == '0') {
                $dbh->rollBack();
                $msg = "该设备未初始化";
                Log::DEBUG("error: $msg, shebeibianhao={$attach['shebeihao']}");
                return false;
            }

            if ($deviceResult['flow_type'] == '2') {
                $dbh->rollBack();
                $msg = "该套餐已是最高级";
                Log::DEBUG("error: $msg, shebeibianhao={$attach['shebeihao']}");
                return false;
            }

            if ($deviceResult['flow_type'] == $attach['f_id']) {
                $dbh->rollBack();
                $msg = "不能升级同套餐";
                Log::DEBUG("error: $msg, shebeibianhao={$attach['shebeihao']}");
                return false;
            }

            $money = 0;

            $total_fee = $data['total_fee'] / 100;
            if ($deviceResult['money'] == '' || $deviceResult['money'] == '0') {
                $money = $total_fee;
            } else {
                $money = $total_fee + $deviceResult['money'];
            }

            $daoqishijian = date('Y-m-d H:i:s', strtotime('+12month'));

            $sql = "update tb_device set flow_type=2, money={$money}, daoqishijian='{$daoqishijian}' where shebeibianhao='{$attach['shebeihao']}'";

            $save_record = $dbh->exec($sql);
            if (!$save_record) {
                $dbh->rollBack();
                $msg = "更改套餐标志失败";
                Log::DEBUG("error: $msg, shebeibianhao={$attach['shebeihao']}");
                return false;
            } else {
                //购买记录表
                $sql = "insert into shield_device_top_record (shebeihao, u_id, money, f_id, addtime) values ('{$attach['shebeihao']}', '{$attach['u_id']}', '{$total_fee}', '{$attach['f_id']}', now())";
                // Log::DEBUG("insert sql:" . $sql);
                $update_line = $dbh->exec($sql);

                if ($update_line === 1) {
                    //erp 的SIM卡表模型
                    $sql = "select card_code from zjzl_device_manage_system_01.ms_device_card where device_code='{$attach['shebeihao']}'";
                    $sth = $dbh->prepare($sql);
                    $sth->execute();
                    $rs = $sth->fetch(PDO::FETCH_ASSOC);
                    if (!$rs) {
                        $dbh->commit();
                        $msg = "success, SIM卡表无该设备号";
                        return true;
                    }

                    $sql = "update zjzl_device_manage_system_01.ms_device_card set f_id='{$attach['f_id']}', buy_time=now() where device_code='{$attach['shebeihao']}'";
                    $save_record = $dbh->exec($sql);
                    if (!$save_record) {
                        $dbh->rollBack();
                        $msg = "更改SIM卡状态失败";
                        Log::DEBUG("error: $msg, $sql");
                        return false;
                    }

                    $dbh->commit();
                } else {
                    $dbh->rollBack();
                    $msg = "添加记录失败";
                    Log::DEBUG("error: $msg, $sql");
                    return false;
                }
            }

            $dbh = null;
        }

        return true;
    }
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
