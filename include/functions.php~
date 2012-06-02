<?php
/*
DAD Online. Web browser MMORPG.
Copyright(C) 2012 Aceapps Aplicaciones. 
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses
*/

	// Login Validation

	function session_validate() {
		if(!isset($_SESSION['id']) || !isset($_SESSION['email']) ||
		!isset($_SESSION['accesslevel'])) {
			session_destroy();
			return false;
		} else {
			return true;
		}
	}

	// Admin Login Validation

	function admin_session_validate() {
		if(!isset($_SESSION['id']) || !isset($_SESSION['email']) ||
		!isset($_SESSION['accesslevel'])) {
			session_destroy();
			return false;
		} else {
			if ($_SESSION['accesslevel'] < 100) {
				session_destroy();
				return false;
			} else {
				return true;
			}
		}
	}

	// Selected Char Validation

	function char_selected() {
		if(!isset($_SESSION['charid']) || !isset($_SESSION['charname']) ||
		!isset($_SESSION['race']) || !isset($_SESSION['map']) ||
		!isset($_SESSION['hp'])) {
			return false;
		} else {
			return true;
		}
	}

	// Battle Check for Characters

	function battle_check($charid) {
		$query = "SELECT * FROM battles WHERE charid = $charid";
		$result = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($result)) return "mob";

		$query = "SELECT * FROM battlenpcs WHERE charid = $charid";
		$result = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($result)) return "npc";

		return "";
	}
?>
