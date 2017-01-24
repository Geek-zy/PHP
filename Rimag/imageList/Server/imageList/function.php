<?php

function getConnection() {
    //$db_host = 'rdsvy2qjemy32yb.mysql.rds.aliyuncs.com';
    $db_host = 'rm-bp173b3q9rjsdpxro.mysql.rds.aliyuncs.com';
    // $db_database='pacsdb';
    $db_username = 'dcm3_jiangxi';
    $db_password = '5iwole@123';
    $connection = mysql_connect($db_host, $db_username, $db_password);
    mysql_query("set names 'utf8'");

    if (!$connection) {
        die("could not connect to the database in getConnection:</br>" . mysql_error()); //诊断连接错误
    }
    mysql_query("set names 'uft8'");
    $db_database = 'dcm3_jiangxi_pacs';
    $db_selecct = mysql_select_db($db_database);
    return $connection;
}
function fetchAll($source, $aetitle, $sDate, $eDate, $pid, $Report,$limit_start,$limit_size) {
    $Conn = getConnection();
    mysql_query("set names 'uft8'");
    $db_database = 'dcm3_jiangxi_pacs';
    $db_selecct = mysql_select_db($db_database);
    if (!$db_selecct) {
        die("could not to the database in fetchAll</br>" . mysql_error());
    }

    $upSource = strtoupper($source);
    //echo $upSource.'-===================';
    //echo $source.'========';
    switch ($upSource) {
        case 'DR': $modality = "'DX','DR','CR'";
            break;
        case 'MR': $modality = "'MR','PR','PR\\\\MR','MR\\\\PR','MR\\\\SR'";
            break;
        case 'CT': $modality = "'CT','CT\\\\SR','SR'";
            break;
        default : $modality = "'CT','CT\\\\SR','PR\\\\MR', 'SR','MR','MR\\\\PR','DX','DR','CR','PR','MR\\\\SR','CT\\\\OT','CT\\\\SR\\\\OT','MR\\\\OT','MR\\\\SR\\\\OT','OT\\\\CT','OT\\\\MR','OT\\\\CT\\\\SR','OT\\\\MR\\\\SR','CT\\\\OT\\\\SR','MR\\\\OT\\\\SR','MG','NM','SC','RF','NM\\\\OT','OT\\\\NM','SC\\\\OT','OT\\\\SC','RF\\\\OT','OT\\\\RF'";
    }

    if (empty($sDate)) {
        $endDate = date("Y-m-d H:i:s");
        $startDate = date('Y-m-d H:i:s', strtotime('-3 Day', strtotime($endDate)));
    } else if (!empty($sDate) && empty($eDate)) {
        $startDate = date("Y-m-d H:i:s", strtotime($sDate));
        $endDate = date("Y-m-d H:i:s");
    } else {
        $startDate = date("Y-m-d H:i:s", strtotime($sDate));
        $endDate = date("Y-m-d H:i:s", strtotime('+1 Day', strtotime($eDate)));
    }
#echo $startDate;
#echo "=======================";
#echo $endDate;
#echo "=======================";
#$query="select study.pk as STUDY_KEY ,patient.pat_id AS PATIENT_ID ,patient.pat_name AS PATIENT_NAME,patient.pat_sex AS PATIENT_SEX,patient.pat_birthdate AS PATIENT_AGE,study.num_series AS SERIES_COUNT,study.num_instances AS INSTANCE_COUNT,study.mods_In_study AS MODALITIES,study.created_time as CREATION_DTTM ,study.study_datetime as STUDY_DTTM,series.institution as INSTITUTION,study.study_iuid as STUDY_INSTANCE_UID,series.src_aet as  SOURCE_AETITLE from study inner join series on series.study_fk=study.pk inner join patient on study.patient_fk=patient.pk where study.mods_In_study like '%$source' and series.src_aet like '%$aetitle' group by series.study_fk";
    if (empty($pid)) {
        $query = "select study.pk AS STUDY_KEY, patient.pat_id AS PATIENT_ID, patient.pat_name AS PATIENT_NAME, 
            patient.pat_sex AS PATIENT_SEX, year( NOW( ) ) - year( patient.pat_birthdate ) AS PATIENT_AGE1, 
            patient.pat_custom1 AS PATIENT_AGE2, study.num_series AS SERIES_COUNT, 
            study.num_instances AS INSTANCE_COUNT, study.mods_In_study AS MODALITIES, 
            study.created_time AS CREATION_DTTM, study.study_datetime AS STUDY_DTTM, 
            series.institution AS INSTITUTION, study.study_iuid AS STUDY_INSTANCE_UID, 
            series.src_aet AS SOURCE_AETITLE, study.accession_no as ACCESSION_NO, 
            study.study_id as STUDY_ID, study.study_custom3 as FILM_Printed, 
            patient.pat_attrs AS PATIENT_ATTRS,
            study.report_hisid AS REPORT_HISID,
            study.report_drid AS REPORT_DRID,
            study.bodyPart_num AS BODYPART_NUM,
            study.bodyPart_Desc AS BODYPART_DESC,
            study.study_custom2 as AW_Printed, study.report as REPORT
                FROM study
                INNER JOIN series ON series.study_fk = study.pk
                INNER JOIN patient ON study.patient_fk = patient.pk
                WHERE study.mods_In_study IN ( $modality )
                AND study.study_datetime>='$startDate' 
                and study.study_datetime<='$endDate'";
    } else {

        $query = "select study.pk AS STUDY_KEY, patient.pat_id AS PATIENT_ID, patient.pat_name AS PATIENT_NAME, 
            patient.pat_sex AS PATIENT_SEX, year( NOW( ) ) - year( patient.pat_birthdate ) AS PATIENT_AGE1, 
            patient.pat_custom1 AS PATIENT_AGE2, study.num_series AS SERIES_COUNT, 
            study.num_instances AS INSTANCE_COUNT, study.mods_In_study AS MODALITIES, 
            study.created_time AS CREATION_DTTM, study.study_datetime AS STUDY_DTTM, 
            series.institution AS INSTITUTION, study.study_iuid AS STUDY_INSTANCE_UID, 
            series.src_aet AS SOURCE_AETITLE, study.accession_no as ACCESSION_NO, 
            study.study_id as STUDY_ID, study.study_custom3 as FILM_Printed, 
            patient.pat_attrs AS PATIENT_ATTRS,
            study.report_hisid AS REPORT_HISID,
            study.report_drid AS REPORT_DRID,
            study.bodyPart_num AS BODYPART_NUM,
            study.bodyPart_Desc AS BODYPART_DESC,
            study.study_custom2 as AW_Printed, study.report as REPORT
                FROM study
                INNER JOIN series ON series.study_fk = study.pk
                INNER JOIN patient ON study.patient_fk = patient.pk
                WHERE study.mods_In_study IN ( $modality )
                and patient.pat_id COLLATE UTF8_GENERAL_CI like '%$pid'
                AND series.src_aet LIKE '%$aetitle'";
    }
    

    if (!empty($aetitle)){
	    $aetSet = explode(",",htmlspecialchars($aetitle));
	    if(!empty($aetSet)){
		    $aetStr = "";
		    foreach($aetSet as $value){
			    $aetStr .= '"'.$value.'", ';
		    }
		    $aetStr = rtrim(substr($aetStr,0,-1),",");
	    }

	    $query = $query . " AND series.src_aet in ($aetStr)";
    }

    if (isset($Report)) {
        $query = $query . " AND study.report=$Report ";
    }
    $query = $query . " GROUP BY series.study_fk
                ORDER BY study.study_datetime DESC";
    if(""!==$limit_start && null !== $limit_start && !empty($limit_size)){
       $query = $query . " LIMIT $limit_start,$limit_size";
    }
    $result = mysql_query($query);
    if (!$result) {
        die("could not to the database later</br>" . mysql_error());
    }
    $MyQueryResult = array();
    while ($result_row = mysql_fetch_array(($result), MYSQL_ASSOC)) {
        $encode = mb_detect_encoding($result_row['PATIENT_NAME'], 'GBK,GB2312,CP936, ISO-8859-1', true);
        //echo '<br>',$encode,'========================================<br>';
        switch ($encode) {
            case false : break;
            default : $result_row['PATIENT_NAME'] = iconv($encode, 'UTF-8', $result_row['PATIENT_NAME']);
            //echo $encode,'========================================';
        }
        //$result_row['PATIENT_NAME'] = preg_replace('/[^a-zA-Z0-9_]/', '', $result_row['PATIENT_NAME']);
        //$result_row['PATIENT_NAME'] = preg_replace('/[\^\s\-\_]+/', ' ', $result_row['PATIENT_NAME']);
        //$result_row['PATIENT_NAME'] = trim($result_row['PATIENT_NAME']);
        //同时需要将其设备名称改为source
/*
        $PatientInfo = explode(" ", $result_row['PATIENT_ATTRS']);
//        print_r($PatientInfo[1]);
        $NameValue = iconv('GB18030', 'UTF-8', $PatientInfo[1]);
        $NameValue = str_replace("PN", "", $NameValue);
        $NameValue = str_replace("^", "", $NameValue);
        $NameValue = preg_replace('/[\x00-\x1F\x7F]/', '', $NameValue);
*/
        $NameValue = GetBetween("PN", "LO" . $result_row['PATIENT_ID'], preg_replace('/[\x00-\x1F\x7F]/', '', $result_row['PATIENT_ATTRS']));
        $NameValue = iconv('GB18030', 'UTF-8', $NameValue);

        $result_row['PATIENT_NAME'] = trim($NameValue);
        unset($result_row['PATIENT_ATTRS']);
        if ($source) {
            $result_row['MODALITIES'] = $source;
        }

        //$result_row['PATIENT_NAME'] = iconv('GB2312','UTF-8',$str);
        $result_row['PATIENT_AGE'] = $result_row['PATIENT_AGE1'] ? $result_row['PATIENT_AGE1'] : $result_row['PATIENT_AGE2'];
        //$result_row['PATIENT_NAME'] = iconv('ISO-8859-1','UTF-8',$str);
        //	print_r(substr($result_row['PATIENT_NAME'],0,-4));	
        array_push($MyQueryResult, $result_row);
    }
    return json_encode(array("list" => $MyQueryResult), true);
}

