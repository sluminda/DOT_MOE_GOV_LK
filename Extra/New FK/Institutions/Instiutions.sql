-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 27, 2024 at 08:32 AM
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
-- Table structure for table `institutes`
--

DROP TABLE IF EXISTS `institutions`;
CREATE TABLE IF NOT EXISTS `institutions` (
  `InstType` char(10),
  `Old_CenCode` varchar(8) NOT NULL,
  `Old_InstitutionName` varchar(100) DEFAULT '',
  `New_CenCode` varchar(8) DEFAULT '',
  `New_InstitutionName` varchar(100) DEFAULT '',
  `ProCode` varchar(3) DEFAULT '',
  `DistrictCode` varchar(3) DEFAULT '',
  `ZoneCode` varchar(6) DEFAULT '',
  `DivisionCode` varchar(6) DEFAULT '',
  `IsNationalSchool` tinyint(1),
  `SchoolType` int DEFAULT '0',
  `SchoolStatus` char(1) DEFAULT 'N',
  PRIMARY KEY (`Old_CenCode`),
  KEY `ProCode` (`ProCode`),
  KEY `DistrictCode` (`DistrictCode`),
  KEY `ZoneCode` (`ZoneCode`),
  KEY `DivisionCode` (`DivisionCode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
