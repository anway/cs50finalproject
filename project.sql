-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 10, 2012 at 05:06 AM
-- Server version: 5.5.28
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl21`
--

CREATE TABLE IF NOT EXISTS `tbl21` (
  `event` varchar(40) NOT NULL,
  `yr` int(11) NOT NULL,
  `mth` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `start` decimal(5,3) NOT NULL DEFAULT '0.000',
  `end` decimal(5,3) NOT NULL DEFAULT '0.000',
  `allday` int(11) NOT NULL DEFAULT '0',
  `notonetime` int(11) NOT NULL DEFAULT '0',
  `notes` varchar(256) DEFAULT NULL,
  `filter1` int(11) NOT NULL DEFAULT '0',
  `filter2` int(11) NOT NULL DEFAULT '0',
  `filter3` int(11) NOT NULL DEFAULT '0',
  `filter4` int(11) NOT NULL DEFAULT '0',
  `filter5` int(11) NOT NULL DEFAULT '0',
  `filter6` int(11) NOT NULL DEFAULT '0',
  `filter7` int(11) NOT NULL DEFAULT '0',
  `filter8` int(11) NOT NULL DEFAULT '0',
  `filter9` int(11) NOT NULL DEFAULT '0',
  `filter10` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event`,`yr`,`mth`,`date`,`start`,`end`,`allday`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl21`
--

INSERT INTO `tbl21` (`event`, `yr`, `mth`, `date`, `start`, `end`, `allday`, `notonetime`, `notes`, `filter1`, `filter2`, `filter3`, `filter4`, `filter5`, `filter6`, `filter7`, `filter8`, `filter9`, `filter10`) VALUES
('Test', 2012, 11, 6, '0.000', '0.000', 1, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Test3', 2012, 12, 9, '0.000', '0.000', 1, 0, '', 0, 0, 1, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `filter1` varchar(40) NOT NULL DEFAULT 'School',
  `filter2` varchar(40) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT 'Work',
  `filter3` varchar(40) NOT NULL DEFAULT 'Family',
  `filter4` varchar(40) NOT NULL DEFAULT 'Extracurricular',
  `filter5` varchar(40) DEFAULT NULL,
  `filter6` varchar(40) DEFAULT NULL,
  `filter7` varchar(40) DEFAULT NULL,
  `filter8` varchar(40) DEFAULT NULL,
  `filter9` varchar(40) DEFAULT NULL,
  `filter10` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `hash`, `filter1`, `filter2`, `filter3`, `filter4`, `filter5`, `filter6`, `filter7`, `filter8`, `filter9`, `filter10`) VALUES
(21, 'user', '$1$iJ11gWdz$Xq4Z5fhc.N0n96WXdm5IV0', 'School', 'Work', 'Family', 'Extracurricular', 'Dino', '', '', '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
