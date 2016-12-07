<?php

require_once('Classes/PHPExcel.php');
require_once('Classes/PHPExcel/Writer/Excel2007.php');
require_once('Classes/PHPExcel/IOFactory.php');
PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);

//设置文件属性  
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");  
$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");  
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");  
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");  
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");  
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");  
$objPHPExcel->getProperties()->setCategory("Test result file");

//添加数据 可以指定位置  
$objPHPExcel->setActiveSheetIndex(0);  
$objPHPExcel->getActiveSheet()->setCellValue('A1', "PID");
$objPHPExcel->getActiveSheet()->setCellValue('B1', "日期");  
$objPHPExcel->getActiveSheet()->setCellValue('C1', "姓名");  
$objPHPExcel->getActiveSheet()->setCellValue('D1', "性别");  
$objPHPExcel->getActiveSheet()->setCellValue('E1', "年龄");  
$objPHPExcel->getActiveSheet()->setCellValue('F1', "部位数");  
$objPHPExcel->getActiveSheet()->setCellValue('G1', "部位");  

//添加表头
$num = 2; 

$objPHPExcel->getActiveSheet(0)
	->setCellValue( 'A'.$num,1)
	->setCellValue( 'B'.$num,2)
	->setCellValue( 'C'.$num,3)
	->setCellValue( 'D'.$num,4)
	->setCellValue( 'E'.$num,5)
	->setCellValue( 'F'.$num,6)
	->setCellValue( 'G'.$num,7);

//生成表格
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('Yi-Zhang.xlsx');

?>
