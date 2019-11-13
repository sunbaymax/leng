$(document).ready(function(){
		if(!window.localStorage.getItem("user")) {
			alert("请先绑定账号至您的微信号");
			window.location.href = "html/register.html"
		};
		var _userName = window.localStorage.getItem("user");
		var _userPass = window.localStorage.getItem("pass");
		$.ajax({
			url:"http://www.ccsc58.com/json/04_00_tb_admin_return.php",
			type:"post",
			data:{
				admin_permit:"zjly8888",
				UserP:"w",
				admin_user:_userName,
				admin_pass:_userPass
			},
			success:function(data){
				var _json=JSON.parse(data);
				//console.log(_json);
				$("#change_uesr_userName").val(_json.resultCode.admin_user);
				$("#change_uesr_real_name").val(_json.resultCode.admin_realname);
				$("#change_uesr_tel_number").val(_json.resultCode.admin_mobile);
				$("#change_uesr_email").val(_json.resultCode.admin_mailbox);
				$("#change_uesr_company_name").val(_json.resultCode.admin_company);
				$("#change_uesr_company_address").val(_json.resultCode.admin_company_address);
				$("#change_uesr_company_zuoji").val(_json.resultCode.admin_company_tel);
			},
			error:function(){
				myPlay("网络错误")
			}
		});
		$(".change_uesr_button input:nth-of-type(2)").on("click",function(){
			window.location.href="machineList.html";
		});
		$(".change_uesr_button input:nth-of-type(1)").on("click",function(){
			//if()
			$.ajax({
				url:"http://www.ccsc58.com/json/03_00_tb_admin.php",
				type:"post",
				data:{
					controller:"update",
					admin_permit:"zjly8888",
					UserP:"w",
					admin_user:$("#change_uesr_userName").val(),//用户名、、
					admin_realname:$("#change_uesr_real_name").val(),//用户真实姓名、、
					admin_mailbox:$("#change_uesr_email").val(),//用户邮箱
					admin_pass:$("#change_uesr_new_pass").val(),//用户新密码；、、
					admin_oldpass:$("#change_uesr_old_pass").val(),//用户原密码
					admin_mobile:$("#change_uesr_tel_number").val(),//用户手机号码；、、
					admin_company:$("#change_uesr_company_name").val(),//用户公司名称；、、
					admin_company_address:$("#change_uesr_company_address").val(),//公司地址；
					admin_company_tel:$("#change_uesr_company_zuoji").val()//公司电话；
				},
				success:function(data){
					var _json=JSON.parse(data);
					console.log(_json);
					if(_json.code==30000){
						alert("原密码输入错误，请重新输入提交")
					}else{
						alert("用户信息修改成功");
						window.localStorage.setItem("pass",$("#change_uesr_new_pass").val());
						var _url=window.location.href;
						window.location.href=_url;
					}
				},
				error:function(){
					myPlay("请检查您是否连接网络");
				}
			});
		});
})
