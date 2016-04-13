<button id='myButton' type='button' onclick='deleteFunction($studentID)''>Restart</button>

function deleteFunction(){
			<?php

			$sql = "DELETE FROM `StudentCourses` WHERE `studentID` = '$studentID'";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$isThere = mysql_fetch_row($rs);

			$sql = "DELETE FROM `Students` WHERE `studentID` = '$studentID'";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$isThere = mysql_fetch_row($rs);

			?>
			var url = "index.php";
			window.location(url);

		}