<?php
ini_set('date.timezone', 'Asia/Shanghai');
// error_reporting(E_ERROR);
// c端语音报警

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

            $attach = json_decode($data['attach'], true);
            $pid = isset($attach['pid']) ? intval($attach['pid']) : 0;
            $uid = isset($attach['uid']) ? intval($attach['uid']) : 0;

            $sql = "select * from shield_voice_package where id={$pid} and types='C'";
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $rs = $sth->fetch(PDO::FETCH_ASSOC);
            if (!$rs) {
                $msg = "套餐不存在";
                Log::DEBUG("error: $msg ");
                return false;
            }
            $numbers = $rs['numbers'];
            $total_fee = $data['total_fee'] / 100;

            $sql = "select phone,pk_total_num,pk_rema_num from shield_user where id={$uid}";
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $user = $sth->fetch(PDO::FETCH_ASSOC);
            if (!$user) {
                $msg = "用户不存在";
                Log::DEBUG("error: $msg ");
                return false;
            }

            $sql = "select id from shield_voice_buy_record where trade_no='{$data['out_trade_no']}'";
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $rs = $sth->fetch(PDO::FETCH_ASSOC);
            if ($rs) {
                $msg = "订单已存在";
                Log::DEBUG("error: $msg " . $sql);
                return false;
            }

            $dbh->beginTransaction();

            $data = ['p_id' => $pid,
                'u_id' => $uid,
                'totalnum' => $numbers,
                'remanum' => $numbers,
                'addtime' => date('Y-m-d H:i:s'),
                'duetime' => date("Y-m-d H:i:s", strtotime('+12month')),
                'duetag' => '1',
                'rematag' => '1',
                'usertype' => $attach['usertype'],
                'money' => $total_fee,
                'trade_no' => $data['out_trade_no'],
            ];
            $fieldList = '';
            $valueList = '';
            foreach ($data as $key => $value) {
                $fieldList .= ",`{$key}`";
                $valueList .= ",'{$value}'";
            }
            $fieldList = trim($fieldList, ',');
            $valueList = trim($valueList, ',');
            $sql = "insert into shield_voice_buy_record ({$fieldList}) values ({$valueList})";
            $save_record = $dbh->exec($sql);
            if (!$save_record) {
                $dbh->rollBack();
                $msg = '套餐记录表添加失败' . $sql;
                Log::DEBUG("error: $msg ");
                return false;
            }

            //总条数
            $totalNum = number_format($user['pk_total_num']) + number_format($numbers);

            //剩余条数
            $remaNum = number_format($user['pk_rema_num']) + number_format($numbers);

            //修改数据
            $changeData = ['pk_total_num' => $totalNum,
                'pk_rema_num' => $remaNum,
                'is_buy' => 1,
            ];
            $sql = "update shield_user set ";
            $i = 0;
            foreach ($changeData as $k => $v) {
                if ($i == 0) {
                    $sql .= "`{$k}`='{$v}'";
                } else {
                    $sql .= ",`{$k}`='{$v}'";
                }
                $i++;
            }
            $sql .= " where id={$uid}";
            $userResult = $dbh->exec($sql);
            if (!$userResult) {
                $dbh->rollBack();
                $msg = '用户表更新失败' . $sql;
                Log::DEBUG("error: $msg ");
                return false;
            }

            $dbh->commit();

            $dbh = null;
        }

        return true;
    }
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
