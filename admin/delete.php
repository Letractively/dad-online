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

	// Delete

	$query = "DELETE FROM $table WHERE id=$id";
	$result = mysql_query($query) or die(mysql_error());

	echo '<script language="javascript">
			alert("Delete successful!!!");
			window.location = ("index.php");
		</script>';
?>
