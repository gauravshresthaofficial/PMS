-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2023 at 07:43 PM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `fullname`, `email`) VALUES
('admin1', 'password1', 'Ram', 'ram@email.com'),
('admin2', 'password456', 'Sita', 'sita@email.com'),
('admin3', 'password789', 'Laxman', 'laxman@email.com'),
('admin4', 'password1234', 'Hari', 'hari@email.com'),
('admin5', 'password54321', 'Krishna', 'krishna@email.com');

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

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `i_id` int(11) NOT NULL,
  `c_name` varchar(255) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`i_id`, `c_name`, `invoice_date`, `total`, `discount`) VALUES
(1, 'Ram', '2023-05-01', '100.00', '0.00'),
(2, 'Sita', '2023-05-02', '80.00', '5.00'),
(3, 'Laxman', '2023-05-03', '60.00', '10.00'),
(4, 'Hari', '2023-06-01', '100.00', '0.00'),
(5, 'Krishna', '2023-06-02', '80.00', '5.00');

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `med_id` int(11) NOT NULL,
  `med_name` varchar(255) DEFAULT NULL,
  `med_pack` varchar(255) DEFAULT NULL,
  `generic_name` varchar(255) DEFAULT NULL,
  `s_name` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`med_id`, `med_name`, `med_pack`, `generic_name`, `s_name`, `deleted`) VALUES
(1, 'Paracetamol', 'Tablets', 'Acetaminophen', 'Cg Corp', 0),
(2, 'Ibuprofen', 'Capsules', 'Ibuprofen', 'Yeti Pharma', 0),
(3, 'Dolo 650', 'Tablets', 'Paracetamol', 'Himalaya Corp', 0),
(4, 'Brufen', 'Capsules', 'Ibuprofen', 'Sagarmatha Pharma', 0);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_stock`
--

CREATE TABLE `medicine_stock` (
  `stock_id` int(11) NOT NULL,
  `med_name` varchar(255) DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `mrp` decimal(10,2) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine_stock`
--

INSERT INTO `medicine_stock` (`stock_id`, `med_name`, `exp_date`, `qty`, `mrp`, `rate`) VALUES
(1, 'Paracetamol', '2023-06-01', 100, '10.00', '5.00'),
(2, 'Ibuprofen', '2023-07-01', 50, '8.00', '4.00'),
(3, 'Dolo 650', '2023-07-01', 100, '10.00', '5.00'),
(4, 'Brufen', '2023-08-01', 50, '8.00', '4.00');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `p_id` int(11) NOT NULL,
  `s_name` varchar(255) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`p_id`, `s_name`, `invoice_number`, `purchase_date`, `total`) VALUES
(1, 'Cg Corp', '123456789', '2023-05-01', '100.00'),
(2, 'Yeti Pharma', '987654321', '2023-05-02', '80.00'),
(3, 'Sunrise Pharma', '543210987', '2023-05-03', '60.00'),
(4, 'Himalaya Corp', '123456789', '2023-06-01', '100.00'),
(5, 'Sagarmatha Pharma', '987654321', '2023-06-02', '80.00');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(255) DEFAULT NULL,
  `s_email` varchar(255) DEFAULT NULL,
  `s_number` varchar(255) DEFAULT NULL,
  `s_address` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`s_id`, `s_name`, `s_email`, `s_number`, `s_address`, `active`) VALUES
(0, 'Gaurav Shrestha', 'gaurav@gmail.com', '9842161086', 'Morang', 1),
(1, 'Cg Corp', 'cgcorp@email.com', '9843210000', 'Kathmandu, Nepal', 1),
(2, 'Yeti Pharma', 'yetipharma@email.com', '9843211111', 'Pokhara, Nepal', 1),
(3, 'Sunrise Pharma', 'sunrisepharma@email.com', '9843212222', 'Chitwan, Nepal', 1),
(4, 'Himalaya Corp', 'himalayacorp@email.com', '9843213333', 'Biratnagar, Nepal', 1),
(5, 'Sagarmatha Pharma', 'sagarmathapharma@email.com', '9843214444', 'Dharan, Nepal', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `c_name` (`c_name`),
  ADD UNIQUE KEY `c_email` (`c_email`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`i_id`),
  ADD KEY `c_name` (`c_name`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`med_id`),
  ADD UNIQUE KEY `med_name` (`med_name`),
  ADD KEY `s_name` (`s_name`);

--
-- Indexes for table `medicine_stock`
--
ALTER TABLE `medicine_stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `med_name` (`med_name`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `s_name` (`s_name`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`s_id`),
  ADD UNIQUE KEY `s_name` (`s_name`),
  ADD UNIQUE KEY `s_email` (`s_email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`c_name`) REFERENCES `customer` (`c_name`) ON UPDATE CASCADE;

--
-- Constraints for table `medicine`
--
ALTER TABLE `medicine`
  ADD CONSTRAINT `medicine_ibfk_1` FOREIGN KEY (`s_name`) REFERENCES `suppliers` (`s_name`) ON UPDATE CASCADE;

--
-- Constraints for table `medicine_stock`
--
ALTER TABLE `medicine_stock`
  ADD CONSTRAINT `medicine_stock_ibfk_1` FOREIGN KEY (`med_name`) REFERENCES `medicine` (`med_name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `medicine_stock_ibfk_2` FOREIGN KEY (`med_name`) REFERENCES `medicine` (`med_name`) ON UPDATE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`s_name`) REFERENCES `suppliers` (`s_name`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