function getImageByPatientId($patientId, $aet) {
     $aetSet = explode(",",htmlspecialchars($aet));
    if(!empty($aetSet)){
      $aetStr = "";
      foreach($aetSet as $value){
        $aetStr .= '"'.$value.'", ';
        }
        $aetStr = rtrim(substr($aetStr,0,-1),",");
    }
    $Conn = getConnection();
    mysql_query("set names 'uft8'");
    $db_database = 'dcm3_jiangxi_pacs';
    $db_selecct = mysql_select_db($db_database);
    if (!$db_selecct) {
        die("could not to the database</br>" . mysql_error());
    }

    $query = "select * from (SELECT study.pk AS STUDY_KEY, patient.pat_id AS PATIENT_ID, patient.pat_name AS PATIENT_NAME, patient.pat_sex AS PATIENT_SEX, year( NOW( ) ) - year( patient.pat_birthdate ) AS PATIENT_AGE1, patient.pat_custom1 AS PATIENT_AGE2, study.num_series AS SERIES_COUNT, study.num_instances AS INSTANCE_COUNT, study.mods_In_study AS MODALITIES, study.created_time AS CREATION_DTTM, study.study_datetime AS STUDY_DTTM, series.institution AS INSTITUTION, study.study_iuid AS STUDY_INSTANCE_UID, series.src_aet AS SOURCE_AETITLE,study.accession_no as ACCESSION_NO
		FROM study
		INNER JOIN series ON series.study_fk = study.pk
		INNER JOIN patient ON study.patient_fk = patient.pk
		WHERE patient.pat_id = '".htmlspecialchars($patientId) . "'
		AND series.src_aet in ($aetStr)
		GROUP BY series.study_fk
		ORDER BY study.created_time DESC) as c ";
    //echo $query.PHP_EOL; 

    $result = mysql_query($query);
    if (!$result) {
        die("could not to the database</br>" . mysql_error());
    }
    $MyQueryResult = array();
    while ($result_row = mysql_fetch_array(($result), MYSQL_ASSOC)) {
        //print_r($result_row);
        //$result_row['PATIENT_NAME'] = preg_replace('/[^a-zA-Z0-9_]/', '', $result_row['PATIENT_NAME']);
        $result_row['PATIENT_NAME'] = preg_replace('/[\^\s\-\_]+/', ' ', $result_row['PATIENT_NAME']);
        $result_row['PATIENT_NAME'] = trim($result_row['PATIENT_NAME']);
        //同时需要将其设备名称改为source
        if (stripos($result_row['MODALITIES'], 'DX')!==false || stripos($result_row['MODALITIES'], 'DR')!==false||stripos($result_row['MODALITIES'], 'CR')!==false) {
            $result_row['MODALITIES'] = 'DR';
        } elseif (stripos($result_row['MODALITIES'], 'MR')!==false) {
            $result_row['MODALITIES'] = 'MR';
        } else {
            $result_row['MODALITIES'] = 'CT';
        }

        //$result_row['PATIENT_NAME'] = iconv('GB2312','UTF-8',$str);
        $result_row['PATIENT_AGE'] = $result_row['PATIENT_AGE1'] ? $result_row['PATIENT_AGE1'] : $result_row['PATIENT_AGE2'];
        //$result_row['PATIENT_NAME'] = iconv('ISO-8859-1','UTF-8',$str);
        //	print_r(substr($result_row['PATIENT_NAME'],0,-4));	
        array_push($MyQueryResult, $result_row);
    }
    return json_encode(array("list" => $MyQueryResult));
}


