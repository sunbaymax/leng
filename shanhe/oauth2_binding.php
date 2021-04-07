<?php
	//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe5ef4f921777c404&redirect_uri=http://www.ccsc58.cc/leng/yechuan/oauth2_templatform.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect
if (isset($_GET['code'])){
			$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx196941ab02f4202e&secret=bdd88fe9b8b7506965bb6f317567e7a7&code=".$_GET['code']."&grant_type=authorization_code";
		    $result=https_request($url);
			$arr = json_decode($result,true);
			$openId=$arr['openid'];
			header('location:bangding/bangding.html?openId='.$openId);
}else{
    echo "NO CODE";
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
