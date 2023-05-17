-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2023 at 11:11 AM
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
-- Database: `pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `fullname`, `email`) VALUES
('admin1', 'password1', 'Admin1', 'admin1@gmail.com'),
('admin2', 'password2', 'Admin2', 'admin2@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(50) NOT NULL,
  `c_address` varchar(100) DEFAULT NULL,
  `c_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`c_id`, `c_name`, `c_address`, `c_number`) VALUES
(1, 'Suman Sharma', 'Kathmandu', '+977-9841000001'),
(2, 'Bikash Rai', 'Pokhara', '+977-9841000002'),
(3, 'Kamal Shah', 'Biratnagar', '+977-9841000003'),
(4, 'Anita KC', 'Butwal', '+977-9841000004'),
(9, 'Anjana Rai', 'Ithari', '+977-9841000005'),
(15, 'Rita Tamang', 'Chitwan', '+977-9841000000'),
(17, 'Amit Thapa', 'Lamjung', '+977-9841000007'),
(18, 'Sarita Rai', 'Bhojpur', '+977-9841000008'),
(19, 'Suresh KC', 'Sindhuli', '+977-9841000009'),
(21, 'Prajwal Rawal', 'Kailali', '+977- 9823456432'),
(23, 'Sujan Shrestha', 'Udayapur', '+977-9842073745'),
(35, 'asdfda', 'sadfasdf', '45253453'),
(36, 'gfdgsdf', 'gsdfgsdf', '+97834524'),
(38, 'asdfasdf', 'safdasdf', '4253435'),
(39, 'asfasdf', 'sadfsadf', '42535423'),
(41, 'Suman shrestha', 'Dfasdf', '9876543456');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `i_id` int(11) NOT NULL,
  `c_name` varchar(50) NOT NULL,
  `invoice_date` date DEFAULT curdate(),
  `total` decimal(10,2) DEFAULT NULL,
  `discount` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`i_id`, `c_name`, `invoice_date`, `total`, `discount`) VALUES
(1, 'Suman Sharma', '2023-04-20', '5000.00', '100.00'),
(2, 'Bikash Rai', '2023-04-20', '3500.00', '50.00'),
(3, 'Kamal Shah', '2023-04-20', '7500.00', '150.00'),
(4, 'Anita KC', '2023-04-20', '10000.00', '200.00');

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `med_id` int(11) NOT NULL,
  `med_name` varchar(50) DEFAULT NULL,
  `med_pack` varchar(20) DEFAULT NULL,
  `generic_name` varchar(50) DEFAULT NULL,
  `s_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`med_id`, `med_name`, `med_pack`, `generic_name`, `s_name`) VALUES
(5, 'Paracetamol', '10 x 1', 'Acetaminophen', 'Himalayan Pharmaceuticals'),
(6, 'Aspirin', '10 x 1', 'Acetylsalicylic acid', 'Nepal Pharmaceuticals'),
(7, 'Amoxicillin', '10 x 1', 'Amoxicillin', 'Everest Pharmaceuticals'),
(8, 'Ibuprofen', '10 x 1', 'Ibuprofen', 'ABC Pharmaceuticals'),
(9, 'Cefixime', '10 x 1', 'Cefixime', 'ABC Pharmaceuticals'),
(10, 'Levocetirizine', '10 x 1', 'Levocetirizine', 'Nepal Pharmaceuticals'),
(11, 'Esomeprazole', '10 x 1', 'Esomeprazole', 'Everest Pharmaceuticals'),
(12, 'Pantoprazole', '10 x 1', 'Pantoprazole', 'Himalayan Pharmaceuticals'),
(13, 'Omeprazole', '10 x 1', 'Omeprazole', 'Nepal Pharmaceuticals'),
(1001, 'flex', '1 x 10', 'flexion', 'Nepal Pharmaceuticals'),
(1012, 'fmgflkj', 'bvv,', 'flexion', 'ABC Pharmaceuticals'),
(1015, 'Parac', '1 x 10', 'Acetylsalicylic acid', 'Everest Pharmaceuticals'),
(1017, 'dfasdf', '1 x 10', 'ssssss', 'Himalayan Pharmaceuticals');

-- --------------------------------------------------------

--
-- Table structure for table `medicine_stock`
--

CREATE TABLE `medicine_stock` (
  `stock_id` int(11) NOT NULL,
  `med_name` varchar(50) DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `mrp` decimal(10,2) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine_stock`
--