function diagnosticCount($AETITLE) {
    $Conn = getConnection();
    $endDate = date('Y-m-d H:i:s', strtotime('+1 day', strtotime(date("Y-m-d")))); //�~N��~O~V第��~L天�~G~L�~Y��~W��~\~_
    $startDate = date('Y-m-d H:i:s', strtotime(date("Y-m-d")));
    $Study_Query = "SELECT study.pk as study_pk, instance.pk as instance_pk, sum(files.file_size) as study_size, 
        study.study_datetime as time FROM study
        INNER JOIN series ON series.study_fk = study.pk
        INNER JOIN patient ON study.patient_fk = patient.pk
        INNER JOIN instance ON instance.series_fk = series.pk
        INNER JOIN files ON files.instance_fk = instance.pk
        WHERE series.src_aet LIKE  '$AETITLE%'
        AND study.study_datetime between '$startDate' and '$endDate'
        group by study.pk order by null";
//echo $Study_Query . "<br><br>";
    $query = "select count(1) as count, sum(study_size) as size, time from 
    ($Study_Query) as c GROUP BY DATE_FORMAT( time,  '%Y-%m-%d' ) ORDER BY time DESC";

    #echo $query . "<br><br>";
    $result = mysql_query($query);
    if (!$result) {
        die("could not to the database</br>" . mysql_error());
    }
    $MyQueryResult = array();
    while ($result_row = mysql_fetch_array(($result), MYSQL_ASSOC)) {
        array_push($MyQueryResult, $result_row);
    }
    mysql_close($Conn);
    return $MyQueryResult;
}
 //2016-06-29 xuzeng
