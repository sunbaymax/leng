/*返回购物车*/
$(".back_list").on("click", function() {
	window.location.href = "shop_car.html"
});
var _zongJia = window.location.href.match(/\?zongjia=\S+/)[0].replace("?zongjia=", "").replace(window.location.href.match(/\&shuLiang=\S+/)[0], "");
var _shuLiang = window.location.href.match(/\&shuLiang=\S+/)[0].replace("&shuLiang=", "");
$(".footer_left span").html("合计：￥" + _zongJia);
/*添加从购物车传过来的*/
var _html = "";
for(var i = 0; i < _shuLiang; i++) {
	_html += "<li>";
	_html += window.sessionStorage.getItem("jiesuan" + i) + "</li>";
	//console.log(i);
}
$("ul").html(_html);
$(".li_middle p:nth-of-type(3) span:nth-of-type(1)").html("x")
	/*积分的算法代码*/
$(".jiFen input").on("click", function() {
		if($(this).is(":checked")) {
			var _jiFenHou = Number($(".footer_left span").html().replace("合计：￥", "")) - Number($(this).prev().attr("jifen"));
			if(_jiFenHou <= 0) {
				$(this).prop("checked", false)
				alert("积分暂时无法使用");
			} else {
				$(".footer_left span").html("合计：￥" + (_jiFenHou).toFixed(2));
			}
		} else {
			var _jiFenHou = Number($(".footer_left span").html().replace("合计：￥", "")) + Number($(this).prev().attr("jifen"));
			$(".footer_left span").html("合计：￥" + (_jiFenHou).toFixed(2));
		}
	})
	/*结算按钮的跳转*/
$(".footer_right").on("click", function() {
	console.log($(this).prev().find("span").html().replace("合计：￥", ""));
	window.sessionStorage.setItem("pay_money", $(this).prev().find("span").html().replace("合计：￥", ""))
	window.location.href = "../payweixin/example/money.html";
});
//console.log("http://www.ccsc58.cc/weixinnew/new/example/jsapi.php?total=1&mao="++total=1&mao=%E4%BD%A0%E5%A5%BD+&code=021ea85F1unTo200xH5F1g6Z4F1ea854&state=STATE".match(/\&mao=\S+\+total=/)[0].replace("&mao=","").replace("+total=",""))
