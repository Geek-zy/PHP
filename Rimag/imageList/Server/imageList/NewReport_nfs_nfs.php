
<?php include("header.php"); ?>

<?php

$URL = $_SERVER['HTTP_HOST'];
$hospid = $_GET['hospid'];
$pid = $_GET['pid'];
$uid = $_GET['uid'];

$Geek_Port = "http://web.rimag.com.cn/Interfaces/Hospitalreport/fetch?hospitalId=$hospid&pId=$pid";
$Geek_Image = "http://$URL:9527/rms/series.html?studyUID=$uid&PID=$pid";

$Json_Date = json_decode(file_get_contents($Geek_Port));

if (empty($Json_Date)) {


	echo "<script language='javascript' type='text/javascript'>";  
	//echo "location.href='$Geek_Image'";  
	//echo "window.location.href='$Geek_Image'";
	echo "window.parent.location.href='$Geek_Image'";
	//echo "</script>";exit; 
	echo "</script>";
	echo "<script language='javascript' type='text/javascript'>";
	echo "history.go(0)";
	echo "</script>";
	//echo "<script language='javascript' type='text/javascript'>";  
	//echo 'history.replaceState({}, "dailyFilelist", "dailyFilelist.php")';
	//echo "</script>";
exit;
	/*
	echo '<ul data-role="listview" data-inset="true">';
	echo "<li data-role='list-divider'>温馨提示：</li>";
	echo "<li>未找到影像报告或影像报告不存在</li>";
	*/
}

else {

	foreach($Json_Date as $reportIndex => $reportInfo) {

		$doctor_name="$reportInfo->doctor_name";
		$port_look="$reportInfo->report_view";
		$port_look_OK=str_replace('\r\n', '<br>',$port_look);
		$port_get="$reportInfo->report_comment";
		$port_get_OK=str_replace('\r\n', '<br>',$port_get);
		$report_time="$reportInfo->report_time";

		echo '<ul data-role="listview" data-inset="true">';
	
		echo "<li data-role='list-divider'>报告医生" . "：" . "</li>";
		echo "<li>" . $doctor_name . "</li>";

		echo "<li data-role='list-divider'>影像所见" . "：" . "</li>";
		echo "<li>" . $port_look_OK . "</li>";
	
		echo "<li data-role='list-divider'>影像所得" . "：" . "</li>";
		echo "<li>" . $port_get_OK . "</li>";

		echo "<li data-role='list-divider'>报告时间" . "：" . "</li>";
		echo "<li>" . $report_time . "</li>";


		echo "</ul>";
	}

		echo '<ul data-role="listview" data-inset="true">';
		echo "<li><a href='$Geek_Image'>" . "点击查看患者影像" . "</a></li></ul>";
}
?>

