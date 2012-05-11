<?php
	// Mysql Info

	$host = 'localhost';
	$user = 'dad';
	$pass = 'dad';
	$database = 'dad';

	// Mysql Connection
	 
	mysql_connect($host, $user, $pass) or die(mysql_error());
	mysql_select_db($database);

	// Game Configurations

	$maxchars = 3;
?>
