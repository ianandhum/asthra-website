-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 30, 2017 at 11:42 AM
-- Server version: 5.7.20-0ubuntu0.16.04.1-log
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asthra_users`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sandbox_user`
--

DROP TABLE IF EXISTS `tbl_sandbox_user`;
CREATE TABLE `tbl_sandbox_user` (
  `userId` varchar(25) NOT NULL,
  `userPass` varchar(100) NOT NULL,
  `userFullName` varchar(100) NOT NULL,
  `userEmail` varchar(200) NOT NULL,
  `userFirstName` varchar(50) DEFAULT NULL,
  `userLastName` varchar(50) DEFAULT NULL,
  `phoneNumber` varchar(13) DEFAULT NULL,
  `collegeId` varchar(30) DEFAULT NULL,
  `activationCode` varchar(100) NOT NULL,
  `status` enum('MAIL_SENT','VERIFIED','DEFAULT','ACTIVE') NOT NULL DEFAULT 'DEFAULT',
  `extra` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE `tbl_users` (
  `userId` varchar(30) NOT NULL,
  `userEmail` varchar(200) NOT NULL,
  `userPass` varchar(100) NOT NULL,
  `sessionKey` varchar(100) NOT NULL DEFAULT 'empty',
  `userFullName` varchar(50) NOT NULL,
  `accessLevel` enum('PLVL01','PLVL02','PLVL03','PLVL04','PLVL05') NOT NULL,
  `userType` varchar(15) NOT NULL,
  `loggedIn` enum('Y','N') NOT NULL DEFAULT 'N',
  `deviceType` enum('DEV_WEB_STD','DEV_ANDROID_APP','DEV_DATA_FETCH','DEV_DEFAULT') NOT NULL,
  `state` enum('READY','RESET_REQUESTED','DISABLED') NOT NULL DEFAULT 'READY',
  `editCode` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userId`, `userEmail`, `userPass`, `sessionKey`, `userFullName`, `accessLevel`, `userType`, `loggedIn`, `deviceType`, `state`, `editCode`) VALUES
('userID5a1442b3c4dc', 'anandhu@asthra.com', '1be71662837d252d84398b0c1c771efc', 'empty', 'Anandhu Manoj', 'PLVL05', 'admin', 'N', 'DEV_DATA_FETCH', 'READY', NULL),
('userID5a1442b3c7dfe', 'admin@asthra.com', 'ba50cd7e74821d5f45743f236da0279d', 'empty', 'Anandhu Manoj', 'PLVL04', 'admin', 'N', 'DEV_DATA_FETCH', 'READY', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_sandbox_user`
--
ALTER TABLE `tbl_sandbox_user`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `userEmail` (`userEmail`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `userEmail` (`userEmail`),
  ADD UNIQUE KEY `userId` (`userId`),
  ADD KEY `userEmail_2` (`userEmail`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
