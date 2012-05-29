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

	// Get Info
		
	$query = "SELECT email,accesslevel FROM users WHERE id=$id";
	$result = mysql_query($query) or die(mysql_error());

	$row=mysql_fetch_array($result);
	$fields = mysql_num_fields($result);

	// Load HTML5 Template

	$title = "<a>Edit User</a>";
	$depth = "../aat/"; include_once '../aat/header.php';

	// Show Editable Info

	echo '<form name="adminedituser" action="edit_do.php?id='.$id.'&table=users" method="post" accept-charset="UTF-8">
		<legend>Edit User</legend>';
	$i = 0;
	while ($i < $fields) {
		$meta = mysql_fetch_field($result,$i);
		echo '<label>'.$meta->name.':</label>';
		echo '<input type="text" name="'.$meta->name.'" class="email" value="'.$row[$i].'" />';
		$i++;
	}
	echo '<input type="submit" value="edit user" name="submit" class="submit" />
		</form>';

	// Cancel Button

	echo '<p><input type="submit" value="cancel" name="extra" class="extra"
		onClick="location.href=\'users.php\'" /></p>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
