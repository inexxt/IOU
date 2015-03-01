-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 01, 2015 at 02:06 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

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
  `completed` date NOT NULL,
  `due_date` date NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `interest` double NOT NULL,
  `inflation` double NOT NULL,
  `consequences` text COLLATE utf8_bin NOT NULL,
  `flag` enum('NEW','CHANGED','','') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE IF NOT EXISTS `USERS` (
`UID` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `paid_on_time` int(11) DEFAULT '0',
  `not_paid_on_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
--
-- AUTO_INCREMENT for table `USERS`
--
ALTER TABLE `USERS`
MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
