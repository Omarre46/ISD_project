-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql311.infinityfree.com
-- Generation Time: Nov 27, 2024 at 12:27 PM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_37790928_hotel_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `Employees`
--

CREATE TABLE `Employees` (
  `ID` int(200) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Role` varchar(200) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Feedback`
--

CREATE TABLE `Feedback` (
  `ID` int(200) NOT NULL,
  `Guest_ID` int(200) NOT NULL,
  `Comments` varchar(200) NOT NULL,
  `Date_Submit` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Guest`
--

CREATE TABLE `Guest` (
  `ID` int(200) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Phone` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Reservation`
--

CREATE TABLE `Reservation` (
  `ID` int(200) NOT NULL,
  `Room_ID` int(200) NOT NULL,
  `Guest_ID` int(200) NOT NULL,
  `CheckIn` date NOT NULL,
  `CheckOut` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Rooms`
--

CREATE TABLE `Rooms` (
  `ID` int(50) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `Description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Service`
--

CREATE TABLE `Service` (
  `ID` int(200) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Guest_ID` int(200) NOT NULL,
  `Employee_ID` int(200) NOT NULL,
  `Type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Employees`
--
ALTER TABLE `Employees`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Feedback`
--
ALTER TABLE `Feedback`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_guest_id` (`Guest_ID`);

--
-- Indexes for table `Guest`
--
ALTER TABLE `Guest`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Reservation`
--
ALTER TABLE `Reservation`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_Room` (`Room_ID`),
  ADD KEY `FK_Guest` (`Guest_ID`);

--
-- Indexes for table `Rooms`
--
ALTER TABLE `Rooms`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Service`
--
ALTER TABLE `Service`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_guest_id` (`Guest_ID`),
  ADD KEY `fk_employee_id` (`Employee_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Employees`
--
ALTER TABLE `Employees`
  MODIFY `ID` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Feedback`
--
ALTER TABLE `Feedback`
  MODIFY `ID` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Guest`
--
ALTER TABLE `Guest`
  MODIFY `ID` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Reservation`
--
ALTER TABLE `Reservation`
  MODIFY `ID` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Rooms`
--
ALTER TABLE `Rooms`
  MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Service`
--
ALTER TABLE `Service`
  MODIFY `ID` int(200) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Service`
--
ALTER TABLE `Service`
  ADD CONSTRAINT `fk_employee_id` FOREIGN KEY (`Employee_ID`) REFERENCES `Employees` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_guest_id` FOREIGN KEY (`Guest_ID`) REFERENCES `Guest` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
