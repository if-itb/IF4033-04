-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2014 at 01:16 PM
-- Server version: 5.5.34
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tugas_kpi`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `email`, `name`, `password`, `salt`) VALUES
(2, 'dedy.berastagi@gmail.com', 'prasetiady', 'fdfd59e81c3519079df59ec59916fa21bf1d013b', '56b41f5be63cd862e3f50631cbaea72ee7ed5dd8'),
(3, 'iqbal.pras@gmail.com', 'iqbal', 'b925964fcf44654d73bfbab1a451b1ba', 'iqbaliqbal');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempt`
--

CREATE TABLE IF NOT EXISTS `login_attempt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `attempt` int(11) NOT NULL,
  `last_attempt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `recovery`
--

CREATE TABLE IF NOT EXISTS `recovery` (
  `id` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `key` varchar(32) NOT NULL,
  `expDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recovery`
--

INSERT INTO `recovery` (`id`, `userId`, `key`, `expDate`) VALUES
(0, 3, 'f7cab1b4b9fd30939fe902e205f141e2', '2014-03-21 12:56:50'),
(0, 3, '8f4975ee7ddf549bc96638d2185facaf', '2014-03-21 12:57:47'),
(0, 3, '34810a53dff20582aaa1eee5bed7ef5f', '2014-03-21 13:02:45'),
(0, 3, '2f1910a4789ee5e7a78c8fd35f28d221', '2014-03-21 13:57:42'),
(0, 3, '34f53d57c3a01aff079da24cd2d8c753', '2014-03-21 14:08:27'),
(0, 3, '80732af360d121f3f1b1a5aa33b8db4b', '2014-03-21 14:08:54');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
