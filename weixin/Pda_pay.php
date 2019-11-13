<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>中集冷云PDA支付平台</title>
		<link rel="stylesheet" href="css/index.css" />
		<style type="text/css">
			.img_logo {
				width: 100%;
			}
			
			.img_logo img {
				width: 100%;
			}
			
			form {
				margin-top: 5px;
				margin-bottom: 5rem;
			}
			
			form div {
				width: 100%;
				height: 4rem;
				border-top: 1px solid #e5e5e5;
				border-bottom: 1px solid #e5e5e5;
				line-height: 4rem;
				text-align: center;
				margin-top: 5px;
				font-size: 1.5rem;
				color: #a8a8a8;
				white-space: nowrap;
			}
			
			form div input {
				width: 65%;
				border: none;
				text-align: center;
				font-size: 1.5rem;
				text-align: right;
				padding-right: 5vw;
			}
			
			form .button {
				width: 80%;
				height: 4rem;
				background: #3299fe;
				line-height: 4rem;
				text-align: center;
				margin-left: 10%;
				border-radius: 10px;
				margin-top: 20px;
				color: #fefefe;
				font-size: 2rem;
			}
			#wenXinTiShi{
				height:2.5rem;
				line-height:2.5rem;
				border:none;
				font-size:1rem;
			}
			.inline{
				position: relative;
			}
			.saoyisao{
				position: absolute;
				display: inline-block;
				width: 2rem;
				height: 2rem;
				top: 1rem;
				right: 5px;
			}
		</style>
	</head>

	<body>
		<div style="display:none">
			<?php
				require_once "jssdk.php";
				$jssdk = new JSSDK("wx82dbac04fa8fd8ef", "98ecda31265ffc327d59adc969089650");
				$signPackage = $jssdk->GetSignPackage();
			?>
		</div>
		<div class="img_logo">
			<img src="img/shouqian.png" />
		</div>
		<form action="" method="post">
			<div>
				付款金额：<input type="text" name="" id="" value="" placeholder="必填,例：0.01" />
			</div>
			<div>
				付款单位：<input type="text" name="" id="" value="" placeholder="请输入付款单位" />
			</div>
			<div>
				服务城市：<input type="text" name="" id="" value="" placeholder="请输入所在城市" />
			</div>
			<div>
				司机工号：<input type="number" name="" id="" value="" placeholder="请输入司机工号" />
			</div>
			<div class="inline">
				运单单号：<input type="number" name="" id="yundan" value="" placeholder="请输入运单号" /><img src="img/saoyisao.png" class="saoyisao" />
			</div>
			
			<div id="wenXinTiShi">
				温馨提示：请务必填写真实有效的资料信息
			</div>
			<div class="button">
				确认付款
			</div>
		</form>
		<script src="js/jquery-1.11.0.js"></script>
		<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" charset="utf-8"></script>
		<script>
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
				$(".saoyisao").on("click", function() {
					wx.scanQRCode({
						needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
						scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
						success: function(res) {
							var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果;
							 if(result.includes(',')){
		                      result = result.split(',')[1];        
		                     }
							 $('#yundan').val(result);
//							alert(result);
			        
						}
					})
				})	
				</script>	

	
		    
            <script>
			$(".button").on("click", function() {
				var _jinE = $("form div:nth-of-type(1) input").val();
				var _danWei=$("form div:nth-of-type(2) input").val();
				var _city=$("form div:nth-of-type(3) input").val();
				var _driverId=$("form div:nth-of-type(4) input").val();
				var _Waybill=$("form div:nth-of-type(5) input").val();
				if(_jinE != "" && _jinE > 0) {
					if(_danWei!=""){
						if(_city!=""){
							if(_driverId!=''){
								if(_Waybill!=''){
								    console.log("金额："+_jinE+",付款单位:"+_danWei+',所属城市:'+_city+"司机工号:"+_driverId+"运单号:"+_Waybill);
									window.sessionStorage.setItem("pay_money",_jinE);//金额
							        window.sessionStorage.setItem("pay_daWei",_danWei);//付款单位
							        window.sessionStorage.setItem("_city",_city);//所属城市
							        window.sessionStorage.setItem("_driverId",_driverId);//司机工号
							        window.sessionStorage.setItem("_Waybill",_Waybill);//运单号
							        window.location.href = "zhifu/example/jsapi_Pda.php?total=" + _jinE * 100;
								}else{
									alert("运单号不能为空！")
								}
							}else{
								alert("司机工号不能为空！")
							}
							
						}else{
							alert("服务城市不能为空！")
						}
					}else{
						alert("付款单位不能为空！");
					}
				} else {
					alert("请输入正确的金额，不能包含除数字以外的内容！");
				}
				
			  })
		
		</script>
	</body>

</html>