<?php //c端缴年费
//http://www.ccsc58.cc/leng/weixin/zhifu/example/freshdun_flow_buy_back.php?shebeihao=999300&years=1&u_id=12423&f_id=1
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);
libxml_disable_entity_loader(true);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

$year = intval($_GET['years']);
if($year<1){
	echo "参数错误";exit;
}
$f_id = intval($_GET['f_id']);
$dbh = new PDO('mysql:host=rm-2ze3o57ph836pk46r.mysql.rds.aliyuncs.com;dbname=wlgl', 'test01', 'Pzg790915');
$sql = "select * from shield_flow_package where f_id={$f_id}";
$sth = $dbh->prepare($sql);
$sth->execute();
$rs1 = $sth->fetch(PDO::FETCH_ASSOC);
if (!$rs1) {
	die("flow not exist");
}
$total = $year * $rs1['price'] * 100;
//$total = 1;

if(isset($_GET['shebeihao']) && trim($_GET['shebeihao'])) {
	$shebeibianhao = trim($_GET['shebeihao']);
	$sql = "select count(*) c from tb_device where shebeibianhao='{$shebeibianhao}'";
	$sth = $dbh->prepare($sql);
	$sth->execute();
	$rs = $sth->fetch(PDO::FETCH_ASSOC);
	if($rs['c'] <= 0) die('设备号不存在');
} else {
	die('device error');
}

if(isset($_GET['u_id']) && intval($_GET['u_id']) > 0) {
	$u_id = intval($_GET['u_id']);
	$sql = "select count(*) c from shield_user where id={$u_id}";
	$sth = $dbh->prepare($sql);
	$sth->execute();
	$rs = $sth->fetch(PDO::FETCH_ASSOC);
	if($rs['c'] <= 0) die('user not exist');
} else {
	die('u_id error');
}

//打印输出数组信息
$attach = array(
	'shebeihao' => $shebeibianhao,
	'years' => $year,
	'u_id' => $u_id,
	'f_id' => $f_id, //套餐id
	'money' => $rs1['price'],
);

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
//$input->SetTotal_fee(1);
$input->SetTotal_fee($total);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://www.ccsc58.cc/leng/weixin/zhifu/example/freshdun_flow_buy_notify_back.php");
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
						// var _sjgoingpay = JSON.parse(sessionStorage.getItem('sjgoingpay'));
      //                   let _num=_sjgoingpay.shebeihao;
		    //           $.ajax({
		    //           	type:"post",
		    //           	url:"https://www.zjcoldcloud.com/xiandun/public/index.php/index/flow_package/server_flow_buy",
		    //           	data:_sjgoingpay,
		    //           	dataType:"JSON",
		    //           	success:function(res){
		    //           		alert("付款成功");
		    //           		window.sessionStorage.removeItem('sjgoingpay');
						 	setTimeout(function () {
					            window.location.href="../../../FreshShield/html/bill.html";
					         }, 1500);
		    //           	},
		    //           	error:function(err){
		    //           		alert("付款成功！");
		    //           		console.log(err)
		    //           	}
		    //           });

					} else if(res.err_msg == "get_brand_wcpay_request:cancel") {
						alert("您已取消付款！！！");
						window.sessionStorage.removeItem('sjgoingpay');
						setTimeout(function () {
					           window.location.href="../../../FreshShield/html/bill.html";
					        }, 1500);
					} else {
						window.sessionStorage.removeItem('sjgoingpay');
						alert("暂时无法付款，请联系客服人员");
						setTimeout(function () {
					           window.location.href="../../../FreshShield/html/bill.html";
					        }, 1500);

					};
				}
			);
		}
	</script>
</body>

</html>