		var _url=window.location.href;
		//var _pass_map=_url.match(/\&pass=\S+/)[0].replace("&pass=", "");
		var _user_map=_url.match(/\?user=\S+/)[0].replace("?user=","");
		//console.log(_user_map);
		$.ajax({
			type: "post",
			url: "http://www.ccsc58.com/json/00_01_tb_shebeidongtai_map.php",
			data: {
				admin_permit: "zjly8888",
				UserP: "w",
				admin_user: _user_map,
				StartNo: 0,
				Length: 10000
			},
			success: function(data) {
				var map = new BMap.Map("user_box");
				map.enableScrollWheelZoom(true);
				var point = new BMap.Point(116.456789, 39.456789);
				map.centerAndZoom(point, 5);
				var geoc = new BMap.Geocoder();
				var myIcon = new BMap.Icon("img/marker_blue_sprite.png", new BMap.Size(39,25),{
					anchor: new BMap.Size(10, 25)
				});
				var _json = JSON.parse(data);
				if(_json.message == "success") {
					for(var i = 0; i < _json.resultCode.length; i++) {
						if(_json.resultCode[i].jingdu != 0 && _json.resultCode[i].jingdu != null) {
							my_index_map(_json.resultCode[i].jingdu, _json.resultCode[i].weidu, _json.resultCode[i].time, _json.resultCode[i].shebeibianhao, _json.resultCode[i].humidity, _json.resultCode[i].temperature01, _json.resultCode[i].temperature02, map, geoc,myIcon);
						}
					}
				} else {
					$("#index_map").html("暂无设备信息");
					$("#index_map").attr("style",'font-size:16px;text-align:center;font-weight:bold;');
				}
			}
		});

		function my_index_map(_jingdu, _weidu, _time, _shebeibianhao, _humidity, _wendu01, _wendu02, map, geoc,myIcon) {
			my_zuobiao_zhuan(_jingdu, _weidu, _time, _shebeibianhao, _humidity, _wendu01, _wendu02, map, geoc);

			function my_zuobiao_zhuan(_jing, _wei, _t, _shebei, _h, _wen01, _wen02, mp, g) {
				$.ajax({
					url: "http://api.map.baidu.com/geoconv/v1/?ak=XP1alssWsEscC3NfYAhj6YfqKvgQgUXF&from=1&to=5",
					type: "post",
					dataType: "JSONP",
					data: {
						coords: _jing + "," + _wei
					},
					success: function(data) {
						my_marker_map(data.result[0].x, data.result[0].y, _t, _shebei, _h, _wen01, _wen02, mp, g)
					},
					error: function() {
						alert("网络错误，请重新进入");
					}
				});
			}

			function my_marker_map(_j, _w, _t, _shebei, _h, _wen01, _wen02, mp, g) {
				var _point = new BMap.Point(_j, _w)
				var marker = new BMap.Marker(_point,{icon:myIcon});
				mp.addOverlay(marker);
				my_index_address(_j, _w, marker, _point, _t, _shebei, _h, _wen01, _wen02, mp, g);
			}

			function my_index_address(_j, _w, mark, _p, _t, _shebei, _h, _wen01, _wen02, mp, g) {
				g.getLocation(_p, function(rs) {
					var addComp = rs.addressComponents;
					var address = (addComp.province == addComp.city) ? (addComp.city + addComp.district + addComp.street) : (addComp.province + addComp.city + addComp.district + addComp.street)
					if(address == "") {
						var _dizhi = "未发现位置信息";
						var _label01 = new BMap.Label(_shebei, {
							offset: new BMap.Size(1, 1)
						});
						_label01.setStyle({
							color: "#fefefe",
							fontSize: "10px",
							backgroundColor: "#3299fe",
							border: "none",
							fontWeight: "normal",
							textAlign: "center",
						});
						mark.setLabel(_label01);
						var _txt = "当前位置：" + _dizhi + "<br>温度01/温度02/湿度：" + _wen01 + "℃/" + _wendu02 + "℃/" + _h + "%RH<br>数据最新更新时间：" + _t;
						var _label02 = new BMap.Label(_txt, {
							offset: new BMap.Size(20, -25)
						});
						_label02.setStyle({
							color: "#046da9",
							fontSize: "12px",
							backgroundColor: "#fefefe",
							fontWeight: "normal",
							border: "1px solid #ff892a"
						});
						_label02.hide();
						mark.setLabel(_label02);
						mark.addEventListener("mouseover", function() {
							_label02.show();
						});
						mark.addEventListener("mouseout", function() {
							_label02.hide();
						});
					} else {
						var _dizhi = address;
						var _label01 = new BMap.Label(_shebei, {
							offset: new BMap.Size(1, 1)
						});
						_label01.setStyle({
							color: "#fefefe",
							fontSize: "10px",
							backgroundColor: "#3299fe",
							border: "none",
							fontWeight: "normal",
							textAlign: "center",
							display: "block"
						});
						mark.setLabel(_label01);
						var _txt = "当前位置：" + _dizhi + "<br>温度01/温度02/湿度：" + _wen01 + "℃/" + _wendu02 + "℃/" + _h + "%RH<br>数据最新更新时间：" + _t;
						var _label02 = new BMap.Label(_txt, {
							offset: new BMap.Size(20, -25)
						});
						_label02.setStyle({
							color: "#046da9",
							fontSize: "12px",
							backgroundColor: "#fefefe",
							fontWeight: "normal",
							border: "1px solid #ff892a"
						});
						_label02.hide();
						mark.setLabel(_label02);
						mark.addEventListener("mouseover", function() {
							_label02.show();
						});
						mark.addEventListener("mouseout", function() {
							_label02.hide();
						});
					}
				})
			};
		}