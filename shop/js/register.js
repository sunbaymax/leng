	$("#login").click(function() {
			var _userName = $("#username").val();
			var _password = $("#password").val();
			var _openid = $("#openid").val();
			var _nicheng = $("#nicheng").val();
			var _touxiang = $("#touxiang").attr('src');
			
			window.sessionStorage.setItem("user", _userName);
			window.sessionStorage.setItem("openid", _openid);
			window.sessionStorage.setItem("nicheng",_nicheng);
			window.sessionStorage.setItem("touxiang",_touxiang);
			
			console.log("用户名"+_userName+",密码："+_password+"微信名："+_nicheng);
		$.ajax({
			url: "http://www.ccsc58.com/json/04_00_tb_admin_return.php",
			type: "post",
			data: {
				admin_permit: "zjly8888",
				UserP: "w",
				admin_user: _userName,
				admin_pass: _password
			},
			success: function(data) {
				var _json = JSON.parse(data);
				console.log(_json.code);
				if(_json.code == 30000) {
					alert("登录失败，请检查用户名及密码");
				} else {
					if(_json.resultCode.admin_user != "") {
						window.localStorage.setItem("user", _userName);
						window.localStorage.setItem("pass", _password);
						window.localStorage.setItem("openid", _openid);
						window.localStorage.setItem("nicheng",_nicheng);
						window.localStorage.setItem("touxiang",_touxiang);
						window.location.href = "shop.html";
					} else {
						alert("用户名不能为空");
					}
				};
			},
			error: function() {
				alert("请检查您是否连接网络")
			}
		});
	})
