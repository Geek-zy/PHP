<?php
require_once 'function.php';
$AETITLE = $_REQUEST['aetitle'];
$DICOM_List = getCountByAet($AETITLE);
echo $DICOM_List;

//echo json_encode($DICOM_List);
?>
