<?php
	function Connection() {
		    $URL = 'mysql:dbname=rmsdep;host=rds5m61c4me526a7v0oy.mysql.rds.aliyuncs.com;charset=utf8';
		    $user = 'report_name';
		    $password = 'Report_name';
		    
		   try {
			$pdo = new PDO($URL, $user, $password);
		    } catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		    }
		    return $pdo;
	}
	function query($pdo,$sql){
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;

		}

	$pdo = Connection();
	//$body = array('上腹部CT平扫','胸部CT平扫','头颅CT平扫');
	$ddd = array();
	
	$year = date('Y')-1;
		for($i = 1; $i <= 12; $i++){
			if($i < 10 ){
				$startdate = $year . '-0'. $i . '-01';
				$enddate = $year . '-0' . $i . '-31';
				$sql = "select count(scan_type) as count,department from hospital_report WHERE hospital_id=2 and create_time BETWEEN '".$startdate." 00:00:00' and '".$enddate." 23:59:59' GROUP by department";
				$ads = query($pdo,$sql);
				array_push($ddd,$ads);
			}else{
				$startdate = $year . '-'. $i . '-01';
				$enddate = $year . '-' . $i . '-31';
				$sql = "select count(scan_type) as count,department from hospital_report WHERE hospital_id=2 and create_time BETWEEN '".$startdate." 00:00:00' and '".$enddate." 23:59:59' GROUP by department";
				$ads = query($pdo,$sql);
				array_push($ddd,$ads);
			}
		}
echo json_encode($ddd,true);
