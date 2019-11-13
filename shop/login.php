<div style="display:none">
<?php
	require_once('weixin.class.php');
	$weixin = new class_weixin();
	if (!isset($_GET["code"])){
	  $redirect_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	  $jumpurl = $weixin->oauth2_authorize($redirect_url, "snsapi_userinfo", "123");
	  Header("Location: $jumpurl");
	}else{
	  $access_token_oauth2 = $weixin->oauth2_access_token($_GET["code"]);
	  $userinfo = $weixin->oauth2_get_user_info($access_token_oauth2['access_token'], $access_token_oauth2['openid']); 
	}
?>
</div>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>智冷科技微商城登录</title>
<link rel="stylesheet" type="text/css" href="css/normalize.css" />
<link rel="stylesheet" type="text/css" href="css/demo.css" />
<!--必要样式-->
<link rel="stylesheet" type="text/css" href="css/component.css" />
<!--[if IE]>
<script src="js/html5.js"></script>
<![endif]-->
</head>
<body>
		<div class="container demo-1">
			<div class="content">
				<div id="large-header" class="large-header">
					<canvas id="demo-canvas"></canvas>
					<div class="logo_box">
						<h3>会员登录</h3>
						<form>
							<div class="input_outer">
								<span class="u_user"></span>
								<input name="logname" class="text" id="username" style="color: #FFFFFF !important" type="text" placeholder="请输入账户">
							</div>
							<div class="input_outer">
								<span class="us_uer"></span>
								<input name="logpass" class="text" id="password" style="color: #FFFFFF !important; position:absolute; z-index:100;"value="" type="password" placeholder="请输入密码">
							</div>
							<div class="mb2"><a class="act-but submit" id="login" href="javascript:;" style="color: #FFFFFF">登录</a></div>
							<p class="zhuce">新用户?<a href="http://www.ccsc58.cc/IceKnight/html/register_Basicinfo.html" style="color: #C1C1C1;">注册</a> </p>
						</form>
					</div>
				</div>
			</div>
		</div><!-- /container -->
		<div style="display:none">
			<label for="openid">openid：</label><br><input type="text" id="openid" name="openid" value="<?php echo $userinfo["openid"];?>" readonly="true"/>
		    <label for="nicheng">微信名：</label><br><input type="text" id="nicheng" name="nicheng" value="<?php echo $userinfo["nickname"];?>" readonly="true"/>
			<label for="touxiang">头像：</label><br><img id="touxiang" src="<?php echo str_replace("/0","/46",$userinfo["headimgurl"]);?> " style="margin-left: 10%;width: 4rem;height: 4rem;padding: 0;">
		</div>
		<script src="js/jquery-1.11.0.js"></script>
		<script src="js/TweenLite.min.js"></script>
		<script src="js/EasePack.min.js"></script>
		<script src="js/rAF.js"></script>
		<script src="js/demo-1.js"></script>
		<script src="js/register.js"></script>
	</body>
</html>