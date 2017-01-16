<?php

//设置时区(中国标准时间)
date_default_timezone_set('PRC');

/*
 * 时间格式的时间
 * echo date('Y-m-d H:i:s');
 * 时间戳格式的时间
 * echo time();
*/

$Date_Time = date('s') . "\n";

if ($Date_Time >= 0 && $Date_Time <= 10)
	echo $Date_Time . "0-10 秒段\n";

else if ($Date_Time >= 10 && $Date_Time <= 20) 
	echo $Date_Time . "10-20 秒段\n";

else if ($Date_Time >= 20 && $Date_Time <= 30) 
	echo $Date_Time . "20-30 秒段\n";

else if ($Date_Time >= 30 && $Date_Time <= 40) 
	echo $Date_Time . "30-40 秒段\n";

else if ($Date_Time >= 40 && $Date_Time <= 50) 
	echo $Date_Time . "40-50 秒段\n";

else 
	echo $Date_Time . "60-0 秒段\n";
?>

