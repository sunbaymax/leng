<?php

define('APPID',"wx029d1989acb9f44c");
define('APPSECRET',"b7a482220530d3be2278429bdf2a7a63");


class class_weixin
{
    var $appid = APPID;
    var $appsecret = APPSECRET;

    //构造函数，获取Access Token
    public function __construct($appid = NULL, $appsecret = NULL)
    {
    	$url = "http://www.zjcoldcloud.com/weixin/get_token_zlkj.php";
	    $access_token=file_get_contents($url);
	    return $access_token;
	    
//      if($appid && $appsecret){
//          $this->appid = $appid;
//          $this->appsecret = $appsecret;
//      }
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
        
    }

    //生成OAuth2的URL
    public function oauth2_authorize($redirect_url, $scope, $state = NULL)
    {
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=".$redirect_url."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";
        return $url;
    }

    //生成OAuth2的Access Token
    public function oauth2_access_token($code)
    {
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appid."&secret=".$this->appsecret."&code=".$code."&grant_type=authorization_code";
        $res = $this->http_request($url);
        return json_decode($res, true);
    }

    //获取用户基本信息（OAuth2 授权的 Access Token 获取 未关注用户，Access Token为临时获取）
    public function oauth2_get_user_info($access_token, $openid)
    {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $res = $this->http_request($url);
        return json_decode($res, true);
    }

    //获取用户基本信息
    public function get_user_info($openid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->access_token."&openid=".$openid."&lang=zh_CN";
        $res = $this->http_request($url);
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
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}
