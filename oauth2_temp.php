<?php
if (isset($_GET['code'])){
			$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx029d1989acb9f44c&secret=b7a482220530d3be2278429bdf2a7a63&code=".$_GET['code']."&grant_type=authorization_code";
		    $result=https_request($url);
			$arr = json_decode($result,true);
			$openId=$arr['openid'];
			//echo "<script type=\"text/javascript\">location.href=\"register.html?openId=".$openId."\"</script>";
			header('location:rukou.html?openId='.$openId);
		   
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
