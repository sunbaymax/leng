<div class="hidden">
	<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
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
/*var_dump($total);
die();*/
//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("冷云科技");
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
	<title>冷云科技--支付平台</title>
</head>

<body>
	<form class="abc" action="../../../weixinnew/last.php" method="post" style="display:none;" id="aaa">
		收款成功：<input class="abcd" type="text" name="username"  value="收款成功"/><br /> 
		订单号：<input type="text" name="password" value="暂无" /><br />
		金额：<input class="money" type="text" name="nickname" /><br /> 
		付款人：<input type="text" name="email" value="暂无" /><br /> 
		付款单位：<input class="pay_danWei" type="text" name="abc" value="" /><br /> 
		时间：<input class="time" type="text" name="cb"/><br /> 
		openID：<input class="_openID" type="text" name="123" value="oSPfHv6gYO5TVgeFIkTi1YU0tQqs" /><br /> 
		appkey：<input type="text" name="app_key" value="261AFF68C0E9F076420D083D66222824" /><br />
	</form>
	<script src="../../js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
	<script src="../../js/ajaxForm.js" type="text/javascript" charset="utf-8"></script>
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

		function history_time(_a) {
			var _start_year = _a.getFullYear();
			var _start_month = _a.getMonth() + 1 < 10 ? "0" + (_a.getMonth() + 1) : _a.getMonth() + 1;
			var _start_date = _a.getDate() < 10 ? "0" + (_a.getDate()) : _a.getDate();
			var _start_hour = _a.getHours() < 10 ? "0" + (_a.getHours()) : _a.getHours();
			var _start_minutes = _a.getMinutes() < 10 ? "0" + (_a.getMinutes()) : _a.getMinutes();
			var _start_seconds = _a.getSeconds() < 10 ? "0" + (_a.getSeconds()) : _a.getSeconds();
			return _start_year + "-" + _start_month + "-" + _start_date + " " + _start_hour + ":" + _start_minutes + ":" + _start_seconds;
		}

		function jsApiCall() {
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				<?php echo $jsApiParameters; ?>,
				function(res) {
					WeixinJSBridge.log(res.err_msg);
					if(res.err_msg == "get_brand_wcpay_request:ok") {
						var _money = window.sessionStorage.getItem("pay_money");
						var _daWei = window.sessionStorage.getItem("pay_daWei");
						var _payCity=window.sessionStorage.getItem("_pay_name");
						//alert(_daWei);decodeURI(window.location.href.match(/\&mao=\S+\+total=/)[0].replace("&mao=","").replace("+total=",""))
						var _x = new Date();
						$(".money").val("￥" + Number(_money).toFixed(2));
						$(".pay_danwei").val(_daWei);
						$(".time").val("服务城市："+_payCity);					
						$.ajax({
							url: "http://www.ccsc58.com/json/weixin/02_00_lykj_weixin_zhifu_post.php",
							type:"post",
							data: {
								controller: "register",
								admin_permit: "zjly8888",
								openid: _payCity,
								fukuandanwei: _daWei,
								money: _money
							},
							success: function(data) {
								var _json = JSON.parse(data);
								if(_json.code == 10000 && _json.message == "success" && _json.resultCode == "success") {
									var _openId=["oTarnv5aWyxLcCENYrs5UOR3FqvQ","oSPfHv-pXx-_E5jFehQHWQy1lpmI"];
									for(var i=0;i<_openId.length;i++){
										$("._openID").val(_openId[i]);
										var username=$("input[name='username']").val();
										var password=$("input[name='password']").val();
										var nickname=$("input[name='nickname']").val();
										var email=$("input[name='email']").val();
										var abc=$("input[name='abc']").val();
										var cb=$("input[name='cb']").val();
										var m123=$("input[name='123']").val();
										var app_key=$("input[name='app_key']").val();
										$.ajax({
											type:"post",
											url:"../../../../leng/lengyunjiekou.php",
											data:{
												username:username,
												password:password,
												nickname:nickname,
												email:email,
												abc:abc,
												cb:cb,
												m123:m123,
												app_key:app_key
											},
											success:function(data){
												if(i==1){
													window.location.href="../../image_test.html";
												}
											},
											error:function(){
												alert("网络错误，如已付款成功请联系'冷云科技客服人员'");
											}
										});
									}
									alert("冷云科技提醒您：付款￥"+_money+"成功");
								} else {
									alert("网络错误，请立即联系'冷云科技'客服人员确认是否已收到付款！");
								}
							},
							error:function(){
								alert("网络错误,请立即联系'冷云科技'客服人员确认是否已收到付款！");
							}
						});
					} else if(res.err_msg == "get_brand_wcpay_request:cancel") {
						alert("您已取消付款！！！");
						window.location.href="../../image_test.html";
					} else {
						alert("暂时无法付款，请联系客服人员");
					};
				}
			);
		}
	</script>
</body>

</html>