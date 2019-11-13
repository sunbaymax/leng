<div style="display:none">
	<?php
		require_once "../jssdk.php";
		$jssdk = new JSSDK("wx82dbac04fa8fd8ef", "98ecda31265ffc327d59adc969089650");
		$signPackage = $jssdk->GetSignPackage();
	?>
</div>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>确认收货，收红包啦</title>
	<link rel="stylesheet" type="text/css" href="../css/index.css" />
	<link rel="stylesheet" type="text/css" href="hongBao/hongbao.css" />
</head>

<body>
	<img class="hong_bj" src="../img/hb_bj.png" />
	<form class="hong_box">
		<p></p>
		<input type="text" placeholder="请输入或扫描运单号" />
		<input type="text" placeholder="请输入手机号" />
		<div class="yanZhengMa">
			获取验证码
		</div>
		<input type="text" placeholder="请输入验证码" />
		<div class="button">确认收货</div>
		<img src="../img/hong_sao.png" />
	</form>
	<div class="JieChuBang_box hidden">
			<div class="JieChuBang">
				<div class="JieChuBang_top">
					
				</div>
				<div class="JieChuBang_footer">
					<div class="JieChuBang_left">
						确定
					</div>
				</div>
			</div>
		</div>
	<script src="../js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
	<script src="hongBao/hongbao.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		wx.config({
			debug: false,
			appId: '<?php echo $signPackage["appId"];?>',
			timestamp: '<?php echo $signPackage["timestamp"];?>',
			nonceStr: '<?php echo $signPackage["nonceStr"];?>',
			signature: '<?php echo $signPackage["signature"];?>',
			jsApiList: [
				'chooseImage',
				'scanQRCode'
			]
		});
		$(".hong_box img").on("click", function() {
			wx.scanQRCode({
				needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
				scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
				success: function(res) {
					var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果;
					/*$("form input").val(result.replace("CODE_128,", ""));
					$("form div").removeClass("hidden");*/
					$(".hong_box input:nth-of-type(1)").val(result.replace("CODE_128,", ""));
				}
			});
		});
		var _openId = window.location.href.match(/\?openId=\S+/)[0].replace("?openId=", "");
		if(_openId=="zjly"){
			$(".JieChuBang_top").html("红包已发送，请注意查收！")
			$(".JieChuBang_box").removeClass("hidden");
		}else if(_openId=="zjly01"){
			$(".JieChuBang_top").html("红包发送失败，请重试！")
			$(".JieChuBang_box").removeClass("hidden");
		}else{
			$(".button").on("click",function(){
				window.location.href="hongbao.php?openId="+_openId;
			});
		};
		$(".JieChuBang_left").on("click",function(){
			WeixinJSBridge.call('closeWindow');
		});
	</script>
</body>

</html>