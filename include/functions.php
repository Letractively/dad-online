<?php
	// Login Validation

	function session_validate() {
		session_start();

		if(!isset($_SESSION['userid']) || !isset($_SESSION['email'])) {
			session_destroy();
			echo '<p>You are not logged in.</p>';
			include 'login.php';
			exit;
		}
	}
?>
