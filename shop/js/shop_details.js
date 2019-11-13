/*返回设备列表*/
$(".back_list").on("click", function() {
	window.location.href = "shop.html"
})
/*增加和减少数量的函数*/
;
$(".dingdan_tanchuang_bottom span:nth-of-type(1)").on("click", function() {
	var _shuLiang = $(this).next().html();
	if(_shuLiang > 1) {
		$(this).next().html(Number(_shuLiang) - 1);
		if($(this).next().html() == 1) {
			$(this).addClass("color");
		}
	}
});
$(".dingdan_tanchuang_bottom span:nth-of-type(3)").on("click", function() {
	var _shuLiang = $(this).prev().html();
	$(this).prev().html(Number(_shuLiang) + 1);
	if($(this).prev().html() > 1) {
		$(this).prev().prev().removeClass("color");
	}
});
/*规格选定后的点击确定的函数*/
//规格：&nbsp;&nbsp;&nbsp;&nbsp;白色 &nbsp;&nbsp;1台&nbsp;&nbsp;
$(".dingdan_tanchuang input").on("click", function() {
	var _guiGe = "规格：&nbsp;&nbsp;"
	_guiGe += $(".choose_color").html();
	_guiGe += $(".dingdan_tanchuang_bottom span:nth-of-type(2)").html() + "台&nbsp;&nbsp <span style='color:#5ED9EF'>已选 &radic;</span><img src='../img/right_shop_car.png'/>";
	$(".shop_guige").html(_guiGe);
	$(".dingdan_guige").animate({
		height: "0vh"
	}, 100);
//	toastr.error("请输入正确的手机号");
})
/*选择颜色是的切换*/
$(".dingdan_tanchuang_middle span").on("click", function() {
	if($(this).index() != 2) {
		$(".dingdan_tanchuang_middle span").removeClass("choose_color");
		$(this).addClass("choose_color");
		console.log($(this).index())
		if($(this).index() == 1) {
			$(".dingdan_tanchuang_top .pay_money").html('888');
			$(".dingdan_tanchuang_top p .goods_desc").html('官方配件+U盘报告导出');
		} else {
			$(".dingdan_tanchuang_top .pay_money").html('360');
			$(".dingdan_tanchuang_top p .goods_desc").html('官方配件');
		}
	} else {
		alert("租赁或定制请联系客服：18911910456")
	}

})
/*选取规格和数量的函数*/
$(".shop_guige").on("click", function() {
	$(".dingdan_guige").animate({
		height: "100vh"
	}, 500);
});
$(".chacha_shop").on("click", function() {
	$(".dingdan_guige").animate({
		height: "0vh"
	}, 500);
});
/*加入购物车的按钮及飞入购物车动画效果*/
if(JSON.parse(sessionStorage.getItem('cargoods'))) {
	var goods = JSON.parse(sessionStorage.getItem('cargoods'));
	console.log(goods);
} else {
	//var goods = [];
	
	
	var goods = [];
}
$(".shop_car_button").on("click", function() {
	if($(".shop_guige").html().indexOf("台") == -1) {
		$(".dingdan_guige").animate({
			height: "100vh"
		}, 500);
	} else {
		$(".shopCar_play").css({
			opacity: "1",
			webkitAnimation: "Playfire 1s ease 0s 1 normal"
		});
		/*$(".shopCar_play").animate({
			display:"none"
		},1000)*/
		setTimeout(function() {
			$(".shopCar_play").css({
				animation: "",
				opacity: "0"
			});
			$(".add_car_success").css({
				display: "block",
				webkitAnimation: "success_form 2s ease-out 0s 1"
			});
			setTimeout(function() {
				$(".add_car_success").css({
					webkitAnimation: "",
					display: "none"
				});
				$(".car_shu").html(Number($(".car_shu").html()) + 1);
			}, 1000)
		}, 500)
		var everygood = {};
		var img_src = $(".left img").attr("src");
		var chanpin = "ZL-TH10TP温湿度智能监控终端";
		var color = $(".choose_color").html();
		var _color = color.replace(/&nbsp;/ig, '');
		var total = $(".dingdan_tanchuang_bottom span:nth-of-type(2)").html();
		var danjia = $(".pay_money").html();
		var shu = $(".car_shu").html();
		everygood = {
			image_src: img_src,
			devicename: chanpin,
			devicetype: _color,
			total: total,
			Price: danjia,
		}
		var isGoods = true;
		for(var i = 0; i < goods.length; i++) {
			if(everygood.devicename == goods[i].devicename && everygood.devicetype == goods[i].devicetype) {
				goods[i].total = parseInt(goods[i].total) + parseInt(everygood.total);
				isGoods = false;
				break;
			}
		}
		if(isGoods) {
			goods.push(everygood);
		}
		sessionStorage.setItem("cargoods", JSON.stringify(goods));
	};
});

$(".shop_car .guanZhu:nth-of-type(2)").on("click", function() {
	window.location.href = "shop_car.html";
});