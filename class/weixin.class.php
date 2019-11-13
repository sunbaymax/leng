<?php

/*
    方倍工作室
    CopyRight 2014 All Rights Reserved
*/
require_once('config.php');

define('APPID',"wx029d1989acb9f44c");
define('APPSECRET',"b7a482220530d3be2278429bdf2a7a63");

class class_weixin
{
	var $appid = APPID;
	var $appsecret = APPSECRET;

    //构造函数，获取Access Token
	public function __construct($appid = NULL, $appsecret = NULL)
	{
//      if($appid && $appsecret){
//          $this->appid = $appid;
//			$this->appsecret = $appsecret;
//      }
//
//		/*
//		DROP TABLE IF EXISTS `wx_token`;
//		CREATE TABLE IF NOT EXISTS `wx_token` (
//		  `id` int(1) NOT NULL,
//		  `type` varchar(20) NOT NULL,
//		  `expire` varchar(16) NOT NULL,
//		  `value` varchar(600) NOT NULL,
//		  PRIMARY KEY (`id`)
//		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
//		INSERT INTO `wx_token` (`id`, `type`, `expire`, `value`) VALUES
//		(1, 'access_token', '1425534992', 't3oyW9fRnOWKQHQhZXoEH-pgThhjmnCqTVpaLyUD-AX705zhu9CQZdgQHzbzeMqzTrwv6vkPN_0eZYHH2-Sjxgaat17mx32S6IfStM9fknU'),
//		(2, 'jsapi_ticket', '', '');
//
//		*/
//      // $con = mysql_connect(MYSQLHOST.':'.MYSQLPORT, MYSQLUSER, MYSQLPASSWORD);
//		// mysql_select_db(MYSQLDATABASE, $con);
//		// $result = mysql_query("SELECT * FROM `wx_token` WHERE `type` = 'access_token'");
//		// while($row = mysql_fetch_array($result))
//		// {	
//			// $this->access_token = $row['value'];
//			// $this->expires_time = $row['expire'];
//			// break;
//		// }
//		// if (time() > ($this->expires_time + 3600)){
//			// $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->appsecret;
//          // $res = $this->http_request($url);
//          // $result = json_decode($res, true);
//			// $this->access_token = $result["access_token"];
//			// $this->expires_time = time();
//			// mysql_query("UPDATE `wx_token` SET `expire` = '$this->expires_time', `value` = '$this->access_token' WHERE `type` = 'access_token';");
//		// }
//      //2. 缓存形式
//      if (isset($_SERVER['HTTP_APPNAME'])){        //SAE环境，需要开通memcache
//          $mem = memcache_init();
//      }else {                                        //本地环境，需已安装memcache
//          $mem = new Memcache;
//          $mem->connect('localhost', 11211) or die ("Could not connect");
//      }
//      $this->access_token = $mem->get($this->appid);
//      if (!isset($this->access_token) || empty($this->access_token)){
//          $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->appsecret;
//          $res = $this->http_request($url);
//          $result = json_decode($res, true);
//          $this->access_token = $result["access_token"];
//          $mem->set($this->appid, $this->access_token, 0, 3600);
//      }
$url = "http://www.zjcoldcloud.com/weixin/get_token_zlkj.php";
    $access_token=file_get_contents($url);
    return $access_token;
        
	}
	
    //获取用户基本信息（全局Access Token 获取 已关注用户，注意和OAuth时的区别）
	public function get_user_info($openid)
    {
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->access_token."&openid=".$openid."&lang=zh_CN";
		$res = $this->http_request($url);
        return json_decode($res, true);
	}
	
    //高级群发(根据分组)
    public function mass_send_group($groupid, $type, $data)
    {
        $msg = array('filter' => array('group_id'=>$groupid));
        $msg['msgtype'] = $type;

        switch($type)
        {
			case 'text':
				$msg[$type] = array('content'=> $data);
				break;
            case 'image':
            case 'voice':
            case 'mpvideo':
            case 'mpnews':
                $msg[$type] = array('media_id'=> $data);
				break;

        }
		$url = "https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".$this->access_token;
		$res = $this->http_request($url, json_encode($msg));
        return json_decode($res, true);
    }

    //HTTP请求（支持HTTP/HTTPS，支持GET/POST）
    protected function http_request($url, $data = null)
    {
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
	
	//日志记录
    private function logger($log_content)
    {
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else{ //LOCAL
            $max_size = 500000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('Y-m-d H:i:s').$log_content."\r\n", FILE_APPEND);
        }
    }
}

?>
