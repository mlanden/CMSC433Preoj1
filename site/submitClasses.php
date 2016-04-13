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

<div class="container" style="background-color:transparent">
<div class="inner-container" style="background-color:transparent">

<?php

include('CommonMethods.php');
$debug = false;
$COMMON = new Common($debug);

$studentID = $_SESSION['studentID'];
$classes = $_POST['submitclass'];
$classList = explode(",", $classes);

//$dbc = mysql_connect("studentdb-maria.gl.umbc.edu", "dale2", "cmsc433") or die(mysql_error());
//mysql_select_db("dale2", $dbc);

	$sql = "SELECT * FROM `StudentCourses` WHERE `studentID` = '$studentID'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$isThere = mysql_fetch_row($rs);
	//echo $isThere[0];

//var_dump($isThere);

//var_dump($classList);

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

	$typeStr ="";
	if ($type == "Sci" || $type == "SciLab"){
		$typeStr = $type;
	}else{
		$typeStr = '%' . $type . '%';
	}
	$classes = $_POST['submitclass'];
	$final = array();
	$classList = explode(",", $classes);
	foreach($classList as $class){
		$inx = strpos($class, ':');
		$key = substr($class, 0, $inx);
		$classid = trim($key);
		if(strlen($classid) < 4){
			continue;
		}
		$sql = "SELECT DISTINCT Courses.courseID, Courses.name, Courses.prereqs FROM `Courses` WHERE Courses.prereqs LIKE '%$classid%'
			AND Courses.courseType Like '$typeStr' AND Courses.courseID NOT IN
	 		(
	 		    SELECT Courses.courseID FROM `Courses` INNER JOIN `StudentCourses` ON Courses.courseID = StudentCourses.courseID WHERE StudentCourses.studentID = '$studentID'
	 		)";
	 	$classes = mysql_query($sql, $dbc);
		while ($classinfo = mysql_fetch_assoc($classes)) {
			$prereqs = split(" ", $classinfo['prereqs']);
			$add = true;
			foreach ($prereqs as $needed) {
				$sql = "SELECT DISTINCT * FROM `StudentCourses` WHERE `studentID` = '$studentID' AND `courseID` = '$needed'";
				$result = mysql_query($sql, $dbc);
				if(mysql_num_rows($result) == 0){
					$add = false;
					break;
				}
			}
			if($add AND ! in_array($classinfo['courseID'] . ": " . $classinfo['name'], $final)){
				$final[] = $classinfo['courseID'] . ": " . $classinfo['name'];
			}
		}

	}

	$i = 0;
	foreach ($final as $class) {
		$i++;
		echo "<p class=\"class\">" . $class . "</p>";
		if($i % 3 ==0){
			echo("<br>");
		}
	}
}
	?>
<p style='background-color:white'>The classes you should take going forward include: </p>
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