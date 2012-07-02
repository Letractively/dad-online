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

// Load MySQL info
require_once 'config.php';

//Get form variables, via POST method. Function used to provide a safe query 
$email = mysql_real_escape_string($_POST['email'],$connection);
if (!$email) {
    die('Error 2: ' . mysql_error($connection));
}

$password = mysql_real_escape_string($_POST['password'],$connection);
if (!$password) {
    die('Error 3: ' . mysql_error($connection));
}

// Login Validation
$query = 
    "SELECT id,accesslevel 
    FROM $userdb.users 
    WHERE email = '$email'
    AND password = PASSWORD('$password')";

$result = mysql_query($query,$connection);
if (!$result) {
    die('Error 4: ' . mysql_error($connection));
}

if(!mysql_num_rows($result)) {
    echo    '<script type="text/javascript">
                alert("Invalid email/password!");
                window.location = ("index.htm");
            </script>';
    exit;
}

// Actual login
$sqlrow = mysql_fetch_array($result);
if (!$sqlrow) {
    die('Error 5: no more rows');
}

$started = session_start();
if (!$started) {
    die('Error 6: could not start session');
}

$_SESSION['id'] = htmlspecialchars($sqlrow['id']);
$_SESSION['email'] = htmlspecialchars($email);
$_SESSION['accesslevel'] = htmlspecialchars($sqlrow['accesslevel']);

header('Location: loged_in.php');
?>