function getMonthStatistics($aet){
        $MyQueryResult = array();
        $todayStatisitcs = diagnosticCount($aet);
        $endDate = date("Y-m-d",strtotime("-1 day"));
        $startDate = date('Y-m-d', strtotime('-30 Day', strtotime($endDate)));
        $url = "http://web.rimag.com.cn/interfaces/AetFilesize/fetchByAetTime?AET=$aet&startDate=$startDate&endDate=$endDate";
        $response = json_decode(file_get_contents($url),true);
        return json_encode(array_merge($todayStatisitcs,$response), true);
}


//2016-03-29
function getCountByAet($aet){
	$Conn = getConnection();
	mysql_query("set names 'uft8'");
	$db_database = 'dcm3_jiangxi_pacs';
	$db_selecct = mysql_select_db($db_database);
	if (!$db_selecct) {
		die("could not to the database</br>" . mysql_error());
	}
        $endDate = date("Y-m-d H:i:s");
        $startDate = date('Y-m-d H:i:s', strtotime('-3 Day', strtotime($endDate)));

	$query = "select count(distinct study.pk) as number FROM study  INNER JOIN series ON series.study_fk = study.pk
		INNER JOIN patient ON study.patient_fk = patient.pk
		WHERE study.study_datetime>='$startDate' 
                and study.study_datetime<='$endDate' and series.src_aet LIKE '%$aet'";
//	echo $query . "<br><br>";
	$result = mysql_query($query);
	if (!$result) {
		die("could not to the database</br>" . mysql_error());
	}
	$MyQueryResult = array();
	while ($result_row = mysql_fetch_array(($result), MYSQL_ASSOC)) {
                
                $count = $result_row;
	}
	return json_encode($count, true);
}




  function formatSizeUnits($bytes)
    {
//        if ($bytes >= 1073741824)
//        {
//            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
//        }
        if ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}


