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

	// Get Character Info
		
	$query = "SELECT c.name,r.name,m.id,m.name
		FROM characters AS c,races AS r,maps AS m
		WHERE c.id = '$charid'
			AND c.race = r.id
			AND c.map = m.id";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($result);

	// Get Routes

	$query = "SELECT name FROM routes,maps WHERE start = $row[2] AND end = maps.id";
	$result = mysql_query($query) or die(mysql_error());

	// Get Spells

	$spellq = "SELECT name FROM charspells,spells 
		WHERE charid = $charid AND spell = spells.id";
	$spellr = mysql_query($spellq) or die(mysql_error());

	// Get Mobs

	$mobq = "SELECT name FROM mapmobs,mobs 
		WHERE map = $row[2] AND mob = mobs.id";
	$mobr = mysql_query($mobq) or die(mysql_error());

	// Get NPCs

	$npcq = "SELECT npcs.id,name FROM mapnpcs,npcs 
		WHERE map = $row[2] AND npc = npcs.id";
	$npcr = mysql_query($npcq) or die(mysql_error());

	// Load HTML5 Template

	$depth = "../aat/"; include_once '../aat/header.php';

	// Show Character Info

	echo '<p>'.$row[0].'</p>
		<p><img name="pic" src="images/'.$row[1].'.gif" border="0"></p>
		<p>@ '.$row[3].'</p>';

	// Show Character Spells

	echo '<p>Spells:</p>';
	while ($row = mysql_fetch_array($spellr)) echo '<p>'.$row[0].'</p>';

	// Show NPCs

	echo '<p>NPCs:</p>';
	while ($row = mysql_fetch_array($npcr)) {
		echo '<p>'.$row[1]. '</p>';

		// Show NPC Quests

		$questq = "SELECT name FROM npcquests,quests
			WHERE npc = $row[0] AND quest=quests.id";
		$questr = mysql_query($questq) or die(mysql_error());

		while ($row = mysql_fetch_array($questr)) echo '- '.$row[0];
	}

	// Show Routes

	echo '<p>Routes:</p>';
	while ($row = mysql_fetch_array($result)) echo '<p>'.$row[0].'</p>';

	// Show Mobs

	echo '<p>Mobs:</p>';
	while ($row = mysql_fetch_array($mobr)) echo '<p>'.$row[0].'</p>';

	// Character Selection Button

	echo '<p><input type="submit" value="change character" name="extral" class="extral"
		onClick="location.href=\'../users/\'" /></p>';

	// Logout Button

	echo '<p><input type="submit" value="logout" name="extra" class="extra"
		onClick="location.href=\'../users/logout.php\'" /></p>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
