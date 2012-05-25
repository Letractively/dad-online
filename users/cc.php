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

	// Get races list

	$query = "SELECT name FROM races";
	$result = mysql_query($query) or die(mysql_error());

	// Load HTML5 Template

    $depth = "../aat/"; include_once '../aat/header.php';

	// Characer Creation Form

	echo '<script language="javascript" src="js/cc.js">
		</script>
		<form id="cc" name="cc" action="cc_do.php" method="post" accept-charset="UTF-8">
			<legend>Character Creation</legend>
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" maxlength="16" required/><br/>
			<label for="race">Race:</label>
			<select name="race" onChange="changePicture()" required>
			<option value="">Please select a race</option>';

	// Fill selection with available races

	while($row = mysql_fetch_array($result)) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}

	// Character Creation Form end + Race picture preview

	echo '</select></br>
			<input type="submit" value="Create" name="submit" class="submit" />
			<input type="submit" value="Cancel" name="register" class="register" onClick="location.href=\'index.php\'" />
		</form>
		<img name="pic" src="images/blank.png" border="0">';

    // Load HTML5 Template

    include_once '../aat/footer.php';
?>
