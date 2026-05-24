-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2026 at 01:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `icfl_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `blood_group` varchar(5) NOT NULL DEFAULT '',
  `position` varchar(20) NOT NULL DEFAULT '',
  `play_for` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `name`, `created_at`, `blood_group`, `position`, `play_for`) VALUES
(7, 'goat ronaldo', '2026-05-11 16:29:08', 'goat+', 'entire field', 'madrid'),
(1234, 'messi', '2026-05-11 15:07:21', 'b+', 'lb', 'fcb'),
(3336, 'mahabub', '2026-05-12 08:38:52', 'c+', 'RB', 'madrid'),
(3338, 'zaman', '2026-05-12 08:41:23', 'l+', 'gk', 'atm');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `team_id` int(11) NOT NULL,
  `team_name` varchar(100) NOT NULL,
  `goal_score` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `match_played` int(11) NOT NULL DEFAULT 0,
  `win_match` int(11) NOT NULL DEFAULT 0,
  `loss_match` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`team_id`, `team_name`, `goal_score`, `created_at`, `match_played`, `win_match`, `loss_match`) VALUES
(5, 'atm', 1, '2026-05-12 08:40:24', 1, 1, 0),
(6, 'venom', 2, '2026-05-20 03:36:58', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `team_registration`
--

CREATE TABLE `team_registration` (
  `id` int(11) NOT NULL,
  `team_name` varchar(255) NOT NULL,
  `team_id` varchar(255) NOT NULL,
  `team_owner` varchar(255) NOT NULL,
  `team_fair_prize` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_registration`
--

INSERT INTO `team_registration` (`id`, `team_name`, `team_id`, `team_owner`, `team_fair_prize`, `created_at`) VALUES
(1, 'venom ', 've-242', 'Ikra', '5000', '2026-05-20 03:12:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `team_registration`
--
ALTER TABLE `team_registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `team_registration`
--
ALTER TABLE `team_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
