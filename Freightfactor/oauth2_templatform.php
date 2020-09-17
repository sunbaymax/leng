<?php
if (isset($_GET['code'])){
			$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxc5d96b83a272e5cb&secret=b35c8397afd0395906de1fe8af7542cf&code=".$_GET['code']."&grant_type=authorization_code";
		    $result=https_request($url);
			$arr = json_decode($result,true);
			$openId=$arr['openid'];
			header('location:html/register.html?openId='.$openId);
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
<!--https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxc5d96b83a272e5cb&redirect_uri=http://www.ccsc58.cc/leng/Freightfactor/oauth2_templatform.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect
sso.dinghuo123.com-->