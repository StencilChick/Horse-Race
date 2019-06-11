<?php
	/*
	* everything for interacting with the database
	*/

	class Database {
		var $conn;

		function connect() {
			$this->conn = new mysqli('localhost', 'root', '', 'horse_race');

			if ($this->conn->connect_errno > 0) {
				die('Connection failed: ' . $this->conn->connect_error);
			}
		}

		function close() {
			mysqli_close($this->conn);
			$this->conn = null;
		}


		// functions for interacting with races
		function getRaceData($id) {
			$sql = 'SELECT * FROM `races` WHERE `id` = '.$id;
			$result = $this->conn->query($sql);

			return $result->fetch_assoc();
		}

		function isRaceUpdate($id, $steps) {
			$sql = 'SELECT `steps` FROM `races` WHERE `id` = '.$id;
			$result = $this->conn->query($sql);

			return (int)$result->fetch_assoc()['steps'] > $steps;
		}

		function stepRace($id) {
			$sql = 'UPDATE `races` SET steps = steps + 1 WHERE `id` = '.$id;
			$this->conn->query($sql);
		}

		function canMakeNewRace() {
			$sql = 'SELECT `id` FROM `races` WHERE `done` = 0';
			$result = $this->conn->query($sql);

			return $result->num_rows < 3;
		}

		function lastRace() {
			$sql = 'SELECT max(id) FROM `races`';
			$result = $this->conn->query($sql);

			return (int)$result->fetch_assoc()['max(id)'];
		}

		function makeNewRace() {
			$sql = 'INSERT INTO `races` (`id`, `done`, `steps`) VALUES (NULL, \'\', \'\')';
			$this->conn->query($sql);
		}

		function endRace($id) {
			$sql = 'UPDATE `races` SET done = 1 WHERE id = '.$id;
			$this->conn->query($sql);
		}


		// functions for interacting with horses
		function getHorseData($id) {
			$sql = 'SELECT * FROM `horses` WHERE `id` = ' . $id;
			$result = $this->conn->query($sql);

			if (!$result) {
				die('Query error: ' . $this->conn->error);
			}

			return $result->fetch_assoc();
		}

		function makeNewHorse($name, $speed, $strength, $endurance) {
			$sql = 'INSERT INTO `horses` (`name`, `speed`, `strength`, `endurance`) VALUES ("'.$name.'", '.$speed.', '.$strength.', '.$endurance.')';
			$result = $this->conn->query($sql);
		}

		function stepHorse($id, $stepsDone) {
			$data = $this->getHorseData($id);

			$beginDist = (int)$data['dist'];
			if ($beginDist >= 1500) return true;

			$speed = 5 + (int)$data['speed'];
			$fatiguePoint = (int)$data['endurance'] * 100;

			$endDist;
			if ($beginDist < $fatiguePoint) {
				// horse is not yet tired
				$endDist = $beginDist + 10 * $speed;

				// check if will become tired within these ten seconds
				if ($endDist > $fatiguePoint) {
					// while not tired
					$distLeft = $fatiguePoint - $beginDist;
					$timeElapsed = $distLeft / $speed;

					$endDist = $beginDist + $speed * $timeElapsed;

					// while tired
					$speed -= 5 - 5 * (0.08 * $data['strength']);

					$endDist += $speed * (10 - $timeElapsed);
				}
			} else {
				// horse is tired
				$speed -= 5 - 5 * (0.08 * $data['strength']);
				$endDist = $beginDist + 10 * $speed;

				// check if horse crosses the finish line
				if ($endDist >= 1500) {
					$distLeft = 1500 - $beginDist;
					$timeElapsed = $distLeft / $speed;

					$finalTime = $stepsDone*10 + $timeElapsed; // time it crosses the finish line

					$sql = 'UPDATE `horses` SET dist=1500, time='.$finalTime.' WHERE `id` = '.$id;
					$this->conn->query($sql);
					return true;
				}
			}


			// move the horse over ten seconds
			$sql = 'UPDATE `horses` SET dist = '.$endDist.' WHERE `id` = '.$id;
			$this->conn->query($sql);

			return false;
		}

		function rankHorses($min, $max) {
			$sql = 'SELECT * FROM `horses` WHERE id >= '.$min.' AND id <= '.$max.' AND time != 0 ORDER BY time';
			$result = $this->conn->query($sql);

			$list = Array();
			while ($data = $result->fetch_assoc()) {
				array_push($list, $data);
				if (count($list) == 3) break;
			}
			return $list;
		}
	}
?>