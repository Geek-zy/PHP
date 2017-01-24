<?php

require_once 'function.php';
$AETITLE = $_REQUEST['aetitle'];
$SourceType = strtoupper($_REQUEST['source']);
$StartDate = $_REQUEST['startDate'];
$EndDate = $_REQUEST['endDate'];
$DICOM_List = fetchAll($SourceType,$AETITLE,$StartDate,$EndDate);
echo $DICOM_List;

//echo json_encode($DICOM_List);
?>
