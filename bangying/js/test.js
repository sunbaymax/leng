var _userName = window.localStorage.getItem("user");
var _userPass = window.localStorage.getItem("pass");
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
			if(_json.code == "10000" && _json.message == "success" & _json.resultCode[0].shebeibianhao != "") {
				for(var i = 0; i < _json.resultCode.length; i++) {
					var _dem = $(".scroller ul li").eq(0).clone().removeClass("hidden").appendTo(".scroller ul");
					_dem.find("div:nth-of-type(1) span").html(_json.resultCode[i].shebeibianhao);
					_dem.find("div:nth-of-type(2) span").html(_json.resultCode[i].qidongshijian);
					_dem.find("div:nth-of-type(3) span").html(_json.resultCode[i].tingzhishijian);
				};
			myscroll.refresh();
			} else {
				$(".ajax_more a").html("未发现更多设备");
				$(".wait").addClass("hidden");
				myscroll.refresh();
				$(".more").html('没有更多数据了').css({
					color:"#ccc"
				});
			}			
		},
		error: function() {
			alert("网络错误！")
			window.location.href = window.location.href;
		}
	});
}