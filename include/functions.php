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

	// Enemy Picker

	function pick_enemy($id,$rate) {

		// Get total rate from mobs in the map

		$totalrate = 0;
		for ($i = 0; $i < sizeof($rate); $i++) $totalrate = $totalrate + $rate[$i];

		// Randomly pick a mob

		$magicnumber = mt_rand(1,$totalrate);

		// Calculate mob id

		$i = 0;
		while ($magicnumber > 0) {
			$magicnumber = $magicnumber - $rate[$i];
			$i++;
		}
		$i--;

		// Return mob id

		return $id[$i];
	}

	// Attack Result

	function attack_result($cid,$chp,$cstr,$cint,$cagi,$sstr,$sint,$sagi,$mob,$mhp,$mstr,$mint,$magi) {

		$dmg[0] = $cstr * $sstr;
		$dmg[1] = $cint * $sint;
		$dmg[2] = $cagi * $sagi;

		if ($mstr) $dmg[0] = $dmg[0] / $mstr;
		if ($mint) $dmg[1] = $dmg[1] / $mint;
		if ($magi) $dmg[2] = $dmg[2] / $magi;

		$totaldmg = $dmg[0] + $dmg[1] + $dmg[2];

		$mhp = $mhp - $totaldmg;

		$query = "UPDATE battles SET hp = $mhp WHERE charid = $cid";
		$result = mysql_query($query) or die(mysql_error());

		header('Location: battle.php');
	}
?>
