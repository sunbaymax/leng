<?php

header("Content-Type: text/html; charset=utf-8");
header("Access-Control-Allow-Origin: *");//解决跨域问题
$conn=mysql_connect("localhost","test01","Pzg790915");
mysql_select_db("wlgl",$conn);
mysql_query("set names utf-8");
$dsn = "mysql:host=120.55.186.125;dbname=wlgl";
$db = new PDO($dsn, 'test01', 'Pzg790915');
$db->exec('set names utf8'); 

$tel = rtrim($_POST['tel'],',');

$arr = explode(',',$tel);
foreach($arr as $key => $val){
	$str=trim($val);
	$ar[]=substr($str,0,11);
	//preg_match('/\w{0,}/',$val,$str);
	//var_dump($str);
}//die;

$str=implode(",",$ar);

$sql = "select openid, name,touxiang,company from weixin_userinfo where tel in ($str)";
$data = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
//var_dump($data);die;
if(empty($data)){
    echo json_encode(array('code'=>30000,'mem'=>'暂无数据'));
}else{
    echo json_encode(array('code'=>10000,'mem'=>'请求成功','data'=>$data));
}

