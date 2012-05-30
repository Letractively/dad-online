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

	// Character Validation

	if (!char_selected()) {
		header('Location: ../users/');
		exit;
	}

	// Get Session Variables

	$charid = $_SESSION['charid'];

	// Get GET Variables

	if (!isset($_GET['id'])) {
		header('Location: ../users/logout.php');
		exit;
	}
	$id = mysql_real_escape_string($_GET['id']);

	// Verify Valid Quest

	$query = "SELECT npcs.id,npcs.name,quests.name
		FROM mapnpcs,npcs,npcquests,quests
		WHERE map = (SELECT map FROM characters WHERE id = $charid)
		AND mapnpcs.npc = npcs.id
		AND mapnpcs.npc = npcquests.npc
		AND quest = $id
		AND quest = quests.id";
	$result = mysql_query($query) or die(mysql_error());

	if (!mysql_num_rows($result)) {
		echo '<script language="javascript">
			alert("You can\'t do this quest!!!");
			window.location = ("map.php");
		</script>';
		exit;
	}

	// Verify Already Completed Quest

	$query = "SELECT * FROM completequests
		WHERE charid = $charid AND quest = $id";
	$result = mysql_query($query) or die(mysql_error());

	if (mysql_num_rows($result)) {
		echo '<script language="javascript">
			alert("You already did this quest!!!");
			window.location = ("map.php");
		</script>';
		exit;
	}

	// Verify Quest in Progress

	$query = "SELECT * FROM charquests
		WHERE charid = $charid AND quest = $id";
	$result = mysql_query($query) or die(mysql_error());

	if (mysql_num_rows($result)) {
		echo '<script language="javascript">
			alert("You are already on this quest!!!");
			window.location = ("map.php");
		</script>';
		exit;
	}

	$query = "INSERT INTO charquests (charid,quest) VALUES ($charid,$id)";
	$result = mysql_query($query) or die(mysql_error());

	header('Location: quest.php?id='.$id);
?>
