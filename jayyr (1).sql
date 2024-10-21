-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2024 at 09:53 AM
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
-- Database: `jayyr`
--

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
(47, '', NULL, '2024-10-16 14:46:28', 74, 6, 'quiz', 10, 1),
(48, '', NULL, '2024-10-18 05:02:36', 68, 1, 'quiz', 10, 1),
(49, '', NULL, '2024-10-18 05:04:47', 68, 1, 'quiz', 10, 1),
(50, '', NULL, '2024-10-18 05:05:03', 68, 1, 'quiz', 10, 1),
(51, '', NULL, '2024-10-18 05:07:05', 68, 1, 'attendance', 16, 1),
(52, '', NULL, '2024-10-18 05:07:21', 68, 1, 'activity', 20, 1),
(53, '', NULL, '2024-10-18 05:08:48', 68, 1, 'exam', 50, 1),
(54, '', NULL, '2024-10-18 05:09:48', 68, 1, 'quiz', 15, 1),
(55, '', NULL, '2024-10-18 05:10:00', 68, 1, 'activity', 10, 1),
(56, '', NULL, '2024-10-18 05:11:26', 68, 1, 'exam', 100, 1),
(57, '', NULL, '2024-10-18 06:05:43', 68, 1, 'exam', 50, 1),
(58, '', NULL, '2024-10-18 06:13:38', 72, 1, 'quiz', 10, 1),
(59, '', NULL, '2024-10-18 06:15:19', 72, 1, 'attendance', 1, 1),
(60, '', NULL, '2024-10-18 06:15:33', 72, 1, 'attendance', 1, 1),
(61, '', NULL, '2024-10-18 06:15:43', 72, 1, 'attendance', 1, 1),
(62, '', NULL, '2024-10-18 06:15:55', 72, 1, 'quiz', 15, 1),
(63, '', NULL, '2024-10-18 06:21:48', 72, 1, 'activity', 10, 1),
(64, '', NULL, '2024-10-18 06:22:21', 72, 1, 'activity', 10, 1),
(65, '', NULL, '2024-10-18 06:22:40', 72, 1, 'quiz', 9, 1),
(66, '', NULL, '2024-10-18 06:22:57', 72, 1, 'exam', 18, 1),
(67, '', NULL, '2024-10-18 06:24:12', 72, 1, 'activity', 15, 1),
(68, '', NULL, '2024-10-18 06:24:26', 72, 1, 'quiz', 10, 1),
(69, '', NULL, '2024-10-18 06:25:11', 72, 1, 'attendance', 1, 1),
(70, '', NULL, '2024-10-18 06:25:57', 72, 1, 'activity', 10, 1),
(71, '', NULL, '2024-10-18 06:26:06', 72, 1, 'activity', 10, 1),
(72, '', NULL, '2024-10-18 07:11:04', 72, 1, 'activity', 13, 1),
(73, '', NULL, '2024-10-18 07:18:50', 68, 1, 'quiz', 5, 1),
(74, '', NULL, '2024-10-18 12:37:00', 68, 1, 'quiz', 10, 1),
(75, '', NULL, '2024-10-18 13:51:22', 69, 1, 'exam', 20, 1),
(76, '', NULL, '2024-10-18 13:51:51', 69, 1, 'quiz', 10, 1),
(77, '', NULL, '2024-10-18 13:55:23', 69, 1, 'attendance', 1, 1),
(78, '', NULL, '2024-10-18 13:55:39', 69, 1, 'attendance', 1, 1),
(79, '', NULL, '2024-10-18 13:55:47', 69, 1, 'attendance', 1, 1),
(80, '', NULL, '2024-10-18 13:56:48', 69, 1, 'exam', 15, 1),
(81, '', NULL, '2024-10-18 13:57:11', 69, 1, 'activity', 10, 1),
(82, '', NULL, '2024-10-18 13:58:30', 69, 1, 'quiz', 10, 1),
(83, '', NULL, '2024-10-18 13:58:51', 69, 1, 'activity', 10, 1),
(84, '', NULL, '2024-10-18 14:29:35', 75, 1, 'quiz', 5, 1),
(85, '', NULL, '2024-10-18 14:30:56', 75, 1, 'quiz', 8, 1),
(86, '', NULL, '2024-10-19 15:14:48', 75, 1, 'attendance', 1, 1),
(87, '', NULL, '2024-10-19 15:15:22', 75, 1, 'attendance', 1, 1),
(88, '', NULL, '2024-10-19 15:16:11', 75, 1, 'attendance', 1, 1),
(89, '', NULL, '2024-10-19 15:17:11', 75, 1, 'activity', 5, 1),
(90, '', NULL, '2024-10-21 06:27:47', 77, 1, 'quiz', 7, 1),
(91, '', NULL, '2024-10-21 07:11:47', 75, 1, 'activity', 10, 1),
(92, '', NULL, '2024-10-21 07:13:28', 78, 1, 'attendance', 1, 1),
(93, '', NULL, '2024-10-21 07:14:00', 78, 1, 'quiz', 10, 1),
(94, '', NULL, '2024-10-21 07:14:28', 78, 1, 'exam', 10, 1),
(95, '', NULL, '2024-10-21 07:14:37', 78, 1, 'attendance', 1, 1),
(96, '', NULL, '2024-10-21 07:15:30', 78, 1, 'quiz', 5, 1),
(97, '', NULL, '2024-10-21 07:16:13', 78, 1, 'exam', 5, 1),
(98, '', NULL, '2024-10-21 07:17:35', 78, 1, 'exam', 10, 1),
(99, '', NULL, '2024-10-21 07:17:41', 78, 1, 'activity', 5, 1),
(100, '', NULL, '2024-10-21 07:17:57', 78, 1, 'exam', 10, 1),
(101, '', NULL, '2024-10-21 07:18:02', 78, 1, 'attendance', 1, 1),
(102, '', NULL, '2024-10-21 07:18:07', 78, 1, 'attendance', 1, 1),
(103, '', NULL, '2024-10-21 07:18:26', 78, 1, 'activity', 10, 1),
(104, '', NULL, '2024-10-21 07:18:50', 78, 1, 'exam', 10, 1),
(105, '', NULL, '2024-10-21 07:18:57', 78, 1, 'exam', 10, 1),
(106, '', NULL, '2024-10-21 07:25:41', 78, 1, 'activity', 5, 1),
(107, '', NULL, '2024-10-21 07:26:14', 78, 1, 'exam', 5, 1),
(108, '', NULL, '2024-10-21 07:26:37', 78, 1, 'attendance', 1, 1),
(109, '', NULL, '2024-10-21 07:27:01', 78, 1, 'attendance', 1, 1),
(110, '', NULL, '2024-10-21 07:27:07', 78, 1, 'attendance', 1, 1),
(111, '', NULL, '2024-10-21 07:27:11', 78, 1, 'attendance', 1, 1),
(112, '', NULL, '2024-10-21 07:27:16', 78, 1, 'attendance', 1, 1),
(113, '', NULL, '2024-10-21 07:27:21', 78, 1, 'attendance', 1, 1);

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
(1176, 92, 47, 7, '2024-10-16 22:47:17', '2024-10-16 22:47:18'),
(1177, 107, 48, 6, '2024-10-18 13:02:42', '2024-10-18 13:02:44'),
(1178, 108, 48, 1, '2024-10-18 13:04:29', '2024-10-18 13:04:29'),
(1179, 107, 49, 7, '2024-10-18 13:04:54', '2024-10-18 13:04:55'),
(1180, 108, 49, 1, '2024-10-18 13:04:56', '2024-10-18 13:04:56'),
(1181, 108, 50, 1, '2024-10-18 13:05:07', '2024-10-18 13:05:07'),
(1182, 107, 50, 10, '2024-10-18 13:05:08', '2024-10-18 13:05:10'),
(1183, 107, 51, 16, '2024-10-18 13:07:11', '2024-10-18 13:07:11'),
(1184, 108, 51, 2, '2024-10-18 13:07:13', '2024-10-18 13:07:26'),
(1185, 108, 52, 2, '2024-10-18 13:07:27', '2024-10-18 13:07:29'),
(1186, 107, 52, 20, '2024-10-18 13:07:32', '2024-10-18 13:07:32'),
(1187, 107, 53, 50, '2024-10-18 13:08:56', '2024-10-18 13:08:56'),
(1188, 108, 53, 14, '2024-10-18 13:08:58', '2024-10-18 13:08:58'),
(1189, 107, 54, 15, '2024-10-18 13:09:53', '2024-10-18 13:09:53'),
(1190, 108, 54, 2, '2024-10-18 13:09:53', '2024-10-18 13:10:19'),
(1191, 107, 55, 10, '2024-10-18 13:10:05', '2024-10-18 13:10:05'),
(1192, 108, 55, 3, '2024-10-18 13:10:12', '2024-10-18 13:10:18'),
(1193, 107, 56, 100, '2024-10-18 13:11:34', '2024-10-18 13:11:34'),
(1194, 108, 56, 40, '2024-10-18 13:11:39', '2024-10-18 13:11:39'),
(1195, 107, 57, 31, '2024-10-18 14:05:48', '2024-10-18 14:05:51'),
(1196, 108, 57, 3, '2024-10-18 14:05:52', '2024-10-18 14:05:52'),
(1197, 109, 58, 10, '2024-10-18 14:13:43', '2024-10-18 14:13:45'),
(1198, 109, 59, 1, '2024-10-18 14:15:23', '2024-10-18 14:15:23'),
(1199, 109, 60, 1, '2024-10-18 14:15:36', '2024-10-18 14:15:36'),
(1200, 109, 61, 1, '2024-10-18 14:15:46', '2024-10-18 14:15:46'),
(1201, 109, 62, 15, '2024-10-18 14:16:04', '2024-10-18 14:16:04'),
(1202, 109, 63, 6, '2024-10-18 14:21:54', '2024-10-18 14:21:55'),
(1203, 109, 64, 9, '2024-10-18 14:22:29', '2024-10-18 14:22:31'),
(1204, 109, 65, 8, '2024-10-18 14:22:44', '2024-10-18 14:22:47'),
(1205, 109, 66, 2, '2024-10-18 14:23:04', '2024-10-18 21:48:43'),
(1206, 109, 67, 11, '2024-10-18 14:24:18', '2024-10-18 14:24:21'),
(1207, 109, 68, 5, '2024-10-18 14:24:43', '2024-10-18 14:24:43'),
(1208, 109, 69, 1, '2024-10-18 14:25:30', '2024-10-18 14:25:30'),
(1209, 109, 70, 1, '2024-10-18 14:26:01', '2024-10-18 14:26:01'),
(1210, 109, 71, 1, '2024-10-18 14:26:11', '2024-10-18 14:26:11'),
(1212, 107, 73, 5, '2024-10-18 15:19:02', '2024-10-18 15:19:02'),
(1213, 108, 73, 1, '2024-10-18 15:19:08', '2024-10-18 15:19:08'),
(1214, 107, 74, 10, '2024-10-18 20:37:05', '2024-10-18 20:37:07'),
(1215, 108, 74, 2, '2024-10-18 20:37:21', '2024-10-18 20:38:02'),
(1216, 110, 58, 7, '2024-10-18 20:38:44', '2024-10-18 20:38:45'),
(1217, 110, 59, 1, '2024-10-18 20:38:46', '2024-10-18 20:38:46'),
(1218, 110, 63, 6, '2024-10-18 20:38:52', '2024-10-18 20:38:52'),
(1219, 110, 60, 1, '2024-10-18 21:48:27', '2024-10-18 21:49:53'),
(1220, 110, 61, 1, '2024-10-18 21:48:28', '2024-10-18 21:49:52'),
(1221, 110, 62, 10, '2024-10-18 21:48:34', '2024-10-18 21:48:36'),
(1222, 110, 64, 2, '2024-10-18 21:48:37', '2024-10-18 21:48:37'),
(1223, 110, 65, 2, '2024-10-18 21:48:39', '2024-10-18 21:48:39'),
(1224, 110, 66, 4, '2024-10-18 21:48:40', '2024-10-21 11:45:43'),
(1225, 110, 67, 5, '2024-10-18 21:48:44', '2024-10-21 11:45:49'),
(1226, 110, 68, 3, '2024-10-18 21:48:47', '2024-10-21 11:45:47'),
(1227, 110, 70, 2, '2024-10-18 21:48:49', '2024-10-18 21:48:49'),
(1228, 110, 71, 2, '2024-10-18 21:48:49', '2024-10-18 21:48:49'),
(1229, 110, 72, 2, '2024-10-18 21:48:50', '2024-10-18 21:48:50'),
(1230, 109, 72, 9, '2024-10-18 21:48:51', '2024-10-18 21:48:53'),
(1231, 110, 69, 1, '2024-10-18 21:49:47', '2024-10-18 21:49:47'),
(1232, 111, 75, 5, '2024-10-18 21:51:35', '2024-10-18 21:57:30'),
(1233, 111, 76, 3, '2024-10-18 21:51:55', '2024-10-18 21:52:07'),
(1234, 111, 77, 1, '2024-10-18 21:56:28', '2024-10-18 21:56:28'),
(1235, 111, 78, 1, '2024-10-18 21:56:30', '2024-10-18 21:56:30'),
(1236, 111, 79, 1, '2024-10-18 21:56:30', '2024-10-18 21:56:30'),
(1237, 111, 80, 4, '2024-10-18 21:56:52', '2024-10-18 21:56:53'),
(1238, 111, 81, 1, '2024-10-18 21:57:16', '2024-10-18 21:57:16'),
(1239, 111, 82, 1, '2024-10-18 21:58:35', '2024-10-18 21:58:35'),
(1240, 111, 83, 3, '2024-10-18 21:58:57', '2024-10-18 21:59:08'),
(1241, 112, 75, 1, '2024-10-18 22:11:23', '2024-10-18 22:11:23'),
(1242, 112, 76, 1, '2024-10-18 22:11:24', '2024-10-18 22:11:24'),
(1243, 112, 77, 1, '2024-10-18 22:11:27', '2024-10-18 22:13:38'),
(1244, 112, 78, 1, '2024-10-18 22:11:28', '2024-10-18 22:13:39'),
(1245, 112, 79, 1, '2024-10-18 22:11:29', '2024-10-18 22:13:40'),
(1246, 112, 80, 1, '2024-10-18 22:11:32', '2024-10-18 22:11:32'),
(1247, 112, 81, 10, '2024-10-18 22:11:36', '2024-10-18 22:11:38'),
(1248, 112, 82, 1, '2024-10-18 22:11:39', '2024-10-18 22:11:39'),
(1249, 112, 83, 1, '2024-10-18 22:11:40', '2024-10-18 22:11:40'),
(1257, 113, 82, 1, '2024-10-18 22:14:27', '2024-10-18 22:14:27'),
(1258, 113, 83, 1, '2024-10-18 22:14:29', '2024-10-18 22:14:29'),
(1261, 115, 84, 5, '2024-10-19 22:50:52', '2024-10-19 23:08:54'),
(1262, 115, 85, 5, '2024-10-19 22:51:16', '2024-10-19 23:09:00'),
(1263, 114, 84, 1, '2024-10-19 23:08:45', '2024-10-19 23:08:45'),
(1264, 114, 85, 1, '2024-10-19 23:08:54', '2024-10-19 23:08:54'),
(1265, 115, 86, 1, '2024-10-19 23:14:55', '2024-10-19 23:14:55'),
(1266, 115, 87, 1, '2024-10-19 23:16:38', '2024-10-19 23:16:38'),
(1267, 115, 88, 1, '2024-10-19 23:16:39', '2024-10-19 23:16:39'),
(1268, 114, 89, 1, '2024-10-19 23:17:15', '2024-10-19 23:17:15'),
(1269, 115, 89, 5, '2024-10-19 23:17:17', '2024-10-19 23:17:19'),
(1270, 114, 86, 1, '2024-10-19 23:20:38', '2024-10-21 15:11:11'),
(1271, 114, 87, 1, '2024-10-19 23:20:40', '2024-10-21 15:11:04'),
(1272, 114, 88, 1, '2024-10-19 23:20:40', '2024-10-21 15:11:08'),
(1273, 117, 90, 7, '2024-10-21 14:27:52', '2024-10-21 14:28:26'),
(1274, 114, 91, 10, '2024-10-21 15:12:00', '2024-10-21 15:12:02'),
(1275, 115, 91, 3, '2024-10-21 15:12:03', '2024-10-21 15:12:06'),
(1276, 118, 92, 1, '2024-10-21 15:13:31', '2024-10-21 15:17:04'),
(1277, 118, 93, 8, '2024-10-21 15:14:04', '2024-10-21 15:17:11'),
(1278, 118, 94, 8, '2024-10-21 15:14:42', '2024-10-21 15:17:09'),
(1279, 118, 95, 1, '2024-10-21 15:14:44', '2024-10-21 15:17:12'),
(1280, 118, 96, 1, '2024-10-21 15:15:33', '2024-10-21 15:15:33'),
(1281, 118, 97, 5, '2024-10-21 15:16:16', '2024-10-21 15:16:17'),
(1282, 118, 98, 8, '2024-10-21 15:19:08', '2024-10-21 15:19:10'),
(1283, 118, 99, 4, '2024-10-21 15:19:11', '2024-10-21 15:19:12'),
(1284, 118, 100, 6, '2024-10-21 15:19:13', '2024-10-21 15:19:14'),
(1285, 118, 101, 1, '2024-10-21 15:19:16', '2024-10-21 15:19:16'),
(1286, 118, 102, 1, '2024-10-21 15:19:17', '2024-10-21 15:19:17'),
(1287, 118, 103, 6, '2024-10-21 15:19:18', '2024-10-21 15:19:19'),
(1288, 118, 104, 6, '2024-10-21 15:19:20', '2024-10-21 15:19:21'),
(1289, 118, 105, 6, '2024-10-21 15:19:22', '2024-10-21 15:19:23'),
(1290, 118, 106, 1, '2024-10-21 15:25:48', '2024-10-21 15:25:48'),
(1291, 118, 107, 1, '2024-10-21 15:26:23', '2024-10-21 15:26:23'),
(1292, 118, 108, 0, '2024-10-21 15:26:45', '2024-10-21 15:26:45'),
(1293, 118, 109, 0, '2024-10-21 15:27:38', '2024-10-21 15:27:38'),
(1294, 118, 110, 0, '2024-10-21 15:27:39', '2024-10-21 15:27:39'),
(1295, 118, 111, 0, '2024-10-21 15:27:39', '2024-10-21 15:27:39'),
(1296, 118, 112, 0, '2024-10-21 15:27:39', '2024-10-21 15:27:39'),
(1297, 118, 113, 0, '2024-10-21 15:27:39', '2024-10-21 15:27:39');

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
(72, '4A G2', 1),
(74, '3B G1 Capstones', 6),
(75, '1A G1', 1),
(76, 'PUTANGINA', 1),
(77, '3B', 1),
(78, '3A', 1);

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
  `student_number` varchar(15) DEFAULT NULL,
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

