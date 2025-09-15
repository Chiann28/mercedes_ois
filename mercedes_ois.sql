-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 15, 2025 at 05:18 PM
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
-- Table structure for table `account_request`
--

CREATE TABLE `account_request` (
  `client` varchar(255) DEFAULT NULL,
  `request_id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `tel_no` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `unittype` varchar(255) DEFAULT NULL,
  `lot_no` varchar(255) DEFAULT NULL,
  `house_no` varchar(255) DEFAULT NULL,
  `ref_fullname` varchar(255) DEFAULT NULL,
  `ref_rel` varchar(255) DEFAULT NULL,
  `ref_mobile_no` varchar(255) DEFAULT NULL,
  `req_status` varchar(255) NOT NULL DEFAULT 'PENDING',
  `request_date` varchar(255) DEFAULT NULL,
  `sysentrydate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_request`
--

INSERT INTO `account_request` (`client`, `request_id`, `name`, `firstname`, `lastname`, `email`, `mobile_no`, `tel_no`, `username`, `unittype`, `lot_no`, `house_no`, `ref_fullname`, `ref_rel`, `ref_mobile_no`, `req_status`, `request_date`, `sysentrydate`) VALUES
('mercedes', '121212', NULL, 'Ejay', 'Balina', 'ejaybalina@gmail.com', '09288471523', NULL, 'ejbalina15', 'RESIDENTIAL', '123', '24', 'Chein Paras', 'Pinsan', '12321312', 'APPROVED', '2025-09-01', '2025-09-06 14:40:55'),
('mercedes', '123123', 'Chein Paras', 'Chein', 'Paras', 'chein@gmail.com', '0912341512', NULL, 'chein', 'COMMERCIAL', '134', '256', 'Renzo', 'Inaanak', '09123212354', 'APPROVED', '2025-09-03', '2025-09-07 08:29:39');

-- --------------------------------------------------------

--
-- Table structure for table `adjustments`
--

CREATE TABLE `adjustments` (
  `id` varchar(45) NOT NULL,
  `client` varchar(100) NOT NULL,
  `accountnumber` varchar(100) NOT NULL,
  `reference` varchar(45) NOT NULL,
  `adjustment_status` varchar(45) DEFAULT NULL,
  `type` varchar(75) DEFAULT NULL,
  `amount` varchar(150) DEFAULT '0.00',
  `previous_amount` decimal(10,2) DEFAULT NULL,
  `present_amount` decimal(10,2) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `sysentrydate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedby` char(17) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adjustments`
--

INSERT INTO `adjustments` (`id`, `client`, `accountnumber`, `reference`, `adjustment_status`, `type`, `amount`, `previous_amount`, `present_amount`, `remarks`, `sysentrydate`, `modifieddate`, `modifiedby`) VALUES
('ADV00000000012025082909463320250902142428', 'mercedes', '0000000001', 'ADV000000000120250829094633', 'adjusted', NULL, '1000', 100.00, NULL, 'test', '2025-09-02 12:24:28', '2025-09-02 12:24:28', 'chein'),
('CASH00000000012025082910120520250830094136', 'mercedes', '0000000001', 'CASH000000000120250829101205', 'adjusted', NULL, '250.66', 500.74, NULL, 'test', '2025-08-30 07:41:36', '2025-08-30 07:41:36', 'chein'),
('CASH00000000052025090108141220250901081644', 'mercedes', '0000000005', 'CASH000000000520250901081412', 'adjusted', NULL, '5677.78', 5607.78, NULL, 'test', '2025-09-01 06:16:44', '2025-09-01 06:16:44', 'chein');

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
  `scheduled_date` date DEFAULT NULL,
  `path1` text DEFAULT NULL,
  `path2` text DEFAULT NULL,
  `path3` text DEFAULT NULL,
  `path4` text DEFAULT NULL,
  `path5` text DEFAULT NULL,
  `sysentrydate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedby` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`client`, `announcement_no`, `title`, `message`, `status`, `scheduled_date`, `path1`, `path2`, `path3`, `path4`, `path5`, `sysentrydate`, `modifieddate`, `modifiedby`) VALUES
