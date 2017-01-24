<?php

require_once 'function.php';
$AETITLE = $_REQUEST['aetitle'];
$SourceType = strtoupper($_REQUEST['source']);
$StartDate = $_REQUEST['startDate'];
$EndDate = $_REQUEST['endDate'];
$patientId = $_REQUEST['pid'];
$Report = $_REQUEST['report'];
$limit_start= $_REQUEST['limit_start'];
$limit_size= $_REQUEST['limit_size'];
$DICOM_List = fetchAll($SourceType,$AETITLE,$StartDate,$EndDate,$patientId,$Report,$limit_start,$limit_size);
echo $DICOM_List;

//echo json_encode($DICOM_List);
?>
