
<?php include("header.php"); ?>
<?php

$hospid = $_GET['hospid'];
$pid = $_GET['pid'];
$datetime = $_GET['datetime'];
$uid = $_GET['studyUID'];

#$Geek = "http://web.rimag.com.cn/Interfaces/Hospitalreport/fetch?hospitalId=$hospid&pId=$pid&datetime=$datetime";
$Geek = "http://web.rimag.com.cn/Interfaces/Hospitalreport/fetch?hospitalId=$hospid&pId=$pid&datetime=2016-01-27%2015:05:56";
$Lee = "http://dcm4.jiangxi.rimag.com.cn:9527/rms/series.html?studyUID=1.2.840.40823.1.1.1.1062.1468505989.267.778.366&PID=P00362750";
#$Lee = "http://dcm4.jiangxi.rimag.com.cn:9527/rms/series.html?studyUID=$uid&PID=$pid";

$Json_Date = json_decode(file_get_contents($Geek));

foreach($Json_Date as $reportIndex => $reportInfo) {

	echo '<ul data-role="listview" data-inset="true">';
	
	echo "<li data-role='list-divider'>影像所见 " . ($reportIndex+1) . ":" . "</li>";
	echo "<li>" . $reportInfo->report_view . "</li>";
	
	echo "<li data-role='list-divider'>影像所得 " . ($reportIndex+1) . ":" . "</li>";
	echo "<li>" . $reportInfo->report_comment . "</li>";
	
	echo "</ul>";
}

#echo "<li><a href='$Geek'>" . "报告" . "</a></li>";

echo '<ul data-role="listview" data-inset="true">';
echo "<li><a href='$Lee'>" . "点击查看患者影像" . "</a></li></ul>";

?>

