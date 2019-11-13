<?php
require_once('class/mysql.class.php');
$db = new class_mysql();
require_once('class/weixin.class.php');
$weixin = new class_weixin();

$mysql_state = "SELECT `id`,`openid`,`heartbeat` FROM `tp_user` WHERE `heartbeat` > ". (time() - 172800);
$result = $db->query($mysql_state);


$content = array();
$content[] = array("Title"=>"多图文1标题", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
$content[] = array("Title"=>"多图文2标题", "Description"=>"", "PicUrl"=>"http://d.hiphotos.bdimg.com/wisegame/pic/item/f3529822720e0cf3ac9f1ada0846f21fbe09aaa3.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
$content[] = array("Title"=>"多图文3标题", "Description"=>"", "PicUrl"=>"http://g.hiphotos.bdimg.com/wisegame/pic/item/18cb0a46f21fbe090d338acc6a600c338644adfd.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");

for($j = 0; $j < count($result); $j++)
{
    $openid = $result[$j]["openid"];
    $result = $weixin->send_custom_message($openid, "news", $content);
}

?>