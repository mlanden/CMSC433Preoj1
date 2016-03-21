<?php

$studentId = $_POST['campusId'];
$classes = $_POST['submitclass'];
$classList = explode(",", $classes);

$dbc = mysql_connect("studentdb-maria.gl.umbc.edu", "dale2", "cmsc433") or die(mysql_error());
mysql_select_db("dale2", $dbc);

foreach($classList as $class){
	$inx = strpos($class, ':');
	$key = substr($class, 0, $inx);
	$sql = "INSERT INTO `StudentCourses`(`courseID`, `studentID`) VALUES ('$key','$studentId')";
	echo $key;
	mysql_query($sql, $dbc);
}
?>