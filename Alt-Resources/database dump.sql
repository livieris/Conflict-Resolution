-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 10, 2015 at 12:50 PM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `livies11`
--

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `userName` varchar(30) NOT NULL,
  `clientNote` varchar(500) DEFAULT 'None',
  `staffNote` varchar(500) DEFAULT 'None',
  PRIMARY KEY (`userName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`userName`, `clientNote`, `staffNote`) VALUES
('fatguylooker', 'This is a note, may be a short note, could be a long note, no one will ever know. However yesterday at the market I saw the funniest thing. A fat guy licking a freezer door... He said he was most thirsty and couldn''t help himself. What in the heck.', 'None'),
('hammod27', '																		Notes for hammod27																		', '																		This is a note by the staff for hammod27 edit																		'),
('livies11', 'another note						', 'Hey just the staff making some notes!						'),
('taco_tuesday!', 'a note', 'None'),
('User1', '', 'None');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `userName` varchar(30) NOT NULL,
  `client` varchar(1) NOT NULL,
  `staff` varchar(1) NOT NULL,
  `company` varchar(1) NOT NULL,
  PRIMARY KEY (`userName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`userName`, `client`, `staff`, `company`) VALUES
('admin', '', 'y', ''),
('company', '', '', 'y'),
('fatguylooker', 'y', '', ''),
('hammod27', 'y', '', ''),
('livies11', 'y', '', ''),
('taco_tuesday!', 'y', '', ''),
('User1', 'y', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `registration_login`
--

CREATE TABLE IF NOT EXISTS `registration_login` (
  `userName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `state` varchar(30) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `company` varchar(40) DEFAULT 'none',
  PRIMARY KEY (`userName`),
  UNIQUE KEY `userName` (`userName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registration_login`
--

INSERT INTO `registration_login` (`userName`, `lastName`, `firstName`, `password`, `email`, `phone`, `address`, `state`, `city`, `company`) VALUES
('admin', 'admin last name', 'admin first name', 'admin', 'myemail@email.com', '911-gethelpnow', '123 Fake St', 'AL', 'Oshkosh', 'None'),
('company', 'Big', 'Tom', 'company', 'mrbig@email.com', '9049569875', '12356 Fox River ', 'WI', 'Oshkosh', 'XYZ Inc'),
('fatguylooker', 'tutone', 'tommy', 'jenny', 'anemail@email.com', '789-456-7895', '54 fat guy lane', 'WI', 'Oshkosh', 'XYZ Inc'),
('hammod27', 'Hammond', 'Dan', 'dandan', 'email@email.email', '8675309', '123 Fake St.', 'WI', 'Oshkosh', 'DANS DIE HARD FAN CLUB'),
('livies11', 'Livieri', 'Shane', 'tacos', 'myemail@email.com', '911-gethelpnow', '123 Fake St', 'AL', 'Oshkosh', 'XYZ Inc'),
('taco_tuesday!', 'Livieri', 'Timmy', 'taco', 'anemail@email.com', '911', '456 Fake st', 'WV', 'Kantetd', 'Finder Kepper'),
('User1', 'test', 'test', 'test', 'test@test.test', '26262626262', 'test', 'AL', 'test', 'XYZ Inc');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(30) NOT NULL,
  `serviceType` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `fee` varchar(30) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `userName`, `serviceType`, `date`, `fee`, `location`) VALUES
(27, 'fatguylooker', 'Consultation', '2015-12-18', '20.36', 'Green Bay'),
(28, 'hammod27', 'Training', '2015-12-14', '25.00', 'Paris'),
(29, 'hammod27', 'Consultation', '2015-12-09', '30.25', 'New York'),
(31, 'livies11', 'another training', '2015-01-17', '30.00', 'Oshkosh'),
(32, 'taco_tuesday!', 'Training', '2015-01-11', '20.00', 'Fond du Lac'),
(33, 'livies11', 'Coaching', '2015-01-15', '20.00', 'Danger Town'),
(34, 'livies11', 'Facilitation', '2015-01-15', '20.00', 'Danger Town'),
(35, 'livies11', 'Consultation', '2015-11-19', '30.00', 'Oshkosh'),
(37, 'livies11', 'Coaching', '2016-11-20', '78', 'England'),
(38, 'User1', NULL, NULL, NULL, NULL),
(41, 'livies11', 'Training', '1995-03-03', '50', 'Oshkosh'),
(43, 'hammod27', 'Facilitation', '2006-03-03', '89289', 'Nowhere');

-- --------------------------------------------------------

--
-- Table structure for table `service_request`
--

CREATE TABLE IF NOT EXISTS `service_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(30) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `dateFrom` varchar(30) DEFAULT NULL,
  `dateTo` varchar(30) DEFAULT NULL,
  `location` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `service_request`
--

INSERT INTO `service_request` (`id`, `userName`, `type`, `dateFrom`, `dateTo`, `location`) VALUES
(22, 'livies11', 'Coaching', '2015-02-15', '2015-11-26', 'England'),
(23, 'User1', NULL, NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
