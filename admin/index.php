<?php
/*
DAD Online. Web browser MMORPG.
Copyright(C) 2012 Aceapps Aplicaciones. 
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses
*/

	// Session Start

	session_start();

	// Load files

	require_once '../include/config.php';
	require_once '../include/functions.php';

	// Admin Login Validation

	if (!admin_session_validate()) {
		header('Location: ../');
		exit;
	}

	// Load HTML5 Template

    $depth = "../aat/"; include_once '../aat/header.php';

	// Admin Options

	echo '<p><input type="submit" value="user list" name="extra" class="extra"
		onClick="location.href=\'users.php\'" /></p>
		<p><input type="submit" value="add map" name="extra" class="extra"
		onClick="location.href=\'add_map.php\'" />
		<input type="submit" value="map list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=maps\'" /></p>
		<p><input type="submit" value="add spell" name="extra" class="extra"
		onClick="location.href=\'add_spell.php\'" />
		<input type="submit" value="spell list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=spells\'" /></p>
		<p><input type="submit" value="add race" name="extra" class="extra"
		onClick="location.href=\'add_race.php\'" />
		<input type="submit" value="race list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=races\'" /></p>
		<p><input type="submit" value="character list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=characters\'" /></p>
		<p>-</p>
		<p><input type="submit" value="user panel" name="extra" class="extra"
		onClick="location.href=\'../users/index.php\'" />
		<input type="submit" value="logout" name="extra" class="extra"
		onClick="location.href=\'../users/logout.php\'" /></p>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>