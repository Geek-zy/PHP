
<?php

$hospid = $_GET['hospid'];
$pid = $_GET['pid'];
$datetime = $_GET['datetime'];

if ($hospid == null && $pid == null && $datetime == null) {

	$hospid = "8";
	$pid = "P00309195";
	$datetime = "2016-01-27%2015:05:56";
}

main();

function main() {

	global $hospid;
	global $pid;
	global $datetime;

	echo "<html><head><title>一脉影像</title><body><pre>";

	$returnArray = Mysql_DB_IT();

    foreach($returnArray as $key => $value) {

		echo "<li><a href='NewReport.php?hospid=" . $value['id'] . "&pid=$pid" . "&datetime=$datetime'>" . $value['name'] . "</a></li>";
	}	

	echo "</pre></body></head></html>";
}


function Mysql_DB_IT() {

	$DB_IT = Mysql_DB_ID();
	$sql = "select id, name from `hospital` where 1";
	$Pre_Pare = $DB_IT->prepare($sql);
	$Pre_Pare->execute();

	$result = $Pre_Pare->fetchAll(PDO::FETCH_ASSOC);

//		print_r($result);

//	while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

//		print_r($result);

//	}
	
	if ($result != null) {

		return $result;
	}

	else {

		return;
	}
}


function Mysql_DB_ID() {

	$URL = 'mysql:dbname=rms;host=192.168.1.106';
	$User = 'rms';
	$Passwd = 'bitrms9527';

	try {

		$DB_ID = new PDO($URL, $User, $Passwd);
	} 
	
	catch (PDOException $e) {

		echo '数据库连接失败,错误代码 ==> ' . $e->getMessage();
		exit;
	}

	$Pre_Pare = $DB_ID->prepare("set names 'utf8'");
	$Pre_Pare->execute();

	return $DB_ID;
}

?>

