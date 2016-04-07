<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>LOL CATS</title>
</head>

<body>

<?php

include('CommonMethods.php');
$debug = false;
$COMMON = new Common($debug);

$type = $_POST['type'];

if ($type == "TF"){
	$qNum = $_POST['qNum'];
	$question = $_POST['question'];
	$option1 = $_POST['option1'];
	$option2 = $_POST['option2'];
	$answer = $_POST['answer'];

	$sql = "INSERT INTO `Question`(`count`, `question`, `type`, `option1`, `option2`, `answer`) VALUES ([$qNum],[$question],[$type],[$option1],[$option2],[$answer])";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

} else if ($type == "MC"){
	$qNum = $_POST['qNum'];
	$question = $_POST['question'];
	$option1 = $_POST['option1'];
	$option2 = $_POST['option2'];
	$option3 = $_POST['option3'];
	$option4 = $_POST['option4'];
	$option5 = $_POST['option5'];
	$answer = $_POST['answer'];

	$sql = "INSERT INTO `Question`(`count`, `question`, `type`, `option1`, `option2`, `option3`, `option4`, `option5`, `answer`) VALUES ([$qNum],[$question],[$type],[$option1],[$option2],[$option3,[$option4],[$option5],[$answer])";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
}


?>
<input type='submit' value='submit' id='submit'>
</body>
</html>