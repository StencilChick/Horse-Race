<?php
	include './database.php';
	session_start();

	$db = new Database();
	$db->connect();

	$raceNum = $_SESSION['raceId'];
	$startId = 1 + 8 * ($raceNum-1);
	echo json_encode($db->rankHorses($startId, $startId+7));

	$db->close();
?>