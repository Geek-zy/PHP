<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
<style>
table.gridtable {
font-family: verdana,arial,sans-serif;
font-size: 11px;
color: #333333;
border-width: 1px;
border-color: #666666;
border-collapse: collapse;
}

</style>
    </head>
    <body>
        <?php
        require_once 'function.php';
//	$Color = array("Blue", "#00CED1", "#228B22", "#191970", "#FF0000", "#6A5ACD");
	$Color = array("", "#7FE817", "#E18B6B", "#7FE817", "#E18B6B", "#7FE817", "#E18B6B", "#7FE817");
	$source="";
	$aetitle="";
	$PATIENT_AGE="";
        $DICOM_List = fetchAll($source,$aetitle);
//        echo $DICOM_List;
        $MyArray = json_decode($DICOM_List);
        //echo $MyArray;    
        $Table = "<center><table style='gridtable'>";
            $Table .= "<th style='border:1px solid black;'>数目</th>";
            $Table .= "<th style='border:1px solid black;'>序列号</th>";
            $Table .= "<th style='border:1px solid black;'>病人ID</th>";
            $Table .= "<th style='border:1px solid black;'>病人姓名</th>";
            $Table .= "<th style='border:1px solid black;'>性别</th>";
            $Table .= "<th style='border:1px solid black;'>年龄</th>";
            $Table .= "<th style='border:1px solid black;'>系列</th>";
            $Table .= "<th style='border:1px solid black;'>实例</th>";
            $Table .= "<th style='border:1px solid black;'>设备</th>";
            $Table .= "<th style='border:1px solid black;'>创建时间</th>";
            $Table .= "<th style='border:1px solid black;'>检查时间</th>";
            $Table .= "<th style='border:1px solid black;'>医院</th>";
            $Table .= "<th style='border:1px solid black;'>AE</th>";
	$TempNumber = 1;
	$TempDate = "";
	$ColorIndex = 0;
       foreach ($MyArray->list as $Record) {
            $Table .= "<tr>";
	    $Date  = explode(" ", $Record->CREATION_DTTM);
	    $Last  = explode("-", $Date[0]);
	    if(trim($Last[2])!=$TempDate) {
		$TempDate = trim($Last[2]);
		$TempNumber = 1;
		$ColorIndex ++;
		}
	    else {
		$TempNumber = $TempNumber +1 ;
		}
	    $Table .= "<td style='border:1px solid black;background-color:" . $Color[$ColorIndex] .  ";'>" . $TempNumber . "</td>";
            $Table .= "<td style='border:1px solid black;'>" . $Record->STUDY_KEY . "</td>";
            $Table .= "<td style='border:1px solid black;'>" . $Record->PATIENT_ID . "</td>";
            $Table .= "<td style='border:1px solid black;'>" . $Record->PATIENT_NAME . "</td>";
            $Table .= "<td style='border:1px solid black;'>" . $Record->PATIENT_SEX . "</td>";
	               
	if($Record->PATIENT_AGE2 !=""){
			$PATIENT_AGE = $Record->PATIENT_AGE2;
		}else{
			$PATIENT_AGE = $Record->PATIENT_AGE1;	    }
	    $Table .= "<td style='border:1px solid black;'>" . $PATIENT_AGE . "</td>";

            $Table .= "<td style='border:1px solid black;'>" . $Record->SERIES_COUNT . "</td>";
            $Table .= "<td style='border:1px solid black;'>" . $Record->INSTANCE_COUNT . "</td>";
            $Table .= "<td style='border:1px solid black;'>" . $Record->MODALITIES . "</td>";
            $Table .= "<td style='border:1px solid black;'>" . $Record->CREATION_DTTM . "</td>";
            $Table .= "<td style='border:1px solid black;'>" . $Record->STUDY_DTTM . "</td>";
            $Table .= "<td style='border:1px solid black;'>" . $Record->INSTITUTION . "</td>";
            $Table .= "<td style='border:1px solid black;'>" . $Record->SOURCE_AETITLE . "</td>";
            $Table .= "</tr>";
        }
        $Table .="</table></center>";
        echo $Table;
        ?>
    </body>
</html>
