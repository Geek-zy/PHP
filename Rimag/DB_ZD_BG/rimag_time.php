<?php

$catalog = date('Ymd');
system("mkdir $catalog");

include "../bin/Connect_mysql.php";
date_default_timezone_set("Asia/Shanghai");

$time_start = "-40 minutes";
  $time_end = "-60 minutes";

$Date_start = date('M d y h:i:s', strtotime($time_start));
  $Date_end = date('M d y h:i:s', strtotime($time_end, strtotime($Date_start)));

Connect_mysql();
global $table_name;

echo '-------------------------------------------' . "\n";
echo ".....start_time ==> " . "$Date_end" . ".....\n";
echo ".....e n d_time ==> " . "$Date_start" . ".....\n";
echo '===========================================' . "\n";
$sql = "SELECT * FROM $table_name where bgsj>='$Date_end' and bgsj <= '$Date_start'";
$query = mssql_query($sql);
for ($i = 0; $i < mssql_fetch_array($query); $i++)
{
	$row = mssql_fetch_array($query, MSSQL_NUM);
	$date_txt = "$catalog/$row[1]_$row[0].txt";
	$fp = fopen("$date_txt","a");
	fputs($fp, json_encode(array("PationJSON" => $row)) . "\n");
	print_r($row);
	fclose($fp);
}
echo '-------------------------------------------' . "\n";
?>
