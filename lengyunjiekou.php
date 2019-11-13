<?php
	header("Access-Control-Allow-Origin: *");
	$postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");  
	//$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
	//$postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
	if (!empty($postStr)){
    //libxml_disable_entity_loader(true);
    $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    $fromUsername = $postObj->FromUserName;
    $toUsername = $postObj->ToUserName;
    $RX_TYPE=trim($postObj->MsgType);

    $keyword = trim($postObj->Content);
    $time = time();

    $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
    $imageTpl=	"<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Image>
							<MediaId><![CDATA[%s]]></MediaId>
							</Image>
							</xml>";
    $newsTpl=	"<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<ArticleCount>1</ArticleCount>
							<Articles>
							<item>
							<Title><![CDATA[%s]]></Title>
							<Description><![CDATA[%s]]></Description>
							<PicUrl><![CDATA[%s]]></PicUrl>
							<Url><![CDATA[%s]]></Url>
							</item>
							</Articles>
						</xml>";
    if($RX_TYPE=="event")
    {
        $result=receiveEvent($postObj);
    }else{
        if(!empty( $keyword ))
        {
            if($keyword=="设备"||$keyword=="查询"||$keyword=="冷链"||$keyword=="绑定"||$keyword=="我的设备"||$keyword=="中集冷云"){
                $msgType = "text";
                $contentStr = "<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">我的设备</a>";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
	             	if($keyword=="天气"){
	             	$msgType = "text";
	                $contentStr = "请输入城市+天气\n如北京天气";
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                echo $resultStr;
	             	}else{
	             		$result=receiveText($postObj);
	             	}
	            	
	            }
            else if($keyword=="JdbJ"||$keyword=="京东报警"){
	                $msgType = "text";
	                $contentStr = "<a href=\"http://www.ccsc58.com/warning/\">京东报警</a>";
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                echo $resultStr;
	            }else{
                $msgType = "text";
                $contentStr = "您好！您可以回复以下内容：\n\n☞【下载】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">下载APP</a>\n\n☞【客服】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">客服电话</a>\n\n☞【说明书】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">产品说明书</a>\n\n☞【设备号】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">设备详情</a>\n\n☞【报警/异常】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">报警设备</a>\n\n☞【绑定/设备】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">绑定账号</a>\n\n☞【订单/我的订单】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">我的订单</a>\n\n客服电话:400-6507-168";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            };
        }else{
            echo "Input something...";
        };
    }
    
    echo $result;
};
function receiveEvent($object)
{
    $content = "";
    switch($object->Event)
    {
        case "subscribe":
            $content = "您好，欢迎关注中集冷云公众平台！/微笑\n\n请点击下方“中集冷云”按钮进行账号绑定\n请点击“关于我们”按钮下载相关APP\n\n您可以回复以下内容：\n\n☞【下载】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">下载APP</a>\n\n☞【客服】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">客服电话</a>\n\n☞【说明书】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">产品说明书</a>\n\n☞【设备号】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">设备详情</a>\n\n☞【报警/异常】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">报警设备</a>\n\n☞【绑定/设备】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">绑定账号</a>\n\n☞【订单/我的订单】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">我的订单</a>";
            break;
        case "unsubscribe":
            $content = "";
            break;
		case "CLICK":
		    switch ($object->EventKey)
		    {
		        case "shuomingshu":
		             $content[] = array("Title" =>"温湿度监控智能终端使用说明书（20TP与20DP）", 
		    		 "Description" =>"温湿度监控智能终端使用说明书（20TP与20DP）", 
		             "PicUrl" =>"http://www.ccsc58.cc/weixinnew/img/shumingshu_tuisong.png", 
		             "Url" =>"http://mp.weixin.qq.com/s/a-7N3QysT4Bmn3eNGPldOw");
		             break;
		        case "tel":
		            $content = "客服电话：400-6507-168";
		            break;
		            default:
		            $content[] = array("Title" =>"冷云冷链", 
		            "Description" =>"您正在使用冷云冷链公众平台", 
		            "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", 
		            "Url" =>"weixin://addfriend/pondbaystudio");
		            break;
		    }
            break;
            default:
            break;  
    }
	if (is_array($content))
	{
        $result = transmitNews($object, $content);
    }else{
        $result = transmitText($object, $content);
    }
    //$result = transmitText($object,$content);
    return $result;
};
function transmitText($object,$content)
{
    $tuiTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					</xml>";
    $fromUsername = $object->FromUserName;
    $toUsername = $object->ToUserName;
    $time = time();
    $result = sprintf($tuiTpl,$fromUsername,$toUsername,$time,$content);
    return $result;
};
function transmitNews($object, $arr_item, $funcFlag = 0)
			    {
			        //首条标题28字，其他标题39字
			        if(!is_array($arr_item))
			            return;
			
			        $itemTpl = "<item>
						        <Title><![CDATA[%s]]></Title>
						        <Description><![CDATA[%s]]></Description>
						        <PicUrl><![CDATA[%s]]></PicUrl>
						        <Url><![CDATA[%s]]></Url>
						    	</item>";
			        $item_str = "";
			        foreach ($arr_item as $item)
			        $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
			        $newsTpl = "<xml>
								<ToUserName><![CDATA[%s]]></ToUserName>
								<FromUserName><![CDATA[%s]]></FromUserName>
								<CreateTime>%s</CreateTime>
								<MsgType><![CDATA[news]]></MsgType>
								<Content><![CDATA[]]></Content>
								<ArticleCount>%s</ArticleCount>
								<Articles>
								$item_str</Articles>
								<FuncFlag>%s</FuncFlag>
								</xml>";
			        $resultStr = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item), $funcFlag);
			        return $resultStr;
			    }
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
        $url="http://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
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
        $url="http://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
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
        $url="http://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
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
        $url="http://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
        $result=https_request($url,urldecode(json_encode($template)));
        header('location:../weixin/image_test.html');
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
        $url="http://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
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
		 jiankong($arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5],$arr[6]);
	}


//用户关注后向客户推送；
function getAccessToken() {
//  $data = json_decode(get_php_file("access_token.php"));
//  if ($data->expire_time < time()) {
//      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx029d1989acb9f44c&secret=b7a482220530d3be2278429bdf2a7a63";
//      $res = json_decode(https_request($url));
//      $access_token = $res->access_token;
//      if ($access_token) {
//          $data->expire_time = time() + 7000;
//          $data->access_token = $access_token;
//          set_php_file("access_token.php", json_encode($data));
//      }
//  } else {
//      $access_token = $data->access_token;
//  }
//  return $access_token;
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

function receiveText($object)
    {
        $keyword = trim($object->Content);
		if (strstr($keyword, "天气")){
			$city = str_replace('天气', '', $keyword);
			include("weather2.php");
			$content = getWeatherInfo($city);
		//判断笑话
		}
        $result = transmitNews($object, $content);
        return $result;
    }