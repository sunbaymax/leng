<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>农管家</title>
		<link rel="stylesheet" type="text/css" href="../css/index.css" />
		<link rel="stylesheet" type="text/css" href="../css/changeM.css" />
		<style type="text/css">
			.content {
				width: 100%;
				height: auto;
				margin-top: 4rem;
				padding: 0 1rem;
				box-sizing: border-box;
				font-size: 1.4rem;
			}

			.header .scan{
			    width: 2rem;
			    height: 1.8rem;
			    position: absolute;
			    top: 1.4rem;
			    right: 1.5rem;
							
			}
			.formdata {
				margin-top: 5rem;
				box-sizing: border-box;
			}
			
			.formdata div {
				height: 4rem;
				line-height: 4rem;
				margin-top: 1rem;
				border-radius: 1rem;
			}
			
			.formdata div input {
				height: 4rem;
				line-height: 4rem;
				width: 100%;
				padding: 0 2vw;
				box-sizing: border-box;
				border-radius: 1rem;
			}
			
			.formdata .last {
				margin-top: 20rem;
				width: 100%;
				text-align: center;
			}
			
			.last button {
				width: 16rem;
				height: 4rem;
				background: #40C0C3;
				border-radius: 5rem;
				border: none;
				color: #ffffff;
				font-size: 1.5rem;
			}
			.hide{
				display: none;
			}
		</style>
	</head>

	<body>
	    <div style="display:none">
			<?php
				require_once "../jssdk.php";
				$jssdk = new JSSDK("wx029d1989acb9f44c", "b7a482220530d3be2278429bdf2a7a63");
				$signPackage = $jssdk->GetSignPackage();
			?>
		</div>
		<div class="header">
			<img class="back_list" src="../img/back.png" /> 添加设备 <img src="../images/scanner.png" class="scan hide" id="test00"/>
		</div>
		<div class="content">
			<div class="formdata">
				<div>
					<input type='number' class="deviceval" id="post_add" placeholder="请输入设备编号" />
				</div>
				
				<div class="last">
					<button class="btn-ok" id="post_add_post">提交</button>
				</div>
			</div>
		</div>

		<script src="../js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
		<script src="../js/index.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" charset="utf-8"></script>
		<script type="text/javascript">
			wx.config({
			debug: false,
			appId: '<?php echo $signPackage["appId"];?>',
			timestamp: '<?php echo $signPackage["timestamp"];?>',
			nonceStr: '<?php echo $signPackage["nonceStr"];?>',
			signature: '<?php echo $signPackage["signature"];?>',
			jsApiList: [
				'chooseImage',
				'scanQRCode'
			]
			});
			$("#test00").on("click", function() {
				wx.scanQRCode({
					needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
					scanType: ["scanQRCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
					success: function(res) {
						var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果;
							 if(result.includes(',')){
		                      result = result.split(',')[1];        
		                     }
							$("#post_add").val(result);
						
					}
				});
			});
			
		$("#post_add_post").on("click", function() {
			var _num = $("#post_add").val().replace(/\s*/g, "");
			if(_num == "") {
				alert("请输入设备号");
				return false;
			} else {
				var userinfo = JSON.parse(localStorage.getItem('isonline'));
			    var _userName = userinfo.user;
			    var _userPass = userinfo.pwd;
				var utype = userinfo.userType;
				if(utype == 'b') {
				///上传设备号和用户名；
			    $.ajax({
				type: "post",
				url: "http://www.ccsc58.com/json/07_00_tb_device_bangding.php",
				data: {
					admin_permit: "zjly8888",
					UserP: "w",
					admin_user: _userName,
					admin_pass: _userPass,
					shebeibianhao: _num
				},
				dataType:'json',
				success: function(data) {
					let _json=data
					//var _json = JSON.parse(data);
					if(_json.resultCode == "success") {
						alert("设备绑定成功，重新进入页面即可看到新绑定的设备");
//						window.location.href = '../machineList.php';
						window.location.reload()
					} else {
						alert(_json.message)
					}
				}
			});
				}else{
					$.ajax({
						type: "post",
//						url: "http://erpapi.ccsc58.com/xiandun/public/index.php/index/Device/bind_device",
						url: "https://erpapi.ccsc58.com/xiandun/public/index.php/index/device/xiandun_bind_device",
						data: {
							mainname: _userName,
							devicenumber: _num,
							bandType:''
						},
						dataType:'json',
						success: function(data) {
							let _json=data
							//var _json = JSON.parse(data);
							if(_json.code == 0) {
								alert("设备绑定成功，重新返回主页面即可看到新绑定的设备");
//								window.location.href = '../machineList.php';
                                window.location.reload()
							} else {
								alert(_json.message)
							}
						}
					});
				}

		}
	});
			$(".back_list").on("click", function() {
				location.href='../machineList.php'
			});

		</script>
	</body>

</html>