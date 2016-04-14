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
	
	//include SQL connectivity file for easy database access
	include('CommonMethods.php');
	$debug = false;
	$COMMON = new Common($debug);

	//grabs form data from index page
	$studentID = strtoupper($_POST['studentID']);
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];

	//creates session data of the form information
	$_SESSION['studentID'] = $studentID;
	$_SESSION['fname'] = $fname;
	$_SESSION['lname'] = $lname;
	$_SESSION['email'] = $email;

	//sql query to see if student exists
	$sql = "SELECT * FROM `Students` WHERE `studentID` = '$studentID'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$isThere = mysql_fetch_row($rs);

	//if no student is currently in the database, display the list of classes
	if (empty($isThere)){
		$sql = "INSERT INTO `Students`(`studentID`, `fname`, `lname`, `email`) VALUES ('$studentID', '$fname', '$lname', '$email')";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		// the form is seperated into different section one for each requirement type.  outside function is used to input classes
		echo "
		<form id='allClasses'>

		<p class='instructP' style='background-color:white'>
		Please select classes you have already taken by clicking the check box next to the class. When you are finished, hit the submit button to the right of your screen.

		</p>

		<fieldset>
			<legend>Core Computer Science</legend>
			" . classes("CScore") . "
		</fieldset>
		<fieldset>
			<legend>Required Math</legend>
			".classes("Reqmath")."
 		</fieldset>
		<fieldset>
			<legend>Required Stat</legend>
			".classes("Reqstat")."
		</fieldset>
		<fieldset>
			<legend>Science</legend>
			".classes("Sci")."
		</fieldset>
		<fieldset>
			<legend>Science with Lab</legend>
			".classes("SciLab")."
		</fieldset>
		<fieldset>
			<legend>Computer Science Electives</legend>
			".classes("CSelec")."
		</fieldset>
		<fieldset>
			<legend>Technical Electives</legend>
			".classes("Techelec")."
		</fieldset>
		<fieldset>
			<legend>Other Compter Science</legend>
			".classes("otherCS")."
		</fieldset>
		</form>

		";

	//otherwise print out that they are already entered into the database and can choose to start over
	} else {
		echo "<form id='deleteClasses' action='deleteStudent.php' method='post'><p class='centerP' style='background-color:white'>You have already chosen classes! 
		Please click the Submit button to the right to see the list of recommended classes. 
		Otherwise, click the Restart button below to enter class information again. <br> <br>
		<input type='submit' id='restart' value='Restart'/>
		</p>
		</form>";
	}

	/*********
	/ classes($type)
	/ $type is the string that matches requirement types in the database
	/*unction that grabs a list of classes from the database and sends their display back to the HTML field to be displayed
	*********/
	function classes($type){
		$dbc = mysql_connect("studentdb-maria.gl.umbc.edu", "dale2", "cmsc433") or die(mysql_error());
		mysql_select_db("dale2", $dbc);
		$sql = "SELECT `courseID`, `name` FROM `Courses` WHERE `courseType` LIKE '%$type%'";
		$classes = mysql_query($sql, $dbc);
		$i = 1;
		$str = "";
		while($row = mysql_fetch_assoc($classes)){
			$str .= "<p class=\"class\"><input type=\"checkbox\" class = \"classoption\" onclick = 'AddRemoveClass(this);' value = '" . $row['courseID'] . ": " . $row['name'] ."'/>" . $row['courseID'] . ": " . $row['name'] . "</p>";
			if( $i % 3 == 0){
				$str .= "<br>";
			}
			$i++;
		}
		return $str;
	}
?>

<!-- Floating form where classes get entered. Data is hidden -->
<form id="classesTaken" action="submitClasses.php" method="post">
<p><b>Next Semester Classes</b></p>
<textarea id = "Selected" name="submitclass" readonly hidden></textarea>
<input type="text" name="studentID" id="studentID" hidden>
<input type="submit" id="submit" value='Submit'/>
</form>

</div>
</div>

</body>
<footer>

	<!-- Script that places the selected classes into the floating form -->
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