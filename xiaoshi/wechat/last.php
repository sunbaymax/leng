<?php
	
define("TOKEN","ljhw4g2oikypwhhf24g4qfccvc4drfnf");
header("Access-Control-Allow-Origin: *");
$wechatObj = new wechatCallbackapiTest();

$menu=$_GET['menu'];
if(!empty($menu))
{
    $wechatObj ->createmenu();
}

if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
}else{
    $wechatObj->valid();
}

class wechatCallbackapiTest
{
	private $link;
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
        	ob_clean();
            echo $echoStr;
            exit;
        }
    }
    public function __construct()
	{
	    $this->link = mysqli_connect("127.0.0.1","test","123456");
		if (!$this->link)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
		  mysqli_select_db($this->link,"shield");
		 
		  //echo '连接成功';
	}
    //响应消息
    public function responseMsg()
    {
        //$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");  
        if (!empty($postStr)){
            $this->logger("R \r\n".$postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            if (($postObj->MsgType == "event") && ($postObj->Event == "subscribe" || $postObj->Event == "unsubscribe")){
                //过滤关注和取消关注事件
            }else{
                
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
        $content = "";
        switch ($object->Event)
        {
            case "subscribe":
                
                $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->getAccessToken()."&openid=".$object->FromUserName."&lang=zh_CN";
                
                $content = "Hi~	😋欢迎关注，寿光市小石网络科技有限公司微信公众平台~~么么哒	❤";
                
				$userInfo=json_decode($this->https_request($url),true);
				 
				$openid = $userInfo['openid'];
				$nickname = $userInfo['nickname'];
				$sex = $userInfo['sex']=='1'?"男":"女";
				$country = $userInfo['country'];
				$province = $userInfo['province'];
				$city = $userInfo['city'];
				$headimgurl = $userInfo['headimgurl'];
				$subscribe = $userInfo['subscribe'];
				$subscribe_time = $userInfo['subscribe_time'];
				$sql="INSERT INTO tb_weixin_user (openid,nickname,sex,country,province,city,headimgurl,subscribe,subscribe_time) values('$openid','$nickname','$sex','$country','$province','$city','$headimgurl','$subscribe','$subscribe_time')";
			    $resql=mysqli_query($this->link,$sql);	
                break;
            case "unsubscribe":
                $content = "取消关注";
                $sql="DELETE FROM tb_weixin_user WHERE openid='$object->FromUserName'";
			    mysqli_query($this->link,$sql);
                break;
            case "CLICK":
                switch ($object->EventKey)
                {
                  
               
                 case "lianxiwomen":
		         $content = array(array("Title" =>"联系我们", 
		         "Description" =>"客服电话: 0536-5996655", 
		         "PicUrl" =>"http://www.ccsc58.cc/leng/images/lxwm.jpg", 
		         "Url" =>""));
		            break;
                default:
                    $content[] = array("Title" =>"", 
                    "Description" =>"", 
                    "PicUrl" =>"", 
                    "Url" =>"weixin://addfriend/pondbaystudio");
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
                $url="http://api.map.baidu.com/geocoder/v2/?ak=XP1alssWsEscC3NfYAhj6YfqKvgQgUXF&location=$object->Latitude,$object->Longitude&output=json&coordtype=gcj0211";
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
        else if (strstr($keyword, "文本")){
            $content = "请换一种说法"."\nOpenID：".$object->FromUserName."\n公众平台";
        }
         else if($keyword=="云平台"){
	        $content = "<a href=\"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx80f7545ed03efa71&redirect_uri=http://www.ccsc58.cc/leng/pengdun/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect\">平台</a>";             
	    }
	    
        else if (strstr($keyword, "单图文")){
            $content = array();
            $content[] = array("Title"=>"单图文标题",  "Description"=>"单图文内容", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
        }else if (strstr($keyword, "图文") || strstr($keyword, "多图文")){
            $content = array();
            $content[] = array("Title"=>"多图文1标题", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
            $content[] = array("Title"=>"多图文2标题", "Description"=>"", "PicUrl"=>"http://d.hiphotos.bdimg.com/wisegame/pic/item/f3529822720e0cf3ac9f1ada0846f21fbe09aaa3.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
            $content[] = array("Title"=>"多图文3标题", "Description"=>"", "PicUrl"=>"http://g.hiphotos.bdimg.com/wisegame/pic/item/18cb0a46f21fbe090d338acc6a600c338644adfd.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
        }else if (strstr($keyword, "音乐")){
            $content = array();
            $content = array("Title"=>"最炫民族风", "Description"=>"歌手：凤凰传奇", "MusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3", "HQMusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3"); 
        }
        else if(strstr($keyword, "你好。")){
        	 $content = "你好：".$this->bytes_to_emoji(0x2601);
        }else if (strstr($keyword, "表情")){
            $content = "表情：".$this->bytes_to_emoji(0x2601)."\nOpenID：".$object->FromUserName."\n慧联云公众平台";
        }
        else if(strstr($keyword, "天气")){
	             	if($keyword=="天气"){
	                $content = "请输入城市+天气\n如北京天气";
	             	}else{
	             		$result=$this->tianqi($object);
	             		
	             	}	
	            } 
        else{
        	$content = date("Y-m-d H:i:s",time())."\nOpenID：".$object->FromUserName."\n技术支持 ";
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
//      $content = "你发送的是位置，经度为：".$object->Location_Y."；纬度为：".$object->Location_X."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
//      $result = $this->transmitText($object, $content);
//      return $result; 
        $pondbay=array();
        $content[]=array("Title"=>"高德地图为您导航","Description"=>"","PicUrl"=>"","Url"=>"");
        $content[]=array("Title"=>"点击图片查看驾车线路导航","Description"=>"点击图片查看驾车线路导航","PicUrl"=>"http://www.ccsc58.cc/IceKnight/img/eeb1cb3.jpg","Url"=>"http://mo.amap.com/?from=".$object->location_x.",".$object->location_y."(".$object->label.")&to=".$pondbay['latitude'].",".$pondbay['longitude']."(".$pondbay['name'].")&type=0&opt=1&dev=1");
        //$content[]=array("Title"=>"点击图片查看驾车线路导航","Description"=>"点击图片查看驾车线路导航","PicUrl"=>"http://www.ccsc58.cc/IceKnight/img/eeb1cb3.jpg","Url"=>"http://mo.amap.com/?from=".$object->location_x.",".$object->location_y."(".$object->label.")&to=".$pondbay['latitude'].",".$pondbay['longitude']."(".$pondbay['name'].")&type=0&opt=1&dev=1");
        
        $result=$this->transmitNews($object,$content);
        return $result;
    }

    //接收语音消息
    private function receiveVoice($object)
    {
        if (isset($object->Recognition) && !empty($object->Recognition)){
       // $content = "你发送的是语音，内容为：".$object->Recognition;        
        $newkeyword = $object->Recognition;        
        $keyword = rtrim($newkeyword, '。'); 
         if (strstr($keyword, "文本")){
            //$content = "请换一种说法"."\nOpenID：".$object->FromUserName."\n慧联云公众平台";
             $content = "请换一种说法,冷云科技公众平台欢迎你";           
        }else if (strstr($keyword, "你好")){
             $content = "你好！/微笑/微笑";
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
        }else if(strstr($keyword, "天气")){
         	if($keyword=="天气"){
            $content = "请输入城市+天气\n如北京天气";
         	}else{
         		$result=$this->yuyintianqi($object);
         		
         	}	
        } 
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
            $log_filename = "wechatlog1.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('Y-m-d H:i:s')." ".$log_content."\r\n", FILE_APPEND);
        }
    }
    public function getAccessToken(){
	    $url = "http://123.57.83.23/api/api/get_token_zlkj.php";
	    $access_token=file_get_contents($url);
	    return $access_token;
	}
	public function https_request($url,$data = null){
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
public function createmenu()
{
    $str='
    {
        "button": [
        {
            
            "name": "云平台",
            "sub_button": [
            {
                "type": "view",
                "name": "棚盾云平台",
                "url": "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx80f7545ed03efa71&redirect_uri=http://www.ccsc58.cc/leng/pengdun/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect",
                "sub_button": []
            },
            {
                "type": "view",
                "name": "棚盾说明",
                "url": "https://wei.jfcss.com/app/index.php?i=2&c=entry&do=hzwshowcontent&m=hzw_toutiao&id=255",
                "sub_button": []
            }
            ]
        },{
            
            "name": "棚友资讯",
            "sub_button": [
            {
                "type": "view",
                "name": "天气预报",
                "url": "https://wei.jfcss.com/app/index.php?i=2&c=entry&classtype=5&do=Hzwtoutiaoenter&m=hzw_toutiao",
                "sub_button": []
            },
            {
                "type": "view",
                "name": "蔬菜价格",
                "url": "https://wei.jfcss.com/app/index.php?i=2&c=entry&classtype=4&do=Hzwtoutiaoenter&m=hzw_toutiao",
                "sub_button": []
            },
            {
                "type": "view",
                "name": "棚友资讯",
                "url": "https://wei.jfcss.com/app/index.php?i=2&c=entry&do=Hzwtoutiaoenter&m=hzw_toutiao",
                "sub_button": []
            }
            ]
            }, {
                "name": "关于我们",
                "sub_button": [
                {
                    "type": "click",
                    "name": "联系我们",
                    "key": "lianxiwomen",
                    "sub_button": []
                }
                
                ]
            }
            ]
    }';
    $url= "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->getAccessToken();
    
    $this->https_request($url,$str);
}

}
?>