-- phpMyAdmin SQL Dump
-- version 4.3.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 01, 2015 at 04:44 AM
-- Server version: 5.6.23
-- PHP Version: 5.6.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `IOU_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `LOANS`
--

CREATE TABLE IF NOT EXISTS `LOANS` (
  `LID` int(11) NOT NULL,
  `1UID` int(11) NOT NULL,
  `2UID` int(11) NOT NULL,
  `GLID` varchar(32) COLLATE utf8_bin NOT NULL,
  `amount` double NOT NULL,
  `completed` date DEFAULT NULL,
  `due_date` date NOT NULL,
  `description` text COLLATE utf8_bin,
  `interest` double NOT NULL DEFAULT '0',
  `inflation` double NOT NULL DEFAULT '0',
  `consequences` text COLLATE utf8_bin,
  `flag` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE IF NOT EXISTS `USERS` (
  `UID` bigint(20) NOT NULL,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `paid_on_time` int(11) DEFAULT '0',
  `not_paid_on_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `USERS`
--

INSERT INTO `USERS` (`UID`, `name`, `paid_on_time`, `not_paid_on_time`) VALUES
(760907277311492, 'Jacek Karwowski', 0, 0),
(868779379811697, 'Bandi Enkhamgalan', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `LOANS`
--
ALTER TABLE `LOANS`
  ADD PRIMARY KEY (`LID`), ADD KEY `1UID` (`1UID`,`2UID`,`GLID`), ADD KEY `1UID_2` (`1UID`,`2UID`);

--
-- Indexes for table `USERS`
--
ALTER TABLE `USERS`
  ADD PRIMARY KEY (`UID`), ADD UNIQUE KEY `username` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `LOANS`
--
ALTER TABLE `LOANS`
  MODIFY `LID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
