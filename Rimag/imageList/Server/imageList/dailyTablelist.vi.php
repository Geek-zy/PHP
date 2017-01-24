<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0,height=device-height,user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <link rel="apple-touch-icon" href="pics/icon.png"/>
        <link rel="apple-touch-icon-precomposed" href="pics/icon.png"/>
        <link rel="shortcut icon" type="image/x-icon" href="jquery/favicon.ico" />
        <link rel='stylesheet' href='jquery/jquery.mobile-1.4.2.min.css'/>
        <script type="text/javascript" src="jquery/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="jquery/jquery.mobile-1.4.2.min.js"></script>
        <script>
        </script>
    </head>
    <body>
        <div data-role="page" id="index" data-fullscreen="true" >
            <div data-role="content" class="content" >
                <div  style="max-width:100%; margin: auto;"><?php
//http://nfs.jiangxi.rimag.com.cn/imageList/json.php?aetitle=JXXYSFYXRMYYCT&startDate=20150729&endDate=20150730
// set the default timezone to use. Available since PHP 5.1
    date_default_timezone_set("Asia/Shanghai"); 

//
// Call
// http://192.168.1.102/~chaoyou/dateList_Fenyi.php?aetitle=JXXYSFYXRMYYCT
// 
// 
//http://nfs.jiangxi.rimag.com.cn/imageList/diagnosticCount.php?aetitle=JXXYSFYXRMYYCT

//    $DailyURL = $dailyFilelist . "?aetitle=$AET&startDate=$currentDayURL&endDate=$currentDayURL";

$AET = $_GET['aetitle'];
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];


$URL = "http://". $_SERVER['HTTP_HOST'] . "/imageList/json.php?aetitle=$AET&startDate=$startDate&endDate=$endDate";
$DCM_URL = "http://". str_replace("nfs", "dcm",$_SERVER['HTTP_HOST']) . ":8080/rms/series.html?studyUID=";
$Detail = json_decode(file_get_contents($URL), true);


$TempArray = $Detail['list'];

$studyID = array_column($TempArray, 'STUDY_ID');

rsort($studyID);
reset($studyID);
$firstElement = current($studyID);
end($studyID);
$lastElement = current($studyID);


for($i=$lastElement;$i<=$firstElement;$i++) {
    if(!in_array($i, $studyID)) echo "$i, ";
}
echo "</font>";
//echo $firstElement . "<br>";
//echo $lastElement . "<br>";

//
//
echo "<table border='1'>";

foreach ($TempArray as $key => $value) {
    echo '<tr><td>' .
            $value["STUDY_ID"] . "</td><td>" . $value["ACCESSION_NO"] . "</td><td>" .
            $value["PATIENT_ID"] . "</td><td>" .
            $value["PATIENT_NAME"] . "</td><td>" .
            $value["PATIENT_SEX"] . "</td><td>"  .
            $value["PATIENT_AGE1"] . "</td><td>"  .
            $value["SERIES_COUNT"] . "</td><td>"  .
            $value["INSTANCE_COUNT"] . "</td><td>"  .  
            $value["STUDY_DTTM"] . "</td><td>"  .  
            $value["FILM_Printed"] . "</td>"  .  
            //$value["CREATION_DTTM"] .
            '</tr>';
}
echo "</table>";
//
//echo "</ul>";
?>


<?php include("footer.php"); ?>
