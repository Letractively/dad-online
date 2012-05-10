<?php
	// Logged in people must NOT be here

	session_start();
	session_destroy();
?>

<! Successful account register welcome>

Welcome!<br><br>

<button type="button"><a href="login.php">Login</a></button>
