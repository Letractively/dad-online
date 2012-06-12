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

	// Verify Already Completed Quest

	$query = "SELECT * FROM charquests WHERE charid = $charid AND quest = $id AND complete = true";
	$result = mysql_query($query) or die(mysql_error());

	if (mysql_num_rows($result)) {
		echo '<script language="javascript">
			alert("You already did this quest!!!");
			window.location = ("map.php");
		</script>';
		exit;
	}

	// Verify Valid Quest / Get Map, NPC & Quest Info

	$query = "SELECT maps.name,mobs.id,mobs.name,quests.name,characters.name
		FROM maps,spawns,mobs,quests,characters
		WHERE characters.id = $charid
		AND maps.id = characters.map
		AND maps.id = spawns.map
		AND spawns.mob = mobs.id
		AND mobs.id = quests.npc
		AND mobs.npc = true
		AND quests.id = $id";
	$result = mysql_query($query) or die(mysql_error());

	if (!mysql_num_rows($result)) {
		echo '<script language="javascript">
			alert("You can\'t do this quest!!!");
			window.location = ("map.php");
		</script>';
		exit;
	}

	$row = mysql_fetch_array($result);
	$map = $row[0];
	$npcid = $row[1];
	$npc = $row[2];
	$quest = $row[3];
	$charname = $row[4];

	// Verify Quest in Progress

	$query = "SELECT * FROM charquests WHERE charid = $charid AND quest = $id AND complete = false";
	$qipr = mysql_query($query) or die(mysql_error());

	// Get Quest Requirements

	$query = "SELECT name,amount,items.id FROM questitems,items
		WHERE quest = $id AND item = items.id";
	$qir = mysql_query($query) or die(mysql_error());

	$query = "SELECT name,amount,mobs.id FROM questmobs,mobs
		WHERE quest = $id AND mob = mobs.id";
	$qmr = mysql_query($query) or die(mysql_error());

	// Load HTML5 Template

	$title = '<li><a href="index.php">'.$charname.'</a></li>
		<li><a href="map.php">'.$map.'</a></li>
		<li><a href="npc.php?id='.$npcid.'">'.$npc.'</a></li>
		<li><a>'.$quest.'</a></li>
		<li><a href="../users/logout.php">Logout</a></li>';
	$depth = "../aat/"; include_once '../aat/header.php';

	// Completable Quest Verifier

	$cqv = 0;

	// Show Quest Requirements / Progress

	if (mysql_num_rows($qipr)) echo '<p>In Progress</p><br>';
	else echo '<p>Requirements</p><br>';

	if (mysql_num_rows($qir)) {
		echo '<p>Items:</p>';
		while ($row = mysql_fetch_array($qir)) {
			if (mysql_num_rows($qipr)) {
				$query = "SELECT amount FROM charitems
					WHERE charid = $charid AND item = $row[2]";
				$result = mysql_query($query) or die(mysql_error());
				if (mysql_num_rows($result)) {
					$item = mysql_fetch_array($result);
					if ($item[0] < $row[1]) $cqv++;
					echo '<p>- '.$row[0].' '.$item[0].'/'.$row[1].'</p>';
				} else {
					$cqv++;
					echo '<p>- '.$row[0].' 0/'.$row[1].'</p>';
				}
			} else echo '<p>- '.$row[0].' x'.$row[1].'</p>';
		}
	}

	if (mysql_num_rows($qmr)) {
		echo '<p>Mobs:</p>';
		while ($row = mysql_fetch_array($qmr)) {
			if (mysql_num_rows($qipr)) {
				$query = "SELECT amount FROM charquestmobs
					WHERE charid = $charid
					AND questmob = (SELECT id FROM questmobs
						WHERE quest = $id AND mob = $row[2])";
				$result = mysql_query($query) or die(mysql_error());
				$mob = mysql_fetch_array($result);
				if ($mob[0] < $row[1]) $cqv++;
				echo '<p>- '.$row[0].' '.$mob[0].'/'.$row[1].'</p>';
			} else echo '<p>- '.$row[0].' x'.$row[1].'</p>';
		}
	}

	// Show Accept Quest if not in Progress

	if (!mysql_num_rows($qipr)) {
		echo '<p><input type="submit" value="accept quest" name="extral" class="extral"
		onClick="location.href=\'quest_take.php?id='.$id.'\'" /></p>';
	} else {

		// Show Complete Quest if Requirements Fulfilled

		if (!$cqv) {
			echo '<p><input type="submit" value="complete quest" name="extral" class="extral"
			onClick="location.href=\'quest_complete.php?id='.$id.'\'" /></p>';
		}
	}

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
