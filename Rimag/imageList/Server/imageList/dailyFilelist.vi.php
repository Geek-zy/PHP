<?php include("header.php"); ?>
<?php include("dicom.class.php"); ?>
<?php
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
$Software = $_GET['software'];

$URL = 'http://' . $_SERVER['HTTP_HOST'] . "/imageList/json.php?aetitle=$AET&startDate=$startDate&endDate=$endDate";
//$URL = str_replace("dailyFilelist.php", "json.php", $_SERVER['SCRIPT_NAME']);
//$URL = "http://" . $_SERVER['HTTP_HOST'] . "$URL?aetitle=&startDate=$startDate&endDate=$endDate";
$dcmIP = str_replace("nfs", "dcm",$_SERVER['HTTP_HOST']); 

switch ($Software) {
    case "ioviyam":  //手机版
        $DCM_URL = 'http://' . $dcmIP . ":" . DicomService::$oviyamPort . "/rms/series.html?studyUID=";
        break;
    case "rmsweb":   //欧唯雅
        $DCM_URL = 'http://' . $dcmIP . ":" . DicomService::$oviyamPort . "/rmsweb/viewer.html?studyUID=";
        break;
    case "weasis":   //一脉影像
        $DCM_URL = 'http://' . $dcmIP . ":" . DicomService::$oviyamPort . "/weasis-pacs-connector/viewer.jnlp?studyUID=";
        break;
    case "yingfeida"://英飞达
        $DCM_URL = "http://117.41.184.222/pkg_pacs/external_interface.aspx?LID=med&LPW=med&studyUID=";
        break;
    default :
        $DCM_URL = 'http://' . $dcmIP . ":" . DicomService::$oviyamPort . "/rms/series.html?studyUID=";
        break;
}

$Detail = json_decode(file_get_contents($URL), true);


$TempArray = $Detail['list'];

$studyID = array_column($TempArray, 'STUDY_ID');


rsort($studyID);
$studyID = array_reverse($studyID);
reset($studyID);

$firstElement = current($studyID);
end($studyID);
$lastElement = current($studyID);
switch ($AET) {
    case "JXEFYY2MR":
        while ($lastElement > 51000) {
            array_pop($studyID);
            end($studyID);
            $lastElement = current($studyID);
        }
        break;      
}

if(!in_array($AET, $NoIndex)) {
  echo "可能遗失：<font color='red'>";

  for($i=$firstElement;$i<=$lastElement;$i++) {
      if(!in_array($i, $studyID)) echo "$i, ";
  }
  echo "</font>";
}

//echo $firstElement . "<br>";
//echo $lastElement . "<br>";

 $TotalFilm = array_sum(array_column($TempArray,'FILM_Printed'));
 $TotalAWFilm = array_sum(array_column($TempArray,'AW_Printed'));
 echo "<br>打印胶片: $TotalFilm";
 echo "<br>打印AW胶片: $TotalAWFilm";
 echo "<br>共做检查: " . count($TempArray);
 echo "<br>平均胶片: " . round(floatval(($TotalFilm+$TotalAWFilm)/count($TempArray)),2);
//
//
echo '<ul data-role="listview" data-filter="true" data-filter-placeholder="输入关键字" data-inset="true" class="ui-mini">';
echo '<li> ID---姓名---性别---年龄---序列---影像---时间</li>';

foreach ($TempArray as $key => $value) {
	$TotalFilm = intval($value["FILM_Printed"])+intval($value["AW_Printed"]);
    echo '<li><a href="'. $DCM_URL. $value["STUDY_INSTANCE_UID"] . '&PID=' . $value["PATIENT_ID"] . '">'.
            $value["STUDY_ID"] . "<br>" . $value["ACCESSION_NO"] . "<br>" .
            $value["PATIENT_ID"] . "--" .
            $value["PATIENT_NAME"] . "--" .
            $value["PATIENT_SEX"] . "--"  .
            $value["PATIENT_AGE1"] . "--"  .
            $value["SERIES_COUNT"] . "--"  .
            $value["INSTANCE_COUNT"] . "<br>"  .  
            $value["STUDY_DTTM"] . "<br>"  .  
            "报告: " . $value["REPORT"] . "<br>"  .  
            "胶片总数: " . $TotalFilm . "<br>"  .  
            "胶片: " . $value["FILM_Printed"] . "<br>"  .  
            "AW胶片: " . $value["AW_Printed"] . "<br>"  .  
            //$value["CREATION_DTTM"] .
            '</a></li>';
}
//
//echo "</ul>";

?>


<?php include("footer.php"); ?>
