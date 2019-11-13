<?php
	include 'WxPay.php';
	$openId=array_pop(explode('=',$_GET['openId']));
	var_dump($openId);
	//die();
	$money=rand(100,150);
	$sender='冷云科技';
	$obj2=array();
	$obj2['wxappid']='wx029d1989acb9f44c';
	$obj2['mch_id']='1455926602';
	$obj2['mch_billno']='1455926602'.date('YmiHis').rand(1000,100);
	$obj2['client_ip']=$_SERVER['REMOTE_ADDR'];
	$obj2['re_openid']=$openId;
	$obj2['total_amount']=$money;
	$obj2['min_value']=$money;
	$obj2['max_value']=$money;
	$obj2['total_num']=1;
	$obj2['nick_name']=$sender;
	$obj2['send_name']=$sender;
	$obj2['wishing']='感谢您的信任，恭喜发财💰';
	$obj2['act_name']=$sender;
	$obj2['remark']=$sender;
	var_dump($obj2);
	$url='https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
	$wxHongBaoHelper2 = new WxPay();
	$result=$wxHongBaoHelper2->pay($url,$obj2);
	//var_dump($result);
	$p = xml_parser_create();
	xml_parse_into_struct($p, $result, $vals, $index);
	xml_parser_free($p);
	
	foreach($vals as $key => $vals){
		if($vals['tag'] == 'RESULT_CODE'){
			if($vals['value']=='SUCCESS'){
				header('location:index.php?openId=zjly');
			}else{
				header('location:index.php?openId=zjly01');
			};
		}
	}
?>