jQuery(document).ready(function($) {
	if(window.localStorage.getItem("isonline")) {
		var userinfo = JSON.parse(localStorage.getItem('isonline'));
		if(userinfo.online == 1 && userinfo.user != '' && userinfo.pwd != '') {
			window.location.href = '../machineList.php?_r='+parseInt(Math.random()*10);
		}

	}
	setTimeout(function() {
		console.log('timeout');
		$(".qdy").hide();
		$(".content").removeClass('hide');
	}, 1000);
	//判断是否获取了用户的openID;
	var _openId = "";
	var _url = window.location.href;
	if(_url.indexOf("?") != -1) {
		_openId = _url.match(/\?openId=\S+/)[0].replace("?openId=", "");
		window.localStorage.setItem("openId", _openId);
	};

	getCookie();

	function setCookie() { //设置cookie 

		var loginCode = $("#signin-username").val(); //获取用户名信息    
		var pwd = $("#signin-password").val(); //获取登陆密码信息    
		//           var checked = $("input[name='checkbox']").prop("checked");//获取“是否记住密码”复选框  
		var checked = $("#check").attr("isuse") == '0' ? false : true;
		if(checked) { //判断是否选中了“记住密码”复选框    
			$.cookie("login_code", loginCode, {
				expires: 7 //设置时间，如果此处留空，则浏览器关闭此cookie就失效。
			}); //调用jquery.cookie.js中的方法设置cookie中的用户名    
			$.cookie("pwd", pwd, {
				expires: 7 //设置时间，如果此处留空，则浏览器关闭此cookie就失效。
			}); //调用jquery.cookie.js中的方法设置cookie中的登陆密码，并使用base64（jquery.base64.js）进行加密    
		} else {
			$.removeCookie('login_code');
			$.removeCookie('pwd');
		}
	}

	function getCookie() { //获取cookie    
		var loginCode = $.cookie("login_code"); //获取cookie中的用户名    
		var pwd = $.cookie("pwd"); //获取cookie中的登陆密码  

		if(loginCode != undefined && pwd != undefined) {
			$("#signin-username").val(loginCode);
			$("#signin-password").val(pwd);
			$("#check").attr("src", "../images/login_choose.png");
			$("#check").attr("isuse", "1");
		} else {
			$("#check").attr("src", "../images/login_nochoose.png");
			$("#check").attr("isuse", "0");
			$("#signin-username").val("");
			$("#signin-password").val("");
		}

	}
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
			$("#success_mao .success_box").show(500)
		}
	}

	$('#signin-username,#signin-password').bind('input propertychange', function() {
		if($(this).val().length>=1) {
			console.log("hhhhhhhh");
			$(this).next().show()
		} else {
			console.log("xxxxxxxx");
			$(this).next().hide()
		}
	});
    
    $(".deltext").on("click",function(){
    	$(this).hide().prev().val('');
    	
    })
	var togglewdj = true;
	$("#check").click(function() {
		if(togglewdj) {
			$(this).attr("src", "../images/login_choose.png");
			$(this).attr("isuse", "1");
			togglewdj = false;
		} else {
			$(this).attr("src", "../images/login_nochoose.png");
			$(this).attr("isuse", "0");
			togglewdj = true;
		}
	});

	/*
	 
	 * 登录页面函数；
	 * 
	 * 
	 * */
	$(".butok").on("click", function() {
		var _userName = $("#signin-username").val();
		var _password = $("#signin-password").val();
		if(_userName == '') {
			myPlay("用户名不能为空！");
		} else if(_password == '') {
			myPlay("密码不能为空！");
		} else {
			myPlay("");
			$.ajax({
				url: "http://www.zjcoldcloud.com/xiandun/public/index.php/index/login",
				type: "post",
				data: {
					username: _userName,
					pwd: _password,
					weixin_openid: _openId
				},
				success: function(data) {
					var _json = JSON.parse(data);

					if(_json.code == 1) {
						myPlay("登录失败，请检查用户名及密码");
					} else {
						console.log(data)

						if(_json.data.content.admin_user != '') {
							var xduser = {};
							xduser = {
								"user": _userName,
								"pwd": _password,
								"online": 1,
								"userType": _json.data.tag,
								"copenid": _json.data.content.openid,
								"duodian":_json.data.duodian==undefined?0:_json.data.duodian,
								"uid": _json.data.content.id,
							}

							window.localStorage.setItem("isonline", JSON.stringify(xduser))
							window.location.href = "../machineList.php?_r="+parseInt(Math.random()*10) ;

						}

					};
				},
				error: function() {
					myPlay("请检查您是否连接网络")
				}
			});
		}

	})
});