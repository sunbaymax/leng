/*判断收件地址*/
var linkaddress = 'addresslibs.html' + window.location.search;
console.log(linkaddress)
var _openid = sessionStorage.getItem('openid');

if(JSON.parse(sessionStorage.getItem('alink'))) {
	var _alink = JSON.parse(sessionStorage.getItem('alink'));
	var str = `<p>收货人：<span class="username" idi='${_alink.id}'>${_alink.name}</span><span class="telphone">${_alink.tel}</span></p>
				<p class="address">${_alink.address}</p><a href='${linkaddress}'><img src="../img/right_shop_car.png" /></a>`
	$('.shouHuoDi').append(str)
} else {
	getFaMsg(_openid)
}
//获取后台发件人默认取件人信息
function getFaMsg(_openid) {

	$.ajax({
		url: "http://www.ccsc58.com/json/shopping/address.php",
		type: "post",
		data: {
			action: 'selDefault',
			openid: _openid
		},
		dataType: "JSON",
		success: function(obj) {
			console.log(obj);
			if(obj.code == 1) {
				var str = `<p><a class="mui-navigate-right noaddress" href='${linkaddress}'>+新建收货地址</a></p><img src="../img/right_shop_car.png" />`
				$('.shouHuoDi').append(str)
			} else {
				var str = `<p>收货人：<span class="username" idi='${obj.data.id}'>${obj.data.username}</span><span class="telphone">${obj.data.phone}</span></p>
				<p class="address">${obj.data.province} ${obj.data.city} ${obj.data.county} ${obj.data.street}</p><a href='${linkaddress}'><img src="../img/right_shop_car.png" /></a>`
				$('.shouHuoDi').append(str)
			}
		},
		error: function(res) {
			console.log(res)
		}
	});
}
/*返回购物车*/
$(".back_list").on("click", function() {
	window.location.href = "shop_car.html";
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

var pay_goods;
$(".footer_right").on("click", function() {
//	console.log($(this).prev().find("span").html().replace("合计：￥", ""));
//	console.log($(this).parent().prev().children('.shouHuoDi').find('.username').attr('idi'));
	var addressid = $(this).parent().prev().children('.shouHuoDi').find('.username').attr('idi');
	var _linkuser = $(this).parent().prev().children('.shouHuoDi').find('.username').text();
	var _linkusertel = $(this).parent().prev().children('.shouHuoDi').find('.telphone').text();
	var _backup= $(this).parent().prev().children('.liuYan').children('.backup').val();
	var everygood={};
	pay_goods=[];
    $.each($(this).parent().prev().children('ul').find('li'), function() {
//  	console.log($(this).children('.li_middle').children('p:first-child').text(),1)
//  	console.log($(this).children('.li_middle').children('p:nth-child(2)').text())
//  	console.log($(this).children('.li_right').children('p:first-child').text())
//  	console.log($(this).children('.li_middle').find('._total').text(),4)
    	everygood = {
			devicename: $(this).children('.li_middle').children('p:first-child').text(),
			devicetype: $(this).children('.li_middle').children('p:nth-child(2)').text(),
			total: $(this).children('.li_middle').find('._total').text(),
			Price: $(this).children('.li_right').children('p:first-child').text(),
		}
    	pay_goods.push(everygood);
    });
    sessionStorage.setItem("paygoods", JSON.stringify(pay_goods));
    var payinfo={
    	address_id:addressid,
    	linkuser:_linkuser,
    	linkusertel:_linkusertel,
    	backup:_backup,
    	pay_money:$(this).prev().find("span").html().replace("合计：￥", "")
    }
    sessionStorage.setItem("payinfo", JSON.stringify(payinfo));
	window.sessionStorage.setItem("pay_money", $(this).prev().find("span").html().replace("合计：￥", ""))
	window.location.href = "../../leng/weixin/zhifu/example/shop_ispay.html";
});
//console.log("http://www.ccsc58.cc/weixinnew/new/example/jsapi.php?total=1&mao="++total=1&mao=%E4%BD%A0%E5%A5%BD+&code=021ea85F1unTo200xH5F1g6Z4F1ea854&state=STATE".match(/\&mao=\S+\+total=/)[0].replace("&mao=","").replace("+total=",""))