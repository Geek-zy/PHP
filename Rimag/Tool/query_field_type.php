<?php

include_once "../bin/Connect_mysql.php";

global $table_name;
Connect_mysql();
echo '-------------------------------------------' . "\n";
echo '......Searching, please wait a moment......' . "\n";
echo '===========================================' . "\n";

$sql = "SELECT * FROM $table_name where ZPDANO='H0020864'";
$query = mssql_query($sql);
$row = mssql_fetch_array($query, MSSQL_NUM);

for ($i = 0; $i < mssql_num_fields($query); ++$i) {

	echo "\t\t" . "[$i]" . " ==> " . mssql_field_name($query) . "\n";
}
print_r($row);
echo '-------------------------------------------' . "\n";
?>
