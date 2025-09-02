-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 20, 2025 at 04:51 PM
-- Server version: 5.7.44
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techeletric_ip_tools`
--

-- --------------------------------------------------------

--
-- Table structure for table `geo_alerts`
--

CREATE TABLE `geo_alerts` (
  `id` int(11) NOT NULL,
  `link_id` int(11) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `geo_links`
--

CREATE TABLE `geo_links` (
  `id` int(11) NOT NULL,
  `original_url` text NOT NULL,
  `short_code` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `expires_at` datetime DEFAULT NULL,
  `click_limit` int(11) DEFAULT '0',
  `click_count` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `geo_links`
--

INSERT INTO `geo_links` (`id`, `original_url`, `short_code`, `created_at`, `expires_at`, `click_limit`, `click_count`) VALUES
(1, 'https://www.joblinerh.com.br', 'eXZU5tQP', '2025-07-18 17:22:52', NULL, 0, 0),
(2, 'https://www.joblinerh.com.br', '6FmeJQBD', '2025-07-18 17:31:31', NULL, 0, 0),
(3, 'https://www.joblinerh.com.br', 'ondaCM9i', '2025-07-18 17:35:00', NULL, 0, 1),
(4, 'https://www.joblinerh.com.br', 'L7k6M9Dj', '2025-07-18 17:47:43', NULL, 0, 0),
(5, 'https://dmacherprojetos.com.br/assets/img/portfolio/grid/identity/1.jpg', 'ICj6uP3S', '2025-07-19 05:37:31', NULL, 0, 1),
(6, 'https://www.joblinerh.com.br', 'iKQVL7Pq', '2025-07-20 14:59:50', NULL, 0, 0),
(7, 'https://www.fatecid.com.br/', 'u1gOPkDs', '2025-07-20 15:00:17', NULL, 0, 0),
(8, 'https://www.fatecid.com.br/', 'dxwWMZlv', '2025-07-20 15:07:41', NULL, 0, 0),
(9, 'https://www.fatecid.com.br/site/', 'tqoALYai', '2025-07-20 15:07:58', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `geo_logs`
--

CREATE TABLE `geo_logs` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text,
  `referrer` text,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `link_id` int(11) DEFAULT NULL,
  `device_type` varchar(50) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `geo_logs`
--

INSERT INTO `geo_logs` (`id`, `ip_address`, `user_agent`, `referrer`, `country`, `city`, `timestamp`, `link_id`, `device_type`, `latitude`, `longitude`) VALUES
(1, '152.245.73.246', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', '', 'Brazil', 'Indaiatuba', '2025-07-18 17:35:26', 3, 'Desktop', NULL, NULL),
(2, '189.68.180.80', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36', '', 'Brazil', 'Indaiatuba', '2025-07-19 05:42:49', 5, 'Mobile', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sms_links`
--

CREATE TABLE `sms_links` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `short_code` varchar(20) DEFAULT NULL,
  `original_url` text,
  `clicked` tinyint(1) DEFAULT '0',
  `click_time` datetime DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `device_type` varchar(50) DEFAULT NULL,
  `user_agent` text,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `geo_alerts`
--
ALTER TABLE `geo_alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `link_id` (`link_id`);

--
-- Indexes for table `geo_links`
--
ALTER TABLE `geo_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short_code` (`short_code`);

--
-- Indexes for table `geo_logs`
--
ALTER TABLE `geo_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `link_id` (`link_id`);

--
-- Indexes for table `sms_links`
--
ALTER TABLE `sms_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short_code` (`short_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `geo_alerts`
--
ALTER TABLE `geo_alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geo_links`
--
ALTER TABLE `geo_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `geo_logs`
--
ALTER TABLE `geo_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sms_links`
--
ALTER TABLE `sms_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `geo_logs`
--
ALTER TABLE `geo_logs`
  ADD CONSTRAINT `fk_logs_link` FOREIGN KEY (`link_id`) REFERENCES `geo_links` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
