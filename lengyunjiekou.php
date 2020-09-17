<?php
header("Access-Control-Allow-Origin: *");

$postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");

function Tui_song($first,$keyword1,$keyword2,$keyword3,$keyword4,$keyword5,$remark,$openId,$app_key,$keyword6)
{
    $first=$first.'\n\n设备编号：'.$keyword1;
    $keyword2=$keyword2.'\n详情描述：'.$keyword5;
    $remark='\n'.$remark;
    if($app_key== "261AFF68C0E9F076420D083D66222824"){
        $template=array(
            'touser'=>"$openId",
            'template_id'=>"J8Cdnh2cAXr-GuJpO6N8vzAp2sDrAPmhNjMnTTu0jQE",
            'url'=>"http://www.ccsc58.cc/weixinnew/html/warning_tui_rukou.html?num_m=".$keyword6."&",
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
    }
}
function jiankong($first,$keyword1,$keyword2,$keyword3,$remark,$openId,$app_key)
{
    $remark='\n'.$remark;
    
    if($app_key== "261AFF68C0E9F076420D083D66222824"){
        $template=array(
            'touser'=>$openId,
            'template_id'=>"OxWlQE5g7gcMRuXwWj6CzDBUEd3_s4ZytQqFDxxq3Pg",
            'url'=>"http://www.ccsc58.com/warning",
            'topcolor'=>"#7B68EE",
            'data'=>array('first'=>array('value'=>urlencode($first),'color'=>"#7B68EE",),
                'keyword1'=>array('value'=>urlencode($keyword1),'color'=>"#FF0000",),
                'keyword2'=>array('value'=>urlencode($keyword2),'color'=>"#C4C400",),
                'keyword3'=>array('value'=>urlencode($keyword3),'color'=>"#0000ff",),
                'remark'=>array('value'=>urlencode($remark),'color'=>"#008000"),
            )
        );
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
        $result=https_request($url,urldecode(json_encode($template)));
        var_dump($result);
    }
}
function xiafa_yzm($first,$keyword1,$keyword2,$remark,$openId,$app_key)
{
    if($app_key== "261AFF68C0E9F076420D083D66222824"){
        $template=array(
            'touser'=>$openId,
            'template_id'=>"T-gz6KxRVda5XQzeGAhG5fCRXPsOmBsn84XGUlQ8W6A",
            'url'=>"http://hr.ccsc58.cc",
            'topcolor'=>"#7B68EE",
            'data'=>array('first'=>array('value'=>urlencode('【中集冷云】你好，欢迎登录恒瑞医药平台'),'color'=>"#743A3A",),
                'keyword1'=>array('value'=>urlencode($keyword1),'color'=>"#FF0000",),
                'keyword2'=>array('value'=>urlencode($keyword2),'color'=>"#0000FF",),
                'remark'=>array('value'=>urlencode('请于30分钟内正确输入 ，若非本人操作，请忽略！'),'color'=>"#008000"),
            )
        );
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
        $result=https_request($url,urldecode(json_encode($template)));
        var_dump($result);
    }
}
function Pay_money($first,$keyword1,$keyword2,$keyword3,$keyword4,$remark,$openId,$app_key)
{
    if($app_key== "261AFF68C0E9F076420D083D66222824"){
        $template=array(
            'touser'=>$openId,
            'template_id'=>"BBslmzoFEYjyyNpXJZKWpbvu7WK_NeBAnxMLKbaQ1lc",
            'url'=>"http://www.ccsc58.cc/leng/pay_list.html",
            'topcolor'=>"#000000",
            'data'=>array('first'=>array('value'=>urlencode($first),'color'=>"#ff0000",),
                'keyword1'=>array('value'=>urlencode($keyword1),'color'=>"#743A3A",),
                'keyword2'=>array('value'=>urlencode("￥".$keyword2),'color'=>"#EC870E",),
                'keyword3'=>array('value'=>urlencode($keyword3),'color'=>"#0000ff",),
                'keyword4'=>array('value'=>urlencode($keyword4),'color'=>"#000",),
                'remark'=>array('value'=>urlencode($remark),'color'=>"#000",),
            )
        );
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
        $result=https_request($url,urldecode(json_encode($template)));
        echo $result;
    }
}
function zhongjiang($first,$keyword1,$keyword2,$keyword3,$remark,$openId,$app_key)
{
	$remark='\n'.$remark;
    if($app_key== "261AFF68C0E9F076420D083D66222824"){
        $template=array(
            'touser'=>$openId,
            'template_id'=>"lnUaS-jkwaIDbHBCsy_gkU7PPBVm9Fd1igq4kx4me2U",
            'url'=>"",
            'topcolor'=>"#000000",
            'data'=>array('first'=>array('value'=>urlencode('恭喜'.$first.'您，中奖了！'),'color'=>"#0000FF",),
                'keyword1'=>array('value'=>urlencode('2018年北京中集年会抽奖现场'),'color'=>"#743A3A",),
                'keyword2'=>array('value'=>urlencode('20180120期'),'color'=>"#008000",),
                'keyword3'=>array('value'=>urlencode($keyword3),'color'=>"#FF0000",),
                'remark'=>array('value'=>urlencode('再次感谢您对公司的付出和支持，本消息仅为中奖凭证,确切的需要跟工作人员核实,希望中奖者尽快到处后台领取奖品。  特此通知！'),'color'=>"#000",),
            )
        );
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
        $result=https_request($url,urldecode(json_encode($template)));
         var_dump($result);
    }
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
	}elseif(count($arr)==8){
		 Pay_money($arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5],$arr[6],$arr[7]);
	}elseif(count($arr)==7){
		 zhongjiang($arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5],$arr[6]);
	}else if(count($arr)==6){
		 xiafa_yzm($arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5]);
	}else{
		 Pay_money($arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5],$arr[6],$arr[7]);
	}


//用户关注后向客户推送；
function getAccessToken() {
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
