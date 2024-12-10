-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 10, 2024 at 09:34 AM
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
-- Database: `CalistheniX_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `authority`
--

CREATE TABLE `authority` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authority`
--

INSERT INTO `authority` (`id`, `email`, `password`) VALUES
(1, 'anik@gmail.com', 'anik123@'),
(2, 'ahmimtiaj@gmail.com', 'imtiaj123@');

-- --------------------------------------------------------

--
-- Table structure for table `calorie_logs`
--

CREATE TABLE `calorie_logs` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `protein` float NOT NULL,
  `carbs` float NOT NULL,
  `fat` float NOT NULL,
  `calories` float NOT NULL,
  `water` float DEFAULT 0,
  `log_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calorie_logs`
--

INSERT INTO `calorie_logs` (`id`, `member_id`, `item_name`, `protein`, `carbs`, `fat`, `calories`, `water`, `log_date`) VALUES
(1, 3, 'Fish', 4, 1, 0, 12, 1, '2024-12-05');

-- --------------------------------------------------------

--
-- Table structure for table `diet_plans`
--

CREATE TABLE `diet_plans` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `nutritionist_id` int(11) NOT NULL,
  `plan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diet_plans`
--

INSERT INTO `diet_plans` (`id`, `member_id`, `nutritionist_id`, `plan`, `created_at`) VALUES
(1, 3, 1, 'skdskd', '2024-12-06 16:36:11'),
(2, 3, 1, 'fsfs', '2024-12-06 16:47:17'),
(3, 1, 1, 'eat this and this', '2024-12-10 07:44:54');

-- --------------------------------------------------------

--
-- Table structure for table `exercise_plans`
--

CREATE TABLE `exercise_plans` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `plan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exercise_plans`
--

INSERT INTO `exercise_plans` (`id`, `member_id`, `trainer_id`, `plan`, `created_at`) VALUES
(1, 1, 1, 'Regular exercise is one of the best things you can do for your health. However, working it into your routine and sticking with it can take some determination and discipline. Certain strategies can help you keep it up.\r\n\r\n', '2024-12-06 06:44:54');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `email`, `phone`, `dob`, `password`, `created_at`) VALUES
(1, 'sagor', 'sagor@gmail.com', '01928287771', '1998-01-05', '$2y$10$ZHZrteWdKOBocTCAumro7OpBNtOrRFI9qN6uo0GzbAfwAOiIS8rEG', '2024-12-05 06:39:25'),
(2, 'Anik', 'anik@gmail.com', '01829182', '2024-12-04', '$2y$10$DLgc/UWN3Wj04KswYhIulu.6rnmZ6NVUDQOcOdbStugoikuAYRQoK', '2024-12-05 07:23:25'),
(3, 'osagor', 'osagor@gmail.com', '01381039193', '2001-01-05', '$2y$10$vI/rrLH6CioU/chsAlVM.uiyHDXVdkwqUULthcr5FciJM4wHGcCYG', '2024-12-05 11:30:36'),
(4, 'Hossain', 'hossain@gmail.com', '0182912821', '2004-01-06', '$2y$10$ss9h1j17HpF.eiOrxpzniOATUuEC.LkMfvnlvIn1z7QMUcXM40MnS', '2024-12-06 08:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `member_trainer`
--

CREATE TABLE `member_trainer` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member_trainer`
--

INSERT INTO `member_trainer` (`id`, `member_id`, `trainer_id`) VALUES
(1, 1, 1),
(5, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `nutritionists`
--

CREATE TABLE `nutritionists` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nutritionists`
--

INSERT INTO `nutritionists` (`id`, `name`, `email`, `password`) VALUES
(1, 'Sagor', 'sagor@gmail.com', '@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `nutritionists_guidance`
--

CREATE TABLE `nutritionists_guidance` (
  `id` int(11) NOT NULL,
  `nutritionist_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `diet_plan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nutritionists_guidance`
--

INSERT INTO `nutritionists_guidance` (`id`, `nutritionist_id`, `member_id`, `diet_plan`) VALUES
(1, 1, 3, 'Diet Plan'),
(2, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'BDT',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `plan_name`, `details`, `price`, `currency`, `updated_at`) VALUES
(3, '1 Months', 'Give all ', 3000.00, 'BDT', '2024-12-05 16:05:45'),
(4, '3 Months', 'all', 9000.00, 'BDT', '2024-12-05 15:29:12'),
(5, '6 Months', 'All', 12000.00, 'BDT', '2024-12-05 15:29:31');

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`id`, `name`, `email`, `password`) VALUES
(1, 'Hridoy', 'hridoy@gmail.com', '@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authority`
--
ALTER TABLE `authority`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `calorie_logs`
--
ALTER TABLE `calorie_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `diet_plans`
--
ALTER TABLE `diet_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `nutritionist_id` (`nutritionist_id`);

--
-- Indexes for table `exercise_plans`
--
ALTER TABLE `exercise_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `member_trainer`
--
ALTER TABLE `member_trainer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `nutritionists`
--
ALTER TABLE `nutritionists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `nutritionists_guidance`
--
ALTER TABLE `nutritionists_guidance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nutritionist_id` (`nutritionist_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authority`
--
ALTER TABLE `authority`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `calorie_logs`
--
ALTER TABLE `calorie_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `diet_plans`
--
ALTER TABLE `diet_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exercise_plans`
--
ALTER TABLE `exercise_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `member_trainer`
--
ALTER TABLE `member_trainer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nutritionists`
--
ALTER TABLE `nutritionists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nutritionists_guidance`
--
ALTER TABLE `nutritionists_guidance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calorie_logs`
--
ALTER TABLE `calorie_logs`
  ADD CONSTRAINT `calorie_logs_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);

--
-- Constraints for table `diet_plans`
--
ALTER TABLE `diet_plans`
  ADD CONSTRAINT `diet_plans_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diet_plans_ibfk_2` FOREIGN KEY (`nutritionist_id`) REFERENCES `nutritionists` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exercise_plans`
--
ALTER TABLE `exercise_plans`
  ADD CONSTRAINT `exercise_plans_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `exercise_plans_ibfk_2` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`);

--
-- Constraints for table `member_trainer`
--
ALTER TABLE `member_trainer`
  ADD CONSTRAINT `member_trainer_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `member_trainer_ibfk_2` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`);

--
-- Constraints for table `nutritionists_guidance`
--
ALTER TABLE `nutritionists_guidance`
  ADD CONSTRAINT `nutritionists_guidance_ibfk_1` FOREIGN KEY (`nutritionist_id`) REFERENCES `nutritionists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nutritionists_guidance_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
