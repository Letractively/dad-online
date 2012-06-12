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

	// Win Check

	if (mob_dead($charid)) header('Location: loot.php');

	// Lose Check

	if (char_dead($charid)) header('Location: lose.php');

	// Get Info

	$query = "SELECT b.hp,m.name,r.name,c.name,c.hp
		FROM battles AS b,mobs AS m,characters AS c,races AS r
		WHERE charid = $charid
		AND mob = m.id
		AND c.id = charid
		AND c.race = r.id";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_row($result);
	$mobhp = $row[0];
	$mob = $row[1];
	$racename = $row[2];
	$charname = $row[3];
	$hp = $row[4];

	// Get Spells

	$query = "SELECT spell,name FROM charspells,spells
		WHERE charid = $charid
		AND spell = spells.id";
	$result = mysql_query($query) or die(mysql_error());

	$leftstyle = "<style>";
	$leftul = "<ul id=\"navigation\">";
	while ($row = mysql_fetch_row($result)) {

		// Fill Lateral Spell List

		$leftstyle .= 'ul#navigation .'.$row[1].' a {
				background-image: url(../chars/images/spells/'.$row[1].'.png);
			}';
		$leftul .= '<li class="'.$row[1].'"><a href="attack.php?id='.$row[0].'" 
			title="'.$row[1].'"></a></li>';
	}
	$leftstyle .= "</style>";
	$leftul .= "</ul>";

	// Load HTML5 Template

	$title = '<li><a>'.$charname.' vs '.$mob.'</a></li>
		<li><a href="../users/logout.php">Logout</a></li>';
	$depth = "../aat/"; include_once '../aat/header.php';

	// Display

	echo '<table>
			<tr>
				<td><img name="pic" src="images/'.$racename.'.gif" border="0"></td>
				<td> VS </td>
				<td><img name="pic" src="images/mobs/'.$mob.'.gif" border="0"></td>
			</tr>
			<tr>
				<td>'.$hp.'</td><td> </td><td>'.$mobhp.'</td>
			</tr>
		</table>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
