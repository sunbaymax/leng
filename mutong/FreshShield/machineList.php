<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="format-detection" content="telephone=no">
		<title>牧童云平台</title>
		<link rel="stylesheet" type="text/css" href="css/index.css" />
		<link rel="stylesheet" type="text/css" href="css/Machines.css" />
	</head>

	<body>
		<style>
			.list .beizhu{
				margin-left: 1.5rem;
				color: #C90000;
				font-size: 1.3rem;
			}
			.list .addresscontent{
				display: block;
				height: auto;
                /*padding-bottom: 0.5rem;*/
               padding: 0;
			}
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
				<p><span>牧童云平台</span></p>
				<p style="display: flex;align-items: center;"><img src="images/addDevice.png" class="addDevice" /> <img src="images/userCenter.png" class="userCenter" /></p>
			</div>
			<div class="window_post hidden" >
			     <div>
					<img id="test00" src="img/saoyisao.png" alt="">
					<label for="post_add">设备号：</label>
					<input type="text" id="post_add" placeholder="请输入设备号"><br>
					<input type="button" id="post_add_post" value="绑定">
					<input type="button" id="post_add_esc" value="取消">
			     </div>
			</div>
	
			<div class="searchdiv">
				<div class="father-search-content">
					<img src="images/soushuo_1@2x.png" class="search-img" />
					<input type="text" placeholder="请输入查询的设备号" id="search" class="search-input" />
					
					<img src="images/soushuo2.png" class="search-img" style="display: none;"/>
				</div>
				
			</div>

			<div id="wrapper">
				<div class="scroller">
					<div class="scroll_box">

						<div class="list hidden">
							<div class="list_tittle">
								<p class="tittlewen">
									<span>设备号：</span>
									<span class="shebeihao"></span>
									<span class="beizhu"></span>
								</p>
								<p>
									<span class="main"></span>
									<img src="img/right_shop_car.png" class="rightimg" />
								</p>

							</div>
							<div class="list-content">
								<div>
									<p>温度1：<span class="temp1">0.0</span>℃</p>
									<p>温度2：<span class="temp2">0.0</span>℃</p>

								</div>
								<div>
									<p>湿度2：<span class="humidity">-</span>%RH</p>
									<p>电量：<span class="power">-</span>%</p>
								</div>
								<div>
									<p>信号强度：<span class="signal">无</span></p>
									<p>箱体状态：<span class="boxstate">-</span></p>
								</div>
								<div>
									<p>报警温度区间：<span class="alarmArea"></span></p>
									<p>合格温度区间：<span class="AcceptableArea"></span></p>
								</div>
								<div>
									采集时间：<span class="worktime"></span>
								</div>
								<div class="addresscontent">
									地理位置：<span class="address"></span>
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

		<script src="js/iscroll.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=XP1alssWsEscC3NfYAhj6YfqKvgQgUXF" charset="utf-8"></script>
		<script type="text/javascript" src="js/jquery-1.11.0.js"></script>
		<script type="text/javascript" src="js/index.js"></script>
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
			}else{
				$(".addDevice").show()
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
				var _userType = userinfo.userType;
				if(_userType == 'b') {
					$.ajax({
						url: "http://www.ccsc58.com/json/00_00_tb_shebeidongtai.php",
						type: "post",
						data: {
							admin_permit: "zjly8888",
							UserP: "x",
							admin_user: _userName,
							admin_pass: _userPass,
							StartNo: _start,
							Length: 5
						},
						success: function(data) {
							var _json = JSON.parse(data);
							if(_json.resultCode != "nodata" && _json.code == 10000) {
								for(var i = 0; i < _json.resultCode.length; i++) {
									var _dem = $(".list").eq(0).clone().removeClass("hidden").appendTo(".scroll_box");
									_dem.find(".list-content .temp1").html(_json.resultCode[i].temperature01);
									_dem.find(".list-content .temp2").html(_json.resultCode[i].temperature02);
									_dem.find(".list-content .humidity").html(_json.resultCode[i].humidity);
									_dem.find(".list-content .speed").html(_json.resultCode[i].speed);
									_dem.find(".list-content .power").html(_json.resultCode[i].power == null ? "0" : _json.resultCode[i].power);
									_dem.find(".list_tittle .shebeihao").html(_json.resultCode[i].shebeibianhao);
//									_dem.find(".list_tittle .beizhu").html(_json.resultCode[i].beizhu);
									_dem.find(".list-content .worktime").html(_json.resultCode[i].time);
									_dem.find(".list-content .boxstate").html(_json.resultCode[i].xiangzistate == 'close' ? "关闭" : "开启");
									_dem.find(".list-content .AcceptableArea").html(_json.resultCode[i].hegewenduxiaxian + "~" + _json.resultCode[i].hegewendushangxian + "℃");
									_dem.find(".list-content .alarmArea").html(_json.resultCode[i].baojingwenduxiaxian + "~" + _json.resultCode[i].baojingwendushangxian + "℃");
									if(_json.resultCode[i].xinghaoqiangdu >= 0 && _json.resultCode[i].xinghaoqiangdu < 5) {
										_dem.find(".list-content  .signal").html("无信号");
									} else if(_json.resultCode[i].xinghaoqiangdu >= 5 && _json.resultCode[i].xinghaoqiangdu < 13) {
										_dem.find(".list-content  .signal").html("弱");
									} else if(_json.resultCode[i].xinghaoqiangdu >= 13 && _json.resultCode[i].xinghaoqiangdu < 20) {
										_dem.find(".list-content  .signal").html("良");
									} else if(_json.resultCode[i].xinghaoqiangdu >= 20 && _json.resultCode[i].xinghaoqiangdu < 26) {
										_dem.find(".list-content  .signal").html("好");
									} else if(_json.resultCode[i].xinghaoqiangdu >= 26) {
										_dem.find(".list-content  .signal").html("强");
									} else {
										_dem.find(".list-content  .signal").html("无信号");
									}
									my_machine_list(_json.resultCode[i].jingdu, _json.resultCode[i].weidu, _dem)
									/*$(".more_machine").before(_dem);*/
								}
							} else {
								$(".more").html("未找到更多设备");
							}
							//$(".wait").addClass("hidden");
							//$(".more").addClass("hidden");
							myscroll_x.refresh();
							myMachine();
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
//					var userinfo = JSON.parse(localStorage.getItem('isonline'));
					var copenid=userinfo.copenid;
					$.ajax({
						url: "http://www.zjcoldcloud.com/xiandun/public/index.php/index/device/device_list",
						type: "post",
						data: {
							openid: copenid,
							offset: _start

						},
						dataType: 'json',
						success: function(res) {
							if(res.code == 0 && res.message == 'success') {
								for(var i = 0; i < res.data.data.length; i++) {
									var _dem = $(".list").eq(0).clone().removeClass("hidden").appendTo(".scroll_box");
									_dem.find(".list-content .temp1").html(res.data.data[i].last_temperature01);
									_dem.find(".list-content .temp2").html(res.data.data[i].last_temperature02);
									_dem.find(".list-content .humidity").html(res.data.data[i].last_humidity);
									_dem.find(".list-content .speed").html(res.data.data[i].speed);
									_dem.find(".list_tittle .beizhu").html(res.data.data[i].beizhu==''?'':"("+res.data.data[i].beizhu+")");
									_dem.find(".list-content .power").html(res.data.data[i].last_power == null ? "0" : res.data.data[i].last_power);
									_dem.find(".list_tittle .shebeihao").html(res.data.data[i].shebeibianhao);
									_dem.find(".list_tittle .shebeihao").attr('is_master',res.data.data[i].is_master);
									_dem.find(".list_tittle .main").html(res.data.data[i].is_master==0?'分':"主");
									_dem.find(".list-content .worktime").html(res.data.data[i].last_time);
									_dem.find(".list-content .boxstate").html(res.data.data[i].xiangzistate == 'close' ? "关闭" : "开启");
									_dem.find(".list-content .AcceptableArea").html(res.data.data[i].hegewenduqujian);
									_dem.find(".list-content .alarmArea").html(res.data.data[i].baojingwenduqujian);
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
									my_machine_list(res.data.data[i].last_jingdu, res.data.data[i].last_weidu, _dem)
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

			function my_machine_list(_jingDu, _weiDu, _dem) {
				//console.log(_jingDu+","+_weiDu)
				$.ajax({
					url: "http://api.map.baidu.com/geoconv/v1/?ak=XP1alssWsEscC3NfYAhj6YfqKvgQgUXF&from=1&to=5",
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
			$("body").on("click", ".scroll_box .list", function() {
				var num = $(this).find(".shebeihao").text();
				var _is_master = $(this).find('.shebeihao').attr("is_master")==undefined?'1':$(this).find('.shebeihao').attr("is_master");
//				console.log(_is_master);
//				return false;
				sessionStorage.setItem('ismaster',_is_master)
				window.location.href = "html/details_lists.html?num_m=" + num
			})
			
			$(".search-input").bind('input propertychange', function() {
				var inputValue = $(this).val();
				if(inputValue.length > 0) {
					$(this).prev().hide();
					$(this).next().show();
				} else {
					$(this).next().hide()
					$(this).prev().show();
				}

			});
			//点击添加
			$(".addDevice").on('click', function() {
//				$(".window_post").removeClass('hidden');
                location.href='html/addDevice.php';

			});
			
	/*
	 * 搜索点击事件；
	 */
	$(".search-img").on("click", function() {
		
		var _search_num = $("#search").val();
		if(_search_num == "") {
			$(".wait").addClass("hidden");
			alert("请输入搜索内容！")
		} else {
			$.ajax({
				url: "http://www.ccsc58.com/json/01_00_tb_history_data.php",
				type: "post",
				data: {
					UserP: "w",
					admin_permit: "zjly8888",
					admin_user: _userName,
					admin_pass: _userPass,
					SheBeiBianHao: _search_num.replace(/\s*/g, ""),
					StartTime: "2000-08-26 00:00:00",
					EndTime: "3000-01-01 00:00:00",
					StartNo: 0,
					Length: 1
				},
				success: function(data) {
					var _json = JSON.parse(data);
					if(_json.code == 1) {
						$(".wait").addClass("hidden");
						alert("未找到您搜索的设备！");
						$("#search").val("");
						$("#search").next().hide();
						$("#search").prev().show();
					} else {
						$("#search").val("");
						$("#search").next().hide();
						$("#search").prev().show();
						window.location.href = "html/details_lists.html?num_m=" +_search_num.replace(/\s*/g, "");
					}
				},
				error: function() {
					$(".wait").addClass("hidden");
					alert("未找到您搜索的设备！");
				}
			});
		}
	});
		/*
	 *发送绑定请求的代码； 
	 */
	$("#post_add_post").on("click", function() {
		var _num = $("#post_add").val().replace(/\s*/g, "");
		if(_num == "") {
			alert("请输入设备号")
		} else {
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
				success: function(data) {
					var _json = JSON.parse(data);
					if(_json.resultCode == "success") {
						alert("设备绑定成功，重新进入页面即可看到新绑定的设备");
						window.location.reload()
					} else {
						alert("请求绑定设备失败，请重新进入再操作")
					}
				}
			});
				}else{
					$.ajax({
						type: "post",
						url: "https://www.zjcoldcloud.com/xiandun/public/index.php/index/Device/bind_device",
						data: {
							mainname: _userName,
							devicenumber: _num
						},
						success: function(data) {
							var _json = JSON.parse(data);
							if(_json.resultCode == "success") {
								alert("设备绑定成功，重新进入页面即可看到新绑定的设备");
								window.location.href = _url;
							} else {
								alert("请求绑定设备失败，请重新进入再操作")
							}
						}
					});
				}

		}
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