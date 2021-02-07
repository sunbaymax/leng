$(document).ready(function() {
	$(".back_list").on("click", function() {
		window.location.href = "../machineList.php"
	})
	/*$("#success_mao .success_box form input").on("click", function() {
		$("#success_mao").css({
			display: "none"
		});
		$("#success_mao .success_box").css({
			display: "none"
		});
	})*/
	function myPlay(play) {
		if(play != "") {
			$("#success_mao .success_box .success_information").html(play);
			$("#success_mao").css({
				display: "block"
			});
			$("#success_mao .success_box").show(500)
		}
	}
	/*
	 * 获取客户需要修改的设备的设备号和设备名称；$(".selector").find("option:selected").text();
	 * */
	var _url = window.location.href;
	var _num_m = "";
	if(_url.indexOf("&") != -1) {
		_num_m = _url.match(/\?num_m=\S+/)[0].replace("?num_m=", "").replace("&", "");
	} else {
		_num_m = _url.match(/\?num_m=\S+/)[0].replace("?num_m=", "");
	}
	var _option01 = ""; //采集、发送时间间隔；
	var _option02 = ""; //温度报警正；
	var _option03 = ""; //温度报警负；
	var _option04 = ""; //电量报警阀值；
	/*控制飞行模式开启的显示和唤醒时间的问题,页面中点击效果的实现；
	 */
	$(".fly_flag input").on("click", function() {
		if($(this).is(":checked")) {
			$(".fly_header").removeClass("hidden");
		} else {
			$(".fly_header").addClass("hidden")
		}

	});
	var _abc = new Date();
	$(".fly_time").val(history_time(_abc))

	function history_time(_a) {
		var _start_year = _a.getFullYear();
		var _start_month = _a.getMonth() + 1 < 10 ? "0" + (_a.getMonth() + 1) : _a.getMonth() + 1;
		var _start_date = _a.getDate() < 10 ? "0" + (_a.getDate()) : _a.getDate();
		var _start_hour = _a.getHours() < 10 ? "0" + (_a.getHours()) : _a.getHours();
		var _start_minutes = _a.getMinutes() < 10 ? "0" + (_a.getMinutes()) : _a.getMinutes();
		var _start_seconds = _a.getSeconds() < 10 ? "0" + (_a.getSeconds()) : _a.getSeconds();
		return _start_year + "-" + _start_month + "-" + _start_date + " " + _start_hour + ":" + _start_minutes + ":" + _start_seconds;
	}
	for(var i = 1; i <= 60; i++) {
		_option01 += "<option value=\"" + i + "\">" + i + "</opation>"
	}
	for(var i = 1; i <= 20; i++) {
		_option04 += "<option value=\"" + i + "\">" + (i * 5) + "</opation>"
	};
	for(var i = 200; i >= 0; i--) {
		if(i == 0) {
			_option02 += "<option value=\"" + i + "\" selected>" + i + "</opation>";
		} else {
			_option02 += "<option value=\"" + i + "\">" + i + "</opation>";
		}

	};
	for(var i = 1; i < 101; i++) {
		_option03 += "<option value=\"" + (200 + i) + "\">" + (-i) + "</opation>"
	};
	$(".basic_input .caijiJianGe").html(_option01);
	$(".basic_input .fasongJianGe").html(_option01);
	$(".basic_input .baojingShang").html(_option02 + _option03);
	$(".basic_input .baojingXia").html(_option02 + _option03);
	$(".basic_input .hegeShang").html(_option02 + _option03);
	$(".basic_input .hegeXia").html(_option02 + _option03);
	$(".basic_input .dianLiang").html(_option04);

	//console.log($(".basic_input .caijiJianGe")[0]);

	/*
	 *
	 * 放弃修改设备返回列表页；
	 */
	giveUp();

	function giveUp() {
		$(".form_post input:nth-of-type(2)").on("click", function() {
			window.location.href = "../machineList.php"
		})
	}
	/*后台获取设备参数的的函数；
	 */
	var userinfo = JSON.parse(localStorage.getItem('isonline'));
	var _userName = userinfo.user;
	var _userPass = userinfo.pwd;
	myMachineList();

	function myMachineList() {
		
		$.ajax({
			type: "post",
			url: "http://www.ccsc58.com/json/06_00_tb_device_chanshu.php",
			data: {
				admin_permit: "zjly8888",
				UserP: "w",
				admin_user: _userName,
				admin_pass: _userPass,
				SheBeiBianHao: _num_m
			},
			success: function(data) {
				var _json = JSON.parse(data);
				$(".userN_form span").html(_userName);
				$(".basic_input .basic_num").val(_json.resultCode.shebeibianhao)
				$(".basic_input .basic_name").val(_json.resultCode.device_name);
				$(".basic_input textarea").val(_json.resultCode.device_printhead);
				for(var i = 0; i < $(".basic_input .caijiJianGe")[0].length; i++) {
					if($(".basic_input .caijiJianGe")[0][i].text == _json.resultCode.caiji_jiange_minute) {
						$(".basic_input .caijiJianGe")[0][i].selected = true;
						break;
					}
				} //采集间隔设置；
				for(var i = 0; i < $(".basic_input .fasongJianGe")[0].length; i++) {
					if($(".basic_input .fasongJianGe")[0][i].text == _json.resultCode.fasong_jiange_minute) {
						$(".basic_input .fasongJianGe")[0][i].selected = true;
						break;
					}
				} //发送间隔设置；
				$(".content_basic_macine .basic_input input:nth-of-type(3)").val(_json.resultCode.feixingmoshi_kaiqishijian);
				$(".content_basic_macine .basic_input input:nth-of-type(4)").val(_json.resultCode.feixingmoshi_huanxingshijian);
				if(_json.resultCode.feixingmoshi_huanxingshijian == 0) {
					$(".fly_flag input").attr("checked", false);
					$(".fly_header").addClass("hidden");
				} else {
					$(".fly_flag input").attr("checked", true);
					$(".fly_header").removeClass("hidden");
				}
				//$(".baojingShang").val(_json.resultCode.baojingwendu_shangxian);
				for(var i = 0; i < $(".baojingShang")[0].length; i++) {
					if($(".baojingShang")[0][i].text == _json.resultCode.baojingwendu_shangxian) {
						$(".baojingShang")[0][i].selected = true;
						break;
					}
				} //报警上限设置；
				for(var i = 0; i < $(".baojingXia")[0].length; i++) {
					if($(".baojingXia")[0][i].text == _json.resultCode.baojingwendu_xiaxian) {
						$(".baojingXia")[0][i].selected = true;
						break;
					}
				} //报警下限设置
				for(var i = 0; i < $(".hegeShang")[0].length; i++) {
					if($(".hegeShang")[0][i].text == _json.resultCode.hegewendu_shangxian) {
						$(".hegeShang")[0][i].selected = true;
						break;
					}
				} //合格上限设置
				for(var i = 0; i < $(".hegeXia")[0].length; i++) {
					if($(".hegeXia")[0][i].text == _json.resultCode.hegewendu_xiaxian) {
						$(".hegeXia")[0][i].selected = true;
						break;
					}
				} //合格下限设置
				for(var i = 0; i < $(".dianLiang")[0].length; i++) {
					if($(".dianLiang")[0][i].text == _json.resultCode.dianliang_xiaxian) {
						$(".dianLiang")[0][i].selected = true;
						break;
					}
				} //电量下限设置
				//console.log($(".dianLiang").find("option:selected").text());
				if(_json.resultCode.GPS_Start == 1) {
					$(".gps_flag input").attr("checked", true);
				} else {
					$(".gps_flag input").attr("checked", false);
				} //开启你gps定位
				$(".tel_number").val(_json.resultCode.duanxingtuisong)
				if(_json.resultCode.baojingwendu_shangxian_baojing == 1) {
					$(".shangxian_baojing").attr("checked", true);
				} else {
					$(".shangxian_baojing").attr("checked", false);
				} //报警温度上限开启；
				if(_json.resultCode.baojingwendu_xiaxian_baojing == 1) {
					$(".xiaxian_baojing").attr("checked", true);
				} else {
					$(".xiaxian_baojing").attr("checked", false);
				} //报警温度下限开启；
				if(_json.resultCode.dianliang_xiaxian_baojing == 1) {
					$(".dianLiang_baojing").attr("checked", true);
				} else {
					$(".dianLiang_baojing").attr("checked", false);
				} //报警电量下限开启；
				if(_json.resultCode.duanxingtuisong_baojing == 1) {
					$(".tel_baojing").attr("checked", true);
				} else {
					$(".tel_baojing").attr("checked", false);
				} //短信推送开启；
			},
			error: function() {
				alert("网络错误！！！")
			}
		});
	}
	/*修改设备参数后提交后台
	 */
	$(".form_post input:nth-of-type(1)").on("click", function() {
		//console.log($(".basic_input .caijiJianGe").find("option:selected").text());
		machine_post_change();
	});

	function machine_post_change() {
		var _shebeiName = $(".basic_input .basic_name").val(); //设备名称
		var _dayinBiaoTou = $(".basic_input textarea").val(); //打印表头
		var caiJi_jiange = $(".basic_input .caijiJianGe").find("option:selected").text(); //采集间隔
		var fasong_jiange = $(".basic_input .fasongJianGe").find("option:selected").text(); //发送间隔
		var fly_kaiqishijian = $(".content_basic_macine .basic_input input:nth-of-type(3)").val(); //飞行开启时间
		var fly_huanxingshijian; //飞行唤醒时间
		var _baojingshangxian = $(".baojingShang").find("option:selected").text(); //报警上限；
		var _baojingxiaxian = $(".baojingXia").find("option:selected").text(); //报警下限
		var _hegeshangxian = $(".hegeShang").find("option:selected").text(); //合格上限
		var _hegexiaxian = $(".hegeXia").find("option:selected").text(); //合格下限
		var _dianliangxiaxian = $(".dianLiang").find("option:selected").text(); //电量下限
		var _tel_number = $(".tel_number").val(); //绑定的手机号码；
		var _baojingshangxian_kaiqi, _baojingxiaxian_kaiqi, _dianliangbaojing_kaiqi, _duanxintuisong_kaiqi, _gps_kaiqi;
		if($(".tel_baojing").is(":checked")) {
			_duanxintuisong_kaiqi = 1;
		} else {
			_duanxintuisong_kaiqi = 0;
		} //短信推送是否开启；
		if($(".shangxian_baojing").is(":checked")) {
			_baojingshangxian_kaiqi = 1;
		} else {
			_baojingshangxian_kaiqi = 0;
		} //温度上限是否开启；
		if($(".xiaxian_baojing").is(":checked")) {
			_baojingxiaxian_kaiqi = 1;
		} else {
			_baojingxiaxian_kaiqi = 0;
		} //温度下限是否开启；
		if($(".dianLiang_baojing").is(":checked")) {
			_dianliangbaojing_kaiqi = 1;
		} else {
			_dianliangbaojing_kaiqi = 0;
		} //温度下限是否开启；
		if($(".gps_flag input").is(":checked")) {
			_gps_kaiqi = 1;
		} else {
			_gps_kaiqi = 0;
		} //gps定位是否开启；
		if($(".fly_flag input").is(":checked")) {
			if($(".content_basic_macine .basic_input input:nth-of-type(4)").val() <= 0) {
				alert("开启飞行模式时唤醒时间不能为0或负数");
				return;
			} else {
				fly_huanxingshijian = $(".content_basic_macine .basic_input input:nth-of-type(4)").val();
			}
		} else {
			fly_huanxingshijian = 0;
		};
		$.ajax({
			type: "post",
			url: "http://www.ccsc58.com/json/05_00_tb_device.php",
			data: {
				controller: "update",
				admin_permit: "zjly8888",
				UserP: "w",
				admin_user: _userName,
				admin_pass: _userPass,
				shebeibianhao: _num_m,
				device_name: _shebeiName,
				device_printhead: _dayinBiaoTou,
				feixingmoshi_kaiqishijian: fly_kaiqishijian,
				feixingmoshi_huanxingshijian: fly_huanxingshijian,
				baojingwendu_shangxian: _baojingshangxian,
				baojingwendu_xiaxian: _baojingxiaxian,
				baojingwendu_shangxian_baojing: _baojingshangxian_kaiqi,
				baojingwendu_xiaxian_baojing: _baojingxiaxian_kaiqi,
				hegewendu_shangxian: _hegeshangxian,
				hegewendu_xiaxian: _hegexiaxian,
				caiji_jiange_minute: caiJi_jiange,
				fasong_jiange_minute: fasong_jiange,
				dianliang_xiaxian: _dianliangxiaxian,
				dianliang_xiaxian_baojing: _dianliangbaojing_kaiqi,
				duanxingtuisong: _tel_number,
				duanxingtuisong_baojing: _duanxintuisong_kaiqi,
				GPS_Start: _gps_kaiqi,
				flag: 1
			},
			success: function(data) {
				var _json = JSON.parse(data);
				//console.log(_dianliangbaojing_kaiqi)
				//console.log(_json);
				if(_json.resultCode == "success") {
					alert("信息保存成功");
					myMachineList();
				} else {
					alert("信息保存失败，请重试！")
				}
			},
			error: function() {
				alert("网络错误")
			}
		});
	}
})