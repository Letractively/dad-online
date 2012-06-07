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

	// Battle Redirect

	$bc = battle_check($charid);
	if ($bc == "mob") {
		header('Location: battle.php');
		exit;
	}
	if ($bc == "npc") {
		header('Location: battlenpc.php');
		exit;
	}

	// Get GET Variables

	if (!isset($_GET['id'])) {
		header('Location: ../users/logout.php');
		exit;
	}
	$id = mysql_real_escape_string($_GET['id']);

	// Verify Valid Route

	$query = "SELECT * FROM routes 
		WHERE start = (SELECT map FROM characters WHERE id = $charid)
		AND end = $id";
	$result = mysql_query($query) or die(mysql_error());

	if (!mysql_num_rows($result)) {
		echo '<script language="javascript">
				alert("You can\'t go here!!!");
				window.location = ("map.php");
			</script>';
		exit;
	}

	// Verify Requirements

	$query = "SELECT * FROM routerequirements WHERE quest not in
		(SELECT quest FROM completequests WHERE charid = $charid)";
	$result = mysql_query($query) or die(mysql_error());

	if (mysql_num_rows($result)) {
		echo '<script language="javascript">
				alert("You don\'t meet the requirements!!!");
				window.location = ("map.php");
			</script>';
		exit;
	}

	// Change Map and Redirect

	$query = "UPDATE characters SET map = $id WHERE id = $charid";
	$result = mysql_query($query) or die(mysql_error());
	$_SESSION['map'] = $id;

	header('Location: map.php');
?>
