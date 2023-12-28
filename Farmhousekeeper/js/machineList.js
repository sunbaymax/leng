$(document).ready(function() {
	var userinfo = JSON.parse(localStorage.getItem('isonline'));
	var _userName = userinfo.user;
	var _userPass = userinfo.pwd;
	var _userType = userinfo.userType;
	var _openid=localStorage.getItem('openId');
	var _url = window.location.href;
	/*
	 *发送绑定请求的代码； 
	 */
	$("#post_add_post").on("click", function() {
		var _num = $("#post_add").val().replace(/\s*/g, "");
		if(_num == "") {
			alert("请输入设备号")
		} else {
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
						window.location.href = _url;
					} else {
						alert("请求绑定设备失败，请重新进入再操作")
					}
				}
			});
		}
	});
	//隐藏上传设备号的窗口；
	$("#post_add_esc").on("click", function() {
		$(".window_post:nth-of-type(1)").addClass("hidden")
	});
	//显示上传设备号的窗口；
	$(".header a").on("click", function() {
		$(".window_post:nth-of-type(1)").removeClass("hidden")
	})

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
		$("#get_add_post").on("click", function() {
			var _num = $("#get_add").val();
			$.ajax({
				type: "post",
				url: "http://www.ccsc58.com/json/08_00_tb_device_jiechubangding.php",
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
						alert("解除设备绑定成功");
						$(".window_post:nth-of-type(2)").addClass("hidden");
						//console.log(_index);
						$(".list").eq(_index).remove();
					} else {
						alert("解除设备绑定失败，请重新进入再操作")
					}
				}
			});
		})
		/*
		 * 编辑设备入口；
		 * */
		$(".list_right a:nth-of-type(1)").on("click", function() {
			var _val = $(this).parent().prev().find("a").html().replace("<span>", "").replace("</span>", "");
			window.location.href = "html/changeM.html?num_m=" + _val;
		})
		/*	
		 * 查看设备详情；
		 * */
		$(".content .list").on("click", function() {
			var _val = $(this).find('.shebeihao').text();
			window.location.href = "html/details_lists.html?num_m=" + _val;
		})

	}
	/*iscroll代码；
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
		_start += 5;
		$(".wait").removeClass("hidden");
		machine_ajax_list(_start);
	}
	/*
	 * 动态获取用户设备编码的函数；
	 */
	var _start = 0; //控制一次加载到页面条数的开头；
	machine_ajax_list(0);
    
	function machine_ajax_list(_start) {
		$.ajax({
			url:"http://www.ccsc58.com/json/00_00_tb_shebeidongtai.php",
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
						_dem.find(".list_tittle .worktime").html(_json.resultCode[i].time);
						_dem.find(".list-content .boxstate").html(_json.resultCode[i].xiangzistate);
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
//				alert("网络错误，请重新进入页面");
				_start -= 5;
				if(_start <= 0) {
					window.location.href = _url;
				};
				$(".wait").addClass("hidden");
				myscroll_x.refresh();
			}
		})

	};
	function getNowFormatDate(day) {
		var date = new Date();
		var year = date.getFullYear();
		var month = date.getMonth() + 1;
		var d =''
		if(day==-1){
			d = date.getDate()-1;
			month = date.getMonth() + 1;
		}else if(day==-30){
			d = date.getDate();
			month = date.getMonth();
		}else{
			d = date.getDate();
			month = date.getMonth() + 1;
		}					
		var hour = date.getHours();
		var minute = date.getMinutes();
		var second = date.getSeconds();
		if(month < 10) {
			month = "0" + month;
		}
		if(d < 10) {
			d = "0" + d;
		}
		if(hour < 10) {
			hour = "0" + hour;
		}
		if(minute < 10) {
			minute = "0" + hour;
		}
		if(second < 10) {
			second = "0" + second;
		}
		return year + "-" + month + "-" + d + " " + hour + ":" + minute + ":" + second;
	}
	/*
	 * 搜索点击事件；
	 */
	$(".list_top form input[type=button]").on("click", function() {
		$(".wait").removeClass("hidden");
		let _startTime=getNowFormatDate(-30)
		let _endTime=getNowFormatDate(0)
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
					StartTime: _startTime,
					EndTime: _endTime,
					StartNo: 0,
					Length: 1
				},
				success: function(data) {
					var _json = JSON.parse(data);
					if(_json.code == 30000) {
						$(".wait").addClass("hidden");
						alert("未找到您搜索的设备！");
					} else {
						window.location.href = "html/details_lists.html?num_m=" + _json.resultCode[0].shebeibianhao;
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
	 * 获取地址的函数；
	 */
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
	//结尾
})