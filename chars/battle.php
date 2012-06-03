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
	$hp = $_SESSION['hp'];

	// No Battle Redirect

	$bc = battle_check($charid);
	if ($bc != "mob") {
		header('Location: index.php');
		exit;
	}

	// Get Info

	$query = "SELECT battles.hp,mobs.name,mobtypes.name,races.name
		FROM battles,mobs,mobtypes,characters,races
		WHERE charid = $charid
		AND mob = mobs.id
		AND mobs.type = mobtypes.id
		AND characters.id = charid
		AND characters.race = races.id";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_row($result);
	$mobhp = $row[0];
	$mob = $row[1];
	$mobtype = $row[2];
	$racename = $row[3];

	// Get Spells

	$query = "SELECT spell,name FROM charspells,spells
		WHERE charid = $charid
		AND spell = spells.id";
	$result = mysql_query($query) or die(mysql_error());

	$leftstyle = "<style>";
	$leftul = "<ul id=\"navigation\">";
	while ($row = mysql_fetch_row($result)) {
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
				<td><img name="pic" src="images/mobs/'.$mobtype.'.gif" border="0"></td>
			</tr>
			<tr>
				<td>'.$hp.'</td><td> </td><td>'.$mobhp.'</td>
			</tr>
		</table>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
