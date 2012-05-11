<?php
	// Load files

	require_once '../include/config.php';
	require_once '../include/functions.php';

	// Login Validation

	session_validate();

	// Get session variables

	$userid = $_SESSION['userid'];
	$email = $_SESSION['email'];

	// Character amount verification info
		
	$query = "SELECT c.name,c.race,m.name FROM characters AS c,map AS m WHERE c.userid = '$userid' AND c.map = m.id";
	$result = mysql_query($query) or die(mysql_error());

	$numrows = mysql_num_rows($result);

	if($numrows) {
		echo '<p>You are logged in as '. $email. '.</p>';

		// Initialize javascript arrays
		echo '<script type="text/javascript">
				var charamount = '.$numrows.';
				var charnames = new Array();
				var charraces = new Array();
				var charmaps = new Array();
				charnames[0] = "mierdaaa";
			</script>';

		// Fill javascript arrays
		$i = 0;
		while($row = mysql_fetch_array($result)) {
			echo '<script type="text/javascript">
					charnames['.$i.'] = "'.$row[0].'";
					charraces['.$i.'] = "'.$row[1].'";
					charmaps['.$i.'] = "'.$row[2].'";
				</script>';
			$i++;
		}

		// Draw user characters
		echo '<script language="javascript" src="js/dad.js">
			</script>';

		// Verify room for more characters
		if($numrows < $maxchars) {
			echo '<p><button type="button"><a href="cc.php">Create Character</a></button></p>';
		}
		echo '<p><button type="button"><a href="logout.php">Logout</a></button></p>';
		exit;
	}

	// No characters redirect

	header('Location: cc.php');
	exit;
?>
