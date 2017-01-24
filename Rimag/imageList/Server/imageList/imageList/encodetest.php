<?php
header("Content-Type:text/html;charset=utf-8");
$db_host='localhost';
$db_database='pacsdb';
$db_username='pacs';
$db_password='pacs';
$connection=mysql_connect($db_host,$db_username,$db_password);//连接到数据库
mysql_query("set names 'latin1'");//编码转化
if(!$connection){
die("could not connect to the database:</br>".mysql_error());//诊断连接错误
}
$db_selecct=mysql_select_db($db_database);//选择数据库
if(!$db_selecct)
{
die("could not to the database</br>".mysql_error());
}
$query = "select pat_name from patient where pat_id in('13326','13325','ct19235','20447','1964')";
$result=mysql_query($query);//执行查询
if(!$result)
{
die("could not to the database</br>".mysql_error());

}

while($result_row=mysql_fetch_row($result)){
	echo "------------------";	
	print_r(iconv('GBK','UTF-8',$result_row[0]));
//	print_r($result_row);
	echo "--+++++++++-";
	}

mysql_close($connection);//关闭连接
?>
