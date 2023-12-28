<?php
if (isset($_GET['code'])){
			$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx1309f0a02d6becbc&secret=70eeb6b0c22a784f39f018ede8cab64a&code=".$_GET['code']."&grant_type=authorization_code";
		   $result=https_request($url);
			$arr = json_decode($result,true);
			$openId=$arr['openid'];
			
			//echo "<script type=\"text/javascript\">location.href=\"http://www.linke58.com/wechat/WxchatPublicP/html/login.html?openid=".$openId."\"</script>";
			echo "<script type=\"text/javascript\">location.href=\"http://www.linke58.com/hly/bangding.html?openId=".$openId."\"</script>";
			//header('Location: http://www.linke58.com/wechat/WxchatPublicP/html/login.html?openid='.$openId);
			echo $openId;
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
