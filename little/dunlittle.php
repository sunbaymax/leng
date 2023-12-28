<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="yes" name="apple-touch-fullscreen">
    <script src="http://res.wx.qq.com/open/js/jweixin-1.6.0.js"></script> 
</head>
<div style="display:none">
	<?php
		require "../jssdk.php";
		$jssdk = new JSSDK("wx029d1989acb9f44c", "b7a482220530d3be2278429bdf2a7a63");
		$signPackage = $jssdk->GetSignPackage();
	?>
</div>
<body style="display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    width: 100%;">
	
	<wx-open-launch-weapp id="launch-btn" username="gh_af977c75039b" path="pages/index/index.html"> <!-- replace -->
	    <template>
	        <style>
	        	.container{
	        		width: 100%;
	        		height: 100%;
	        		display: flex;
	        		align-items: center;
	        		justify-content: center;
	        	}
	            .btn {
	                    margin: 60px auto;
                        display: block;
					    width: 180px;
					    height: 60px;
					    line-height: 60px;
					    border-radius: 4px;
					    font-size: 16px;
					    transition: background .3s;
                        background-color: #07c160;
                        color: #fff;
                        font-weight: 500;
	            }
	        </style>
	        <div class="container">
	        	<button class="btn">打开小程序</button>
	        </div>
	        
	    </template>
	</wx-open-launch-weapp>
	<script type="text/javascript">
		wx.config({    
			debug:false, // 是否开启调试模式
		  appId: '<?php echo $signPackage["appId"];?>',
			timestamp: '<?php echo $signPackage["timestamp"];?>',
			nonceStr: '<?php echo $signPackage["nonceStr"];?>',
			signature: '<?php echo $signPackage["signature"];?>',
			jsApiList:['openLocation'], // 必填，需要使用的JS接口列表
			openTagList: ['wx-open-launch-weapp'] // 可选，需要使用的开放标签列表，例如['wx-open-launch-app']
		}); 
		
		wx.ready(function () {
		  // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中
		});
		
		wx.error(function (res) {
		  // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名
		});
		
		var btn = document.getElementById('launch-btn');
	    btn.addEventListener('launch', function (e) {
	    	console.log('success');
	    });
	    btn.addEventListener('error', function (e) {
	    	console.log('fail', e.detail);
	    });
	</script>
</body>
</html>

