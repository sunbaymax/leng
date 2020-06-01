$(document).ready(function() {
	
	$(".work_line").on("click",function(){
		//$(".sbgzcssz").css("display","block");
		$(".sbgzcssz").toggle();
	})
	$("#Happentime").shijian();
	$("#endtime").shijian();
	
	$(".print_line").on("click",function(){
		//$(".sbgzcssz").css("display","block");
		$(".sbdysz").toggle();
	})
	
	$(".baojing_line").on("click",function(){
		$(".sbbjsz").toggle();
	})
	
	$(".system_line").on("click",function(){
		$(".xtbjsz").toggle();
	})
	
	setTimeout(function(){//定时器 
	$(".wait1").css("display","none");//将图片的display属性设置为none
	},
	3000);

	$(".back_list").on("click",function(){
		window.location.href="../machineList.php"
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
//	/*
//	 * 获取客户需要修改的设备的设备号和设备名称；$(".selector").find("option:selected").text();
//	 * */
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
	$(".fly_flag input").on("click",function(){
		if($(this).is(":checked")){
			$(".fly_header").removeClass("hidden");
		}else{
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
	var userinfo = JSON.parse(localStorage.getItem('isonlinelaojiu'));
	var _userName = userinfo.user;
	var _userPass = userinfo.pwd;
	var utype=userinfo.userType;
	var ujigou=userinfo.suoshujigou;
	if(utype=='b'&&ujigou!='888891'){
		$('.details_parameter #fujiaset').hide()
		$('.details_parameter #baojingset').hide()
	}else{
		$('.details_parameter #fujiaset').hide()
		$('.details_parameter #baojingset').show()
	}

	
	myMachineList();

	function myMachineList() {
		$.ajax({
			type: "post",
			url: "http://www.ccsc58.com/json/06_00_tb_device_chanshu.php",
			data: {
				admin_permit: "zjly8888",
				UserP: "w",
				controller:"update",
				admin_user: _userName,
				admin_pass: _userPass,
				SheBeiBianHao: _num_m
			},
			success: function(data) {
				var _json = JSON.parse(data);
				<!-- 当前用户模块  -->
				$(".userN_form span").html(_userName);
				$(".userN_form span").css("margin-left","1rem")
				<!-- 设备基本信息  -->
				$(".basic_input .basic_num").val(_json.resultCode.shebeibianhao);
				$(".basic_input .mach_name").val(_json.resultCode.device_name);
				$(".basic_input .basic_num_daoqitime").val(_json.resultCode.daoqishijian);
				<!-- 设备工作参数设置  -->
				if(_json.resultCode.feixingmoshikaiqi==0){
					$("#checkbox_c1").attr("checked", false);
				}else{
					$("#checkbox_c1").attr("checked", true);
				}
				$(".cjjg").val(_json.resultCode.caiji_jiange_minute);//采集时间间隔
				$(".scjg").val(_json.resultCode.fasong_jiange_minute);//上传时间间隔
                <!-- 设备打印设置  -->
				$(".company").val(_json.resultCode.device_printhead);//打印表头
				
				if(_json.resultCode.GPS_Start==0){
					$("#checkbox_c2").attr("checked", false);
				}else{
					$("#checkbox_c2").attr("checked", true);
				}
				if(_json.resultCode.printshidu==0){
					$("#checkbox_c3").attr("checked", false);
				}else{
					$("#checkbox_c3").attr("checked", true);
				}
				if(_json.resultCode.yuanchengjiluopen==0){
					$("#checkbox_c4").attr("checked", false);
					$("#Happentime").attr("disabled","true");
				}else{
					$("#checkbox_c4").attr("checked", true);
					$("#Happentime").removeAttr('disabled');
				}
				$("#Happentime").val(_json.resultCode.feixingmoshi_kaiqishijian);//飞行模式开启时间
				if(_json.resultCode.yuanchengjiluclose==0){
					$("#checkbox_c5").attr("checked", false);
				    $("#endtime").attr("disabled","true");
				}else{
					$("#checkbox_c5").attr("checked", true);
					$("#endtime").removeAttr('disabled');
				}
				$("#endtime").val(_json.resultCode.feixingmoshi_guanbishijian);//飞行模式停止时间
				<!-- 设备报警设置  -->
				$(".tempHighbaojing").val(_json.resultCode.baojingwendu_shangxian);//报警温度上限
				if(_json.resultCode.baojingwendu_shangxian_baojing==0){
					$("#checkbox_c6").attr("checked", false);
				}else{
					$("#checkbox_c6").attr("checked", true);
				}
				$(".templowbaojing").val(_json.resultCode.baojingwendu_xiaxian);//报警温度下限
				if(_json.resultCode.baojingwendu_xiaxian_baojing==0){
					$("#checkbox_c7").attr("checked", false);
				}else{
					$("#checkbox_c7").attr("checked", true);
				}
				$(".baojingpower").val(_json.resultCode.dianliang_xiaxian);//报警电量下限
				if(_json.resultCode.dianliang_xiaxian_baojing==0){
					$("#checkbox_c8").attr("checked", false);
				}else{
					$("#checkbox_c8").attr("checked", true);
				}
				<!-- 系统报警设置  -->
				$(".hegetemphigh").val(_json.resultCode.hegewendu_shangxian);//合格温度上限
				$(".hegetemplow").val(_json.resultCode.hegewendu_xiaxian);//合格温度下限
				if(_json.resultCode.duanxingtuisong_baojing==0){
					$("#checkbox_c9").attr("checked", false);
					$(".messphone").attr("disabled","true");
				}else{
					$("#checkbox_c9").attr("checked", true);
					$(".messphone").removeAttr('disabled');
				}
				$(".messphone").val(_json.resultCode.duanxingtuisong);//手机号消息
			},
			error: function() {
				alert("网络错误！！！")
			}
		});
	}
	$("#checkbox_c4").on("click",function(){
		if($(this).prop('checked')){
			$("#Happentime").removeAttr("disabled","true");
		}else{
			$("#Happentime").attr("disabled","true");
		}
	})
	$("#checkbox_c5").on("click",function(){
		if($(this).prop('checked')){
			$("#endtime").removeAttr("disabled","true");
		}else{
			$("#endtime").attr("disabled","true");
		}
	})
	$("#checkbox_c9").on("click",function(){
		if($(this).prop('checked')){
			$(".messphone").removeAttr("disabled","true");
		}else{
			$(".messphone").attr("disabled","true");
		}
	})
 
	/*修改设备参数后提交后台
	 */
		/*修改设备参数后提交后台
	 */
	$(".tijiao").on("click", function() {
		machine_post_change();
	});

	function machine_post_change() {
		var _GPS_Start;
		if($("#checkbox_c2").is(":checked")) {
			_GPS_Start = 1;
		} else {
			_GPS_Start = 0;
		} //是否打印湿度；
		var _baojingshangxian = $(".tempHighbaojing").val(); //温度报警上限；
		var	_baojingwendu_shangxian_baojing;
		if($("#checkbox_c6").is(":checked")) {
			_baojingwendu_shangxian_baojing = 1;
		} else {
			_baojingwendu_shangxian_baojing = 0;
		} //是否开启报警上限；
		var _feixingmoshi_kaiqishijian = $("#Happentime").val(); //开启远程记录时间
		var _feixingmoshi_guanbishijian = $("#endtime").val(); //远程关闭记录时间
		var _baojingxiaxian = $(".templowbaojing").val(); //报警下限
		var	_baojingwendu_xiaxian_baojing;
		if($("#checkbox_c7").is(":checked")) {
			_baojingwendu_xiaxian_baojing = 1;
		} else {
			_baojingwendu_xiaxian_baojing = 0;
		} //是否开启报警上限；
		var _caiji_jiange_minute = $(".cjjg").val(); //采集间隔
		var _shebeiName = $(".mach_name").val();//设备名称
		var _device_printhead = $(".company").val(); //打印表头
		var _dianliang_xiaxian = $(".baojingpower").val(); //电量下限
		var _dianliang_xiaxian_baojing;
		if($("#checkbox_c8").is(":checked")) {
			_dianliang_xiaxian_baojing = 1;
		} else {
			_dianliang_xiaxian_baojing = 0;
		} //是否开启电量下限；
		var _duanxingtuisong = $(".messphone").val(); //绑定的手机号码；
		var _duanxingtuisong_baojing;
		if($("#checkbox_c9").is(":checked")) {
			_duanxingtuisong_baojing = 1;
		} else {
			_duanxingtuisong_baojing = 0;
		} //是否开启手机号推送；
		var _fasong_jiange_minute = $(".scjg").val();; //发送间隔
		var _feixingmoshikaiqi; //飞行开启时间
		if($("#checkbox_c1").is(":checked")) {
			_feixingmoshikaiqi = 1;
		} else {
			_feixingmoshikaiqi = 0;
		} //是否nixun；
		console.log(_feixingmoshikaiqi);
		var _hegeshangxian = $(".hegetemphigh").val(); //合格上限
		var _hegexiaxian = $(".hegetemplow").val(); //合格下限
		var _printshidu; 
		if($("#checkbox_c3").is(":checked")) {
			_printshidu = 1;
		} else {
			_printshidu = 0;
		} //是否打印湿度；
		var _shebeibianhao=$(".basic_num").val(); //设备号
		console.log(_shebeibianhao);
		var _yuanchengjiluclose;
		if($("#checkbox_c5").is(":checked")) {
			_yuanchengjiluclose = 1;
		} else {
			_yuanchengjiluclose = 0;
		} //是否开启远程时间；
		var _yuanchengjiluopen;
		if($("#checkbox_c4").is(":checked")) {
			_yuanchengjiluopen = 1;
		} else {
			_yuanchengjiluopen = 0;
		} //远程记录开启开关
	
		$.ajax({
			type: "post",
			url: "http://www.ccsc58.com/json/05_00_tb_device.php",
			data: {
				controller: "update",
				admin_permit: "zjly8888",
				UserP: "w",
				shebeibianhao:_shebeibianhao,
				admin_user: _userName,
				admin_pass: _userPass,
				device_name: _shebeiName,
				caiji_jiange_minute:_caiji_jiange_minute,
				fasong_jiange_minute:_fasong_jiange_minute,
				feixingmoshikaiqi:_feixingmoshikaiqi,
				device_printhead:_device_printhead,
				GPS_Start:_GPS_Start,
				printshidu:_printshidu,
				yuanchengjiluopen:_yuanchengjiluopen,
				feixingmoshi_kaiqishijian:_feixingmoshi_kaiqishijian,
				yuanchengjiluclose:_yuanchengjiluclose,
				feixingmoshi_guanbishijian:_feixingmoshi_guanbishijian,
				baojingwendu_shangxian:_baojingshangxian,
 			    baojingwendu_shangxian_baojing:_baojingwendu_shangxian_baojing,
				baojingwendu_xiaxian:_baojingxiaxian,
				baojingwendu_xiaxian_baojing:_baojingwendu_xiaxian_baojing,
				dianliang_xiaxian:_dianliang_xiaxian,
				dianliang_xiaxian_baojing:_dianliang_xiaxian_baojing,
				duanxingtuisong:_duanxingtuisong,
				duanxingtuisong_baojing:_dianliang_xiaxian_baojing,
 				hegewendu_shangxian:_hegeshangxian,
 				hegewendu_xiaxian:_hegexiaxian,
				flag: 1
			},
			success: function(data) {
				var _json = JSON.parse(data);
				if(_json.code == 10000) {
					alert("参数同步成功");
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