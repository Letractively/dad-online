<?php

/*
DAD Online. Web browser MMORPG.
Copyright(C) 2012 Aceapps Aplicaciones.
This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version. This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or
FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
details. You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses
*this* source code originaly commited by Sunsoft Servicios.
*/

// Session start and load required files

session_start()
    or die('Error 7: could not start session');
require_once 'config.php';
require_once 'functions.php';

// Login Validation

if (!_session_validate()) {
    header('Location: index.htm');
    exit;
}

// Get session variables

$userid = $_SESSION['id'];
$accesslevel = $_SESSION['accesslevel'];

// Character amount verification info
		
$query =
    "SELECT c.id, c.name, r.name, m.name 
    FROM characters AS c, races AS r, maps AS m
    WHERE c.user = '$userid' 
    AND c.race = r.id 
    AND c.map = m.id";
$result = mysql_query($query) 
    or die('Error 8: ' . mysql_error());

// No characters redirect
/*
$numrows = mysql_num_rows($result);
if(!$numrows) {
    header('Location: ../users/cc.php');
    exit;
}
*/
// Load HTML5 Template
include_once '../aat/header.php';
$title = '<li><a href="index.htm">Home</a></li>
    <li><a href="profile.php">Profile</a></li>';

// Verify Room for More Characters

if ($numrows < $maxchars) {
    $title .= '<li><a href="../users/cc.php">Create Character</a></li>';
}

$title .= '<li><a href="logout.php">Logout</a></li>';

$depth = "../aat/"; include_once '../aat/header.php';

// Char Selection

echo '<table>';
while ($row = mysql_fetch_array($result)) {
    echo '<tr><td>'.$row[1].'</td>
        <td><img name="pic" src="images/'.$row[2].'.png" border="0"></td>
        <td>@ '.$row[3].'</td>
        <td><input type="submit" value="play!" name="extra" class="extra" 
        onClick="location.href=\'sc.php?id='.$row[0].'\'" /></td></tr>';			
}
echo '</table>';

// Admin Panel

if ($accesslevel >= 100) 
    echo '<p><input type="submit" value="admin panel" name="extra" class="extra"
    onClick="location.href=\'../admin/index.php\'" /></p>';

// Load HTML5 Template

include_once '../aat/footer.php';
?>
