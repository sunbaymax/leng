var _url = window.location.href;
var _user_map = _url.match(/\?user=\S+\&pass=/)[0].replace("?user=", "").replace("&pass=", "");
var _user_pass = _url.match(/\&pass=\S+\&machine=/)[0].replace("&pass=", "").replace("&machine=", "");
var _machine = _url.match(/\&machine=\S+/)[0].replace("&machine=", "").split(",");
console.log(_machine);
console.log(_user_map);
console.log(_user_pass);
var map = new BMap.Map("danDian_box");
map.enableScrollWheelZoom(true);
var point = new BMap.Point(116.456789, 39.456789);
map.centerAndZoom(point, 5);
var geoc = new BMap.Geocoder();
var myIcon = new BMap.Icon("img/marker_blue_sprite.png", new BMap.Size(39, 25), {
	anchor: new BMap.Size(10, 25)
});
for(var i = 0; i < _machine.length; i++) {
	$.ajax({
		url: "http://www.ccsc58.com/json/01_00_tb_history_data.php",
		type: "post",
		data: {
			UserP: "w",
			admin_permit: "zjly8888",
			SheBeiBianHao: _machine[i],
			StartTime: "2000-08-26 00:00:00",
			EndTime: "3000-08-26 00:00:00",
			StartNo: 0,
			Length: 1,
			admin_user: _user_map,
			admin_pass: _user_pass,
		},
		success: function(data) {
			var _json = JSON.parse(data);
			console.log(_json);
			//jig_wei_Zhuan(_json.resultCode[0].jingdu, _json.resultCode[0].weidu, _json.resultCode[0].time, _json.resultCode[0].temperature01, _json.resultCode[0].temperature02, _json.resultCode[0].humidity, _json.resultCode[0].shebeibianhao)
			if(_json.resultCode[0].jingdu!=0&&_json.resultCode[0].weidu!=0){
				my_index_map(_json.resultCode[0].jingdu, _json.resultCode[0].weidu, _json.resultCode[0].time, _json.resultCode[0].shebeibianhao, _json.resultCode[0].humidity, _json.resultCode[0].temperature01, _json.resultCode[0].temperature02, map, geoc,myIcon);
			}
			
		},
		error: function() {

		}
	});
}
function my_index_map(_jingdu, _weidu, _time, _shebeibianhao, _humidity, _wendu01, _wendu02, map, geoc,myIcon) {
			my_zuobiao_zhuan(_jingdu, _weidu, _time, _shebeibianhao, _humidity, _wendu01, _wendu02, map, geoc);

			function my_zuobiao_zhuan(_jing, _wei, _t, _shebei, _h, _wen01, _wen02, mp, g) {
				$.ajax({
					url: "http://api.map.baidu.com/geoconv/v1/?ak=jmgKloGf3cOvRl3Y9pUAfvKZCTtCNGwj&from=1&to=5",
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