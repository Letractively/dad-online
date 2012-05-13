<?php
/*
DAD Online. Web browser MMORPG.
Copyright(C) 2012 Aceapps Aplicaciones. 
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses
*/

	// Load files

	require_once '../include/config.php';
	require_once '../include/functions.php';

	// Login Validation

	session_validate();

    // Load HTML5 Template

    $depth = "../aat/"; include_once '../aat/header.php';

	// Get session variables

	$userid = $_SESSION['userid'];

	// Get form variables

	$name = mysql_real_escape_string($_POST['name']);
	$race = mysql_real_escape_string($_POST['race']);

	// Character amount verification info
		
	$query = "SELECT * FROM characters WHERE userid = '$userid'";
	$result = mysql_query($query) or die(mysql_error());

	if(mysql_num_rows($result) >= $maxchars) {
		echo "<p>You can't create any more characters!</p>";
		session_destroy();
		include 'login.php';
		exit;
	}

	// Character Name Verification

	$query = "SELECT name FROM characters WHERE name = '$name'";
	$result = mysql_query($query) or die(mysql_error());

	if(mysql_num_rows($result)) {
		echo '<p>Character name is already being used!</p>';
		include 'cc.php';
		exit;
	}

	// Character Creation

	$query = "INSERT INTO characters (userid,name,race,map) VALUES('$userid','$name','$race',(SELECT startmap FROM races WHERE name = '$race'))";
	$result = mysql_query($query) or die(mysql_error());

	include 'main.php';

    // Load HTML5 Template

    include_once '../aat/footer.php';

    exit;
?>
