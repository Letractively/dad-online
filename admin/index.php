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

	$title = "<a>Admin Control Panel</a>";
	$depth = "../aat/"; include_once '../aat/header.php';

	// Admin Options

	echo 'Users

		<p><input type="submit" value="user list" name="extra" class="extra"
		onClick="location.href=\'users.php\'" /></p>

		Items

		<p><input type="submit" value="add item" name="extra" class="extra"
		onClick="location.href=\'add.php?table=items\'" />
		<input type="submit" value="item list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=items\'" /></p>

		Spells

		<p><input type="submit" value="add spell" name="extra" class="extra"
		onClick="location.href=\'add.php?table=spells\'" />
		<input type="submit" value="spell list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=spells\'" /></p>

		Maps

		<p><input type="submit" value="add map" name="extra" class="extra"
		onClick="location.href=\'add.php?table=maps\'" />
		<input type="submit" value="map list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=maps\'" />
		<input type="submit" value="add route" name="extra" class="extra"
		onClick="location.href=\'add.php?table=routes\'" />
		<input type="submit" value="route list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=routes\'" /></p>

		Races

		<p><input type="submit" value="add race" name="extra" class="extra"
		onClick="location.href=\'add.php?table=races\'" />
		<input type="submit" value="race list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=races\'" /></p>

		Mobs

		<p><input type="submit" value="add mob" name="extra" class="extra"
		onClick="location.href=\'add.php?table=mobs\'" />
		<input type="submit" value="mob list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=mobs\'" />
		<input type="submit" value="add drop" name="extra" class="extra"
		onClick="location.href=\'add.php?table=drops\'" />
		<input type="submit" value="drop list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=drops\'" />
		<input type="submit" value="add spawn" name="extra" class="extra"
		onClick="location.href=\'add.php?table=spawns\'" />
		<input type="submit" value="spawn list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=spawns\'" /></p>

		Quests

		<p><input type="submit" value="add quest" name="extra" class="extra"
		onClick="location.href=\'add.php?table=quests\'" />
		<input type="submit" value="quest list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=quests\'" />
		<input type="submit" value="add questmob" name="extral" class="extral"
		onClick="location.href=\'add.php?table=questmobs\'" />
		<input type="submit" value="questmob list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=questmobs\'" /></p>
		<p><input type="submit" value="add questitem" name="extral" class="extral"
		onClick="location.href=\'add.php?table=questitems\'" />
		<input type="submit" value="questitem list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=questitems\'" />
		<input type="submit" value="add reward" name="extral" class="extra"
		onClick="location.href=\'add.php?table=rewards\'" />
		<input type="submit" value="reward list" name="extral" class="extra"
		onClick="location.href=\'list.php?table=rewards\'" /></p>

		Characters

		<p><input type="submit" value="character list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=characters\'" />
		<input type="submit" value="add charspell" name="extral" class="extral"
		onClick="location.href=\'add.php?table=charspells\'" />
		<input type="submit" value="charspell list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=charspells\'" /></p>
		<p><input type="submit" value="add charitem" name="extral" class="extral"
		onClick="location.href=\'add.php?table=charitems\'" />
		<input type="submit" value="charitem list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=charitems\'" /></p>
		<p><input type="submit" value="add charquest" name="extral" class="extral"
		onClick="location.href=\'add.php?table=charquests\'" />
		<input type="submit" value="charquest list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=charquests\'" /></p>

		<!-- Options -->

		<p>-</p>
		<p><input type="submit" value="user panel" name="extra" class="extra"
		onClick="location.href=\'../users/index.php\'" />
		<input type="submit" value="logout" name="extra" class="extra"
		onClick="location.href=\'../users/logout.php\'" /></p>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
