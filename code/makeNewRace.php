<?php
	include './database.php';
	session_start();

	$db = new Database();
	$db->connect();

	if ($db->canMakeNewRace()) {
		// for constructing names
		$vornamen = ['Radiant', 'Old', 'Effervescent', 'Agile', 'Charismatic', 'Winning', 'Funny', 'Quiet', 'Courtly', 'Worthy', 'Affirmed', 'Sunday', 'Moon', 'Boots', 'Personal', 'War', 'Pleasant', 'Super', 'Dandy', 'Venetian', 'California', 'Malkovich', 'Morose', 'Silver', 'Gin', 'Electric', 'Serious', 'Spectacular', 'Venture', 'The', 'Jebidiah', 'Big', 'Iron', 'Pensive', 'Assault and', 'Grand', 'Genuine', 'Flying', 'Sir', 'Winter\'s', 'Saint', 'Her Esteemed Eminence Judge'];
		$nachnamen = ['Raddish', 'Potato', 'Sugarcube', 'Johnson', 'Colours', 'Cinderblock', 'Donau', 'Meridian', 'Hooves', 'Apollo', 'Hill', 'Moon', 'Silence', 'Chant', 'Riley', 'Ridge', 'Emblem', 'Gelatto', 'Man', 'Boy', 'Jones', 'Chrome', 'Malkovich', 'Charm', 'Grindstone', 'Bit', 'Heart Attack', 'Bid', 'Bird', 'Fortune', 'Capital', 'Secretariat', 'Smith', 'Buchanan', 'Paul', 'Battery', 'Monokeros', 'Admiral', 'Khan', 'Risk', 'Needles', 'Joe'];

		// add the new race
		$db->makeNewRace();
		$_SESSION['raceId'] = $db->lastRace();

		// add the new horses
		for ($i = 0; $i < 8; $i++) {
			$name = $vornamen[rand(0, 41)] . ' ' . $nachnamen[rand(0, 41)];

			$db->makeNewHorse($name, rand(0, 10), rand(0, 10), rand(0, 10));
		}

		// end
		echo 'Started a new race.';
	} else {
		echo 'A new race could not be started.  There are already three currently active races.';
	}

	$db->close();
?>