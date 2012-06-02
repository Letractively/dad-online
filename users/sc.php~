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

	// Get GET Variables

	if (!isset($_GET['id'])) {
		header('Location: logout.php');
		exit;
	}

	$id = mysql_real_escape_string($_GET['id']);

	// Get session variables

	$userid = $_SESSION['id'];

	// Verify User owns Character

	$query = "SELECT name,race,map,hp FROM characters WHERE id=$id AND user=$userid";
	$result = mysql_query($query) or die(mysql_error());

	if (!mysql_num_rows($result)) {
		header('Location: logout.php');
		exit;
	}

	$row = mysql_fetch_array($result);

	// Get Race Name

	$query = "SELECT name FROM races WHERE id=$row[1]";
	$result = mysql_query($query) or die(mysql_error());
	$race = mysql_fetch_array($result);

	// Save session and redirect

	$_SESSION['charid'] = htmlspecialchars($id);
	$_SESSION['charname'] = htmlspecialchars($row[0]);
	$_SESSION['race'] = htmlspecialchars($row[1]);
	$_SESSION['map'] = htmlspecialchars($row[2]);
	$_SESSION['hp'] = htmlspecialchars($row[3]);
	$_SESSION['racename'] = htmlspecialchars($race[0]);
	header('Location: ../chars/');
?>
