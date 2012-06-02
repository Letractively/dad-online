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

	$table = mysql_real_escape_string($_GET['table']);

	// Get List
		
	$query = "SELECT * FROM $table ORDER BY id";
	$result = mysql_query($query) or die(mysql_error());

	$fields = mysql_num_fields($result);

	// Load HTML5 Template

	$title = "<a>List of ".$table."</a>";
    $depth = "../aat/"; include_once '../aat/header.php';

	// Show Info

	echo '<table border="1">';
	while ($row=mysql_fetch_array($result)){
		echo '<tr>';
		$i = 0;
		while ($i < $fields) {
			echo '<td>'.$row[$i].'</td>';
			$i++;
		}
		echo ('<td><a href=\'edit.php?id='.$row[0].'&table='.$table.'\'>Edit</a></td>');
		echo ('<td><a href=\'delete.php?id='.$row[0].'&table='.$table.'\'>Delete</a></td></tr>');
	}
	echo '</table>';

	// Cancel Button

	echo '<p><input type="submit" value="cancel" name="extra" class="extra"
		onClick="location.href=\'index.php\'" /></p>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