('mercedes', '001', 'System Maintenance', 'Scheduled downtime for system upgrade', 'POSTED', '2025-09-10', NULL, NULL, NULL, NULL, NULL, '2025-09-05 05:34:43', '2025-09-14 12:36:08', 'admin'),
('mercedes', '002', 'New Feature Release', 'Introducing the new dashboard module', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-05 05:34:43', '2025-09-06 08:05:04', 'admin'),
('mercedes', '003', 'Holiday Notice', 'Office closed on September 15', 'CLOSED', NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-05 05:34:43', '2025-09-06 08:05:04', 'hr_manager'),
('mercedes', '004', 'Security Update', 'Mandatory password reset by all users', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-05 05:34:43', '2025-09-06 08:05:04', 'it_support'),
('mercedes', '005', 'Mobile App Update', 'New version available in app stores', 'POSTED', '2025-09-12', NULL, NULL, NULL, NULL, NULL, '2025-09-05 05:34:43', '2025-09-14 12:36:08', 'dev_team'),
('mercedes', '007', 'Policy Update', 'Updated terms of service effective immediately', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-05 05:34:43', '2025-09-06 08:05:04', 'compliance'),
('mercedes', '008', 'Training Session', 'Staff training scheduled for September 20', 'SCHEDULED', '2025-09-20', NULL, NULL, NULL, NULL, NULL, '2025-09-05 05:34:43', '2025-09-06 08:05:04', 'training_dept'),
('mercedes', '009', 'Closed Announcement', 'Past announcement for reference only', 'CLOSED', NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-05 05:34:43', '2025-09-06 08:05:04', 'admin'),
('mercedes', '010', 'BILLS PAYMENTs', 'Please magbayad before sep 12s', 'POSTED', '2025-09-11', NULL, NULL, NULL, NULL, NULL, '2025-09-07 07:21:49', '2025-09-07 08:19:29', 'chein');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `client` varchar(255) NOT NULL,
  `report_id` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sysentrydate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedby` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `client`, `report_id`, `description`, `sysentrydate`, `modifieddate`, `modifiedby`) VALUES
(3, 'mercedes', '1', 'test', '2025-09-02 11:19:41', '2025-09-02 11:19:41', 'chein'),
(4, 'mercedes', '1', 'ulit', '2025-09-02 11:28:14', '2025-09-02 11:28:14', 'chein'),
(5, 'mercedes', '1', 'chein', '2025-09-02 12:27:00', '2025-09-02 12:27:00', 'chein'),
(6, 'mercedes', '1', 'tapos na po', '2025-09-10 14:27:18', '2025-09-10 14:27:18', 'chein');

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
  `house_no` varchar(100) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `sysentrydate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedby` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_details`
--

INSERT INTO `customer_details` (`client`, `accountnumber`, `fullname`, `firstname`, `middlename`, `lastname`, `birthdate`, `type`, `address`, `longitude`, `latitude`, `customer_tag`, `lot_number`, `house_no`, `contact_number`, `email`, `status`, `registration_date`, `sysentrydate`, `modifieddate`, `modifiedby`) VALUES
('mercedes', '0000000001', 'CHEIN IAN PARAS', 'CHEIN', 'IAN', 'PARAS', '2002-10-09', 'RESIDENTIAL', 'MERCEDES BENZ BRGY TEST', '213123.21312', '43534.543543', '1', '345', '22', '099324324444', 'cheinianparas@gmail.com', 'ACTIVE', '2024-10-07', '2025-08-29 05:57:46', '2025-08-29 05:57:46', 'CIP00000001'),
('mercedes', '0000000002', 'MARIA CLARA DELA CRUZ', 'MARIA', 'CLARA', 'DELA CRUZ', '1998-05-15', 'RESIDENTIAL', 'STREET 12, MERCEDES VILLAGE', '12123.4523', '14123.5523', '2', '123', '10', '09171234567', 'maria.clara@gmail.com', 'ACTIVE', '2024-10-08', '2025-08-29 05:58:54', '2025-08-29 05:58:54', 'CIP00000002'),
('mercedes', '0000000003', 'JUAN MIGUEL SANTOS', 'JUAN', 'MIGUEL', 'SANTOS', '1995-03-20', 'COMMERCIAL', 'LOT 45, MERCEDES BUSINESS PARK', '15234.8765', '13245.8765', '1', '45', '7', '09281234567', 'juan.santos@yahoo.com', 'ACTIVE', '2024-10-08', '2025-08-29 05:58:54', '2025-08-29 05:58:54', 'CIP00000003'),
('mercedes', '0000000004', 'ANA SOFIA RAMOS', 'ANA', 'SOFIA', 'RAMOS', '2000-11-30', 'RESIDENTIAL', 'BLK 7 LOT 8, MERCEDES HEIGHTS', '17823.4456', '14234.9987', '3', '78', '5', '09351234567', 'ana.ramos@hotmail.com', 'ACTIVE', '2024-10-09', '2025-08-29 05:58:54', '2025-08-29 05:58:54', 'CIP00000004'),
('mercedes', '0000000005', 'CARLOS EDUARDO REYES', 'CARLOS', 'EDUARDO', 'REYES', '1989-01-12', 'RESIDENTIAL', 'PHASE 2, MERCEDES SUBDIVISION', '16452.2321', '13452.8976', '1', '12', '30', '09451234567', 'carlos.reyes@gmail.com', 'INACTIVE', '2024-10-09', '2025-08-29 05:58:54', '2025-08-29 05:58:54', 'CIP00000005'),
('mercedes', '0000000006', 'BEATRIZ LOUISE GOMEZ', 'BEATRIZ', 'LOUISE', 'GOMEZ', '1992-07-25', 'COMMERCIAL', 'UNIT 4B, MERCEDES TOWER', '18234.5623', '15234.6754', '2', '4', 'B', '09561234567', 'bea.gomez@outlook.com', 'ACTIVE', '2024-10-09', '2025-08-29 05:58:54', '2025-08-29 05:58:54', 'CIP00000006');

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
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `client` varchar(45) NOT NULL,
  `accountnumber` varchar(45) NOT NULL,
  `payment_date` date NOT NULL,
  `payment` varchar(100) DEFAULT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `transaction_type` varchar(100) DEFAULT NULL,
  `source` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `sysentrydate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedby` char(17) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`client`, `accountnumber`, `payment_date`, `payment`, `transaction_id`, `transaction_type`, `source`, `status`, `remarks`, `sysentrydate`, `modifieddate`, `modifiedby`) VALUES
('mercedes', '0000000001', '2025-09-01', '460.78', 'GCASH2135637624', 'Advance Payment', 'GCASH', 'posted', 'Sa GCASH NAGBAYAD', '2025-09-01 03:35:42', '2025-09-01 03:35:50', 'chein'),
('mercedes', '0000000002', '2025-09-01', '500.78', 'GCASH2135637621', 'Advance Payment', 'GCASH', 'pending', 'Sa GCASH NAGBAYAD', '2025-09-01 03:35:42', '2025-09-01 03:35:42', 'chein');

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
-- Table structure for table `requests_and_incidents`
--

CREATE TABLE `requests_and_incidents` (
  `id` int(11) NOT NULL,
  `client` varchar(255) DEFAULT NULL,
  `requested_by` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `attachment_url` varchar(255) DEFAULT NULL,
  `resolved_date` date DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `sysentrydate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests_and_incidents`
--

INSERT INTO `requests_and_incidents` (`id`, `client`, `requested_by`, `type`, `category`, `title`, `description`, `priority`, `status`, `location`, `attachment_url`, `resolved_date`, `comment`, `sysentrydate`, `modifieddate`) VALUES
(1, 'mercedes', 'CHEIN', 'incident', 'maintenance', 'Broken Street Light', 'Streetlight not working in front of the house.', 'Urgent', 'In Progress', 'Main Road - Gate 2', NULL, '2025-09-01', NULL, '2025-09-01 11:48:26', '2025-09-05 03:59:32'),
(2, 'mercedes', 'CHEIN', 'request', 'security', 'Gate Access Request', 'Requesting temporary gate pass for visitor.', 'Low', 'Resolved', 'North Gate', NULL, '2025-08-31', NULL, '2025-09-01 11:48:26', '2025-09-01 11:55:03'),
(3, 'mercedes', 'JUAN', 'incident', 'security', 'Suspicious Activity', 'Unidentified person loitering near the clubhouse.', 'Urgent', 'In Progress', 'Clubhouse Entrance', NULL, NULL, NULL, '2025-09-01 11:48:26', '2025-09-01 11:55:03'),
(4, 'mercedes', 'MARIA', 'request', 'facility', 'Reservation for Clubhouse', 'Booking the clubhouse for a birthday party.', 'Medium', 'Resolved', 'Clubhouse', NULL, '2025-08-28', NULL, '2025-09-01 11:48:26', '2025-09-01 11:55:03'),
(5, 'mercedes', 'PEDRO', 'incident', 'maintenance', 'Water Leakage', 'Leakage reported in the community park fountain.', 'High', 'In Progress', 'Community Park', NULL, NULL, NULL, '2025-09-01 11:48:26', '2025-09-01 11:55:03'),
(6, 'mercedes', 'ANNA', 'request', 'utility', 'Internet Connectivity Issue', 'Requesting help with weak Wi-Fi signal near pool area.', 'Low', 'Closed', 'Pool Area', NULL, '2025-08-25', NULL, '2025-09-01 11:48:26', '2025-09-01 11:55:03'),
(7, 'mercedes', 'MARK', 'incident', 'security', 'Gate Malfunction', 'South gate not closing properly.', 'High', 'New', 'South Gate', NULL, NULL, NULL, '2025-09-01 11:48:26', '2025-09-01 11:55:03'),
(8, 'mercedes', 'LIZA', 'request', 'maintenance', 'Garden Maintenance', 'Requesting trimming of overgrown bushes near playground.', 'Medium', 'Resolved', 'Playground', NULL, '2025-08-29', NULL, '2025-09-01 11:48:26', '2025-09-01 11:55:03'),
(9, 'mercedes', 'CARLOS', 'incident', 'utility', 'Power Outage', 'Reported blackout in several homes in Block 5.', 'Urgent', 'In Progress', '', NULL, NULL, NULL, '2025-09-01 11:48:26', '2025-09-01 11:55:03'),
(10, 'mercedes', 'ROSA', 'request', 'facility', 'Swimming Pool Cleaning', 'Request for urgent cleaning due to cloudy water.', 'High', 'New', 'Swimming Pool', NULL, NULL, NULL, '2025-09-01 11:48:26', '2025-09-01 11:55:12');

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
  `filename` varchar(100) NOT NULL,
  `filetype` varchar(100) DEFAULT NULL,
  `filesize` varchar(100) DEFAULT NULL,
  `filepath` text DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `sysentrydate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modifiedby` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requirements`
--

INSERT INTO `requirements` (`client`, `accountnumber`, `document_code`, `type`, `description`, `filename`, `filetype`, `filesize`, `filepath`, `status`, `sysentrydate`, `modifieddate`, `modifiedby`) VALUES
('mercedes', 'ANNOUNCEMENTS', '010', 'Announcement', 'Announcement Attachment', 'AnnouncementFiles_010_1757229709_0.jpg', 'image/jpeg', '32855', '/Applications/XAMPP/xamppfiles/htdocs/mercedes_ois/mercedes_ois/admin/api/../../files/announcements/AnnouncementFiles_010_1757229709_0.jpg', '1', '2025-09-07 07:21:49', '2025-09-07 07:21:49', 'chein'),
('mercedes', 'ANNOUNCEMENTS', '010', 'Announcement', 'Announcement Attachment', 'AnnouncementFiles_010_1757229709_1.jpg', 'image/jpeg', '10747', '/Applications/XAMPP/xamppfiles/htdocs/mercedes_ois/mercedes_ois/admin/api/../../files/announcements/AnnouncementFiles_010_1757229709_1.jpg', '1', '2025-09-07 07:21:49', '2025-09-07 07:21:49', 'chein'),
('mercedes', 'ANNOUNCEMENTS', '010', 'Announcement', 'Announcement Attachment', 'AnnouncementFiles_010_1757229709_2.jpg', 'image/jpeg', '14607', '/Applications/XAMPP/xamppfiles/htdocs/mercedes_ois/mercedes_ois/admin/api/../../files/announcements/AnnouncementFiles_010_1757229709_2.jpg', '1', '2025-09-07 07:21:49', '2025-09-07 07:21:49', 'chein');

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

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`client`, `transaction_id`, `accountnumber`, `item_id`, `price`, `amount_paid`, `status`, `classification`, `transaction_type`, `transaction_paid`, `transaction_balance`, `transaction_date`, `discount1`, `discount2`, `vat`, `adjustments`, `overpayment`, `source`, `sysentrydate`, `modifieddate`, `modifiedby`) VALUES
('mercedes', 'ADJ000000000120250829103915', '0000000001', NULL, NULL, '2344.44', 'With Underpayment', 'normal payment', 'Adjustments', NULL, NULL, '2025-08-29', NULL, NULL, NULL, NULL, NULL, 'collection', '2025-08-29 08:39:15', '2025-08-29 08:39:15', 'chein'),
('mercedes', 'ADV000000000120250829094633', '0000000001', NULL, NULL, '1000', 'With Underpayment', 'advance payment', 'Advance Payment', NULL, NULL, '2025-08-29', NULL, NULL, NULL, '1000', NULL, 'collection', '2025-08-29 07:46:33', '2025-09-02 12:24:28', 'chein'),
('mercedes', 'ADV000000000120250829094911', '0000000001', NULL, NULL, '450', 'Paid', 'advance payment', 'Advance Payment', NULL, NULL, '2025-08-29', NULL, NULL, NULL, NULL, NULL, 'collection', '2025-08-29 07:49:11', '2025-08-29 07:49:11', 'chein'),
('mercedes', 'ADV000000000220250901072342', '0000000002', NULL, NULL, '100', 'Paid', 'advance payment', 'Advance Payment', NULL, NULL, '2025-09-01', NULL, NULL, NULL, NULL, NULL, 'collection', '2025-09-01 05:23:42', '2025-09-01 05:23:42', 'chein'),
('mercedes', 'ADV000000000420250901075928', '0000000004', NULL, NULL, '600.98', 'With Underpayment', 'advance payment', 'Advance Payment', NULL, NULL, '2025-09-01', NULL, NULL, NULL, NULL, NULL, 'collection', '2025-09-01 05:59:28', '2025-09-01 05:59:28', 'chein'),
('mercedes', 'CASH000000000120250829101205', '0000000001', NULL, NULL, '250.66', 'Advance Payment', 'normal payment', 'Cash', NULL, NULL, '2025-08-29', NULL, NULL, NULL, '250.66', NULL, 'collection', '2025-08-29 08:12:05', '2025-08-30 07:41:36', 'chein'),
('mercedes', 'CASH000000000520250901081249', '0000000005', NULL, NULL, '100.45', 'With Underpayment', 'normal payment', 'Cash', NULL, NULL, '2025-09-01', NULL, NULL, NULL, NULL, NULL, 'collection', '2025-09-01 06:12:49', '2025-09-01 06:12:49', 'chein'),
('mercedes', 'CASH000000000520250901081412', '0000000005', NULL, NULL, '5677.78', 'Paid', 'normal payment', 'Cash', NULL, NULL, '2025-09-01', NULL, NULL, NULL, '5677.78', NULL, 'collection', '2025-09-01 06:14:12', '2025-09-01 06:16:44', 'chein'),
('mercedes', 'CASH000000000620250901080052', '0000000006', NULL, NULL, '670.67', 'Paid', 'normal payment', 'Cash', NULL, NULL, '2025-09-01', NULL, NULL, NULL, NULL, NULL, 'collection', '2025-09-01 06:00:52', '2025-09-01 06:00:52', 'chein'),
('mercedes', 'GCASH2135637621', '0000000002', NULL, NULL, '500.78', 'Paid', 'normal payment', 'Advance Payment', NULL, NULL, '2025-08-31', NULL, NULL, NULL, NULL, NULL, 'GCASH', '2025-09-01 03:25:13', '2025-09-01 03:25:13', 'chein'),
('mercedes', 'GCASH2135637624', '0000000001', NULL, NULL, '460.78', 'Paid', 'normal payment', 'Advance Payment', NULL, NULL, '2025-09-01', NULL, NULL, NULL, NULL, NULL, 'GCASH', '2025-09-01 03:35:50', '2025-09-01 03:35:50', 'chein'),
('mercedes', 'RENT000000000220250829094740', '0000000002', NULL, NULL, '500', 'Paid', 'normal payment', 'Cash', NULL, NULL, '2025-08-29', NULL, NULL, NULL, NULL, NULL, 'collection', '2025-08-29 07:47:40', '2025-08-29 07:47:40', 'chein'),
('mercedes', 'RENT000000000620250901080449', '0000000006', NULL, NULL, '509.45', 'Paid', 'normal payment', 'Cash', NULL, NULL, '2025-09-01', NULL, NULL, NULL, NULL, NULL, 'collection', '2025-09-01 06:04:49', '2025-09-01 06:04:49', 'chein');

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `client` varchar(100) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `accountnumber` varchar(266) DEFAULT NULL,
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

INSERT INTO `user_accounts` (`client`, `user_id`, `accountnumber`, `username`, `password`, `firstname`, `middlename`, `lastname`, `role`, `sysentrydate`, `modifieddate`, `modifiedby`) VALUES
('mercedes', 1, NULL, 'chein', 'chein123', 'CHEIN IAN', 'SALUDES', 'PARAS', 'admin', '2025-08-27 11:47:36', '2025-08-27 14:07:56', 'CIP-000001'),
('mercedes', 2, NULL, 'ejay', 'ejay123', 'emmard', 'salih', 'balina', 'user', '2025-08-27 13:59:25', '2025-08-27 14:08:09', 'ejsb-0001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_request`
--
ALTER TABLE `account_request`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `adjustments`
--
ALTER TABLE `adjustments`
  ADD PRIMARY KEY (`id`,`client`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`client`,`announcement_no`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`client`,`accountnumber`,`payment_date`,`transaction_id`);

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
-- Indexes for table `requests_and_incidents`
--
ALTER TABLE `requests_and_incidents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requirements`
--
ALTER TABLE `requirements`
  ADD PRIMARY KEY (`client`,`accountnumber`,`document_code`,`filename`) USING BTREE;

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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `requests_and_incidents`
--
ALTER TABLE `requests_and_incidents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
