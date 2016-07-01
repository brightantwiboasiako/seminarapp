-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2016 at 01:28 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `seminar`
--

-- --------------------------------------------------------

--
-- Table structure for table `seminars`
--

CREATE TABLE `seminars` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `location` varchar(128) NOT NULL,
  `registration_deadline` datetime NOT NULL,
  `date` datetime NOT NULL,
  `files_url` varchar(255) DEFAULT NULL,
  `participants` mediumtext,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seminars`
--

INSERT INTO `seminars` (`id`, `title`, `slug`, `location`, `registration_deadline`, `date`, `files_url`, `participants`, `created_at`, `updated_at`) VALUES
(1, 'Seminar 2016', 'seminar-2016', 'SSNIT', '2016-07-15 23:00:00', '2016-07-16 12:00:00', NULL, '["{\\"surname\\":\\"Antwi Boasiako\\",\\"first_name\\":\\"Bright\\",\\"gender\\":\\"male\\",\\"email\\":\\"brightantwiboasiako@aol.com\\",\\"phone\\":\\"0501373573\\",\\"institution\\":\\"knust\\",\\"programme\\":\\"actuarial\\",\\"completion_year\\":\\"2015\\"}","{\\"surname\\":\\"Adu Poku\\",\\"first_name\\":\\"Presido\\",\\"gender\\":\\"male\\",\\"email\\":\\"presido@gmail.com\\",\\"phone\\":\\"0244336520\\",\\"institution\\":\\"knust\\",\\"programme\\":\\"mathematics\\",\\"completion_year\\":\\"2015\\"}"]', '2016-06-29 22:31:05', '2016-06-30 22:59:51'),
(2, 'Seminar 2017', 'seminar-2017', 'ACCRA', '2016-06-20 00:00:00', '2016-06-30 00:00:00', NULL, '', '2016-06-29 22:32:43', '2016-06-29 22:32:43');

-- --------------------------------------------------------

--
-- Table structure for table `seminar_responses`
--

CREATE TABLE `seminar_responses` (
  `id` int(10) UNSIGNED NOT NULL,
  `seminar_id` int(10) UNSIGNED NOT NULL,
  `responses` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(60) NOT NULL,
  `remember_token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `remember_token`) VALUES
(1, 'seminaradmin', '$2y$10$CNY2Ol4BIP181Osqi8NUWeQivHIaUycxO2g5iazsaId0IYE1lgU/u', '0jwSHBVGmUFY274loSYZ2sz29nmAQThKCqTDobj6so8vdDpfPZhV0PzuFrWE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `seminars`
--
ALTER TABLE `seminars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seminar_responses`
--
ALTER TABLE `seminar_responses`
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
-- AUTO_INCREMENT for table `seminars`
--
ALTER TABLE `seminars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `seminar_responses`
--
ALTER TABLE `seminar_responses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