function GetBetween($var1 = "", $var2 = "", $pool) {
    $temp1 = strpos($pool, $var1) + strlen($var1);
    $result = substr($pool, $temp1, strlen($pool));
    $dd = strpos($result, $var2);
    if ($dd == 0) {
        $dd = strlen($result);
    }
    return trim(substr($result, 0, $dd));
}


function MySQL_PHP7() {
    $URL = 'mysql:dbname=dcm3_jiangxi_pacs;host=rm-bp173b3q9rjsdpxro.mysql.rds.aliyuncs.com';
    $user = 'dcm3_jiangxi';
    $password = '5iwole@123';

    try {
        $pdo = new PDO($URL, $user, $password);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    return $pdo;
}

function diagnosticDailyCount($AETITLE = null, $SearchStartDay = null) {
    if ($AETITLE === null) {
        $AETITLE = "JXJAWAXRMYYMR";
    }
    if ($SearchStartDay === null) {
        $SearchStartDay = new DateTime("2016-05-03");
    }

    $SearchEndDay = clone $SearchStartDay;
    $SearchEndDay = $SearchEndDay->modify('+1 day');
    $SearchStartDay = $SearchStartDay->format("Y-m-d");
    $SearchEndDay = $SearchEndDay->format("Y-m-d");

    $pdo = MySQL_PHP7();
    $query = "SELECT COUNT(DISTINCT(`study` .`patient_fk` )) FROM `study` 
                INNER JOIN series ON series.study_fk = study.pk
                WHERE series.src_aet LIKE  '$AETITLE'
                        AND study.study_datetime >=  '$SearchStartDay' 
                        AND study.study_datetime <=  '$SearchEndDay'";
//    echo $query;
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_NUM);
    echo ($result[0]);
}

function MySQL_PHP7_nfs3() {
    //$URL = 'mysql:dbname=dcm3_jiangxi_pacs;host=rdsvy2qjemy32yb.mysql.rds.aliyuncs.com';
    $URL = 'mysql:dbname=dcm3_jiangxi_pacs;host=rm-bp173b3q9rjsdpxro.mysql.rds.aliyuncs.com';
    $user = 'dcm3_jiangxi';
    $password = '5iwole@123';

    try {
        $pdo = new PDO($URL, $user, $password);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    return $pdo;
}

function diagnosticSpaceCount($pdo = null, $AETITLE = null, $startDate = null) {
    if ($AETITLE === null) {
        return ;
    }
    if ($startDate === null) {
        return ;
    }

    $endDate = clone $startDate;

    $endDate = $endDate->modify('+1 day');
    $startDate = $startDate->format("Y-m-d");
    $endDate = $endDate->format("Y-m-d");

    $Study_Query = "SELECT study.pk as study_pk, instance.pk as instance_pk, sum(files.file_size) as study_size, 
        DATE_FORMAT(study.study_datetime, '%Y-%m-%d') as queryDate , series.src_aet as AET FROM study
        INNER JOIN series ON series.study_fk = study.pk
        INNER JOIN patient ON study.patient_fk = patient.pk
        INNER JOIN instance ON instance.series_fk = series.pk
        INNER JOIN files ON files.instance_fk = instance.pk
        WHERE series.src_aet ='$AETITLE'
        AND study.study_datetime >=  '$startDate'
        AND study.study_datetime <=  '$endDate' group by study.pk";

    $query = "select count(*) as count, sum(study_size) as size, queryDate, AET as AET from 
    ($Study_Query) as c GROUP BY DATE_FORMAT( queryDate,  '%Y-%m-%d' ) ORDER BY queryDate DESC";

    //echo $query . "\n";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result != null) {
        return $result;
    } else {
        return;
    }
}

