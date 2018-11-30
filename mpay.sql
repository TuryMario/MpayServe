-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 29, 2018 at 08:51 AM
-- Server version: 5.7.24-0ubuntu0.16.04.1
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mpay`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `AccountNumber` int(25) NOT NULL,
  `AccountName` varchar(225) NOT NULL,
  `AccountType` varchar(25) NOT NULL,
  `UserId` varchar(25) NOT NULL,
  `TransactionId` varchar(25) NOT NULL,
  `Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`AccountNumber`, `AccountName`, `AccountType`, `UserId`, `TransactionId`, `Created`) VALUES
(1234, 'mariotury', '', '', '', '2018-11-26 11:17:55'),
(12345, 'Tury', '', '', '', '2018-11-26 11:17:55');

-- --------------------------------------------------------

--
-- Table structure for table `transactionLogs`
--

CREATE TABLE `transactionLogs` (
  `TransactionId` int(225) NOT NULL,
  `TransactionType` varchar(225) NOT NULL,
  `TransactionStatus` varchar(25) NOT NULL,
  `TransactionCode` varchar(25) NOT NULL,
  `Created` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `Modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactionLogs`
--

INSERT INTO `transactionLogs` (`TransactionId`, `TransactionType`, `TransactionStatus`, `TransactionCode`, `Created`, `Modified`) VALUES
(1234, 'Withdraw', 'OK', '345', '2018-11-28 14:06:43', '2018-11-28 12:06:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserName` varchar(225) NOT NULL,
  `FirstName` varchar(225) NOT NULL,
  `LastName` varchar(225) NOT NULL,
  `DoB` date NOT NULL,
  `Email` varchar(25) NOT NULL,
  `AccountType` varchar(25) NOT NULL,
  `Mobile` varchar(25) NOT NULL,
  `Gender` varchar(25) NOT NULL,
  `UserId` varchar(25) NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactionLogs`
--
ALTER TABLE `transactionLogs`
  ADD PRIMARY KEY (`TransactionId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactionLogs`
--
ALTER TABLE `transactionLogs`
  MODIFY `TransactionId` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1235;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
