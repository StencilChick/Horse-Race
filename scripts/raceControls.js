// check if the race has progressed
var checkTimeout;
var checkRaceUpdated = function() {
	clearTimeout(checkTimeout);

	update();
}
window.onload = checkRaceUpdated;

// update the display to be current with the database
var update = function () {
	var request = new XMLHttpRequest();
	request.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var data = JSON.parse(this.responseText);
			
			var raceText = 'Race #' + data['id'] + ' - ';
			data['done'] === '0' ? raceText += 'Ongoing' : raceText += 'Complete';
			document.querySelector('#name').innerHTML = raceText;

			document.querySelector('#number').innerHTML = data['id'];

			document.querySelector('#time').innerHTML = 'Time: '+(parseInt(data['steps'])*10)+' sec.';

			raceDisplay();
			rankDisplay();

			checkTimeout = setTimeout(update, 3000); // check for an update every second
		}
	}
	request.open('POST', './code/getRaceInfo.php', true);
	request.send();
}

var raceDisplay = function(id) {
	var request = new XMLHttpRequest();
	request.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			// find and clear display
			var display = document.querySelector('div#display');
			while (display.firstChild) display.removeChild(display.firstChild);

			// add all the horse info
			var arr = JSON.parse(this.responseText);
			for (var i = 0; i < 8; i++) {
				var horse = arr[i];

				var div = document.createElement('div');
				div.className = 'horse';
				display.appendChild(div);

				var name = document.createElement('span');
				name.className = 'horseName';
				name.innerHTML = horse['name'];
				div.appendChild(name);

				var stats = document.createElement('span');
				stats.className = 'horseStats';
				stats.innerHTML = 'Spd. '+horse['speed']+' | Str. '+horse['strength']+' | End. '+horse['endurance'];
				div.appendChild(stats);

				var dist = document.createElement('span');
				dist.className = 'horseDist';
				dist.innerHTML = 'Dist: '+horse['dist']+'m<br> &lt;';
				for (var ii = 0; ii < 15; ii++) {
					if (parseInt(horse['dist'])/100 >= ii+1) {
						dist.innerHTML += '#';
					} else {
						dist.innerHTML += '-';
					}
				}
				dist.innerHTML += '&gt;';
				if (horse['time'] != '0') {
					dist.innerHTML = 'Time: '+horse['time']+'s | ' + dist.innerHTML;
				}
				div.appendChild(dist);
			}
		}
	};
	request.open('POST', './code/getRaceHorses.php', true);
	request.send();
}

var rankDisplay = function() {
	var request = new XMLHttpRequest();
	request.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var ranks = document.querySelector('#ranks');
			while (ranks.firstChild) ranks.removeChild(ranks.firstChild);

			var data = JSON.parse(this.responseText);
			for (var i = 0; i < 3; i++) {
				var p = document.createElement('p');
				p.innerHTML = (i+1)+'. ';
				ranks.appendChild(p);

				if (data.length <= i) {
					p.innerHTML += '--';
				} else {
					var horse = data[i];
					p.innerHTML += horse['name'];
				}
			}
		}
	}
	request.open('POST', './code/getRaceRanks.php', true);
	request.send();
}


// navigate to another race
var nextRace = function() {
	var request = new XMLHttpRequest();
	request.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			update();
		}
	}
	request.open('POST', './code/nextRace.php', true);
	request.send();
}

var prevRace = function() {
	var request = new XMLHttpRequest();
	request.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			update();
		}
	}
	request.open('POST', './code/prevRace.php', true);
	request.send();
}

// progress the currently shown race
var progressRace = function() {
	var request = new XMLHttpRequest();
	request.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			// get message
			var response = this.responseText;
			if (response!= '') makeMsg(response);

			// update the display
			update();
		}
	}
	request.open('POST', './code/progressRace.php', true);
	request.send();
}

// start a new race
var newRace = function() {
	var request = new XMLHttpRequest();
	request.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			// get message
			var response = this.responseText;
			if (response != '') {
				makeMsg(response);
			}

			// update the display
			update();
		}
	}
	request.open('POST', './code/makeNewRace.php', true);
	request.send();
}


// messaging
var makeMsg = function(text) {
	var msg = document.querySelector('#msg');
	msg.style.display = 'block';
	while (msg.firstChild) msg.removeChild(msg.firstChild);

	var p = document.createElement('p');
	p.innerHTML = text;
	msg.appendChild(p);

	var button = document.createElement('button');
	button.innerHTML = 'Close';
	button.addEventListener('click', function() {
		var msg = document.querySelector('#msg');
		msg.style.display = 'none';
		while (msg.firstChild) msg.removeChild(msg.firstChild);
	});
	msg.appendChild(button);
}