jQuery(document).ready(function($) {
	//注册和登录页面的切换效果
	$(".cd-switcher li").on("click", function() {
			$(".cd-switcher li a").removeClass("selected")
			$(this).find("a").addClass("selected");
			if($(this).index() == 0) {
				$("#cd-login").removeClass("hidden");
				$("#cd-signup").addClass("hidden");
			} else if($(this).index() == 1) {
				$("#cd-login").addClass("hidden");
				$("#cd-signup").removeClass("hidden");
			}
		})
		//注册页面函数；
		//注册成功后的提示框函数；
	$("#success_register .success_box form input:nth-of-type(1)").on("click", function() {
		$("#success_register").css({
			display: "none"
		})
		var _url = window.location.href;
		window.location.href = _url;
	})
	$("#success_register .success_box form input:nth-of-type(2)").on("click", function() {
			$("#success_register").css({
				display: "none"
			})
		})
		//弹出框函数
	$("#success_mao .success_box form input").on("click", function() {
		$("#success_mao").css({
			display: "none"
		});
	})

	function myPlay(play) {
		if(play != "") {
			$("#success_mao .success_box .success_information").html(play);
			$("#success_mao").css({
				display: "block"
			});
		}
	}
	//注册时判断两次输入密码是否相同；
	var _x = 0;
	$("#signup-password02").on("blur", function() {
		var _admin_pass = $("#signup-password01").val(); //用户密码1；、、
		var _admin_pass02 = $("#signup-password02").val(); //用户密码2；、、
		if(_admin_pass02 == "") {
			$(".register_prompt_signup-password02").html("再次输入密码不能为空");
			$(".register_prompt_signup-password02").css({
				color: "red"
			});
			_x = 1
		} else if(_admin_pass02 != _admin_pass) {
			$(".register_prompt_signup-password02").html("请两次输入相同的密码");
			$(".register_prompt_signup-password02").css({
				color: "red"
			})
			_x = 1
		} else {
			$(".register_prompt_signup-password02").html("√");
			$(".register_prompt_signup-password02").css({
				color: "blue",
				fontWeight: "blod"
			})
			_x = 0;
		}
	});
	//注册时判断用户名是否符合要求；
	$("#signup-username").on("blur", function() {
		var _userName = $("#signup-username").val();
		if($(this).val() == "") {
			$(".register_prompt_signup-username").html("用户名不能为空！！！");
			$(".register_prompt_signup-username").css({
				color: "red"
			})
			_x = 1
		} else if(!/[a-zA-z0-9]{6,20}/.test($(this).val())) {
			$(".register_prompt_signup-username").html("请输入6-20位字母数字组合作为用户名！！！");
			$(".register_prompt_signup-username").css({
				color: "red"
			})
			_x = 1
		} else {
			$(".register_prompt_signup-username").html("√");
			$(".register_prompt_signup-username").css({
				color: "blue",
				fontWeight: "blod"
			})
			_x = 0;
		}
	});
	//注册时判断密码是否符合要求；
	$("#signup-password01").on("blur", function() {
		if($(this).val() == "") {
			$(".register_prompt_signup-password01").html("密码项不能为空");
			$(".register_prompt_signup-password01").css({
				color: "red"
			})
			_x = 1
		} else if(!/[a-zA-z0-9]{6,12}/.test($(this).val())) {
			$(".register_prompt_signup-password01").html("请输入6-12位字母数字组合作为密码");
			$(".register_prompt_signup-password01").css({
				color: "red"
			})
			_x = 1
		} else {
			$(".register_prompt_signup-password01").html("√");
			$(".register_prompt_signup-password01").css({
				color: "blue",
				fontWeight: "blod"
			})
			_x = 0;
		}
	});
	//注册时判断手机号码是否符合要求；
	$("#signup-userTel").on("blur", function() {
		if($(this).val() == "") {
			$(".register_prompt_signup-userTel").html("手机号码不能为空");
			$(".register_prompt_signup-userTel").css({
				color: "red"
			})
			_x = 1
		} else if(!/^1\d{10}$/.test($(this).val())) {
			$(".register_prompt_signup-userTel").html("请输入正确格式的手机号码！");
			$(".register_prompt_signup-userTel").css({
				color: "red"
			})
			_x = 1
		} else {
			$(".register_prompt_signup-userTel").html("√");
			$(".register_prompt_signup-userTel").css({
				color: "blue",
				fontWeight: "blod"
			})
			_x = 0;
		}
	});
	//注册时判断邮箱是否符合要求;
	$("#signup-userEmail").on("blur", function() {
		if($(this).val() == "") {
			$(".register_prompt_signup-userEmail").html("邮箱地址不能为空");
			$(".register_prompt_signup-userEmail").css({
				color: "red"
			})
			_x = 1
		} else if(!/^([a-zA-Z0-9\_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())) {
			$(".register_prompt_signup-userEmail").html("请输入正确格式的邮箱地址");
			$(".register_prompt_signup-userEmail").css({
				color: "red"
			})
			_x = 1
		} else {
			$(".register_prompt_signup-userEmail").html("√");
			$(".register_prompt_signup-userEmail").css({
				color: "blue"
			})
			_x = 0;
		}
	})
	$("#cd-signup input[type=button]").on("click", function() {
			if(!$("#accept-terms")[0].checked) {
				myPlay("请仔细阅读用户使用协议");
			} else {
				var _admin_user = $("#signup-username").val(); //用户名、、
				var _admin_realname = $("#signup-realname").val(); //用户真实姓名、、
				var _admin_mailbox = $("#signup-userEmail").val(); //用户邮箱
				var _admin_pass = $("#signup-password01").val(); //用户密码1；、、
				var _admin_pass02 = $("#signup-password02").val(); //用户密码2；、、
				var _admin_mobile = $("#signup-userTel").val(); //用户手机号码；、、
				var _admin_company = $("#signup-userCom").val(); //用户公司名称；、、
				var _admin_company_address = $("#signup-userAddress").val(); //公司地址；
				var _admin_company_tel = $("#signup-userComTel").val(); //公司电话；
				if(_admin_user == "" || _admin_realname == "" || _admin_mailbox == "" || _admin_pass == "" || _admin_pass02 == "" || _admin_mobile == "" || _admin_company == "") {
					myPlay("提示必填项目不能为空");
					return
				};
				if(_x == 1) {
					myPlay("请按照网页中提示填写注册内容");
					return;
				};
				$.ajax({
					url: "http://www.ccsc58.com/json/03_00_tb_admin.php",
					type: "post",
					data: {
						controller: "register",
						admin_permit: "zjly8888",
						UserP: "w",
						admin_user: _admin_user, //用户名、、
						admin_realname: _admin_realname, //用户真实姓名、、
						admin_mailbox: _admin_mailbox, //用户邮箱
						admin_pass: _admin_pass, //用户密码；、、
						admin_mobile: _admin_mobile, //用户手机号码；、、
						admin_company: _admin_company, //用户公司名称；、、
						admin_company_address: _admin_company_address, //公司地址；
						admin_company_tel: _admin_company_tel //公司电话；
					},
					success: function(data) {
						var _json =JSON.parse(data);
						if(_json.code == "10000") {
							$("#success_register").css({
								display: "block"
							})
						};
						if(_json.resultCode == "samename") {
							myPlay("该用户名已被使用，请重新输入用户名");
						};
					},
					error: function() {
						myPlay("请检查您是否连接网络");
					}
				});
			}
		})
		/*
		 
		 * 登录页面函数；
		 * 2016/9/5
		 * 毛人杰；
		 * */
	$("#cd-login input[type=button]").on("click", function() {
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
					myPlay("登录失败，请检查用户名及密码");
				} else {
					if(_json.resultCode.admin_user != "") {
						window.localStorage.setItem("user", _json.resultCode.admin_user);
						window.localStorage.setItem("pass", _password);
						window.location.href = "../machineList.html";
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