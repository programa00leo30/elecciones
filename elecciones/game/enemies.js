


var enemyTypes = [
	{ img : "guard.png", moveSpeed : 0.05, rotSpeed : 3, totalStates : 13 }
];

var mapEnemies = [
	{type : 0, x : 17.5, y : 4.5},
	{type : 0, x : 25.5, y : 16.5}
];



var enemies = [];		

function initEnemies() {
	var screen = $("screen");

	for (var i=0;i<mapEnemies.length;i++) {
		var enemy = mapEnemies[i];
		var type = enemyTypes[enemy.type];
		var img = dc("img");
		img.src = type.img;
		img.style.display = "none";
		img.style.position = "absolute";

		enemy.state = 0;
		enemy.rot = 0;
		enemy.rotDeg = 0;
		enemy.dir = 0;
		enemy.speed = 0;
		enemy.moveSpeed = type.moveSpeed;
		enemy.rotSpeed = type.rotSpeed;
		enemy.totalStates = type.totalStates;

		enemy.oldStyles = {
			left : 0,
			top : 0,
			width : 0,
			height : 0,
			clip : "",
			display : "none",
			zIndex : 0
		};

		enemy.img = img;
		enemies.push(enemy);

		screen.appendChild(img);
	}
}

function renderEnemies() {

	for (var i=0;i<enemies.length;i++) {
		var enemy = enemies[i];
		var img = enemy.img;

		var dx = enemy.x - player.x;
		var dy = enemy.y - player.y;

		var angle = Math.atan2(dy, dx) - player.rot;

		if (angle < -Math.PI) angle += 2*Math.PI;
		if (angle >= Math.PI) angle -= 2*Math.PI;

		// is enemy in front of player? Maybe use the FOV value instead.
		if (angle > -Math.PI*0.5 && angle < Math.PI*0.5) {
			var distSquared = dx*dx + dy*dy;
			var dist = Math.sqrt(distSquared);
			var size = viewDist / (Math.cos(angle) * dist);
			var x = Math.tan(angle) * viewDist;

			var style = img.style;
			var oldStyles = enemy.oldStyles;

			// height is equal to the sprite size
			if (size != oldStyles.height) {
				style.height =  size + "px";
				oldStyles.height = size;
			}

			// width is equal to the sprite size times the total number of states
			var styleWidth = size * enemy.totalStates;
			if (styleWidth != oldStyles.width) {
				style.width = styleWidth + "px";
				oldStyles.width = styleWidth;
			}

			// top position is halfway down the screen, minus half the sprite height
			var styleTop = ((screenHeight-size)/2);
			if (styleTop != oldStyles.top) {
				style.top = styleTop + "px";
				oldStyles.top = styleTop;
			}

			// place at x position, adjusted for sprite size and the current sprite state
			var styleLeft = (screenWidth/2 + x - size/2 - size*enemy.state);
			if (styleLeft != oldStyles.left) {
				style.left = styleLeft + "px";
				oldStyles.left = styleLeft;
			}

			var styleZIndex = -(distSquared*1000)>>0;
			if (styleZIndex != oldStyles.zIndex) {
				style.zIndex = styleZIndex;
				oldStyles.zIndex = styleZIndex;
			}

			var styleDisplay = "block";
			if (styleDisplay != oldStyles.display) {
				style.display = styleDisplay;
				oldStyles.display = styleDisplay;
			}

			var styleClip = "rect(0, " + (size*(enemy.state+1)) + ", " + size + ", " + (size*(enemy.state)) + ")";
			if (styleClip != oldStyles.clip) {
				style.clip = styleClip;
				oldStyles.clip = styleClip;
			}
		} else {
			var styleDisplay = "none";
			if (styleDisplay != enemy.oldStyles.display) {
				img.style.display = styleDisplay;
				enemy.oldStyles.display = styleDisplay;
			}
		}
	}
}


function ai(timeDelta) {
	for (var i=0;i<enemies.length;i++) {
		var enemy = enemies[i];

		var dx = player.x - enemy.x;
		var dy = player.y - enemy.y;

		var dist = Math.sqrt(dx*dx + dy*dy);
		if (dist > 4) {
			var angle = Math.atan2(dy, dx);

			enemy.rotDeg = angle * 180 / Math.PI;
			enemy.rot = angle;
			enemy.speed = 1;

			var walkCycleTime = 1000;
			var numWalkSprites = 4;

			enemy.state = Math.floor((new Date() % walkCycleTime) / (walkCycleTime / numWalkSprites)) + 1;

		} else {
			enemy.state = 0;
			enemy.speed = 0;
		}

		move(enemies[i], timeDelta);
	}
}
