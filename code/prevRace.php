<?php
	session_start();
	$val = $_SESSION['raceId'] - 1;
	if ($val > 0) $_SESSION['raceId'] = $val;
?>