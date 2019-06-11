<?php
	include './database.php';
	session_start();

	$db = new Database();
	$db->connect();

	$raceNum = $_SESSION['raceId'];
	$raceData = $db->getRaceData($raceNum);

	if ($raceData['done'] == '1') {
		// the race is complete
		echo 'This race is already finished.';
	} else {
		$db->stepRace($raceNum);

		$endCount = 0;

		$startId = 1 + 8 * ($raceNum-1);
		for ($i = $startId; $i < $startId+8; $i++) {
			$endCount += $db->stepHorse($i, $raceData['steps']);
		}

		if ($endCount == 8) $db->endRace($raceNum);
	}

	$db->close();
?>