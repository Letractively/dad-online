/*
DAD Online. Web browser MMORPG.
Copyright(C) 2012 Aceapps Aplicaciones. 
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses
*/

// Create the canvas
var canvas = document.createElement("canvas");
var ctx = canvas.getContext("2d");
canvas.width = 512;
canvas.height = 64 * charamount;
var el = document.getElementById("drawhere");
el.appendChild(canvas);

// Initialize dummies
var i = 0;
var oldSelected = 0;

// Framing Function
function frame(x) {
	ctx.beginPath();
	ctx.moveTo(0,(x * 64));
	ctx.lineTo(512,(x * 64));
	ctx.lineTo(512,((x * 64) + 64));
	ctx.lineTo(0,((x * 64) + 64));
	ctx.closePath();
	ctx.stroke();
};

// Select Character Frame
canvas.addEventListener('click', function(e) {

	// Calculate Click Position
	var y;
	if (e.pageY) {
		y = e.pageY;
	}
	else {
		y = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
	}
	y -= canvas.offsetTop;

	// Deframe Old Selected Character
	ctx.strokeStyle = "rgb(255, 255, 255)";
	frame(oldSelected);

	// Frame Selected Character
	var x = Math.floor(y/64);
	ctx.strokeStyle = "rgb(0, 0, 0)";
	frame(x);
	oldSelected = x;
}, false);

// Char Images
var heroImage = new Array(charamount);

var charlist = function() {
	// Text
	ctx.fillStyle = "rgb(0, 0, 0)";
	ctx.font = "24px Helvetica";
	ctx.textAlign = "left";
	ctx.textBaseline = "top";
	ctx.fillText(charnames[i], 5, (i * 64));
	ctx.textAlign = "right";
	ctx.fillText(charmaps[i], 507, (i * 64));

	// Hero image
	heroImage[i] = new Image();
	heroImage[i].onload = function () {
		ctx.drawImage(heroImage[i], 5, ((i * 64) + 27));
		i++;
		if (i < charamount) {
			charlist();
		};
	};
	heroImage[i].src = "images/" + charraces[i] +".gif";
};

charlist();
