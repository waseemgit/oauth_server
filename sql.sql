-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 01, 2015 at 04:35 PM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_tokens`
--

CREATE TABLE IF NOT EXISTS `access_tokens` (
  `access_token` varchar(40) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`access_token`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `access_tokens`
--

INSERT INTO `access_tokens` (`access_token`, `client_id`, `expires`) VALUES
('29b9deaa24418dd4d8d79d5fe71d11c1', '123456789', '2015-10-30 21:12:32'),
('672f50def56d0d1990a67b14bc1bd5d4', '123456789', '2015-10-30 21:22:58'),
('406a2fad291eec56e6e181a900b4cc1c', '123456789', '2015-11-06 20:03:15'),
('d780ee4be3091faeb408124f6e50d80f', '123456789', '2015-11-06 22:19:14'),
('7d0fa758e08f67f9a6678a99a5e390e9', '123456789', '2015-11-08 11:50:07');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `search_count` int(11) NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '1',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `title`, `description`, `search_count`, `created_by`, `date_created`) VALUES
(1, 'answer1', '', 5, 1, '2015-11-01 13:49:15'),
(2, 'an2222dfdfd', '', 3, 1, '2015-11-01 13:18:13'),
(15, 'test title', 'test description', 6, 1, '2015-11-01 13:50:31');

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `module_type` int(11) NOT NULL COMMENT '1=Comments, 2= Answers',
  `file_extension` varchar(10) NOT NULL,
  `file_size` double NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `module_id`, `module_type`, `file_extension`, `file_size`, `file_name`, `date_created`) VALUES
(1, 1, 1, '', 0, 'comment1.jpg', '2015-10-29 19:44:25'),
(2, 1, 1, '', 0, 'comment2.jpg', '2015-10-29 20:25:39'),
(3, 1, 2, '', 0, 'answers.jpg', '2015-10-29 20:26:51'),
(4, 2, 2, '', 0, 'answers.jpg', '2015-10-29 19:45:28'),
(5, 1, 2, '', 0, 'test.jpg', '2015-10-30 23:52:28'),
(6, 1, 2, '', 0, 'test1.jpg', '2015-10-30 23:52:28'),
(24, 3, 1, 'jpg', 155124, '8685af081d7359beca34cbca3441e6f9.jpg', '2015-11-01 12:35:06'),
(25, 3, 1, 'png', 181513, 'ad28ce03e1f093f87777e2867c9be677.png', '2015-11-01 12:35:06'),
(26, 15, 2, 'doc', 26112, '0efbfb808e4a2c6de9d561f29bd7fb0f.doc', '2015-11-01 13:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE IF NOT EXISTS `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fabrication_year` year(4) NOT NULL,
  `producer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `fabrication_year`, `producer`) VALUES
(1, 1994, 'Mercedes'),
(2, 2000, 'BMW'),
(3, 1994, 'Audi'),
(4, 2005, 'BMW'),
(5, 2002, 'Audi'),
(6, 2014, 'BMW'),
(7, 1994, 'Mercedes'),
(8, 2000, 'BMW'),
(9, 2011, 'Audi'),
(10, 2000, 'BMW'),
(11, 2010, 'Audi'),
(12, 1989, 'BMW');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text NOT NULL,
  `answer_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '1',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `answer_id`, `created_by`, `date_created`) VALUES
(1, 'comment 1', 1, 1, '2015-10-30 23:50:27'),
(2, 'comment 2', 1, 1, '2015-10-30 23:50:31'),
(3, 'test comment', 1, 1, '2015-11-01 12:35:05'),
(4, 'test comment', 1, 1, '2015-11-01 13:05:21');

-- --------------------------------------------------------

--
-- Table structure for table `system_users`
--

CREATE TABLE IF NOT EXISTS `system_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `system_users`
--

INSERT INTO `system_users` (`id`, `name`) VALUES
(1, 'Waseem');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(500) COLLATE utf8_bin NOT NULL,
  `client_secret` varchar(500) COLLATE utf8_bin NOT NULL,
  `access_token` varchar(500) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `client_id`, `client_secret`, `access_token`) VALUES
(1, '123456789', '25f9e794323b453885f5181f1b624d0b', '228365421ce006f986bebfeb24fbbf77');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
