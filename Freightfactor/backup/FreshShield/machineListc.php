<div style="display:none">
	<?php
		require_once "jssdk.php";
		$jssdk = new JSSDK("wx029d1989acb9f44c", "b7a482220530d3be2278429bdf2a7a63");
		$signPackage = $jssdk->GetSignPackage();
	?>
</div>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<title>物运保理</title>
	<link rel="stylesheet" href="css/machineList.css" />
	<link rel="stylesheet" type="text/css" href="css/index.css" />
	<link rel="stylesheet" href="css/changeM.css" />
	<link rel="stylesheet" href="css/iconfont.css" />
</head>

<body>
	<div class="list_top">
		<div class="header">
			<img class="back_list" src="img/back.png" /> 冷链监控&nbsp;&nbsp;
			<!--<a href="javascript:void(0)">+添加设备</a>-->
		</div>
		<form>
			<label for="search"><img src="img/search.png"/></label>
			<input type="text" id="search" placeholder="请输入查询的设备号" />
			<input type="button" value="搜索" />
		</form>
	</div>
	<div class="content">
		<div id="wrapper">
			<div class="scroller">
				<div class="scroll_box">
					
					
					<div class="list hidden">
						<div class="list_tittle">
							<p>
								<img src="images/device.png" class="device_img" />
							    <span class="shebeihao">-</span>
							</p>
							<p>
								<span class="worktime">-</span>
							</p>
							
						</div>
						<div class="list-content">
							<div>
								电量：<span class="power">-</span>%
							</div>
							<div>
								<p>温度1：<span class="temp1">0.0</span>℃</p>
								<p>湿度：<span class="humidity">-</span>%RH</p>
							</div>
							<div>
								<p>温度2：<span class="temp2">0.0</span>℃</p>
								<p>速度：<span class="speed">-</span>km/h</p>
							</div>
							<div>
								<p>信号强度：<span class="signal">无</span></p>
								<p>箱体状态：<span class="boxstate">-</span></p>
							</div>
							<div>
								报警温度区间：<span class="alarmArea"></span>
							</div>
							<div>
								合格温度区间：<span class="AcceptableArea"></span>
							</div>
							<div>
								地理位置：<span class="address"></span>
							</div>
						</div>
					</div>
					<!--<div class="list hidden">
						<div class="list_left">
							<div>
								<p></p>
								<p></p>
								<p></p>
								<p></p>
								<p></p>
							</div>
						</div>
						<ul class="list_center">
							<li>
								<a href="javascript:void(0)"></a><span>箱体状态：<span></span></span>
							</li>
							<li class="li_all hidden">车牌号：<span></span></li>
							<li class="li_all">位置：<span></span></li>
							<li class="li_all">更新时间：<span></span></li>
							<li class="li_all hidden">上报时间：<span></span></li>
							<li class="li_all">合格温度区间：<span></span></li>
							<li class="li_all">报警温度区间：<span></span></li>
							<li class="li_all">信号强度：<span></span></li>
						</ul>
						<div class="list_right">
							<a href="javascript:void(0)">编辑设备</a><br/>
							<a href="javascript:void(0)">解除绑定</a>
						</div>
					</div>-->
					
				</div>
				<div class="more">
					<i class="pull_icon"></i><span>上拉加载...</span>
				</div>
			</div>
		</div>
		<!--<div class="more_machine">
			<a href="javascript:void(0)">查看更多设备</a>
		</div>-->
	</div>
	<form class="window_post hidden">
		<div>
			<img id="test00" src="img/saoyisao.png" alt="" />
			<label for="post_add">设备号：</label>
			<input type="text" id="post_add" placeholder="请输入设备号" /><br/>
			<input type="button" id="post_add_post" value="发送绑定请求" />
			<input type="button" id="post_add_esc" value="取消" />
		</div>
	</form>
	<form class="window_post hidden">
		<div>
			<label for="get_add">设备号：</label>
			<input type="text" id="get_add" readonly/><br/>
			<input type="button" id="get_add_post" value="发送解除绑定请求" />
			<input type="button" id="get_add_esc" value="取消" />
		</div>
	</form>

	<div class="footer" style="display: none;">
			<a  href="index.html">
				<img src="images/tab_weixin_normal.png" alt="" />
				<span>首页</span>
			</a>
			<a href="html/dingdan.php">
				<img src="images/tab_find_frd_normal.png" alt="" />
				<span>我的订单</span>
			</a>
			<a class="choosed" href="html/shebei_list.html">
				<img src="images/tab_address_pressed.png" alt="" />
				<span>设备信息</span>
			</a>
			<a href="html/user_sheZhi.html">
				<img src="images/tab_settings_normal.png" alt="" />
				<span>我的</span>
			</a>
		</div>
	<!--<div class="wait">
		数据加载中<span style="">……</span>
	</div>-->
	<script src="js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=jmgKloGf3cOvRl3Y9pUAfvKZCTtCNGwj" charset="utf-8"></script>
	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" charset="utf-8"></script>
	<script src="js/iscroll.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/machineList.js" charset="utf-8"></script>
	<script src="js/index.js" type="text/javascript" charset="utf-8"></script>
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
		$("#test00").on("click", function() {
			wx.scanQRCode({
				needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
				scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
				success: function(res) {
					var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果;
					$("#post_add").val(result.replace("CODE_128,", ""));
				}
			});
		});
		$(".back_list").on("click", function() {
			window.location.href = "index.html"
		})
	</script>
</body>

</html>