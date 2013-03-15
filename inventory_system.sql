-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2013 at 04:25 PM
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product`, `quantity_left`, `quantity_sold`, `price`, `sales`, `product_description`, `product_date`) VALUES
(1, 'DVR Kit', 8, 22, 23086, 507892, 'Complete Analog Camera kit. Includes DVR and wiring.', '2013-03-03'),
(2, 'Vedrus Package', 40, 10, 52363, 523630, 'Video footages are captured in zoom default with 2 Mega Pixel resolution. It enables fast efficient analysis of recorded data in predefined picture areas.', '2013-03-03'),
(3, 'Egarda Package', 15, 5, 57828, 289140, 'Captures a wide range of area and it keeps eye on everything. The wide viewing angle of this IP camera captures everything it covers.', '2013-03-03'),
(4, 'A-170D-SE', 10, 0, 4499, 0, 'The High Resolution Choice in a Metal Shell Perfect for outdoors and public areas.', '2013-03-03'),
(5, 'A-471D', 30, 0, 3599, 0, 'The Affordable Dome Camera that offers High Resolution. Perfect for homes and small businesses.', '2013-03-03'),
(6, '171D-SE', 35, 5, 6199, 30995, 'Top of the line Analog camera that has all the best Specs plus the durability to withstand vandals. Used in areas of high crime rate.', '2013-03-03'),
(7, 'DP-793', 15, 0, 18699, 0, 'The top of the line Dome type IP Camera. Perfect for monitoring floor operations at 360 view.', '2013-03-03'),
(8, 'A-180B-SE', 60, 0, 4699, 0, 'High Resolution, Weatherproof and High Night Sensitivity. Perfect for outdoors and public areas.', '2013-03-03'),
(9, 'A-181B-SE', 15, 0, 5799, 0, 'High Specs Choice with Varifocal lens. Capture larger areas when zoomed out. Perfect for large spaces.', '2013-03-05'),
(10, 'A-841B', 17, 12, 5999, 71988, 'All the Best Features with External Focusing Function. Can view wide angles. Perfect for offices and classrooms.', '2013-03-05'),
(12, 'upuan', 5, 10, 100, 1000, 'ginagamit sa pagupo', '2013-03-08');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `filename`, `type`, `size`) VALUES
(1, 1, 'pp1.jpg', 'image/jpeg', 6568),
(2, 2, 'pp2.jpg', 'image/jpeg', 5420),
(3, 3, 'pp3.jpg', 'image/jpeg', 16585),
(4, 4, 'p1.jpg', 'image/jpeg', 40287),
(5, 5, 'p2.jpg', 'image/jpeg', 32731),
(6, 6, 'p3.jpg', 'image/jpeg', 39555),
(7, 7, 'p4.jpg', 'image/jpeg', 38517),
(8, 8, 'p5.jpg', 'image/jpeg', 5848);

-- --------------------------------------------------------

--
-- Table structure for table `product_price`
--

CREATE TABLE IF NOT EXISTS `product_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `updated_price` int(11) NOT NULL,
  `upprice_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `product_price`
--

INSERT INTO `product_price` (`id`, `product_id`, `updated_price`, `upprice_date`) VALUES
(1, 12, 200, '2013-03-15'),
(2, 12, 100, '2013-03-15');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `product_id`, `units_purchase`, `purchase_date`) VALUES
(1, 1, 20, '2013-03-03'),
(2, 1, 20, '2013-03-03'),
(3, 2, 50, '2013-03-03'),
(4, 3, 20, '2013-03-03'),
(5, 4, 10, '2013-03-03'),
(6, 5, 30, '2013-03-03'),
(7, 6, 40, '2013-03-03'),
(8, 7, 15, '2013-03-03'),
(9, 8, 60, '2013-03-03'),
(10, 9, 15, '2013-03-05'),
(11, 10, 19, '2013-03-05'),
(12, 12, 5, '2013-03-08'),
(13, 12, 10, '2013-03-08'),
(14, 10, 10, '2013-03-15');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `units_sold` int(11) NOT NULL,
  `sales_date` varchar(30) NOT NULL,
  `sales` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `units_sold`, `sales_date`, `sales`) VALUES
(1, 1, 10, '2013-03-03', 230860),
(2, 1, 10, '2013-03-03', 230860),
(3, 1, 2, '2013-03-03', 46172),
(4, 2, 10, '2013-03-03', 523630),
(5, 6, 5, '2013-03-03', 30995),
(9, 12, 10, '2013-03-08', 1000),
(7, 10, 10, '2013-03-05', 59990),
(8, 10, 2, '2013-03-05', 11998),
(10, 3, 5, '2013-03-10', 289140);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `address`, `age`, `gender`, `contact_number`) VALUES
(1, 'mykhel', '8eb3aef537d38daf8714dc53a3fedaa3bc5263303f8f4841d4b0308d38939ce3b4169c1a26fbb686e5734cbf6681ccc73829ebafc603cd9083bb1513409ba9fd', 'michael.dpoint@gmail.com', 'michael', 'raagas', '#88 1st st. Area 5 Veterans Village, Pasong Tamo, Quezon City', 22, 'male', '09094448532'),
(2, 'deng', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 'denver_tabios2002@yahoo.com', 'denver', 'tabios', 'commonwealth, quezon city', 25, 'male', '09299659973');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
