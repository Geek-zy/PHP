<?php
require_once 'function.php';
//$AETITLE = $_REQUEST['aetitle'];
$patientId = $_REQUEST['patientId'];
$aet = $_REQUEST['aetitle'];
//$SourceType = strtoupper($_REQUEST['source']);
if(!empty($aet) and !empty($patientId)){
	$DICOM_List = getImageByPatientId($patientId, $aet);
	//print_r($DICOM_List);
	echo $DICOM_List;
//print_r(json_decode($DICOM_List));
}
//echo json_encode($DICOM_List);
?>
