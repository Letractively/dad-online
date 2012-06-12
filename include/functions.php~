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
		!isset($_SESSION['accesslevel']) || ($_SESSION['accesslevel'] < 100)) {
			session_destroy();
			return false;
		} else {
			return true;
		}
	}

	// Login & Character Validation

	function char_selected() {
		if(!isset($_SESSION['id']) || !isset($_SESSION['email']) ||
		!isset($_SESSION['accesslevel']) || !isset($_SESSION['charid'])) {
			return false;
		} else {
			return true;
		}
	}

	// Battle Check for Characters

	function battle_check($charid) {
		$query = "SELECT * FROM battles WHERE charid = $charid";
		$result = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($result)) return true;
		return false;
	}

	// Enemy Picker

	function pick_enemy($id,$rate) {

		// Get Total Rate from Mobs in the Map

		$totalrate = 0;
		for ($i = 0; $i < sizeof($rate); $i++) $totalrate = $totalrate + $rate[$i];

		// Randomly Pick a Mob

		$magicnumber = mt_rand(1,$totalrate);

		// Calculate Mob ID

		$i = 0;
		while ($magicnumber > 0) {
			$magicnumber = $magicnumber - $rate[$i];
			$i++;
		}
		$i--;

		// Return Mob ID

		return $id[$i];
	}

	// Attack Result

	function attack_result($cid,$char,$cstr,$cint,$cagi,$sstr,$sint,$sagi,$mob,$mhp,$mstr,$mint,$magi) {

		// Get Total Damage

		$totaldmg = damage_calc($cstr,$cint,$cagi,$sstr,$sint,$sagi,$mstr,$mint,$magi);

		// Calculate Remaining HP

		$mhp = $mhp - $totaldmg;

		// Update Battle

		$query = "UPDATE battles SET hp = $mhp WHERE charid = $cid";
		$result = mysql_query($query) or die(mysql_error());

		// Inform User

		return $char.' attacks '.$mob.' for '.$totaldmg.' damage!\n';
	}

	// Defense Result

	function defense_result($cid,$char,$chp,$cstr,$cint,$cagi,$mid,$mob,$mstr,$mint,$magi) {

		// Get Spell List

		$query = "SELECT spell1,spell2,spell3,spell4 FROM mobs WHERE id = $mid";
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_row($result);
		$sl[0] = $row[0]; $sl[1] = $row[1]; $sl[2] = $row[2]; $sl[3] = $row[3];

		// Calculate Most Damage

		$maxdmg = 0;
		$spell = "nothing";
		for ($i = 0 ; $i < 4 ; $i++) {

			$q = "SELECT `str`,`int`,`agi`,`name` FROM spells WHERE id = $sl[$i]";
			$r = mysql_query($q) or die(mysql_error());
			$sr = mysql_fetch_row($r);

			// Get Total Damage

			$totaldmg = damage_calc($mstr,$mint,$magi,$sr[0],$sr[1],$sr[2],$cstr,$cint,$cagi);

			// Choose Higher Damage

			if ($totaldmg > $maxdmg) {
				$maxdmg = $totaldmg;
				$spell = $sr[3];
			}
		}

		// Calculate Remaining HP

		$chp = $chp - $maxdmg;

		// Update Character

		$query = "UPDATE characters SET hp = $chp WHERE id = $cid";
		$result = mysql_query($query) or die(mysql_error());

		// Inform User

		return $mob.' attacks '.$char.' with '.$spell.' for '.$maxdmg.' damage!\n';
	}

	// Total Damage Calculator

	function damage_calc($astr,$aint,$aagi,$sstr,$sint,$sagi,$dstr,$dint,$dagi) {

		// Calculate Max Attack Value

		$dmg[0] = $astr * $sstr;
		$dmg[1] = $aint * $sint;
		$dmg[2] = $aagi * $sagi;

		// Damage Diminishers

		if ($dstr) $dmg[0] = $dmg[0] / $dstr;
		if ($dint) $dmg[1] = $dmg[1] / $dint;
		if ($dagi) $dmg[2] = $dmg[2] / $dagi;

		// Round up Total Damage

		$totaldmg = $dmg[0] + $dmg[1] + $dmg[2];
		$totaldmg = round($totaldmg);

		return $totaldmg;
	}

	// Mob Dead Verify

	function mob_dead($id) {
		$query = "SELECT hp FROM battles WHERE charid = $id";
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_row($result);
		if ($row[0]) return false;
		else return true;
	}

	// Character Dead Verify

	function char_dead($id) {
		$query = "SELECT hp FROM characters WHERE id = $id";
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_row($result);
		if ($row[0]) return false;
		else return true;
	}
?>
