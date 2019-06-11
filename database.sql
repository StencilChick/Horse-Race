-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2019 at 02:57 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `horse_race`
--

-- --------------------------------------------------------

--
-- Table structure for table `horses`
--

CREATE TABLE `horses` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `speed` tinyint(3) UNSIGNED NOT NULL,
  `strength` tinyint(3) UNSIGNED NOT NULL,
  `endurance` tinyint(3) UNSIGNED NOT NULL,
  `dist` int(11) UNSIGNED NOT NULL,
  `time` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `horses`
--

INSERT INTO `horses` (`id`, `name`, `speed`, `strength`, `endurance`, `dist`, `time`) VALUES
(1, 'Pleasant Cinderblock', 3, 7, 3, 0, 0),
(2, 'California Gelatto', 9, 8, 9, 0, 0),
(3, 'Sunday Monokeros', 4, 7, 7, 0, 0),
(4, 'Moon Capital', 0, 8, 4, 0, 0),
(5, 'Pensive Grindstone', 0, 7, 10, 0, 0),
(6, 'Morose Joe', 3, 5, 9, 0, 0),
(7, 'Assault and Smith', 5, 6, 8, 0, 0),
(8, 'Radiant Bit', 5, 5, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `races`
--

CREATE TABLE `races` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `done` tinyint(1) NOT NULL,
  `steps` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `races`
--

INSERT INTO `races` (`id`, `done`, `steps`) VALUES
(1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `horses`
--
ALTER TABLE `horses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `races`
--
ALTER TABLE `races`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `horses`
--
ALTER TABLE `horses`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `races`
--
ALTER TABLE `races`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
