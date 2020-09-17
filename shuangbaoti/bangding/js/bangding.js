jQuery(document).ready(function($) {
	//判断是否获取了用户的openID;
	var _openId = "";
	var _url = window.location.href;
	if(_url.indexOf("?") != -1) {
		_openId = _url.match(/\?openId=\S+/)[0].replace("?openId=", "");
		//console.log(_openId);
	};
		//弹出框函数
	$("#success_mao .success_box form input").on("click", function() {
		$("#success_mao").css({
			display: "none"
		});
		$("#success_mao .success_box").css({
			display: "none"
		});
	})

	function myPlay(play) {
		if(play != "") {
			$("#success_mao .success_box .success_information").html(play);
			$("#success_mao").css({
				display: "block"
			});
			$("#success_mao .success_box").show(500);
		}
	}
		/*
		 
		 * 登录页面函数；
		 * 2016/9/5
		 * 毛人杰；
		 * */
	$(".cd-form input[type=button]").on("click", function() {
		var _userName = $("#signin-username").val();
		var _password = $("#signin-password").val();
		myPlay("");
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
				if(_json.code == 30000) {
					myPlay("账号或密码错误");
				} else {
					if(_json.resultCode.admin_user != "") {
						$.ajax({
							url: "http://www.ccsc58.com/json/11_00_tb_weixin_openID.php",
							type: "post",
							data: {
								admin_permit: "zjly8888",
								UserP: "w",
								admin_user: _userName,
								admin_pass: _password,
								controller: "update",
								openID: _openId,
								ip: ""
							},
							success: function(data) {
								var _json01 = JSON.parse(data);
								if(_json01.resultCode == "success") {
									window.localStorage.setItem("user", _userName);
									window.localStorage.setItem("pass", _password);
									window.location.href = "../index.html";
								} else {
									myPlay("绑定失败，请重新输入用户名及密码");
									window.location.href = _url;
								};
							},
							error: function() {
								myPlay("请检查您是否连接网络")
							}
						});
					} else {
						myPlay("用户名不能为空");
					}
				};
			},
			error: function() {
				myPlay("请检查您是否连接网络")
			}
		});
	})
});