-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 28, 2025 at 03:02 AM
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
-- Database: `mercedes_ois`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `client` varchar(100) NOT NULL,
  `announcement_no` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `sysentrydate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedby` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_details`
--

CREATE TABLE `customer_details` (
  `client` varchar(100) NOT NULL,
  `accountnumber` varchar(100) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `longitude` varchar(100) DEFAULT NULL,
  `latitude` varchar(100) DEFAULT NULL,
  `customer_tag` varchar(100) DEFAULT NULL,
  `lot_number` varchar(50) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `sysentrydate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedby` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `client` varchar(100) NOT NULL,
  `event_no` varchar(100) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_description` varchar(255) DEFAULT NULL,
  `event_type` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `event_status` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `initiated_by` varchar(100) DEFAULT NULL,
  `sysentrydate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedby` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `client` varchar(100) NOT NULL,
  `property_no` varchar(100) NOT NULL,
  `property_code` varchar(100) NOT NULL,
  `property_name` varchar(100) DEFAULT NULL,
  `property_type` varchar(100) DEFAULT NULL,
  `lot_no` varchar(100) DEFAULT NULL,
  `block_no` varchar(100) DEFAULT NULL,
  `property_status` varchar(100) DEFAULT NULL,
  `date_occupied` date DEFAULT NULL,
  `initial_date_used` date DEFAULT NULL,
  `property_tag` varchar(100) DEFAULT NULL,
  `sysentrydate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedby` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `client` varchar(100) NOT NULL,
  `request_no` varchar(100) NOT NULL,
  `requested_by` varchar(100) NOT NULL,
  `request_type` varchar(100) NOT NULL,
  `request_title` varchar(100) DEFAULT NULL,
  `request_description` varchar(100) DEFAULT NULL,
  `requested_date` date DEFAULT NULL,
  `date_resolved` date DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `sysentrydate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedby` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requirements`
--

CREATE TABLE `requirements` (
  `client` varchar(100) NOT NULL,
  `accountnumber` varchar(100) NOT NULL,
  `document_code` varchar(100) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `filetype` varchar(100) DEFAULT NULL,
  `filesize` varchar(100) DEFAULT NULL,
  `filepath` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `sysentrydate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedby` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `client` varchar(100) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `accountnumber` varchar(100) NOT NULL,
  `item_id` varchar(100) DEFAULT NULL,
  `price` varchar(100) DEFAULT NULL,
  `amount_paid` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `classification` varchar(100) DEFAULT NULL,
  `transaction_type` varchar(100) DEFAULT NULL,
  `transaction_paid` varchar(100) DEFAULT NULL,
  `transaction_balance` varchar(100) DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `discount1` varchar(100) DEFAULT NULL,
  `discount2` varchar(100) DEFAULT NULL,
  `vat` varchar(100) DEFAULT NULL,
  `adjustments` varchar(100) DEFAULT NULL,
  `overpayment` varchar(100) DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `sysentrydate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedby` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `client` varchar(100) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `sysentrydate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedby` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`client`, `user_id`, `username`, `password`, `firstname`, `middlename`, `lastname`, `role`, `sysentrydate`, `modifieddate`, `modifiedby`) VALUES
('mercedes', 1, 'chein', 'chein123', 'CHEIN IAN', 'SALUDES', 'PARAS', 'admin', '2025-08-27 11:47:36', '2025-08-27 14:07:56', 'CIP-000001'),
('mercedes', 2, 'ejay', 'ejay123', 'emmard', 'salih', 'balina', 'user', '2025-08-27 13:59:25', '2025-08-27 14:08:09', 'ejsb-0001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`client`,`announcement_no`);

--
-- Indexes for table `customer_details`
--
ALTER TABLE `customer_details`
  ADD PRIMARY KEY (`client`,`accountnumber`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`client`,`event_no`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`client`,`property_no`,`property_code`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`client`,`request_no`);

--
-- Indexes for table `requirements`
--
ALTER TABLE `requirements`
  ADD PRIMARY KEY (`client`,`accountnumber`,`document_code`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`client`,`transaction_id`,`accountnumber`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
