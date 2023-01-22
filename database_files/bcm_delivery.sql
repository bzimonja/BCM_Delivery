-- phpMyAdmin SQL Dump
-- version 5.1.4deb2+focal1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 22, 2023 at 05:34 AM
-- Server version: 8.0.31-0ubuntu0.20.04.2
-- PHP Version: 8.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bcm_delivery`
--

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `id` int NOT NULL,
  `driver_first_name` varchar(45) DEFAULT NULL,
  `driver_last_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`id`, `driver_first_name`, `driver_last_name`) VALUES
(1, 'Bob', 'Zhang'),
(2, 'Yunus', 'Nash'),
(3, 'Alia', 'Sharpe'),
(4, 'Macauley', 'Odling'),
(5, 'Emilio', 'Norton'),
(6, 'Austin', 'Vasquez'),
(7, 'Rocco', 'Potter'),
(8, 'Syed', 'Harper'),
(9, 'Carl', 'Valdez'),
(10, 'Aleeza', 'Petty'),
(11, 'Eliza', 'Garza'),
(12, 'Hajra', 'Cruz');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int NOT NULL,
  `status_label` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status_label`) VALUES
(1, 'Loading at warehouse'),
(2, 'Outbound for deliveries'),
(3, 'Returning to warehouse'),
(4, 'Maintenance'),
(5, 'Other (see note)');

-- --------------------------------------------------------

--
-- Stand-in structure for view `status_overview`
-- (See below for the actual view)
--
CREATE TABLE `status_overview` (
`truck_id` int
,`truck_label` varchar(45)
,`status_id` int
,`status_label` varchar(45)
,`driver_id` int
,`driver_first_name` varchar(45)
,`driver_last_name` varchar(45)
,`note` varchar(500)
);

-- --------------------------------------------------------

--
-- Table structure for table `truck`
--

CREATE TABLE `truck` (
  `id` int NOT NULL,
  `truck_label` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `truck`
--

INSERT INTO `truck` (`id`, `truck_label`) VALUES
(1, 'Truck 1'),
(2, 'Truck 2'),
(3, 'Truck 3'),
(4, 'Truck 4'),
(5, 'Truck 5'),
(6, 'Truck 6'),
(7, 'Truck 7'),
(8, 'Truck 8');

-- --------------------------------------------------------

--
-- Table structure for table `truck_status`
--

CREATE TABLE `truck_status` (
  `id` int NOT NULL,
  `note` varchar(500) NOT NULL,
  `truck_id` int NOT NULL,
  `status_id` int NOT NULL,
  `driver_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `truck_status`
--

INSERT INTO `truck_status` (`id`, `note`, `truck_id`, `status_id`, `driver_id`) VALUES
(1, '', 1, 1, NULL),
(2, '', 2, 2, 9),
(3, '', 3, 1, 7),
(4, '', 4, 1, 2),
(5, '', 5, 3, 4),
(6, '', 6, 2, 1),
(7, '', 7, 4, 12),
(8, 'On loan for parade.', 8, 5, NULL);

-- --------------------------------------------------------

--
-- Structure for view `status_overview`
--
DROP TABLE IF EXISTS `status_overview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`bcm_delivery_user`@`localhost` SQL SECURITY DEFINER VIEW `status_overview`  AS SELECT `truck_status`.`truck_id` AS `truck_id`, `truck`.`truck_label` AS `truck_label`, `truck_status`.`status_id` AS `status_id`, `status`.`status_label` AS `status_label`, `truck_status`.`driver_id` AS `driver_id`, `driver`.`driver_first_name` AS `driver_first_name`, `driver`.`driver_last_name` AS `driver_last_name`, `truck_status`.`note` AS `note` FROM (((`truck_status` left join `driver` on((`truck_status`.`driver_id` = `driver`.`id`))) join `truck` on((`truck_status`.`truck_id` = `truck`.`id`))) join `status` on((`truck_status`.`status_id` = `status`.`id`)))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `truck`
--
ALTER TABLE `truck`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `truck_label_UNIQUE` (`truck_label`);

--
-- Indexes for table `truck_status`
--
ALTER TABLE `truck_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_truck_status_driver_idx` (`driver_id`),
  ADD KEY `fk_truck_status_truck1_idx` (`truck_id`),
  ADD KEY `fk_truck_status_status1_idx` (`status_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `truck`
--
ALTER TABLE `truck`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `truck_status`
--
ALTER TABLE `truck_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `truck_status`
--
ALTER TABLE `truck_status`
  ADD CONSTRAINT `fk_truck_status_driver` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`),
  ADD CONSTRAINT `fk_truck_status_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `fk_truck_status_truck1` FOREIGN KEY (`truck_id`) REFERENCES `truck` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
