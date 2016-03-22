<?php

session_start();

$studentID = $_SESSION['studentID'];
$classes = $_POST['submitclass'];
$classList = explode(",", $classes);

$dbc = mysql_connect("studentdb-maria.gl.umbc.edu", "dale2", "cmsc433") or die(mysql_error());
mysql_select_db("dale2", $dbc);

foreach($classList as $class){
	$inx = strpos($class, ':');
	$key = substr($class, 0, $inx);
	$classid = trim($key);

	if(strlen($key) > 0){
		$sql = "INSERT INTO `StudentCourses`(`courseID`, `studentID`) VALUES ('$classid','$studentID')";
		var_dump($sql);
		mysql_query($sql, $dbc);
	}
}
?>