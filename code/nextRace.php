<?php
	include './database.php';
	$db = new Database();
	$db->connect();

	session_start();
	$val = $_SESSION['raceId'] + 1;
	if ($val <= $db->lastRace()) $_SESSION['raceId'] = $val;

	$db->close();
?>