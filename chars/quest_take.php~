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

	if (battle_check($charid)) {
		header('Location: battle.php');
		exit;
	}

	// Get GET Variables

	if (!isset($_GET['id'])) {
		header('Location: ../users/logout.php');
		exit;
	}
	$id = mysql_real_escape_string($_GET['id']);

	// Verify Valid Quest

	$query = "SELECT * FROM spawns,quests
		WHERE map = (SELECT map FROM characters WHERE id = $charid)
		AND spawns.mob = quests.npc
		AND quests.id = $id";
	$result = mysql_query($query) or die(mysql_error());

	if (!mysql_num_rows($result)) {
		echo '<script language="javascript">
			alert("You can\'t do this quest!!!");
			window.location = ("map.php");
		</script>';
		exit;
	}

	// Verify Already Completed/In Progress Quest

	$query = "SELECT * FROM charquests WHERE charid = $charid AND quest = $id";
	$result = mysql_query($query) or die(mysql_error());

	if (mysql_num_rows($result)) {
		header('Location: ../oops.php');
		exit;
	}

	$query = "INSERT INTO charquests (charid,quest) VALUES ($charid,$id)";
	$result = mysql_query($query) or die(mysql_error());

	header('Location: quest.php?id='.$id);
?>
