<?php include("header.php"); ?>
<?php
//http://nfs.jiangxi.rimag.com.cn/imageList/json.php?aetitle=JXXYSFYXRMYYCT&startDate=20150729&endDate=20150729
// set the default timezone to use. Available since PHP 5.1
    date_default_timezone_set("Asia/Shanghai"); 
require_once 'function.php';

//
// Call
// http://192.168.1.102/~chaoyou/dateList_Fenyi.php?aetitle=JXXYSFYXRMYYCT
// 
// 
//http://nfs.jiangxi.rimag.com.cn/imageList/diagnosticCount.php?aetitle=JXXYSFYXRMYYCT

$today = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
$earlyDay = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")-30, date("Y")));
$MaxDays = 30;
$AET = $_GET['aetitle'];
$dailyFilelist = "dailyTablelist.php";

$Today = $tomorrow  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));

$CountURL = str_replace("tableList_Fenyi.php", "diagnosticCount.php", $_SERVER['SCRIPT_NAME']);
$CountURL = "http://" . $_SERVER['HTTP_HOST'] . "$CountURL?aetitle=$AET";


$Count = json_decode(file_get_contents($CountURL), true);

$TempArray = array();
$SizeArray = array();
foreach ($Count['list'] as $key => $value) {
    $TempArray[substr($value['time'],0,10)]= $value['count'];
    $SizeArray[substr($value['time'],0,10)]= formatSizeUnits($value['size']);

}


echo "<table border='0' >";
for($Index=0; $Index<=$MaxDays; $Index++){
    $currentDay = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")-$Index, date("Y")));
    $currentDayURL = date("Ymd", mktime(0, 0, 0, date("m")  , date("d")-$Index, date("Y")));
    $DailyURL = $dailyFilelist . "?aetitle=$AET&startDate=$currentDayURL&endDate=$currentDayURL";
    $currentCount = ($TempArray[$currentDay]==null) ? "0": $TempArray[$currentDay];
    $currentSize = ($SizeArray[$currentDay]==null) ? "0": $SizeArray[$currentDay];
    $currentSize = str_replace(" MB", "", $currentSize);
    echo "<tr align='right'><td>$currentDay</td><td>$currentCount</td><td>$currentSize</td><td><a href=\"$DailyURL\">详情</a></td></tr>";
}

echo "</table>";
?>


<?php include("footer.php"); ?>
