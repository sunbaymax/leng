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
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>中集冷云（北京）冷链科技有限公司</title>
		<link rel="stylesheet" type="text/css" href="../css/index.css" />
		  <link rel="stylesheet" href="css/weui.min.css">
        <link rel="stylesheet" href="css/example.css">
		<style type="text/css">
			form {
				width: 100%;
				line-height: 3rem;
				font-size: 1.5rem;
			}
			
			label {
				display: inline-block;
				width: 20%;
				height: 2rem;
				line-height: 2rem;
				text-align: left;
				margin-left: 10%;
				font-weight: bold;
			}
			
			input {
				width: 80%;
				height: 3rem;
				border: none;
				border-bottom: 1px solid #ccc;
				outline: none;
				line-height: 3rem;
				margin-left: 10%;
				font-size: 1.5rem;
			}
			
			.top {
				width: 100%;
				height: 18rem;
			}
			
			.button {
				width: 80%;
				height: 3rem;
				line-height: 3rem;
				text-align: center;
				margin-left: 10%;
				margin-top: 2rem;
				background: #0A1A39;
				color: #fefefe;
				border: none;
				font-weight: bold;
				font-size: 2rem;
				letter-spacing: 2px;
			}
			
			p {
				width: 80%;
				margin-left: 10%;
				height: 2rem;
				line-height: 2rem;
				color: #C1C1C1;
				font-size: 1rem;
			}
		</style>
	</head>

	<body>
		<img class="top" src="images/kaijiang.gif" alt="" />
		<form>
			<div style="display:none">
			<label for="openid">openid：</label><br><input type="text" id="openid" name="openid" value="<?php echo $userinfo["openid"];?>" readonly="true"/>
			
			<label for="nicheng">微信名：</label><br><input type="text" id="nicheng" name="nicheng" value="<?php echo $userinfo["nickname"];?>" readonly="true"/>
			<p></p>
			<label for="touxiang">头像：</label><br><img id="touxiang" src="<?php echo str_replace("/0","/46",$userinfo["headimgurl"]);?> " style="margin-left: 10%;width: 4rem;height: 4rem;padding: 0;">
			<p style="height: 1rem;border-top: 1px solid #ccc;"></p>
			</div>
			
			<label for="name" style="margin-top: 5px;">姓名：</label><br><input type="text" id="name" value="" placeholder="请输入真实姓名，以便工作人员核实" />
			<p>请输入真实姓名，以便工作人员核实</p>
			<label for="tel">电话：</label><br><input type="text" id="tel" value="" placeholder="请输入真实手机号码，以便工作人员核实" />
			<p>请输入真实手机号码，以便工作人员核实</p>
			<!--<label for="company">公司：</label><br><input type="text" id="company" value="" placeholder="请输入真实公司名称，以便工作人员核实" />-->
			<label for="company">公司：</label><br><input type="text" id="company" value="" placeholder="请输入真实公司名称，以便我们邮寄奖品" />
			<!--<select name="company" id="company" style="width: 50%;height:3rem; font-family: '楷体';font-size: 1.5rem; margin-left: 10%;margin-top: 1rem;">
				<option value="0" class="s1">请选择公司名称</option> 
				<option value="北京中集">北京中集</option>
				<option value="中集冷云">中集冷云</option> 
				<option value="冷云科技">冷云科技</option> 
				<option value="成都公司">成都公司</option> 
				<option value="杭州公司">杭州公司</option>  
     </select> -->
     <!--<s style="display:inline-block;width: 80%;height: 1px;margin-top:3px;margin-left: 10%; border-bottom: 1px solid #ccc;"></s>-->
			<p>请选择真实公司名称，以便工作人员核实</p>
			<div class="button">开始签到</div>
		</form>
		<p style="text-align: center;font-size: 1.2rem;margin-top: 20px;">
			感谢体验，幸运大转盘抽奖！<img src="images/smile.png" style="display:inline-block;width:2rem ;height:2rem ;line-height: 2rem;" /></br>技术支持：冷云科技 售后热线：18519773728
		</p>
		<script src="../zhuanPans/js/jquery-1.10.2.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
//			$("#company").on("click", function() {
//				$(".s1").hide();
//				$(".s1").css("display", "none"); 
//			});
			$(".button").on("click", function() {
				
				var _openid = $("#openid").val();
				var _nicheng = $("#nicheng").val();
				var _touxiang = $("#touxiang").attr('src');
				var _name = $("#name").val();
				var _tel = $("#tel").val();
				var _company = $("#company").val();
				window.sessionStorage.setItem("name", _name);
				window.sessionStorage.setItem("tel", _tel);
				window.sessionStorage.setItem("company", _company);
				window.sessionStorage.setItem("openid", _openid);
				window.sessionStorage.setItem("touxiang", _touxiang);
				window.sessionStorage.setItem("nicheng", _nicheng);
				//alert(_openid);
		    if(_name == "") {
					$("form p:nth-of-type(3)").html("请输入您的姓名").css({
						color: "red"
					});
				} else if(_tel == "") {
					$("form p:nth-of-type(4)").html("请输入您的手机号码").css({
						color: "red"
					});
				} else if(_company == "") {
					$("form p:nth-of-type(5)").html("请选择您的公司名称").css({
						color: "red"
					});
				} else if(_tel.length!=11){
					$("form p:nth-of-type(4)").html("请输入有效的11位手机号码").css({
						color: "red"
					});
				}
				else{
						$.ajax({
								type: "post",
								url: "http://www.ccsc58.com/get_userinfo.php",
								dataType:"json",
								data: {
									admin_permit:"zjly8888",
									openid: _openid,
									nicheng: _nicheng,
									touxiang: _touxiang,
									name: _name,
									tel:_tel,
									company:_company
								},
								success: function(data) {
									console.log(data);
									if(data.code == "10000" && data.message == "sucess" && data.resultCode=="Ok" ) {
											window.location.href = "index.html";										
									}
									else if(data.code == "20000"){
									 		alert("已经签到过！")
									 }
									else if(data.code == "30000"){
										alert("签到失败，已经签到过！");
									}else{
										alert("非法签到，请于工作人员联系！");
									}
								},
								error: function() {
									alert("网络错误");
									window.location.href = window.location.href;
								}
							});
						}
				});

		</script>
	</body>

</html>