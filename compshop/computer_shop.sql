-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 09:42 AM
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
-- Database: `computer_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_table`
--

CREATE TABLE `active_table` (
  `active_index` bigint(100) NOT NULL,
  `request_id` bigint(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `active_table`
--

INSERT INTO `active_table` (`active_index`, `request_id`) VALUES
(21, 50);

-- --------------------------------------------------------

--
-- Table structure for table `request_table`
--

CREATE TABLE `request_table` (
  `request_index` bigint(100) NOT NULL,
  `request_id` bigint(100) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `timestamp` time(1) NOT NULL,
  `file_upload` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_table`
--

INSERT INTO `request_table` (`request_index`, `request_id`, `service_type`, `customer_name`, `timestamp`, `file_upload`) VALUES
(50, 0, 'Printing', 'asddas', '15:30:00.0', '../docs/'),
(51, 50, 'Printing', 'asd', '14:00:00.0', '../docs/');

-- --------------------------------------------------------

--
-- Table structure for table `service_table`
--

CREATE TABLE `service_table` (
  `service_index` bigint(100) NOT NULL,
  `service_id` bigint(100) NOT NULL,
  `service_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_table`
--

INSERT INTO `service_table` (`service_index`, `service_id`, `service_type`) VALUES
(2, 102, 'Typing Job'),
(4, 101, 'Printing'),
(5, 104, 'Passport Booking');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee') NOT NULL DEFAULT 'employee',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'firstadmin', 'davesales27@gmail.com', '$2y$10$n5duZk2zhMIPqsjIRLCjgeClzb8XiufA4FD8PoLKmDT8pzzv8CmHW', 'admin', '2025-05-16 01:18:04'),
(4, 'TitoBadang', 'ziobeppe82@gmail.com', '$2y$10$w6kkJbsxCn2YENgTFZUXCuiiXZyT56W6s1p8vLJgUmDVvUmvB7IDG', 'admin', '2025-05-16 06:36:38'),
(5, 'VictorBatongBakal', 'ewan@gmail.com', '$2y$10$j1zTX326Bl0Ota/XwUH7WuUncFNRagl50aHdUfFHP9kI2wsRREkJ.', 'employee', '2025-05-16 09:42:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_table`
--
ALTER TABLE `active_table`
  ADD PRIMARY KEY (`active_index`),
  ADD KEY `request_id_fk` (`request_id`);

--
-- Indexes for table `request_table`
--
ALTER TABLE `request_table`
  ADD PRIMARY KEY (`request_index`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `servicecons` (`service_type`);

--
-- Indexes for table `service_table`
--
ALTER TABLE `service_table`
  ADD PRIMARY KEY (`service_index`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `service_type` (`service_type`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_table`
--
ALTER TABLE `active_table`
  MODIFY `active_index` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `request_table`
--
ALTER TABLE `request_table`
  MODIFY `request_index` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `service_table`
--
ALTER TABLE `service_table`
  MODIFY `service_index` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `active_table`
--
ALTER TABLE `active_table`
  ADD CONSTRAINT `request_id_fk` FOREIGN KEY (`request_id`) REFERENCES `request_table` (`request_id`);

--
-- Constraints for table `request_table`
--
ALTER TABLE `request_table`
  ADD CONSTRAINT `servicecons` FOREIGN KEY (`service_type`) REFERENCES `service_table` (`service_type`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
