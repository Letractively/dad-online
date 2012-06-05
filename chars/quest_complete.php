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

	// Verify Valid Quest / Get Map, NPC & Quest Info

	$query = "SELECT maps.name,npcs.id,npcs.name,quests.name,characters.name
		FROM maps,mapnpcs,npcs,npcquests,quests,characters
		WHERE characters.id = $charid
		AND maps.id = characters.map
		AND maps.id = mapnpcs.map
		AND mapnpcs.npc = npcs.id
		AND npcs.id = npcquests.npc
		AND quest = quests.id
		AND quests.id = $id";
	$result = mysql_query($query) or die(mysql_error());

	if (!mysql_num_rows($result)) {
		echo '<script language="javascript">
			alert("You can\'t do this quest!!!");
			window.location = ("map.php");
		</script>';
		exit;
	}

	$row = mysql_fetch_array($result);
	$map = $row[0];
	$npcid = $row[1];
	$npc = $row[2];
	$quest = $row[3];
	$charname = $row[4];

	// Load HTML5 Template

	$title = '<li><a href="index.php">'.$charname.'</a></li>
		<li><a href="map.php">'.$map.'</a></li>
		<li><a href="npc.php?id='.$npcid.'">'.$npc.'</a></li>
		<li><a>'.$quest.'</a></li>
		<li><a href="../users/logout.php">Logout</a></li>';
	$depth = "../aat/"; include_once '../aat/header.php';

	echo "Not yet implemented!";

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
