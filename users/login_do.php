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
