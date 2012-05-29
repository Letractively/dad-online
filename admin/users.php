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

	// Get Users Info
		
	$query = "SELECT id,email,accesslevel FROM users";
	$result = mysql_query($query) or die(mysql_error());

	// Load HTML5 Template

	$title = "<a>Users List</a>";
    $depth = "../aat/"; include_once '../aat/header.php';

	// Show Users Info

	echo '<table border="1">';
	while ($row=mysql_fetch_array($result)){
		echo ('<tr><td>'.$row[0].'</td>');
		echo ('<td>'.$row[1].'</td>');
		echo ('<td>'.$row[2].'</td>');
		echo ('<td><a href=\'edit_user.php?id='.$row[0].'\'>Edit</a></td>');
		echo ('<td><a href=\'delete.php?id='.$row[0].'&table=users\'>Delete</a></td></tr>');
	}
	echo '</table>';

	// Cancel Button

	echo '<p><input type="submit" value="cancel" name="extra" class="extra"
		onClick="location.href=\'index.php\'" /></p>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
