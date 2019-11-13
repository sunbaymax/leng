$(document).ready(function() {
	myChang();

	function myChang() {
		$(".wait span").animate({
			width: "2rem"
		}, 1000, myDuan)
	};

	function myDuan() {
		$(".wait span").animate({
			width: "0rem"
		}, 10, myChang);
	};
	window.alert = function(name) {
		var iframe = document.createElement("IFRAME");
		iframe.style.display = "none";
		iframe.setAttribute("src", 'data:text/plain,');
		document.documentElement.appendChild(iframe);
		window.frames[0].window.alert(name);
		iframe.parentNode.removeChild(iframe);
	}

	window.confirm = function (message) {
            var iframe = document.createElement("IFRAME");
            iframe.style.display = "none";
            iframe.setAttribute("src", 'data:text/plain,');
            document.documentElement.appendChild(iframe);
            var alertFrame = window.frames[0];
            var result = alertFrame.window.confirm(message);
            iframe.parentNode.removeChild(iframe);
            return result;
    };
	$('input').blur(function() {
		$('body,html').animate({
			scrollTop: 0
		}, 0);
	})

})