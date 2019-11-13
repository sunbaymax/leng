<?php
/**
 * wechat php test
 */
//define your token
//get post data, May be due to the different environments
$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
//file_put_contents("./data.txt",$postStr);
//die();
//extract post data
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
            }else if($keyword=="说明书"||$keyword=="产品说明书"||$keyword=="监控仪"||$keyword=="设备"){
                $msgType = "news";
                $title="温湿度监控智能终端使用说明书（20TP与20DP）";
                $Description="温湿度监控智能终端使用说明书（20TP与20DP）";
                $PicUrl="https://mmbiz.qlogo.cn/mmbiz_jpg/ziaKJxqKkuup3fry27hibTV069yNNVhOohiaRgsATuWCAxMcRIXvvldetzjbudkAsXpv05v4ISAib1M6Mj05MAmIxg/0?wx_fmt=jpeg";
                $Url="http://mp.weixin.qq.com/s/a-7N3QysT4Bmn3eNGPldOw";
                $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$title,$Description,$PicUrl,$Url);
                echo $resultStr;
            }else if($keyword=="下载"||$keyword=="app"||$keyword=="APP"||$keyword=="App"||$keyword=="安卓"||$keyword=="ios"||$keyword=="IOS"||$keyword=="应用"||$keyword=="苹果"){
                $msgType = "text";
                $contentStr = "<a href=\"http://fusion.qq.com/cgi-bin/qzapps/unified_jump?appid=42375908&isTimeline=false&actionFlag=0&params=pname%3Dcom.ccsc.coldcloud%26versioncode%3D1%26channelid%3D%26actionflag%3D0&from=singlemessage&isappinstalled=1\">中集冷云(安卓)</a>\n\n<a href=\"https://itunes.apple.com/us/app/zhong-ji-leng-yun-wen-shi/id1173609882?mt=8\">中集冷云(苹果)</a>";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }else if($keyword=="客服"){
                $msgType = "text";
                $contentStr = "客服电话:400-6507-168";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }else if($keyword=="报警"||$keyword=="异常"){
                $msgType = "text";
                $contentStr = "<a href=\"http://www.ccsc58.cc/weixinnew/html/warning_rukou.html\">设备报警列表</a>";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }else if(is_numeric($keyword)){
                $msgType = "text";
                $contentStr = "<a href=\"http://www.ccsc58.cc/weixinnew/details_rukou.html?num_m=".$keyword."\">".$keyword."</a>";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }else if($keyword=="订单"||$keyword=="我的订单"){
                $msgType = "text";
                $contentStr = "<a href=\"http://www.ccsc58.cc/weixinnew/html/dingdan_rukou.html\">我的订单</a>";
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
            $content ="";
            break;
    }

    $result = transmitText($object,$content);
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
//{{first.DATA}}
//设备号：{{keyword1.DATA}}
//告警时间：{{keyword2.DATA}}
//告警级别：{{keyword3.DATA}}
//告警模块：{{keyword4.DATA}}
//事件描述：{{keyword5.DATA}}
//{{remark.DATA}}
function Tui_song($first,$keyword1,$keyword2,$keyword3,$keyword4,$keyword5,$remark,$openId,$app_key,$keyword6)
{
    $keyword5='\n'.$keyword5.'\n';
    $first=$first.'\n';
    if($app_key== "261AFF68C0E9F076420D083D66222824"){
        $template=array(
            'touser'=>$openId,
            'template_id'=>"qkU8mzqUxVqMLApXrtK6RHsrM7Kng32U5An5Trpuy90",
            'url'=>"http://www.ccsc58.cc/weixinnew/html/warning_tui_rukou.html?num_m=".$keyword6."&",
            'topcolor'=>"#000000",
            'data'=>array('first'=>array('value'=>urlencode($first),'color'=>"#0978BD",),
                'keyword1'=>array('value'=>urlencode($keyword1),'color'=>"#1818FF",),
                'keyword2'=>array('value'=>urlencode($keyword2),'color'=>"#1818FF",),
                'keyword3'=>array('value'=>urlencode($keyword3),'color'=>"#FF0000",),
                'keyword4'=>array('value'=>urlencode($keyword4),'color'=>"#000",),
                'keyword5'=>array('value'=>urlencode($keyword5),'color'=>"#000",),
                'remark'=>array('value'=>urlencode($remark),'color'=>"#000",),
            )
        );
        $url="http://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
        $result=https_request($url,urldecode(json_encode($template)));
        //var_dump($result);
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
}else{
	 Pay_money($arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5],$arr[6],$arr[7]);
}

function Pay_money($first,$keyword1,$keyword2,$keyword3,$keyword4,$remark,$openId,$app_key)
{
    if($app_key== "261AFF68C0E9F076420D083D66222824"){
        $template=array(
            'touser'=>$openId,
            'template_id'=>"0P_Gawko7wU3H2uJFHWBbbVYxsKmnZj4fFJ6mS5nBLI",
            'url'=>"http://www.ccsc58.cc/weixinnew/pay_list.html",
            'topcolor'=>"#000000",
            'data'=>array('first'=>array('value'=>urlencode($first),'color'=>"#000",),
                'keyword1'=>array('value'=>urlencode($keyword1),'color'=>"#000",),
                'keyword2'=>array('value'=>urlencode($keyword2),'color'=>"#0000ff",),
                'keyword3'=>array('value'=>urlencode($keyword3),'color'=>"#000",),
                'keyword4'=>array('value'=>urlencode($keyword4),'color'=>"#000",),
                'remark'=>array('value'=>urlencode($remark),'color'=>"#000",),
            )
        );
        $url="http://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".getAccessToken();
        $result=https_request($url,urldecode(json_encode($template)));
        header('location:../weixin/image_test.html');
    }
}
//用户关注后向客户推送；
function getAccessToken() {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode(get_php_file("access_token.php"));
    if ($data->expire_time < time()) {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx82dbac04fa8fd8ef&secret=98ecda31265ffc327d59adc969089650";
        $res = json_decode(https_request($url));
        $access_token = $res->access_token;
        if ($access_token) {
            $data->expire_time = time() + 7000;
            $data->access_token = $access_token;
            set_php_file("access_token.php", json_encode($data));
        }
    } else {
        $access_token = $data->access_token;
    }
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