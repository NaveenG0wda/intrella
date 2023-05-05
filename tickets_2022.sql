-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2022 at 01:36 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tickets_2022`
--

-- --------------------------------------------------------

--
-- Table structure for table `tickets_2022_employees`
--

CREATE TABLE `tickets_2022_employees` (
  `id` int(10) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets_2022_employees`
--

INSERT INTO `tickets_2022_employees` (`id`, `uid`, `name`, `type`, `email`, `password`) VALUES
(8, 'uid_ecf2983f99', 'empl1', 'development,report', 'empl1@empl1.com', 'empl1'),
(9, 'uid_ed7162807d', 'empl2', 'report,configuration', 'empl2@empl2.com', 'empl2');

-- --------------------------------------------------------

--
-- Table structure for table `tickets_2022_slots`
--

CREATE TABLE `tickets_2022_slots` (
  `id` int(10) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `starttime` varchar(255) NOT NULL,
  `endtime` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `employee` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `reportformat` varchar(255) NOT NULL,
  `reportfile` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `userstatus` varchar(255) NOT NULL,
  `employeestatus` varchar(255) NOT NULL,
  `employeename` varchar(255) NOT NULL,
  `usercomment` text NOT NULL,
  `employeecomment` text NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets_2022_slots`
--

INSERT INTO `tickets_2022_slots` (`id`, `uid`, `starttime`, `endtime`, `date`, `type`, `employee`, `user`, `title`, `description`, `reportformat`, `reportfile`, `contact`, `userstatus`, `employeestatus`, `employeename`, `usercomment`, `employeecomment`, `location`) VALUES
(47, 'uid_63a65cdea3', '12:00:00', '13:00:00', '2022-10-13', 'explanation', 'empl1@empl1.com', 'proj2@proj2.com', 'proj2', 'proj2', '', '', '9876543210', 'active', 'active', 'empl1', '', '', 'ramakrishna nagar'),
(49, 'uid_44c4853779', '11:00:00', '12:00:00', '2022-10-15', 'configuration', 'empl2@empl2.com', 'proj1@proj1.com', 'Project', 'Project', '', '', '9876543214', 'closed', 'active', 'empl2', 'close', '', 'chamundi puram');

-- --------------------------------------------------------

--
-- Table structure for table `tickets_2022_users`
--

CREATE TABLE `tickets_2022_users` (
  `id` int(10) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets_2022_users`
--

INSERT INTO `tickets_2022_users` (`id`, `uid`, `title`, `course`, `phone`, `email`, `password`, `pid`) VALUES
(13, 'uid_89e9a7b17c', 'proj1', 'me', '9876543210', 'proj1@proj1.com', 'proj1', 'Proj_2022_1'),
(14, 'uid_9d1e7e62d5', 'proj2', 'mba', '9876543211', 'proj2@proj2.com', 'proj2', 'Proj_2022_2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tickets_2022_employees`
--
ALTER TABLE `tickets_2022_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_2022_slots`
--
ALTER TABLE `tickets_2022_slots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_2022_users`
--
ALTER TABLE `tickets_2022_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tickets_2022_employees`
--
ALTER TABLE `tickets_2022_employees`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tickets_2022_slots`
--
ALTER TABLE `tickets_2022_slots`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `tickets_2022_users`
--
ALTER TABLE `tickets_2022_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
