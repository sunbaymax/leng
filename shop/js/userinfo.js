$(document).ready(function() {
	var _touxiang = window.sessionStorage.getItem("touxiang");
    var _user = window.sessionStorage.getItem("user");
    console.log(_user);
	var _openid = window.sessionStorage.getItem("openid");
	var _nicheng = window.sessionStorage.getItem("nicheng");
	$(".user_top div:nth-of-type(1)").css("background-image", "url(\""+_touxiang+"\")");
	$(".content .user_top .user").val(_user);
	$(".user_bottom ul li:nth-of-type(1) span:nth-of-type(2)").html(_nicheng);
	$(".user_bottom ul li:nth-of-type(2) span:nth-of-type(2)").html(_user==""?"未填写":_user);
	$(".user_bottom ul li:nth-of-type(3) span:nth-of-type(2)").html("未填写");
});