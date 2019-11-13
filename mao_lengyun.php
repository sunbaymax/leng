<?php
/*
    方倍工作室 http://www.cnblogs.com/txw1958/
    CopyRight 2013 www.fangbei.org  All Rights Reserved
*/
header('Content-type:text');
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
if (isset($_GET['echostr'])) {
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            header('content-type:text');
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
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
            if(!empty($keyword))
            {
	               if($keyword=="设备"||$keyword=="查询"||$keyword=="冷链"||$keyword=="绑定"||$keyword=="我的设备"||$keyword=="中集冷云"){
	                $msgType = "text";
	                $contentStr = "<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">我的设备</a>";
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                echo $resultStr;
	            }else if($keyword=="说明书"||$keyword=="产品说明书"||$keyword=="监控仪"||$keyword=="设备"){
	                $msgType = "news";
	                $title="温湿度监控智能终端使用说明书（20TP与20DP）";
	                $Description="温湿度监控智能终端使用说明书（20TP与20DP）";
					$PicUrl="http://www.ccsc58.cc/weixinnew/img/shumingshu_tuisong.png";
	                $Url="http://mp.weixin.qq.com/s/a-7N3QysT4Bmn3eNGPldOw";
	                $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$title,$Description,$PicUrl,$Url);
	                echo $resultStr;
	            }
	           else if($keyword=="下载"||$keyword=="app"||$keyword=="APP"||$keyword=="App"||$keyword=="安卓"||$keyword=="ios"||$keyword=="IOS"||$keyword=="应用"||$keyword=="苹果"){
	                $msgType = "text";
	                $contentStr = "<a href=\"http://fusion.qq.com/cgi-bin/qzapps/unified_jump?appid=42375908&isTimeline=false&actionFlag=0&params=pname%3Dcom.ccsc.coldcloud%26versioncode%3D1%26channelid%3D%26actionflag%3D0&from=singlemessage&isappinstalled=1\">中集冷云(安卓)</a>\n\n<a href=\"https://itunes.apple.com/us/app/zhong-ji-leng-yun-wen-shi/id1173609882?mt=8\">中集冷云(苹果)</a>";
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                echo $resultStr;
	            }else if($keyword=="客服"){
	                $msgType = "text";
	                $contentStr = "客服电话:010-8361-2390";
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                echo $resultStr;
	            }else if($keyword=="报警"||$keyword=="异常"||$keyword=="超温"){
	                $msgType = "text";
	                $contentStr = "<a href=\"http://www.ccsc58.cc/leng/html/warning_rukou.html\">设备报警列表</a>";
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                echo $resultStr;
	            }else if(is_numeric($keyword)){
	                $msgType = "text";
	                $contentStr = "<a href=\"http://www.ccsc58.cc/leng/details_rukou.html?num_m=".$keyword."\">".$keyword."</a>";
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                echo $resultStr;
	            }else if($keyword=="订单"||$keyword=="我的订单"){
	                $msgType = "text";
	                $contentStr = "<a href=\"http://www.ccsc58.cc/leng/html/dingdan_rukou.html\">我的订单</a>";
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                echo $resultStr;
	            }else if($keyword=="JdbJ"||$keyword=="京东报警"){
	                $msgType = "text";
	                $contentStr = "http://www.ccsc58.com/warning/";
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                echo $resultStr;
	            }
	            else if($keyword=="设备"||$keyword=="温度记录仪"||$keyword=="湿度"||$keyword=="产品"||$keyword=="温湿度记录仪"){
	                $msgType = "text";
	                $contentStr = "<a href=\"https://mp.weixin.qq.com/s/tZV04PE7w3RGO0vQ-XJ5Ng\">LY-TH20TP型温湿度记录仪</a>";
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                echo $resultStr;
	            }
	             else if(strstr($keyword, "天气")){
	             	if($keyword=="天气"){
	             	$msgType = "text";
	                $contentStr = "请输入城市+天气\n如北京天气";
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                echo $resultStr;
	             	}else{
	             		$result=receiveText($postObj);
	             	}
	            	
	            }
	             else if($keyword=="哆啦A梦"||$keyword=="孙"||$keyword=="月"||$keyword=="王"||$keyword=="田"){
	                $msgType = "news";
	                $title="可爱";
	                $Description="萌萌哒";
					$PicUrl="http://www.ccsc58.cc/leng/images/mao.jpg";
	                $Url="http://mp.weixin.qq.com/s/a-7N3QysT4Bmn3eNGPldOw";
	                $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$title,$Description,$PicUrl,$Url);
	                echo $resultStr;
	            }
	            else if($keyword=="李丹"||$keyword=="宋明月"){
	            	$msgType = "text";
	                $contentStr = "嬷嬷/偷笑";
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                echo $resultStr;	
	            }
	              else if($keyword=="吴倩"||$keyword=="蹲"||$keyword=="敦" ){
	            	$msgType = "text";
	                $contentStr = "●ω●大名：【敦儿】/偷笑\n\n●ω●爱好：【我有毒】/阴险";
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                echo $resultStr;
	            	}
	            else if($keyword=="巧"||$keyword=="大远"||$keyword=="赵文鹏" ){
	            	if($keyword=="大远"){
	            	$msgType = "text";
	                $contentStr = "●ω●外号：【小吾远】/偷笑\n\n●ω●爱好：【嘿嘿巧】/阴险";
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                echo $resultStr;
	            	}else{
	            	$msgType = "text";
	                $contentStr = "☞外号：【大酒蒙子】/偷笑\n\n☞爱好：【大保健】/坏笑";
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                echo $resultStr;
	            	}	            	
	            }
	           else{
	                $msgType = "text";
	                $contentStr = "您好！您可以回复以下内容：\n\n☞【下载】:<a href=\"http://a.app.qq.com/o/simple.jsp?pkgname=com.ccsc.coldcloud\">下载APP</a>\n\n☞【客服】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">客服电话</a>\n\n☞【说明书】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">产品说明书</a>\n\n☞【设备号】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">设备详情</a>\n\n☞【报警/异常】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">报警设备</a>\n\n☞【绑定/设备】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">绑定账号</a>\n\n☞【订单/我的订单】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">我的订单</a>\n\n☞【天气预报】:请输入城市+天气\n\n客服电话:010-8361-2390";
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                echo $resultStr;
	            };
            }else{
            	echo "Input something...";
            }
            $RX_TYPE=trim($postObj->MsgType);
            if($RX_TYPE=="event"){
            	$result=receiveEvent($postObj);
            }
            echo $result;
        }else{
            echo "";
            exit;
        }
    }
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
function receiveEvent($object)
			{
			    $content = "";
			    switch($object->Event)
			    {
			        case "subscribe":
			            $content = "您好，欢迎关注'冷云冷链'公众平台！/微笑/微笑";//粉丝关注后自动发给粉丝的内容；
			            break;
			        case "unsubscribe":
			            $content ="";
			            break;
			        case "CLICK":
			        	switch ($object->EventKey)
		                {
		                    case "shuomingshu":
		                        $content[] = array("Title" =>"温湿度监控智能终端使用说明书（20TP与20DP）", 
		                        "Description" =>"温湿度监控智能终端使用说明书（20TP与20DP）", 
		                        "PicUrl" =>"http://www.ccsc58.cc/weixinnew/img/shumingshu_tuisong.png", 
		                        "Url" =>"http://mp.weixin.qq.com/s/a-7N3QysT4Bmn3eNGPldOw");
		                        $content[] = array("Title" =>"温度计使用说明书（LY-RTH1000系列）", 
		                        "Description" =>"温度计使用说明书（LY-RTH1000系列）", 
		                        "PicUrl" =>"http://www.ccsc58.cc/leng/img/1000a_sms.png", 
		                        "Url" =>"http://mp.weixin.qq.com/s/8bXlkPaTNIagbCN8Zqaqhg");
		                        break;
		                     case "lianxiwomen":
		                        $content[] = array("Title" =>"联系我们", 
		                        "Description" =>"客服电话：010-8361-2390\n服务热线:    15910283704", 
		                        "PicUrl" =>"http://www.ccsc58.cc/leng/images/lxwm.jpg", 
		                        "Url" =>"http://ccsc58.com/folder/about.html");
		                        break;
		                    case "tel":
		                    	$content = "客服电话：010-8361-2390";//点击公众下面的菜单想用户推送的内容匹配；
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
				 if (is_array($content)){
           				 $resultStr = transmitNews($object, $content);
       				 }else{
           				 $resultStr = transmitText($object, $content);
       				 }
       			return $resultStr;
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
			    
			  
function logger($log_content)
    {
        if(isset($_SERVER['HTTP_BAE_ENV_APPID'])){   //BAE
            require_once "BaeLog.class.php";
            $logger = BaeLog::getInstance();
            $logger ->logDebug($log_content);
        }else if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "101.201.103.155"){ //LOCAL
            $max_size = 10000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
        }
    }
?>