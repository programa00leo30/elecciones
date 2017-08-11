// just a few helper functions
var $ = function(id) { return document.getElementById(id); };
var dc = function(tag) { return document.createElement(tag); };


// indexOf for IE. From: https://developer.mozilla.org/En/Core_JavaScript_1.5_Reference:Objects:Array:indexOf
if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function(elt /*, from*/) {
		var len = this.length;
		var from = Number(arguments[1]) || 0;
		from = (from < 0) ? Math.ceil(from) : Math.floor(from);
		if (from < 0)
			from += len;
		for (; from < len; from++) {
			if (from in this && this[from] === elt)
				return from;
		}
		return -1;
	};
}

function move(entity, timeDelta) {
	// time timeDelta has passed since we moved last time. We should have moved after time gameCycleDelay,
	// so calculate how much we should multiply our movement to ensure game speed is constant

	var mul = timeDelta / gameCycleDelay;

	// aqui se calcula el modulo de la distancia a recorrer por la velocidad.. ( rapidez. )
	var moveStep = mul * entity.speed * entity.moveSpeed;	// entity will move this far along the current direction vector

	// aqui se convierte el valor dir en rotDeg para saver rotacion en degradanes.
	entity.rotDeg += mul * entity.dir * entity.rotSpeed; // add rotation if entity is rotating (entity.dir != 0)
	entity.rotDeg %= 360;

	if (entity.rotDeg < -180) entity.rotDeg += 360;
	if (entity.rotDeg >= 180) entity.rotDeg -= 360;

	var snap = (entity.rotDeg+360) % 90
	if (snap < 2 || snap > 88) {
		entity.rotDeg = Math.round(entity.rotDeg / 90) * 90;
	}

	entity.rot = entity.rotDeg * Math.PI / 180;

	// nueva posicion del objeto. movido.
	var newX = entity.x + Math.cos(entity.rot) * moveStep;	// calculate new entity position with simple trigonometry
	var newY = entity.y + Math.sin(entity.rot) * moveStep;

	var pos = checkCollision(entity.x, entity.y, newX, newY, 0.35);

	entity.x = pos.x; // set new position
	entity.y = pos.y;
}

function checkCollision(fromX, fromY, toX, toY, radius) {
	var pos = {
		x : fromX,
		y : fromY
	};

	if (toY < 0 || toY >= mapHeight || toX < 0 || toX >= mapWidth)
		return pos;

	var blockX = Math.floor(toX);
	var blockY = Math.floor(toY);


	if (isBlocking(blockX,blockY)) {
		return pos;
	}

	pos.x = toX;
	pos.y = toY;

	var blockTop = isBlocking(blockX,blockY-1);
	var blockBottom = isBlocking(blockX,blockY+1);
	var blockLeft = isBlocking(blockX-1,blockY);
	var blockRight = isBlocking(blockX+1,blockY);

	if (blockTop != 0 && toY - blockY < radius) {
		toY = pos.y = blockY + radius;
	}
	if (blockBottom != 0 && blockY+1 - toY < radius) {
		toY = pos.y = blockY + 1 - radius;
	}
	if (blockLeft != 0 && toX - blockX < radius) {
		toX = pos.x = blockX + radius;
	}
	if (blockRight != 0 && blockX+1 - toX < radius) {
		toX = pos.x = blockX + 1 - radius;
	}

	// is tile to the top-left a wall
	if (isBlocking(blockX-1,blockY-1) != 0 && !(blockTop != 0 && blockLeft != 0)) {
		var dx = toX - blockX;
		var dy = toY - blockY;
		if (dx*dx+dy*dy < radius*radius) {
			if (dx*dx > dy*dy)
				toX = pos.x = blockX + radius;
			else
				toY = pos.y = blockY + radius;
		}
	}
	// is tile to the top-right a wall
	if (isBlocking(blockX+1,blockY-1) != 0 && !(blockTop != 0 && blockRight != 0)) {
		var dx = toX - (blockX+1);
		var dy = toY - blockY;
		if (dx*dx+dy*dy < radius*radius) {
			if (dx*dx > dy*dy)
				toX = pos.x = blockX + 1 - radius;
			else
				toY = pos.y = blockY + radius;
		}
	}
	// is tile to the bottom-left a wall
	if (isBlocking(blockX-1,blockY+1) != 0 && !(blockBottom != 0 && blockBottom != 0)) {
		var dx = toX - blockX;
		var dy = toY - (blockY+1);
		if (dx*dx+dy*dy < radius*radius) {
			if (dx*dx > dy*dy)
				toX = pos.x = blockX + radius;
			else
				toY = pos.y = blockY + 1 - radius;
		}
	}
	// is tile to the bottom-right a wall
	if (isBlocking(blockX+1,blockY+1) != 0 && !(blockBottom != 0 && blockRight != 0)) {
		var dx = toX - (blockX+1);
		var dy = toY - (blockY+1);
		if (dx*dx+dy*dy < radius*radius) {
			if (dx*dx > dy*dy)
				toX = pos.x = blockX + 1 - radius;
			else
				toY = pos.y = blockY + 1 - radius;
		}
	}

	return pos;
}
