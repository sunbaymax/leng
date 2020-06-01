<?php	
header("Content-type: text/html; charset=utf-8");
$url = "http://www.zjcoldcloud.com/weixin/get_token_zlkj.php";
$access_token=file_get_contents($url);

define("ACCESS_TOKEN", $access_token);

//创建菜单
function createMenu($data){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".ACCESS_TOKEN);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$tmpInfo = curl_exec($ch);
if (curl_errno($ch)) {
  return curl_error($ch);
}

curl_close($ch);
return $tmpInfo;

}

//获取菜单
function getMenu(){
return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".ACCESS_TOKEN);
}

//删除菜单
function deleteMenu(){
return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".ACCESS_TOKEN);
}



//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe215e9ec8c5c3306&redirect_uri=http://www.ccsc58.cc/leng/laojiu/oauth2_templatform.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect

$data = '{
	"button": [
		{
			"type": "view",
			"name": "云平台",
			"url": "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2_templatform.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect",
			"sub_button": []
		}, {
			"name": "智冷服务",
			"sub_button": [
			  {
					"type": "view",
					"name": "产品资料",
					"url": "http://www.ccsc58.cc/weixinnew/menuSwiper/product.html",
					"sub_button": []
				}, {
					"type": "view",
					"name": "售后工单",
					"url": "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2_repair.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect",
					"sub_button": []
				}, {
					"type": "view",
					"name": "历史文章",
					"url": "http://mp.weixin.qq.com/mp/homepage?__biz=MzIxNzU1MzIyNA==&hid=1&sn=dcf2df0452631e6d69908350d4f53ae6#wechat_redirect",
					"sub_button": []
				}, {
					"type": "view",
					"name": "机器人小冷",
					"url": "http://www.ccsc58.cc/IceKnight/Zlservices/main.html",
					"sub_button": []
				}
			]
		}, {
			"name": "关于我们",
			"sub_button": [
				{
					"type": "view",
					"name": "公司首页",
					"url": "http://www.ccsc58.com/",
					"sub_button": []
				}, {
					"type": "click",
					"name": "联系我们",
					"key": "lianxiwomen",
					"sub_button": []
				}, {
					"type": "view",
					"name": "充值缴费",
					"url": "http://www.ccsc58.cc/leng/weixin/index.html",
					"sub_button": []
				},
				 {
					"type": "view",
					"name": "服务费充值",
					"url": "http://www.ccsc58.cc/leng/FreshShield/html/yearfeepay.html",
					"sub_button": []
				}
			]
		}
	]
}';




echo createMenu($data);
//echo getMenu();
//echo deleteMenu();