<?php

// 微信兼容方法
class Http
{
    
    public static function get($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//将返回结果进行转换
        $res = curl_exec($ch);//发送请求
        return $res;//将结果返返回
    }


    public static function post($url, $filedata)
    {
        $curl = curl_init();
        if(class_exists('./CURLFile'))//php5.5跟php5.6中的CURLOPT_SAFE_UPLOAD的默认值不同
        {
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
        }else
        {
            if(defined('CURLOPT_SAFE_UPLOAD'))
            {
                curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
            }
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if(!empty($filedata))
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $filedata);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}
