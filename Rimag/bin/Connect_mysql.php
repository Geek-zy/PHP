<?php

global $table_name;

$table_name = "his.v_ymyg_yjbgd";

function Connect_mysql() {

	global $table_name;

	$server = '10.3.1.5\hissql';
	$username = "jk_ymyg";
	$password = "ymyg@XXK#802";
	$db_name = "NCEFY_ZY";
	
	$link = mssql_connect($server, $username, $password);

	if (!$link) {

		die('Something went wrong while connecting to MSSQL');
	}

	$db_selected = mssql_select_db($db_name, $link);

	if (!$db_selected) {

		die ("Can't use test_db : " . mssql_error());
	}
}
?>
