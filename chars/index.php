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

	$query = "SELECT c.name,hp,m.name,r.name,c.str,c.int,c.agi,c.stats
		FROM characters AS c,maps AS m,races AS r
		WHERE c.id = $charid AND c.map = m.id AND race = r.id";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$charname = $row[0];
	$hp = $row[1];
	$map = $row[2];
	$race = $row[3];
	$str = $row[4];
	$int = $row[5];
	$agi = $row[6];
	$stats = $row[7];

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

	$title = '<li><a>'.$charname.'</a></li>
		<li><a href="map.php">'.$map.'</a></li>
		<li><a href="../users/">Change Character</a></li>
		<li><a href="../users/logout.php">Logout</a></li>';
	$depth = "../aat/"; include_once '../aat/header.php';

	// Show Character Picture

	echo '<p><img name="pic" src="images/'.$race.'.gif" border="0"></p>';

	// Show Character Info

	echo '<p>HP: '.$hp.'/100 <br> STR: '.$str.' <br> INT: '.$int.' <br> AGI: '.$agi.'</p>';

	// Check for Free Stat Points

	if ($stats) echo "You got remaining stats!";

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
