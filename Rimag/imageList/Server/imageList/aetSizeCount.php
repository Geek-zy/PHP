<?php

//http://nfs3.jiangxi.rimag.com.cn/imageListTest/aetSizeCount.php?hospid=116&startdate=2016-05-19

require_once 'function.php';
$pdo = MySQL_PHP7_nfs3();

if ($_GET['hospid'] == null) {
    echo json_encode(array("hospid is null"));
    die;
}
if ($_GET['startdate'] === null) {
    echo json_encode(array("startdate is null"));
    die;
}
if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$_GET['startdate']))
    {
    echo json_encode(array("startdate format is wrong"));
    die;
    }
    
$HospID = $_GET['hospid'];
$startDate = new DateTime($_GET['startdate']);

$URL = "http://web.rimag.com.cn/Interfaces/index/getHospitalAetList/hospitalId/" . $HospID;
$Detail = json_decode(file_get_contents($URL), true);
$diskUsageArray = array();

foreach ($Detail[0]['aet'] as $AETIndex => $AETvalue) {
    array_push($diskUsageArray, diagnosticSpaceCount($pdo, $AETvalue['aet'], $startDate));
}
unset($pdo);

$finalArry = array();
foreach (array_filter($diskUsageArray) as $AETIndex => $Content) {
    array_push($finalArry, $Content);
}

echo json_encode($finalArry);

