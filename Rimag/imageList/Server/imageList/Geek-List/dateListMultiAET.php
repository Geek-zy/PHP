<?php include("header.php"); ?>
                <div  style="max-width:400px; margin: auto;">

<?php

date_default_timezone_set("Asia/Shanghai");

$today = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
$startDate = $today;
$endDate = $today;

$AET = array_filter(explode("-", $_GET['aetitles']));

$hospid = $_GET['hospID'];

echo '<ul data-role="listview" data-inset="true" class="ui-mini">';

foreach ($AET as $key => $value) {
      echo "<li><a href=\"dailyTablelist.php?aetitle=" . $value . "&hospID=$hospid" . "&startDate=$startDate&endDate=$endDate" . '">' . $value . '</a></li>';
}
echo "</ul>";
?>

