function changePicture() {
	var selection = document.cc.race.selectedIndex;
	if (selection == 0) {
		document.pic.src = "images/blank.png";
	} else {
		document.pic.src = "images/" + document.cc.race.options[selection].value + ".gif";
	};
}
