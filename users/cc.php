<?php
/*
DAD Online. Web browser MMORPG.
Copyright(C) 2012 Aceapps Aplicaciones. 
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses
*/

	// Session Start

	session_start();

	// Load files

	require_once '../include/config.php';
	require_once '../include/functions.php';

	// Login Validation

	if (!session_validate()) {
		header('Location: ../');
		exit;
	}

	// Get session variables

	$userid = $_SESSION['id'];
	$accesslevel = $_SESSION['accesslevel'];

	// Character amount verification info
		
	$query = "SELECT * FROM characters WHERE user = '$userid'";
	$result = mysql_query($query) or die(mysql_error());

	if(mysql_num_rows($result) >= $maxchars) {
		echo '<script language="javascript">
				alert("You can\'t create any more characters!");
				window.location = ("index.php");
			</script>';
		exit;
	}

	// Get GET Variables

	$cid = '';
	$classtext = 'Please select a class';
	$racetext = 'Select a class first';
	if (isset($_GET['class'])) {
		$cid = mysql_real_escape_string($_GET['class']);

		// Get class name
		$classtextarray = mysql_fetch_array(mysql_query("SELECT name FROM classes WHERE id=$cid"));
		$classtext = $classtextarray[0];

		$racetext = 'Please select a race';

		// Get races list

		$query2 = "SELECT id,name FROM races WHERE class=$cid";
		$result2 = mysql_query($query2) or die(mysql_error());
	}

	$name = '';
	if (isset($_GET['name'])) $name = mysql_real_escape_string($_GET['name']);

	// Get classes list

	$query = "SELECT id,name,accesslevel FROM classes";
	$result = mysql_query($query) or die(mysql_error());

	// Load HTML5 Template

	$title = '<li><a href="index.php">Home</a></li>
		<li><a href="profile.php">Profile</a></li>
		<li><a href="cc.php">Create Character</a></li>
		<li><a href="logout.php">Logout</a></li>';
	$depth = "../aat/"; include_once '../aat/header.php';

	// Class/Race Selector

	echo '<script language=javascript>
			function reload(form) {
				var val=form.class.options[form.class.options.selectedIndex].value;
				var name=form.name.value;
				self.location="cc.php?class=" + val + "&name=" + name;
			}
		</script>';

	// Characer Creation Form

	echo '<script language="javascript" src="js/cc.js">
		</script>
		<form id="cc" name="cc" action="cc_do.php" method="post" accept-charset="UTF-8">
			<legend>Character Creation</legend>
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" maxlength="16" value="'.$name.'" required/><br/>
			<p><label for="class">Class:</label>
			<select name="class" onChange="reload(this.form)" required>
			<option value="'.$cid.'">'.$classtext.'</option>';

	// Fill selection with available classes

	while($row = mysql_fetch_array($result)) {
		if (($row[0] != $cid) && ($accesslevel >= $row[2])) 
			echo '<option value="'.$row[0].'">'.$row[1].'</option>';
	}

	echo '</select></p>
			<p><label for="race">Race:</label>
			<select name="race" onChange="changePicture()" required>
			<option value="">'.$racetext.'</option>';

	// Fill selection with races of the selected class

	if ($cid != '') {
		while($row = mysql_fetch_array($result2)) {
			echo '<option value="'.$row[0].'">'.$row[1].'</option>';
		}
	}

	// Character Creation Form end + Race picture preview

	echo '</select></p>
			<input type="submit" value="create" name="submit" class="submit" />
			<input type="submit" value="cancel" name="register" class="register" onClick="location.href=\'index.php\'" />
		</form>
		<img name="pic" src="images/blank.png" border="0">';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
