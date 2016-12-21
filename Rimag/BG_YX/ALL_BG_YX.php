<?php

include_once "../bin/Connect_mysql.php";

function all_BG_YX() {

	system("rm ALL_BG_MR.txt");
	global $table_name;
	Connect_mysql();
	$TD_date = 'Dec 17 2015';
	$TD_type = 'mr';
	$BG_txt = 'ALL_BG_MR.txt';

	echo '-------------------------------------------' . "\n";
	echo '......Searching, please wait a moment......' . "\n";
	echo '===========================================' . "\n";
	$sql = "SELECT * FROM $table_name where bz='$TD_type' and bgsj LIKE '%$TD_date%'";
	$query = mssql_query($sql);
	$row = mssql_fetch_array($query, MSSQL_NUM);

//	for ($i = 0; $i < mssql_num_fields($query); $i++) {
	for ($i = 0; $i < mysql_num_rows($query); $i++) {
	//	$fp = fopen("$BG_txt", "a");
	//	fread($fp,"$row[1]\n");
	//	fclose($fp);
	print_r("$row[0]\n");

	}
	echo '-------------------------------------------' . "\n";
}
all_BG_YX();
?>
