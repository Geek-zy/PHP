
<?php include("header.php"); ?>

<?php

date_default_timezone_set("Asia/Shanghai"); 

$AET = $_GET['aetitle'];
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];
$hospID = $_GET['hospID'];

$URL 	   =   "http://". $_SERVER['HTTP_HOST'] . "/imageList/json.php?aetitle=$AET&startDate=$startDate&endDate=$endDate";
$URL_Start = "\"http://". $_SERVER['HTTP_HOST'] . "/imageList/json.php?aetitle=$AET&startDate=$startDate&endDate=$endDate\"";

$Detail = json_decode(file_get_contents($URL), true);
$TempArray=$Detail['list'];

$PHP_Start = "php Start.php $AET $URL_Start";
system("$PHP_Start");

echo '<form method="get" action="dailyTablelist.php">'; 
echo "<div style='max-width:15%; margin: auto;'>";
echo '<input type="hidden" name="aetitle" value='.$_GET["aetitle"].'>';
echo '<input type="hidden" name="hospID" value='.$_GET["hospID"].'>';
echo '<input type="search" name="startDate" placeholder="起始时间" onclick="laydate()" />';
echo '<input type="search" name="endDate"   placeholder="结束时间" onclick="laydate()" />';
echo '<input type="submit" value="确 定">';
echo "</form>";

echo "<ul data-role='listview' data-inset='true'>";
echo "<li><a target='_blank' href='Excel/$AET.xlsx'>" . "下载文件" . "</a></li></u></div>";

echo "<table>";
 echo "</div></div>";
   echo '<div data-role="main" class="ui-content">' .
    	'<table data-role="table" data-mode="columntoggle" class="ui-responsive ui-shadow" id="myTable" data-column-btn-text="点击切换数据">' .
      	'<thead>' .
        '<tr>' .
          '<th data-priority="1">序号</th>'		.
          '<th data-priority="2">流水号</th>'		.
          '<th data-priority="3">设备号</th>'		.
          '<th data-priority="4">检查ID</th>'		.
          //'<th data-priority="4">患者ID</th>'		.
          //'<th data-priority="5">患者姓名</th>'	.
          //'<th data-priority="6">性别</th>'		.
          //'<th data-priority="7">年龄</th>'		.
	  '<th>患者ID</th>'				.
	  '<th>患者姓名</th>'				.
	  '<th>性别</th>'				.
	  '<th>年龄</th>'				.
          '<th data-priority="5">部位数</th>'		.
          '<th data-priority="6">部位</th>'		.
          '<th data-priority="7">检查日期</th>'		.
          //'<th data-priority="11">创建日期</th>'	.
          //'<th data-priority="11">检查类型</th>'	.
          '<th data-priority="8">报告数量</th>'		.
          '<th data-priority="9">胶片数量</th>'	.
          '<th data-priority="10">序列数量</th>'	.
          '<th data-priority="11">影像数量</th>'	.
          //'<th data-priority="11">AET</th>'		.
          //'<th data-priority="12">患者UID</th>'	.
        '</tr>'.
     	'</thead>';

$sum = 1;
foreach ($TempArray as $key => $value) {

        $TotalFilm = intval($value["FILM_Printed"])+intval($value["AW_Printed"]);

        echo "<tr>" .
                "<td>" . $sum                     	. "</td>" . 
                "<td>" . $value["STUDY_ID"]       	. "</td>" . 
                "<td>" . $value["ACCESSION_NO"]   	. "</td>" . 
                "<td>" . $value["STUDY_KEY"] 	  	. "</td>" . 
                "<td>" . $value["PATIENT_ID"]     	. "</td>" . 
                "<td>" . $value["PATIENT_NAME"]   	. "</td>" . 
                "<td>" . $value["PATIENT_SEX"]    	. "</td>" . 
                "<td>" . $value["PATIENT_AGE"]    	. "</td>" . 
                "<td>" . $value["BODYPART_NUM"]   	. "</td>" . 
                "<td>" . $value["BODYPART_DESC"]  	. "</td>" . 
                "<td>" . $value["STUDY_DTTM"]     	. "</td>" . 
                //"<td>" . $value["CREATION_DTTM"]	. "</td>" . 
                //"<td>" . $value["MODALITIES"]   	. "</td>" . 
                "<td>" . $value["REPORT"]   	  	. "</td>" . 
                "<td>" . $TotalFilm			. "</td>" .
                "<td>" . $value["SERIES_COUNT"]   	. "</td>" . 
                "<td>" . $value["INSTANCE_COUNT"] 	. "</td>" .
                //"<td>" . $value["SOURCE_AETITLE"] 	. "</td>" . 
                //"<td>" . $value["STUDY_INSTANCE_UID"] . "</td>" . 
        "</tr>";

	$sum += 1;
}

echo "</table>";
echo "<div data-role='footer'><h1>* 使用过程中遇到问题或者错误请联系技术部 ==> 张懿-邮箱：zhangyi@rimag.com.cn</h1></div>";

?>
