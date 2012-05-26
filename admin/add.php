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

	// Admin Login Validation

	if (!admin_session_validate()) {
		header('Location: ../');
		exit;
	}

	// Get GET Variables

	$table = $_GET['table'];

	// Get Info
		
	$query = "SELECT * FROM $table";
	$result = mysql_query($query) or die(mysql_error());

	$fields = mysql_num_fields($result);

	// Get Foreign Keys

	$fkquery = 'SELECT column_name,referenced_table_name
		FROM information_schema.KEY_COLUMN_USAGE
		WHERE table_name = "'.$table.'"
			AND referenced_column_name IS NOT NULL';
	$fkresult = mysql_query($fkquery) or die(mysql_error());

	// Store Foreign Keys Info

	$fknames[] = null;
	$fktables[] = null;
	$i = 0;
	while ($fkrow=mysql_fetch_array($fkresult)) {
		$fknames[$i] = $fkrow[0];
		$fktables[$i] = $fkrow[1];
		$i++;
	}

	// Load HTML5 Template

	$depth = "../aat/"; include_once '../aat/header.php';

	// Add Form

	echo '<form name="adminedit" action="add_do.php?table='.$table.'" method="post" accept-charset="UTF-8">
		<legend>Add '.$table.'</legend>';
	$i = 1;
	while ($i < $fields) {
		$meta = mysql_fetch_field($result,$i);
		echo '<label>'.$meta->name.':</label>';
		if (in_array($meta->name,$fknames)) {

			// Get Foreign Keys Info

			$fkindex = array_search($meta->name, $fknames);

			$fkquery2 = "SELECT * FROM $fktables[$fkindex]";
			$fkresult2 = mysql_query($fkquery2) or die(mysql_error());

			echo '<p><select name="'.$meta->name.'" required >
				<option value=""></option>';
			while ($fkrow2=mysql_fetch_array($fkresult2)) {
				echo '<option value="'.$fkrow2[0].'">'.$fkrow2[1].'</option>';
			}
			echo '</select></p>';

		} else {
			echo '<input type="text" name="'.$meta->name.'" class="email" required />';
		}
		$i++;
	}
	echo '<input type="submit" value="add '.$table.'" name="submit" class="submit" />
		</form>';

	// Cancel Button

	echo '<p><input type="submit" value="cancel" name="extra" class="extra"
		onClick="location.href=\'index.php\'" /></p>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
