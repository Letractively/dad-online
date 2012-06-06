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

	// Verify Quest in Progress

	$query = "SELECT * FROM charquests
		WHERE charid = $charid AND quest = $id";
	$result = mysql_query($query) or die(mysql_error());

	if (!mysql_num_rows($result)) {
		header('Location: ../oops.php');
		exit;
	}

	// Verify QuestItems and QuestCharMobs

	$query = "SELECT * FROM questitems,charitems
		WHERE quest = $id AND questitems.item = charitems.item AND charid = $charid
		AND questitems.amount > charitems.amount";
	$result = mysql_query($query) or die(mysql_error());

	$query = "SELECT * FROM questmobs,charquestmobs
		WHERE quest = $id AND questmobs.id = charquestmobs.questmob AND charid = $charid
		AND questmobs.amount > charquestmobs.amount";
	$result2 = mysql_query($query) or die(mysql_error());

	if (mysql_num_rows($result) || mysql_num_rows($result2)) {
		header('Location: ../oops.php');
		exit;
	}

	// Take Away Required Items

	$query = "SELECT item,amount FROM questitems WHERE quest = $id";
	$result = mysql_query($query) or die(mysql_error());

	while ($row = mysql_fetch_array($result)) {
		$q = "UPDATE charitems SET amount = amount - $row[1] WHERE charid = $charid AND item = $row[0]";
		$r = mysql_query($q) or die(mysql_error());
	}

	// Insert Quest Complete and Deliver Rewards

	$query = "INSERT INTO completequests(charid,quest) VALUES($charid,$id)";
	$result = mysql_query($query) or die(mysql_error());

	$reward = "";

	$query = "SELECT item,amount,name FROM rewards,items
		WHERE quest = $id AND item = items.id
		AND item in (SELECT item FROM charitems WHERE charid =$charid)";
	$result = mysql_query($query) or die(mysql_error());

	while ($row = mysql_fetch_row($result)) {
		$reward .= "You received $row[1] $row[2]! ";
		$q = "UPDATE charitems SET amount = amount + $row[1] WHERE charid = $charid AND item = $row[0]";
		$r = mysql_query($q) or die(mysql_error());
	}

	$query = "SELECT item,amount,name FROM rewards,items
		WHERE quest = $id AND item = items.id
		AND item not in (SELECT item FROM charitems WHERE charid =$charid)";
	$result = mysql_query($query) or die(mysql_error());

	while ($row = mysql_fetch_row($result)) {
		$reward .= "You received $row[1] $row[2]! ";
		$q = "INSERT INTO charitems SET charid = $charid, item = $row[0], amount = $row[1]";
		$r = mysql_query($q) or die(mysql_error());
	}

	echo '<script language="javascript">
			alert("'.$reward.'");
			window.location = ("index.php");
		</script>';
?>
