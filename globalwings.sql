-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 09:11 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `globalwings`
--

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `symbol_no` varchar(50) NOT NULL,
  `graduated_student` varchar(255) NOT NULL,
  `training_period` varchar(100) NOT NULL,
  `issue_date` date NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`symbol_no`, `graduated_student`, `training_period`, `issue_date`, `image_path`) VALUES
('07701122', 'Salina Miya', 'April 26, 2020 - August 25, 2020', '2025-01-21', 'uploads/67e1087d15c6e_kakashi.png'),
('0800745', 'Jyotshna Adhikari', 'October 25, 2022 - February 25, 2023', '2024-12-02', 'uploads/67e0f3c69e6e5_nickfox1.jpg'),
('0810275', 'Bijaya Poudel', 'July 07, 2024 - October 08, 2024', '2025-03-20', 'uploads/67dbe72888f5f_ballackk.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`symbol_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
