<?php
$tel = $_POST['tel'];

$url = "http://www.ccsc58.com/SMS/SMS-telephone.php?telephone=".$tel."&action=call&admin_permit=zjly8888";
        include "Http.class.php";
        $res = substr(Http::get($url),0,7);
        if($res == 'success'){
        	$arr = array('status' => 1, 'info' => '发送成功');
        	echo json_encode($arr);
        }else{
            $arr = array('status' => 0, 'info' => '验证码不正确');
        	echo json_encode($arr);
        }