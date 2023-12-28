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
// $jsonxml = '{"appid":"wx029d1989acb9f44c","attach":"{\"type\":\"1\",\"number\":\"2998271\",\"num\":\"10\",\"admin_user\":\"tbqtest\"}","bank_type":"CITIC_CREDIT","cash_fee":"1","fee_type":"CNY","is_subscribe":"Y","mch_id":"1454416802","nonce_str":"qftfarkvspyw0wrgnofdhfvbb613trnw","openid":"oSPfHvycCLdGBQJIL1CjAgjR84hI","out_trade_no":"SMS2020110411524333679","result_code":"SUCCESS","return_code":"SUCCESS","sign":"B18641F1C94B5EA30E28EEB9CD9EC8C3","time_end":"20201104115249","total_fee":"1","trade_type":"JSAPI","transaction_id":"4200000819202011043413327133"}';

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
            return false;
        }
        //查询订单，判断订单真实性
        if (!$this->Queryorder($data["transaction_id"])) {
            $msg = "订单查询失败";
            return false;
        }

        if (isset($data['return_code']) && $data['return_code'] == 'SUCCESS') {
            $dbh = new PDO('mysql:host=rm-2ze3o57ph836pk46r.mysql.rds.aliyuncs.com;dbname=wlgl', 'test01', 'Pzg790915');
            $dbh->beginTransaction();

            $attach = json_decode($data['attach'], true);

            $sql = "select * from tb_department where number={$attach['number']} for update";
            //echo $sql, "\n";
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $rs = $sth->fetch(PDO::FETCH_ASSOC);
            if (!$rs) {
                $dbh->rollBack();
                $msg = "部门不存在";
                return false;
            }

            //执行业务逻辑,创建订单数据
            $current_num = $rs['duanxingshengyushuliang'] + $attach['num'];
            $sql = "INSERT INTO tb_department_payment_records (trade_no, openid, mechanism_id, `money`, num, type, pay_time, createtime, pay_type, admin_user, source, current_num) VALUES ('{$data['out_trade_no']}', '{$data['openid']}', '{$attach['number']}', {$data['total_fee']}, {$attach['num']}, {$attach['type']}, '" . date('Y-m-d H:i:s', strtotime($data['time_end'])) . "', now(), 2, '{$attach['admin_user']}', 'wx', '{$current_num}')";
            //Log::DEBUG("insert sql:" . $sql);
            $save_record = $dbh->exec($sql);
            if (!$save_record) {
                $dbh->rollBack();
                $msg = "save record error";
                return false;
            } else {
                //修改短信条数 锁当前机构记录
                $sql = "update tb_department set duanxingshengyushuliang={$current_num}, duanxingkaitong=1 where `number`='{$attach['number']}'";
                // Log::DEBUG("update sql:" . $sql);
                $update_line = $dbh->exec($sql);

                if ($update_line === 1 && $save_record) {
                    $dbh->commit();
                } else {
                    $dbh->rollBack();
                    $msg = "update order error";
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

// $data = '{"appid":"wx029d1989acb9f44c","attach":"{\"type\":\"1\",\"number\":\"000004\",\"num\":\"10\",\"admin_user\":\"tbqtest\"}","bank_type":"CITIC_CREDIT","cash_fee":"1","fee_type":"CNY","is_subscribe":"Y","mch_id":"1454416802","nonce_str":"s3i3pwnxz98s2taaco5pp1l8m0nde26s","openid":"oSPfHvycCLdGBQJIL1CjAgjR84hI","out_trade_no":"SMS2020110516592447792","result_code":"SUCCESS","return_code":"SUCCESS","sign":"F3B7E0D15057ECDDB33EBA1DA03963A6","time_end":"20201105165930","total_fee":"1","trade_type":"JSAPI","transaction_id":"4200000827202011050067574379"}';
// $data = json_decode($data, true);
// $msg = '';
// $notify->NotifyProcess($data, $msg);
// var_dump($msg);
