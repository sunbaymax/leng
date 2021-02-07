$(document).ready(function() {
	var _httpUrl='https://www.jfcss.com/api/public/index.php?s=';
	window.sessionStorage.setItem("httpUrl", _httpUrl);
	var _down_panDuan = 0;
	//返回顶端的函数；
	window.onscroll = function() {
		var t = document.documentElement.scrollTop || document.body.scrollTop;
		if(t >= 300) {
			$(".back_top").removeClass("hidden");
		} else {
			$(".back_top").addClass("hidden");
		}
	};
	$(".back_top").on("click", function() {
		nihaohao()
	})
	var sdelay = 0;

	function nihaohao() {
		window.scrollBy(0, -200);
		if(document.body.scrollTop > 0) {
			sdelay = setTimeout(nihaohao, 10);
		} else {
			window.clearTimeout(sdelay);
		}
	};
	/*
	 * 获取用户的名称和密码；
	 */

	var userinfo = JSON.parse(localStorage.getItem('onlinepengdun'));
	var _userName = userinfo.user;
	var _userPass = userinfo.pwd;
	var copenid=userinfo.copenid;

	/*
	 * 顶部导航栏点击后实现下面网页切换效果；
	 * */
	$(".wait").removeClass("hidden");
	$(".form input").on("click", function() {
		$("form input").removeClass("white_input");
		$(this).addClass("white_input");
		var arr = [$(".detailNow"), $(".details_history"), $(".details_parameter"), $(".details_warning"), $("#content_details")];
		$("._display").addClass("hidden");
		if($(this).index() > 0) {
			arr[4].addClass("hidden");
		} else {
			arr[4].removeClass("hidden");
			arr[4].css({
				height: "0vh",
				width: "0vw"
			});
		}
		arr[$(this).index()].removeClass("hidden");
	})

	/*
	 *
	 * 获取用户查找的设备号及设备名称；
	 * */
	var _url = window.location.href;
	var _num_m = "";
	if(_url.indexOf("&") != -1) {
		var pa = sessionStorage.getItem('paraset');
		if(pa == 1) {
			_num_m = _url.match(/\?num_m=\S+/)[0].replace("?num_m=", "").replace("&", "");
			$("form input").removeClass("white_input");
			$("form input:nth-of-type(3)").addClass("white_input");
			$("._display").addClass("hidden");
			$(".details_parameter").removeClass("hidden");
			sessionStorage.setItem('paraset',0);
		} else {
			_num_m = _url.match(/\?num_m=\S+/)[0].replace("?num_m=", "").replace("&", "");
			$("form input").removeClass("white_input");
			$("form input:nth-of-type(4)").addClass("white_input");
			$("._display").addClass("hidden");
			$(".details_warning").removeClass("hidden");
		}
		
	} else {
		_num_m = _url.match(/\?num_m=\S+/)[0].replace("?num_m=", "");
	}
	window.alert = function(name) {
		var iframe = document.createElement("IFRAME");
		iframe.style.display = "none";
		iframe.setAttribute("src", 'data:text/plain,');
		document.documentElement.appendChild(iframe);
		window.frames[0].window.alert(name);
		iframe.parentNode.removeChild(iframe);
	}
	$(".work_line").on("click", function() {
		var _num_ms = _url.match(/\?num_m=\S+/)[0].replace("?num_m=", "");
		var spanval = $(this).find('span').text();
		if(spanval == '基础信息设置') {
			location.href = '../html/basicSet.html?num_m=' + _num_ms
		} else if(spanval == '参数信息设置') {
			location.href = '../html/parameterSet.html?num_m=' + _num_ms
		} else if(spanval == '设备打印设置') {
			location.href = '../html/printSet.html?num_m=' + _num_ms
		} else if(spanval == '设备报警设置') {
			location.href = '../html/warningSet.html?num_m=' + _num_ms
		} else if(spanval == '系统报警设置') {
			location.href = '../html/systemSet.html?num_m=' + _num_ms
		} else {
			location.href = '../html/additionalSet.html?num_m=' + _num_ms
		}
	})
	details_list_get()

	function details_list_get() {
		$(".header").html("<div class=\"button_back_list\"><img src=\"../img/back.png\"><span></span></div>温控数据");
		/*
		 * 返回列表页的时间；
		 */
		$(".header .button_back_list").on("click", function() {
			sessionStorage.setItem('paraset','0');
			window.location.href = "../machineList.php";
			//window.history.go(-1);
		})
	}

	//将时间函数转换成所需样式的并加载到页面中去；
	var _endTime = new Date();
	var _startTime = new Date(_endTime.getTime() - 24 * 60 * 60 * 1000);
	$("#history_start_time").val(history_time(_startTime));
	$("#history_end_time").val(history_time(_endTime));
	var calendar = new datePicker();
	calendar.init({
		'trigger': '#history_start_time',
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
	/*
	 * 查看地图位置函数；
	 * */
	details_now_map()

	function details_now_map() {
		$(".details_now").on("click", function() {
			var _jingDu = $(this).find(".lng").text();
			var _weiDu = $(this).find(".lat").text();
			var _time = $(this).find(".worktime").text();
			var _wenDu01 = $(this).find(".temp1").text();
			var _wenDu02 = $(this).find(".temp2").text();
			var _shiDu = $(this).find(".humidity").text();
			_details_map(_jingDu, _weiDu, _time, _wenDu01, _wenDu02, _shiDu);
		});

		function _details_map(_jingDu, _weiDu, _time, _wenDu01, _wenDu02, _shiDu) {
			if(_jingDu == 0 || _weiDu == 0) {
				alert("未查到位置信息");
				return;
			}
			now_one_map(_jingDu, _weiDu);

			function now_one_map(x, y) {
				$(".content_details").css({
					minHeight: "80vh"
				});
				$("#content_details").css({
					height: "80vh",
					width: "100vw"
				});
				$(".detailNow").addClass("hidden");
				var map = new BMap.Map("content_details");
				var point = new BMap.Point(x, y);
				map.centerAndZoom(point, 15);
				var geoc = new BMap.Geocoder(); //添加地图到页面并确定中心点；
				var marker = new BMap.Marker(point);
				map.addOverlay(marker); //添加小红点；
				geoc.getLocation(point, function(rs) {
					var addComp = rs.addressComponents;
					var address = (addComp.province == addComp.city) ? (addComp.city + addComp.district + addComp.street + addComp.streetNumber) : (addComp.province + addComp.city + addComp.district + addComp.street + addComp.streetNumber);
					var _label = new BMap.Label(address + "<br/>温度01/温度02/湿度：" + _wenDu01 + "℃/" + _wenDu02 + "℃/" + _shiDu + "%RH<br/>时间：" + _time, {
						offset: new BMap.Size(20, -25)
					})
					_label.setStyle({
						color: "#046da9",
						fontSize: "1rem",
						backgroundColor: "#fefefe",
						fontWeight: "normal",
						border: "1px solid #ff892a"
					});
					marker.setLabel(_label);
				});
			}
		}
	}
	/*
	 *后台请求查看数据的最新的前五条数据；
	 * */
	/*
	 * 通过百度地图接口坐标转换的函数；
	 */

	/*获取最新数据时获取单条位置的函数；
	 */
	function my_machine_list(_jingDu, _weiDu, _dem) {
		$.ajax({
			url: "http://api.map.baidu.com/geoconv/v1/?ak=XP1alssWsEscC3NfYAhj6YfqKvgQgUXF&from=1&to=5",
			type: "post",
			dataType: "JSONP",
			data: {
				coords: _jingDu + "," + _weiDu
			},
			success: function(data) {
				if(data.status == 0) {
					now_one_map_address(data.result[0].x, data.result[0].y);
					_dem.find(".details_now_right .details_address span:nth-of-type(1)").html(data.result[0].x);
					_dem.find(".details_now_right .details_address span:nth-of-type(2)").html(data.result[0].y);
				} else {
					now_one_map_address(0, 0);
					_dem.find(".details_now_right .details_address span:nth-of-type(1)").html(0);
					_dem.find(".details_now_right .details_address span:nth-of-type(2)").html(0);
				}

			},
			error: function() {
				//				alert("网络错误，请重新进入");
				$(".wait").addClass("hidden");
			}
		});

		function now_one_map_address(_jingDu, _weiDu) {
			var point = new BMap.Point(_jingDu, _weiDu);
			var geoc = new BMap.Geocoder(); //添加地图到页面并确定中心点；
			geoc.getLocation(point, function(rs) {
				var address = rs.address;
				if(address == "") {
					_dem.find(".list-content .address").html("未发现位置信息");
				} else {
					_dem.find(".list-content .address").html(address);
				}

			})
		}
	}
	//获取页面当前时间；
	//http://www.ccsc58.com/json/xiandun_history_data.php http://www.ccsc58.com/json/01_00_tb_history_data.php
	$.ajax({
		url: "https://www.jfcss.com/api/public/index.php?s=/index/device/get_history_data",
		type: "post",
		data: {
			UserP: "w",
			admin_permit: "zjly8888",
			SheBeiBianHao: _num_m,
			StartTime: "2000-08-26 00:00:00",
			EndTime: history_time(_endTime),
			StartNo: 0,
			Length: 20,
			admin_user: _userName,
			admin_pass: _userPass,
			openid:copenid
		},
		success: function(data) {
			var _json = JSON.parse(data);
			if(_json.code == 10000) {
				if(_json.resultCode == "null") {
					var _s = "<a href=\"../machineList.php\">您查看的设备未开启，请开启后重新查看</a>";
					var _dem = $(".details_now").clone().removeClass("hidden").html(_s);
					_dem.css({
						width: "100vw",
						height: "10rem",
						textAlign: "center",
						fontSize: "1.4rem",
						lineHeight: "4rem",
					})
					$(".details_now").before(_dem)
				} else {
					var _list = _json.resultCode;
					for(var i = 0; i < _list.length; i++) {
						var _demN = $(".details_now").eq(0).clone().removeClass("hidden").appendTo($(".detailNow"));
						_demN.find(".list_tittle .shebeihao").html(_list[i].shebeibianhao);
						_demN.find(".list_tittle .worktime").html(_list[i].time);
						_demN.find(".list-content .temp1").html(_list[i].temperature01);
						_demN.find(".list-content .humidity").html(_list[i].humidity=='0.0'?"-":_list[i].humidity);
						_demN.find(".list-content .temp2").html(_list[i].temperature02);
						_demN.find(".list-content .power").html(_list[i].power);
						if(_list[i].xinghaoqiangdu >= 0 && _list[i].xinghaoqiangdu < 5) {
							_demN.find(".list-content .signal").html("无信号");
						} else if(_list[i].xinghaoqiangdu >= 5 && _list[i].xinghaoqiangdu < 13) {
							_demN.find(".list-content .signal").html("弱");
						} else if(_list[i].xinghaoqiangdu >= 13 && _list[i].xinghaoqiangdu < 20) {
							_demN.find(".list-content .signal").html("良");
						} else if(_list[i].xinghaoqiangdu >= 20 && _list[i].xinghaoqiangdu < 26) {
							_demN.find(".list-content .signal").html("好");
						} else if(_list[i].xinghaoqiangdu >= 26) {
							_demN.find(".list-content .signal").html("强");
						} else {
							_demN.find(".list-content .signal").html("无信号");
						}
						_demN.find(".list-content .speed").html(_list[i].speed);
						_demN.find(".list-content .boxstate").html(_list[i].xiangzistate == "close" ? '关闭' : "开启");
						_demN.find(".list-content .lng").html(_list[i].jingdu);
						_demN.find(".list-content .lat").html(_list[i].weidu);
						my_machine_list(_list[i].jingdu, _list[i].weidu, _demN)
					};
					details_now_map();
				};
			} else if(_json.code == 1){
				alert("未发现：" + _num_m.replace("&", "") + "设备，请确认您的设备是否绑定在 " + _userName + " 账号下！！！！");
				location.href='../machineList.php';
				return false;
				
				//window.location.href = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2_templatform.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
			}else {
				
				alert("请求错误");
				window.location.href = "../machineList.php";
			}
		},
		error: function() {
			var _s = "<a href=\"../machineList.php\">您查看的设备不存在或未开启，请点击返回前一页面重新查看</a>";
			var _dem = $(".details_now").clone().removeClass("hidden").html(_s);
			_dem.css({
				width: "100vw",
				height: "10rem",
				textAlign: "left",
				fontSize: "2rem",
				lineHeight: "5rem"
			})
			$(".details_now").before(_dem)
		}
	});
	$(".fujiaset").on("click", function() {
		location.href = '../html/additionalSet.html'
	})

	/*
	 * 后台获取页面列表(历史数据)；
	 */
	var _start = 0;
	var _zhe_length = 0; //折现的加载数据条数变量；
	var _iscroll_length = 5
	var _history_start_time = $("#history_start_time").val();
	var _history_end_time = $("#history_end_time").val();
	/*$(".look_more a").on("click", function() {
		_start += 20;
		_zhe_length += 20;
		$(".wait").removeClass("hidden")
		my_history_ajax(_start, _history_start_time, _history_end_time);
	});*/
	/*iscroll----
	 */
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

	function pullUpActions() {
		$(".wait").addClass("hidden");
		/*_start += 20;
		_zhe_length += 20;*/
		//$(".wait").removeClass("hidden")
		if(_iscroll_length == 5) {
			_start += 5;
			_iscroll_length = 15;
		} else if(_iscroll_length == 15) {
			_start += 15;
			_iscroll_length = 20;
		} else {
			_start += 20;
			_iscroll_length = 20;
		};
		my_history_ajax(_start, _history_start_time, _history_end_time, _iscroll_length);
	}
	my_history_ajax(_start, _history_start_time, _history_end_time, _iscroll_length);
    
    //http://www.ccsc58.com/json/01_00_tb_history_data.php 
	function my_history_ajax(_start, _history_start_time, _history_end_time, _iscroll_length) {
		$.ajax({
			type: "post",
			url: "http://www.ccsc58.com/json/xiandun_history_data.php",
			data: {
				UserP: "w",
				SheBeiBianHao: _num_m,
				StartTime: _history_start_time,
				EndTime: _history_end_time,
				StartNo: _start,
				Length: _iscroll_length,
				admin_permit: "zjly8888",
				admin_user: _userName,
				admin_pass: _userPass
			},
			success: function(data) {
				var _json = JSON.parse(data);
				if(_json.message == "noDate") {
					$(".more").html("此段时间未找到更多数据,请重新调整查看时间");
					$(".look_more").removeClass("hidden");
					$(".wait").addClass("hidden")
				} else {
					_down_panDuan = 1;
					$(".look_more a").html("点击查看更多数据");
					$(".look_more").removeClass("hidden");
					for(var i = 0; i < _json.resultCode.length; i++) {
						_dem = $(".history_content_ul_list").eq(0).clone().removeClass("hidden").appendTo(".scroll_box");
						_dem.find("li:nth-of-type(1)").html(_start + i + 1);
						_dem.find("li:nth-of-type(2)").html(_json.resultCode[i].time.replace(_json.resultCode[i].time.match(/^2[0-9]{3}/)[0] + "-", "").replace(_json.resultCode[i].time.match(/\s/)[0], "<br>"));
						_dem.find("li:nth-of-type(4)").html(_json.resultCode[i].temperature01 + "℃/<br>" + _json.resultCode[i].temperature02 + "℃");
						_dem.find("li:nth-of-type(5)").html(_json.resultCode[i].humidity=='0.0'?'-':_json.resultCode[i].humidity + "%");
						$(".more").html("<i class='pull_icon'></i><span>上拉加载...</span>")
						address_test(_json.resultCode[i].jingdu, _json.resultCode[i].weidu, _dem, _start + i, (_json.resultCode.length - 1));
						//$(".look_more").before(_dem);
					};
					_zhe_length += _json.resultCode.length;
					$(".wait").addClass("hidden");
				}
				myscroll_x.refresh();
			},
			error: function() {
				//alert("网络错误，请重新进入");
				$(".wait").addClass("hidden");
				my_history_ajax(_start, _history_start_time, _history_end_time);
			}
		})
	}

	function address_test(_jingdu, _weidu, _dem, i, _length) {
		$.ajax({
			url: "http://api.map.baidu.com/geoconv/v1/?ak=XP1alssWsEscC3NfYAhj6YfqKvgQgUXF&from=1&to=5",
			type: "post",
			dataType: "JSONP",
			data: {
				coords: _jingdu + "," + _weidu
			},
			success: function(data) {
				if(data.status == 0) {
					address_address(data.result[0].x, data.result[0].y, _dem, i, _length)
				} else {
					address_address(0, 0, _dem, i, _length)
				}

			},
			error: function() {
				//alert("网络错误，请重新进入");
				$(".wait").addClass("hidden");
			}
		});
	}

	function address_address(_jingdu, _weidu, _dem, i, _length) {
		$.ajax({
			type: "post",
			dataType: "jsonp",
			url: "http://api.map.baidu.com/geocoder/v2/?ak=XP1alssWsEscC3NfYAhj6YfqKvgQgUXF&output=json&pois=0&coordtype=bd09ll",
			data: {
				location: _weidu + "," + _jingdu,
			},
			success: function(data) {
				if(data.result.formatted_address == "" || data.status != 0) {
					_dem.find("li:nth-of-type(3)").html("未发现位置信息");
				} else {
					_dem.find("li:nth-of-type(3)").html(data.result.formatted_address);
				}
			},
			error: function() {
				$(".wait").addClass("hidden");
				//alert("网络错误，请重新进入");
			}
		})
	};

	/*历史数据中添加点击事件，防止数据未加载完成效果不能出现*/
	$(".history_search_footer li").on("click", function() {
		$(".zhiShiXian").addClass("hidden");
		$(".history_search_footer li").removeClass("white_li");
		$(this).addClass("white_li");
		var history_button = [$(".history_content_list"), $("#zhe_box"), $("#history_content_map"), $("#history_content_dayin")];
		$(".history_display").addClass("hidden");
		history_button[$(this).index()].removeClass("hidden");
		if($(this).index() == 1) {
			$("#history_content_zhe").css({
				width: "100vw",
				height: "30rem"
			});
			_history_start_time = $("#history_start_time").val();
			_history_end_time = $("#history_end_time").val();
			history_my_zhe(_history_start_time, _history_end_time, _zhe_length)
		} else if($(this).index() == 2) {
			my_new_map(_history_start_time, _history_end_time, _zhe_length)
		} else if($(this).index() == 3) {
			if(_down_panDuan == 0) {

				alert("此时间段内未发现数据！");
				$(".history_search_footer li").removeClass("white_li");
				$(".history_search_footer li:nth-of-type(1)").addClass("white_li");
				$(".history_content_list").removeClass("hidden");
			} else {
				window.location.href = "down.html?num_m=" + _num_m + "&start=" + $("#history_start_time").val() + "&end=" + $("#history_end_time").val();
			}
		} else {
			$("#history_content_map").css({
				width: "0vw",
				height: "0vh"
			});
		}
	});

	function my_new_map(_history_start_time, _history_end_time, _zhe_length) {
		$.ajax({
			url: "http://www.ccsc58.com/json/01_01_tb_history_data_map.php",
			type: "post",
			data: {
				UserP: "w",
				SheBeiBianHao: _num_m,
				StartTime: _history_start_time,
				EndTime: _history_end_time,
				StartNo: 0,
				Length: _zhe_length,
				admin_permit: "zjly8888",
				admin_user: _userName,
				admin_pass: _userPass
			},
			success: function(data) {
				var _json = JSON.parse(data);
				if(_json.resultCode != "null") {
					var _jing = [],
						_wei = [],
						_temp = [],
						_time = [],
						_timeCha = [];
					for(var j = 0, i = _json.resultCode.length - 1; j < _json.resultCode.length, i >= 0; j++, i--) {
						_jing[j] = _json.resultCode[i].jingdu;
						_wei[j] = _json.resultCode[i].weidu;
						_temp[j] = _json.resultCode[i].temperature01 + "℃/" + _json.resultCode[i].temperature02 + "℃/" + _json.resultCode[i].humidity + "%";
						_time[j] = _json.resultCode[i].time;
						_timeCha[j] = _json.resultCode[i].timecha;
					};
					mao_map(_jing, _wei, _temp, _time, _timeCha);
				} else {
					$('#history_content_map').html("此段时间未找到数据,请重新调整查看时间");
					$('#history_content_map').css({
						width: "100vw",
						height: "5rem",
						textAlign: "center",
						lineHeight: "5rem",
						fontSize: "1.5rem"
					});
				}
			},
			error: function() {
				//alert("网络错误，请重新打开页面");
			}
		})

		function mao_map(_jing, _wei, _temp, _time, _timeCha) {

			$("#history_content_map").html("");
			$("#history_content_map").css({
				width: "100vw",
				height: "70vh"
			})
			var map = new BMap.Map("history_content_map");
			var a = 0;
			var b = 1,
				_flag_map = "";
			var adds_line = [];
			my_map_new(_jing[a], _wei[a], _temp[a], _time[a], a, b, _timeCha[a]);
			map.enableScrollWheelZoom(true);

			function my_flag() {
				window.clearTimeout(_flag_map)
				a += 1;
				b += 1
				if(a < _jing.length) {
					my_map_new(_jing[a], _wei[a], _temp[a], _time[a], a, b, _timeCha[a]);
				}
			}

			function my_map_new(_jing_d, _wei_d, _tem, _tim, a, b, _timeC) {
				if(_jing_d != 0 && _wei_d != 0) {

					$.ajax({
						url: "http://api.map.baidu.com/geoconv/v1/?ak=XP1alssWsEscC3NfYAhj6YfqKvgQgUXF&from=1&to=5",
						type: "post",
						dataType: "JSONP",
						data: {
							coords: _jing_d + "," + _wei_d
						},
						success: function(data) {
							my_address_new(data.result[0].x, data.result[0].y)
						},
						error: function() {
							console.log(11)
						}
					});
				} else {
					my_flag();
				};

				function my_address_new(_j, _w) {
					$.ajax({
						type: "post",
						dataType: "jsonp",
						url: "http://api.map.baidu.com/geocoder/v2/?ak=XP1alssWsEscC3NfYAhj6YfqKvgQgUXF&output=json&pois=0&coordtype=bd09ll",
						data: {
							location: _w + "," + _j,
						},
						success: function(data) {
							my_add_map_new(_j, _w, (data.result.formatted_address + data.result.sematic_description));
						},
						error: function() {
							//alert("网络慢，加载中耐心等待");
						}
					})
				}

				function my_add_map_new(_j, _w, _address) {
					var point = new BMap.Point(_j, _w);
					map.centerAndZoom(point, 10);
					var myIcon = new BMap.Icon("../img/marker_blue_sprite.png", new BMap.Size(39, 25), {
						anchor: new BMap.Size(10, 25)
					});
					var myGeo = new BMap.Geocoder();
					var opts = {
						title: "<span style=\"font-weight:bold;\">" + _num_m + "</span>", // 信息窗口标题
						enableMessage: true //设置允许信息窗发送短息
					};
					if(adds_line.length == 2) {
						adds_line.shift();
						adds_line.push(point);
					} else {
						adds_line.push(point);
					}
					var marker;
					if(Number(_timeC) >= 30) {
						marker = new BMap.Marker(point);
					} else {
						marker = new BMap.Marker(point, {
							icon: myIcon
						});
					}

					var content = "时间:<span style=\"color:blue;font-size:12px;\">" + _tim + "</span><br/>位置:<span style=\"color:blue;font-size:12px;\">" + _address + "</span><br/>温度01/温度02/湿度：<span style=\"color:blue;font-size:12px;\">" + _tem + "</span><br>停留时间：<span style=\"color:blue;font-size:12px;\">" + parseInt(_timeC) + "分钟</span>";
					map.addOverlay(marker);
					addClickHandler(content, marker);
					var _label01 = new BMap.Label(b, {
						offset: new BMap.Size(1, 1)
					});
					marker.setLabel(_label01);
					if(Number(_timeC) >= 30) {
						_label01.setStyle({
							color: "#fefefe",
							fontSize: "10px",
							backgroundColor: "#ed2d2d",
							border: "none",
							fontWeight: "normal",
							textAlign: "center",
							display: "block"
						});
					} else {
						_label01.setStyle({
							color: "#fefefe",
							fontSize: "10px",
							backgroundColor: "#3299fe",
							border: "none",
							fontWeight: "normal",
							textAlign: "center",
							display: "block"
						});
					}

					function addClickHandler(content, marker) {
						marker.addEventListener("click", function(e) {
							openInfo(content, e)
						});
					}

					function openInfo(content, e) {
						var p = e.target;
						var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
						var infoWindow = new BMap.InfoWindow(content, opts); // 创建信息窗口对象
						map.openInfoWindow(infoWindow, point); //开启信息窗口
					}
					var polyline = new BMap.Polyline(adds_line, {
						strokeColor: "#0139B4",
						strokeWeight: 2,
						strokeOpacity: 1
					}); //创建折线
					map.removeOverlay(polyline);
					map.addOverlay(polyline); //将折线覆盖到地图上
					_flag_map = setTimeout(my_flag, 30);
					//my_flag();
				}
			}
		}
	}
	/*
	 * 根据用户输入时间显示数据；5
	 */
	$(".history_search_top input[type=button]").on("click", function() {
		_zhe_length = 0;
		/*
		 * 判断用户输入的内容是否符合要求（起始时间早于终止时间）；
		 */
		var _retain = $(".history_content_ul_list").eq(0).clone();
		$(".history_content_ul_list").remove();
		_retain.appendTo(".scroll_box");
		_start = 0;
		_iscroll_length = 5;
		$(".wait").removeClass("hidden");
		_history_start_time = $("#history_start_time").val();
		_history_end_time = $("#history_end_time").val();
		my_history_ajax(_start, _history_start_time, _history_end_time, _iscroll_length);
	})

	/*
	 *
	 * 设备报警信息后台读取；
	 */
	myWarning();

	function myWarning() {
		var _warning_more = 0;
		warning_more(_warning_more, 0);

		function warning_more(_warning_more, _flag) {
			//http://www.ccsc58.com/json/02_00_tb_baojing.php
			$.ajax({
				url: "http://www.ccsc58.com/json/xiandun_baojing.php",
				type: "post",
				data: {
					admin_permit: "zjly8888",
					UserP: "w",
					SheBeiBianHao: _num_m,
					admin_user: _userName,
					admin_pass: _userPass,
					StartNo: _warning_more,
					Length: 5
				},
				success: function(data) {
					var _json = JSON.parse(data);
					var warning_data = _json.resultCode;
					if(_json.message == "nodata") {
						if(_flag == 0) {
							$(".details_warning").css({
								height: "5rem",
								width: "100vw",
								lineHeight: "5rem",
								color: "green",
								fontSize: "1.5rem",
								textAlign: "center"
							});
							$(".more_warning").html("<a href=\"../machineList.php\">该设备未设置报警规格,点击返回列表页</a>");
							$(".wait").addClass("hidden");
						} else {
							$(".more_warning").html("没有更多数据了！！！")
							$(".wait").addClass("hidden");
						}
					} else {
						for(var i = 0; i < warning_data.length; i++) {
							//湿度阀值数据暂无；
							var _dem = $(".warning_list").eq(0).clone().removeClass("hidden").appendTo(".scroll_box_warning");
							_dem.find(".list_tittle .shebeihao").html(warning_data[i].shebeibianhao);
							_dem.find(".list_tittle .worktime").html(warning_data[i].time);
							_dem.find(".list-content .temp1").html(warning_data[i].temperature01);
							_dem.find(".list-content .temp2").html(warning_data[i].temperature02 == 0 ? '' : '/ ' + warning_data[i].temperature02);
							_dem.find(".list-content .humidity").html(warning_data[i].humidity);
							_dem.find(".list-content .power").html(warning_data[i].power);
							_dem.find(".list-content .powerLimit").html(warning_data[i].dianliang_xiaxian);
							_dem.find(".list-content .tempLimit").html(warning_data[i].baojingwendu_xiaxian + "~" + warning_data[i].baojingwendu_shangxian);
							var shidulowstr = warning_data[i].chaodishidubaojingfazhi == -99999.9 ? '-' : warning_data[i].chaodishidubaojingfazhi;
							var shiduhigtstr = warning_data[i].chaogaoshidubaojingfazhi == 99999.9 ? '-' : warning_data[i].chaogaoshidubaojingfazhi;

							_dem.find(".list-content .humiditylimit").html(shidulowstr + '~' + shiduhigtstr);

							_dem.find(".list-content .armType").html(warning_data[i].baojingleixing == false ? '温度报警' : "");

						}
						$(".wait").addClass("hidden");
					}
					myscroll.refresh();
				}
			})
		}
		$(".warning_more").on("click", function() {
			_warning_more += 5;
			//$(".wait").removeClass("hidden");
			warning_more(_warning_more, 1);
		});
		var myscroll = new iScroll("wrapper_warning", {
			onScrollMove: function() {
				if(this.y < (this.maxScrollY)) {
					$('.pull_icon_warning').addClass('flip_warning');
					$('.pull_icon_warning').removeClass('loading_warning');
					$('.more span_warning').text('释放加载...');
				} else {
					$('.pull_icon_warning').removeClass('flip_warning loading_warning');
					$('.more_warning span').text('上拉加载...')
				}
			},
			onScrollEnd: function() {
				if($('.pull_icon_warning').hasClass('flip_warning')) {
					$('.pull_icon_warning').addClass('loading_warning');
					$('.more_warning span').text('加载中...');
					pullUpActions_warning();
				}
			},
			onRefresh: function() {
				$('.more_warning').removeClass('flip_warning');
				$('.more_warning span').text('上拉加载...');
			}
		});

		function pullUpActions_warning() {
			_warning_more += 5;
			//$(".wait").removeClass("hidden");
			warning_more(_warning_more, 1);
		};
	}
	/*
	 * 折线函数；
	 * StartTime: _history_start_time,
				EndTime: _history_end_time,
	 */

	function history_my_zhe(_history_start_time, _history_end_time, _length) {
		var _hegeShang = [],
			_hegeXia = [],
			_baojingShang = [],
			_baojingXia = [],
			_shi_tem = [],
			_shi_humdity = [],
			_now_zhe_time = [];
		$.ajax({
			url: "http://www.ccsc58.com/json/09_00_tb_draw_line.php",
			type: "post",
			data: {
				UserP: "w",
				SheBeiBianHao: _num_m,
				StartTime: _history_start_time,
				EndTime: _history_end_time,
				StartNo: 0,
				Length: _length, //_length or 5000;
				admin_permit: "zjly8888",
				admin_user: _userName,
				admin_pass: _userPass,
			},
			success: function(data) {
				var _json = JSON.parse(data);
				if(_json.message == "noData") {
					$('#history_content_zhe').html("此段时间未找到数据,请重新调整查看时间");
					$('#history_content_zhe').css({
						width: "100vw",
						height: "5rem",
						textAlign: "center",
						lineHeight: "5rem",
						fontSize: "1.5rem"
					});
					$(".wait").addClass("hidden");
				} else {
					for(var i = _json.resultCode.length - 1; i >= 0; i--) {
						var _zhe_time = _json.resultCode[i].time.match(/^2[0-9]{3}/)[0] + "-"
						_shi_tem.push(Number(Number(_json.resultCode[i].temperature01).toFixed(1)));
						_now_zhe_time.push(_json.resultCode[i].time.replace(_zhe_time, ""));
						_hegeShang.push(Number(_json.hegewendushangxian));
						_hegeXia.push(Number(_json.hegewenduxiaxian));
						_baojingShang.push(Number(_json.baojingwendushangxian));
						_baojingXia.push(Number(_json.baojingwenduxiaxian));
						_shi_humdity.push(Number(Number(_json.resultCode[i].humidity).toFixed(1)));
					}
					history_zhe(_shi_tem, _now_zhe_time, _hegeShang, _hegeXia, _baojingShang, _baojingXia, _shi_humdity);
				}
			},
			error: function() {
				//alert("网络错误，请重新进入");
			}
		})

		function history_zhe(_shi_tem, _now_zhe_time, _hegeShang, _hegeXia, _baojingShang, _baojingXia, _shi_humdity) {
			var _width_xian;
			if(_shi_tem.length <= 10) {
				_width_xian = 100;
			} else {
				_width_xian = _shi_tem.length * 10;
			}
			$("#history_content_zhe").css({
				width: _width_xian + "vw"
			})
			$(".zhiShiXian").removeClass("hidden");
			$('#history_content_zhe').highcharts({
				title: {
					text: "",
					x: 0 //center
				},
				subtitle: {
					text: '',
					x: 0
				},
				xAxis: {
					categories: _now_zhe_time,
					title: {
						text: "时间（月/日/时/分/秒）"
					},
					plotLines: [{
						color: '#ccc', //线的颜色
						dashStyle: 'solid', //标示线的样式，默认是solid（实线），这里定义为长虚线
						value: -0.5, //定义在哪个值上显示标示线，这里是在x轴上刻度为3的值处垂直化一条线
						width: 1 //标示线的宽度，1px
					}],
					label: {
						text: '我是标示线的标签', //标签的内容
						align: 'left', //标签的水平位置，水平居左,默认是水平居中center
						x: 10 //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
					}
				},
				yAxis: {
					title: {
						text: '温度01(°C)/湿度(%rh)'
					},
					plotLines: [{
						color: 'red', //线的颜色
						dashStyle: 'longdashdot', //标示线的样式，默认是solid（实线），这里定义为长虚线
						value: _hegeShang[0], //定义在哪个值上显示标示线，这里是在x轴上刻度为3的值处垂直化一条线
						width: 2 //标示线的宽度，1px
					}, {
						color: 'red', //线的颜色
						dashStyle: 'longdashdot', //标示线的样式，默认是solid（实线），这里定义为长虚线
						value: _hegeXia[0], //定义在哪个值上显示标示线，这里是在x轴上刻度为3的值处垂直化一条线
						width: 2 //标示线的宽度，1px
					}, {
						color: '#F6A900', //线的颜色
						dashStyle: 'shortdot', //标示线的样式，默认是solid（实线），这里定义为长虚线
						value: _baojingShang[0], //定义在哪个值上显示标示线，这里是在x轴上刻度为3的值处垂直化一条线
						width: 2 //标示线的宽度，1px
					}, , {
						color: '#F6A900', //线的颜色
						dashStyle: 'shortdot', //标示线的样式，默认是solid（实线），这里定义为长虚线
						value: _baojingXia[0], //定义在哪个值上显示标示线，这里是在x轴上刻度为3的值处垂直化一条线
						width: 2 //标示线的宽度，1px
					}]
				},
				tooltip: {
					valueSuffix: ''

				},
				legend: {
					layout: 'horizontal',
					align: 'center',
					verticalAlign: 'bottom',
					borderWidth: 0,
					itemWidth: 80
				},
				series: [{
					name: '合格上限',
					data: _hegeShang,
					color: "rgba(0,0,0,0)",
					dashStyle: 'longdash'
				}, {
					name: '合格下限',
					data: _hegeXia,
					color: "rgba(0,0,0,0)",
					dashStyle: 'longdash'
				}, {
					name: '报警上限',
					data: _baojingShang,
					color: "rgba(0,0,0,0)",
					dashStyle: 'shortdot'
				}, {
					name: '报警下限',
					data: _baojingXia,
					color: "rgba(0,0,0,0)",
					dashStyle: 'shortdot'
				}, {
					name: '实时温度01',
					data: _shi_tem,
					color: "blue",
					lineWidth: 1,
					tooltip: {
						valueSuffix: '°C'
					},
				}, {
					name: '实时湿度',
					data: _shi_humdity,
					color: "green",
					lineWidth: 1,
					tooltip: {
						valueSuffix: '%rh'
					},
				}]
			});
		}
	}
})