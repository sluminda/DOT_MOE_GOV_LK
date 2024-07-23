-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jun 30, 2024 at 07:24 AM
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
  KEY `procode` (`procode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  KEY `zonecode` (`zonecode`),
  KEY `distcode` (`distcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otp_requests`
--

DROP TABLE IF EXISTS `otp_requests`;
CREATE TABLE IF NOT EXISTS `otp_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `otp_hash` varchar(150) NOT NULL,
  `expires_at` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

DROP TABLE IF EXISTS `province`;
CREATE TABLE IF NOT EXISTS `province` (
  `procode` varchar(6) NOT NULL,
  `province` varchar(50) DEFAULT '',
  PRIMARY KEY (`procode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workplace_details`
--

DROP TABLE IF EXISTS `workplace_details`;
CREATE TABLE IF NOT EXISTS `workplace_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullName` varchar(250) NOT NULL,
  `nameWithInitials` varchar(250) NOT NULL,
  `nic` varchar(12) NOT NULL,
  `email` varchar(250) NOT NULL,
  `whatsappNumber` varchar(10) NOT NULL,
  `mobileNumber` varchar(10) NOT NULL,
  `headOfInstituteName` varchar(250) NOT NULL,
  `headOfInstituteContactNo` varchar(10) NOT NULL,
  `currentWorkingPlace` varchar(50) NOT NULL,
  `selectedInstituteCode` varchar(8) NOT NULL,
  `selectedInstituteName` varchar(200) NOT NULL,
  `Province` varchar(50) DEFAULT '',
  `District` varchar(50) DEFAULT '',
  `Zone` varchar(50) DEFAULT '',
  `Division` varchar(50) DEFAULT '',
  `submittedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nic` (`nic`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `workplace_details`
--
DROP TRIGGER IF EXISTS `before_insert_workplace_details`;
DELIMITER $$
CREATE TRIGGER `before_insert_workplace_details` BEFORE INSERT ON `workplace_details` FOR EACH ROW BEGIN
    DECLARE v_ProCode VARCHAR(3);
    DECLARE v_DistrictCode VARCHAR(3);
    DECLARE v_ZoneCode VARCHAR(6);
    DECLARE v_DivisionCode VARCHAR(6);
    
    -- Fetch codes from institutions table
    SELECT ProCode, DistrictCode, ZoneCode, DivisionCode
    INTO v_ProCode, v_DistrictCode, v_ZoneCode, v_DivisionCode
    FROM institutions
    WHERE New_CenCode = NEW.selectedInstituteCode;
    
    -- Fetch names from province, district, zone, and division tables
    SELECT province INTO @Province FROM province WHERE procode = v_ProCode;
    SELECT distname INTO @District FROM district WHERE distcode = v_DistrictCode;
    SELECT zonename INTO @Zone FROM zone WHERE zonecode = v_ZoneCode;
    SELECT divisionname INTO @Division FROM division WHERE divcode = v_DivisionCode;
    
    SET NEW.Province = @Province;
    SET NEW.District = @District;
    SET NEW.Zone = @Zone;
    SET NEW.Division = @Division;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_workplace_details`;
DELIMITER $$
CREATE TRIGGER `before_update_workplace_details` BEFORE UPDATE ON `workplace_details` FOR EACH ROW BEGIN
    DECLARE v_ProCode VARCHAR(3);
    DECLARE v_DistrictCode VARCHAR(3);
    DECLARE v_ZoneCode VARCHAR(6);
    DECLARE v_DivisionCode VARCHAR(6);

    -- Fetch codes from institutions table
    SELECT ProCode, DistrictCode, ZoneCode, DivisionCode
    INTO v_ProCode, v_DistrictCode, v_ZoneCode, v_DivisionCode
    FROM institutions
    WHERE New_CenCode = NEW.selectedInstituteCode;

    -- Fetch names from province, district, zone, and division tables
    SELECT province INTO @Province FROM province WHERE procode = v_ProCode;
    SELECT distname INTO @District FROM district WHERE distcode = v_DistrictCode;
    SELECT zonename INTO @Zone FROM zone WHERE zonecode = v_ZoneCode;
    SELECT divisionname INTO @Division FROM division WHERE divcode = v_DivisionCode;

    SET NEW.Province = @Province;
    SET NEW.District = @District;
    SET NEW.Zone = @Zone;
    SET NEW.Division = @Division;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `workplace_details_history`
--

DROP TABLE IF EXISTS `workplace_details_history`;
CREATE TABLE IF NOT EXISTS `workplace_details_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullName` varchar(250) NOT NULL,
  `nameWithInitials` varchar(250) NOT NULL,
  `nic` varchar(12) NOT NULL,
  `email` varchar(250) NOT NULL,
  `whatsappNumber` varchar(10) NOT NULL,
  `mobileNumber` varchar(10) NOT NULL,
  `headOfInstituteName` varchar(250) NOT NULL,
  `headOfInstituteContactNo` varchar(10) NOT NULL,
  `currentWorkingPlace` varchar(50) NOT NULL,
  `selectedInstituteCode` varchar(8) NOT NULL,
  `selectedInstituteName` varchar(200) NOT NULL,
  `Province` varchar(50) DEFAULT '',
  `District` varchar(50) DEFAULT '',
  `Zone` varchar(50) DEFAULT '',
  `Division` varchar(50) DEFAULT '',
  `submittedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `workplace_details_history`
--
DROP TRIGGER IF EXISTS `before_insert_workplace_details_history`;
DELIMITER $$
CREATE TRIGGER `before_insert_workplace_details_history` BEFORE INSERT ON `workplace_details_history` FOR EACH ROW BEGIN
    DECLARE v_ProCode VARCHAR(3);
    DECLARE v_DistrictCode VARCHAR(3);
    DECLARE v_ZoneCode VARCHAR(6);
    DECLARE v_DivisionCode VARCHAR(6);

    -- Fetch codes from institutions table
    SELECT ProCode, DistrictCode, ZoneCode, DivisionCode
    INTO v_ProCode, v_DistrictCode, v_ZoneCode, v_DivisionCode
    FROM institutions
    WHERE New_CenCode = NEW.selectedInstituteCode;

    -- Fetch names from province, district, zone, and division tables
    SELECT province INTO @Province FROM province WHERE procode = v_ProCode;
    SELECT distname INTO @District FROM district WHERE distcode = v_DistrictCode;
    SELECT zonename INTO @Zone FROM zone WHERE zonecode = v_ZoneCode;
    SELECT divisionname INTO @Division FROM division WHERE divcode = v_DivisionCode;

    SET NEW.Province = @Province;
    SET NEW.District = @District;
    SET NEW.Zone = @Zone;
    SET NEW.Division = @Division;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_workplace_details_history`;
DELIMITER $$
CREATE TRIGGER `before_update_workplace_details_history` BEFORE UPDATE ON `workplace_details_history` FOR EACH ROW BEGIN
    DECLARE v_ProCode VARCHAR(3);
    DECLARE v_DistrictCode VARCHAR(3);
    DECLARE v_ZoneCode VARCHAR(6);
    DECLARE v_DivisionCode VARCHAR(6);

    -- Fetch codes from institutions table
    SELECT ProCode, DistrictCode, ZoneCode, DivisionCode
    INTO v_ProCode, v_DistrictCode, v_ZoneCode, v_DivisionCode
    FROM institutions
    WHERE New_CenCode = NEW.selectedInstituteCode;

    -- Fetch names from province, district, zone, and division tables
    SELECT province INTO @Province FROM province WHERE procode = v_ProCode;
    SELECT distname INTO @District FROM district WHERE distcode = v_DistrictCode;
    SELECT zonename INTO @Zone FROM zone WHERE zonecode = v_ZoneCode;
    SELECT divisionname INTO @Division FROM division WHERE divcode = v_DivisionCode;

    SET NEW.Province = @Province;
    SET NEW.District = @District;
    SET NEW.Zone = @Zone;
    SET NEW.Division = @Division;
END
$$
DELIMITER ;

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
  KEY `distcode` (`distcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;