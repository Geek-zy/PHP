<?php

require_once 'Classes/PHPExcel.php';
require_once('Classes/PHPExcel/Writer/Excel2007.php');
require_once('Classes/PHPExcel/IOFactory.php');
//PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);

$AET = $argv[1];
$URL = $argv[2];
$Detail = json_decode(file_get_contents($URL), true);
$TempArray=$Detail['list'];

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
$objPHPExcel->getActiveSheet()->setCellValue('A1', "序号");
$objPHPExcel->getActiveSheet()->setCellValue('B1', "流水号");
$objPHPExcel->getActiveSheet()->setCellValue('C1', "设备号");  
$objPHPExcel->getActiveSheet()->setCellValue('D1', "患者ID");  
$objPHPExcel->getActiveSheet()->setCellValue('E1', "患者姓名");  
$objPHPExcel->getActiveSheet()->setCellValue('F1', "性别");  
$objPHPExcel->getActiveSheet()->setCellValue('G1', "年龄");
$objPHPExcel->getActiveSheet()->setCellValue('H1', "部位数");  
$objPHPExcel->getActiveSheet()->setCellValue('I1', "部位");  
$objPHPExcel->getActiveSheet()->setCellValue('J1', "胶片数量");  
$objPHPExcel->getActiveSheet()->setCellValue('K1', "检查日期");  

//添加表头

$num = 1; 
foreach($TempArray as $key => $value){   

        $TotalFilm = intval($value["FILM_Printed"])+intval($value["AW_Printed"]);

	$num += 1;

	$objPHPExcel->getActiveSheet(0)
				->setCellValue( 'A'.$num,($num - 1))
				->setCellValue( 'B'.$num,$value['STUDY_ID'] )
				->setCellValue( 'C'.$num,$value['ACCESSION_NO'] )
				->setCellValue( 'D'.$num,$value['PATIENT_ID'] )
				->setCellValue( 'E'.$num,$value['PATIENT_NAME'] )
				->setCellValue( 'F'.$num,$value['PATIENT_SEX'] )
				->setCellValue( 'G'.$num,$value['PATIENT_AGE1'] )
				->setCellValue( 'H'.$num,$value['BODYPART_NUM'] )
				->setCellValue( 'I'.$num,$value['BODYPART_DESC'] )
				->setCellValue( 'J'.$num,$TotalFilm)
				->setCellValue( 'K'.$num,$value['STUDY_DTTM'] );

}

//生成表格
system("rm Excel/$AET.xlsx");
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save("Excel/$AET.xlsx");

?>
