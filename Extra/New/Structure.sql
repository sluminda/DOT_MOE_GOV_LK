-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jun 27, 2024 at 05:05 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dot_moe_gov_lk`
--

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

DROP TABLE IF EXISTS `district`;
CREATE TABLE IF NOT EXISTS `district` (
  `distcode` varchar(3) NOT NULL,
  `distname` varchar(12) DEFAULT '',
  `procode` varchar(3) DEFAULT '',
  `distname_si` varchar(30) DEFAULT '',
  `distname_ta` varchar(30) DEFAULT '',
  `status` int DEFAULT '0',
  PRIMARY KEY (`distcode`),
  KEY `distcode` (`distcode`),
  KEY `procode` (`procode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

DROP TABLE IF EXISTS `division`;
CREATE TABLE IF NOT EXISTS `division` (
  `divcode` varchar(6) NOT NULL,
  `divisionname` varchar(30) DEFAULT '',
  `distcode` varchar(3) DEFAULT '',
  `zonecode` varchar(6) DEFAULT '',
  `divisionname_si` varchar(30) DEFAULT '',
  `divisionname_ta` varchar(30) DEFAULT '',
  `status` int DEFAULT '0',
  PRIMARY KEY (`divcode`),
  KEY `divcode` (`divcode`),
  KEY `zonecode` (`zonecode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `institutions`
--

DROP TABLE IF EXISTS `institutions`;
CREATE TABLE IF NOT EXISTS `institutions` (
  `InstType` char(10) DEFAULT NULL,
  `Old_CenCode` varchar(8) NOT NULL,
  `Old_InstitutionName` varchar(100) DEFAULT '',
  `New_CenCode` varchar(8) DEFAULT '',
  `New_InstitutionName` varchar(100) DEFAULT '',
  `ProCode` varchar(3) DEFAULT '',
  `DistrictCode` varchar(3) DEFAULT '',
  `ZoneCode` varchar(6) DEFAULT '',
  `DivisionCode` varchar(6) DEFAULT '',
  `IsNationalSchool` tinyint(1) DEFAULT NULL,
  `SchoolType` int DEFAULT '0',
  `SchoolStatus` char(1) DEFAULT 'N',
  PRIMARY KEY (`Old_CenCode`),
  KEY `ProCode` (`ProCode`),
  KEY `DistrictCode` (`DistrictCode`),
  KEY `ZoneCode` (`ZoneCode`),
  KEY `DivisionCode` (`DivisionCode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

DROP TABLE IF EXISTS `province`;
CREATE TABLE IF NOT EXISTS `province` (
  `procode` varchar(6) NOT NULL,
  `province` varchar(50) DEFAULT '',
  PRIMARY KEY (`procode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

DROP TABLE IF EXISTS `zone`;
CREATE TABLE IF NOT EXISTS `zone` (
  `zonecode` varchar(6) NOT NULL,
  `zonename` varchar(30) DEFAULT '',
  `distcode` varchar(3) DEFAULT '',
  `zonename_si` varchar(50) DEFAULT '',
  `zonename_ta` varchar(50) DEFAULT '',
  `status` int DEFAULT '0',
  PRIMARY KEY (`zonecode`),
  KEY `zonecode` (`zonecode`),
  KEY `distcode` (`distcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
