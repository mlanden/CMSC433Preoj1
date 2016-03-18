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
			echo "<p class=\"class\"><input type=\"checkbox\" class = \"classoption\">" . $row['courseID'] . ": " . $row['name'] . "</input></p>";
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

<form id="classesTaken">
<p>Classes taken</p>
</form>
</body>
<footer>
	<script type="text/javascript">
		var classes = document.getElementsByClassName("classoption");

		function AddRemoveClass(){
			alert("Add or remove click class");
		}
		for(var i = 0; i < classes.length; i++){
			alert(i);
			classes[i].onclick = AddRemoveClass;
		}
		alert("Done");
	</script>
</footer>
</html>