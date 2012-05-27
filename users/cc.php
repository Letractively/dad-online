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

	// Get classes list

	$query = "SELECT id,name FROM classes";
	$result = mysql_query($query) or die(mysql_error());

	// Load HTML5 Template

    $depth = "../aat/"; include_once '../aat/header.php';

	// Class/Race Selector

	echo '<script language=javascript>
			function reload(form) {
			var val=form.class.options[form.class.options.selectedIndex].value;
			self.location="cc.php?class=" + val;
		}
		</script>';

	// Characer Creation Form

	echo '<script language="javascript" src="js/cc.js">
		</script>
		<form id="cc" name="cc" action="cc_do.php" method="post" accept-charset="UTF-8">
			<legend>Character Creation</legend>
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" maxlength="16" required/><br/>
			<label for="race">Class:</label>
			<select name="class" onChange="reload(this.form)" required>
			<option value="">Please select a class</option>';

	// Fill selection with available classes

	while($row = mysql_fetch_array($result)) {
		echo '<option value="'.$row[0].'">'.$row[1].'</option>';
	}

	// Character Creation Form end + Race picture preview

	echo '</select></br>
			<input type="submit" value="create" name="submit" class="submit" />
			<input type="submit" value="cancel" name="register" class="register" onClick="location.href=\'index.php\'" />
		</form>
		<img name="pic" src="images/blank.png" border="0">';

    // Load HTML5 Template

    include_once '../aat/footer.php';
?>
