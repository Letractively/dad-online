/*
DAD Online. Web browser MMORPG.
Copyright(C) 2012 Aceapps Aplicaciones. 
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses
*/

// Race picture preview

function changePicture() {
	var selection = document.cc.race.selectedIndex;
	if (selection == 0) {
		document.pic.src = "images/blank.png";
	} else {
		document.pic.src = "images/" + document.cc.race.options[selection].value + ".gif";
	};
}
