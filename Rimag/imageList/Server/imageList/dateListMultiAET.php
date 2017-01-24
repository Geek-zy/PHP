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
//$AET = $_GET['aetitles'];
$AETs = array_filter(explode("-", $_GET['aetitles']));
$Software = $_GET['software'];

//---------------Geek---------------
$hospid = $_GET['hospID'];

echo '<ul data-role="listview" data-inset="true" class="ui-mini">';

foreach ($AETs as $key => $value) {
    echo "<li><a href=\"dateList_Fenyi.php?software=$Software&aetitle=" . $value . "&hospID=$hospid" . '">' . $value . '</a></li>';
}
echo "</ul>";
?>


<?php include("footer.php"); ?>
