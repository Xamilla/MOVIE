-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 03:55 AM
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
-- Database: `movies_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `email`, `role`, `profile_picture`, `created_at`, `updated_at`) VALUES
(3, 'fsdf', '$2y$10$ZoVC3v5SjMxTYq29/uHQI.cx6067tznMbKWju8yAfcxXnM1TI3nxe', 'camillebarola842@gmail.com', 'user', 'camsprof.jpg', '2025-03-31 14:40:34', '2025-04-28 01:20:07'),
(4, 'baby', '$2y$10$yPaCh6FnIFGglp/dR39Vy.pbViGQ9UeAHcEt/W9b2MOw5bMhqjoM.', 'xamillebarola09@gmail.com', 'user', '../MOVIE/images/profile_pictures/67eaaa2fb26d66.57920430.jpg', '2025-03-31 14:43:59', '2025-03-31 14:43:59'),
(5, 'cam24', '$2y$10$rogU.1Cq3qEQw9YuERwfTeL.3r.B6ZXtgESWZ63u0FuXjHNcY3uSG', 'sfasf@gmail.com', 'user', NULL, '2025-04-23 07:14:20', '2025-04-23 07:14:20'),
(6, 'wee', '$2y$10$ubpx.RrPyeCJh.tinQotRe4Kh7vlkTz6S8qRzX4VURXt3tLTBDi96', 'wee@gmial.com', 'user', NULL, '2025-04-27 15:16:03', '2025-04-27 15:16:03'),
(7, 'cams', '$2y$10$UIAWnFmC72IUIMATrrvWUO9KjTfG2IxbMfBSIVggoJ59tq1WhApPS', 'cams@gmail.com', 'user', '../images/profile_pictures/680ed7388f77b6.92485180.jpg', '2025-04-28 01:17:44', '2025-04-28 01:17:44'),
(8, 'admin123', '$2y$10$NrF6vgujDeQn72vsrtvtdeIbN24cETu3GAhFA5hb5qwCki9tLibmK', 'admin@gmail.com', 'admin', '../images/profile_pictures/680ed918419944.77574726.jpg', '2025-04-28 01:25:44', '2025-04-28 01:26:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
