<?php
header("Access-Control-Allow-Origin: *");

$postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");



//{{first.DATA}}
//设备号：{{keyword1.DATA}}
//告警时间：{{keyword2.DATA}}
//告警级别：{{keyword3.DATA}}
//告警模块：{{keyword4.DATA}}
//事件描述：{{keyword5.DATA}}
//{{remark.DATA}}
//--------温度报警消息推送----------------//
function Tui_song($first,$keyword1,$keyword2,$keyword3,$keyword4,$keyword5,$remark,$openId,$app_key,$keyword6)
{
    //$keyword5='\n'.$keyword5.'\n';
    $first=$first.'\n\n设备编号：'.$keyword1;
    $keyword2=$keyword2.'\n详情描述：'.$keyword5;

    if($app_key== "261AFF68C0E9F076420D083D66222824"){
        $template=array(
            'touser'=>"$openId",
            'template_id'=>"zL41XN2WuflVXGVdKmu_ThLrbILzBRvW84L7JkjnVGM",
//          'url'=>"http://www.ccsc58.cc/weixinnew/html/warning_list.html,
            'url'=>"http://www.ccsc58.cc/leng/FreshShield/html/details_lists.html?num_m=".$keyword6."&",
            'topcolor'=>"#7B68EE",
            'data'=>array('first'=>array('value'=>urlencode($first),'color'=>"#000",),
                'keyword1'=>array('value'=>urlencode($keyword3),'color'=>"#ff0000",),
                'keyword2'=>array('value'=>urlencode($keyword4),'color'=>"#000",),
                'keyword3'=>array('value'=>urlencode($keyword2),'color'=>"#000",),
                'remark'=>array('value'=>urlencode($remark),'color'=>"#0000ff"),
            )
        );
        $url="http://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
        $result=https_request($url,urldecode(json_encode($template)));
        echo($result);
    }
}
//-------设备到期服务提醒---------------//
function Tui_expiration($first,$keyword1,$keyword2,$keyword3,$remark,$openId)
{
    $first=$first.'\n\n缴费金额：'.$keyword3;

        $template=array(
            'touser'=>"$openId",
            'template_id'=>"MB2YmsYRvtEXIFfxO5lnZ3Cbm9AeIlA1OwJsZg3a9ig",
            'url'=>"http://www.ccsc58.cc/leng/FreshShield/html/buyflewpackage.html?num_m=".$keyword1,
            'topcolor'=>"#7B68EE",
            'data'=>array('first'=>array('value'=>urlencode($first),'color'=>"#000",),
                'keyword1'=>array('value'=>urlencode($keyword1),'color'=>"#000",),
                'keyword2'=>array('value'=>urlencode($keyword2),'color'=>"#ff0000",),
                'remark'=>array('value'=>urlencode($remark),'color'=>"#000"),
            )
        );
        $url="http://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
        $result=https_request($url,urldecode(json_encode($template)));
        echo($result);
    
}
//定时推送温度消息模板
function Tui_temphumMsg($first,$keyword1,$keyword2,$keyword3,$keyword4,$keyword5,$remark,$openId)
{
        $template=array(
            'touser'=>"$openId",
            'template_id'=>"3lCw6P8cyvGDOPDKLIjC0yz2KR0H62l-cOn3nEtX5oc",
            'url'=>"",
            'topcolor'=>"#7B68EE",
            'data'=>array('first'=>array('value'=>urlencode($first),'color'=>"#000",),
                'keyword1'=>array('value'=>urlencode($keyword1),'color'=>"#000",),
                'keyword2'=>array('value'=>urlencode($keyword2),'color'=>"#000000",),
                'keyword3'=>array('value'=>urlencode($keyword3),'color'=>"#000000",),
                'keyword4'=>array('value'=>urlencode($keyword4),'color'=>"#000000",),
                'keyword5'=>array('value'=>urlencode($keyword5),'color'=>"#000000",),
                'remark'=>array('value'=>urlencode($remark),'color'=>"#000"),
            )
        );
        $url="http://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
        $result=https_request($url,urldecode(json_encode($template)));
        echo($result);
    
}
//维修工单用户确认
function isrepairorder($first,$keyword1,$keyword2,$keyword3,$keyword4,$remark,$openId)
{
        $template=array(
            'touser'=>"$openId",
            'template_id'=>"oVRk4lOt8s3XO8E_OXuAgL1nnUkppXBusvVnqR-loZI",
            'url'=>"http://www.ccsc58.cc/IceKnight/Zlservices/descrepair.html?id=".$remark."&openId=".$openId,
            'topcolor'=>"#7B68EE",
            'data'=>array('first'=>array('value'=>urlencode($first),'color'=>"#000",),
                'keyword1'=>array('value'=>urlencode($keyword1),'color'=>"#000",),
                'keyword2'=>array('value'=>urlencode($keyword2),'color'=>"#000000",),
                'keyword3'=>array('value'=>urlencode($keyword3),'color'=>"#000000",),
                'keyword4'=>array('value'=>urlencode($keyword4),'color'=>"#000000",),
                'remark'=>array('value'=>urlencode(''),'color'=>"#000"),
            )
        );
        $url="http://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
        $result=https_request($url,urldecode(json_encode($template)));
        echo($result);
    
}
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
	$arr = array();
	foreach($_POST as $v)
	{
	    $arr[] = $v;
	}
	if(count($arr)==10){
		Tui_song($arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5],$arr[6],$arr[7],$arr[8],$arr[9]);
	}else if(count($arr)==8){
		Tui_temphumMsg($arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5],$arr[6],$arr[7]);
	}else if(count($arr)==7){
		isrepairorder($arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5],$arr[6]);
	}else if(count($arr)==6){
		Tui_expiration($arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5]);
	}else{
		 var_dump("aa");
	}

function getAccessToken(){
    $url = "http://www.zjcoldcloud.com/weixin/get_token_zlkj.php";
    $access_token=file_get_contents($url);
    return $access_token;
}

function get_php_file($filename) {
    return trim(substr(file_get_contents($filename), 15));
}

function set_php_file($filename, $content) {
    $fp = fopen($filename, "w");
    fwrite($fp, "<?php exit();?>
" . $content);
fclose($fp);
}
