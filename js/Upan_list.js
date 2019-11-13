var _userName = window.localStorage.getItem("user");
var _userPass = window.localStorage.getItem("pass");
if(window.location.href.indexOf("?") != -1) {
	var _num_U = window.location.href.match(/\?U_num=\S+\&qid/)[0].replace("?U_num=", "").replace("&qid", "");
	var _qidongshijian = window.location.href.match(/\&qidongshijian=\S+\&ting/)[0].replace("&qidongshijian=", "").replace("&ting", "").replace("%20", " ");
	var _tingzhishijian = window.location.href.match(/&tingzhishijian=\S+/)[0].replace("&tingzhishijian=", "").replace("%20", " ");
	$(".content").css({
		marginTop: "7rem"
	})
	$(".content_top span").on("click", function() {
		$(".content_top span").removeClass("xinXi_choosed")
		$(this).addClass("xinXi_choosed");
		$(".content_sheBei").addClass("hidden");
		$(".content_wenDu").addClass("hidden");
		if($(this).index() == 0) {
			$(".content_sheBei").removeClass("hidden");
		} else if($(this).index() == 1) {
			$(".content_wenDu").removeClass("hidden");
		}
	});
	$(".back_list").on("click", function() {
		window.location.href = "Upan_list.html";
	});
	/*获取设备信息
	 */
	$.ajax({
		type: "post",
		url: "http://www.ccsc58.com/json/15_00_tb_U_return.php",
		data: {
			UserP: "w",
			admin_permit: "zjly8888",
			admin_user: _userName,
			admin_pass: _userPass,
			shebeibianhao: _num_U,
			qidongshijian: _qidongshijian,
			tingzhishijian: _tingzhishijian
		},
		success: function(data) {
			var _json_xiang = JSON.parse(data);
			if(_json_xiang.code == "10000" && _json_xiang.message == "success" && _json_xiang.resultCode[0].shebeibianhao != "") {
				/*设备信息
				 */
				$(".sheBei_xinxi ul:first-child li:nth-of-type(1) span").html(_json_xiang.resultCode[0].shebeimingcheng);
				$(".sheBei_xinxi ul:first-child li:nth-of-type(1) span").css({
					fontSize: "1.3rem"
				});
				$(".sheBei_xinxi ul:first-child li:nth-of-type(2) span").html(_json_xiang.resultCode[0].qidongyanshi == "" ? "暂无" : (_json_xiang.resultCode[0].qidongyanshi + "分钟"))
				$(".sheBei_xinxi ul:first-child li:nth-of-type(3) span").html(_json_xiang.resultCode[0].shangxianwendu == "" ? "暂无" : (_json_xiang.resultCode[0].shangxianwendu + "℃"));
				$(".sheBei_xinxi ul:last-child li:nth-of-type(1) span").html(_json_xiang.resultCode[0].shebeibianhao);
				$(".sheBei_xinxi ul:last-child li:nth-of-type(1) span").css({
					fontSize: "1.3rem"
				});
				$(".sheBei_xinxi ul:last-child li:nth-of-type(2) span").html(_json_xiang.resultCode[0].caiyangjiange == "" ? "暂无" : (_json_xiang.resultCode[0].caiyangjiange + "分钟"))
				$(".sheBei_xinxi ul:last-child li:nth-of-type(3) span").html(_json_xiang.resultCode[0].xiaxianwendu == "" ? "暂无" : (_json_xiang.resultCode[0].xiaxianwendu + "℃"));
				/*纪要信息
				 */
				$(".sheBei_jiYao ul:first-child li:nth-of-type(1) span").html(_json_xiang.resultCode[0].zuigaowendu == "" ? "暂无" : (_json_xiang.resultCode[0].zuigaowendu + "℃"));
				$(".sheBei_jiYao ul:first-child li:nth-of-type(2) span").html(_json_xiang.resultCode[0].pingjunwendu == "" ? "暂无" : (_json_xiang.resultCode[0].pingjunwendu + "℃"));
				$(".sheBei_jiYao ul:nth-of-type(2) li:nth-of-type(1) span").html(_json_xiang.resultCode[0].zuidiwendu == "" ? "暂无" : (_json_xiang.resultCode[0].zuidiwendu + "℃"));
				$(".sheBei_jiYao ul:nth-of-type(2) li:nth-of-type(2) span").html(_json_xiang.resultCode[0].MKTwendu == "" ? "暂无" : (_json_xiang.resultCode[0].MKTwendu + "℃"));
				$(".sheBei_jiYao p:nth-of-type(1) span").html(_json_xiang.resultCode[0].qidongshijian);
				$(".sheBei_jiYao p:nth-of-type(2) span").html(_json_xiang.resultCode[0].tingzhishijian);
				$(".sheBei_jiYao p:nth-of-type(3) span").html(_json_xiang.resultCode[0].jiluzongdianshu);
				$(".sheBei_jiYao p:nth-of-type(4) span").html(_json_xiang.resultCode[0].jiluzongshichang + "分钟");
				/*警告统计
				 */
				$(".warning_Tong ul:nth-of-type(2) li:nth-of-type(2)").html(_json_xiang.resultCode[0].shangxianwendu == "" ? "暂无" : (_json_xiang.resultCode[0].shangxianwendu + "℃"));
				$(".warning_Tong ul:nth-of-type(2) li:nth-of-type(3)").html(_json_xiang.resultCode[0].gaowenbaojing_count);
				$(".warning_Tong ul:nth-of-type(2) li:nth-of-type(4)").html(_json_xiang.resultCode[0].gaowenbaojing_count_shichang);
				if(_json_xiang.resultCode[0].gaowenbaojing_count != 0) {
					$(".warning_Tong ul:nth-of-type(2) li:nth-of-type(5)").html("警告");
				} else {
					$(".warning_Tong ul:nth-of-type(2) li:nth-of-type(5)").html("合格");
				}
				$(".warning_Tong ul:nth-of-type(3) li:nth-of-type(2)").html(_json_xiang.resultCode[0].xiaxianwendu == "" ? "暂无" : (_json_xiang.resultCode[0].xiaxianwendu + "℃"));
				$(".warning_Tong ul:nth-of-type(3) li:nth-of-type(3)").html(_json_xiang.resultCode[0].diwenbaojing_count);
				$(".warning_Tong ul:nth-of-type(3) li:nth-of-type(4)").html(_json_xiang.resultCode[0].diwenbaojing_count_shichang);
				if(_json_xiang.resultCode[0].diwenbaojing_count != 0) {
					$(".warning_Tong ul:nth-of-type(3) li:nth-of-type(5)").html("警告");
				} else {
					$(".warning_Tong ul:nth-of-type(3) li:nth-of-type(5)").html("合格");
				}
				/*收货信息
				 */
				$(".shouHuo ul:nth-of-type(2) li:nth-of-type(1) input").val(_json_xiang.resultCode[0].yunshudanhao);
				$(".shouHuo ul:nth-of-type(2) li:nth-of-type(2) input").val(_json_xiang.resultCode[0].shouhuoren);
				$(".shouHuo ul:nth-of-type(2) li:nth-of-type(3) input").val(_json_xiang.resultCode[0].lianxidianhua);
				$(".shouHuo ul:nth-of-type(2) li:nth-of-type(4) input").val(_json_xiang.resultCode[0].shouhuodizhi);
			}
			$(".wait").addClass("hidden");
		},
		error: function() {
			$(".wait").addClass("hidden");
			alert("网络错误！")
			window.location.href = window.location.href;
		}
	});
	/*获取温度信息
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
		if(_length == 5) {
			_start_W += 5;
			_length = 15;
		} else if(_length == 15) {
			_start_W += 15;
			_length = 20;
		} else {
			_start_W += 20;
			_length = 20;
		};
		my_WenDu(_start_W, _length);
	};
	var _start_W = 0;
	var _length = 5;
	my_WenDu(_start_W, _length);

	function my_WenDu(_s, _l) {
		//console.log(_start_W);
		//console.log(_length);
		$.ajax({
			type: "post",
			url: "http://www.ccsc58.com/json/15_03_tb_U_history_data.php",
			data: {
				UserP: "w",
				admin_permit: "zjly8888",
				admin_user: _userName,
				admin_pass: _userPass,
				SheBeiBianHao: _num_U,
				StartTime: _qidongshijian,
				EndTime: _tingzhishijian,
				StartNo: _s,
				Length: _l
			},
			success: function(data) {
				$(".wenDu p span").html(_num_U);
				var _json_wenDu = JSON.parse(data);
				if(_json_wenDu.code == 10000 && _json_wenDu.message == "success" && _json_wenDu.resultCode[0].id != "") {
					for(var i = 0; i < _json_wenDu.resultCode.length; i++) {
						//console.log(_json_wenDu.resultCode[i].id);
						var _dem_W = $("#scroll_boxXiang ul").eq(0).clone().removeClass("hidden").appendTo("#scroll_boxXiang");
						_dem_W.find("li:nth-of-type(1) span").html(_json_wenDu.resultCode[i].temperature01 == "" ? "暂无" : (_json_wenDu.resultCode[i].temperature01 + "℃"));
						_dem_W.find("li:nth-of-type(2) span").html(_json_wenDu.resultCode[i].time);
					}
					myscroll_x.refresh();
				} else {
					myscroll_x.refresh();
					$(".more").html('没有更多数据了').css({
						color: "#ccc"
					});
				}
				$(".wait").addClass("hidden");
			},
			error: function() {
				$(".wait").addClass("hidden");
				alert("网络错误！")
				window.location.href = window.location.href;
			}
		});
	};
	/*修改收货信息
	 */
	$(".shouHuo_button").on("click", function() {
		if(confirm("确定要修改收货信息吗？")) {
			var _yunshudanhao = $(".shouHuo ul:last-child li:nth-of-type(1) input").val();
			var _shouhuoren = $(".shouHuo ul:last-child li:nth-of-type(2) input").val();
			var _lianxidianhua = $(".shouHuo ul:last-child li:nth-of-type(3) input").val();
			var _shouHuoDiZhi = $(".shouHuo ul:last-child li:nth-of-type(4) input").val();
			$.ajax({
				type: "post",
				url: "http://www.ccsc58.com/json/15_01_tb_U_post.php",
				data: {
					UserP: "w",
					admin_permit: "zjly8888",
					admin_user: _userName,
					admin_pass: _userPass,
					controller: "update",
					shebeibianhao: _num_U,
					qidongshijian: _qidongshijian,
					tingzhishijian: _tingzhishijian,
					yunshudanhao: _yunshudanhao,
					lianxidianhua: _lianxidianhua,
					shouhuoren: _shouhuoren,
					shouhuodizhi: _shouHuoDiZhi
				},
				success: function(data) {
					var _json_xiuGai = JSON.parse(data);
					if(_json_xiuGai.code == "10000" && _json_xiuGai.message == "success" && _json_xiuGai.resultCode == "success") {
						alert("修改成功！");
						window.location.href = window.location.href;
					} else {
						alert("修改失败！请重新提交请求！")
					};
				},
				error: function() {
					$(".wait").addClass("hidden");
					alert("网络错误！")
					window.location.href = window.location.href;
				}
			});
		}
	});
} else {
	$(".back_list").on("click", function() {
		window.location.href = "../index.html";
	})
	$(".content").css({
		marginTop: "4rem"
	});
	$(".content").on("click", "ul", function() {
		window.location.href = "Upan_xiang.html?U_num=" + $(this).find("li:nth-of-type(1) span").html() + "&qidongshijian=" + $(this).find("li:nth-of-type(2) span").html() + "&tingzhishijian=" + $(this).find("li:nth-of-type(3) span").html();
	});
	var myscroll = new iScroll("wrapper", {
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
				pullUpAction();
			}
		},
		onRefresh: function() {
			$('.more').removeClass('flip');
			$('.more span').text('上拉加载...');
		}
	});

	function pullUpAction() {
		_start += 10;
		my_Upan_list(_start);
	};
	/*数据的加载；
	 */
	var _start = 0;
	my_Upan_list(_start);

	function my_Upan_list(_start) {
		$.ajax({
			type: "post",
			url: "http://www.ccsc58.com/json/15_00_tb_U_list.php",
			data: {
				UserP: "w",
				admin_permit: "zjly8888",
				admin_user: _userName,
				admin_pass: _userPass,
				StartNo: _start,
				Length: 10
			},
			success: function(data) {
				var _json = JSON.parse(data);
				console.log(_json);
				if(_json.code == "10000" && _json.message == "success" & _json.resultCode[0].shebeibianhao != "") {
					for(var i = 0; i < _json.resultCode.length; i++) {
						var _dem = $(".content ul").eq(0).clone().removeClass("hidden").appendTo(".iscroll_box");
						_dem.find("li:nth-of-type(1) span").html(_json.resultCode[i].shebeibianhao);
						_dem.find("li:nth-of-type(2) span").html(_json.resultCode[i].qidongshijian);
						_dem.find("li:nth-of-type(3) span").html(_json.resultCode[i].tingzhishijian);
					};
					$(".wait").addClass("hidden");
					myscroll.refresh();
				} else {
					$(".ajax_more a").html("未发现更多设备");
					$(".wait").addClass("hidden");
					myscroll.refresh();
					$(".more").html('没有更多数据了').css({
						color: "#ccc"
					});
				}
			},
			error: function() {
				$(".wait").addClass("hidden");
				alert("网络错误！")
				window.location.href = window.location.href;
			}
		});
	}
}