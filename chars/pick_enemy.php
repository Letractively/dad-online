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

	// Get Mobs

	$query = "SELECT mob,rate FROM spawns WHERE map = (SELECT map FROM characters WHERE id = $charid)";
	$result = mysql_query($query) or die(mysql_error());
	$nummobs = mysql_num_rows($result);

	if (!$nummobs) {
		echo '<script language="javascript">
				alert("There are no mobs here!!!");
				window.location = ("map.php");
			</script>';
		exit;
	}

	$i = 0;
	while ($row = mysql_fetch_row($result)) {
		$mobid[$i] = $row[0];
		$mobrate[$i] = $row[1];
		$i++;
	}

	$chosen = pick_enemy($mobid,$mobrate);
	$query = "INSERT INTO battles SET charid=$charid, mob=$chosen";
	$result = mysql_query($query) or die(mysql_error());

	header('Location: battle.php');
?>
