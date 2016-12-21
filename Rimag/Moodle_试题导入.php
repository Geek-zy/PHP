<?php

$questionArray = array();
$Questionhandle = @fopen("2012_entryLevel.txt", "r");
$Answerhandle = @fopen("2012_entryLevel_Answer.txt", "r");

$Questionhandle = @fopen("techFinance.txt", "r");
$Answerhandle = @fopen("techFinance_Answer.txt", "r");



if ($Questionhandle) {
	while (($buffer = fgets($Questionhandle, 1024)) !== false) {
		echo "--" . substr( $buffer, 0, 9 ) . "--" . PHP_EOL;
		if (substr($buffer, 0, 9) === "［试题") {
			$currentQuestion = array();
			echo "$buffer \n";
			$currentQuestion["question"] = trim($buffer);
			$questions = trim(fgets($Questionhandle, 1024));
			echo $questions . PHP_EOL;
			$currentQuestion["selections"] = $questions;
			array_push($questionArray, $currentQuestion);
		}
	}
	if (!feof($Questionhandle)) {
		echo "Error: unexpected fgets() fail\n";
	}
	fclose($Questionhandle);
}

$index = 0;
$answerArray = array();
if ($Answerhandle) {
	while (($buffer = fgets($Answerhandle, 8192)) !== false) {
		echo "$buffer \n";
		preg_match_all('#\((.*?)\)#', $buffer, $answer);
		$answerArray = array_merge($answerArray, $answer[1]);
	}
	if (!feof($Answerhandle)) {
		echo "Error: unexpected fgets() fail\n";
	}
	fclose($Answerhandle);
}

foreach ($questionArray as $index => $key) {
	$questionArray[$index]['answer'] = $answerArray[$index];
}

print_r($questionArray);
print_r($answerArray);


foreach ($questionArray as $index => $value) {
	$question = $value['question'];
	$selections = $value['selections'];
	$answer = $value['answer'];
	$selectionArray = preg_split("/[A-Z]、/", $selections);
	array_shift($selectionArray);

	$anserArray = str_split(strtoupper($answer));

	echo "==" . $question . "\n";
	print_r($selectionArray);
	$anserArray = array_map("answerToNumber", $anserArray);
	$answerNumber = count($anserArray);
	$answerPercent = (100 / count($anserArray));
	echo $answerPercent;
	print_r($anserArray);

	array_walk($selectionArray, "popAnswer", $anserArray);

	$answerString = "{" . implode(" ", $selectionArray) . "}";

	$questionString = $question . $answerString . "\n";

	echo $questionString . "\n";
}

function popAnswer(&$item, $key, $anserArray) {
	global $answerPercent;
	if (in_array($key, $anserArray)) {
		$item = "~%$answerPercent%$item";
	} else {
		$item = "~%-100%$item";
	}
}

function answerToNumber($n) {
	return(ord($n) - 65);
}
