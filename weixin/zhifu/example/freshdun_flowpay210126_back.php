<?php
/**
 * 变更流量套餐 升级套餐
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

$f_id = isset($_GET['f_id']) ? intval($_GET['f_id']) : die('no f_id');
$phone = isset($_GET['phone']) ? trim($_GET['phone']) : die('no phone');
$shebeihao = isset($_GET['shebeihao']) ? trim($_GET['shebeihao']) : die('no shebeihao');

$sql = "select * from shield_flow_package where f_id={$f_id}";
$sth = $dbh->prepare($sql);
$sth->execute();
$rs = $sth->fetch(PDO::FETCH_ASSOC);
if (!$rs) {
	die("flow not exist");
}
$money_flow = $rs['price'] * 100;

$sql = "select id from shield_user where phone= :phone limit 1";
$sth = $dbh->prepare($sql);
$sth->execute(array(':phone' => $phone));
$rs = $sth->fetch(PDO::FETCH_ASSOC);
if (!$rs) {
	die("user not exist");
}
$u_id = $rs['id'];

$sql = "select d_id from shield_user_device where u_id = :u_id and shebeihao=:shebeihao limit 1";
$sth = $dbh->prepare($sql);
$sth->execute(array(':u_id' => $u_id, ':shebeihao' => $shebeihao));
$rs = $sth->fetch(PDO::FETCH_ASSOC);
if (!$rs) {
	$sql = "select id from shield_second_device where u_id = :u_id and shebeihao=:shebeihao limit 1";
	$sth = $dbh->prepare($sql);
	$sth->execute(array(':u_id' => $u_id, ':shebeihao' => $shebeihao));
	$rs = $sth->fetch(PDO::FETCH_ASSOC);
	if (!$rs) {
		die("user device not exist");
	}
}

$sql = "select id,flow_type,daoqishijian,money from tb_device where shebeibianhao=:shebeibianhao limit 1";
$sth = $dbh->prepare($sql);
$sth->execute(array(':shebeibianhao' => $shebeihao));
$rs = $sth->fetch(PDO::FETCH_ASSOC);
if (!$rs) {
	die("device not exist");
}

if ($rs['flow_type'] == '0') {
    die('该设备未初始化');
}

if ($rs['flow_type'] == '2') {
    die('该套餐已是最高级');
}

if ($rs['flow_type'] == $f_id) {
    die('不能升级同套餐');
}

$attach = array(
    'u_id' => $u_id,
    'f_id' => $f_id,
    'shebeihao' => $shebeihao,
    'type' => 'c', //c端升级套餐
);

$money = $money_flow - $rs['money'] * 100;
//$money = 1;

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
$input->SetAttach(json_encode($attach));
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee($money);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://www.ccsc58.cc/leng/weixin/zhifu/example/freshdun_flowpay210126_notify.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
if(isset($_GET['source']) && $_GET['source'] == 'wxapp') {
    //微信小程序
    $order = WxPayApi::unifiedOrderForWeapp($input);
} else {
    $order = WxPayApi::unifiedOrder($input);
}
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();
if(isset($_GET['source']) && $_GET['source'] == 'wxapp') {
    header('content-type:application/json');
    die($jsApiParameters);
}
?>
<div class="hidden" style="display: none;">


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
					           window.location.href="../../../FreshShield/html/upbill.html";
					        }, 1500);
					} else if(res.err_msg == "get_brand_wcpay_request:cancel") {
						alert("您已取消付款！！！");
						window.sessionStorage.removeItem('sjgoingpay');
						setTimeout(function () {
					           window.location.href="../../../FreshShield/html/upbill.html";
					        }, 1500);
					} else {
						window.sessionStorage.removeItem('sjgoingpay');
						alert("暂时无法付款，请联系客服人员");
						setTimeout(function () {
					           window.location.href="../../../FreshShield/html/upbill.html";
					        }, 1500);

					};
				}
			);
		}
	</script>
</body>

</html>
