var _url = window.location.href;
//var _pass_map=_url.match(/\&pass=\S+/)[0].replace("&pass=", "");
var _user_map = _url.match(/\?user=\S+\&machine=/)[0].replace("?user=", "").replace("&machine=","");
var _machine=_url.match(/\&machine=\S+\&startTime=/)[0].replace("&machine=","").replace("&startTime=","");
var _startTime=_url.match(/\&startTime=\S+\&endTime=/)[0].replace("&startTime=","").replace("&endTime=","").replace("%20"," ");
var _endTime=_url.match(/\&endTime=\S+/)[0].replace("&endTime=","").replace("%20"," ");
$("#history_start_time").val(_startTime);
$("#history_end_time").val(_endTime);
$(".machine_num").val(_machine);
hu_first_map();
/*查看运动轨迹的代码
 */
/*$(".choose_right input[type='checkbox']").on("click", function() {
	if($(this).prop("checked")) {
		$(".guiJi").removeClass("hidden");
		hu_first_map();
	} else {
		$(".guiJi").addClass("hidden");
		my_all_map()
	}
});*/
function hu_first_map() {
	var _machine_num = $(".machine_num").val();
	var _start_time = $("#history_start_time").val();
	var _end_time = $("#history_end_time").val();
	var _length = 100000;
	var _jing = [];
	var _wei = [];
	var _temp = [];
	var _time = [];
	var _timeCha = [];
	var _shebeibianhao = "";
	var _chepaihao = "";
	$.ajax({
		url: "http://www.ccsc58.com/json/01_01_tb_history_data_map.php",
		type: "post",
		data: {
			UserP: "w",
			SheBeiBianHao: _machine_num,
			StartTime: _start_time,
			EndTime: _end_time,
			StartNo: 0,
			Length: _length,
			admin_permit: "zjly8888",
			admin_user: _user_map
		},
		success: function(data) {
			var _json = JSON.parse(data);
			if(_json.resultCode != "null" && _json.resultCode != "Nopermit") {
				for(var i = _json.resultCode.length - 1, j = 0; i >= 0, j < _json.resultCode.length; i--, j++) {
					_jing[j] = _json.resultCode[i].jingdu;
					_wei[j] = _json.resultCode[i].weidu;
					_temp[j] = _json.resultCode[i].temperature01 + "℃/" + _json.resultCode[i].temperature02 + "℃/" + _json.resultCode[i].humidity + "%RH";
					_time[j] = _json.resultCode[i].time;
					_timeCha[j] = Number(_json.resultCode[i].timecha).toFixed(2);
				}
				_shebeibianhao = _json.resultCode[0].shebeibianhao;
				_chepaihao = _json.chepaihao;
				var url = "http://www.ccsc58.com/json/12_00_tb_return_licheng.php";
				var data = {
					"admin_permit": "zjly8888",
					"UserP": "w",
					"SheBeiBianHao": _machine_num,
					"StartTime": _start_time,
					"EndTime": _end_time,
					"StartNo": "0",
					"Length": _length,
					"admin_user": "ceshi1234 ",
				};
				//console.log(data);
				$.post(url, data, function(data) {
					var resultCode = JSON.parse(data);
					$(".showinfo").css({
						display: "block"
					});
					$(".gongLi div:nth-of-type(1) span").html(_machine_num);
					$(".gongLi div:nth-of-type(2) span").html(_chepaihao);
					$(".gongLi div:nth-of-type(3) span").html(Number(resultCode.resultCode).toFixed(2) + "km");
					$(".gongLi div:nth-of-type(4) span").html(_start_time);
					$(".gongLi div:nth-of-type(5) span").html(_end_time);
					$(".gongLi div:nth-of-type(6) span:nth-of-type(1)").html(_json.maxtemperature01 + "℃");
					$(".gongLi div:nth-of-type(6) span:nth-of-type(2)").html(_json.mintemperature01 + "℃");
					$(".gongLi div:nth-of-type(6) span:nth-of-type(3)").html(_json.avgtemperature01 + "℃");
					$(".gongLi div:nth-of-type(7) span:nth-of-type(1)").html(_json.maxtemperature02 + "℃");
					$(".gongLi div:nth-of-type(7) span:nth-of-type(2)").html(_json.mintemperature02 + "℃");
					$(".gongLi div:nth-of-type(7) span:nth-of-type(3)").html(_json.avgtemperature02 + "℃");
					$(".gongLi div:nth-of-type(8) span:nth-of-type(1)").html(_json.maxhumidity + "%RH");
					$(".gongLi div:nth-of-type(8) span:nth-of-type(2)").html(_json.minhumidity + "%RH");
					$(".gongLi div:nth-of-type(8) span:nth-of-type(3)").html(_json.avghumidity + "%RH");
				});
				mao_map(_jing, _wei, _temp, _time, _shebeibianhao, _chepaihao, _timeCha);
			} else {
				$("#machine_map").html(_start_time + "至" + _end_time + "时间内" + _machine_num + "号设备暂无数据");
				$("#machine_map").css({
					fontSize: "16px",
					fontWeight: "bold",
					textAlign: "center"
				})
			}

		},
		error: function() {
			alert("网络错误");
		}
	});

}

