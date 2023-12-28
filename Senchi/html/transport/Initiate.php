<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>温湿度监控宝</title>
		<link rel="stylesheet" type="text/css" href="../../css/index.css" />
		<link rel="stylesheet" type="text/css" href="../../css/set.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=8">
		<meta http-equiv="Expires" content="0">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Cache-control" content="no-cache">
		<meta http-equiv="Cache" content="no-cache">
		<style type="text/css">
			.content {
			    width: 100%;
			    height: auto;
			    margin-top: 5.6rem;
			    font-size: 1.4rem;
			    padding: 0;
			}
          .paylist {
				width: 1.8rem;
				height: 2.2rem;
				position: absolute;
				top: 1rem;
				right: 1rem;
			}
			.content .group{
				background:#FFFFFF;
				height: auto;
				 padding: 0 2vw;
				 box-sizing: border-box;
				 margin: 15px 0 0;
			}
			.content .group .item{
				display: flex;
				height: 4rem;
				align-items: center;
				border-bottom: 1px solid #CCCC;
			}
			.content .group .item:last-child{
				border:none
			}
			.group .item .itemleft{
				display: inline-block;
				width: 28vw;
			}
			.group .item .itemcenter{
				display: flex;
			    align-items: center;
			    justify-content: space-between;
				width: 60vw;
			}
			.group .item .itemcenter input{
				display: inline-block;
				width: 100%;
				
			}
			.group .item .itemcenter .tempval{
				display: inline-block;
				width: 24vw;
				
			}
			.group .item .wendu{
				display: flex;
			    align-items: center;
			    justify-content: flex-start;
				width: 60vw;
			}
			.group .item .itemcenter .delicon{
				display: inline-block;
				width: 1.6rem;
				height: 1.6rem;
			}
			.group .item .itemright{
				display: flex;
			    width: 15vw;
			    vertical-align: middle;
			    text-align: right;
			    align-items: end;
			    justify-content: flex-end;
			}
			.item .itemright .saoyisao{
				display: inline-block;
				width: 2rem;
				height: 2rem;
			}
			.item .itemright .xuanze{
				margin-right: 0.5rem;
				display: inline-block;
				width: 1.5rem;
				height: 2.2rem;
			}
			.group .item .itemcenter select {
				display: block;
				height: 3rem;
				width: 16rem;
				text-align: center;
				background: none;
				margin-right: 5px;
			}
			.content .group .addressitem{
				height: auto!important;
				
			}
			.item .itemcenter .shouaddress,.item .itemcenter .address{
				display: inline-block;
			    width: 100%;
			    line-height: 2rem;
				margin: 5px 0;
				font-size: 1.4rem;
			    outline: none;
			    border: none;
			    font-family: "微软雅黑";
			}
			@media screen and (max-width: 320px) {
			   .group .item .itemleft{
				display: inline-block;
				width: 35vw;
			}
			}
		</style>
	</head>
   
	<body>
		
		<div class="header">
			<img class="back_list" src="../../img/back.png" /> 
			<span>运输订单 </span>
			<img src="../../img/paylists.png" class="paylist"/>
		</div>
		<div style="display:none">
			<?php
				require_once "../../jssdk.php";
				$jssdk = new JSSDK("wx029d1989acb9f44c", "b7a482220530d3be2278429bdf2a7a63");
				$signPackage = $jssdk->GetSignPackage();
			?>
		</div>
		<div class="content">
			<div class="group">
			    <div class="item">
			       <div class="itemleft">
			        	运输单号
			       </div>	
			       <div class="itemcenter">
			        	<input class="danhao" placeholder="请输入运输单号" id="yundannum"/>
			        	<img src="../../img/del.png" class="delicon"/>
			       </div>	
			    	<div class="itemright">
			    		<img src="../../img/saoyisao.png" class="saoyisao" id="test00"/>
			    	</div>
			    </div>
			    <div class="item">
			       <div class="itemleft">
			        	业务单号
			       </div>	
			       <div class="itemcenter">
			        	<input class="yewuhao" placeholder="请输入业务单号" id="yewunum"/>
			        	<img src="../../img/del.png" class="delicon" />
			       </div>	
			    	<div class="itemright">
			    		<img src="../../img/saoyisao.png" class="saoyisao" id="test01"/>
			    	</div>
			    </div>
			    <div class="item">
			       <div class="itemleft">
			        	设备编号
			       </div>	
			       <div class="itemcenter">
			        	<input class="shebeihao" placeholder="请输入设备编号" id="shebeinum"/>
			        	<img src="../../img/del.png" class="delicon"/>
			       </div>	
			    	<div class="itemright">
			    		<img src="../../img/right_shop_car.png" class="xuanze goshebei"/>
			    	</div>
			    </div>
			</div>
			<div class="group">
			    <div class="item">
			       <div class="itemleft">
			        	发货人<span style="visibility: hidden;">名</span>
			       </div>	
			       <div class="itemcenter">
			        	<input class="fahuoren" placeholder="请输入发货人" />
			        	<img src="../../img/del.png" class="delicon" />
			       </div>	
			    	<div class="itemright">
			    		<img src="../../img/right_shop_car.png" class="xuanze gofahuoren"/>
			    	</div>
			    </div>
			    <div class="item">
			       <div class="itemleft">
			        	发货单位
			       </div>	
			       <div class="itemcenter">
			        	<input class="company" placeholder="请输入发货单位"/>
			       </div>
			       <div class="itemright">
			    	</div>	
			    </div>
			    <div class="item addressitem">
			       <div class="itemleft">
			        	发货地址
			       </div>	
			       <div class="itemcenter">
			        	<textarea class="address" rows="3" cols="20" placeholder="请输入发货地址"></textarea>
			       </div>
			        <div class="itemright">
			    	</div>
			    </div>
			</div>
			<div class="group">
			    <div class="item">
			       <div class="itemleft">
			        	收货人
			       </div>	
			       <div class="itemcenter">
			        	<input class="shouhuoren" placeholder="请输入收货人"/>
			        	<img src="../../img/del.png" class="delicon" />
			       </div>	
			    	<div class="itemright">
			    		<img src="../../img/right_shop_car.png" class="xuanze goshouhuoren"/>
			    	</div>
			    </div>
			    <div class="item">
			       <div class="itemleft">
			        	收货单位
			       </div>	
			       <div class="itemcenter">
			        	<input class="shoucompany" placeholder="请输入收货单位"/>
			       </div>
			       <div class="itemright">
			    	</div>	
			    </div>
			    <div class="item addressitem">
			       <div class="itemleft">
			        	收货地址
			       </div>	
			       <div class="itemcenter">
			       	<textarea class="shouaddress" rows="3" cols="20" placeholder="请输入收货地址"></textarea>
			        	<!--<input class="shouaddress" placeholder="请输入收货地址"/>-->
			       </div>
			       <div class="itemright">
			    	</div>	
			    </div>
			</div>
			<div class="group">
			    <div class="item">
			       <div class="itemleft">
			        	货物编号
			       </div>	
			       <div class="itemcenter">
			        	<input class="drugid" placeholder="请输入货物编号"/>
			        	<img src="../../img/del.png" class="delicon" />
			       </div>	
			    	<div class="itemright">
			    		<img src="../../img/right_shop_car.png" class="xuanze godruglist"/>
			    	</div>
			    </div>
			    <div class="item">
			       <div class="itemleft">
			        	货物名称
			       </div>	
			       <div class="itemcenter">
			        	<input class="drugname" placeholder="请输入货物名称"/>
			       </div>
			       <div class="itemright">
			    	</div>	
			    </div>
			    <div class="item">
			       <div class="itemleft">
			        	货物数量
			       </div>	
			       <div class="itemcenter">
			        	<input class="drugnum" placeholder="请输入货物数量"/>
			       </div>
			       <div class="itemright">
			    	</div>	
			    </div>
			</div>
			<div class="group">
			    <div class="item">
			       <div class="itemleft">
			        	超高温度报警 
			       </div>	
			       <div class="itemcenter wendu">
			       	<input type="number" class="tempHighbaojing tempval" placeholder="请输入" value="8"/> ℃
			        	<!--<select class="tempHighbaojing">

					    </select>-->
					   
			       </div>	
			    </div>
			    <div class="item">
			       <div class="itemleft">
			        	超低温度报警
			       </div>	
			       <div class="itemcenter wendu">
			       		<input type="number" class="templowbaojing tempval" placeholder="请输入" value="2"/> ℃
			        	<!--<select class="templowbaojing">

					    </select>-->
					 
			       </div>	
			    </div>
			</div>
			<div class="group">
			    <div class="item">
			       <div class="itemleft">
			        	超高温度预警 
			       </div>	
			       <div class="itemcenter wendu">
			       	<input type="number" class="tempHighyujing tempval" placeholder="请输入" value="7"/>℃
			        	<!--<select class="tempHighyujing">

					    </select>-->
					   
			       </div>	
			    </div>
			    <div class="item">
			       <div class="itemleft">
			        	超低温度预警 
			       </div>	
			       <div class="itemcenter wendu">
			       		<input type="number" class="templowyujing tempval" placeholder="请输入" value="3"/>℃
			        	<!--<select class="templowyujing">

					    </select>-->
					   
			       </div>	
			    </div>
			</div>
			<div class="group">
			    <div class="item">
			       <div class="itemleft">
			        	创建时间
			       </div>	
			       <div class="itemcenter">
			        	<input class="time" placeholder="请选择创建时间"  id="history_start_time" readonly="readonly"/>
			       </div>	
			    </div>
			    <div class="item">
			       <div class="itemleft">
			        	预计运达时间
			       </div>	
			       <div class="itemcenter wendu">
			        	<input class="daodatime" placeholder="请选择预计运达时间" id="history_end_time" readonly="readonly"/>
			       </div>	
			    </div>
			</div>
			<div class="btnok">
				<button>提交运单</button>
			</div>

		</div>
		<script src="../../js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
		<script src="../../js/iostime.js" type="text/javascript" charset="utf-8"></script>
		<!--<script src="../../js/index.js" type="text/javascript" charset="utf-8"></script>-->
		<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" charset="utf-8"></script>
		<script>
			window.alert = function(name) {
				var iframe = document.createElement("IFRAME");
				iframe.style.display = "none";
				iframe.setAttribute("src", 'data:text/plain,');
				document.documentElement.appendChild(iframe);
				window.frames[0].window.alert(name);
				iframe.parentNode.removeChild(iframe);
			}
			if(JSON.parse(sessionStorage.getItem('waybill'))) {
				let waybill = JSON.parse(sessionStorage.getItem('waybill'));
				let txt = $('input,textarea'); // 获取所有文本框
				for (let i = 0; i < txt.length; i++) {
					txt.eq(i).val(waybill[i]); // 将文本框的值添加到数组中
				}
			}
			var _endTime = new Date();
			$("#history_start_time").val(history_time(_endTime));
			// var _startTime = new Date(_endTime.getTime() + 24 * 60 * 60 * 1000);
			// $("#history_start_time").val(history_time(_startTime));
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
			wx.ready(function(){
				$("#test00").on("click", function() {
					wx.scanQRCode({
						needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
						scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
						success: function(res) {
							var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果;
								 if(result.includes(',')){
			                      result = result.split(',')[1];        
			                     }
								$("#yundannum").val(result);
							
						}
					});
				});
				$("#test01").on("click", function() {
					wx.scanQRCode({
						needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
						scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
						success: function(res) {
							var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果;
								 if(result.includes(',')){
			                      result = result.split(',')[1];        
			                     }
								$("#yewunum").val(result);
							
						}
					});
				});
			});
			var calendar = new datePicker();
			calendar.init({
				'trigger': '#history_end_time',
				/*按钮选择器，用于触发弹出插件*/
				'type': 'datetime',
				/*模式：date日期；datetime日期时间；time时间；ym年月；*/
				'minDate': '1900-1-1',
				/*最小日期*/
				'maxDate': '2100-12-31',
				/*最大日期*/
				'onSubmit': function() { /*确认时触发事件*/
					var theSelectData = calendar.value;
				},
				'onClose': function() { /*取消时触发事件*/ }
			});
		
			function history_time(_a) {
				var _start_year = _a.getFullYear();
				var _start_month = _a.getMonth() + 1 < 10 ? "0" + (_a.getMonth() + 1) : _a.getMonth() + 1;
				var _start_date = _a.getDate() < 10 ? "0" + (_a.getDate()) : _a.getDate();
				var _start_hour = _a.getHours() < 10 ? "0" + (_a.getHours()) : _a.getHours();
				var _start_minutes = _a.getMinutes() < 10 ? "0" + (_a.getMinutes()) : _a.getMinutes();
				var _start_seconds = _a.getSeconds() < 10 ? "0" + (_a.getSeconds()) : _a.getSeconds();
				return _start_year + "-" + _start_month + "-" + _start_date + " " + _start_hour + ":" + _start_minutes + ":" + _start_seconds;
			}
			//返回
			$('.back_list').click(function(){
				window.location.href='../../machineList.php'
			})
			
			$('.paylist').click(function(){
				location.href='waybillmanager.html'
			})
			//删除
			$('.delicon').click(function(){
				$(this).prev().val('')
			})
			
			$('.xuanze').click(function(){
				//console.log($(this).attr('class').indexOf('goshebei')!=-1)
				//return false;
				if($(this).attr('class').indexOf('goshebei')!=-1){
					location.href='shebeilist.html'
				}else if($(this).attr('class').indexOf('gofahuoren')!=-1){
					location.href='fahuohulist.html'
				}else if($(this).attr('class').indexOf('goshouhuoren')!=-1){
					location.href='shouhuolist.html'
				}else if($(this).attr('class').indexOf('godruglist')!=-1){
					location.href='durgsmanager.html'
				}
				save()
			})
			function save(){  
		        let numArr = [];
				let txt = $('input,textarea'); // 获取所有文本框
				for (let i = 0; i < txt.length; i++) {
					numArr.push(txt.eq(i).val()); // 将文本框的值添加到数组中
				}
				//var arra=[1,2,3,4];
				sessionStorage.setItem('waybill',JSON.stringify(numArr));
				//var read=JSON.parse(localStorage.getItem('key'));
				//numArr.push(idata)
		        //alert("添加成功");
		        console.log(numArr)
		    }
		    var userinfo = JSON.parse(localStorage.getItem('isonline'));
			var _userName = userinfo.user;
			var _userPass = userinfo.pwd;
			var _openid = userinfo.copenid;
			var _suoshujigou = userinfo.suoshujigou;
		    //提交运单
		    $('.btnok button').on('click',function(){
		    	let danhao=$('#yundannum').val()
		    	let yewunum=$('#yewunum').val()
		    	let shebeinum=$('#shebeinum').val().substring(0,$('#shebeinum').val().lastIndexOf(","));
		    	let fahuoren=$('.fahuoren').val()
		    	let company=$('.company').val()
		    	let address=$('.address').val()
		    	let shouhuoren=$('.shouhuoren').val()
		    	let shoucompany=$('.shoucompany').val()
		    	let shouaddress=$('.shouaddress').val()
		    	let drugid=$('.drugid').val()
		    	let drugname=$('.drugname').val()
		    	let drugnum=$('.drugnum').val()
		    	let tempHighbaojing=$('.tempHighbaojing').val()
		    	let templowbaojing=$('.templowbaojing').val()
		    	let tempHighyujing=$('.tempHighyujing').val()
		    	let templowyujing=$('.templowyujing').val()
		    	let ordertime=$('#history_start_time').val()
		    	let yundatime=$('#history_end_time').val()
		    	if(danhao==''){
		    		alert('运输单号不能为空');
		    		return false;
		    	}else if(shebeinum==''){
		    		alert('设备号不能为空');
		    		return false;
		    	}
//                else if(fahuoren==''){
//		    		alert('发货人不能为空');
//		    		return false;
//		    	}else if(company==''){
//		    		alert('发货公司不能为空');
//		    		return false;
//		    	}else if(address==''){
//		    		alert('发货地址不能为空');
//		    		return false;
//		    	}else if(shouhuoren==''){
//		    		alert('收货人不能为空');
//		    		return false;
//		    	}else if(shoucompany==''){
//		    		alert('收货公司不能为空');
//		    		return false;
//		    	}else if(shouaddress==''){
//		    		alert('收货地址不能为空');
//		    		return false;
//		    	}else if(drugid==''){
//		    		alert('货物编号不能为空');
//		    		return false;
//		    	}else if(drugname==''){
//		    		alert('货物名称不能为空');
//		    		return false;
//		    	}else if(drugnum==''){
//		    		alert('货物数量不能为空');
//		    		return false;
//		    	}else if(tempHighbaojing==''){
//		    		alert('超高温度报警不能为空');
//		    		return false;
//		    	}else if(templowbaojing==''){
//		    		alert('超低温度报警不能为空');
//		    		return false;
//		    	}else if(yundatime==''){
//		    		alert('预计运达时间不能为空');
//		    		return false;
//		    	}
		    	$.ajax({
		    		type:"post",
		    		url:"http://erpapi.ccsc58.com/xiandun/public/index.php/index/transport/save",
		    		async:true,
		    		data:{
		    			controller:"register",
						admin_permit:"zjly8888",
						readonly:0,
						yonghuming:_userName,
						suoshujigou:_suoshujigou,
						state:0,
						danhao:danhao,
						yewudanhao:yewunum,
						shebeibianhao:shebeinum,
						fahuoren:fahuoren,
						fahuodanwei:company,
						fahuodizhi:address,
						shouhuoren:shouhuoren,
						shouhuodanwei:shoucompany,
						shouhuodizhi:shouaddress,
						bianhao:drugid,
						pinming:drugname,
						yaopinshuliang:drugnum,
						baojingwendu_shangxian:tempHighbaojing,
						baojingwendu_xiaxian:templowbaojing,
						hegewendu_shangxian:tempHighyujing,
						hegewendu_xiaxian:templowyujing,
						createtime:ordertime,
						yujidaodatime:yundatime
		    		},
		    		dataType:'json',
		    		success:function(res){
		    			console.log(res)
		    			if(res.code==0){
		    				alert('提交成功');
		    				setTimeout(function(){
								location.href='waybillmanager.html'
							},1500)
		    				
		    			}
		    		},
		    		error:function(err){
		    			console.log(err)
		    		}
		    	});
		    })
		</script>
		
	</body>

</html>