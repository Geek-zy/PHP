<?php

$File_URL = "DATA/";

if ($_FILES["File"]["error"] > 0 && $_FILES["File"]["error"] > 0) {

	echo "错误 ==> " . $_FILES["File"]["error"] . "<br>";
}

else {

	// 判断上传目录是否存在该文件,目录权限为777
	if (file_exists("$File_URL" . $_FILES["File"]["name"])) {

		echo $_FILES["File"]["name"] . " 文件已经存在。";
	}

	else {

		// 如果目录不存在该文件则将文件上传到该目录下
		move_uploaded_file($_FILES["File"]["tmp_name"], "$File_URL" . $_FILES["File"]["name"]);

		echo "上传文件名: " . $_FILES["File"]["name"] . "<br>";
		echo "文件类型: " . $_FILES["File"]["type"] . "<br>";
		echo "文件大小: " . ($_FILES["File"]["size"] / 1024) . " kB<br>";
		echo "文件临时存储的位置: " . $_FILES["File"]["tmp_name"] . "<br>";
		echo "文件存储在: " . "$File_URL" . $_FILES["File"]["name"];
	}
}
?>
