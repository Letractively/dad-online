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

	$id = $_GET['id'];
	$table = $_GET['table'];

	// Get Info
		
	$query = "SELECT * FROM $table WHERE id=$id";
	$result = mysql_query($query) or die(mysql_error());

	$row=mysql_fetch_array($result);
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

	// Show Editable Info

	echo '<form name="adminedit" action="" method="post" accept-charset="UTF-8">
		<legend>Edit '.$table.'</legend>';

	$i = 0;
	$j = 0;
	while ($i < $fields) {
		$meta = mysql_fetch_field($result,$i);
		echo '<label>'.$meta->name.':</label>';
		if (in_array($meta->name,$fknames)) {

			// Get Foreign Keys Info

			$fkquery2 = "SELECT * FROM $fktables[$j]";
			$fkresult2 = mysql_query($fkquery2) or die(mysql_error());

			echo '<p><select name="'.$meta->name.'" required >
				<option value=""></option>';

			while ($fkrow2=mysql_fetch_array($fkresult2)) {
				echo '<option value="'.$fkrow2[0].'">'.$fkrow2[1].'</option>';
			}

			echo '</select></p>';

			// REQUIRES SCRIP TO SELECT ORIGINAL!!! (value = $row[$i])

			$j++;

		} else {
			echo '<input type="text" name="'.$meta->name.'" class="email" value="'.$row[$i].'" />';
		}
		$i++;
	}

	echo '</form>';

	// Cancel Button

	echo '<p><input type="submit" value="cancel" name="extra" class="extra"
		onClick="location.href=\'index.php\'" /></p>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
