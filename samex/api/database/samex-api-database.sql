-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jun 04, 2021 at 03:03 AM
-- Server version: 5.6.25
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `samex_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `db_entries`
--

CREATE TABLE `db_entries` (
  `id` int(11) NOT NULL,
  `db_name` varchar(100) NOT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `db_entries`
--

INSERT INTO `db_entries` (`id`, `db_name`, `created_on`) VALUES
(1, 'samex_db', '2021-06-03 21:17:13'),
(16, 'samex_db1', '2021-06-04 00:08:37'),
(17, 'samex_db3', '2021-06-04 00:09:29'),
(18, 'samex_db4', '2021-06-04 00:09:59'),
(19, 'samex_db5', '2021-06-04 00:35:52'),
(20, 'samex_db6', '2021-06-04 00:36:57'),
(21, 'samex_db7', '2021-06-04 00:37:38'),
(22, 'samex_db8', '2021-06-04 00:43:46'),
(23, 'samex_db9', '2021-06-04 00:47:38'),
(24, 'samex_db10', '2021-06-04 00:49:14'),
(25, 'samex_db11', '2021-06-04 00:54:53');

-- --------------------------------------------------------

--
-- Table structure for table `user_auth`
--

CREATE TABLE `user_auth` (
  `id` int(11) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_auth`
--

INSERT INTO `user_auth` (`id`, `username`, `password`) VALUES
(1, 'samexllc', '8f508d7873678f8b321997f43468234f');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `db_entries`
--
ALTER TABLE `db_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_auth`
--
ALTER TABLE `user_auth`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `db_entries`
--
ALTER TABLE `db_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `user_auth`
--
ALTER TABLE `user_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;