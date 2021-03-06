<!--
DAD Online. Web browser MMORPG.
Copyright(C) 2012 Aceapps Aplicaciones. 
This program is free software: you can redistribute it and/or modify it under 
the terms of the GNU General Public License as published by the Free Software 
Foundation, either version 3 of the License, or (at your option) any later 
version. This program is distributed in the hope that it will be useful, but 
WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more 
details. You should have received a copy of the GNU General Public License 
along with this program. If not, see <http://www.gnu.org/licenses
*this* source code originaly commited by Sunsoft Servicios.
-->
<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> -->
<?php
session_start();
?>
<html>
    <head>
        <title>DAD Online - Alternate loging/register</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="jquery-1.7.2.js"></script>
        <script type="text/javascript" src="functions.js"></script>
    </head>
    <body>
        <div id="div1"></div>
        <div id='div2'>
            <?php
            require_once 'functions.php';
            //session_start();
            if (isset($_SESSION['id'])){
                echo '<span id=span1>Loged in!</span>';
            } 
            elseif (isset($_POST['email'])) {
                if (_login()) {
                    _loged_in();
                    echo '<span id=span1>Loged in!</span>';
                } else {
                    echo '<span id=span1>Invalid email or password!</span>';
                }
            }
            else {
                echo '<span id=span1>Wellcome!</span>';
            }
            ?>
        </div>
    </body>
</html>