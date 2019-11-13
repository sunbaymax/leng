<?php

/***配置微信参数***/



/***配置数据库***/
if (($_SERVER['REMOTE_ADDR'] == "127.0.0.1" ) || ($_SERVER['REMOTE_ADDR'] == "localhost" )){
    define("MYSQLHOST", "127.0.0.1");
    define("MYSQLPORT", "3306");
    define("MYSQLUSER", "root");
    define("MYSQLPASSWORD", "root");
    define("MYSQLDATABASE", "aunt"); 
}else if(isset($_SERVER['HTTP_APPNAME'])){        //SAE
    define("MYSQLHOST", SAE_MYSQL_HOST_M);
    define("MYSQLPORT", SAE_MYSQL_PORT);
    define("MYSQLUSER", SAE_MYSQL_USER);
    define("MYSQLPASSWORD", SAE_MYSQL_PASS);
    define("MYSQLDATABASE", SAE_MYSQL_DB);
}else{
    define("MYSQLHOST", "rm-2ze3o57ph836pk46r.mysql.rds.aliyuncs.com");
    define("MYSQLPORT", "3306");
    define("MYSQLUSER", "utest01");
    define("MYSQLPASSWORD", "Pzg790915");
    define("MYSQLDATABASE", "wlgl");
}
?>