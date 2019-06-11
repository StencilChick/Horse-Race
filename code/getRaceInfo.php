<?php
	include './database.php';
	session_start();

	$db = new Database();
	$db->connect();

	$raceNum = $_SESSION['raceId'];
	$data = $db->getRaceData($raceNum);
	$db->close();

	echo json_encode($data);
?>