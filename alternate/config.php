<?php
/*
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
*/

	// MySQL Info
	$host = 'localhost';
	$user = 'dad';
	$pass = 'dad';
	$userdb = 'users';
	$daddb = 'dad';

	// MySQL Connection
	$connection = mysql_connect($host, $user, $pass);
    if (!$connection){
        die('Error 1: ' . mysql_error($connection));
    }
	mysql_select_db($daddb,$connection);

	// Game Configurations
	$maxchars = 3;
?>
