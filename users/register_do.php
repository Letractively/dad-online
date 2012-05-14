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
	$pwd1 = mysql_real_escape_string($_POST['pwd1']);
	$pwd2 = mysql_real_escape_string($_POST['pwd2']);

	// Function for validation errors

	function validationError($msg) {
		echo '<script language="javascript">alert("'.$msg.'");</script>';
		include 'register.php';
		exit;
	}

	// Email Validation

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		validationError("Invalid email address!");
	}

	// Password Validation

	if (strlen($pwd1) < 8) {
		validationError("Password too short! Must have at least 8 characters!");
	}

	if ($pwd1 != $pwd2) {
		validationError("Passwords don't match!");
	}

	// Register Validation

	$query = "SELECT * FROM users WHERE email = '$email'";
	$result = mysql_query($query) or die(mysql_error());

	if(mysql_num_rows($result)) {
		validationError("Email is already in use!");
	}

	// Register

	$query = "INSERT INTO users (email,password) VALUES('$email',PASSWORD('$pwd1'))";
	$result = mysql_query($query) or die(mysql_error());

	echo '<script language="javascript">
			alert("Registration successful!!!");
			window.location = ("../index.php");
		</script>';
?>
