<?php
	include './code/database.php';
	$db = new Database();
	$db->connect();

	session_start();
	if (!isset($_SESSION['raceId'])) {
		$_SESSION['raceId'] = $db->lastRace();
	}

	$db->close();
?>

<!DOCTYPE html>
<html>

<head>
	<title>Horse Race</title>
	<meta charset='utf-8'>

	<link type='text/css' rel='stylesheet' href='./style.css'>

	<script src='./scripts/raceControls.js'></script>
</head>

<body>
	<h1>Horse Race</h1>

	<!-- race interface -->
	<h2 id=name>Race #</h2>
	<h3 id=time>Time: </h3>
	<div id=display>

	</div>
	<h3>Winners</h3>
	<div id=ranks>

	</div>

	<!-- controls -->
	<div id=controls>
		<!-- navigate races -->
		<div class=left>
			<button onclick='prevRace()'>&lt;</button>
			<span id=number>1</span>
			<button onclick='nextRace()'>&gt;</button>
		</div>

		<!-- new and progress --->
		<div class=right>
			<button onclick='progressRace()'>Progress</button>
			<button onclick='newRace()'>New Race</button>
		</div>

		<div class=clear></div>
	</div>

	<!-- messaging -->
	<div id=msg>

	</div>
</body>
</html>