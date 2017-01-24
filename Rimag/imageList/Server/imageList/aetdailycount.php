<?php

//http://nfs.rimag.com.cn/imageListTest/json.php?aetitle=sync&startDate=20151129&endDate=20151208
// 一个
require_once 'function.php';
$AETITLE = $_GET['aetitle'];
$SearchStartDay = new DateTime($_GET['startdate']);

MySQL_PHP7();
diagnosticDailyCount($AETITLE, $SearchStartDay);




