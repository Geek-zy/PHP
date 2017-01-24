<?php

require_once 'function.php';
$AETITLE = $_REQUEST['aetitle'];

$Conn = getConnection();
//mysql_query("set names 'uft8'");
//$db_database = 'pacsdb';
//$db_selecct = mysql_select_db($db_database);
if (!$db_selecct) {
    die("could not to the database</br>" . mysql_error());
}
$endDate = date('Y-m-d H:i:s', strtotime('+0 day', strtotime(date("Y-m-d")))); //获取第二天凌晨日期
$startDate = date('Y-m-d H:i:s', strtotime('-1 day', strtotime(date("Y-m-d"))));

$Study_Query = "SELECT study.pk as study_pk, instance.pk as instance_pk, sum(files.file_size) as study_size, 
        study.study_datetime as time FROM study
        INNER JOIN series ON series.study_fk = study.pk
        INNER JOIN patient ON study.patient_fk = patient.pk
        INNER JOIN instance ON instance.series_fk = series.pk
        INNER JOIN files ON files.instance_fk = instance.pk
        WHERE series.src_aet LIKE  '%$AETITLE'
        AND study.study_datetime >=  '$startDate'
        AND study.study_datetime <=  '$endDate' group by study.pk";

echo $Study_Query . "<br><br>";


$query = "select count(*) as count, sum(study_size) as size, time from 
    ($Study_Query) as c GROUP BY DATE_FORMAT( time,  '%Y-%m-%d' ) ORDER BY time DESC";

echo $query . "<br><br>";

$result = mysql_query($query);
if (!$result) {
    die("could not to the database</br>" . mysql_error());
}
$MyQueryResult = array();
while ($result_row = mysql_fetch_array(($result), MYSQL_ASSOC)) {
    array_push($MyQueryResult, $result_row);
}
$JSON_String = json_encode(array("list" => $MyQueryResult), true);

echo $JSON_String;

