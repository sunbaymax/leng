<?php

define("TOKEN", "weixin");
header("Access-Control-Allow-Origin: *");
$openid=$_GET['openid'];
$servername = "rm-2ze3o57ph836pk46r.mysql.rds.aliyuncs.com";
$username = "test01";
$password = "Pzg790915";
$dbname = "wlgl";
 
// 创建连接
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("连接失败: " . mysqli_connect_error());
}


$sql = "SELECT * FROM tb_weixin_user where openid='$openid'";

$result = mysqli_query($conn, $sql);
 
if (mysqli_num_rows($result) > 0) {
    // 输出数据
    while($row = mysqli_fetch_assoc($result)) {
//      var_dump($row);
//      print_r(json_encode($row));
        $arr=$row;
	    if(empty($arr)){
		   	echo json_encode(array('code' => '400','msg' => '没有查询到结果!'));die;
		   }else{
		   	echo json_encode(array('code' => '200','data' => $arr));die;
		   }
    }
} else {
    echo json_encode(array('code' => '400','msg' => '没有查询到结果!'));die;
}
 
mysqli_close($conn);

?>