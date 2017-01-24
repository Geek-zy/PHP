<?php
$AETITLE = $_REQUEST['aetitle'];
$StudyID = $_REQUEST['studyid'];

$endDate = date("Y-m-d H:i:s");
$startDate = date('Y-m-d H:i:s', strtotime('-1 Day', strtotime($endDate)));
//$AETTitle = "JXEFYY1MR";
//$StudyID = "14871";
$query = "select study.pk AS STUDY_KEY, patient.pat_id AS PATIENT_ID, patient.pat_name AS PATIENT_NAME, 
            study.num_series AS SERIES_COUNT, study.study_iuid AS STUDY_INSTANCE_UID,
            study.num_instances AS INSTANCE_COUNT, study.mods_In_study AS MODALITIES, 
            study.created_time AS CREATION_DTTM, study.study_datetime AS STUDY_DTTM,      
            series.src_aet AS SOURCE_AETITLE, study.accession_no as ACCESSION_NO, 
            study.study_id as STUDY_ID, study.study_custom3 as FILM_Printed, 
            study.study_custom2 as AW_Printed, study.report as REPORT
            FROM study
            INNER JOIN series ON series.study_fk = study.pk
            INNER JOIN patient ON study.patient_fk = patient.pk
            WHERE series.src_aet LIKE '%$AETTitle'
            AND study.created_time>='$startDate' 
            and study.created_time<='$endDate'
            AND study.study_id ='$StudyID'
            GROUP BY study.pk
                ";


$pdo = 'mysql:dbname=pacsdb;host=127.0.0.1';
$user = 'pacs';
$password = 'pacs';
try {
    $pdo = new PDO($pdo, $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_CLASS);
//print_r($result);

echo json_encode(array("list" => $result), true);
