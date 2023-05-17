-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+jammy2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 17, 2023 at 02:11 PM
-- Server version: 8.0.33-0ubuntu0.22.04.2
-- PHP Version: 8.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `math_exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int NOT NULL,
  `set_id` int NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `set_id`, `file_name`) VALUES
(1, 54, 'blokovka01pr.tex'),
(2, 54, 'blokovka02pr.tex'),
(3, 54, 'odozva01pr.tex'),
(4, 55, 'blokovka01pr.tex'),
(5, 55, 'blokovka02pr.tex'),
(6, 56, 'blokovka01pr.tex'),
(7, 56, 'blokovka02pr.tex'),
(8, 56, 'odozva01pr.tex'),
(9, 57, 'blokovka01pr.tex'),
(10, 57, 'blokovka02pr.tex'),
(11, 57, 'odozva01pr.tex'),
(12, 57, 'odozva02pr.tex'),
(13, 58, 'blokovka01pr.tex'),
(14, 58, 'blokovka02pr.tex'),
(15, 58, 'odozva01pr.tex'),
(16, 58, 'odozva02pr.tex');

-- --------------------------------------------------------

--
-- Table structure for table `task_set`
--

CREATE TABLE `task_set` (
  `id` int NOT NULL,
  `task_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `term_start` datetime DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `score` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_set`
--

INSERT INTO `task_set` (`id`, `task_name`, `term_start`, `deadline`, `score`) VALUES
(54, 'Prvý test', '2023-05-16 15:05:00', '2023-05-18 15:05:00', 20),
(55, 'Druhý test', NULL, NULL, 15),
(56, 'test_piaty', '2023-05-16 12:20:00', '2023-05-19 17:10:00', 15),
(57, 'Test budúci', '2023-05-24 15:27:00', '2023-05-25 15:27:00', 30),
(58, 'Test null', NULL, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int NOT NULL,
  `student_id` int NOT NULL,
  `score` int DEFAULT NULL,
  `task` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `task_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `task_result` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `student_result` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `set_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `student_id`, `score`, `task`, `task_image`, `task_result`, `student_result`, `timestamp`, `set_id`) VALUES
(25, 30, 0, 'Nájdite prenosovú funkciu $F(s)=\\dfrac{Y(s)}{W(s)}$ pre systém opísaný blokovou schémou:', 'blokovka02_00003.jpg', '\\dfrac{s^2+s+6}{2s^3+9s^2+7s+6}', '\\frac{\\left(s^2-5s\\right)}{12s^3}+\\alpha', '2023-05-17 13:08:43', 54),
(26, 33, 0, 'Nájdite prenosovú funkciu $F(s)=\\dfrac{Y(s)}{W(s)}$ pre systém opísaný blokovou schémou:', 'blokovka02_00002.jpg', '\\dfrac{s^2+s+5}{2s^3+8s^2+6s+5}', '\\frac{\\left(s^2-5s\\right)}{4s^4}+\\sqrt{s}', '2023-05-17 13:25:17', 56),
(28, 33, 0, 'Vypočítajte prechodovú funkciu pre systém opísaný prenosovou funkciou $F(s)=\\dfrac{6}{(5s+2)^2}e^{-4s}$ \\\\', NULL, 'y(t)=\\left[ \\dfrac{3}{2}-\\dfrac{3}{2}e^{-\\frac{2}{5}(t-4)}-\\dfrac{3}{5}(t-4)e^{-\\frac{2}{5}(t-4)} \\right] \\eta(t-4)', 'y\\left(t\\right)=\\left\\lbrack\\frac{3t}{2t}-\\frac{3e^{-\\frac{2\\left(t-4\\right)}{5}}}{2}-\\frac{3\\left(t-4\\right)e^{-\\frac{2\\left(t-4\\right)}{5}}}{5}\\right\\rbrack\\eta\\left(t-4\\right)', '2023-05-17 13:47:05', 58);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `role`) VALUES
(27, 'Peter', 'Novák', 'xucitel@stuba.sk', '$2y$10$POW./J6GLjm/DK6MbuOh4uWrYynhVPauN9ilWmIa4wcklGELXI.5q', 'teacher'),
(28, 'František', 'Mrkva', 'xucitel2@stuba.sk', '$2y$10$iTjz0bCddyI2sMKutClMjeJ6Yi0K4kM2Us1J//WZntt2yiCtnXs5u', 'teacher'),
(29, 'Matúš', 'Kornhauser', 'xkornhauser@stuba.sk', '$2y$10$NQJMP7BFMQC/sTemdH0pOO10gzvc7si63JjpaggKvuOwVTYYqcxa2', 'student'),
(30, 'Samuel', 'Gibala', 'xgibala@stuba.sk', '$2y$10$SDJ5jhxDqEGwI1OI8M7DQ.8.sqOC3/C8LMI8Zs64IZnMgEPVyMO6K', 'student'),
(31, 'Viktor', 'Bojda', 'xbojda@stuba.sk', '$2y$10$TMC1UNpgEwwfNGeYYq4cQ.0YXyWl.eDMoprQfsiJN1wbyF3IO5s56', 'student'),
(32, 'Rudolf', 'Bezák', 'xbezak@stuba.sk', '$2y$10$6XgBn.T2j0ZY0g5enLJIOetwYFe/45ARrEpzPG9gKSoIJNJ2Fik6m', 'student'),
(33, 'Peter', 'Nový', 'xstudent@stuba.sk', '$2y$10$yhDGSMtXgCaJT8U5vIkYVuzwJ2EMjstqWwq9L2KbqBba9hv3DJVeK', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `set_id` (`set_id`);

--
-- Indexes for table `task_set`
--
ALTER TABLE `task_set`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `task_name` (`task_name`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `test_name` (`set_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `task_set`
--
ALTER TABLE `task_set`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`set_id`) REFERENCES `task_set` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tests_ibfk_2` FOREIGN KEY (`set_id`) REFERENCES `task_set` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
