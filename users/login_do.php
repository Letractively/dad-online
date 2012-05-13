<?php
/*
DAD Online. Web browser MMORPG.
Copyright(C) 2012 Aceapps Aplicaciones. 
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses
*/

    // Load mysql info

	require_once '../include/config.php';

	// Logged in people must NOT be here

	session_start();
	session_destroy();

    // Load HTML5 Template

    $depth = "../aat/"; include_once '../aat/header.php';

	// Get form variables

	$email = mysql_real_escape_string($_POST['email']);
	$password = mysql_real_escape_string($_POST['password']);

	// Login Validation
	
	$query = "SELECT id FROM users WHERE email = '$email' AND password = PASSWORD('$password')";
	$result = mysql_query($query) or die(mysql_error());

	// Login

	if(mysql_num_rows($result)) {
		$row = mysql_fetch_array($result);
		session_start();
		$_SESSION['userid'] = htmlspecialchars($row[0]);
		$_SESSION['email'] = htmlspecialchars($email);
		include 'main.php';
		exit;
	}

	// Login Error

	echo '<p><strong>Error:</strong> Invalid email or password.</p>';
	include 'login.php';

    // Load HTML5 Template

    include_once '../aat/footer.php';

    exit;
?>
