$(document).ready(function() {
	var _userName = window.localStorage.getItem("user");
	var _userPass = window.localStorage.getItem("pass");

	/*订单详情的函数；
	 */
	var _url = window.location.href;
	if(_url.indexOf("?") != -1) {
		var _danhao = _url.match(/\?danhao=\S+/)[0].replace("?danhao=", "");
		$.ajax({
			type: "post",
			url: "http://ccsc58.com/json/13_01_tb_yundan_return.php",
			data: {
				admin_permit: "zjly8888",
				UserP: "w",
				admin_user: _userName,
				admin_pass: _userPass,
				danhao: _danhao
			},
			success: function(data) {
				var _json_xiang = JSON.parse(data);
				if(_json_xiang.message == "success") {
					$(".dingdan_content_xiang p:nth-of-type(1) span").html(_json_xiang.resultCode.danhao);
					$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(1)").html(_json_xiang.resultCode.yewudanhao==""?"暂无":_json_xiang.resultCode.yewudanhao);
					$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(2)").html(_json_xiang.resultCode.pinming);
					$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(3)").html(_json_xiang.resultCode.yaopinshuliang == "" ? "暂无数据" : _json_xiang.resultCode.yaopinshuliang);
					$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(4)").html(_json_xiang.resultCode.createtime);
					$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(5)").html(_json_xiang.resultCode.fahuodanwei);
					$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(6)").html(_json_xiang.resultCode.fahuodizhi);
					$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(7)").html(_json_xiang.resultCode.fahuoren);
					$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(8)").html(_json_xiang.resultCode.shouhuodanwei);
					$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(9)").html(_json_xiang.resultCode.shouhuodizhi);
					$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(10)").html(_json_xiang.resultCode.shouhuoren);
					$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(11)").html(_json_xiang.resultCode.yujidaodatime);
					if(_json_xiang.resultCode.state==1){
						$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(12)").html("暂未送达");
						$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(13)").html(_json_xiang.resultCode.zhuangchetime);
					}else if(_json_xiang.resultCode.state==0){
						$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(12)").html("暂未送达");
						$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(13)").html("未装车");
					}else{
						$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(12)").html(_json_xiang.resultCode.yundatime);
						$(".dingdan_content_xiang p:nth-of-type(2) span:nth-of-type(13)").html(_json_xiang.resultCode.zhuangchetime);
					};
					for(var i = 0; i < _json_xiang.resultCode.data.length; i++) {
						var _dem01 = $("ul li").eq(0).clone().removeClass("hidden").appendTo("ul");
						_dem01.find("div:nth-of-type(1) p:nth-of-type(1) span").html(_json_xiang.resultCode.data[i].shebeibianhao);
						_dem01.find("div:nth-of-type(1) p:nth-of-type(2) span").html(_json_xiang.resultCode.data[i].maxtemperature01 + "℃");
						_dem01.find("div:nth-of-type(2) p:nth-of-type(1) span").html(_json_xiang.resultCode.data[i].avgtemperature01 + "℃");
						_dem01.find("div:nth-of-type(2) p:nth-of-type(2) span").html(_json_xiang.resultCode.data[i].mintemperature01 + "℃");
					};
					$(".wait").addClass("hidden");
				} else {
					$(".content").html("未发现订单号：" + _danhao);
					$(".content").css({
						textAlign: "center",
						lineHeight: "5rem",
						fontSize: "2rem"
					});
					$(".wait").addClass("hidden");
				}
			},
			error: function() {
				alert("网络错误，请刷新页面或重新进入");
				$(".wait").addClass("hidden");
			}
		});
		$(".back_list").on("click",function(){
			window.location.href="dingdan.php"
		})
	} else {
		$(".back_list").on("click",function(){
			window.location.href="../index.html"
		})
		$.ajax({
			type: "post",
			url: "http://ccsc58.com/json/13_02_tb_yundan_return.php",
			data: {
				admin_permit: "zjly8888",
				UserP: "w",
				admin_user: _userName,
				admin_pass: _userPass,
			},
			success: function(data) {
				var _json = JSON.parse(data);
				if(_json.message == "success" && _json.data != "") {
					var _length = _json.data.length;
					var _ding = [];
					var _xiaLaKuang = "";
					for(var i = 0; i < _length; i++) {
						var _dem = $(".dingdan_content").eq(0).clone().removeClass("hidden").appendTo(".content");
						_dem.find("p:nth-of-type(1) span").html(_json.data[i].danhao);
						_dem.find("p:nth-of-type(2) span:nth-of-type(1)").html(_json.data[i].yewudanhao == "" ? "暂无" : _json.data[i].yewudanhao);
						_dem.find("p:nth-of-type(2) span:nth-of-type(2)").html(_json.data[i].pinming == "" ? "暂无" : _json.data[i].pinming);
						_dem.find("p:nth-of-type(2) span:nth-of-type(3)").html(_json.data[i].yaopinshuliang == "" ? "暂无数据" : _json.data[i].yaopinshuliang);
						_dem.find("p:nth-of-type(2) span:nth-of-type(4)").html(_json.data[i].createtime);
						if(_json.data[i].state == 2) {
							_dem.find("img").removeClass("hidden");
						} else {
							_dem.find(".weiWanCheng").removeClass("hidden")
						}
						_ding.push(_json.data[i].danhao);
						_xiaLaKuang += "<p class=\"hidden\" value=" + _json.data[i].danhao + ">" + _json.data[i].danhao + "</p>";
					}
					$(".search_dingdan div").html(_xiaLaKuang);
					$(".wait").addClass("hidden");
					/*订单详情入口点击事件；
					 */
					$(".dingdan_content form input").on("click", function() {
						var _dingdan = $(this).parents(".dingdan_content").find("p:nth-of-type(1) span").html();
						window.location.href = "dingdan_xiang.html?danhao=" + _dingdan;
					});
					/*搜索功能代码；
					 */
					var _x = 0
					$(".header img:nth-of-type(2)").on("click", function() {
						if(_x == 0) {
							$(".search_dingdan").animate({
								height: "100vh"
							}, 500);
							_x = 1
						} else {
							$(".search_dingdan").animate({
								height: "0vh"
							}, 500);
							_x = 0
						}
					});
					$(".search_dingdan input[type=button]").on("click", function() {
						var _search_dan = $(this).prev().prev().val().replace(/\s*/g,"");
						var _mark = 0
						if(_search_dan == "") {
							alert("搜索内容不能为空");
						} else {
							for(var i = 0; i < _ding.length; i++) {
								if(_search_dan == _ding[i]) {
									_mark = _ding[i];
								}
							}
							if(_mark != 0) {
								window.location.href = "dingdan_xiang.html?danhao=" + _mark;
							} else {
								alert("未找到该订单，请仔细核实订单号")
							}
						}
					});
					/*下拉框的隐藏*/
					/*$(".search_dingdan input[type=text]").on("blur",function(){
						$(".search_dingdan div").addClass("hidden");
					});*/
					/*搜索框搜索时的代码编辑*/
					$(".search_dingdan input[type=text]").on("input", function() {
						$(".search_dingdan div").removeClass("hidden");
						var _thisVal = $(this).val();
						if(_thisVal == "") {
							$(".search_dingdan div").find("p").addClass("hidden");
							$(".search_dingdan div").addClass("hidden");
							return;
						}
						$(".search_dingdan div").find("p").addClass("hidden");
						for(var i = 0; i < _ding.length; i++) {
							if(_ding[i].indexOf(_thisVal) != -1) {
								$(".search_dingdan div").find("p").eq(i).removeClass("hidden");
								var _tiHuan = $(".search_dingdan div").find("p").eq(i).attr("value").replace(_thisVal, "<span>" + _thisVal + "</span>");
								$(".search_dingdan div").find("p").eq(i).html(_tiHuan);
							}
						}
					});
					/*点击下拉菜单事件*/
					$(".search_dingdan div p").on("click", function() {
						$(".search_dingdan input[type=text]").val($(this).attr("value"));
						$(".search_dingdan div").addClass("hidden");
					});
				} else {
					$(".content").html("未发现订单");
					$(".content").css({
						textAlign: "center",
						lineHeight: "5rem",
						fontSize: "2rem"
					});
					$(".wait").addClass("hidden");
				}
			},
			error: function() {
				alert("网络错误，请刷新页面或重新进入");
				$(".wait").addClass("hidden");
			}
		});
	};

})