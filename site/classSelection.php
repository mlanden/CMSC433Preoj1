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

	$studentID = strtoupper($_POST['studentID']);
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];

	$_SESSION['studentID'] = $studentID;
	$_SESSION['fname'] = $fname;
	$_SESSION['lname'] = $lname;
	$_SESSION['email'] = $email;


	$sql = "SELECT * FROM `Students` WHERE `studentID` = '$studentID'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$isThere = mysql_fetch_row($rs);
	//echo $isThere[0];

	if (empty($isThere)){
	$sql = "INSERT INTO `Students`(`studentID`, `fname`, `lname`, `email`) VALUES ('$studentID', '$fname', '$lname', '$email')";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	}

	function classes($type){
		$dbc = mysql_connect("studentdb-maria.gl.umbc.edu", "dale2", "cmsc433") or die(mysql_error());
		mysql_select_db("dale2", $dbc);
		$sql = "SELECT `courseID`, `name` FROM `Courses` WHERE `courseType` LIKE '%$type%'";
		$classes = mysql_query($sql, $dbc);
		$i = 1;
		while($row = mysql_fetch_assoc($classes)){
			echo "<p class=\"class\"><input type=\"checkbox\" class = \"classoption\" onclick = 'AddRemoveClass(this);' value = '" . $row['courseID'] . ": " . $row['name'] ."'/>" . $row['courseID'] . ": " . $row['name'] . "</p>";
			if( $i % 3 == 0){
				echo "<br>";
			}
			$i++;
		}
	}
?>
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

<form id="classesTaken" action="submitClasses.php" method="post">
<p>Classes taken</p>
<textarea id = "Selected" name="submitclass"readonly></textarea>
<input type="text" name="studentID" id="studentID" hidden>
<input type="submit"/>
</form>

</div>
</div>

</body>
<footer>
	<script type="text/javascript">
		var id = "<?php echo $_POST['studentID']?>";
		var input = document.getElementById("studentID").value = id;
		function AddRemoveClass(checkbox){
			if(checkbox.checked){
				var text = document.getElementById("Selected");
				text.value += checkbox.value + ",\n";
			}else{
				var text = document.getElementById("Selected");
				text.value = text.value.replace(checkbox.value + ',\n', '');
			}
		}

	</script>
</footer>
</html>