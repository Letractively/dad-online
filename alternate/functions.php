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

function _login(){

    // Load MySQL info

    require_once 'config.php';

    //Get form variables, via POST. Function used to provide a safe query 

    $email = mysql_real_escape_string($_POST['email'],$connection)
        or die('Error 2: ' . mysql_error($connection));


    $password = mysql_real_escape_string($_POST['password'],$connection)
        or die('Error 3: ' . mysql_error($connection));


    // Login Validation

    $query = 
        "SELECT id,accesslevel 
        FROM $userdb.users 
        WHERE email = '$email'
        AND password = PASSWORD('$password')";

    $result = mysql_query($query,$connection)
        or die('Error 4: ' . mysql_error($connection));

    if(!mysql_num_rows($result)) {
        return FALSE;
        exit;
    }

    // Actual login

    $sqlrow = mysql_fetch_array($result)
        or die('Error 5: no more rows');

    $started = session_start()
        or die('Error 6: could not start session');

    $_SESSION['id'] = htmlspecialchars($sqlrow['id']);
    $_SESSION['email'] = htmlspecialchars($email);
    $_SESSION['accesslevel'] = htmlspecialchars($sqlrow['accesslevel']);

    //header('Location: loged_in.php');

    return TRUE;
}


function _session_validate() {
    if(!isset($_SESSION['id']) ||
       !isset($_SESSION['email'])|| 
       !isset($_SESSION['accesslevel'])) {
        session_destroy();
        return false;
    } else {
        return true;
    }
}

function _loged_in(){
    // Session start and load required files

    session_start()
        or die('Error 7: could not start session');
    require_once 'config.php';
    //require_once 'functions.php';

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
    $numrows = mysql_num_rows($result);
    if ($numrows == 0) {
        echo '<span> no characers yet! please create a characer </span>';
    }
    
    // Char Selection Table
    
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
        echo '<p><input class="extra" type="submit" value="admin panel" 
            name="extra" onClick="location.href=\'../admin/index.php\'" /></p>';
}
?>
