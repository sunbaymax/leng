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
            'template_id'=>"l_bsfkIkd_oxa6ErE7FuDeVwjm7V3Hq_j5XQ3jQ87wA",
            'url'=>"http://www.ccsc58.cc/leng/laojiu/html/details_lists.html?num_m=".$keyword6."&",
            'topcolor'=>"#7B68EE",
            'data'=>array('first'=>array('value'=>urlencode($first),'color'=>"#000",),
                'keyword1'=>array('value'=>urlencode($keyword3),'color'=>"#ff0000",),
                'keyword2'=>array('value'=>urlencode($keyword4),'color'=>"#000",),
                'keyword3'=>array('value'=>urlencode($keyword2),'color'=>"#000",),
                'remark'=>array('value'=>urlencode($remark),'color'=>"#000"),
            )
        );
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
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
            'url'=>"",
            'topcolor'=>"#7B68EE",
            'data'=>array('first'=>array('value'=>urlencode($first),'color'=>"#000",),
                'keyword1'=>array('value'=>urlencode($keyword1),'color'=>"#000",),
                'keyword2'=>array('value'=>urlencode($keyword2),'color'=>"#ff0000",),
                'remark'=>array('value'=>urlencode($remark),'color'=>"#000"),
            )
        );
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
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


/*
     * 发送post请求
     * @param string $url 请求地址
     * @param array $arr post键值对数据
     * @return string
     */
function request_post($url, $arr=false) {

    //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    //curl_setopt($curl, CURLOPT_HEADER, 1);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //设置post方式提交
    curl_setopt($curl, CURLOPT_POST , 1);
    //设置post数据
    curl_setopt($curl, CURLOPT_POSTFIELDS, $arr);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($arr)
        )
    );
    //执行命令
    $data = curl_exec($curl);
    //关闭URL请求
    curl_close($curl);
    //显示获得的数据
    return $data;
}

	$arr = array();
	foreach($_POST as $v)
	{
	    $arr[] = $v;
	}
	if(count($arr)==10){
		Tui_song($arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5],$arr[6],$arr[7],$arr[8],$arr[9]);
	}else if(count($arr)==6){
		Tui_expiration($arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5]);
	}else{
		 var_dump("aa");
	}

function getAccessToken(){
    $url = "http://app.qilinke.cn/api/getAccessToken";
    $result = request_post($url);
    $token = json_decode($result, true)['data']['accessToken'];
    return $token;
}


