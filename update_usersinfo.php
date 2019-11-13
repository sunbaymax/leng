<?php
header("content-type:text/html;charset=utf-8");
require_once('lengyun_kj.php');
$weixin = new class_weixin_adv("wx029d1989acb9f44c", "b7a482220530d3be2278429bdf2a7a63");
require_once('mysql_class.php');
$db=new ClassMysql();

$mysql_state="select * from tb_weixin_user where subscribe=''limit 0,1";
//var_dump($mysql_state);
$result=$db->query_array($mysql_state);
//var_dump($result);
$sexes=array("","男","女");
if(count($result)>0){
	$openid=$result[0]["openid"];
//	var_dump($openid);
	$info=$weixin->get_user_info($openid);
	//var_dump($info);
	$mysql_state2="update tb_weixin_user set
	subscribe='".$sexes[$info['subscribe']]."',
    sex='".$sexes[$info['sex']]."',
	country='".$info['country']."',
	province='".$info['province']."',
	city='".$info['city']."',
	headimgurl='".$info['headimgurl']."',
	subscribe_time='".$info['subscribe_time']."' 
	where openid='".$openid."';";
	var_dump($mysql_state2);
	$result=$db->query($mysql_state2);
	//var_dump($result);
	$mysql_state3="update tb_weixin_user set nickname='".$info['nickname']."' where openid='".$openid."';";
	$result=$db->query($mysql_state3);
	echo "<script language =javascript>location.replace(location.href);</script>";
}else{
	echo "over";
}

?>