<?php
	include './database.php';
	session_start();

	$db = new Database();
	$db->connect();

	$horseArr = array();

	$raceNum = $_SESSION['raceId'];
	$startId = 1 + 8 * ($raceNum-1);
	for ($i = $startId; $i < $startId+8; $i++) {
		$data = $db->getHorseData($i);
		array_push($horseArr, $data);
	}

	echo json_encode($horseArr);
	$db->close();
?>