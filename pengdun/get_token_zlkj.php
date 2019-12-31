<?php
    header("Content-Type: text/html; charset=utf-8");
    header("Access-Control-Allow-Origin: *");//解决跨域问题
    //////////////////////////////////准备本地数据库
    $conn=mysql_connect("127.0.0.1","test","123456");
    $res = mysql_select_db("shield",$conn);
    $a = mysql_query("set names utf8",$conn);
function Curl(){
	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx80f7545ed03efa71&secret=a026334371c4bdfc1037ae492b44a3ab";
	$ch=curl_init();
	curl_setopt($ch,CURLOPT_TIMEOUT,5);
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
	$data=curl_exec($ch);
	curl_close($ch);
	$res=json_decode($data,true);
	//echo '<pre>';
	//print_r($res);die;
	return $res['access_token'];
}
function Serilizable(){
	global $conn;
	$appid="wx80f7545ed03efa71";
	$secret="a026334371c4bdfc1037ae492b44a3ab";
	$sql='select A_ID,A_Token,A_Date from tb_accesstoken_lykj order by A_ID desc';
	$rs=mysql_query($sql,$conn);
	$times=time();
	$row=mysql_fetch_array($rs);
	if($row==0){
		$timestamp=time()+6000;//每隔100分钟重新获取token
		$token=Curl();
		$sqlin="INSERT INTO `tb_accesstoken_lykj` (`A_Token`, `A_Date` , `A_Update`) VALUES ('".$token."', '".$timestamp."',0)";
		$res = mysql_query($sqlin,$conn);
		return $token;
	}else{
		if($row['A_Date']<$times){
			$token=Curl();
			$timestamp=time()+6000;
			$sqlu="UPDATE tb_accesstoken_lykj SET A_Token='".$token.",A_Date='".$timestamp."' WHERE (`A_ID`='".$row['A_ID']."')";
//			echo $sqlu;die;
			mysql_query($sqlu);
			return $token;
		}else{
			return $row['A_Token'];
		}
	}
}
	
	$token=Serilizable();
	echo $token;
	
	
	
	
	
	
