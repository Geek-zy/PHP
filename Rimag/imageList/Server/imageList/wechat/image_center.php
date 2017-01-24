<?php
	$center = array(
	
//	'荆门市第二人民医院' => 160,
	//'万安县人民医院' => 47,
	//'鄱阳县人民医院' => 76,
	'分宜县人民医院' => 8,
	'海拉尔农垦总医院' => 81,
	'兴国人民医院' => 137
	);
	$hospital = "http://web.rimag.com.cn/Interfaces/index/getHospitalAetList/";
	$ppp = json_decode(file_get_contents("$hospital"),true);


	function Connection(){
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
	
	function query($id,$startdate,$enddate){
		$pdo = Connection();
		$top  = "SELECT   `department`,count(*) as sum  FROM `hospital_report` 
		WHERE hospital_id='".$id."' and `create_time` between '".$startdate." 00:00:00' and '".$enddate." 23:59:59'  GROUP BY  `department` order by sum desc
		limit 0,3";
	
	//echo $top;
		$stmt = $pdo->prepare($top);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
		
	}
	function sum($id,$startdate,$enddate){
		$pdo = Connection();
		$sum = "SELECT   count(*) as sum  FROM `hospital_report` 
WHERE hospital_id='".$id."' and `create_time` between '".$startdate." 00:00:00' and '".$enddate." 23:59:59'";
		$stmt = $pdo->prepare($sum);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}	
	function return_key($ppp,$target){
		foreach($ppp as $key => $value){
			if(in_array($target,$value)){
				return $key;
				
			}

		}

	}
	//周六计算本周一到周五;
	$monday = time() - (7 * 24 * 60 * 60);
	$friday = time() - (1 * 24 * 60 *60);
	
	$startdate = date('Y-m-d',$monday);
	$enddate = date('Y-m-d',$friday);
	$returnArray = array();	

	foreach($center as $key => $value){
		$department = query($value,$startdate,$enddate);
		$sum = sum($value,$startdate,$enddate);
		$number =  $sum[0]['sum'];
		$dds[$value][$number] = $department;
	}

	$hospitalArray = array();
	foreach($ppp as $key => $value){
		$center = $value['is_center'];
		if($center == 1 || $center == 2 ){
			$stat = $value['state_name'];
			$hospital_name = $value['hospital_name'];
			$id = $value['hospital_id'];
			$new = array($stat,$hospital_name,$id);
			array_push($hospitalArray,$new);
	
		}
	}

	//echo json_encode($dds,true);
$pop = array();
	foreach($dds as $k => $v){
		$pos = return_key($hospitalArray,$k);
		array_push($pop,$pos);
	}
	
	$bbs = array();
	foreach($pop as $x => $y){
		$state = $hospitalArray[$y]['0'];
		$name = $hospitalArray[$y]['1'];
		$id = $hospitalArray[$y]['2'];
		//$bbs[$state] = array();
		$bbs[$state][$name] = array();
		foreach($dds[$id] as $count => $department){
			foreach($department as $index => $Infor){
				$sum = $Infor['sum'];
				$proportion = round(($sum / $count),3)*100 .'%';
	//			echo $proportion ."\n";
				$bbs[$state][$name]['sum'] = $count;
				$bbs[$state][$name][$Infor['department']] = array($sum,$proportion); 
				//echo $Infor['department'] .'--'. $sum;
			}
		}
		
	}

	echo json_encode($bbs,true);
