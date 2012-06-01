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

	// Get session variables

	$userid = $_SESSION['id'];

	// Get form variables

	$name = mysql_real_escape_string($_POST['name']);
	$race = mysql_real_escape_string($_POST['race']);

	// Character amount verification info
		
	$query = "SELECT * FROM characters WHERE user = '$userid'";
	$result = mysql_query($query) or die(mysql_error());

	if(mysql_num_rows($result) >= $maxchars) {
		echo '<script language="javascript">
				alert("You can\'t create any more characters!");
				window.location = ("index.php");
			</script>';
		exit;
	}

	// Character Name Verification

	$query = "SELECT name FROM characters WHERE name = '$name'";
	$result = mysql_query($query) or die(mysql_error());

	if(mysql_num_rows($result)) {
		echo '<script language="javascript">alert("Character name is already being used!");</script>';
		include 'cc.php';
		exit;
	}

	// Character Creation

	$query = "INSERT INTO characters (`name`,`user`,`race`,`map`,`alignment`,`str`,`int`,`agi`) 
		VALUES('$name','$userid','$race',
			(SELECT startmap FROM races WHERE id = '$race'),
			(SELECT startalignment FROM races WHERE id = '$race'),
			(SELECT startstr FROM races WHERE id = '$race'),
			(SELECT startint FROM races WHERE id = '$race'),
			(SELECT startagi FROM races WHERE id = '$race'))";
	$result = mysql_query($query) or die(mysql_error());

	header('Location: index.php');
?>
