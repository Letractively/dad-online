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

	// Verify Valid NPC / Get Info

	$query = "SELECT mo.name,ma.name,c.name FROM spawns AS s,mobs AS mo,maps AS ma,characters AS c
		WHERE mo.id = $id AND s.mob = mo.id AND s.map = ma.id AND ma.id = c.map AND c.id = $charid
		AND npc = true";
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
	$map = $row[1];
	$charname = $row[2];

	// Get NPC Available Quests

	$query = "SELECT id,name FROM quests
		WHERE npc = $id
		AND id not in (SELECT quest FROM charquests
				WHERE charid = $charid)";
	$questr = mysql_query($query) or die(mysql_error());

	// Get Quests in Progress from NPC

	$query = "SELECT id,name FROM quests
		WHERE npc = $id
		AND id in (SELECT quest FROM charquests
				WHERE charid = $charid AND complete = false)";
	$qipr = mysql_query($query) or die(mysql_error());

	// Load HTML5 Template

	$title = '<li><a href="index.php">'.$charname.'</a></li>
		<li><a href="map.php">'.$map.'</a></li>
		<li><a>'.$npc.'</a></li>
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
