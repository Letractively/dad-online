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

	// Get Info
		
	$query = "SELECT c.name,m.id,m.name,count(cq.id)
		FROM characters AS c,maps AS m, charquests AS cq
		WHERE c.id = $charid AND map = m.id AND charid = c.id AND complete = true";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$charname = $row[0];
	$map = $row[1];
	$mapname = $row[2];
	$quests = $row[3];

	// Get Routes

	$query = "SELECT end,name,quests FROM routes,maps WHERE start = $map AND end = maps.id";
	$router = mysql_query($query) or die(mysql_error());

	// Get Mobs

	$query = "SELECT * FROM spawns,mobs WHERE map = $map AND mob = mobs.id AND npc = false";
	$mobr = mysql_query($query) or die(mysql_error());
	$nummobs = mysql_num_rows($mobr);

	// Get NPCs

	$query = "SELECT mobs.id,name FROM spawns,mobs WHERE map = $map AND mob = mobs.id AND npc = true";
	$npcr = mysql_query($query) or die(mysql_error());
	$numnpcs = mysql_num_rows($npcr);

	// Load HTML5 Template

	$title = '<li><a href="index.php">'.$charname.'</a></li>
		<li><a>'.$mapname.'</a></li>
		<li><a href="../users/">Change Character</a></li>
		<li><a href="../users/logout.php">Logout</a></li>';
	$depth = "../aat/"; include_once '../aat/header.php';

	// Show NPCs

	if ($numnpcs) {
		echo '<p>NPCs:</p>';
		while ($row = mysql_fetch_array($npcr))
			echo '<p><a href="npc.php?id='.$row[0].'">- '.$row[1].'</a></p>';
	}

	// Show Routes

	echo '<p>Routes:</p>';
	while ($row = mysql_fetch_array($router)) {
		if ($quests < $row[2]) echo '- '.$row[1].' ('.$quests.'/'.$row[2].')';
		else echo '<p><a href="cm.php?id='.$row[0].'">- '.$row[1].'</a></p>';
	}

	// Show Mobs

	if ($nummobs) echo '<p><a href="pick_enemy.php">Search for monsters!</a></p>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