function mao_map(_jing, _wei, _temp, _time, _shebeibianhao, _chepaihao, _timeCha) {
	$("#machine_map").html("");
	var map = new BMap.Map("machine_map");
	var a = 0;
	var b = 1,
		_flag_map = "";
	var adds_line = [];
	my_map_new(_jing[a], _wei[a], _temp[a], _time[a], a, b, _timeCha[a]);
	map.enableScrollWheelZoom(true);

	function my_flag() {
		a += 1;
		b += 1;
		if(a < _jing.length) {
			my_map_new(_jing[a], _wei[a], _temp[a], _time[a], a, b, _timeCha[a]);
		} else {
			console.log("代码还是自己写的好");
		}
	}

	function my_map_new(_jing_d, _wei_d, _tem, _tim, a, b, _timeC) {
		if(_jing_d != 0 && _wei_d != 0) {
			$.ajax({
				url: "http://api.map.baidu.com/geoconv/v1/?ak=jmgKloGf3cOvRl3Y9pUAfvKZCTtCNGwj&from=1&to=5",
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
				url: "http://api.map.baidu.com/reverse_geocoding/v3/?ak=jmgKloGf3cOvRl3Y9pUAfvKZCTtCNGwj&output=json&pois=0&coordtype=bd09ll",
				data: {
					location: _w + "," + _j,
				},
				success: function(data) {
					my_add_map_new(_j, _w, data.result.formatted_address)
				},
				error: function() {
					alert("网络错误，请重新进入");
				}
			})
		}

		function my_add_map_new(_j, _w, _address) {
			var point = new BMap.Point(_j, _w);
			map.centerAndZoom(point, 10);
			var myGeo = new BMap.Geocoder();
			var myIcon = new BMap.Icon("img/marker_blue_sprite.png", new BMap.Size(39, 25), {
				anchor: new BMap.Size(10, 25)
			});
			var opts = {
				title: "<span style=\"font-weight:bold;\">" + _shebeibianhao + "号设备：</span>", // 信息窗口标题
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
			var content = "车牌号：<span style=\"color:blue;font-size:12px;display:inline;\">" + _chepaihao + "</span>" + "<br>时间:<span style=\"color:blue;font-size:12px;display:inline;\">" + _tim + "</span><br/>位置:<span style=\"color:blue;font-size:12px;display:inline;\">" + _address + "</span><br/>温度01/温度02/湿度：<span style=\"color:blue;font-size:12px;display:inline;\">" + _tem + "</span><br>停留时间：<span style=\"color:blue;font-size:12px;display:inline;\">" + _timeC + "分钟</span>";
			map.addOverlay(marker);
			addClickHandler(content, marker);
			var _label01 = new BMap.Label(b, {
				offset: new BMap.Size(1, 1)
			});
			marker.setLabel(_label01);
			if(Number(_timeC) >= 30) {
				_label01.setStyle({
					color: "#fefefe",
					fontSize: "12px",
					backgroundColor: "#ed2d2d",
					border: "none",
					fontWeight: "normal",
					textAlign: "center",
					display: "block"
				});
			} else {
				_label01.setStyle({
					color: "#fefefe",
					fontSize: "12px",
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
			my_flag();
		}
	}
}