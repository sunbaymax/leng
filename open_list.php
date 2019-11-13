<?php
header("content-type:text/html;charset=utf-8");
require_once('lengyun_kj.php');
$weixin = new class_weixin_adv("wx029d1989acb9f44c", "b7a482220530d3be2278429bdf2a7a63");
require_once('mysql_class.php');
$db=new ClassMysql();

$userlist=$weixin->get_user_list();
for($i=0;$i<count($userlist["data"]["openid"]);$i++){
	$openid=$userlist["data"]["openid"][$i];
	$mysql_state="insert into tb_weixin_user (openid) values('".$openid."');";
	$result=$db->query($mysql_state);
	
}


?>