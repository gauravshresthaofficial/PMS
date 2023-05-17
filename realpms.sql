-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2023 at 07:42 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(255) DEFAULT NULL,
  `c_address` varchar(255) DEFAULT NULL,
  `c_number` varchar(255) DEFAULT NULL,
  `c_email` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`c_id`, `c_name`, `c_address`, `c_number`, `c_email`, `active`) VALUES
(0, 'Bikram', 'Ewrewr', '9842132453', 'BIKRAM@gmail.com', 1),
(1, 'Ram', 'Kathmandu, Nepal', '9843210000', 'ram@email.com', 1),
(2, 'Sita', 'Pokhara, Nepal', '9843211111', 'sita@email.com', 1),
(3, 'Laxman', 'Chitwan, Nepal', '9843212222', 'laxman@email.com', 1),
(4, 'Hari', 'Biratnagar, Nepal', '9843213333', 'hari@email.com', 1),
(5, 'Krishna', 'Dharan, Nepal', '9843214444', 'krishna@email.com', 1),
(6, 'rrrrrrrrrr', 'rrrrrrrrrrrrrrr', '9876543234', 'asdfasd@gmail.com', 0),
(7, 'Asdfasdf', 'Sdfasdf', '9876543213', 'sdfasdfa@gas.vom', 0),
(8, 'sdfasdfasdf', 'sdfasdfasdf', NULL, 'sdfasdfasdfa', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `c_name` (`c_name`),
  ADD UNIQUE KEY `c_email` (`c_email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
