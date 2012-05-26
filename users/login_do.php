<?php
/*
DAD Online. Web browser MMORPG.
Copyright(C) 2012 Aceapps Aplicaciones. 
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses
*/

	// Logged in people must NOT be here

	session_start();
	session_destroy();

	// Load mysql info

	require_once '../include/config.php';

	// Get form variables

	$email = mysql_real_escape_string($_POST['email']);
	$password = mysql_real_escape_string($_POST['password']);

	// Login Validation
	
	$query = "SELECT id,accesslevel FROM users WHERE email = '$email' AND password = PASSWORD('$password')";
	$result = mysql_query($query) or die(mysql_error());

	// Login Error

	if(!mysql_num_rows($result)) {
		echo '<script language="javascript">
				alert("Invalid email/password!");
				window.location = ("../index.php");
			</script>';
		exit;
	}

	// Login

	$row = mysql_fetch_array($result);
	session_start();
	$_SESSION['id'] = htmlspecialchars($row[0]);
	$_SESSION['email'] = htmlspecialchars($email);
	$_SESSION['accesslevel'] = htmlspecialchars($row[1]);
	if ($row[1] >= 100) {
		echo '<script language="javascript">
				window.location = ("../admin/index.php");
			</script>';
		exit;
	}
	header('Location: index.php');
?>
