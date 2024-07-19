-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2024 at 02:22 PM
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
-- Database: `nhasystem_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` varchar(250) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `sec_year` varchar(255) NOT NULL,
  `reset_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fullname`, `email`, `username`, `password`, `role`, `address`, `gender`, `sec_year`, `reset_token`) VALUES
(18, 'Macky', 'zeninmacky05@gmail.com', 'macky ', '4ea40e393bab5bde47d5ba1b0d9421ae', 'Admin', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `block_lot`
--

CREATE TABLE `block_lot` (
  `id` int(11) NOT NULL,
  `block_number` varchar(255) NOT NULL,
  `lot_number` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `block_lot`
--

INSERT INTO `block_lot` (`id`, `block_number`, `lot_number`, `status`) VALUES
(1, 'Block-10', 1, 'Unoccupied'),
(2, 'Block-10', 2, 'Unoccupied'),
(3, 'Block-11', 1, 'Unoccupied'),
(4, 'Block-11', 2, 'Unoccupied');

-- --------------------------------------------------------

--
-- Table structure for table `profiling`
--

CREATE TABLE `profiling` (
  `id` int(11) NOT NULL,
  `block_number` varchar(255) NOT NULL,
  `lot_number` int(11) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `signature` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiling`
--

INSERT INTO `profiling` (`id`, `block_number`, `lot_number`, `lastname`, `firstname`, `middlename`, `gender`, `barangay`, `remarks`, `status`, `signature`) VALUES
(1, 'Block-10', 1, 'Jose', 'Margie', 'Montebon', 'Female', 'Bunakan', 'sa ', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `block_lot`
--
ALTER TABLE `block_lot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiling`
--
ALTER TABLE `profiling`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `block_lot`
--
ALTER TABLE `block_lot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `profiling`
--
ALTER TABLE `profiling`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
