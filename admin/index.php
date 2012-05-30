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

	echo '<p><input type="submit" value="user list" name="extra" class="extra"
		onClick="location.href=\'users.php\'" /></p>

		<!-- Maps -->

		<p><input type="submit" value="add map" name="extra" class="extra"
		onClick="location.href=\'add.php?table=maps\'" />
		<input type="submit" value="map list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=maps\'" />
		<input type="submit" value="add route" name="extra" class="extra"
		onClick="location.href=\'add.php?table=routes\'" />
		<input type="submit" value="route list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=routes\'" /></p>

		<!-- Spells -->

		<p><input type="submit" value="add spell" name="extra" class="extra"
		onClick="location.href=\'add.php?table=spells\'" />
		<input type="submit" value="spell list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=spells\'" />
		<input type="submit" value="add spell to char" name="extral" class="extral"
		onClick="location.href=\'add.php?table=charspells\'" />
		<input type="submit" value="spell of char list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=charspells\'" /></p>
		<p><input type="submit" value="add class" name="extra" class="extra"
		onClick="location.href=\'add.php?table=classes\'" />
		<input type="submit" value="class list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=classes\'" /></p>
		<p><input type="submit" value="add race" name="extra" class="extra"
		onClick="location.href=\'add.php?table=races\'" />
		<input type="submit" value="race list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=races\'" /></p>
		<p><input type="submit" value="character list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=characters\'" /></p>
		<p><input type="submit" value="add npc" name="extra" class="extra"
		onClick="location.href=\'add.php?table=npcs\'" />
		<input type="submit" value="npc list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=npcs\'" />
		<input type="submit" value="add npc to map" name="extral" class="extral"
		onClick="location.href=\'add.php?table=mapnpcs\'" />
		<input type="submit" value="npc in map list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=mapnpcs\'" /></p>
		<p><input type="submit" value="add mob" name="extra" class="extra"
		onClick="location.href=\'add.php?table=mobs\'" />
		<input type="submit" value="mob list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=mobs\'" />
		<input type="submit" value="add mob to map" name="extral" class="extral"
		onClick="location.href=\'add.php?table=mapmobs\'" />
		<input type="submit" value="mob in map list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=mapmobs\'" /></p>
		<p><input type="submit" value="add item" name="extra" class="extra"
		onClick="location.href=\'add.php?table=items\'" />
		<input type="submit" value="item list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=items\'" />
		<input type="submit" value="add item to char" name="extral" class="extral"
		onClick="location.href=\'add.php?table=charitems\'" />
		<input type="submit" value="item of char list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=charitems\'" /></p>

		<!-- Quests -->

		<p><input type="submit" value="add quest" name="extra" class="extra"
		onClick="location.href=\'add.php?table=quests\'" />
		<input type="submit" value="quest list" name="extra" class="extra"
		onClick="location.href=\'list.php?table=quests\'" />
		<input type="submit" value="add quest to npc" name="extral" class="extral"
		onClick="location.href=\'add.php?table=npcquests\'" />
		<input type="submit" value="quest of npc list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=npcquests\'" />
		<input type="submit" value="add mob to quest" name="extral" class="extral"
		onClick="location.href=\'add.php?table=questmobs\'" />
		<input type="submit" value="mob of quest list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=questmobs\'" /></p>
		<p><input type="submit" value="add item to quest" name="extral" class="extral"
		onClick="location.href=\'add.php?table=questitems\'" />
		<input type="submit" value="item of quest list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=questitems\'" /></p>

		<!-- Character Quests -->

		<p><input type="submit" value="add quest to char" name="extral" class="extral"
		onClick="location.href=\'add.php?table=charquests\'" />
		<input type="submit" value="quest of char list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=charquests\'" /></p>
		<p><input type="submit" value="add questmob to char" name="extral" class="extral"
		onClick="location.href=\'add.php?table=charquestmobs\'" />
		<input type="submit" value="questmob of char list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=charquestmobs\'" /></p>
		<p><input type="submit" value="add completequest to char" name="extral" class="extral"
		onClick="location.href=\'add.php?table=completequests\'" />
		<input type="submit" value="completequest list" name="extral" class="extral"
		onClick="location.href=\'list.php?table=completequests\'" /></p>

		<!-- Options -->

		<p>-</p>
		<p><input type="submit" value="user panel" name="extra" class="extra"
		onClick="location.href=\'../users/index.php\'" />
		<input type="submit" value="logout" name="extra" class="extra"
		onClick="location.href=\'../users/logout.php\'" /></p>';

	// Load HTML5 Template

	include_once '../aat/footer.php';
?>
