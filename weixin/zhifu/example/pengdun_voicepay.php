<div class="hidden" style="display: none;">
<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
libxml_disable_entity_loader(true);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息


//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();
$total = array_pop(explode('=',$_GET['total']));
//var_dump($total);
//var_dump($openId);
//die();
//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("智冷科技");
$input->SetAttach("test");
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee($total);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("notify.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
/*echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
printf_info($order);*/
$jsApiParameters = $tools->GetJsApiParameters($order);

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
						
					            window.location.href="http://www.jfcss.com/FreshShield/html/payvoiceok.html";
					        
		              	

					} else if(res.err_msg == "get_brand_wcpay_request:cancel") {
						alert("您已取消付款！！！");
						setTimeout(function () {
				            window.history.go(-1)
				        }, 1500);
						
					} else {
						
						alert("暂时无法付款，请联系客服人员");
						setTimeout(function () {
				           window.history.go(-1)
				        }, 1500);
					};
				}
			);
		}
	</script>
</body>

</html>