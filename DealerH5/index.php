   <?php
    define("TOKEN", "weixin");
    header("Access-Control-Allow-Origin: *");
    require_once "jssdk.php";
    $jssdk = new JSSDK("wx82dbac04fa8fd8ef", "98ecda31265ffc327d59adc969089650");
    $signPackage = $jssdk->GetSignPackage();
    die (json_encode($signPackage));