INSERT INTO `medicine_stock` (`stock_id`, `med_name`, `exp_date`, `qty`, `mrp`, `rate`) VALUES
(1, 'Paracetamol', '2023-07-30', 100, '10.00', '8.50'),
(2, 'Aspirin', '2023-09-30', 150, '15.00', '12.50'),
(3, 'Amoxicillin', '2023-12-31', 75, '20.00', '17.50'),
(4, 'Ibuprofen', '2024-03-31', 200, '25.00', '20.00'),
(37, 'Cefixime', '2024-05-31', 50, '30.00', '25.00'),
(1001, 'Aspirin', '2023-05-31', 100, '10.00', '10.00'),
(1002, 'Levocetirizine', '2023-04-06', 200, '100.00', '20.00'),
(1003, 'Pantoprazole', '2023-05-27', 20, '20.00', '24.00'),
(1004, 'Pantoprazole', '2023-05-27', 20, '20.00', '24.00'),
(1005, 'Pantoprazole', '2023-05-19', 100, '20.00', '24.00'),
(1006, 'Pantoprazole', '2023-05-27', 100, '10.00', '24.00'),
(1007, 'Pantoprazole', '2023-05-27', 100, '24.00', '24.00'),
(1008, 'Parac', '2023-05-27', 10024, '10.00', '24.00'),
(1009, 'Pantoprazole', '2023-05-27', 34, '32.00', '34.00');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `p_id` int(11) NOT NULL,
  `s_name` varchar(50) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`p_id`, `s_name`, `invoice_number`, `purchase_date`, `total`) VALUES
(1, 'ABC Pharmaceuticals', 0, '2023-04-20', '5000.00'),
(2, 'Everesdafdf', 0, '2023-04-20', '3500.00'),
(3, 'Himalayan Pharmaceuticals', 0, '2023-04-20', '7500.00'),
(9, 'Nepal Pharmaceuticals', 200, '2023-05-08', '0.00'),
(10, 'Mars Pharmacy', 231, '2023-05-08', '0.00'),
(11, 'Sunrise Pharmaceuticals', 3244, '2023-05-08', '0.00'),
(14, 'Nepal Pharmaceuticals', 352425, '2023-05-08', '3000.00');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(50) NOT NULL,
  `s_email` varchar(50) NOT NULL,
  `s_number` varchar(20) NOT NULL,
  `s_address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`s_id`, `s_name`, `s_email`, `s_number`, `s_address`) VALUES
(1, 'ABC Pharmaceuticals', 'abcpharma@gmail.com', '+977-1-4444444', 'Kathmandu'),
(2, 'Nepal Pharmaceuticals', 'nepalpharma@gmail.com', '+977-1-5555555', 'Lalitpur'),
(3, 'Everest Pharmaceuticals', 'everestpharma@gmail.com', '+977-1-6666666', 'Bhaktapur'),
(4, 'Himalayan Pharmaceuticals', 'himalayanpharma@gmail.com', '+977-1-7777777', 'Kathmandu'),
(5, 'Sunrise Pharmaceuticals', 'sunrisepharma@gmail.com', '+977-1-8888888', 'Lalitpur'),
(6, 'Sagarmatha Pharmaceuticals', 'sagarmathapharma@gmail.com', '+977-1-9999999', 'Bhaktapur'),
(7, 'Mars Pharmacy', 'marspharmacy@gmail.com', '+977-1-1111111', 'Kathmandu'),
(19, 'Everesdafdf', 'asdfadf', 'sdfasdf', 'asdfasdf'),
(21, 'Ja Raj Tuladhar', 'ha@gmail.com', '983232324', 'Bhaktapur');

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
  ADD UNIQUE KEY `c_number` (`c_number`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`i_id`),
  ADD KEY `invoice_ibfk_1` (`c_name`);

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
  ADD KEY `medicine_stock_ibfk_1` (`med_name`);

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
  ADD UNIQUE KEY `s_email` (`s_email`),
  ADD UNIQUE KEY `s_number` (`s_number`),
  ADD UNIQUE KEY `s_name` (`s_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `med_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1020;

--
-- AUTO_INCREMENT for table `medicine_stock`
--
ALTER TABLE `medicine_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1010;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`c_name`) REFERENCES `customer` (`c_name`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `medicine`
--
ALTER TABLE `medicine`
  ADD CONSTRAINT `medicine_ibfk_1` FOREIGN KEY (`s_name`) REFERENCES `suppliers` (`s_name`);

--
-- Constraints for table `medicine_stock`
--
ALTER TABLE `medicine_stock`
  ADD CONSTRAINT `medicine_stock_ibfk_1` FOREIGN KEY (`med_name`) REFERENCES `medicine` (`med_name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
