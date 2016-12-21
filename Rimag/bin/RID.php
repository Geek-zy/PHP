<?php

include_once "Connect_mysql.php";

function rid_data_query($PID_core) {

	global $table_name;
	Connect_mysql();

	$PID = $PID_core;

	echo '-------------------------------------------' . "\n";
	echo '......Searching, please wait a moment......' . "\n";
	echo '===========================================' . "\n";
	$sql = "SELECT * FROM $table_name where YJDH='$PID'";
	$query = mssql_query($sql);
	$row = mssql_fetch_array($query, MSSQL_NUM);
	print_r($row);
	return $row;
	echo '-------------------------------------------' . "\n";
}
?>
