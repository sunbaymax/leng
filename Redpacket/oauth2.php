<?php
if (isset($_GET['code'])){
			$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx82dbac04fa8fd8ef&secret=98ecda31265ffc327d59adc969089650&code=".$_GET['code']."&grant_type=authorization_code";
		    $result=https_request($url);
			$arr=json_decode($result,true);
			$openId=$arr['openid'];
			header('location:index.php?openId='.$openId);
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
