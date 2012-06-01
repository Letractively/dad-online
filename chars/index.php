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

	// Battle Redirect

	$query = "SELECT * FROM battles WHERE charid = $charid";
	$result = mysql_query($query) or die(mysql_error());

	if (mysql_num_rows($result)) {
		header('Location: battle.php');
	}

	// Get Character Info
		
	$query = "SELECT c.name,r.name,m.name,hp
		FROM characters AS c,races AS r,maps AS m
		WHERE c.id = '$charid'
			AND c.race = r.id
			AND c.map = m.id";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($result);

	// Get Spells

	$spellq = "SELECT name FROM charspells,spells 
		WHERE charid = $charid AND spell = spells.id";
	$spellr = mysql_query($spellq) or die(mysql_error());

	// Get Items

	$itemq = "SELECT name,amount FROM charitems,items 
		WHERE charid = $charid AND item = items.id";
	$itemr = mysql_query($itemq) or die(mysql_error());

	// Load HTML5 Template

	$title = '<li><a href="index.php">'.$row[0].'</a></li>
		<li><a href="map.php">'.$row[2].'</a></li>
		<li><a href="../users/">Change Character</a></li>
		<li><a href="../users/logout.php">Logout</a></li>';
	$depth = "../aat/"; include_once '../aat/header.php';

	// Show Character Picture

	echo '<p><img name="pic" src="images/'.$row[1].'.gif" border="0"></p>';

	// Show Character HP

	echo 'HP: '.$row[3].'/100';

	// Show Character Spells

	echo '<p>Spells:</p>';
	while ($row = mysql_fetch_array($spellr)) echo '<p>- '.$row[0].'</p>';

	// Character Items

	echo '<p>Items:</p>';
	while ($row = mysql_fetch_array($itemr)) echo '<p>- '.$row[0].' x'.$row[1].'</p>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
