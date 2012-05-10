<?php
	// Load files

	require_once '../include/config.php';
	require_once '../include/functions.php';

	// Login Validation

	session_validate();

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

	header('Location: main.php');
?>
