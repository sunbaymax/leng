<?php
 //$db=new ClassMysql();
 
class ClassMysql{ 
	function __construct(){
		$host="rm-2ze3o57ph836pk46r.mysql.rds.aliyuncs.com";
		$user="test01";
		$pwd="Pzg790915";
		$bdname="wlgl";
		$link=mysql_connect($host,$user,$pwd);
		
		if(!$link){
		echo "失败!"; 
		} 
        else {
        echo "成功!"; 
		
		mysql_select_db($bdname,$link);
		mysql_query("set names 'utf8'");
        }
	}
	function query($sql){
		if(!($query=mysql_query($sql))){
			return $query;
		}
		return $query;
	}
	function query_array($sql){
		$result=mysql_query($sql);
		if(!$result)return false;
		$arr=array();
		while($row=mysql_fetch_array($result)){
			$arr[]=$row;
		}
		return $arr;
	}
}
?>