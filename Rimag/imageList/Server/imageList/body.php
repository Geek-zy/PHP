<?php
	function Connection() {
		    $URL = 'mysql:dbname=dcm3_jiangxi_pacs;host=rm-bp173b3q9rjsdpxro.mysql.rds.aliyuncs.com;charset=utf8';
		    $user = 'dcm3_jiangxi';
		    $password = '5iwole@123';
		    
		   try {
			$pdo = new PDO($URL, $user, $password);
		    } catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		    }
		    return $pdo;
	}

	function Aetitle($hospitalid){
			$da = array();
			$Url = "http://web.rimag.com.cn/Interfaces/index/getHospitalAetList/hospitalId/$hospitalid";
			$hospital = json_decode(file_get_contents($Url),true);
				foreach ($hospital[0]['aet'] as $key => $value) {
						 array_push($da,$value['aet']);
				}
			return $da;
	}
	


	function body($pdo,$hospitalid,$aet,$startdate='2016-01-01',$enddate){
		
			$bodyhospital = array();
			foreach($aet as $key=> $value){
				
				$sql = "select count(study.`bodyPart_desc`) as count,study.bodyPart_num as body_num,study.bodyPart_Desc as body_desc,series.`src_aet`,study.study_datetime as time
					from study
					left join `series` on series.`study_fk` =study.`pk` 
					where
					series.`src_aet` ='".$value."'  and study.bodyPart_num is not null and study.`bodyPart_Desc` is not null
					and study.bodyPart_Desc <> ' ' and study.study_datetime between '".$startdate."' and '".$enddate."'
					group by body_desc";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
  	  				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if(!empty($result)){
					 	array_push($bodyhospital,$result);
					}
			
				}
				#	$bs[$hospitalid] = $bodyhospital;
					return $bodyhospital;
		}
	
	$id = $_GET['hospitalid'];
	$startDate = $_GET['startDate'];
	$endDate = $_GET['endDate'];
	if(empty($id) ||  empty($startDate) || empty($endDate)){
		
		echo '<h3 align="center" style="margin-top:200px">' .'参数不全'. '</h3>';
	}

	
	$pdo = Connection();
	$Aet = Aetitle($id);
	$po = body($pdo,$id,$Aet,$startDate,$endDate);
	echo json_encode($po,true);

