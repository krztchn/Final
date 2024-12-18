-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Dec 10, 2024 at 02:20 PM
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
-- Database: `final_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `role` enum('user','admin','student','instructor','superadmin') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `hobby` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `name`, `role`, `birthdate`, `gender`, `address`, `hobby`) VALUES
(1, 'Jobel', 'jobelgolde12@gmail.com', '$2y$10$O7kavCm9m3bsR1kAJg62M.xwmbj0FUolLwEWX8kYsvw1RLPzU8eWy', NULL, 'user', NULL, NULL, NULL, NULL),
(4, 'admin', 'admin@gmail.com', '$2y$10$g0dXPIB83A6Y7nff3OxS.uC7sc3y/ejbxU7sWGD7CLzcAVdZiBL7G', NULL, 'admin', NULL, NULL, NULL, NULL),
(14, 'instructor', 'instructor@gmail.com', '$2y$10$1AFJnmC7OL8.MPJH0NxEUejUtqHnQ8EDY3eRQjFKfkieEAWXshRw2', NULL, 'instructor', NULL, NULL, NULL, NULL),
(16, 'superadmin', 'superadmin@gmail.com', '$2y$10$DMtRsJRusHwEJt4EX1by2uovovfwTDVUJYgpIiJY4u0HYlRL6atOS', NULL, 'superadmin', NULL, NULL, NULL, NULL),
(18, 'asd', 'asd@gmail.com', '$2y$10$AOO1bmt6rLHil2QWbfXct.14V0mMOafl6Mqs/RBS7lW7coAyX8Y.W', NULL, 'admin', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
