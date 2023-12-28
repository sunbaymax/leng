<?php	
header("Content-type: text/html; charset=utf-8");
$url = "http://www.ccsc58.com/weixin/get_token_zlkj.php";
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
			"name": "温控平台",
			"sub_button": [
				{
					"type": "miniprogram",
					"name": "小程序版",
					"url": "http://mp.weixin.qq.com",
					"appid": "wx28db04fa5b729118",
					"pagepath": "pages/index/index"
				}, {
					"type": "view",
					"name": "微信版",
					"url": "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2_templatform.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect",
					"sub_button": []
				}, {
					"type": "view",
					"name": "电脑版",
					"url": "https://mp.weixin.qq.com/s?__biz=MzIxNzU1MzIyNA==&mid=2247485770&idx=2&sn=27cbf7403467ecc0192c44bee311a05a&chksm=97f9496da08ec07b83027d93ce9afc15c1a0ca83c6179ae41c46990582bd9f905283dc08a97f&token=1988235242&lang=zh_CN#rd",
					"sub_button": []
				}, {
					"type": "view",
					"name": "微信报警",
					"url": "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/oauth2_messbangding.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect",
					"sub_button": []
				}
			]
			
		}, {
			"type": "miniprogram",
			"name": "智冷商城",
			"url": "http://mp.weixin.qq.com",
			"appid": "wx2f42e1cbacc765d8",
			"pagepath": "pages/common/blank-page/index?weappSharePath=pages%2Fhome%2Fdashboard%2Findex%3Fkdt_id%3D91813120"
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
					"url": "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx029d1989acb9f44c&redirect_uri=http://www.ccsc58.cc/leng/RepairOrder/oauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect",
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