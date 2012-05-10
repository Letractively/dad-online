// Create the canvas
var canvas = document.createElement("canvas");
var ctx = canvas.getContext("2d");
canvas.width = 512;
canvas.height = 64 * charamount;
document.body.appendChild(canvas);

// Initialize dummies
var i = 0;

// Char Images
var heroImage = new Array(charamount);

var charlist = function() {
	// Text
	ctx.fillStyle = "rgb(0, 0, 0)";
	ctx.font = "24px Helvetica";
	ctx.textAlign = "left";
	ctx.textBaseline = "top";
	ctx.fillText(charnames[i], 0, (i * 64));
	ctx.textAlign = "right";
	ctx.fillText(charmaps[i], 512, (i * 64));

	// Hero image
	heroImage[i] = new Image();
	heroImage[i].onload = function () {
		ctx.drawImage(heroImage[i], 0, ((i * 64) + 32));
		i++;
		if (i < charamount) {
			charlist();
		}
	};
	heroImage[i].src = "images/" + charraces[i] +".gif";
};

charlist();
