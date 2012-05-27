<?php
/*
DAD Online. Web browser MMORPG.
Copyright(C) 2012 Aceapps Aplicaciones. 
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses
*/

	// Session Start

	session_start();

	// Load files

	require_once '../include/config.php';
	require_once '../include/functions.php';

	// Login Validation

	if (!session_validate()) {
		header('Location: ../');
		exit;
	}

	// Get session variables

	$userid = $_SESSION['id'];
	$email = $_SESSION['email'];

	// Character amount verification info
		
	$query = "SELECT c.name,r.name,m.name FROM characters AS c,races AS r,maps AS m WHERE c.user = '$userid' AND c.race = r.id AND c.map = m.id";
	$result = mysql_query($query) or die(mysql_error());

	$numrows = mysql_num_rows($result);

    // No characters redirect

	if(!$numrows) {
        header('Location: cc.php');
        exit;
    }

	// Load HTML5 Template

    $depth = "../aat/"; include_once '../aat/header.php';

    // Show user info

    echo '<p>You are logged in as '. $email. '.</p>';

    // Initialize javascript arrays
    echo '<script type="text/javascript">
            var charamount = '.$numrows.';
            var charnames = new Array();
            var charraces = new Array();
            var charmaps = new Array();
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
    echo '<p><script language="javascript" src="js/dad.js">
        </script></p>';

	// Options Buttons

    // Verify room for more characters
    if($numrows < $maxchars) {
		echo '<p><input type="submit" value="create character" name="extral" class="extral"
			onClick="location.href=\'cc.php\'" /></p>';
	}

	// Logout Button

    echo '<p><input type="submit" value="logout" name="extra" class="extra"
		onClick="location.href=\'logout.php\'" /></p>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
