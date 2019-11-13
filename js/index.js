$(document).ready(function() {
	myChang();
	function myChang() {
		$(".wait span").animate({
				width: "2rem"
			}, 1000,myDuan)
	};
	function myDuan(){
		$(".wait span").animate({
				width: "0rem"
			}, 10,myChang);
	}
})