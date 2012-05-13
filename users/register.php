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

    $depth = "../aat/"; include_once '../aat/header.php';

	// Regiser Form

	echo '<form id="register" action="register_do.php" method="post" accept-charset="UTF-8">
			<fieldset>
				<legend>Register</legend>
				<label for="email">Email:</label>
				<input type="text" name="email" id="email" maxlength="50" required/><br/>
				<label for="pwd1">Password:</label>
				<input type="password" name="pwd1" id="pwd1" maxlength="50" required/><br/>
				<label for="pwd2">Repeat Password:</label>
				<input type="password" name="pwd2" id="pwd2" maxlength="50" required/><br/>
				<input type="submit" name="Submit" value="Submit"/>
				<button type="button"><a href="../index.php">Cancel</a></button>
			</fieldset>
		</form>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
