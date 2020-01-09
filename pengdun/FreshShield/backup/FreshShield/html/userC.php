<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="format-detection" content="telephone=no">
		<title>棚盾</title>
		<link rel="stylesheet" href="../css/index.css" />
		<link rel="stylesheet" href="../css/iconfont.css" />
	</head>
	<style>
		.content {
			margin: 4.6rem 0 5rem 0;
			padding: 0.4rem 1rem;
			box-sizing: border-box;
			font-size: 1.4rem;
		}
		
		.user_bottom ul {
			height: auto;
			padding: 0;
			margin: 0;
		}
		
		.user_bottom ul li {
			display: flex;
			justify-content: inherit;
			align-items: center;
			height: 4rem;
			background: #ffffff;
			border-bottom: 1px solid #F2F5F8;
			border-radius: 1rem;
			margin: 0.4rem 0 1rem;
		}
		
		li i {
			margin-left: 2vw;
			margin-right: 1.5rem;
			font-size: 1.6rem;
		}
		
		li input {
			width: 60%;
			height: 3rem;
			border: 1px solid #CCCCCC;
			padding-left: 1rem;
		}
		
		.btn {
			margin: 20rem 0 0;
			text-align: center;
		}
		
		button {
			width: 16rem;
			height: 4rem;
			line-height: 4rem;
			background: #40C0C3;
			border-radius: 5rem;
			border: none;
			color: #ffffff;
			font-size: 1.5rem;
		}
	</style>

	<body>

		<div class="header">
			<img class="back_list_user" src="../img/back.png" /> 个人中心
		</div>
		<div class="content">

			<div class="user_bottom">
				<ul>

					<li><i class="icon iconfont icon-shoujihaoma"></i><span>手机号码：</span><input type="text" readonly="readonly" class="tel" /></li>
					<li><i class="icon iconfont icon-mima"></i><span>原始密码：</span><input type="password" class="oldpsw" placeholder="修改密码请输入原密码" /></li>
				</ul>
				        <?php
//				        require_once "../../last8_28.php";
				        $_SERVER["QUERY_STRING"]; 
						parse_str("name=Bill&age=60");
						echo $name."<br>";
						echo $age;
						?>
				<!--<div class="btn">
					<button class="btn-ok">提交</button>
				</div>-->
			</div>
		</div>
		<script src="../js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
		<script>
			var userinfo = JSON.parse(localStorage.getItem('isonline'));
			var _userName = userinfo.user;
			var _userPass = userinfo.pwd;
			var utype = userinfo.userType;
			$(".tel").val(_userName);
			$(".oldpsw").val(_userPass);
			$(".back_list_user").on("click", function() {
				//window.location.href="../index.html";
				window.history.go(-1);
			});

			$(".btn-ok").on("click", function() {
				var _oldpsw = $(".oldpsw").val();
				var _newpsw = $(".newpsw").val();
				var _newpsw2 = $(".newpsw2").val();
				if(_oldpsw == '') {
					alert("原密码不能为空");
					return false;
				} else if(_newpsw == '') {
					alert("新密码不能为空");
					return false;
				} else if(_newpsw2 == '') {
					alert("确认密码不能为空");
					return false;
				} else if(_newpsw2 != _newpsw) {
					alert("两次密码输入不一致");
					return false;
				} else {
					$.ajax({
						type: "post",
						url: "http://www.zjcoldcloud.com/xiandun/public/index.php/index/register/update_pwd",
						async: true,
						data: {
							phone: _userName,
							old_pwd: _oldpsw,
							new_pwd: _newpsw
						},
						dataType: 'JSON',
						success: function(res) {
							console.log(res);
							if(res.code == 0 && res.message == 'success') {
								alert('修改成功');
								var userinfo = JSON.parse(localStorage.getItem('isonline'));
								userinfo.pwd = _newpsw;

								window.localStorage.setItem("isonline", JSON.stringify(userinfo))
								location.reload()
							} else {
								alert(res.message)
							}
						},
						error: function(err) {

						}
					});
				}

			})
		</script>
		<!--<script src="../js/change_user.js" type="text/javascript" charset="utf-8"></script>-->
	</body>

</html>