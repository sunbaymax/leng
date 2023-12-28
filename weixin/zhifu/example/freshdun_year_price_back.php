<?php
/**
 * b端年费缴费
 */
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
libxml_disable_entity_loader(true);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';

$dbh = new PDO('mysql:host=rm-2ze3o57ph836pk46r.mysql.rds.aliyuncs.com;dbname=wlgl', 'test01', 'Pzg790915');

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

$tradeNo = isset($_GET['tradeNo']) ? $_GET['tradeNo'] : die('tradeNo error');
$sql = "select * from tb_payment_record where trade_no='{$tradeNo}'";
$sth = $dbh->prepare($sql);
$sth->execute();
$rs = $sth->fetch(PDO::FETCH_ASSOC);
if (!$rs) {
	var_dump($_GET);
	die("tradeNo not exist");
}
$money = $rs['money'];
$money = 1;
$list = [];

//①、获取用户openid
$tools = new JsApiPay();
if(isset($_GET['source']) && $_GET['source'] == 'wxapp') {
    //微信小程序
    $openId = $_GET['openid'];
} else {
    $openId = $tools->GetOpenid();
}

//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("智冷科技");
$input->SetAttach('');

$input->SetOut_trade_no($tradeNo);
$input->SetTotal_fee($money);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://www.ccsc58.cc/wlgl_back/wxNotify_yearPrice.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);

if(isset($_GET['source']) && $_GET['source'] == 'wxapp') {
    //微信小程序
    $order = WxPayApi::unifiedOrderForWeapp($input);
} else {
    $order = WxPayApi::unifiedOrder($input);
}
$jsApiParameters = $tools->GetJsApiParameters($order);

if(isset($_GET['source']) && $_GET['source'] == 'wxapp') {
    header('content-type:application/json');
    die($jsApiParameters);
}
?>
<div class="hidden" style="display: none;">
<?php
echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';

//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
?>
</div>
<html>

<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>智冷科技微信支付平台</title>
</head>
        <div class="user"></div>
        <div class="shebeinum"></div>
        <div class="money"></div>
<body>
<script src="../../js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
callpay();
function callpay() {
    if(typeof WeixinJSBridge == "undefined") {
        if(document.addEventListener) {
            document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
        } else if(document.attachEvent) {
            document.attachEvent('WeixinJSBridgeReady', jsApiCall);
            document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
        }
    } else {
        jsApiCall();
    }
};

function jsApiCall() {

    WeixinJSBridge.invoke(
        'getBrandWCPayRequest',
        <?php echo $jsApiParameters; ?>,
        function(res) {
            WeixinJSBridge.log(res.err_msg);
            if(res.err_msg == "get_brand_wcpay_request:ok") {
                alert("付款成功");
                window.sessionStorage.removeItem('sjgoingpay');
                setTimeout(function () {
					history.go(-1)
                    //window.location.href="../../../FreshShield/html/upbill.html";
                }, 1500);
            } else if(res.err_msg == "get_brand_wcpay_request:cancel") {
                alert("您已取消付款！！！");
                window.sessionStorage.removeItem('sjgoingpay');
                setTimeout(function () {
					history.go(-1)
                    //window.location.href="../../../FreshShield/html/upbill.html";
                }, 1500);
            } else {
                window.sessionStorage.removeItem('sjgoingpay');
                alert("暂时无法付款，请联系客服人员");
                setTimeout(function () {					
					history.go(-1)
                    //window.location.href="../../../FreshShield/html/upbill.html";
                }, 1500);
            };
        }
    );
}
</script>
</body>

</html>