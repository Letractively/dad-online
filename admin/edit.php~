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

	$id = mysql_real_escape_string($_GET['id']);
	$table = mysql_real_escape_string($_GET['table']);

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

	$title = "<a>Edit ".$table."</a>";
	$depth = "../aat/"; include_once '../aat/header.php';

	// Show Editable Info

	echo '<form name="adminedit" action="edit_do.php?id='.$id.'&table='.$table.'" method="post" accept-charset="UTF-8">
		<legend>Edit '.$table.'</legend>';
	$i = 1;
	while ($i < $fields) {
		$meta = mysql_fetch_field($result,$i);
		echo '<label>'.$meta->name.':</label>';
		if (in_array($meta->name,$fknames)) {

			// Get Foreign Keys Info

			$fkindex = array_search($meta->name, $fknames);

			$fkquery2 = "SELECT * FROM $fktables[$fkindex]";
			$fkresult2 = mysql_query($fkquery2) or die(mysql_error());

			$original = mysql_fetch_array(mysql_query("SELECT name FROM $fktables[$fkindex] WHERE id=$row[$i]"));

			if ($meta->name == "user") $original = mysql_fetch_array(mysql_query("SELECT email FROM $fktables[$fkindex] WHERE id=$row[$i]"));

			// Fill Foreign Keys Info

			echo '<p><select name="'.$meta->name.'" required >
				<option value="'.$row[$i].'">'.$original[0].'</option>';
			while ($fkrow2=mysql_fetch_array($fkresult2)) {
				if ($fkrow2[0] != $row[$i]) echo '<option value="'.$fkrow2[0].'">'.$fkrow2[1].'</option>';
			}
			echo '</select></p>';

		} else {
			echo '<input type="text" name="'.$meta->name.'" class="email" value="'.$row[$i].'" />';
		}
		$i++;
	}
	echo '<input type="submit" value="edit '.$table.'" name="submit" class="submit" />
		</form>';

	// Cancel Button

	echo '<p><input type="submit" value="cancel" name="extra" class="extra"
		onClick="location.href=\'list.php?table='.$table.'\'" /></p>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
