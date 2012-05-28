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

	// Get Character Info
		
	$query = "SELECT c.name,r.name,m.name,s.name
		FROM characters AS c,races AS r,maps AS m,charspells AS cs,spells AS s
		WHERE c.id = '$charid'
			AND c.race = r.id
			AND c.map = m.id
			AND cs.charid = '$charid'
			AND s.id = cs.spell";
	$result = mysql_query($query) or die(mysql_error());

	$row = mysql_fetch_array($result);

	// Load HTML5 Template

	$depth = "../aat/"; include_once '../aat/header.php';

	// Show Character Info

	echo '<p>'.$row[0].'</p>';
	echo '<p><img name="pic" src="images/'.$row[1].'.gif" border="0"></p>';
	echo '<p>'.$row[2].'</p>';
	echo '<p>'.$row[3].'</p>';

	// Character Selection Button

	echo '<p><input type="submit" value="change character" name="extral" class="extral"
		onClick="location.href=\'../users/\'" /></p>';

	// Logout Button

	echo '<p><input type="submit" value="logout" name="extra" class="extra"
		onClick="location.href=\'../users/logout.php\'" /></p>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>