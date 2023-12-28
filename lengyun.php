<?php

define("TOKEN", "weixin");
header("Access-Control-Allow-Origin: *");

$wechatObj = new wechatCallbackapiTest();
if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
}else{
    $wechatObj->valid();
}

class wechatCallbackapiTest
{
    //验证签名
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            echo $echoStr;
            exit;
        }
    }

    //响应消息
    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $this->logger("R \r\n".$postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            if (($postObj->MsgType == "event") && ($postObj->Event == "subscribe" || $postObj->Event == "unsubscribe")){
                //过滤关注和取消关注事件
            }else{
            require_once('AdvancedGroup/mysql.class.php');
            $db = new class_mysql();
            $mysql_state = "UPDATE `wx_user` SET `heartbeat` = '".time()."' WHERE `openid` = '".$postObj->FromUserName."';";
            $result = $db->query($mysql_state);
            }
            
            //消息类型分离
            switch ($RX_TYPE)
            {
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
                case "text":
                    $result = $this->receiveText($postObj);
                    break;            
                case "image":
                    $result = $this->receiveImage($postObj);
                    break;
                case "location":
                    $result = $this->receiveLocation($postObj);
                    break;
                case "voice":
                    $result = $this->receiveVoice($postObj);
                    break;
                case "video":
                    $result = $this->receiveVideo($postObj);
                    break;
                case "link":
                    $result = $this->receiveLink($postObj);
                    break;
                default:
                    $result = "unknown msg type: ".$RX_TYPE;
                    break;
            }
            $this->logger("T \r\n".$result);
            echo $result;
        }else {
            echo "";
            exit;
        }
    }

    //接收事件消息
    private function receiveEvent($object)
    {
	    require_once('AdvancedGroup/mysql.class.php');
	    $db = new class_mysql();
	    require_once('AdvancedGroup/weixin.class.php');
	    $weixin = new class_weixin();
	    $openid = strval($object->FromUserName);
	    $content = "";
        switch ($object->Event)
        {
            case "subscribe":
                $info = $weixin->get_user_info($openid);
                $mysql_state = "INSERT INTO 'tb_weixin_userinfo' ('id', 'openid', 'nickname', 'sex', 'country', 'province', 'city', 'headimgurl', 'heartbeat', 'subscribe') VALUES (NULL, '".$openid."', '".$info['nickname']."', '".$info['sex']."', '".$info['country']."', '".$info['province']."', '".$info['city']."', '".$info['headimgurl']."', '".$info['subscribe_time']."', '".$info['subscribe_time']."');";
                $result = $db->query($mysql_state);
                $content = "您好".$info['nickname']."，感谢您的关注！平台定期推送感兴趣的内容，欢迎关注'冷云科技'公众平台！/微笑/微笑  ";
	            //$content .= (!empty($object->EventKey))?("\n请回复绑定 ".str_replace("qrscene_","",$object->EventKey)):"";
	            $content .= (!empty($object->EventKey))?("\n\n<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth_3.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">微信绑定</a>"):"";
                break;
            case "unsubscribe":
                $content = "取消关注";
                break;
            case "CLICK":
                switch ($object->EventKey)
                {
                    case "shuomingshu":
                        $content[] = array(array("Title" =>"温湿度监控智能终端使用说明书（20TP与20DP）", 
                        "Description" =>"温湿度监控智能终端使用说明书（20TP与20DP）", 
                        "PicUrl" =>"http://www.ccsc58.cc/weixinnew/img/shumingshu_tuisong.png", 
                        "Url" =>"http://mp.weixin.qq.com/s/a-7N3QysT4Bmn3eNGPldOw"));
                        $content[] = array(array("Title" =>"温度计使用说明书（LY-RTH1000系列）", 
                        "Description" =>"温度计使用说明书（LY-RTH1000系列）", 
                        "PicUrl" =>"http://www.ccsc58.cc/leng/img/1000a_sms.png", 
                        "Url" =>"http://mp.weixin.qq.com/s/8bXlkPaTNIagbCN8Zqaqhg"));
                        $content[] = array(array("Title"=>"温湿度远程采集云分析平台（微信版本）", 
                        "Description"=>"温湿度远程采集云分析平台-微信",  								"PicUrl"=>"http://www.ccsc58.cc/leng/img/wxjm.jpg",
                         "Url" =>"https://mp.weixin.qq.com/s/5O4lbFehdZT1kuJcDvj5sw"));       
                        break;
                     case "lianxiwomen":
                        $content[] = array(array("Title" =>"联系我们", 
                        "Description" =>"客服电话：010-8361-2390\n售后热线:    15910283704", 
                        "PicUrl" =>"http://www.ccsc58.cc/leng/images/lxwm.jpg", 
                        "Url" =>"http://ccsc58.com/folder/about.html"));
                        break;
                    case "tel":
                    	$content = "客服电话：010-8361-2390";//点击公众下面的菜单想用户推送的内容匹配；
                        break;
                    
                    default:
                        $content[] = array(array("Title" =>"冷云冷链", 
                        "Description" =>"您正在使用冷云冷链公众平台", 
                        "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", 
                        "Url" =>"weixin://addfriend/pondbaystudio"));
                        break;
                }
                break;
            case "VIEW":
                $content = "跳转链接 ".$object->EventKey;
                break;
            case "SCAN":            
               // $content = "扫描场景 ".$object->EventKey;           
                $content = "<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth_3.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">微信绑定</a>";        
                break;
            case "LOCATION":
//              $content = "上传位置：纬度 ".$object->Latitude.";经度 ".$object->Longitude;
//              break;
                $url="http://api.map.baidu.com/reverse_geocoding/v3/?ak=jmgKloGf3cOvRl3Y9pUAfvKZCTtCNGwj&location=$object->Latitude,$object->Longitude&output=json&coordtype=gcj0211";
                $output=file_get_contents(url);
                $address=json_decode($output,true);
                $content="位置".$address["result"]["addressComponent"]["province"]." ".$address["result"]["addressComponent"]["city"]." ".$address["result"]["addressComponent"]["district"]." ".$address["result"]["addressComponent"]["street"];
                break;
            case "scancode_waitmsg":
                if ($object->ScanCodeInfo->ScanType == "qrcode"){
                    $content = "扫码带提示：类型 二维码 结果：".$object->ScanCodeInfo->ScanResult;
                }else if ($object->ScanCodeInfo->ScanType == "barcode"){
                    $codeinfo = explode(",",strval($object->ScanCodeInfo->ScanResult));
                    $codeValue = $codeinfo[1];
                    $content = "扫码带提示：类型 条形码 结果：".$codeValue;
                }else{
                    $content = "扫码带提示：类型 ".$object->ScanCodeInfo->ScanType." 结果：".$object->ScanCodeInfo->ScanResult;
                }
                break;
            case "scancode_push":
                $content = "扫码推事件";
                break;
            case "pic_sysphoto":
                $content = "系统拍照";
                break;
            case "pic_weixin":
                $content = "相册发图：数量 ".$object->SendPicsInfo->Count;
                break;
            case "pic_photo_or_album":
                $content = "拍照或者相册：数量 ".$object->SendPicsInfo->Count;
                break;
            case "location_select":
                $content = "发送位置：标签 ".$object->SendLocationInfo->Label;
                break;
            default:
                $content = "receive a new event: ".$object->Event;
                break;
        }

        if(is_array($content)){
            if (isset($content[0]['PicUrl'])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }

    //接收文本消息
    private function receiveText($object)
    {
        $keyword = trim($object->Content);
        
        //多客服人工回复模式
        if (strstr($keyword, "请问在吗") || strstr($keyword, "在线客服")){
            $result = $this->transmitService($object);
            return $result;
        }
       
         //自动回复模式
        if (strstr($keyword, "文本")){
            $content = "请换一种说法"."\nOpenID：".$object->FromUserName."\n冷云冷链公众平台";
        }else if($keyword=="设备"||$keyword=="查询"||$keyword=="冷链"||$keyword=="监控"||$keyword=="我的设备"||$keyword=="中集冷云"){
         $content = "<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">我的设备</a>";
            }
        else if($keyword=="网址"||$keyword=="官网"||$keyword=="中集冷云（北京）冷链科技有限公司"||$keyword=="中集冷云"||$keyword=="冷云科技"||$keyword=="门户网站"||$keyword=="网站"){        
            $content = "<a href=\"http://www.ccsc58.com\">中集冷云（北京）冷链科技有限公司</a>";
        }
        else if($keyword=="授权"||$keyword=="签到"||$keyword=="新年快乐"){
	         //$content = "<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">授权</a>";
	        $content = "/微笑<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">文字参与现场签到</a>/微笑\n备注：请本人参与签到，代抽一律作废处理，感谢您的参与与配合!本次年会会给您更多意想不到的惊喜 /:heart";             
	    }
        else if(strstr($keyword, "客服电话")){
	        $content = "客服电话:010-8361-2390";
        }
        else if($keyword=="JdbJ"||$keyword=="京东报警"){
	         $content = "<a href=\"http://www.ccsc58.com/warning/\">京东报警</a>";
	    }
	    else if($keyword=="抽奖"||$keyword=="奖"||$keyword=="抽"||$keyword=="转盘抽奖"||$keyword=="choujiang"){
            // $content = "/微笑<a href=\"http://www.ccsc58.cc/leng/zhuanPan/yongHuXinXi.html\">参与抽奖</a>/微笑\n备注：请本人参与抽奖，代抽一律作废处理，感谢您的参与与配合!本次活动最终解释权归中集冷云所有";             
            $content = "/微笑<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2_choujiang.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">转盘抽奖</a>/微笑\n备注：请本人参与签到，代抽一律作废处理，感谢您的参与与配合!本次抽奖会给您更多意想不到的惊喜 /:heart";             
	    
        }       
        else if($keyword=="订单"||$keyword=="我的订单"){
             $content = "<a href=\"http://www.ccsc58.cc/weixinnew/html/dingdan_rukou.html\">我的订单</a>";
        }
        else if($keyword=="运单"||$keyword=="运单查询"||$keyword=="单号查询"||$keyword=="单号"){
             $content = "<a href=\"http://www.cccc58.com/\">下单查询</a>";
        }
        else if(is_numeric($keyword)&&strlen($keyword)==12){
             $content = "<a href=\"http://www.cccc58.com\">运单单号:".$keyword."</a>";
        }
        else if($keyword=="报警"||$keyword=="异常"){
             $content = "<a href=\"http://www.ccsc58.cc/weixinnew/html/warning_rukou.html\">设备报警列表</a>";
        }
        else if(is_numeric($keyword)&&strlen($keyword)>=5&&strlen($keyword)<=8){
             $content = "<a href=\"http://www.ccsc58.cc/weixinnew/details_rukou.html?num_m=".$keyword."\">".$keyword."</a>";
        }
        else if($keyword=="?"||$keyword=="？"||$keyword=="时间"||$keyword=="当前时间"){
             $content = date("Y-m-d H:i:s", time()+6*60*60);
        }
        else if($keyword=="下载"||$keyword=="app"||$keyword=="APP"||$keyword=="App"||$keyword=="安卓"||$keyword=="ios"||$keyword=="IOS"||$keyword=="应用"||$keyword=="苹果"){
             $content = "<a href=\"http://fusion.qq.com/cgi-bin/qzapps/unified_jump?appid=42375908&isTimeline=false&actionFlag=0&params=pname%3Dcom.ccsc.coldcloud%26versioncode%3D1%26channelid%3D%26actionflag%3D0&from=singlemessage&isappinstalled=1\">中集冷云(安卓)</a>\n\n<a href=\"https://itunes.apple.com/us/app/zhong-ji-leng-yun-wen-shi/id1173609882?mt=8\">中集冷云(苹果)</a>";
        }
        else if($keyword=="KBCX"||$keyword=="绑定查询"){
             $content = "<a href=\"http://www.ccsc58.cc/weixinnew/select_boxs.php\">箱码设备号绑定查询</a>";
        }
         else if(strstr($keyword, "编号")){
        	$shebeihao = str_replace('编号', '', $keyword);
        	$shebeihao1 = str_replace('，', '', $shebeihao);
        	if(is_numeric($shebeihao1)&&strlen($shebeihao1)==6){
        		$content = "<a href=\"http://www.zjcoldcloud.com/index_data1.php?id=".$shebeihao1."&h=1\">".$shebeihao1."</a>";
        		//"你说的是"."<a href=\"http://www.ccsc58.com/index_data.php?id=".$shebeihao."\">设备号:".$shebeihao."</a>";
        	}else{
        		$content = "设备号:数值不正确"."$shebeihao";
        	}
             
        }
        else if($keyword=="微信绑定"||$keyword=="手机号码绑定"||$keyword=="关联"){          
             $content = "<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth_3.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">微信绑定</a>";
        }
        else if($keyword=="RFID"||$keyword=="rfid"||$keyword=="Rfid"){
            $content = "<a href=\"http://jd.ccsc58.cc/index_RFID.php?t=RFID_20170830\">RFID</a>";
        }
        else if (strstr($keyword, "单图文")){
            $content = array();
            $content[] = array("Title"=>"单图文标题",  "Description"=>"单图文内容", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
        }else if (strstr($keyword, "图文") || strstr($keyword, "多图文")){
            $content = array();
            $content[] = array("Title"=>"多图文1标题", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
            $content[] = array("Title"=>"多图文2标题", "Description"=>"", "PicUrl"=>"http://d.hiphotos.bdimg.com/wisegame/pic/item/f3529822720e0cf3ac9f1ada0846f21fbe09aaa3.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
            $content[] = array("Title"=>"多图文3标题", "Description"=>"", "PicUrl"=>"http://g.hiphotos.bdimg.com/wisegame/pic/item/18cb0a46f21fbe090d338acc6a600c338644adfd.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
        }else if (strstr($keyword, "使用说明书") || strstr($keyword, "操作手册")){
            $content = array();
            $content[] = array("Title"=>"温湿度监控智能终端使用说明书（20TP与20DP）", "Description"=>" 温湿度监控智能终端使用说明书（20TP与20DP）", "PicUrl"=>"http://www.ccsc58.cc/weixinnew/img/shumingshu_tuisong.png", "Url" =>"http://mp.weixin.qq.com/s/a-7N3QysT4Bmn3eNGPldOw");
            $content[] = array("Title"=>"温度计使用说明书（LY-RTH1000系列）", "Description"=>"温度计使用说明书（LY-RTH1000系列）", "PicUrl"=>"http://www.ccsc58.cc/leng/images/1000B01.png", "Url" =>"http://www.ccsc58.com/folder/Download/1000A.pdf");
            $content[] = array("Title"=>"温湿度远程采集云分析平台（微信版本）", "Description"=>"温湿度远程采集云分析平台-微信", "PicUrl"=>"http://www.ccsc58.cc/leng/img/wxjm.jpg", "Url" =>"https://mp.weixin.qq.com/s?__biz=MzIxNzU1MzIyNA==&mid=2247483725&idx=1&sn=19baee7dea592c772d7b9f513e4c5f2a&chksm=97f9416aa08ec87cc846de9af8f2be8d16b8b76abb04269a8ab66415c5c19f5e007f978d1168#wechat_redirect");
        }else if (strstr($keyword, "音乐")){
            $content = array();
            $content = array("Title"=>"最炫民族风", "Description"=>"歌手：凤凰传奇", "MusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3", "HQMusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3"); 
        }
        else if(strstr($keyword, "你好。")){
        	 $content = "中集冷云：".$this->bytes_to_emoji(0x2601);
           //$content = date("Y-m-d H:i:s",time())."\nOpenID：".$object->FromUserName."\n技术支持 方倍工作室";
        }else if (strstr($keyword, "表情")){
        	//$content = "中国：".$this->bytes_to_emoji(0x1F1E8).$this->bytes_to_emoji(0x1F1F3)."\n仙人掌：".$this->bytes_to_emoji(0x1F335);
            $content = "中集冷云：".$this->bytes_to_emoji(0x2601)."\nOpenID：".$object->FromUserName."\n冷云冷链公众平台";
        }
         else if (strstr($keyword, "bd")){
        	//$content = "中国：".$this->bytes_to_emoji(0x1F1E8).$this->bytes_to_emoji(0x1F1F3)."\n仙人掌：".$this->bytes_to_emoji(0x1F335);
            $content = "中集冷云：".$this->bytes_to_emoji(0x2601);
        }
        else if(strstr($keyword, "天气")){
	             	if($keyword=="天气"){
	                $content = "请输入城市+天气\n如北京天气";
	             	}else{
	             		$result=$this->tianqi($object);
	             		
	             	}	
	            } 
        else{
        	//$content = date("Y-m-d H:i:s",time())."\nOpenID：".$object->FromUserName."\n技术支持 方倍工作室";
           $content = "您好！您可以回复以下内容：\n\n☞【下载】:<a href=\"http://a.app.qq.com/o/simple.jsp?pkgname=com.ccsc.coldcloud\">下载APP</a>\n\n☞【官网】:<a href=\"http://www.ccsc58.com\">客服电话</a>\n\n☞【天气】:<a href=\"https://m.tianqi.com\">城市天气</a>\n\n ☞【绑定】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth_3.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">微信绑定</a>\n\n☞【说明书】:<a href=\"https://mp.weixin.qq.com/s/5O4lbFehdZT1kuJcDvj5sw\">操作说明</a>\n\n☞【设备号】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">设备详情</a>\n\n☞【报警/异常】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">报警设备</a>\n\n☞【设备/监控】:<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">我的设备</a>\n\n ☎  客服电话:010-83612390";     
	    }
		if(!empty($result)){
			echo $result;
		}else if(is_array($content)){
        	
            if (isset($content[0])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }
  //接收天气消息
    private function tianqi($object)
    {
    	
        $keyword = trim($object->Content);
		if (strstr($keyword, "天气")){
			$city = str_replace('天气', '', $keyword);
			include("weather2.php");
			$content = getWeatherInfo($city);
		}
		
        $result = $this->transmitNews($object, $content);
        return $result;
    }
     private function yuyintianqi($object)
    {
        $newkeyword = $object->Recognition;        
        $keyword = rtrim($newkeyword, '。'); 
        
		if (strstr($keyword, "天气")){
			$city = str_replace('天气', '', $keyword);
			include("weather2.php");
			$content = getWeatherInfo($city);
		}
        $result = $this->transmitNews($object, $content);
        return $result;
    }


    //接收图片消息
    private function receiveImage($object)
    {
        $content = array("MediaId"=>$object->MediaId);
        $result = $this->transmitImage($object, $content);
        return $result;
    }

    //接收位置消息
    private function receiveLocation($object)
    {
        $content = "你发送的是位置，经度为：".$object->Location_Y."；纬度为：".$object->Location_X."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //接收语音消息
    private function receiveVoice($object)
    {
//      if (isset($object->Recognition) && !empty($object->Recognition)){
//          $content = "你刚才说的是：".$object->Recognition;
//          $result = $this->transmitText($object, $content);
//      }else{
//          $content = array("MediaId"=>$object->MediaId);
//          $result = $this->transmitVoice($object, $content);
//      }
//      return $result;
if (isset($object->Recognition) && !empty($object->Recognition)){
        //$content = "你发送的是语音，内容为：".$object->Recognition;        
        $newkeyword = $object->Recognition;        
        $keyword = rtrim($newkeyword, '。'); 
         if (strstr($keyword, "文本")){
            //$content = "请换一种说法"."\nOpenID：".$object->FromUserName."\n冷云冷链公众平台";
             $content = "请换一种说法,冷云科技公众平台欢迎你";           
        }
        else if($keyword=="授权"||$keyword=="签到"||$keyword=="新年快乐"){
	          $content = "/微笑<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">参与现场签到</a> \n备注：请本人参与签到，代抽一律作废处理，感谢您的参与与配合!本次年会会给您更多意想不到的惊喜  /:heart";             
	    }else if (strstr($keyword, "你好")){
             $content = "你好！/微笑/微笑";
        }else if($keyword=="设备"||$keyword=="查询"||$keyword=="监控"||$keyword=="我的设备"||$keyword=="中集冷云"){
             $content = "<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">我的设备</a>";
        }
        else if(strstr($keyword, "冷链运输")||strstr($keyword, "运输")||strstr($keyword, "冷链")){
        $content = "客服电话:400-6507168";
        }
        else if($keyword=="网址"||$keyword=="官网"||$keyword=="中集冷云（北京）冷链科技有限公司"||$keyword=="中集冷云"||$keyword=="冷云科技"||$keyword=="门户网站"||$keyword=="网站"){        
            $content = "<a href=\"http://www.ccsc58.com\">中集冷云（北京）冷链科技有限公司</a>";
        }
        else if(strstr($keyword, "客服电话")){
	        $content = "客服电话:010-8361-2390";
        }
         else if(strstr($keyword, "元旦")){
        	 $content = "你好/微笑 \n提前祝你:\n元旦快乐!2018年心想事成 ".$this->bytes_to_emoji(0x2764);
          
        }
        else if($keyword=="KBCX"||$keyword=="绑定查询"){
             $content = "<a href=\"http://www.ccsc58.cc/weixinnew/select_boxs.php\">箱码设备号绑定查询</a>";
        }
        else if($keyword=="运单号查询"||$keyword=="运单查询"||$keyword=="物流信息查询"||$keyword=="物流查询"){
             $content = "<a href=\"http://www.ccsc58.cc/weixinnew/logistics.php\">运单号查询</a>";
        }
        else if($keyword=="JdbJ"||$keyword=="京东报警"){
	         $content = "<a href=\"http://www.ccsc58.com/warning/\">京东报警</a>";
	    }
	    else if($keyword=="抽奖"||$keyword=="奖"||$keyword=="抽"||$keyword=="转盘抽奖"||$keyword=="choujiang"){
             $content = "/微笑<a href=\"http://www.ccsc58.cc/leng/zhuanPan/yongHuXinXi.html\">参与抽奖</a>/微笑\n备注：请本人参与抽奖，代抽一律作废处理，感谢您的参与与配合!本次活动最终解释权归中集冷云所有";             
        }
        else if($keyword=="订单"||$keyword=="我的订单"){
             $content = "<a href=\"http://www.ccsc58.cc/weixinnew/html/dingdan_rukou.html\">我的订单</a>";
        }
        else if($keyword=="运单"||$keyword=="运单查询"||$keyword=="单号查询"||$keyword=="单号"){
             $content = "<a href=\"http://www.cccc58.com/\">下单查询</a>";
        }
        
        else if(strstr($keyword, "编号")){
        	$shebeihao = str_replace('编号', '', $keyword);
        	$shebeihao1 = str_replace('，', '', $shebeihao);
        	var_dump($shebeihao1);
        	
        	if(is_numeric($shebeihao1)&&strlen($shebeihao1)==6){
        		$content = "<a href=\"http://www.zjcoldcloud.com/index_data1.php?id=".$shebeihao1."\">".$shebeihao1."</a>";
        		//"你说的是"."<a href=\"http://www.ccsc58.com/index_data.php?id=".$shebeihao."\">设备号:".$shebeihao."</a>";
        	}else{
        		$content = "$shebeihao"."设备号:数值不正确";
        	}
             
        }
        
        else if(is_numeric($keyword)&&strlen($keyword)==6){
             $content = "<a href=\"http://www.zjcoldcloud.com/index_data1.php?id=".$keyword."\">".$keyword."</a>";
        		
        }
        else if($keyword=="报警"||$keyword=="异常"){
             $content = "<a href=\"http://www.ccsc58.cc/weixinnew/html/warning_rukou.html\">设备报警列表</a>";
        }
        else if(is_numeric($keyword)&&strlen($keyword)>=5&&strlen($keyword)<=8){
             $content = "<a href=\"http://www.ccsc58.cc/weixinnew/details_rukou.html?num_m=".$keyword."\">".$keyword."</a>";
        }
        else if($keyword=="?"||$keyword=="？"||$keyword=="时间"||$keyword=="当前时间"){
              $content = date("Y-m-d H:i:s", time()+6*60*60);
        }
        else if($keyword=="下载"||$keyword=="app"||$keyword=="APP"||$keyword=="App"||$keyword=="安卓"||$keyword=="ios"||$keyword=="IOS"||$keyword=="应用"||$keyword=="苹果"){
             $content = "<a href=\"http://fusion.qq.com/cgi-bin/qzapps/unified_jump?appid=42375908&isTimeline=false&actionFlag=0&params=pname%3Dcom.ccsc.coldcloud%26versioncode%3D1%26channelid%3D%26actionflag%3D0&from=singlemessage&isappinstalled=1\">中集冷云(安卓)</a>\n\n<a href=\"https://itunes.apple.com/us/app/zhong-ji-leng-yun-wen-shi/id1173609882?mt=8\">中集冷云(苹果)</a>";
        }
        else if($keyword=="微信绑定"||$keyword=="手机号码绑定"||$keyword=="关联"){          
             $content = "<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx82dbac04fa8fd8ef&redirect_uri=http://www.ccsc58.cc/weixinnew/oauth_3.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">微信绑定</a>";
        }
        else if($keyword=="RFID"||$keyword=="rfid"||$keyword=="Rfid"){
            $content = "<a href=\"http://jd.ccsc58.cc/index_RFID.php?t=RFID_20170830\">RFID</a>";
        }
        else if (strstr($keyword, "单图文")){
            $content = array();
            $content[] = array("Title"=>"单图文标题",  "Description"=>"单图文内容", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
        }else if (strstr($keyword, "图文") || strstr($keyword, "多图文")){
            $content = array();
            $content[] = array("Title"=>"多图文1标题", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
            $content[] = array("Title"=>"多图文2标题", "Description"=>"", "PicUrl"=>"http://d.hiphotos.bdimg.com/wisegame/pic/item/f3529822720e0cf3ac9f1ada0846f21fbe09aaa3.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
            $content[] = array("Title"=>"多图文3标题", "Description"=>"", "PicUrl"=>"http://g.hiphotos.bdimg.com/wisegame/pic/item/18cb0a46f21fbe090d338acc6a600c338644adfd.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
        }else if (strstr($keyword, "使用说明书") || strstr($keyword, "操作手册")){
            $content = array();
            $content[] = array("Title"=>"温湿度监控智能终端使用说明书（20TP与20DP）", "Description"=>" 温湿度监控智能终端使用说明书（20TP与20DP）", "PicUrl"=>"http://www.ccsc58.cc/weixinnew/img/shumingshu_tuisong.png", "Url" =>"http://mp.weixin.qq.com/s/a-7N3QysT4Bmn3eNGPldOw");
            $content[] = array("Title"=>"温度计使用说明书（LY-RTH1000系列）", "Description"=>"温度计使用说明书（LY-RTH1000系列）", "PicUrl"=>"http://www.ccsc58.cc/leng/images/1000B01.png", "Url" =>"http://www.ccsc58.com/folder/Download/1000A.pdf");
            $content[] = array("Title"=>"温湿度远程采集云分析平台（微信版本）", "Description"=>"温湿度远程采集云分析平台-微信", "PicUrl"=>"http://www.ccsc58.cc/leng/img/wxjm.jpg", "Url" =>"https://mp.weixin.qq.com/s?__biz=MzIxNzU1MzIyNA==&mid=2247483725&idx=1&sn=19baee7dea592c772d7b9f513e4c5f2a&chksm=97f9416aa08ec87cc846de9af8f2be8d16b8b76abb04269a8ab66415c5c19f5e007f978d1168#wechat_redirect");
        }else if (strstr($keyword, "音乐")){
            $content = array();
            $content = array("Title"=>"最炫民族风", "Description"=>"歌手：凤凰传奇", "MusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3", "HQMusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3"); 
        }
        else if(strstr($keyword, "你好。")){
        	 $content = "中集冷云：".$this->bytes_to_emoji(0x2601);
           //$content = date("Y-m-d H:i:s",time())."\nOpenID：".$object->FromUserName."\n技术支持 方倍工作室";
        }else if (strstr($keyword, "表情")){
        	//$content = "中国：".$this->bytes_to_emoji(0x1F1E8).$this->bytes_to_emoji(0x1F1F3)."\n仙人掌：".$this->bytes_to_emoji(0x1F335);
            $content = "中集冷云：".$this->bytes_to_emoji(0x2601)."\nOpenID：".$object->FromUserName."\n冷云冷链公众平台";
        }
         else if (strstr($keyword, "bd")){
        	//$content = "中国：".$this->bytes_to_emoji(0x1F1E8).$this->bytes_to_emoji(0x1F1F3)."\n仙人掌：".$this->bytes_to_emoji(0x1F335);
            $content = "中集冷云：".$this->bytes_to_emoji(0x2601);
        }
         else if(strstr($keyword, "天气")){
	             	if($keyword=="天气"){
	                $content = "请输入城市+天气\n如北京天气";
	             	}else{
	             		$result=$this->yuyintianqi($object);
	             		
	             	}	
	            } 
//      else if(strstr($keyword, "天气")){
//	             	if($keyword=="天气"){
//	                $content = "请输入城市+天气\n如北京天气";
//	             	}else{
//	             		  $content = "<a href=\"https://m.tianqi.com/\">天气预报</a>";	
//	             	}	
//	            } 

	            else{
        	$content = "没能明白您的意思！";
        }
    }else{
        $content = "未开启语音识别功能或者识别内容为空";
    }
    if(!empty($result)){
			echo $result;
		}else if(is_array($content)){
        	
            if (isset($content[0])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }

    //接收视频消息
    private function receiveVideo($object)
    {
        $content = array("MediaId"=>$object->MediaId, "ThumbMediaId"=>$object->ThumbMediaId, "Title"=>"", "Description"=>"");
        $result = $this->transmitVideo($object, $content);
        return $result;
    }

    //接收链接消息
    private function receiveLink($object)
    {
        $content = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $result = $this->transmitText($object, $content);
        return $result;
        
    }

    //回复文本消息
    private function transmitText($object, $content)
    {
        if (!isset($content) || empty($content)){
            return "";
        }

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);

        return $result;
    }

    //回复图文消息
    private function transmitNews($object, $newsArray)
    {
        if(!is_array($newsArray)){
            return "";
        }
        $itemTpl = "        <item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
        </item>
";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[news]]></MsgType>
    <ArticleCount>%s</ArticleCount>
    <Articles>$item_str</Articles>
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

    //回复音乐消息
    private function transmitMusic($object, $musicArray)
    {
        if(!is_array($musicArray)){
            return "";
        }
        $itemTpl = "<Music>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <MusicUrl><![CDATA[%s]]></MusicUrl>
        <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
    </Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[music]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复图片消息
    private function transmitImage($object, $imageArray)
    {
        $itemTpl = "<Image>
        <MediaId><![CDATA[%s]]></MediaId>
    </Image>";

        $item_str = sprintf($itemTpl, $imageArray['MediaId']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[image]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复语音消息
    private function transmitVoice($object, $voiceArray)
    {
        $itemTpl = "<Voice>
        <MediaId><![CDATA[%s]]></MediaId>
    </Voice>";

       $item_str = sprintf($itemTpl, $voiceArray['MediaId']);
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[voice]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复视频消息
    private function transmitVideo($object, $videoArray)
    {
        $itemTpl = "<Video>
        <MediaId><![CDATA[%s]]></MediaId>
        <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
    </Video>";

        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[video]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复多客服消息
    private function transmitService($object)
    {
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }   

    //回复第三方接口消息
    private function relayPart3($url, $rawData)
    {
        $headers = array("Content-Type: text/xml; charset=utf-8");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $rawData);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
   
    //字节转Emoji表情
    function bytes_to_emoji($cp)
    {
        if ($cp > 0x10000){       # 4 bytes
            return chr(0xF0 | (($cp & 0x1C0000) >> 18)).chr(0x80 | (($cp & 0x3F000) >> 12)).chr(0x80 | (($cp & 0xFC0) >> 6)).chr(0x80 | ($cp & 0x3F));
        }else if ($cp > 0x800){   # 3 bytes
            return chr(0xE0 | (($cp & 0xF000) >> 12)).chr(0x80 | (($cp & 0xFC0) >> 6)).chr(0x80 | ($cp & 0x3F));
        }else if ($cp > 0x80){    # 2 bytes
            return chr(0xC0 | (($cp & 0x7C0) >> 6)).chr(0x80 | ($cp & 0x3F));
        }else{                    # 1 byte
            return chr($cp);
        }
    }

    //日志记录
    private function logger($log_content)
    {
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "101.201.103.155"){ //LOCAL
            $max_size = 1000000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('Y-m-d H:i:s')." ".$log_content."\r\n", FILE_APPEND);
        }
    }
}
?>