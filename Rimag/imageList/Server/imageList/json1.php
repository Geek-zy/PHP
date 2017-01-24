<?php

require_once 'function.php';
$AETITLE = $_REQUEST['aetitle'];
$SourceType = strtoupper($_REQUEST['source']);
$DICOM_List = fetchAll($SourceType,$AETITLE);
echo $DICOM_List;

//echo json_encode($DICOM_List);
?>
