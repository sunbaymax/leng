$(document).ready(function() {
	window.alert = function(name) {
		var iframe = document.createElement("IFRAME");
		iframe.style.display = "none";
		iframe.setAttribute("src", 'data:text/plain,');
		document.documentElement.appendChild(iframe);
		window.frames[0].window.alert(name);
		iframe.parentNode.removeChild(iframe);
	}
	$(".back_list").on("click", function() {
		window.location.href = "user.html";
	});
	$(".back_list_user").on("click", function() {
		//window.location.href="../index.html";
		window.history.go(-1);
	});
	var userinfo = JSON.parse(localStorage.getItem('isonline'));
	var b = userinfo.user;
	var c = userinfo.pwd;
	$.ajax({
		url: "http://www.ccsc58.com/json/04_00_tb_admin_return.php",
		type: "post",
		data: {
			admin_permit: "zjly8888",
			UserP: "w",
			admin_user: b,
			admin_pass: c
		},
		success: function(a) {
			console.log(a)
			a =
				JSON.parse(a);
			$(".user_top div:nth-of-type(2)").html(a.resultCode.admin_user);
			$(".user_bottom ul li:nth-of-type(1) input").val(a.resultCode.admin_realname);
			$(".user_bottom ul li:nth-of-type(2) input").val(a.resultCode.admin_mobile == "" ? "未填写" : a.resultCode.admin_mobile);
			$(".user_bottom ul li:nth-of-type(3) input").val(c);
			$(".user_bottom ul li:nth-of-type(4) input").val(c);
			$(".user_bottom ul li:nth-of-type(5) input").val(a.resultCode.admin_mailbox == "" ? "未填写" : a.resultCode.admin_mailbox);
			$(".user_bottom ul li:nth-of-type(6) input").val(a.resultCode.admin_company == "" ? "未填写" : a.resultCode.admin_company);
			$(".user_bottom ul li:nth-of-type(7) input").val(a.resultCode.admin_company_address == "" ? "未填写" : a.resultCode.admin_company_address);
			$(".user_bottom ul li:nth-of-type(8) input").val(a.resultCode.admin_company_tel == "" ? "未填写" : a.resultCode.admin_company_tel);
		},
		error: function() {
			alert("\u7f51\u7edc\u9519\u8bef")
		}
	});
	//console.log($(".user_top div input"));
	$(".user_bottom form div").on("click", function() {
		$.ajax({
			url: "http://www.ccsc58.com/json/03_00_tb_admin.php",
			type: "post",
			data: {
				controller: "update",
				admin_permit: "zjly8888",
				UserP: "w",
				admin_user: $(".user_top div:nth-of-type(2)").html(),
				admin_realname: $(".user_bottom ul li:nth-of-type(1) input").val(),
				admin_mailbox: $(".user_bottom ul li:nth-of-type(5) input").val(),
				admin_pass: $(".user_bottom ul li:nth-of-type(4) input").val(),
				admin_oldpass: $(".user_bottom ul li:nth-of-type(3) input").val(),
				admin_mobile: $(".user_bottom ul li:nth-of-type(2) input").val(),
				admin_company: $(".user_bottom ul li:nth-of-type(6) input").val(),
				admin_company_address: $(".user_bottom ul li:nth-of-type(7) input").val(),
				admin_company_tel: $(".user_bottom ul li:nth-of-type(8) input").val()
			},
			success: function(a) {
				var b;
				var userinfo = JSON.parse(localStorage.getItem('isonline'));
				userinfo.pwd=$(".user_bottom ul li:nth-of-type(4) input").val();
				window.localStorage.setItem("isonline", JSON.stringify(userinfo))
//				window.localStorage.setItem("pass", $(".user_bottom ul li:nth-of-type(4) input").val());
				3E4 == JSON.parse(a).code ? alert("\u539f\u5bc6\u7801\u8f93\u5165\u9519\u8bef\uff0c\u8bf7\u91cd\u65b0\u8f93\u5165\u63d0\u4ea4") : (alert("\u7528\u6237\u4fe1\u606f\u4fee\u6539\u6210\u529f"), window.localStorage.setItem("pass", $(".user_bottom ul li:nth-of-type(4) input").val()), b = window.location.href, window.location.href = b)
			},
			error: function() {
				alert("\u8bf7\u68c0\u67e5\u60a8\u662f\u5426\u8fde\u63a5\u7f51\u7edc")
			}
		})
	});
	$(".user_top div:nth-of-type(1)").html('<img src="http://www.ccsc58.com/json/04_01_tb_admin_return_bmp.php?admin_user=' + b + '"/>')
});