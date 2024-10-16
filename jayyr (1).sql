-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2024 at 04:48 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jayyr`
--
CREATE DATABASE IF NOT EXISTS `jayyr` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `jayyr`;

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `section_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_type` varchar(50) NOT NULL,
  `total_score` int(11) NOT NULL,
  `displayed` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `name`, `description`, `created_at`, `section_id`, `user_id`, `activity_type`, `total_score`, `displayed`) VALUES
(46, '', NULL, '2024-10-16 14:45:42', 74, 6, 'quiz', 20, 1),
(47, '', NULL, '2024-10-16 14:46:28', 74, 6, 'quiz', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `activity_types`
--

CREATE TABLE `activity_types` (
  `id` int(11) NOT NULL,
  `activity_type` varchar(255) NOT NULL,
  `max_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `description`, `user_id`) VALUES
(3, 'BSIT', 'ss', NULL),
(4, 'BSBA', 'aa', NULL),
(5, 'BSED', 'ED', NULL),
(10, 'BSBA', 'ahah', 1);

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`id`, `student_id`, `activity_id`, `score`, `created_at`, `updated_at`) VALUES
(1167, 94, 46, 6, '2024-10-16 22:46:59', '2024-10-16 22:47:00'),
(1168, 94, 47, 7, '2024-10-16 22:47:01', '2024-10-16 22:47:19'),
(1169, 92, 46, 10, '2024-10-16 22:47:03', '2024-10-16 22:47:05'),
(1170, 100, 46, 8, '2024-10-16 22:47:05', '2024-10-16 22:47:06'),
(1171, 98, 46, 11, '2024-10-16 22:47:06', '2024-10-16 22:47:08'),
(1172, 96, 46, 14, '2024-10-16 22:47:08', '2024-10-16 22:47:11'),
(1173, 96, 47, 10, '2024-10-16 22:47:11', '2024-10-16 22:47:13'),
(1174, 98, 47, 6, '2024-10-16 22:47:14', '2024-10-16 22:47:15'),
(1175, 100, 47, 5, '2024-10-16 22:47:15', '2024-10-16 22:47:16'),
(1176, 92, 47, 7, '2024-10-16 22:47:17', '2024-10-16 22:47:18');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `section_name`, `user_id`) VALUES
(68, '4A G1 CAPSTONE', 1),
(69, '4B G2', 1),
(72, '4A G2', 1),
(74, '3B G1 Capstones', 6);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `section_name` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `courses` varchar(255) DEFAULT NULL,
  `sections` varchar(255) DEFAULT NULL,
  `cp_number` varchar(15) DEFAULT NULL,
  `program` varchar(50) DEFAULT NULL,
  `course` varchar(50) DEFAULT NULL,
  `timestamp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_name`, `email`, `course_id`, `section_id`, `section_name`, `user_id`, `subject_id`, `phone_number`, `courses`, `sections`, `cp_number`, `program`, `course`, `timestamp`) VALUES
(92, 'lance', 'lance.musngi@gmail.com', NULL, 74, NULL, 6, NULL, NULL, 'A', NULL, NULL, NULL, NULL, '10/13/2024 15:38:04'),
(94, 'Joseph Adrian M. Madrideo', 'josephadrianthenax@gmail.com', NULL, 74, NULL, 6, NULL, NULL, 'A', NULL, NULL, NULL, NULL, '10/13/2024 16:13:39'),
(96, 'Shara H. Aniceto', 'anicetosharah49@gmail.com ', NULL, 74, NULL, 6, NULL, NULL, 'A', NULL, NULL, NULL, NULL, '10/13/2024 16:18:18'),
(98, 'Santos, Jay R U.', 'jayrsantos114@gmail.com', NULL, 74, NULL, 6, NULL, NULL, 'A', NULL, NULL, NULL, NULL, '10/13/2024 16:13:29'),
(100, 'Rosette Lorianne C. Reyes', 'rsttrys@gmail.com', NULL, 74, NULL, 6, NULL, NULL, 'A', NULL, NULL, NULL, NULL, '10/13/2024 16:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `student_activities`
--

CREATE TABLE `student_activities` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `activity_type` enum('quiz','activity','exam','attendance') NOT NULL,
  `score` int(11) DEFAULT NULL,
  `total_score` int(50) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `course_id`, `user_id`) VALUES
(2, 'web1', 3, NULL),
(3, 'web2', 3, NULL),
(4, '311', 4, NULL),
(6, 'BUSINESS ', 3, NULL),
(7, 'CAPSTONE', 3, NULL),
(19, 'CAPSTONE2', 3, NULL),
(20, 'EDUC', 5, NULL),
(21, 'test', 3, 1),
(22, 'sa', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirmation_status` enum('not confirmed','confirmed') NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'profile.png',
  `address` text NOT NULL,
  `confirmation_code` varchar(50) NOT NULL,
  `forgot_password_code` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `subject`, `email`, `password`, `confirmation_status`, `profile_picture`, `address`, `confirmation_code`, `forgot_password_code`) VALUES
(1, 'Jay R', 'Santos', 'CAPSTONE', 'jayrsantos114@gmail.com', 'aa', 'confirmed', 'photo_66cffc9c17476_FB_IMG_1621143430679.jpg', 'BLK-16 LOT-12 Bulacan Heights Catacte', '5wlho', ''),
(2, 'TESTING', 'USER', 'HHAHA', 'jayrsantos144@gmail.com', 'bb', 'confirmed', NULL, '12', 'GRpCX', ''),
(3, 'HAHA', 'hehe', 'a', 'jayrs@gmail.com', 'haha', 'confirmed', NULL, 'BLK-16 LOT-12 Bulacan Heights Catacte', 'Hf6sM', ''),
(4, 'rst', 'rys', 'CAPSTONE', 'anicetosharah49@gmail.com', 'aa', 'not confirmed', NULL, '12', 'BjAqL', ''),
(6, 'Lance Grayson', 'Musngi', '', 'lance.musngi@gmail.com', 'Dec@1219', 'confirmed', 'profile.png', 'Sampaguita St.', 'vcRvk', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_types`
--
ALTER TABLE `activity_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_courses_user` (`user_id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `fk_activity` (`activity_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `fk_students_user` (`user_id`),
  ADD KEY `fk_subject_id` (`subject_id`);

--
-- Indexes for table `student_activities`
--
ALTER TABLE `student_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `fk_subjects_user` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `activity_types`
--
ALTER TABLE `activity_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1177;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `student_activities`
--
ALTER TABLE `student_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_courses_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `fk_activity` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `scores_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_students_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `fk_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `fk_subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `student_activities`
--
ALTER TABLE `student_activities`
  ADD CONSTRAINT `student_activities_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `fk_subjects_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
