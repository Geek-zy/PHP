<?php

function ping($ip){

	shell_exec("ping -c 4 $ip > ping.txt");

	$Num = shell_exec("cat -n ping.txt | tac | awk 'NR == 1' | awk '{print $1}'");

	if($Num < 9)

		return 0;	// 0 ping 超时

	else

		return 1;	// 1 ping 成功
}

if(empty($argv[1]))

	echo
		"请输入有效IP地址或者域名!\n" .
		"PS: php Network.php 192.168.1.30\n" .
		"OR: php Network.php www.baidu.com\n";

else {

	$Network_State = ping($argv[1]);

	if($Network_State == 0)

		echo "ping 网络超时\n";
	
	else
	
		echo "ping 网络成功\n";
	
	system("cat ping.txt");
}

?>
