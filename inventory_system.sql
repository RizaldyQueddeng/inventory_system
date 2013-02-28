-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2013 at 06:13 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product` varchar(100) NOT NULL,
  `quantity_left` int(11) NOT NULL,
  `quantity_sold` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `sales` int(11) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_date` date NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product`, `quantity_left`, `quantity_sold`, `price`, `sales`, `product_description`, `product_date`) VALUES
(1, 'DVR Kit', 10, 0, 23086, 0, 'Complete Analog Camera kit. Includes DVR and wiring.', '2013-02-28'),
(2, 'Vedrus Package', 30, 0, 52363, 0, 'Video footages are captured in zoom default with 2 Mega Pixel resolution. It enables fast efficient analysis of recorded data in predefined picture areas', '2013-02-28'),
(3, 'Egarda Package', 50, 0, 57828, 0, 'Captures a wide range of area and it keeps eye on everything. The wide viewing angle of this IP camera captures everything it covers.', '2013-02-28'),
(4, 'A-170D-SE', 40, 0, 4499, 0, 'The High Resolution Choice in a Metal Shell Perfect for outdoors and public areas.', '2013-02-28');

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE IF NOT EXISTS `product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `size` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `units_purchase` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `product_id`, `units_purchase`, `purchase_date`) VALUES
(1, 1, 10, '2013-02-28'),
(2, 2, 20, '2013-02-28'),
(3, 3, 30, '2013-02-28'),
(4, 2, 10, '2013-02-28'),
(5, 3, 20, '2013-02-28'),
(6, 4, 10, '2013-02-28'),
(7, 4, 30, '2013-02-28');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `sales_date` varchar(30) NOT NULL,
  `sales` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `quantity`, `sales_date`, `sales`) VALUES
(1, 2, 41, '2012-06-28', 30),
(2, 1, 14, '2012-06-28', 1484),
(3, 1, 9, '2012-06-29', 1060),
(4, 2, 2, '2012-06-29', 6),
(5, 3, 1, '2012-06-29', 1000000),
(6, 1, 1, '2012-06-30', 212),
(7, 3, 0, '2012-06-30', 0),
(8, 2, 0, '2012-06-30', 0),
(9, 3, 12, '2012-07-07', 12000000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `gender`, `contact_number`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'michael', 'raagas', 'male', '09094448532');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
