<div class="hidden" style="display: none;">
	<?php 
		ini_set('date.timezone','Asia/Shanghai');
		libxml_disable_entity_loader(true);
		require_once "../lib/WxPay.Api.php";
		require_once "WxPay.JsApiPay.php";
		require_once 'log.php';
		$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
		$log = Log::Init($logHandler, 15);
		$tools = new JsApiPay();
		$openId = $tools->GetOpenid();
		$total = array_pop(explode('=',$_GET['total']));
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
		$jsApiParameters = $tools->GetJsApiParameters($order);
		$editAddress = $tools->GetEditAddressParameters();
	?>
</div>
<html>

<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>智冷科技微信支付平台</title>
</head>

<body>
	<form class="abc" action="../../../weixinnew/last8_28.php" method="post"  style="display: none;"  id="aaa">
		收款成功：<input class="abcd" type="text" name="success"  value="微信商城用户下单成功"/><br /> 
		订单号：<input type="text" class="danhao" name="danhao" value="暂无" /><br />
		金额：<input class="money" type="text" name="nickname" /><br /> 
		付款人：<input class="username" type="text" name="username" value="暂无" /><br /> 
		时间：<input class="time" type="text" name="cb"/><br /> 
		openID：<input class="_openID" type="text" name="123" value="oSPfHv-pXx-_E5jFehQHWQy1lpmI" /><br /> 
	</form>
	<script src="../../js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
	<script src="../../js/ajaxForm.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		callpay();

	    	var _pay_money = window.sessionStorage.getItem("pay_money");
		    var _total = window.sessionStorage.getItem('pay_money');
			var _openid = window.sessionStorage.getItem('openid');
			var _alink = JSON.parse(sessionStorage.getItem('payinfo'));
			var _goods = JSON.parse(sessionStorage.getItem('paygoods'));
			var _linkid=_alink.address_id;
			var _remark=_alink.backup;
			var _money=_alink.pay_money;
			
	
			
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
						var _pay_money = window.sessionStorage.getItem("pay_money");
						var _total = window.sessionStorage.getItem('pay_money');
						var _openid = window.sessionStorage.getItem('openid');
						var _alink = JSON.parse(sessionStorage.getItem('payinfo'));
						var _goods = JSON.parse(sessionStorage.getItem('paygoods'));
						var _linkid = _alink.address_id;
						var _remark = _alink.backup;
						var _money = _alink.pay_money;
			            $.ajax({
		                	type:"post",
		                	url:"http://www.ccsc58.com/json/shopping/order.php",
		                	data:{
		                		openid:_openid,
		                		address_id:_linkid,
		                		remark:_remark,
		                		goods:_goods,
		                		money:_money,
		                		action:"insert"
		                	},
		                	dataType:"json",
		                	success:function(res){
		                		
		                		var timestamp = Date.parse(new Date());
		                		function getNowFormatDate() {
							        var date = new Date();
							        var seperator1 = "-";
							        var year = date.getFullYear();
							        var month = date.getMonth() + 1;
							        var strDate = date.getDate();
							        if (month >= 1 && month <= 9) {
							            month = "0" + month;
							        }
							        if (strDate >= 0 && strDate <= 9) {
							            strDate = "0" + strDate;
							        }
							        var currentdate = year + seperator1 + month + seperator1 + strDate;
							        return currentdate;
							    }
							    var curtend=getNowFormatDate();
		                		console.log(res)
		                		if(res.code==0){
		                			var _openId=["oSPfHv-jEPOW_KI6x67x1JOGqm514",'oSPfHv-pXx-_E5jFehQHWQy1lpmI'];
		                			for(var i=0;i<_openId.length;i++){
			                			$.ajax({
							            	type:"post",
							            	url:"http://www.ccsc58.cc/leng/last8_28.php",
							            	data:{
							            		frist:"店主，有新订单啦，请及时处理。",
							            		keyword1:timestamp,
							            		keyword2:"温度记录仪",
							            		keyword3:_money,
							            		keyword4:curtend,
							            		remark:'_remark',
							            		openId:_openId[i]
							            	},
							            	dataType:"json",
							            	success:function(res){
							            		
							            	},
							            	error:function(err){
							            		 window.location.href="http://www.ccsc58.cc/leng/shop/shop.html";
							            	}
							            });
		                			}
                                    alert("付款成功 ，交易完成！！！");
							        window.location.href="http://www.ccsc58.cc/leng/shop/shop.html";
		                		}else{
		                			alert("网络故障！");
		                			 window.location.href="http://www.ccsc58.cc/leng/shop/shop.html";
		                		}
		                	},
		                	error:function(err){
		                		console.log(err)
		                	}
			            }); 
					} else if(res.err_msg == "get_brand_wcpay_request:cancel") {
						alert("您已取消付款！！！");
						window.location.href="http://www.ccsc58.cc/leng/shop/shop.html";
					} else {
						alert("暂时无法付款，请联系客服人员");
					};
				}
			);
		}
	</script>
</body>

</html>