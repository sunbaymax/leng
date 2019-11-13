<?php


// require_once('mysql.class.php');
// $db = new class_mysql();
// $mysql_state2 = "INSERT INTO `departer` (`id`, `openid`, `name`, `telephone`, `question1`, `question2`, `question3`, `question4`) VALUES (NULL, '".$openid."', '".$name."', '".$telephone."', '".$sex."', '".$orientedstr."', '".$depart."', '".$bearstr."');";
// $result = $db->query($mysql_state2);


require_once('config.php');   //引用配置

class class_mysql
{
	var $link_id    = NULL;

    function __construct(){
//      $host = MYSQLHOST;
//      $port = MYSQLPORT;
//      $user = MYSQLUSER;
//      $pwd =  MYSQLPASSWORD;
//      $dbname = MYSQLDATABASE;
        $host="rm-2ze3o57ph836pk46r.mysql.rds.aliyuncs.com";
        $port = "3306";
		$user="test01";
		$pwd="Pzg790915";
		$bdname="wlgl";

        $this->link_id = @mysql_connect("{$host}:{$port}", $user, $pwd, true);
        if(!$this->link_id){
            return "Connect Server Failed: " . mysql_error($this->link_id);
        }
        mysql_query("SET NAMES 'UTF8'");
        if(!mysql_select_db($dbname, $this->link_id)) {
            return "Select Database Failed: " . mysql_error($this->link_id);
        }
        return $this->link_id;
    }

    //返回数组
    function fetch_array($sql){
        $result = mysql_query($sql);
        if(!$result)return false;
        $arr = array();
        while ($row = mysql_fetch_array($result)) {
            $arr[] = $row;
        }
        return $arr;
    }
	
    //返回数组第0条
    function fetch_array_one($sql){
        $result = mysql_query($sql);
        if(!$result)return false;
        $arr = array();
        while ($row = mysql_fetch_assoc($result)) {
            $arr[] = $row;
            return $arr[0];
        }
        return;
    }
	
    //判断记录是否存在
    function record_is_exist($table, $field, $value){
        $result = mysql_query("SELECT * FROM  `$table` WHERE  `$field` =  '$value' LIMIT 0 , 1");
        $arr = array();
        while ($row = mysql_fetch_array($result)) {
            $arr[] = $row;
        }
		if (count($arr) > 0){
			return true;
		}else{
			return false;
		}
    }
	
    //返回数组第0条
    function query_array_first($sql){
        $result = mysql_query($sql);
        if(!$result)return false;
        $arr = array();
        while ($row = mysql_fetch_assoc($result)) {
            $arr[] = $row;
            return $arr[0];
        }
        return;
    }

    //只执行
    function query($sql)
    {
        return  mysql_query($sql);
    }

    function getCol($sql)
    {
        $res = $this->query($sql);
        if ($res !== false)
        {
            $arr = array();
            while ($row = mysql_fetch_row($res))
            {
                $arr[] = $row[0];
            }

            return $arr;
        }
        else
        {
            return false;
        }
    }

    //返回记录条数,update,insert
    function affected_rows($sql){
        $result = mysql_query($sql);
        return $result?mysql_affected_rows():false;
    }

    //返回记录条数,select
    function records($sql){
        if($result = mysql_query($sql))
			return mysql_num_rows($result);
		else return -1;
    }

    function num_rows($sql)
    {
        return mysql_num_rows($sql);
    }

    function num_fields($sql)
    {
        return mysql_num_fields($sql);
    }

    function free_result($sql)
    {
        return mysql_free_result($sql);
    }

    function fetchRow($sql)
    {
        return mysql_fetch_assoc($sql);
    }

    function fetch_fields($sql)
    {
        return mysql_fetch_field($sql);
    }
}
?>