-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 19, 2014 at 10:05 PM
-- Server version: 5.5.35-0ubuntu0.13.10.2
-- PHP Version: 5.5.3-1ubuntu2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `description` text NOT NULL,
  `is_in_stock` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `price`, `description`, `is_in_stock`) VALUES
(6, 'Japanese HDD', 7, 3247, 'Amazing Japanese HDD.', 1),
(7, 'Dell Laptop', 2, 29999, 'Dell 15R Inspiorn Laptop i3 gIII', 1),
(26, 'Samsung S5', 13, 40000, 'Samsung latest announced S5 quad core processor', 1),
(27, 'Nokia Lumia', 21, 8000, 'Nokia Lumia 520', 1),
(28, 'Samsung S5', 13, 40000, 'Samsung latest announced S5 quad core processor', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE IF NOT EXISTS `tokens` (
  `token` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`token`, `username`, `created_at`) VALUES
('{0014A670-FA03-A67C-89F5-6D76339F81BF}', 'mayank', '2014-03-19 18:42:49'),
('{1BD91069-17AF-A47D-5B77-5B9E1D561C6A}', 'mayank', '2014-03-19 18:47:22'),
('{32BE90E7-DFC8-7217-0A68-0C6893C2B624}', 'mayank', '2014-03-19 19:47:48'),
('{C100CC0E-451E-C3C8-A3CB-D549F8CB645F}', 'mayank', '2014-03-19 21:23:14'),
('{DA9B1B54-4AAF-4C7B-B437-A9852ECC2103}', 'mayank', '2014-03-19 21:33:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(500) NOT NULL,
  `passwd` varchar(100) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `name`, `username`, `email`, `passwd`) VALUES
(1, 'Mayank', 'mayank', 'mayank@gmail.com', '308a3820e4cccbe043cb5228de5e71e3');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
