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

	// Verify Valid NPC

	$query = "SELECT npcs.name,maps.name FROM mapnpcs,npcs,maps
		WHERE map = (SELECT map FROM characters WHERE id = $charid)
		AND npc = $id
		AND npc = npcs.id
		AND map = maps.id";
	$result = mysql_query($query) or die(mysql_error());

	if (!mysql_num_rows($result)) {
		echo '<script language="javascript">
			alert("This NPC isn\'t here!!!");
			window.location = ("map.php");
		</script>';
		exit;
	}

	$row = mysql_fetch_array($result);

	// Get NPC Quests

	$questq = "SELECT quests.id,name FROM npcquests,quests
		WHERE npc = $id
		AND quest = quests.id";
	$questr = mysql_query($questq) or die(mysql_error());

	// Load HTML5 Template

	$title = '<li><a href="npc.php?id='.$id.'">'.$row[0].'</a></li>
		<li><a href="map.php?id='.$id.'">'.$row[1].'</a></li>
		<li><a href="../users/logout.php">Logout</a></li>';
	$depth = "../aat/"; include_once '../aat/header.php';

	// Show NPC Picture

	echo '<p><img name="pic" src="images/npcs/'.$row[0].'.gif" border="0"></p>';

	// Show NPC Quests

	echo '<p>Quests:</p>';
	while ($row = mysql_fetch_array($questr)) 
		echo '<p><a href="quest.php?id='.$row[0].'">'.$row[1].'</a></p>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
