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
	$map = $_SESSION['map'];
	$charname = $_SESSION['charname'];

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

	// Get Mobs

	$query = "SELECT name,rate FROM mapmobs,mobs 
		WHERE map = $map AND mob = mobs.id";
	$mobr = mysql_query($query) or die(mysql_error());
	$nummobs = mysql_num_rows($mobr);

	// Load HTML5 Template

	$title = '<li><a href="index.php">'.$charname.'</a></li>
		<li><a href="map.php">'.$mapname.'</a></li>
		<li><a href="../users/">Change Character</a></li>
		<li><a href="../users/logout.php">Logout</a></li>';
	$depth = "../aat/"; include_once '../aat/header.php';

	// Show Mobs

	echo '<p>Mobs:</p>';
	while ($row = mysql_fetch_array($mobr)) echo $row[0].' with rate '.$row[1];

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
