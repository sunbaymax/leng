<?php

/*
------------------------------------------------------------------
微信支付写入接口：
www.ccsc58.com/json/weixin/01_00_weixin_zhifu_post.php
需要POST数值
$controller=$_POST[controller];      //操作编码，默认register
$admin_permit=$_POST[admin_permit]; //操作允许码，默认permit码暂定为zjly8888
$openid=$_POST[openid];               //openid
$fukuandanwei=$_POST[fukuandanwei];   //付款单位
$money=$_POST[money];                 //钱数
返回：{"code":10000,"message":"success","resultCode":"success"} 为成功
------------------------------------------------------------------
 */

header("Content-Type: text/html; charset=utf-8");
header("Access-Control-Allow-Origin: *"); //解决跨域问题
include "connW_weixin.inc";
$arr = array();

$controller = $_POST[controller]; //操作编码
$admin_permit = $_POST[admin_permit]; //操作允许码，默认permit码暂定为zjly8888

$openid = $_POST[openid];
$tel = $_POST[tel];
$username = $_POST[username];
$fukuandanwei = $_POST[fukuandanwei];
$money = $_POST[money];
$danhao = $_POST[danhao];
$time = date("Y-m-d H:i:s"); //时间;

if ($admin_permit == "zjly8888") {
    if ($controller == "register") {
        $INS = mysql_query("insert into lykj_weixinzhifu(
                openid,fukuandanwei,money,time,tel,username,danhao)
                Values ('$openid','$fukuandanwei','$money','$time','$tel','$username','$danhao')");
        if ($INS == true) {
            //成功
            //oSPfHv31aoyEYqDG1k-y_wZqV80M 张 oSPfHv6VlfxV4bRPRatRl1BtNl8Q刘之榕
            $m123Arr = array("oSPfHv31aoyEYqDG1k-y_wZqV80M", "oSPfHv-pXx-_E5jFehQHWQy1lpmI", "oSPfHv17xGpC6zVfDQ-bErQf-cko", "oSPfHv84aKIanXMRwVie1dGybNxQ", "oSPfHv1vTpBnh_tiJ4X6-2lFnmEE", "oSPfHv8Ir9Nwt9xArDUbwPr5Pt2Q");
            $url = "http://www.ccsc58.cc/leng/lengyunjiekou.php";
            $data = array(
                'success' => '收款成功',
                'danhao' => '暂无',
                'money' => $money,
                'username' => $username,
                'company' => $fukuandanwei,
                'cb' => $openid,
                'm123' => '',
                'app_key' => '261AFF68C0E9F076420D083D66222824',
            );

            foreach ($m123Arr as $value) {
                $data['m123'] = $value;
                $message = [];
                foreach ($data as $key => $v) {
                    $message[] = "{$key}={$v}";
                }
                $rt = http_request($url, implode('&', $message));
            }

            $arr[code] = 10000;
            $arr[message] = 'success';
            $arr[resultCode] = 'success';
        } else {
            $arr[code] = 30000;
            $arr[message] = 'fail';
            $arr[resultCode] = 'fail';
        }
    }
} else {
    $arr[code] = 30000;
    $arr[message] = 'fail';
    $arr[resultCode] = 'Nopermit';
}
$returns = stripslashes(json_encode($arr)); //删除反斜杠
echo $returns;

/**
 * Curl版本
 * 使用方法：
 * $post_string = "app=request&version=beta";
 * request_by_curl('http://facebook.cn/restServer.php',$post_string);
 */
function http_request($remote_server, $post_string) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $remote_server);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'mypost=' . $post_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Jimmy's CURL Example beta");
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
