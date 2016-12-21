<?php
// Server in the this format: <computer>\<instance name> or
// <server>,<port> when using a non default port number
$server = '10.3.1.5\hissql';
$username = "jk_ymyg";
$password = "ymyg@XXK#802";
$db_name = "NCEFY_ZY";
$table_name = "his.v_ymyg_yjbgd";
// Connect to MSSQL
$link = mssql_connect($server, $username, $password);

//$SerialNumber = $argv[1];

if (!$link) {
	die('Something went wrong while connecting to MSSQL');
}

$db_selected = mssql_select_db($db_name, $link);

if (!$db_selected)
{
	die ("Can\'t use test_db : " . mssql_error());
}

// Get all mssql tables and put them in variable tables.
if ($link) {
	$result = mssql_query('select table_name from information_schema.tables order by table_name', $link);
	while ($row = mssql_fetch_row($result)) {
		$tables[] = $row[0];
	}
}
else {
	echo 'Database connection failed while getting list of all tables in mssql.';
}
//mssql_close($link);

// Print MSSQL table list.
//print_r($tables);


//echo $SerialNumber . PHP_EOL;
// Send a select query to MSSQL
//$sql = "SELECT * FROM $table_name where YJDH=$SerialNumber";
$sql = "SELECT * FROM $table_name where ZPDANO='H0020864'";
//$sql = "SELECT * FROM his.v_ymyg_yjbgd";
$query = mssql_query($sql);


   echo '===============', PHP_EOL;
   for ($i = 0; $i < mssql_num_fields($query); ++$i) {
   echo ' - ' . mssql_field_name($query, $i), PHP_EOL;
   }



$row = mssql_fetch_array($query, MSSQL_NUM);

print_r($row[1]);

// Free the query result
//mssql_free_result($query);
//echo json_encode(array("reportinfo" => $row));
