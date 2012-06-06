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

	// Verify Quest in Progress

	$query = "SELECT * FROM charquests
		WHERE charid = $charid AND quest = $id";
	$result = mysql_query($query) or die(mysql_error());

	if (!mysql_num_rows($result)) {
		header('Location: ../oops.php');
		exit;
	}

	// Verify QuestItems and QuestCharMobs

	$query = "SELECT * FROM questitems,charitems
		WHERE quest = $id AND questitems.item = charitems.item AND charid = $charid
		AND questitems.amount > charitems.amount";
	$result = mysql_query($query) or die(mysql_error());

	$query = "SELECT * FROM questmobs,charquestmobs
		WHERE quest = $id AND questmobs.id = charquestmobs.questmob AND charid = $charid
		AND questmobs.amount > charquestmobs.amount";
	$result2 = mysql_query($query) or die(mysql_error());

	if (mysql_num_rows($result) || mysql_num_rows($result2)) {
		header('Location: ../oops.php');
		exit;
	}

	// Deliver Rewards and Delete Quest in Progress
?>
