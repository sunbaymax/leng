<?php
	$post = $_POST;
$url = "http://www.ccsc58.com/SMS/SMS-telephone.php?telephone=".$post['phone']."&action=bijiao&admin_permit=zjly8888&yanzhengmas=".$post['messageCode'];
                include 'Http.class.php';
                if($post['phone'] && \Http::get($url)){
                	$arr = array('status' => 1, 'info' => '验证成功');
                	echo json_encode($arr);
                }else{
                	$arr = array('status' => 0, 'info' => '验证码不正确');
                	echo json_encode($arr);
                }
