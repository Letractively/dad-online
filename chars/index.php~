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
	$race = $_SESSION['race'];
	$map = $_SESSION['map'];
	$hp = $_SESSION['hp'];

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

	// Get Map Name
		
	$query = "SELECT name FROM maps WHERE id = $map";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$mapname = $row[0];

	// Get Race Name
		
	$query = "SELECT name FROM races WHERE id = $race";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$racename = $row[0];

	// Get Spells

	$query = "SELECT name FROM charspells,spells 
		WHERE charid = $charid AND spell = spells.id";
	$spellr = mysql_query($query) or die(mysql_error());

	// Get Items

	$query = "SELECT name,amount FROM charitems,items 
		WHERE charid = $charid AND item = items.id";
	$itemr = mysql_query($query) or die(mysql_error());
	$numitems = mysql_num_rows($itemr);

	// Load HTML5 Template

	$title = '<li><a href="index.php">'.$charname.'</a></li>
		<li><a href="map.php">'.$mapname.'</a></li>
		<li><a href="../users/">Change Character</a></li>
		<li><a href="../users/logout.php">Logout</a></li>';
	$depth = "../aat/"; include_once '../aat/header.php';

	// Show Character Picture

	echo '<p><img name="pic" src="images/'.$racename.'.gif" border="0"></p>';

	// Show Character HP

	echo 'HP: '.$hp.'/100';

	// Show Character Spells

	echo '<p>Spells:</p>';
	while ($row = mysql_fetch_array($spellr)) echo '<p>- '.$row[0].'</p>';

	// Character Items

	if ($numitems) {
		echo '<p>Items:</p>';
		while ($row = mysql_fetch_array($itemr)) echo '<p>- '.$row[0].' x'.$row[1].'</p>';
	}

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
