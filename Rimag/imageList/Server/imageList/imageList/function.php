<?php
function getConnection(){
	$db_host='127.0.0.1';
	// $db_database='pacsdb';
	$db_username='root';
	$db_password='root';
	$connection = mysql_connect($db_host,$db_username,$db_password);
	mysql_query("set names 'utf8'");

	if(!$connection){
		die("could not connect to the database:</br>".mysql_error());//诊断连接错误
	}
	return $connection;
}
function fetchAll($source,$aetitle){
	$Conn = getConnection();
	mysql_query("set names 'uft8'");
	$db_database='pacsdb';
	$db_selecct=mysql_select_db($db_database);
	if(!$db_selecct){
		die("could not to the database</br>".mysql_error());
	}
	
	$upSource = strtoupper($source);
	//echo $upSource.'-===================';
	//echo $source.'========';
	switch($upSource){
		case 'DR': $modality = "'DX','DR','CR'"; break;
		case 'MR': $modality = "'MR','MR\\\\PR'";break;
		case 'CT': $modality = "'CT','CT\\\\SR','SR'";  break;
		default : $modality = "'CT','CT\\\\SR', 'SR','MR','MR\\\\PR','DX','DR','CR'";
	}


#$query="select study.pk as STUDY_KEY ,patient.pat_id AS PATIENT_ID ,patient.pat_name AS PATIENT_NAME,patient.pat_sex AS PATIENT_SEX,patient.pat_birthdate AS PATIENT_AGE,study.num_series AS SERIES_COUNT,study.num_instances AS INSTANCE_COUNT,study.mods_In_study AS MODALITIES,study.created_time as CREATION_DTTM ,study.study_datetime as STUDY_DTTM,series.institution as INSTITUTION,study.study_iuid as STUDY_INSTANCE_UID,series.src_aet as  SOURCE_AETITLE from study inner join series on series.study_fk=study.pk inner join patient on study.patient_fk=patient.pk where study.mods_In_study like '%$source' and series.src_aet like '%$aetitle' group by series.study_fk";
	$query="select * from (SELECT study.pk AS STUDY_KEY, patient.pat_id AS PATIENT_ID, patient.pat_name AS PATIENT_NAME, patient.pat_sex AS PATIENT_SEX, year( NOW( ) ) - year( patient.pat_birthdate ) AS PATIENT_AGE1, patient.pat_custom1 AS PATIENT_AGE2, study.num_series AS SERIES_COUNT, study.num_instances AS INSTANCE_COUNT, study.mods_In_study AS MODALITIES, study.created_time AS CREATION_DTTM, study.study_datetime AS STUDY_DTTM, series.institution AS INSTITUTION, study.study_iuid AS STUDY_INSTANCE_UID, series.src_aet AS SOURCE_AETITLE
		FROM study
		INNER JOIN series ON series.study_fk = study.pk
		INNER JOIN patient ON study.patient_fk = patient.pk
		WHERE study.mods_In_study IN ( $modality )
		AND series.src_aet LIKE '%$aetitle'
		GROUP BY series.study_fk
		ORDER BY study.created_time DESC) as c limit 0,100";
#echo $query;
	$result=mysql_query($query);
	if(!$result){
		die("could not to the database</br>".mysql_error());
	}
	$MyQueryResult = array();	
	while($result_row=mysql_fetch_array(($result),MYSQL_ASSOC))
	{
		$encode = mb_detect_encoding( $result_row['PATIENT_NAME'] , 'GBK,GB2312,CP936, ISO-8859-1', true);
                        //echo '<br>',$encode,'========================================<br>';
                switch ($encode){
                        case false : break;
                        default : $result_row['PATIENT_NAME'] = iconv($encode, 'UTF-8', $result_row['PATIENT_NAME']);
                        //echo $encode,'========================================';
                } 
                //$result_row['PATIENT_NAME'] = preg_replace('/[^a-zA-Z0-9_]/', '', $result_row['PATIENT_NAME']);
                $result_row['PATIENT_NAME'] = preg_replace('/[\^\s\-\_]+/', ' ', $result_row['PATIENT_NAME']);
		$result_row['PATIENT_NAME'] = trim($result_row['PATIENT_NAME']);
		//同时需要将其设备名称改为source
		if($source){
			$result_row['MODALITIES'] = $source;
		}

		//$result_row['PATIENT_NAME'] = iconv('GB2312','UTF-8',$str);
		$result_row['PATIENT_AGE'] = $result_row['PATIENT_AGE1']? $result_row['PATIENT_AGE1'] : $result_row['PATIENT_AGE2'] ; 
		//$result_row['PATIENT_NAME'] = iconv('ISO-8859-1','UTF-8',$str);
		//	print_r(substr($result_row['PATIENT_NAME'],0,-4));	
		array_push($MyQueryResult,$result_row);
	}
	return json_encode(array("list" => $MyQueryResult),true);
}
