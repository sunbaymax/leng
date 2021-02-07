﻿jQuery(document).ready(function($) {
	myChang();

	function myChang() {
		$(".wait span").animate({
			width: "2rem"
		}, 1000, myDuan)
		$('body,html').animate({
			scrollTop: 0
		}, 0);
	};

	function myDuan() {
		$(".wait span").animate({
			width: "0rem"
		}, 10, myChang);
		$('body,html').animate({
			scrollTop: 0
		}, 0);
	};
	window.alert = function(name) {
		var iframe = document.createElement("IFRAME");
		iframe.style.display = "none";
		iframe.setAttribute("src", 'data:text/plain,');
		document.documentElement.appendChild(iframe);
		window.frames[0].window.alert(name);
		iframe.parentNode.removeChild(iframe);
	}

	window.confirm = function (message) {
            var iframe = document.createElement("IFRAME");
            iframe.style.display = "none";
            iframe.setAttribute("src", 'data:text/plain,');
            document.documentElement.appendChild(iframe);
            var alertFrame = window.frames[0];
            var result = alertFrame.window.confirm(message);
            iframe.parentNode.removeChild(iframe);
            return result;
    };
	$('input').blur(function() {
		$('body,html').animate({
			scrollTop: 0
		}, 0);
	})
    function onBridgeReady() {
            WeixinJSBridge.call('hideOptionMenu');
        }

        if (typeof WeixinJSBridge == "undefined") {
            if (document.addEventListener) {
                document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
            } else if (document.attachEvent) {
                document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
            }
        } else {
            onBridgeReady();
        }
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
	function getQueryVariable(variable)
	{
	       var query = window.location.search.substring(1);
	       var vars = query.split("&");
	       for (var i=0;i<vars.length;i++) {
	               var pair = vars[i].split("=");
	               if(pair[0] == variable){return pair[1];}
	       }
	       return(false);
	}
	if(_url.indexOf("?") != -1) {
		//_openId = _url.match(/\?openId=\S+/)[0].replace("?openId=", "");
		_openId=getQueryVariable("openId")
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
    $(".forgetpsd").on("click",function(){
    	location.href='banding.html?openId='+_openId
    	
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
		let _type=$('input:radio:checked').val();
		if(_userName == '') {
			myPlay("用户名不能为空！");
		} else if(_password == '') {
			myPlay("密码不能为空！");
		} else {
			myPlay("");
			$.ajax({
				url: "http://www.zjcoldcloud.com/xiandun/public/index.php/index/login/xiandunLogin",
				type: "post",
				data: {
					username: _userName,
					pwd: _password,
					weixin_openid: _openId,
					type:_type
				},
				dataType:'json',
				success: function(data) {
					//var _json = JSON.parse(data);
					let _json=data
                   console.log(data)
//                   return false;
					if(_json.code == 1) {
						myPlay("登录失败，请检查用户名及密码");
					} else {
						
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
								'suoshujigou':_json.data.content.suoshujigou
							}
							window.localStorage.setItem("isonline", JSON.stringify(xduser))
							if(_json.data.tag=='c'){
								window.location.href = "../machineList.php?_r="+parseInt(Math.random()*10) ;
							}else{
								window.location.replace("../main.html?_r="+parseInt(Math.random()*10)) ;
							}
							

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