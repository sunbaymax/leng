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
		<img class="top" src="http://www.ccsc58.cc/leng/img/zhanhui.jpg" alt="" />
		 <!--<div class="container js_container">
            <div class="page cell">
                <div class="hd">
                    <h1 class="page_title">我的信息</h1>
                    <p class="page_desc"><a style="font-size: 14px;color:#0F0F0F;font-weight: bold; " href="../bangding/bangding.html?openId=<?php echo $userinfo['openid'];?>">绑定手机</a></p>
                </div>
                <div class="bd">
                    <div class="weui_cells_title">个人信息</div>
                    <div class="weui_cells">
                        <div class="weui_cell">
                            <div class="weui_cell_bd weui_cell_primary">
                                <p>OpenID</p>
                            </div>
                            <div class="weui_cell_ft"><?php echo $userinfo["openid"];?></div>
                        </div>
                       <div class="weui_cell">
                            <div class="weui_cell_bd weui_cell_primary">
                                <p>昵称</p>
                            </div>
                            <div class="weui_cell_ft"><?php echo $userinfo["nickname"];?></div>
                        </div>
                        <div class="weui_cell ">
                            <div class="weui_cell_bd weui_cell_primary">
                                <p>头像</p>
                            </div>
                            <div class="weui_cell_ft"><img src="<?php echo str_replace("/0","/46",$userinfo["headimgurl"]);?>"></div>
                        </div>
                        <div class="weui_cell">
                            <div class="weui_cell_bd weui_cell_primary">
                                <p>性别</p>
                            </div>
                            <div class="weui_cell_ft"><?php echo (($userinfo["sex"] == 0)?"未知":(($userinfo["sex"] == 1)?"男":"女"));?></div>
                        </div>
                        <div class="weui_cell">
                            <div class="weui_cell_bd weui_cell_primary">
                                <p>地区</p>
                            </div>
                            <div class="weui_cell_ft"><?php echo $userinfo["country"];?> <?php echo $userinfo["province"];?> <?php echo $userinfo["city"];?></div>
                        </div>
                        <div class="weui_cell">
                            <div class="weui_cell_bd weui_cell_primary">
                                <p>语言</p>
                            </div>
                            <div class="weui_cell_ft"><?php echo $userinfo["language"];?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
		<form>
			<label for="name">昵称：</label><br><input type="text" id="nicheng" value="<?php echo $userinfo["nickname"];?>" readonly="true"/>
			<p></p>
			<label for="name">头像：</label><br><img src="<?php echo str_replace("/0","/46",$userinfo["headimgurl"]);?> " style="margin-left: 10%;width: 4rem;height: 4rem;padding: 0;">
			<p style="height: 1rem;"></p>
			<label for="name">姓名：</label><br><input type="text" id="name" value="" placeholder="请输入真实姓名，以便工作人员核实" />
			<p>请输入真实姓名，以便工作人员核实</p>
			<label for="tel">电话：</label><br><input type="text" id="tel" value="" placeholder="请输入真实手机号码，以便工作人员核实" />
			<p>请输入真实手机号码，以便工作人员核实</p>
			<label for="company">公司：</label><br><input type="text" id="company" value="" placeholder="请输入真实公司名称，以便工作人员核实" />
			<p>请输入真实公司名称，以便工作人员核实</p>
			<div class="button">开始签到</div>
		</form>
		<p style="text-align: center;font-size: 1.2rem;margin-top: 20px;">
			感谢参与，年会愉快！<img src="images/smile.png" style="display:inline-block;width:2rem ;height:2rem ;line-height: 2rem;" /></br>技术支持：中集冷云（北京）冷链科技有限公司
		</p>
		<script src="../js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			$(".button").on("click", function() {
				//11号10：00-10:30
				var _startTime01 = new Date("2018/1/12 08:00:00");
				var _endTime01 = new Date("2018/1/12 22:00:00");
				//19号10：00-10:30
				var _startTime02 = new Date("2018/1/19 08:00:00");
				var _endTime02 = new Date("2017/1/19 22:00:00");

				//20号10:00-10:30
				var _startTime03 = new Date("2018/1/20 08:00:00");
				var _endTime03 = new Date("2018/1/20 22:00:00");

				var _first_set = window.localStorage.getItem("chouJiang01");
				var _twice_set = new Date();
				var _JianGe_time = _twice_set.getTime() - _first_set;
				var _now_time = _twice_set.getTime();
				//document.write(_startTime01.getTime() + "<br>" + _endTime01.getTime() + "<br>" + _startTime02.getTime() + "<br>" + _endTime02.getTime() + "<br>" + _startTime03.getTime() + "<br>" + _endTime03.getTime() + "<br>" + _now_time)
				if((_now_time > _startTime01.getTime() && _now_time < _endTime01.getTime()) || (_now_time > _startTime02.getTime() && _now_time < _endTime02.getTime()) || (_now_time > _startTime03.getTime() && _now_time < _endTime03.getTime())) {
					if((_JianGe_time / (1000 * 60 * 60 * 24)) > 10) {
						var _name = $("#name").val();
						var _tel = $("#tel").val();
						var _company = $("#company").val();
						if(_name == "") {
							$("form p:nth-of-type(1)").html("请输入您的姓名").css({
								color: "red"
							});
						} else if(_tel == "") {
							$("form p:nth-of-type(2)").html("请输入您的手机号码").css({
								color: "red"
							});;
						} else if(_company == "") {
							$("form p:nth-of-type(3)").html("请输入您的公司名称").css({
								color: "red"
							});;
						} else if(_tel.length!=11){
							$("form p:nth-of-type(2)").html("请输入有效的11位手机号码").css({
								color: "red"
							});;
						}else {
							$("p").html("").css({
								color: "#c1c1c1"
							});
							window.sessionStorage.setItem("name", _name);
							window.sessionStorage.setItem("tel", _tel);
							window.sessionStorage.setItem("company", _company);
							window.location.href = "qiandao_ok.html";
						}
					} else {
						alert("感谢你的参与，请于工作人员联系");
					}
				} else {
					alert("此时不是签到时间，谢谢您的参与！")
				}

			});
		</script>
	</body>

</html>