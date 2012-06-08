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

	// Login & Character Validation

	if (!char_selected()) {
		header('Location: ../users/');
		exit;
	}

	// Get Session Variables

	$charid = $_SESSION['charid'];

	// Get StartMap

	$query = "SELECT startmap FROM races WHERE id = (SELECT map FROM characters WHERE id = $charid)";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_row($result);
	$map = $row[0];

	// Resurrection

	$query = "UPDATE characters SET hp = 100, map = $map WHERE id = $charid AND hp = 0";
	$result = mysql_query($query) or die(mysql_error());

	echo '<script language="javascript">
			alert("You\'ve been resurrected!");
			window.location = ("index.php");
		</script>';
?>
