-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2024 at 01:24 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

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
(12, '', NULL, '2024-08-28 09:36:40', 68, 1, 'activity', 15, 0),
(13, '', NULL, '2024-08-29 03:33:12', 68, 1, 'attendance', 1, 0),
(14, '', NULL, '2024-08-29 05:10:25', 68, 1, 'exam', 70, 0);

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
(73, 72, 12, 13, '2024-08-28 17:44:11', '2024-08-29 11:35:32'),
(74, 74, 12, 12, '2024-08-28 17:44:11', '2024-08-28 17:47:23'),
(75, 75, 12, 13, '2024-08-28 17:44:11', '2024-08-28 17:50:11'),
(76, 72, 13, 1, '2024-08-29 11:33:22', '2024-08-29 11:33:22'),
(77, 74, 13, 1, '2024-08-29 11:33:22', '2024-08-29 13:11:10'),
(78, 75, 13, 1, '2024-08-29 11:33:22', '2024-08-29 11:33:22'),
(79, 72, 14, 56, '2024-08-29 13:10:43', '2024-08-29 13:10:43'),
(80, 74, 14, 60, '2024-08-29 13:10:43', '2024-08-29 13:10:43'),
(81, 75, 14, 50, '2024-08-29 13:10:43', '2024-08-29 13:11:28');

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
(72, '4A G2', 1);

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
  `course` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_name`, `email`, `course_id`, `section_id`, `section_name`, `user_id`, `subject_id`, `phone_number`, `courses`, `sections`, `cp_number`, `program`, `course`) VALUES
(38, 'jayr santos', 'jayrsantos144@gmail.com', 3, 46, NULL, 1, 21, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 'joseph', 'josephadrianthenax@gmail.com', 3, 7, NULL, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'student ID', 'Name', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, '2002121', 'Jayr Santos', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, '2002324', 'Sharah Aniceto', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, '2002345', 'Joseph Madrideo', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, '2002136', 'Rosette Reyes', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, '2002524', 'Ezel Nisperos', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, '2002130', 'Miles Capangpangan', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, '2002021', 'David Bautista', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 'sample', 'Name@gmail.com', 3, 46, NULL, 1, NULL, NULL, 'gender', 'email', NULL, NULL, NULL),
(56, '2002121', 'Jayr Santos', NULL, 57, NULL, 1, NULL, NULL, 'male', 'arar@gmail.com', NULL, NULL, NULL),
(57, '2002324', 'Sharah Aniceto', NULL, 57, NULL, 1, NULL, NULL, 'female', 'aaaa@gmail.com', NULL, NULL, NULL),
(58, '2002345', 'Joseph Madrideo', NULL, 57, NULL, 1, NULL, NULL, 'male', 'hagdha@gmail.com', NULL, NULL, NULL),
(59, '2002136', 'Rosette Reyes', NULL, 57, NULL, 1, NULL, NULL, 'female', 'rsttrys@gmail.com', NULL, NULL, NULL),
(60, '2002524', 'Ezel Nisperos', NULL, 57, NULL, 1, NULL, NULL, 'female', 'ez@gmail.com', NULL, NULL, NULL),
(61, '2002130', 'Miles Capangpangan', NULL, 57, NULL, 1, NULL, NULL, 'male', 'jwjw@gmail.com', NULL, NULL, NULL),
(62, '2002021', 'David Bautista', NULL, 57, NULL, 1, NULL, NULL, 'male', 'jai@gmail.com', NULL, NULL, NULL),
(63, 'jayr santos', 'jayrsantos114@gmail.com', 3, 63, NULL, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'jayr santos', 'jayrsantos114@gmail.com', 3, 64, NULL, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'jayr santos', 'jayrsantos114@gmail.com', 3, 65, NULL, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'joseph', 'jayrsantos114@gmail.com', 3, 66, NULL, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'jayr santos', 'jayrsantos114@gmail.com', 3, 67, NULL, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'Jay R Santos ', 'jayrsantos114@gmail.com', NULL, 68, NULL, 1, NULL, NULL, NULL, NULL, '09918866661', 'BSIT', 'SIA'),
(73, 'joseph', 'joseph@gmail.com', NULL, 69, NULL, 1, NULL, NULL, NULL, NULL, '87654321', 'BSIT', 'WEB2'),
(74, 'Joseph Adrian Madrideo', 'joseph@gmail.com', NULL, 68, NULL, 1, NULL, NULL, NULL, NULL, '87654321', 'BSIT', 'CAPS'),
(75, 'Aniceto Sharah', 'shh@gmail.com', NULL, 68, NULL, 1, NULL, NULL, NULL, NULL, '12345', 'BSIT', 'WEB2'),
(77, '2002121', 'Jayr Santos', NULL, 69, NULL, 1, NULL, NULL, 'male', 'arar@gmail.com', NULL, NULL, NULL),
(78, '2002324', 'Sharah Aniceto', NULL, 69, NULL, 1, NULL, NULL, 'female', 'aaaa@gmail.com', NULL, NULL, NULL),
(79, '2002345', 'Joseph Madrideo', NULL, 69, NULL, 1, NULL, NULL, 'male', 'hagdha@gmail.com', NULL, NULL, NULL),
(80, '2002136', 'Rosette Reyes', NULL, 69, NULL, 1, NULL, NULL, 'female', 'rsttrys@gmail.com', NULL, NULL, NULL),
(81, '2002524', 'Ezel Nisperos', NULL, 69, NULL, 1, NULL, NULL, 'female', 'ez@gmail.com', NULL, NULL, NULL),
(82, '2002130', 'Miles Capangpangan', NULL, 69, NULL, 1, NULL, NULL, 'male', 'jwjw@gmail.com', NULL, NULL, NULL);

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
(6, 'Lance Grayson', 'Musngi', '', 'lance.musngi@gmail.com', 'Dec@1219', 'confirmed', 'css/img/profile.png', 'Sampaguita St.', 'vcRvk', '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

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
