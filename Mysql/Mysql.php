<?php

$DB_Name = "Yi_Zhang";
$Table_Name = "main";

//php PDO 连接Mysql 数据库
function _Mysql() {

	$host = "localhost";
	$user = "root";
	$passwd = "root";

	try {
		$link = new PDO("mysql:host=$host", $user, $passwd, array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
		echo "连接成功\n"; 
	}

	catch(PDOException $e) {

		echo "连接失败 ==> ";
		echo $e->getMessage() . "\n";
		exit;
	}

	return $link;
}


function Start_Mysql() {

	global $DB_Name;
	$host = "localhost";
	$user = "root";
	$passwd = "root";

	try {
		$link = new PDO("mysql:host=$host; dbname=$DB_Name", $user, $passwd, array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
		//echo "连接成功\n"; 
	}

	catch(PDOException $e) {

		echo "连接失败 ==> ";
		echo $e->getMessage() . "\n";
		exit;
	}

	return $link;
}

//建库
function Mysql_DB() {

	global $DB_Name;
    $pdo = _Mysql();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $sql = "create database $DB_Name default character set utf8 collate utf8_general_ci"; 
    $pdo->exec($sql);

    echo "数据库创建成功\n";
}


//建表
function Mysql_Table() {

	global $DB_Name;
    global $Table_Name;
    $pdo = Start_Mysql();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	$sql = 
		"create table $Table_Name (

	       id int unsigned not null auto_increment primary key comment '序号',
	       Tag char(16) not null comment '软件编号',
	       Name text not null comment '软件名称',
	       Version text not null comment '软件版本',
	       Introduce text not null comment '软件简介',
		   Class text not null comment '软件类别',
	       Worked_OS text not null comment '运行环境',
	       Course_URL text not null comment '教程地址',
	       Download_URL text not null comment '下载地址',
	       Image_URL text not null comment '图标地址',
	       Remarks_1 text null default '' comment '备注1',
		   Remarks_2 text null default '' comment '备注2'
		  )
	   comment='main表是所有软件的信息表'";

    $pdo->exec($sql); 

    echo "数据表创建成功\n"; 
}


//插入数据
function Mysql_Data() {

	global $DB_Name;
	global $Table_Name;
    $pdo = Start_Mysql();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	$sql =
		"insert into $Table_Name (id, Tag, Name, Version, Introduce, Class, Worked_OS, Course_URL, Download_URL, Image_URL, Remarks_1, Remarks_2) 
		values (NULL, '软件编号', '软件名称', '软件版本', '软件简介', '软件类别', '运行环境', '教程地址', '下载地址', '图标地址', '备注1', '备注2');
		";

	$pdo->exec($sql); 

	echo "新数据插入成功\n"; 
}


//遍历数据库
function Mysql_Select() {
	
	global $Table_Name;
	$pdo = Start_Mysql();
	$sql = "select * from $Table_Name";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$PatientInfo = array();
	
	if(empty($stmt->fetch(PDO::FETCH_ASSOC))) {

		exit;
	}
 	 
	$stmt->execute();//将指针指向头
	while ( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {

		array_push($PatientInfo, $row);
	}
	 
	print_r($PatientInfo);
	return $PatientInfo;
}


//升级数据库字段数据
function Mysql_Update() {

	global $Table_Name;
	$pdo = Start_Mysql();
	$_Table = Mysql_Select();

	foreach ($_Table as $Key => $value) {

		$Date = explode(" ", $value['Name']);
		$Date_Num = count($Date);
		$ID = $value['id'];
		$sql = "update $Table_Name set Name = $Date_Num where id = $ID";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$PatientInfo = array();
	}   
		echo "数据已更新\n";
}


//删除数据库数据
function Mysql_Delete() {

	global $Table_Name;
	$pdo = Start_Mysql();
	$_Table = Mysql_Select();

	foreach ($_Table as $Key => $value) {

		$sql = "delete from $Table_Name where id = 1";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$PatientInfo = array();
	}   
	echo "数据已删除\n";
}


_Mysql();
Mysql_DB();
Mysql_Table();
Mysql_Data();
Mysql_Select();
Mysql_Update();
Mysql_Delete();

//关闭数据库
$link = null;

?>
