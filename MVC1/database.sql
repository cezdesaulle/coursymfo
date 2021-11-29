-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 10, 2020 at 10:20 AM
-- Server version: 5.7.26
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `wf3_php_final_thomas`
--

-- --------------------------------------------------------

--
-- Table structure for table `contest`
--

CREATE TABLE `contest` (
  `id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `winner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contest`
--

INSERT INTO `contest` (`id`, `game_id`, `start_date`, `winner_id`) VALUES
(1, 23, '2019-12-25 00:00:00', 2),
(2, 25, '2020-12-25 00:00:00', NULL),
(3, 23, '2020-09-10 13:30:00', NULL),
(4, 23, '2020-09-10 13:30:00', NULL),
(5, 23, '2020-09-26 10:48:00', NULL),
(6, 23, '2020-09-01 10:48:00', NULL),
(7, 5, '2020-09-26 11:05:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `min_players` int(11) NOT NULL,
  `max_players` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`id`, `title`, `min_players`, `max_players`) VALUES
(5, '7 Wonders Duel', 2, 2),
(6, 'fdsdf', 2, 98),
(23, '7 Wonders', 2, 7),
(24, 'Ticket to Ride', 2, 5),
(25, 'Pandemic', 2, 4),
(26, 'Munchkin', 3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `email`, `nickname`) VALUES
(1, 'luke.skywalker@rogue.sw', 'Luke'),
(2, 'amidala.padme@naboo.gov', 'Padme'),
(3, 'han.solo@millenium-falcon.com', 'HanSolo'),
(4, 'chewbacca@wook.ie', 'Chewbie'),
(5, 'rey@jakku.planet', 'Rey'),
(6, 'john@doe.com', 'johndoe'),
(7, 'test@tes.co', 'tgsdf');

-- --------------------------------------------------------

--
-- Table structure for table `player_contest`
--

CREATE TABLE `player_contest` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `contest_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `player_contest`
--

INSERT INTO `player_contest` (`id`, `player_id`, `contest_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(5, 5, 1),
(19, 4, 1),
(20, 4, 2),
(21, 5, 2),
(22, 1, 5),
(24, 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contest`
--
ALTER TABLE `contest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `winner_id` (`winner_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player_contest`
--
ALTER TABLE `player_contest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`),
  ADD KEY `contest_id` (`contest_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contest`
--
ALTER TABLE `contest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `player_contest`
--
ALTER TABLE `player_contest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
