-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 16, 2019 at 12:19 PM
-- Server version: 5.7.24-0ubuntu0.18.10.1
-- PHP Version: 7.2.10-0ubuntu1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `swift`
--

-- --------------------------------------------------------

--
-- Table structure for table `affected_areas`
--

CREATE TABLE `affected_areas` (
  `id` int(11) NOT NULL,
  `inc_id` int(11) NOT NULL,
  `province` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `town` varchar(150) NOT NULL,
  `lat` decimal(9,6) NOT NULL,
  `lng` decimal(9,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `inc_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `published_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_public` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `casualties`
--

CREATE TABLE `casualties` (
  `id` int(11) NOT NULL,
  `inc_id` int(11) NOT NULL,
  `deaths` int(11) NOT NULL DEFAULT '0',
  `wounded` int(11) NOT NULL DEFAULT '0',
  `missing` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_info`
--

CREATE TABLE `company_info` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT 'swift_demo',
  `slogan` varchar(45) DEFAULT 'This is just a demo',
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_1` varchar(25) DEFAULT NULL,
  `contact_2` varchar(25) DEFAULT NULL,
  `contact_3` varchar(25) DEFAULT NULL,
  `contact_4` varchar(25) DEFAULT NULL,
  `contact_5` varchar(25) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `emp_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `last_logged_in` datetime DEFAULT NULL,
  `is_admin` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `emp_id`, `first_name`, `last_name`, `password`, `contact`, `email`, `last_logged_in`, `is_admin`) VALUES
(8, 'E555', 'Dhamith', 'Hewamullage', '$2y$10$P5VhaacDbHBSYP.Z2241WOPHlpXswB.yUo55ZA1ZupCynPrubtU0O', '+94773635658', 'hewamullage123@gmail.com', '2019-01-16 12:14:28', 1),
(9, 'E666', 'Test', 'Lamb', '$2y$10$mpGZgEv5MOwnE1ZlDSJiTu3qdH61bFbUH9AatC8an2iCgvEIAxUfa', '123123', 'test@test.com', '2019-01-16 12:16:26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `evacuations`
--

CREATE TABLE `evacuations` (
  `id` int(11) NOT NULL,
  `inc_id` int(11) NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(15) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hospitalizations`
--

CREATE TABLE `hospitalizations` (
  `id` int(11) NOT NULL,
  `inc_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE `incidents` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `date` varchar(10) NOT NULL,
  `time` varchar(8) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `hazard_warning` text NOT NULL,
  `on_going` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `msg_brd_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `published_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message_by_emp` int(11) NOT NULL,
  `message_by_res` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `message_boards`
--

CREATE TABLE `message_boards` (
  `id` int(11) NOT NULL,
  `inc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `type_id` int(11) NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `organization_types`
--

CREATE TABLE `organization_types` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `organization_types`
--

INSERT INTO `organization_types` (`id`, `type`) VALUES
(1, 'Hospital'),
(2, 'Fire-brigade'),
(3, 'Ambulance service'),
(4, 'Police'),
(5, 'Search & Rescue'),
(6, 'Military'),
(7, 'Provincial Council'),
(8, 'Urban Council '),
(9, 'Pradheshiya Sabha');

-- --------------------------------------------------------

--
-- Table structure for table `press_releases`
--

CREATE TABLE `press_releases` (
  `id` int(11) NOT NULL,
  `inc_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `published_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `written_by` int(11) NOT NULL,
  `is_published` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `property_damages`
--

CREATE TABLE `property_damages` (
  `id` int(11) NOT NULL,
  `inc_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `responders`
--

CREATE TABLE `responders` (
  `id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `is_admin` int(11) NOT NULL DEFAULT '0',
  `is_available` int(11) DEFAULT '1',
  `responding_to` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `responding_areas`
--

CREATE TABLE `responding_areas` (
  `id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `province` varchar(200) NOT NULL,
  `district` varchar(200) NOT NULL,
  `town` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `responding_organizations`
--

CREATE TABLE `responding_organizations` (
  `id` int(11) NOT NULL,
  `inc_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `inc_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `is_completed` int(11) NOT NULL DEFAULT '0',
  `assigned_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affected_areas`
--
ALTER TABLE `affected_areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inc_id` (`inc_id`);

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inc_id` (`inc_id`);

--
-- Indexes for table `casualties`
--
ALTER TABLE `casualties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inc_id` (`inc_id`);

--
-- Indexes for table `company_info`
--
ALTER TABLE `company_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_info_1_idx` (`admin_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evacuations`
--
ALTER TABLE `evacuations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inc_id` (`inc_id`);

--
-- Indexes for table `hospitalizations`
--
ALTER TABLE `hospitalizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inc_id` (`inc_id`);

--
-- Indexes for table `incidents`
--
ALTER TABLE `incidents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `msg_brd_id` (`msg_brd_id`),
  ADD KEY `message_by_emp` (`message_by_emp`),
  ADD KEY `message_by_res` (`message_by_res`);

--
-- Indexes for table `message_boards`
--
ALTER TABLE `message_boards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inc_id` (`inc_id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `organization_types`
--
ALTER TABLE `organization_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `press_releases`
--
ALTER TABLE `press_releases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inc_id` (`inc_id`),
  ADD KEY `written_by` (`written_by`);

--
-- Indexes for table `property_damages`
--
ALTER TABLE `property_damages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inc_id` (`inc_id`);

--
-- Indexes for table `responders`
--
ALTER TABLE `responders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `org_id` (`org_id`),
  ADD KEY `fk_responders_1_idx` (`responding_to`);

--
-- Indexes for table `responding_areas`
--
ALTER TABLE `responding_areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `org_id` (`org_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `responding_organizations`
--
ALTER TABLE `responding_organizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inc_id` (`inc_id`),
  ADD KEY `org_id` (`org_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inc_id` (`inc_id`),
  ADD KEY `org_id` (`org_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affected_areas`
--
ALTER TABLE `affected_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;
--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `casualties`
--
ALTER TABLE `casualties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `evacuations`
--
ALTER TABLE `evacuations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `hospitalizations`
--
ALTER TABLE `hospitalizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `incidents`
--
ALTER TABLE `incidents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `message_boards`
--
ALTER TABLE `message_boards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `organization_types`
--
ALTER TABLE `organization_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `press_releases`
--
ALTER TABLE `press_releases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `property_damages`
--
ALTER TABLE `property_damages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `responders`
--
ALTER TABLE `responders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `responding_areas`
--
ALTER TABLE `responding_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `responding_organizations`
--
ALTER TABLE `responding_organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `affected_areas`
--
ALTER TABLE `affected_areas`
  ADD CONSTRAINT `affected_areas_ibfk_1` FOREIGN KEY (`inc_id`) REFERENCES `incidents` (`id`);

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_ibfk_1` FOREIGN KEY (`inc_id`) REFERENCES `incidents` (`id`);

--
-- Constraints for table `casualties`
--
ALTER TABLE `casualties`
  ADD CONSTRAINT `casualties_ibfk_1` FOREIGN KEY (`inc_id`) REFERENCES `incidents` (`id`);

--
-- Constraints for table `company_info`
--
ALTER TABLE `company_info`
  ADD CONSTRAINT `fk_company_info_1` FOREIGN KEY (`admin_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `evacuations`
--
ALTER TABLE `evacuations`
  ADD CONSTRAINT `evacuations_ibfk_1` FOREIGN KEY (`inc_id`) REFERENCES `incidents` (`id`);

--
-- Constraints for table `hospitalizations`
--
ALTER TABLE `hospitalizations`
  ADD CONSTRAINT `hospitalizations_ibfk_1` FOREIGN KEY (`inc_id`) REFERENCES `incidents` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`msg_brd_id`) REFERENCES `message_boards` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`message_by_emp`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`message_by_res`) REFERENCES `responders` (`id`);

--
-- Constraints for table `message_boards`
--
ALTER TABLE `message_boards`
  ADD CONSTRAINT `message_boards_ibfk_1` FOREIGN KEY (`inc_id`) REFERENCES `incidents` (`id`);

--
-- Constraints for table `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `organizations_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `organization_types` (`id`);

--
-- Constraints for table `press_releases`
--
ALTER TABLE `press_releases`
  ADD CONSTRAINT `press_releases_ibfk_1` FOREIGN KEY (`inc_id`) REFERENCES `incidents` (`id`),
  ADD CONSTRAINT `press_releases_ibfk_2` FOREIGN KEY (`written_by`) REFERENCES `employees` (`id`);

--
-- Constraints for table `property_damages`
--
ALTER TABLE `property_damages`
  ADD CONSTRAINT `property_damages_ibfk_1` FOREIGN KEY (`inc_id`) REFERENCES `incidents` (`id`);

--
-- Constraints for table `responders`
--
ALTER TABLE `responders`
  ADD CONSTRAINT `fk_responders_1` FOREIGN KEY (`responding_to`) REFERENCES `incidents` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `responders_ibfk_1` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`id`);

--
-- Constraints for table `responding_areas`
--
ALTER TABLE `responding_areas`
  ADD CONSTRAINT `responding_areas_ibfk_1` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`id`),
  ADD CONSTRAINT `responding_areas_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `organization_types` (`id`);

--
-- Constraints for table `responding_organizations`
--
ALTER TABLE `responding_organizations`
  ADD CONSTRAINT `responding_organizations_ibfk_1` FOREIGN KEY (`inc_id`) REFERENCES `incidents` (`id`),
  ADD CONSTRAINT `responding_organizations_ibfk_2` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`inc_id`) REFERENCES `incidents` (`id`),
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;