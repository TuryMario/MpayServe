-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2018 at 09:12 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mpay_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `AccountNumber` varchar(255) NOT NULL,
  `AccountName` varchar(225) NOT NULL,
  `AccountType` varchar(25) NOT NULL,
  `TransactionId` varchar(25) NOT NULL,
  `Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `AccountBalance` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`AccountNumber`, `AccountName`, `AccountType`, `TransactionId`, `Created`, `AccountBalance`) VALUES
('1543509365123136319494210178', 'earl23 mon', 'client', '', '2018-11-29 19:36:05', 3450000),
('1543509481989515864842696187', 'cruz matt', 'client', '', '2018-11-29 19:38:02', 1500000),
('1543562952943218147575940775', 'pixelconsult uganda', 'partner', '', '2018-11-30 10:29:52', 35000000);

-- --------------------------------------------------------

--
-- Table structure for table `transactionlogs`
--

CREATE TABLE `transactionlogs` (
  `id` int(225) NOT NULL,
  `TransactionType` varchar(225) NOT NULL,
  `TransactionStatus` varchar(25) NOT NULL,
  `TransactionCode` varchar(25) NOT NULL,
  `Created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `Modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` varchar(255) NOT NULL,
  `FirstName` varchar(225) NOT NULL,
  `LastName` varchar(225) NOT NULL,
  `Email` varchar(25) NOT NULL,
  `AccountType` varchar(25) NOT NULL,
  `Mobile` varchar(25) NOT NULL,
  `Gender` varchar(25) NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `AccountNumber` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `FirstName`, `LastName`, `Email`, `AccountType`, `Mobile`, `Gender`, `Created`, `AccountNumber`) VALUES
('4OEzyTBWVnVViDKNoFRcd1SCUc13', 'cruz', 'matt', 'cruz256@gmail.com', 'client', '0789 232343', '', '2018-11-29 16:38:02', '1543509481989515864842696187'),
('Y24RSSVJjPUGisqS3sCC8gNGzpp1', 'earl23', 'mon', 'earl23@gmail.com', 'client', '221321', '', '2018-11-29 16:36:05', '1543509365123136319494210178');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`AccountNumber`);

--
-- Indexes for table `transactionlogs`
--
ALTER TABLE `transactionlogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactionlogs`
--
ALTER TABLE `transactionlogs`
  MODIFY `id` int(225) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
