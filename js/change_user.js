$(document).ready(function() {
	$(".back_list").on("click",function(){
		window.location.href="user.html";
	});
	$(".back_list_user").on("click",function(){
		//window.location.href="../index.html";
		window.history.go(-1);
	});
	var b = window.localStorage.getItem("user"),
		c = window.localStorage.getItem("pass");
	$(".user_bottom form input").on("click", function() {
		confirm("\u786e\u5b9a\u6ce8\u9500\u767b\u5f55\u5417\uff1f") && (console.log(b), console.log(c), $.ajax({
			url: "http://www.ccsc58.com/json/11_00_tb_weixin_openID.php",
			type: "post",
			data: {
				admin_permit: "zjly8888",
				UserP: "w",
				admin_user: b,
				admin_pass: c,
				controller: "update",
				openID: "0000000000000000000000000000",
				ip: ""
			},
			success: function(a) {
				a = JSON.parse(a);
				console.log(a);
				"success" == a.resultCode ? (window.localStorage.removeItem("user"), window.localStorage.removeItem("pass"), window.localStorage.removeItem("warning"),WeixinJSBridge.call("closeWindow")) : (alert("\u89e3\u9664\u7ed1\u5b9a\u5931\u8d25\uff0c\u8bf7\u91cd\u65b0\u64cd\u4f5c"), window.location.href = _url)
			},
			error: function() {
				console.log("\u8bf7\u68c0\u67e5\u60a8\u662f\u5426\u8fde\u63a5\u7f51\u7edc")
			}
		}))
	});
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
			a =
				JSON.parse(a);
			$("#change_uesr_userName").val(a.resultCode.admin_user);
			$("#change_uesr_old_pass").val(c);
			$("#change_uesr_new_pass").val(c);
			$("#change_uesr_real_name").val(a.resultCode.admin_realname);
			//$("#change_uesr_tel_number").val(a.resultCode.admin_mobile);
			panDuan($("#change_uesr_tel_number"),a.resultCode.admin_mobile,"请完善手机号码");//手机号码；
			//$("#change_uesr_email").val(a.resultCode.admin_mailbox);
			panDuan($("#change_uesr_email"),a.resultCode.admin_mailbox,"请完善邮箱地址");//邮箱地址；
			//$("#change_uesr_company_name").val(a.resultCode.admin_company);
			panDuan($("#change_uesr_company_name"),a.resultCode.admin_company,"请完善公司名称");//公司名称；
			//$("#change_uesr_company_address").val(a.resultCode.admin_company_address);
			panDuan($("#change_uesr_company_address"),a.resultCode.admin_company_address,"请完善公司地址");//公司地址；
			//$("#change_uesr_company_zuoji").val(a.resultCode.admin_company_tel);
			panDuan($("#change_uesr_company_zuoji"),a.resultCode.admin_company_tel,"请完善公司座机号码");//公司座机；
			$(".user_top div:nth-of-type(2) input").val(a.resultCode.admin_user);
			$(".user_bottom ul li:nth-of-type(1) span:nth-of-type(2)").html(a.resultCode.admin_realname);
			$(".user_bottom ul li:nth-of-type(2) span:nth-of-type(2)").html(a.resultCode.admin_mobile==""?"未填写":a.resultCode.admin_mobile);
			$(".user_bottom ul li:nth-of-type(3) span:nth-of-type(2)").html(a.resultCode.admin_mailbox==""?"未填写":a.resultCode.admin_mailbox);
			$(".user_bottom ul li:nth-of-type(4) span:nth-of-type(2)").html(a.resultCode.admin_company==""?"未填写":a.resultCode.admin_company);
			$(".user_bottom ul li:nth-of-type(5) span:nth-of-type(2)").html(a.resultCode.admin_company_address==""?"未填写":a.resultCode.admin_company_address);
			$(".user_bottom ul li:nth-of-type(6) span:nth-of-type(2)").html(a.resultCode.admin_company_tel==""?"未填写":a.resultCode.admin_company_tel);
			function panDuan(dem,xiangMu,neirong){
				if(xiangMu==""){
					dem.attr("placeholder",neirong);
				}else{
					dem.val(xiangMu);
				}
			}
		},
		error: function() {
			myPlay("\u7f51\u7edc\u9519\u8bef")
		}
	});
	$(".change_uesr_button input:nth-of-type(1)").on("click", function() {
		$.ajax({
			url: "http://www.ccsc58.com/json/03_00_tb_admin.php",
			type: "post",
			data: {
				controller: "update",
				admin_permit: "zjly8888",
				UserP: "w",
				admin_user: $("#change_uesr_userName").val(),
				admin_realname: $("#change_uesr_real_name").val(),
				admin_mailbox: $("#change_uesr_email").val(),
				admin_pass: $("#change_uesr_new_pass").val(),
				admin_oldpass: $("#change_uesr_old_pass").val(),
				admin_mobile: $("#change_uesr_tel_number").val(),
				admin_company: $("#change_uesr_company_name").val(),
				admin_company_address: $("#change_uesr_company_address").val(),
				admin_company_tel: $("#change_uesr_company_zuoji").val()
			},
			success: function(a) {
				var b;
				3E4 == JSON.parse(a).code ? alert("\u539f\u5bc6\u7801\u8f93\u5165\u9519\u8bef\uff0c\u8bf7\u91cd\u65b0\u8f93\u5165\u63d0\u4ea4") : (alert("\u7528\u6237\u4fe1\u606f\u4fee\u6539\u6210\u529f"), window.localStorage.setItem("pass", $("#change_uesr_new_pass").val()), b = window.location.href, window.location.href = b)
			},
			error: function() {
				myPlay("\u8bf7\u68c0\u67e5\u60a8\u662f\u5426\u8fde\u63a5\u7f51\u7edc")
			}
		})
	});
	$(".user_top div:nth-of-type(1)").html('<img src="http://www.ccsc58.com/json/04_01_tb_admin_return_bmp.php?admin_user=' + b + '"/>')
});