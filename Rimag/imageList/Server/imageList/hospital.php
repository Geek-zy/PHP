<?php include("header.php"); ?>

<?php

$HospitalArray = json_decode(file_get_contents("http://web.rimag.com.cn/Interfaces/index/getHospitalAetList/"), TRUE);

echo '<ul data-role="listview" data-filter="true" data-filter-placeholder="输入关键字" data-inset="true" class="ui-mini">';

foreach ($HospitalArray as $key => $value) {
    $AETs="";
    if(count($value['aet'])==1) {
        echo '<li><a href="dateList_Fenyi.php?aetitle='. $value['aet'][0]['aet'] .'">'. $value['hospital_name']  .'</a></li>';
    }
    else {
        foreach($value['aet'] as $AETIndex => $AETvalue) {
            $AETs = $AETs . "-" . $AETvalue['aet'];
        }
        echo '<li><a href="dateListMultiAET.php?aetitles='. $AETs .'">'. $value['hospital_name'] . " 多个设备" .'</a></li>';
        
    }
}

echo "</ul>";