INSERT INTO `students` (`id`, `student_name`, `email`, `course_id`, `section_id`, `section_name`, `user_id`, `subject_id`, `student_number`, `courses`, `sections`, `cp_number`, `program`, `course`, `timestamp`) VALUES
(92, 'lance', 'lance.musngi@gmail.com', NULL, 74, NULL, 6, NULL, NULL, 'A', NULL, NULL, NULL, NULL, '10/13/2024 15:38:04'),
(94, 'Joseph Adrian M. Madrideo', 'josephadrianthenax@gmail.com', NULL, 74, NULL, 6, NULL, NULL, 'A', NULL, NULL, NULL, NULL, '10/13/2024 16:13:39'),
(96, 'Shara H. Aniceto', 'anicetosharah49@gmail.com ', NULL, 74, NULL, 6, NULL, NULL, 'A', NULL, NULL, NULL, NULL, '10/13/2024 16:18:18'),
(98, 'Santos, Jay R U.', 'jayrsantos114@gmail.com', NULL, 74, NULL, 6, NULL, NULL, 'A', NULL, NULL, NULL, NULL, '10/13/2024 16:13:29'),
(100, 'Rosette Lorianne C. Reyes', 'rsttrys@gmail.com', NULL, 74, NULL, 6, NULL, NULL, 'A', NULL, NULL, NULL, NULL, '10/13/2024 16:16:20'),
(107, 'Madrideo, Joseph Adrian M.', 'josephadrianthenax@gmail.com', NULL, 68, NULL, 1, NULL, NULL, NULL, NULL, '', '', '', ''),
(108, 'Sharah Nazahrie Aniceto', 'lance.musngi@gmail.com', NULL, 68, NULL, 1, NULL, NULL, NULL, NULL, '', '', '', ''),
(109, 'Joseph Adrian Madrideo', 'josephadrianthenax@gmail.com', NULL, 72, NULL, 1, NULL, NULL, NULL, NULL, '', '', '', ''),
(110, 'Jay R Santos', 'lance.musngi@gmail.com', NULL, 72, NULL, 1, NULL, NULL, NULL, NULL, '', '', '', ''),
(113, 'Rosette Lorianne C. Reyes', 'lance.musngi@gmail.com', NULL, 69, NULL, 1, NULL, NULL, NULL, NULL, '', '', '', ''),
(114, 'Joseph Adrian Madrideo', 'josephadrianthenax@gmail.com', NULL, 75, NULL, 1, NULL, NULL, NULL, NULL, '', '', '', ''),
(115, 'Joseph Adrian Madrideo', 'josephadrianthenax@gmail.com', NULL, 75, NULL, 1, NULL, '2021', NULL, NULL, NULL, NULL, NULL, ''),
(116, 'Jay R Santos', 'lance.musngi@gmail.com', NULL, 76, NULL, 1, NULL, '2021', NULL, NULL, NULL, NULL, NULL, ''),
(117, 'Joseph Adrian Madrideo', 'josephadrianthenax@gmail.com', NULL, 77, NULL, 1, NULL, '2021', NULL, NULL, NULL, NULL, NULL, ''),
(118, 'Joseph Adrian Madrideo', 'josephadrianthenax@gmail.com', NULL, 78, NULL, 1, NULL, '2021', NULL, NULL, NULL, NULL, NULL, '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1298;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

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
