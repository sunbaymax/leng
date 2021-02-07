<?php
	//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe5ef4f921777c404&redirect_uri=http://www.ccsc58.cc/leng/yechuan/oauth2_templatform.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect
if (isset($_GET['code'])){
			$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx6ac3e32d22a450a7&secret=36028aa0c5eb5b848862c47d8bd6c99a&code=".$_GET['code']."&grant_type=authorization_code";
		    $result=https_request($url);
			$arr = json_decode($result,true);
			$openId=$arr['openid'];
			header('location:html/register.html?openId='.$openId);
}else{
    header('location:html/register.html?openId=123456');
};
function https_request($url,$data = null){
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
					curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
					if (!empty($data)){
						curl_setopt($curl, CURLOPT_POST, 1);
						curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
					}
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					$output = curl_exec($curl);
					curl_close($curl);
					return $output;
}
?>
