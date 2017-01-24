<?php include("header.php"); ?>
<?php
//http://nfs.jiangxi.rimag.com.cn/imageList/json.php?aetitle=JXXYSFYXRMYYCT&startDate=20150729&endDate=20150729
// set the default timezone to use. Available since PHP 5.1
    date_default_timezone_set("Asia/Shanghai"); 

//
// Call
// http://192.168.1.102/~chaoyou/dateList_Fenyi.php?aetitle=JXXYSFYXRMYYCT
// 
// 
//http://nfs.jiangxi.rimag.com.cn/imageList/diagnosticCount.php?aetitle=JXXYSFYXRMYYCT

$today = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
$earlyDay = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")-30, date("Y")));
$MaxDays = 31;
$AET = $_GET['aetitle'];
$Software = $_GET['software'];
$dailyFilelist = "dailyFilelist.php";

//Geek
$hospid=$_GET['hospID'];

$Today = $tomorrow  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));

$CountURL = str_replace("dateList_Fenyi.php", "monthly_statistics.php", $_SERVER['SCRIPT_NAME']);
$CountURL = "http://" . $_SERVER['HTTP_HOST'] . "$CountURL?aetitle=$AET";
$Count = json_decode(file_get_contents($CountURL), true);
$TempArray = array();
foreach ($Count as $key => $value) {
    $TempArray[substr($value['time'],0,10)]= $value['count'];
}

echo '<ul data-role="listview" data-inset="true" class="ui-mini">';
for($Index=0; $Index<=$MaxDays; $Index++){
    $currentDay = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")-$Index, date("Y")));
    $currentDayURL = date("Ymd", mktime(0, 0, 0, date("m")  , date("d")-$Index, date("Y")));
//Geek
    $DailyURL = $dailyFilelist . "?software=$Software&aetitle=$AET&startDate=$currentDayURL&endDate=$currentDayURL&hospid=$hospid";
    $currentCount = ($TempArray[$currentDay]==null) ? "0": $TempArray[$currentDay];
    echo "<li><a href=\"$DailyURL\">". $currentDay .  '<span class="ui-li-count">'. "$currentCount" . '</span></a></li>';
}

echo "</ul>";
?>


<?php include("footer.php"); ?>
