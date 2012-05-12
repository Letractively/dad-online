<?php
    // Load mysql info

	require_once '../include/config.php';

    // Logged in people must NOT be here

	session_start();
	session_destroy();

    // Load HTML5 Template

    $depth = "../aat/"; include_once '../aat/header.php';

	// Get form variables

	$email = mysql_real_escape_string($_POST['email']);
	$pwd1 = mysql_real_escape_string($_POST['pwd1']);
	$pwd2 = mysql_real_escape_string($_POST['pwd2']);

	// Function for validation errors

	function validationError() {
		echo "<br><br>";
		include 'register.php';
		exit;
	}

	// Email Validation

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    	echo "Invalid email address!";
		validationError();
	}

	// Password Validation

	if (strlen($pwd1) < 8) {
		echo "Password too short! Must have at least 8 characters!";
		validationError();
	}

	if ($pwd1 != $pwd2) {
		echo "Passwords don't match!";
		validationError();
	}

	// Register Validation

	$query = "SELECT * FROM users WHERE email = '$email'";
	$result = mysql_query($query) or die(mysql_error());

	if(mysql_num_rows($result)) {
		echo "Email is already in use!";
		validationError();
	}

	// Register

	$query = "INSERT INTO users (email,password) VALUES('$email',PASSWORD('$pwd1'))";
	$result = mysql_query($query) or die(mysql_error());

	include 'welcome.php';

    // Load HTML5 Template

    include_once '../aat/footer.php';

    exit;
?>
