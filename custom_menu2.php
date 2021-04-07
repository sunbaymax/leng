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
			"name": "云平台",
			"sub_button": [
				{
					"type": "view",
					"name": "温控平台",
					"url": "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2_templatform.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect",
					"sub_button": []
				}, {
					"type": "miniprogram",
					"name": "智慧养殖",
					"url": "http://mp.weixin.qq.com",
					"appid": "wx3aefe01c475fe181",
					"pagepath": "pages-breed/Login/main"
				}
			]
		}, {
			"type": "view",
			"name": "智冷商城",
			"url": "https://shop92005288.youzan.com/v2/showcase/homepage?alias=8BZnwKvlhe&dc_ps=2665872149977290753.300001",
			"sub_button": []
		},{
			"name": "智冷服务",
			"sub_button": [
				{
					"type": "view",
					"name": "产品资料",
					"url": "http://www.ccsc58.cc/weixinnew/menuSwiper/product.html",
					"sub_button": []
				},
				{
					"type": "view",
					"name": "发票申请",
					"url": "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/mobileinvoice/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect",
					"sub_button": []
				},
				{
					"type": "view",
					"name": "设备报修",
					"url": "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2_repair.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect",
					"sub_button": []
				},
				{
					"type": "view",
					"name": "充值缴费",
					"url": "http://www.ccsc58.cc/leng/mypay/index.html",
					"sub_button": []
				},
				{
					"type": "view",
					"name": "联系我们",
					"url": "http://www.ccsc58.cc/weixinnew/menuSwiper/contact.html",
					"sub_button": []
				}
			]
		}
	]
}';




echo createMenu($data);
//echo getMenu();
//echo deleteMenu();