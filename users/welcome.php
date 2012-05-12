<?php
	// Logged in people must NOT be here

	session_start();
	session_destroy();

    // Load HTML5 Template

    $depth = "../aat/"; include_once '../aat/header.php';
?>

<! Successful account register welcome>

Welcome!<br><br>

<button type="button"><a href="login.php">Login</a></button>

<?php
    // Load HTML5 Template

    include_once '../aat/footer.php';
?>


