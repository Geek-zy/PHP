
<?php include("header.php"); ?>

<?php

$dcmIP = str_replace("nfs", "dcm",$_SERVER['HTTP_HOST']);
$hospid = $_GET['hospid'];
$pid = $_GET['pid'];
$uid = $_GET['uid'];

$Software = $_GET['software'];

$Geek_Port = "http://web.rimag.com.cn/Interfaces/Hospitalreport/fetch?hospitalId=$hospid&pId=$pid";
//$Geek_Image = "http://$dcmIP:9527/rms/series.html?studyUID=$uid&PID=$pid";
switch ($Software) {

    case "ioviyam":  //�~I~K�~\��~I~H
        //$DCM_URL = 'http://' . $dcmIP . ":" . DicomService::$oviyamPort . "/rms/series.html?studyUID=";
        $Geek_Image = "http://$dcmIP:9527/rms/series.html?studyUID=$uid&PID=$pid";
        break;

    case "rmsweb":   //欧�~T��~[~E
        //$DCM_URL = 'http://' . $dcmIP . ":" . DicomService::$oviyamPort . "/rmsweb/viewer.html?studyUID=";
        $Geek_Image = "http://$dcmIP:9527/rmsweb/viewer.html?studyUID=$uid&PID=$pid";
        break;

    case "weasis":   //��~@�~D~I影�~C~O
        //$DCM_URL = 'http://' . $dcmIP . ":" . DicomService::$oviyamPort . "/weasis-pacs-connector/viewer.jnlp?studyUID=";
        $Geek_Image = "http://$dcmIP:9527/weasis-pacs-connector/viewer.jnlp?studyUID=$uid&PID=$pid";
        break;

    case "yingfeida"://�~K���~^达
        //$DCM_URL = "http://117.41.184.222/pkg_pacs/external_interface.aspx?LID=med&LPW=med&studyUID=";
        $Geek_Image = "http://117.41.184.222/pkg_pacs/external_interface.aspx?LID=med&LPW=med&studyUID=$uid&PID=$pid";
        break;

    default :
        //$DCM_URL = 'http://' . $dcmIP . ":" . DicomService::$oviyamPort . "/rms/series.html?studyUID=";
        $Geek_Image = "http://$dcmIP:9527/rms/series.html?studyUID=$uid&PID=$pid";

        break;
}



$Json_Date = json_decode(file_get_contents($Geek_Port));

if (empty($Json_Date)) {


	echo "<script language='javascript' type='text/javascript'>";  
	//echo "location.href='$Geek_Image'";  
	//echo "window.location.href='$Geek_Image'";
	echo "window.parent.location.href='$Geek_Image'";
	//echo "return false";
	//echo "</script>";exit; 
	echo "</script>";
	echo "<script language='javascript' type='text/javascript'>";
	//echo "history.go(0)";
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

		$patient_cname="$reportInfo->patient_cname";
		$doctor_name="$reportInfo->doctor_name";
		$port_look="$reportInfo->report_view";
		$port_look_OK=str_replace('\r\n', '<br>',$port_look);
		$port_get="$reportInfo->report_comment";
		$port_get_OK=str_replace('\r\n', '<br>',$port_get);
		$report_time="$reportInfo->report_time";

		echo '<ul data-role="listview" data-inset="true">';

		echo "<li data-role='list-divider'>患者姓名" . "：" . "</li>";
		echo "<li>" . $patient_cname . "</li>";

		echo "<li data-role='list-divider'>报告医生" . "：" . "</li>";
		echo "<li>" . $doctor_name . "</li>";

		echo "<li data-role='list-divider'>影像所见" . "：" . "</li>";
		echo "<li>" . $port_look_OK . "</li>";
		//echo "<li>" . $port_look . "</li>";
	
		echo "<li data-role='list-divider'>影像所得" . "：" . "</li>";
		echo "<li>" . $port_get_OK . "</li>";
		//echo "<li>" . $port_get . "</li>";

		echo "<li data-role='list-divider'>报告时间" . "：" . "</li>";
		echo "<li>" . $report_time . "</li>";


		echo "</ul>";
	}

		echo '<ul data-role="listview" data-inset="true">';
		echo "<li><a href='$Geek_Image'>" . "点击查看患者影像" . "</a></li></ul>";
}
?>

