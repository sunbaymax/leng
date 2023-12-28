<div style="display:none">
	<?php
		require_once "../jssdk.php";
		$jssdk = new JSSDK("wx029d1989acb9f44c", "b7a482220530d3be2278429bdf2a7a63");
		$signPackage = $jssdk->GetSignPackage();
	?>
</div>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>农管家</title>
	<link rel="stylesheet" href="../css/index.css" />
	<link rel="stylesheet" href="../css/index01.css" />
	<link rel="stylesheet" href="../css/dingdan.css" />
	<link rel="stylesheet" href="../css/changeM.css" />
</head>

<body>
	<div class="header">
		<img class="back_list" src="../img/back.png"/>
		我的订单
		<img src="../img/search_ding.png" alt="" />
	</div>
	<div class="content">
		
	</div>
	<div class="footer">
			<a href="../index.html">
				<img src="../images/tab_weixin_normal.png" alt="" />
				<span>首页</span>
			</a>
			<a href="dingdan.php"  class="choosed">
				<img src="../images/tab_find_frd_pressed.png" alt="" />
				<span>我的运单</span>
			</a>
			<a href="shebei_list.html">
				<img src="../images/tab_address_normal.png" alt="" />
				<span>设备信息</span>
			</a>
			<a href="user_sheZhi.html">
				<img src="../images/tab_settings_normal.png" alt="" />
				<span>我的</span>
			</a>
		</div>
	

	<!--<div class="wait">
		数据加载中<span style="">……</span>
	</div>-->
	<div class="search_dingdan">
		<input type="text" placeholder="请输入订单号" /><br><input type="button" value="搜索" /><img src="../img/saoyisao.png" alt="" />
		<div class="hidden">
			
		</div>
	</div>
	<script src="../js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/dingdan.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/index.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" charset="utf-8"></script>
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
		$(".search_dingdan img").on("click", function() {
			wx.scanQRCode({
				needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
				scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
				success: function(res) {
					var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果;
					if(result.indexOf(",")!=-1){
						$(".search_dingdan input:nth-of-type(1)").val(result.match(/\,.+/)[0].replace(",",""));
					}else{
						$(".search_dingdan input:nth-of-type(1)").val(result);
					}
				}
			});
		})
		/*var _dog="CODE_39,12 3456789";
		console.log(_dog.match(/\,.+/)[0].replace(",",""));*/
	</script>
</body>

</html>