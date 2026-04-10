-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2025 at 03:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `c_ID` int(11) NOT NULL,
  `c_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`c_ID`, `c_name`) VALUES
(1, 'เครื่องเขียน'),
(2, 'อุปกรณ์กีฬา'),
(3, 'เครื่องแบบ'),
(4, 'อุปกรณ์งานฝีมือ');

-- --------------------------------------------------------

--
-- Table structure for table `edit`
--

CREATE TABLE `edit` (
  `p_ID` int(11) NOT NULL,
  `E_ID` int(11) NOT NULL,
  `date_edit` date NOT NULL,
  `time_edit` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `p_ID` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_detail` text DEFAULT NULL,
  `p_price` decimal(10,2) NOT NULL,
  `p_total` int(11) NOT NULL,
  `c_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`p_ID`, `p_name`, `p_detail`, `p_price`, `p_total`, `c_ID`) VALUES
(1, 'ปากกา', 'ปากกาเจล K35 ขนาดหัว 0.5mm ด้ามจับมียางกันลื่น นุ่มสบาย เขียนลื่น ไม่มีสะดุด', 20.00, 10, 1),
(2, 'ลูกขนไก่', 'GRAND SPORT', 35.00, 10, 2),
(3, 'ผ้าพันคอลูกเสือ-เนตรนารี', 'สำหรับลูกเสือและเนตรนารี ระดับมัธยมศึกษา', 50.00, 8, 3),
(4, 'สะดึง', 'ใช้สำหรับปักผ้า', 15.00, 12, 4),
(5, 'ยางลบ', 'STAEDTLER ยางลบ', 5.00, 10, 1),
(6, 'กบเหลาดินสอ', 'Master Art กบเหลาดินสอ', 20.00, 9, 1),
(7, 'ดินสอ', 'STAEDTLER ดินสอ HB', 5.00, 19, 1),
(8, 'ดินสอกด', 'PENTEL ดินสอกด รุ่น Caplet A105 ขนาด 0.5 มม', 30.00, 4, 1),
(9, 'ไส้ดินสอกด', 'PENTAL C275S ไส้ดินสอกด 0.5 มม. 2B ', 12.00, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `p_ID` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sale_id`, `user_id`, `p_ID`, `quantity`, `total_price`, `sale_date`) VALUES
(3, 2, 1, 1, 20.00, '2025-03-19 07:10:41'),
(4, 2, 3, 1, 50.00, '2025-03-22 16:34:15'),
(5, 2, 2, 1, 35.00, '2025-03-22 16:36:07'),
(6, 2, 4, 1, 15.00, '2025-03-22 16:36:07'),
(7, 2, 8, 1, 30.00, '2025-03-23 13:46:09'),
(8, 2, 9, 1, 12.00, '2025-03-23 13:46:09'),
(9, 2, 7, 1, 5.00, '2025-03-23 13:54:57'),
(10, 2, 6, 1, 20.00, '2025-03-23 13:54:57'),
(11, 2, 4, 1, 15.00, '2025-03-23 15:11:20'),
(12, 2, 3, 1, 50.00, '2025-03-23 15:11:20'),
(13, 2, 1, 1, 20.00, '2025-03-26 10:55:47'),
(14, 2, 2, 1, 35.00, '2025-03-26 10:55:47'),
(15, 2, 4, 1, 15.00, '2025-03-26 10:55:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(2, 'admin', '$2y$10$A04YJ1unTh/qUinFArrncOsKX.zHl15aMulqTyHMoHSMqiCbashlu', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`c_ID`);

--
-- Indexes for table `edit`
--
ALTER TABLE `edit`
  ADD PRIMARY KEY (`p_ID`,`E_ID`,`date_edit`,`time_edit`),
  ADD KEY `E_ID` (`E_ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_ID`),
  ADD KEY `c_ID` (`c_ID`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `p_ID` (`p_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `c_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `p_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `edit`
--
ALTER TABLE `edit`
  ADD CONSTRAINT `edit_ibfk_1` FOREIGN KEY (`p_ID`) REFERENCES `product` (`p_ID`),
  ADD CONSTRAINT `edit_ibfk_2` FOREIGN KEY (`E_ID`) REFERENCES `editor` (`E_ID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`c_ID`) REFERENCES `categories` (`c_ID`) ON DELETE SET NULL;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`p_ID`) REFERENCES `product` (`p_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
