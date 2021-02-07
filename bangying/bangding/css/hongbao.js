$(".yanZhengMa").on("click",function(){
	$(this).html("60s");
	//console.log($(this).html().replace("s",""));
	setTimeout(my_Time,1000)
});
function my_Time(){
	var _old=$(".yanZhengMa").html().replace("s"," ");
	if(_old==0){
		$(".yanZhengMa").html("获取验证码");
	}else{
		$(".yanZhengMa").html((_old-1)+"s");
		setTimeout(my_Time,1000);
	}
	
}
