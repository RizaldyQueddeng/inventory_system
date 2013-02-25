-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2013 at 02:31 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `liveedit`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(100) NOT NULL,
  `qtyleft` int(11) NOT NULL,
  `qty_sold` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `sales` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `item`, `qtyleft`, `qty_sold`, `price`, `sales`) VALUES
(1, 'qweqwqw', 10, 14, 212, 2120),
(2, 'wewqewe', 343, 10, 100, 6),
(3, 'argie', 23232, 13, 111111111, 13000000),
(4, 'wewew', 23232, 0, 3232, 0),
(5, 'upuan', 6, 4, 15, 65);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `date` varchar(30) NOT NULL,
  `sales` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `qty`, `date`, `sales`) VALUES
(1, 2, 41, '2012-06-28', 30),
(2, 1, 14, '2012-06-28', 1484),
(3, 1, 9, '2012-06-29', 1060),
(4, 2, 2, '2012-06-29', 6),
(5, 3, 1, '2012-06-29', 1000000),
(6, 1, 1, '2012-06-30', 212),
(7, 3, 0, '2012-06-30', 0),
(8, 2, 0, '2012-06-30', 0),
(9, 3, 12, '2012-07-07', 12000000),
(10, 5, 4, '2013-02-22', 45);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `first_name`, `last_name`, `gender`, `contact_number`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'michael', 'raagas', 'male', '09094448532');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
