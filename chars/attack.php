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

	// No Battle Redirect

	if (!battle_check($charid)) {
		header('Location: index.php');
		exit;
	}

	// Get GET Variables

	if (!isset($_GET['id'])) {
		header('Location: ../users/logout.php');
		exit;
	}
	$id = mysql_real_escape_string($_GET['id']);

	// Get & Validate Info

	$query = "SELECT c.name,c.hp,c.str,c.`int`,c.agi,s.str,s.`int`,s.agi,
		m.id,m.name,b.hp,m.str,m.`int`,m.agi
		FROM characters AS c, charspells, spells AS s, battles AS b, mobs AS m
		WHERE c.id = $charid AND charspells.charid = c.id
		AND spell = s.id AND s.id = $id AND b.charid = c.id
		AND mob = m.id";
	$result = mysql_query($query) or die(mysql_error());

	if (!mysql_num_rows($result)) {
		header('Location: ../users/logout.php');
		exit;
	}

	$row = mysql_fetch_row($result);

	// Check Attack Order

	if ($row[4] >= $row[13]) {

		// Player Attacks First

		$report = $row[0].' attacks first!\n';
		$fr = attack_result($charid,$row[0],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[9],
			$row[10],$row[11],$row[12],$row[13]);
		if (!mob_dead($charid)) $sr = defense_result($charid,$row[0],$row[1],$row[2],$row[3],$row[4],
			$row[8],$row[9],$row[11],$row[12],$row[13]);
		else $sr = $row[9]. " is dead!";
	} else {

		// Mob Attacks First

		$report = $row[9].' attacks first!\n';
		$fr = defense_result($charid,$row[0],$row[1],$row[2],$row[3],$row[4],$row[8],$row[9],$row[11],
			$row[12],$row[13]);
		if (!char_dead($charid)) $sr = attack_result($charid,$row[0],$row[2],$row[3],$row[4],$row[5],
			$row[6],$row[7],$row[9],$row[10],$row[11],$row[12],$row[13]);
		else $sr = "You can't take any more...";
	}

	// Inform User

	echo '<script language="javascript">
			alert("'.$report.''.$fr.''.$sr.'");
			window.location = ("battle.php");
		</script>';
?>
