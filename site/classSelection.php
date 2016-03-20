<!DOCTYPE html>
<html>
<head>
	<title>Computer Science Advising</title>
	<link rel="stylesheet" type="text/css" href="design.css">
</head>
<body>
<?php
	$id = $_POST['campusId'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$sql = "INSERT INTO `Students`(`studentID`, `fname`, `lname`, `email`) VALUES ('$id', '$fname', '$lname', '$email')";
	$dbc = mysql_connect("studentdb-maria.gl.umbc.edu", "dale2", "cmsc433") or die(mysql_error());
	mysql_select_db("dale2", $dbc);
	$result = mysql_query($sql, $dbc);

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
	<legend>Technical Wlectives</legend>
	<?php classes("Techelec");?>
</fieldset>
<fieldset>
	<legend>Other Compter Science</legend>
	<?php classes("otherCS");?>
</fieldset>
</form>

<form id="classesTaken" action="submitClasses.php" method="post">
<p>Classes taken</p>
<textarea id = "Selected" readonly></textarea>
<input type="text"  id= "submitclass"/>
<input type="submit"/>
</form>
</body>
<footer>
	<script type="text/javascript">
		function AddRemoveClass(checkbox){
			if(checkbox.checked){
				var text = document.getElementById("Selected");
				text.value += checkbox.value + "\n";
				var submit = document.getElementById("submitclass");
				submit.value += checkbox.value + ",";
			}else{
				var text = document.getElementById("Selected");
				text.value = text.value.replace(checkbox.value + '\n', '');
				var submit = document.getElementById("submitclass");
				submit.value = submit.value.replace(checkbox.value+',','');
			}
		}

	</script>
</footer>
</html>