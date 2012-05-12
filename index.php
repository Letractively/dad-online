<?php
/*
DAD Online. Web browser MMORPG.
Copyright(C) 2012 Aceapps Aplicaciones. 
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses
*/

	// Logged in people must NOT be here

	session_start();
	session_destroy();

    // Load HTML5 Template

    $depth = "aat/"; include_once 'aat/header.php';

    // Login/Register Buttons

    echo '<table align=center>
        <tr>
            <td align="left">
                <button type="button"><a href="users/login.php">Login</a></button>
            </td>
            <td align="right">
                <button type="button"><a href="users/register.php">Register</a></button>
            </td>
        </tr>
    </table>';

    // Load HTML5 Template

    include_once 'aat/footer.php';
?>
