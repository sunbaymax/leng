<?php
header("Content-Type: text/html; charset=utf-8");
header("Access-Control-Allow-Origin: *");//解决跨域问题
//////////////////////////////////准备本地数据库
$conn = mysql_connect("rm-2ze3o57ph836pk46r.mysql.rds.aliyuncs.com", "test01", "Pzg790915");
mysql_select_db("wlgl", $conn);
mysql_query("set names utf-8", $conn);
function Curl()
{
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxc03267326573b6b5&secret=b7eb8ceb3970004911adbb83ca296bde";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $data = curl_exec($ch);
    curl_close($ch);
    $res = json_decode($data, true);
    //echo '<pre>';
    //print_r($res);die;
    return $res['access_token'];
}

function Serilizable()
{
    global $conn;
    $appid = "wxc03267326573b6b5";
    $secret = "b7eb8ceb3970004911adbb83ca296bde";
    $sql = 'select A_ID,A_Token,A_Date from tb_accesstoken_shuangbaotai order by A_ID desc';
    $rs = mysql_query($sql);
    $times = time();
    $row = mysql_fetch_array($rs);
    $rownum = mysql_num_rows($rs);
    if ($rownum == 0) {
        $timestamp = time() + 6000;//每隔100分钟重新获取token
        $token = Curl();
        $sqlin = "INSERT INTO `tb_accesstoken_shuangbaotai` (`A_Token`, `A_Date`) VALUES ('" . $token . "', '" . $timestamp . "')";
        mysql_query($sqlin, $conn);
        return $token;
    } else {
        if ((int)$row['A_Date'] < $times) {
            $token = Curl();
            $timestamp = time() + 6000;
            $sqlu = "UPDATE tb_accesstoken_shuangbaotai SET A_Token='" . $token . "',A_Date=" . $timestamp . ",`date` = '" . date("Y-m-d H:i:s") . "' WHERE (A_ID=" . $row['A_ID'] . ")";
            mysql_query($sqlu);
            return $token;
        } else {
            return $row['A_Token'];
        }
    }
}

$token = Serilizable();
echo $token;
	
	
	
	
	
	
