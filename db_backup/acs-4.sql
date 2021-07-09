-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2021 at 12:30 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acs`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup_dirs`
--

CREATE TABLE `backup_dirs` (
  `id` int(11) NOT NULL,
  `backup_dir_path` varchar(300) NOT NULL,
  `backup_dir_name` varchar(100) NOT NULL,
  `script_id` int(11) NOT NULL,
  `backup_process_id` bigint(4) NOT NULL DEFAULT 0,
  `auto_backup` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `backup_dirs`
--

INSERT INTO `backup_dirs` (`id`, `backup_dir_path`, `backup_dir_name`, `script_id`, `backup_process_id`, `auto_backup`) VALUES
(1, 'D:\\San1_Data\\Desktop\\New folder\\c', 'backup_myscript2', 32, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `scripts`
--

CREATE TABLE `scripts` (
  `id` bigint(20) NOT NULL,
  `serial_no` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `source_id` bigint(20) NOT NULL,
  `destination_id` bigint(20) NOT NULL,
  `process_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `scripts`
--

INSERT INTO `scripts` (`id`, `serial_no`, `name`, `source_id`, `destination_id`, `process_id`) VALUES
(32, 4, 'script_b_to_a', 16, 17, 0),
(34, 3, 'script2', 16, 26, 0),
(35, 1, 'ca', 26, 17, 0),
(37, 2, 'a_to_c', 17, 26, 0);

-- --------------------------------------------------------

--
-- Table structure for table `script_log_32`
--

CREATE TABLE `script_log_32` (
  `id` varchar(150) NOT NULL,
  `copied_file` text DEFAULT NULL,
  `on_date` date DEFAULT NULL,
  `at_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `script_log_32`
--

INSERT INTO `script_log_32` (`id`, `copied_file`, `on_date`, `at_time`) VALUES
('1edfa392c45511eb864f64006a3abfc7', 'tr.txt', '2021-06-03', '15:49:03'),
('35eb43f1bafa11eb9ad464006a3abfc7', '75459.txt', '2021-05-22', '18:05:37'),
('53ce1ec9bafa11eb889764006a3abfc7', 'n01.txt', '2021-05-22', '18:06:27'),
('6bb7d6e6bafa11ebb9bd64006a3abfc7', 'ghj.txt', '2021-05-22', '18:07:07');

-- --------------------------------------------------------

--
-- Table structure for table `script_log_34`
--

CREATE TABLE `script_log_34` (
  `id` varchar(150) NOT NULL,
  `copied_file` text DEFAULT NULL,
  `on_date` date DEFAULT NULL,
  `at_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `script_log_34`
--

INSERT INTO `script_log_34` (`id`, `copied_file`, `on_date`, `at_time`) VALUES
('e2a26964cd0c11eb8ad464006a3abfc7', '75459.txt', '2021-06-14', '18:04:39'),
('e2ae2b57cd0c11eb8af664006a3abfc7', 'ghj.txt', '2021-06-14', '18:04:39'),
('e2be33d0cd0c11ebb15864006a3abfc7', 'n01.txt', '2021-06-14', '18:04:39'),
('e2ce6361cd0c11eb820064006a3abfc7', 'tr.txt', '2021-06-14', '18:04:39');

-- --------------------------------------------------------

--
-- Table structure for table `script_log_35`
--

CREATE TABLE `script_log_35` (
  `id` varchar(150) NOT NULL,
  `copied_file` text DEFAULT NULL,
  `on_date` date DEFAULT NULL,
  `at_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `script_log_35`
--

INSERT INTO `script_log_35` (`id`, `copied_file`, `on_date`, `at_time`) VALUES
('e8b526c2cd0c11eb99c764006a3abfc7', '75459.txt', '2021-06-14', '18:04:49');

-- --------------------------------------------------------

--
-- Table structure for table `script_log_37`
--

CREATE TABLE `script_log_37` (
  `id` varchar(150) NOT NULL,
  `copied_file` text DEFAULT NULL,
  `on_date` date DEFAULT NULL,
  `at_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `script_log_37`
--

INSERT INTO `script_log_37` (`id`, `copied_file`, `on_date`, `at_time`) VALUES
('46491903cffa11ebba0b64006a3abfc7', '12.txt', '2021-06-18', '11:28:59'),
('465612e2cffa11eb950564006a3abfc7', '123.txt', '2021-06-18', '11:28:59'),
('46612a7dcffa11eb969764006a3abfc7', '32.txt', '2021-06-18', '11:28:59'),
('466dafe0cffa11ebb93664006a3abfc7', '43.txt', '2021-06-18', '11:28:59'),
('4677c3d4cffa11eb900664006a3abfc7', '54.txt', '2021-06-18', '11:28:59'),
('469c6d52cffa11ebb2d664006a3abfc7', '75459.txt', '2021-06-18', '11:28:59'),
('46ae1de0cffa11eb9c3564006a3abfc7', 'ghj.txt', '2021-06-18', '11:28:59'),
('46bb0e02cffa11ebb47c64006a3abfc7', 'index.html', '2021-06-18', '11:29:00'),
('46c7a6f7cffa11ebb99264006a3abfc7', 'index.html.txt', '2021-06-18', '11:29:00'),
('46d95272cffa11ebac9564006a3abfc7', 'll.txt', '2021-06-18', '11:29:00'),
('46e90d37cffa11eb8a1d64006a3abfc7', 'n01.txt', '2021-06-18', '11:29:00'),
('46f28406cffa11eba31e64006a3abfc7', 'New Text Document.txt', '2021-06-18', '11:29:00'),
('46f8da48cffa11eb88d564006a3abfc7', 'tmp_b.txt', '2021-06-18', '11:29:00'),
('47014fc4cffa11eb807d64006a3abfc7', 'tr.txt', '2021-06-18', '11:29:00');

-- --------------------------------------------------------

--
-- Table structure for table `servers`
--

CREATE TABLE `servers` (
  `id` bigint(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `path` text NOT NULL,
  `backup_path` text NOT NULL,
  `backup_process_id` bigint(20) NOT NULL DEFAULT 0,
  `ip` varchar(50) DEFAULT 'Not set'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `servers`
--

INSERT INTO `servers` (`id`, `name`, `path`, `backup_path`, `backup_process_id`, `ip`) VALUES
(16, 'b', 'D:\\San1_Data\\Desktop\\New folder\\b', 'D:\\San1_Data\\backup_for_test', 0, 'Not set'),
(17, 'a', 'D:\\San1_Data\\Desktop\\New folder\\a', '', 0, 'Not set'),
(26, 'c', 'D:\\San1_Data\\Desktop\\New folder\\c', '', 0, 'Not set');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(300) NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backup_dirs`
--
ALTER TABLE `backup_dirs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scripts`
--
ALTER TABLE `scripts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `script_log_32`
--
ALTER TABLE `script_log_32`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `script_log_34`
--
ALTER TABLE `script_log_34`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `script_log_35`
--
ALTER TABLE `script_log_35`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `script_log_37`
--
ALTER TABLE `script_log_37`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backup_dirs`
--
ALTER TABLE `backup_dirs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `scripts`
--
ALTER TABLE `scripts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `servers`
--
ALTER TABLE `servers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
