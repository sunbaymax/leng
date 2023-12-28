<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="format-detection" content="telephone=no">
		<title>页川云平台</title>
		<link rel="stylesheet" type="text/css" href="css/index.css" />
		<!--<link rel="stylesheet" type="text/css" href="css/Machines.css" />-->
	</head>
	<script>
        var now = new Date().getTime();
		document.write('<link href="css/Machines.css?v=' + now + '" rel="stylesheet" type="text/css"/>');
	</script>
	<body>
		<style>
			
			.hidden{
				display: none;
			}
			
		</style>
		<div style="display:none">
			<?php
				require_once "jssdk.php";
				$jssdk = new JSSDK("wx029d1989acb9f44c", "b7a482220530d3be2278429bdf2a7a63");
				$signPackage = $jssdk->GetSignPackage();
			?>
		</div>
		<div class="container">
			<div class="header">
				<p><span>云平台</span></p>
				<p style="display: flex;align-items: center;"><img src="images/yunshuicon.png" class="yunshu" /> <img src="images/addDevice.png" class="addDevice" /> <img src="images/userCenter.png" class="userCenter" /></p>
			</div>
			<div class="window_post hidden" >
			     <div>
					<!--<img id="test00" src="img/saoyisao.png" alt="">-->
					<label for="post_add">昵称：</label>
					<input type="text" id="post_add" placeholder="请输入"><br>
					<input type="button" id="post_add_post" value="确定">
					<input type="button" id="post_add_esc" value="取消">
			     </div>
			</div>
	
			<div class="searchdiv">
				<div class="father-search-content">
					<!--<img src="images/soushuo_1@2x.png" class="search-img" />-->
					<input type="text" placeholder="按昵称或设备号搜索" id="search" class="search-input" />
					<img src="images/soushuo2.png" class="search-img" />
				</div>
				
			</div>

			<div id="wrapper">
				<div class="scroller">
					<div class="refreshmsg" style="display: none;">
						<!--<i class="pull_icon"></i><span>正在刷新</span>-->
					
						<i class="pull_icon"></i><span>正在刷新...</span>
				
					</div>
					<div class="shebeitotal">
						您当前绑定的设备总数为<span class="text-blue alltotal"></span>台 <label class="is_c">,待缴设备数:<a class="text-red daoqitotal" href="html/bill.html"><span class="val"></span> <i class="tip"></i></a>台</label>
					</div>
					<div class="scroll_box">
                       
						<div class="list hidden">
							<div class="item">
								<div class="list_tittle">
									<p class="tittlewen">
										<span>设备号：</span>
										<span class="shebeihao"></span>
										<span>(<b class="main"></b>)</span>
										<!--<span class="left15">昵称：<label class="beizhu"></label></span>-->
									</p>
									
									<!--<p>
										<img src="img/right_shop_car.png" class="rightimg" />
									</p>-->
	
								</div>
								<div class="list-content">
									<div>
										<p><span class="wen">温度1：</span><span class="temp1">0.0</span>℃</p>
										<p>温度2：<span class="temp2"></span></p>
	                                    <p>湿度：<span class="humidity"></span></p>
									</div>
									<div>
										<p>信号强度：<span class="signal">无</span></p>
										<p>电量：<span class="power">-</span>%</p>
									</div>
									<div>
										
										<p>合格温度区间：<span class="alarmArea"></span></p>
										
									</div>
									<!--<div>
										<p>箱体状态：<span class="boxstate">-</span></p>
										<p>合格温度区间：<span class="AcceptableArea"></span></p>
									</div>-->
									<div>
										采集时间：<span class="worktime"></span>
									</div>
									<div class="addresscontent">
										<span>地理位置：</span><span class="address"></span>
									</div>
	
								</div>
							</div>
							
							<div id="caozuo">
								<span class="left15">昵称：<label class="beizhu"></label></span>
								<button class="Untyingbtn">解绑</button>
							</div>
							<div class="daoqi">
								<h4>设备已到期</h4>
								<div class="daoqicontent">
									您的设备服务已到期，请于<span class="daoqiTime">2020-12-12  09:35:35</span>前进行缴费，逾期该设备SIM卡将被注销。
								</div>
								<div>
									<button>前往缴费</button>
								</div>
							</div>
							
							
	
						</div>

					</div>
					<div class="more">
						<i class="pull_icon"></i><span>上拉加载...</span>
					</div>
				</div>
			</div>
       
		</div>

		<script src="../js/iscroll.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=jmgKloGf3cOvRl3Y9pUAfvKZCTtCNGwj" charset="utf-8"></script>
		<script type="text/javascript" src="../js/jquery-1.11.0.js"></script>
		<script type="text/javascript" src="../js/index.js"></script>
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
             //console.log(new Date().getTime())
			/*iscroll代码；
			 */
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
			$("#test00").on("click", function() {
				wx.scanQRCode({
					needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
					scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
					success: function(res) {
						var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果;
							 if(result.includes(',')){
		                      result = result.split(',')[1];        
		                     }
							$("#post_add").val(result);
						
					}
				});
			});
			if(!window.localStorage.getItem("isonline")) {
				window.location.href = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2_templatform.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
			}else{
			var userinfo = JSON.parse(localStorage.getItem('isonline'));
			var _userName = userinfo.user;
			var _userPass = userinfo.pwd;
			var utype = userinfo.userType;
			if(utype == 'b') {
				$(".addDevice").hide()
				$('.yunshu').show()
			}else{
				$(".addDevice").show()
				$('.yunshu').hide()
			}
			
			var _openid = localStorage.getItem('openId');
			var myscroll_x = new iScroll("wrapper", {
				onScrollMove: function() {
					if(this.y < (this.maxScrollY)) {
						$('.pull_icon').addClass('flip');
						$('.pull_icon').removeClass('loading');
						$('.more span').text('释放加载...');
					} else {
						$('.pull_icon').removeClass('flip loading');
						$('.more span').text('上拉加载...')
						if(myscroll_x.y > 50) {
							$(".refreshmsg").show();
							$('.pull_icon').addClass('loading');
						    $('.refreshmsg span').text('正在刷新...');
						    setTimeout(function () {
				                window.location.reload()
				              }, 1500);
							
						}
					}
				},
				onScrollEnd: function() {
					if($('.pull_icon').hasClass('flip')) {
						$('.pull_icon').addClass('loading');
						$('.more span').text('加载中...');
						pullUpActions();
						
					}
				},
				onRefresh: function() {
					console.log("上拉加载")
					$('.more').removeClass('flip');
					$('.more span').text('上拉加载...');
				}
			});

			var _start = 0; //控制一次加载到页面条数的开头；
			function pullUpActions() {
				_start += 5;
				$(".wait").removeClass("hidden");
				machine_ajax_list(_start);
			}

			/*
			 * 获取地址的函数；
			 */

			machine_ajax_list(0)

			function machine_ajax_list(_start) {
				let _search_num = $("#search").val();
				let userinfo = JSON.parse(localStorage.getItem('isonline'));
				let _userType = userinfo.userType;
				console.log(_userType)
				if(_userType == 'b') {
					$('.is_c').hide()
					$.ajax({
						url: "http://erpapi.ccsc58.com/xiandun/public/index.php/index/device/device_list",
//						url: "http://www.ccsc58.com/json/00_00_tb_shebeidongtai.php",
						type: "post",
						data: {
							userName: _userName,
							offset: _start,
							vague:_search_num
						},
                        dataType: 'json',
						success: function(res) {
							$('.alltotal').text(res.data.count)
							$('.daoqitotal .val').text(res.data.daoqi_count)
							if(res.code == 0 && res.message == 'success') {
							   if(res.data.count<=5){
									console.log("111")
									$(".wait").addClass("hidden");
							         $(".more").addClass("hidden");
									$(".more").html("未找到更多设备");
								}else{
									myscroll_x.refresh();

								}
								
								for(var i = 0; i < res.data.data.length; i++) {
									var _dem = $(".list").eq(0).clone().removeClass("hidden").appendTo(".scroll_box");
									_dem.find(".list-content .temp1").html(res.data.data[i].last_temperature01);
									if(res.data.data[i].model_type=='TT'){
										_dem.find(".list-content .temp2").html(res.data.data[i].last_temperature02==0?'-':res.data.data[i].last_temperature02+"℃");
										_dem.find(".list-content .humidity").parents('p').addClass('hidden');
									}else{
										_dem.find(".list-content .temp1").parents('p').find('.wen').text('温度：');
										_dem.find(".list-content .temp2").parents('p').addClass('hidden');
										_dem.find(".list-content .humidity").html(res.data.data[i].last_humidity==0?'-':res.data.data[i].last_humidity+"%RH");
									}
									_dem.find(".list-content .speed").html(res.data.data[i].speed);
									_dem.find("#caozuo .beizhu").html(res.data.data[i].beizhu==''?'':res.data.data[i].beizhu);
									_dem.find(".list-content .power").html(res.data.data[i].last_power == null ? "0" : res.data.data[i].last_power);
									_dem.find(".list_tittle .shebeihao").html(res.data.data[i].shebeibianhao);
									_dem.find(".list_tittle .shebeihao").attr('is_master',res.data.data[i].is_master);
									_dem.find(".list_tittle .main").html(res.data.data[i].is_master==0?'分':"主");
									_dem.find(".list-content .worktime").html(res.data.data[i].last_time);
									_dem.find(".list-content .boxstate").html(res.data.data[i].xiangzistate == 'close' ? "关闭" : "开启");
									_dem.find(".list-content .AcceptableArea").html(res.data.data[i].hegewenduqujian);
									_dem.find(".list-content .alarmArea").html(res.data.data[i].baojingwenduqujian);
									_dem.find(".list-content .address").html(res.data.data[i].address);
									if(res.data.data[i].xinhaoqiangdu >= 0 && res.data.data[i].xinhaoqiangdu < 5) {
										_dem.find(".list-content  .signal").html("无");
									} else if(res.data.data[i].xinhaoqiangdu >= 5 && res.data.data[i].xinhaoqiangdu < 13) {
										_dem.find(".list-content  .signal").html("弱");
									} else if(res.data.data[i].xinhaoqiangdu >= 13 && res.data.data[i].xinhaoqiangdu < 20) {
										_dem.find(".list-content  .signal").html("良");
									} else if(res.data.data[i].xinhaoqiangdu >= 20 && res.data.data[i].xinhaoqiangdu < 26) {
										_dem.find(".list-content  .signal").html("好");
									} else if(res.data.data[i].xinhaoqiangdu >= 26) {
										_dem.find(".list-content  .signal").html("强");
									} else {
										_dem.find(".list-content  .signal").html("无");
									}
									if(res.data.data[i].is_guoqi==false){
										_dem.find(".daoqi").addClass('hidden');
									}else{
										_dem.find(".daoqi").addClass('hidden');
									}
									//my_machine_list(res.data.data[i].last_jingdu, res.data.data[i].last_weidu, _dem)
									/*$(".more_machine").before(_dem);*/
								}

							} else {
								$(".more").html("未找到更多设备");
							}
							myscroll_x.refresh();
							},
						error: function() {
//							alert("网络错误，请重新进入页面");
							_start -= 5;
							if(_start <= 0) {
								window.location.href = _url;
							};
							$(".wait").addClass("hidden");
							myscroll_x.refresh();
						}
					})
				} else {
				//
//                  let _search_num = $("#search").val();
					let copenid=userinfo.copenid;
					console.log(copenid,33)
					$.ajax({
						url: "http://erpapi.ccsc58.com/xiandun/public/index.php/index/device/device_list",
						type: "post",
						data: {
							openid: copenid,
							offset: _start,
							vague:_search_num
                            
						},
						dataType: 'json',
						success: function(res) {
							$('.alltotal').text(res.data.count)
							$('.daoqitotal .val').text(res.data.daoqi_count)
							if(res.code == 0 && res.message == 'success') {
							   if(res.data.count<=5){
									console.log("111")
									$(".wait").addClass("hidden");
							         $(".more").addClass("hidden");
									$(".more").html("未找到更多设备");
								}else{
									myscroll_x.refresh();

								}
								
								for(var i = 0; i < res.data.data.length; i++) {
									var _dem = $(".list").eq(0).clone().removeClass("hidden").appendTo(".scroll_box");
									_dem.find(".list-content .temp1").html(res.data.data[i].last_temperature01);
									if(res.data.data[i].model_type=='TT'){
										_dem.find(".list-content .temp2").html(res.data.data[i].last_temperature02==0?'-':res.data.data[i].last_temperature02+"℃");
										_dem.find(".list-content .humidity").parents('p').addClass('hidden');
									}else{
										_dem.find(".list-content .temp1").parents('p').find('.wen').text('温度：');
										_dem.find(".list-content .temp2").parents('p').addClass('hidden');
										_dem.find(".list-content .humidity").html(res.data.data[i].last_humidity==0?'-':res.data.data[i].last_humidity+"%RH");
									}
									_dem.find(".list-content .speed").html(res.data.data[i].speed);
									_dem.find("#caozuo .beizhu").html(res.data.data[i].beizhu==''?'':res.data.data[i].beizhu);
									_dem.find(".list-content .power").html(res.data.data[i].last_power == null ? "0" : res.data.data[i].last_power);
									_dem.find(".list_tittle .shebeihao").html(res.data.data[i].shebeibianhao);
									_dem.find(".list_tittle .shebeihao").attr('is_master',res.data.data[i].is_master);
									_dem.find(".list_tittle .main").html(res.data.data[i].is_master==0?'分':"主");
									_dem.find(".list-content .worktime").html(res.data.data[i].last_time);
									_dem.find(".list-content .boxstate").html(res.data.data[i].xiangzistate == 'close' ? "关闭" : "开启");
									_dem.find(".list-content .AcceptableArea").html(res.data.data[i].hegewenduqujian);
									_dem.find(".list-content .alarmArea").html(res.data.data[i].baojingwenduqujian);
									_dem.find(".list-content .address").html(res.data.data[i].address);
									if(res.data.data[i].xinhaoqiangdu >= 0 && res.data.data[i].xinhaoqiangdu < 5) {
										_dem.find(".list-content  .signal").html("无");
									} else if(res.data.data[i].xinhaoqiangdu >= 5 && res.data.data[i].xinhaoqiangdu < 13) {
										_dem.find(".list-content  .signal").html("弱");
									} else if(res.data.data[i].xinhaoqiangdu >= 13 && res.data.data[i].xinhaoqiangdu < 20) {
										_dem.find(".list-content  .signal").html("良");
									} else if(res.data.data[i].xinhaoqiangdu >= 20 && res.data.data[i].xinhaoqiangdu < 26) {
										_dem.find(".list-content  .signal").html("好");
									} else if(res.data.data[i].xinhaoqiangdu >= 26) {
										_dem.find(".list-content  .signal").html("强");
									} else {
										_dem.find(".list-content  .signal").html("无");
									}
									if(res.data.data[i].is_guoqi==false){
										_dem.find(".daoqi").addClass('hidden');
									}else{
										_dem.find(".daoqi").removeClass('hidden');
									}
									//my_machine_list(res.data.data[i].last_jingdu, res.data.data[i].last_weidu, _dem)
									/*$(".more_machine").before(_dem);*/
								}

							} else {
								$(".more").html("未找到更多设备");
							}
							myscroll_x.refresh();

						},
						error: function() {
//							alert("网络错误，请重新进入页面");

							$(".wait").addClass("hidden");
							myscroll_x.refresh();
						}
					})
				}

			}
						
//$(".search-input").on("propertychange input",function(){
//   var searchBox_val = $(".search-input").val();
////   alert(searchBox_val);
//   if(searchBox_val == ""){
//      window.location.reload();//刷新页面
//   }else{
//      $(this).prev().hide();
//		$(this).next().show();
//   }
//});
//		$(".search-input").bind('input propertychange', function() {
//				var inputValue = $(this).val();
//				if(inputValue.length > 0) {
//					$(this).prev().hide();
//					$(this).next().show();
//				} else {
//					$(this).next().hide();
//					$(this).prev().show();
//					
//				}
//
//			});	
			
	/*
	 * 搜索点击事件；
	 */
	$(".search-img").on("click", function() {
		
		var _search_num = $("#search").val();
		if(_search_num == "") {
			location.reload()
		} else {
			$(".scroll_box .list").not(".hidden").remove();
			machine_ajax_list(0)
			
							  
								
					

			
			
			
			
//			$.ajax({
//				url: "http://www.ccsc58.com/json/01_00_tb_history_data.php",
//				type: "post",
//				data: {
//					UserP: "w",
//					admin_permit: "zjly8888",
//					admin_user: _userName,
//					admin_pass: _userPass,
//					SheBeiBianHao: _search_num.replace(/\s*/g, ""),
//					StartTime: "2000-08-26 00:00:00",
//					EndTime: "3000-01-01 00:00:00",
//					StartNo: 0,
//					Length: 1
//				},
//				success: function(data) {
//					var _json = JSON.parse(data);
//					if(_json.code == 1) {
//						$(".wait").addClass("hidden");
//						alert("未找到您搜索的设备！");
//						$("#search").val("");
//						$("#search").next().hide();
//						$("#search").prev().show();
//					}else if(_json.code==30000){
//						alert(_json.message);
//						return false;
//					} else {
//						$("#search").val("");
//						$("#search").next().hide();
//						$("#search").prev().show();
//						window.location.href = "html/details_lists.html?num_m=" +_search_num.replace(/\s*/g, "");
//					}
//				},
//				error: function() {
//					$(".wait").addClass("hidden");
//					alert("未找到您搜索的设备！");
//				}
//			});
		}
	});
	        //到期点击跳转
	        $(document).on('click','.daoqi',function(){
	        	
	        	let shebeihao= $(this).parents('.list').find('.shebeihao').text();
	        	window.location.href='html/buyflewpackage.html?num_m='+shebeihao
	        })

			function my_machine_list(_jingDu, _weiDu, _dem) {
				//console.log(_jingDu+","+_weiDu)
				$.ajax({
					url: "http://api.map.baidu.com/geoconv/v1/?ak=jmgKloGf3cOvRl3Y9pUAfvKZCTtCNGwj&from=1&to=5",
					type: "post",
					dataType: "JSONP",
					data: {
						coords: _jingDu + "," + _weiDu
					},
					success: function(data) {
						if(data.status == 0) {
							now_one_map_machine_list(data.result[0].x, data.result[0].y)
						} else {
							now_one_map_machine_list(0, 0)
						}
					},
					error: function() {
						$(".wait").addClass("hidden");
					}
				});

				function now_one_map_machine_list(_jingDu01, _weiDu01) {
					var point = new BMap.Point(_jingDu01, _weiDu01);
					var geoc = new BMap.Geocoder(); //添加地图到页面并确定中心点；
					geoc.getLocation(point, function(rs) {
						var addComp = rs.addressComponents;
						var address = (addComp.province == addComp.city) ? (addComp.city + addComp.district + addComp.street) : (addComp.province + addComp.city + addComp.district + addComp.street)
						if(address == "") {
							_dem.find(".list-content  .address").html("未发现位置信息")
						} else {
							_dem.find(".list-content  .address").html(address);
						}
					})
				}
			}

			function myMachine() {
				/*	
				 * 发送解除绑定的请求；
				 */
				//显示解除设备窗口；
				var _index; //解除绑定后设备成功后从页面中删除的节点下标；
				$(".list_right a:nth-of-type(2)").on("click", function() {
					var _val = $(this).parent().prev().find("a").html().replace("<span>", "").replace("</span>", "");
					$("#get_add").val(_val);
					$(".window_post:nth-of-type(2)").removeClass("hidden");
					_index = $(this).parent().parent().index();
				});
				//隐藏解除设备窗口；
				$("#get_add_esc").on("click", function() {
					$(".window_post:nth-of-type(2)").addClass("hidden");
				});
				$("#get_add_post").unbind("click");

				/*
				 * 编辑设备入口；
				 * */
				$(".list_right a:nth-of-type(1)").on("click", function() {
					var _val = $(this).parent().prev().find("a").html().replace("<span>", "").replace("</span>", "");
					window.location.href = "html/changeM.html?num_m=" + _val;
				})
				
				$(".content .list").on("click", function() {
					var _val = $(this).find('.shebeihao').text();
					var _is_master = $(this).find('.shebeihao').attr("is_master")==undefined?'1':$(this).find('.shebeihao').attr("is_master");
					if(_is_master=='0'){
						sessionStorage.setItem('ismaster_no',_val)
					}
					window.location.href = "html/details_lists.html?num_m=" + _val;
				})

			}
			$(".userCenter").on("click", function() {
				window.location.href = "html/user_sheZhi.html"
			})
			/*	
				 * 查看设备详情；
				 * */
			$("body").on("click", ".scroll_box .list .item", function() {
				var num = $(this).find(".shebeihao").text();
				var _is_master = $(this).find('.shebeihao').attr("is_master")==undefined?'1':$(this).find('.shebeihao').attr("is_master");
//				console.log(_is_master);
//				return false;
				sessionStorage.setItem('ismaster',_is_master)
				window.location.href = "html/details_lists.html?num_m=" + num
			})
		    //解绑
			$("body").on("click", ".scroll_box .list .Untyingbtn", function() {
				var num = $(this).parents('.list').find(".shebeihao").text();
				var _is_master = $(this).parent().prev().find('.shebeihao').attr("is_master");
			
				var jbmsg='请确定要解绑'+num+'该设备吗?';
				var mymessage = confirm(jbmsg);
			    if (mymessage == true) {
       				var _jiebangurl = '';
					if(_is_master == 0) {
						_jiebangurl = "http://erpapi.ccsc58.com/xiandun/public/index.php/index/device/remove_scend_device";
					} else {
						_jiebangurl = "http://erpapi.ccsc58.com/xiandun/public/index.php/index/Device/remove_bind";
					}
				
					$.ajax({
						type: "post",
						url: _jiebangurl,
						data: {
							mainname: _userName,
							devicenumber: num

						},
						success: function(data) {
							var _json = JSON.parse(data);

							if(_json.code == 0) {
								alert("解除成功");
								location.reload();
							} else {
								alert("解除失败")
							}
						}
					});
			    }else{
			        console.log("取消解绑")
			    }
				
				return false;
				

				sessionStorage.setItem('ismaster',_is_master)
				window.location.href = "html/details_lists.html?num_m=" + num
			})
			
             //运输
             $('.yunshu').on('click',function(){
             	window.location.href='html/transport/Initiate.php'
             })
			//点击添加
			$(".addDevice").on('click', function() {
//				$(".window_post").removeClass('hidden');
                location.href='html/addDevice.php';

			});

	$("body").on('click','.list .left15' ,function() {
			var _num = $(this).parents('.list').find('.shebeihao').text();
			var _beizhu = $(this).parents('.list').find('.beizhu').text();
				$(".window_post").removeClass('hidden');
				
				$(".window_post").attr('num',_num)
				$(".window_post #post_add").val(_beizhu)

	});
		/*
	 *发送绑定请求的代码； 
	 */
	$("#post_add_post").on("click", function() {
		var bieming = $("#post_add").val().replace(/\s*/g, "");
		var _num = $(this).parents('.window_post').attr('num');
	
			var copenid = userinfo.copenid == undefined ? '' : userinfo.copenid;
			$.ajax({
				type: "post",
				url: "http://erpapi.ccsc58.com/xiandun/public/index.php/index/device/update_device",
				data: {
					devid: _num,
					beizhu: bieming,
					openid:copenid
				},
				dataType: "JSON",
				success: function(res) {
					console.log(res)
					if(res.code == 0 && res.message == "success") {
						alert("保存成功");
						location.reload()
					} else {
						alert("信息保存失败，请重试！")
					}
				},
				error: function() {
					console.log("网络错误")
				}
			});

		
	});
	//隐藏上传设备号的窗口；
	$("#post_add_esc").on("click", function() {
		$(this).parents('.window_post').addClass("hidden")
	});
	//显示上传设备号的窗口；
//	$(".header a").on("click", function() {
//		$(".window_post:nth-of-type(1)").removeClass("hidden")
//	})
	
	}		
		</script>
	</body>

</html>