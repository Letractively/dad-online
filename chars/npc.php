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
	$charname = $_SESSION['charname'];
	$map = $_SESSION['map'];

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

	// Verify Valid NPC / Get Map & NPC Info

	$query = "SELECT npcs.name,maps.name FROM mapnpcs,npcs,maps
		WHERE map = $map AND npc = $id AND npc = npcs.id AND map = maps.id";
	$result = mysql_query($query) or die(mysql_error());

	if (!mysql_num_rows($result)) {
		echo '<script language="javascript">
			alert("This NPC isn\'t here!!!");
			window.location = ("map.php");
		</script>';
		exit;
	}

	$row = mysql_fetch_array($result);
	$npc = $row[0];
	$mapname = $row[1];

	// Get NPC Available Quests

	$query = "SELECT quests.id,name FROM npcquests,quests
		WHERE npc = $id
		AND quest = quests.id
		AND quest not in (SELECT quest FROM charquests
				WHERE charid = $charid)
		AND quest not in (SELECT quest FROM completequests
				WHERE charid = $charid)";
	$questr = mysql_query($query) or die(mysql_error());

	// Get Quests in Progress from NPC

	$query = "SELECT quests.id,name FROM npcquests,quests
		WHERE npc = $id
		AND quest = quests.id
		AND quest in (SELECT quest FROM charquests
				WHERE charid = $charid)";
	$qipr = mysql_query($query) or die(mysql_error());

	// Load HTML5 Template

	$title = '<li><a href="index.php">'.$charname.'</a></li>
		<li><a href="map.php">'.$mapname.'</a></li>
		<li><a href="npc.php?id='.$id.'">'.$npc.'</a></li>
		<li><a href="../users/logout.php">Logout</a></li>';
	$depth = "../aat/"; include_once '../aat/header.php';

	// Show NPC Picture

	echo '<p><img name="pic" src="images/npcs/'.$npc.'.gif" border="0"></p>';

	// Show NPC Available Quests

	if (mysql_num_rows($questr) || mysql_num_rows($qipr)) echo '<p>Quests:</p>';

	while ($row = mysql_fetch_array($questr)) echo '<p><a href="quest.php?id='.$row[0].'">'.$row[1].'</a></p>';

	// Show Quests in Progress from NPC

	while ($row = mysql_fetch_array($qipr)) echo '<p><a href="quest.php?id='.$row[0].'">'.$row[1].'</a> (In Progress)</p>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
