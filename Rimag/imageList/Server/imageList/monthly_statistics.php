<?php
//http://nfs.jiangxi.rimag.com.cn/imageListTest/diagnosticCount.php?aetitle=JXXYSFYXRMYYCT

require_once 'function.php';
$AETITLE = $_REQUEST['aetitle'];
$DICOM_List = getMonthStatistics($AETITLE);
echo $DICOM_List;

//echo json_encode($DICOM_List);
?>
