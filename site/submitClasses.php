<?php

session_start();

?>

<?php

session_start();

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


<head>
<title>Advising Sign Up</title>
<!-- ============================================================== -->
<meta name="resource-type" content="document" />
<meta name="distribution" content="global" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="Content-Language" content="en-us" />
<meta name="description" content="CMSC Graduation Path" />
<meta name="keywords" content="CMSC Graduation Path" />
<!-- ============================================================== -->

<base target="_top" />
<link rel="stylesheet" type="text/css" href="styler.css" />
<link rel="icon" type="image/png" href="icon.png" />
</head>

<body id="login">

<!-- Styling - Same on Every Page -->
<div class="topContainer">
  <div class="leftTopContainer">
    
  	<img src="umbcLogo.png" width="261" height="72" alt="umbcLogo" />
  	<b>CMSC Graduation Path</b>
  
  	</div>
    
  <div class="rightTopContainer">
  		<div class="rightTopContent">
        <a href="index.php">Logout</a>	
        </div>
  
    </div>
</div>

<body>

<div class="container">
<div class="inner-container">

<?php

include('CommonMethods.php');
$debug = false;
$COMMON = new Common($debug);

$studentID = $_SESSION['studentID'];
$classes = $_POST['submitclass'];
$classList = explode(",", $classes);

//$dbc = mysql_connect("studentdb-maria.gl.umbc.edu", "dale2", "cmsc433") or die(mysql_error());
//mysql_select_db("dale2", $dbc);

$sql = "SELECT * FROM `Students` WHERE `studentID` = '$studentID'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$isThere = mysql_fetch_row($rs);
	//echo $isThere[0];

if (empty($isThere)){

	foreach($classList as $class){
		$inx = strpos($class, ':');
		$key = substr($class, 0, $inx);
		$classid = trim($key);

		if(strlen($key) > 0){
			$sql = "INSERT INTO `StudentCourses`(`courseID`, `studentID`) VALUES ('$classid','$studentID')";
			//var_dump($sql);
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			//mysql_query($sql, $dbc);
		}
	}
}

function classes($type){
		$studentID = $_SESSION['studentID'];
		$dbc = mysql_connect("studentdb-maria.gl.umbc.edu", "dale2", "cmsc433") or die(mysql_error());
		mysql_select_db("dale2", $dbc);
		$sql = "SELECT Courses.courseID, Courses.name
				FROM  `Courses` 
				INNER JOIN  `StudentCourses` ON Courses.prereqs LIKE CONCAT('%', StudentCourses.courseID, '%')
				AND StudentCourses.studentID =  '$studentID' AND Courses.courseType Like '%$type%' WHERE Courses.courseID NOT IN
				(SELECT Courses.courseID FROM `Courses` INNER JOIN `StudentCourses` ON Courses.courseID = StudentCourses.courseID AND StudentCourses.studentID = '$studentID')";
		//var_dump($sql);
		$classes = mysql_query($sql, $dbc);
		$i = 1;
		while($row = mysql_fetch_assoc($classes)){
			echo "<p class=\"class\">" . $row['courseID'] . ": " . $row['name'] . "</p>";
			if( $i % 3 == 0){
				echo "<br>";
			}
			$i++;
		}
	}
?>
<p>The classes you should take going forward include: </p>
<form id="allClasses">
<fieldset>
	<legend>Core Computer Science</legend>
	<?php classes("CScore");?>
</fieldset>
<fieldset>
	<legend>Required Math</legend>
	<?php classes("Reqmath");?>
</fieldset>
<fieldset>
	<legend>Required Stat</legend>
	<?php classes("Reqstat");?>
</fieldset>
<fieldset>
	<legend>Science</legend>
	<?php classes("Sci");?>
</fieldset>
<fieldset>
	<legend>Science with Lab</legend>
	<?php classes("SciLab");?>
</fieldset>
<fieldset>
	<legend>Computer Science Electives</legend>
	<?php classes("CSelec");?>
</fieldset>
<fieldset>
	<legend>Technical Electives</legend>
	<?php classes("Techelec");?>
</fieldset>
<fieldset>
	<legend>Other Compter Science</legend>
	<?php classes("otherCS");?>
</fieldset>
</form>


</div>
</div>

</body>
</html>