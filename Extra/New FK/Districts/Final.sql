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
  KEY `procode` (`procode`),
  CONSTRAINT `fk_district_province` FOREIGN KEY (`procode`) REFERENCES `province`(`procode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;


INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D01', 'COLOMBO', 'P05', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D02', 'GAMPAHA', 'P05', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D03', 'KALUTARA', 'P05', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D04', 'KANDY', 'P01', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D05', 'MATALE', 'P01', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D06', 'NUWARA ELIYA', 'P01', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D07', 'GALLE', 'P08', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D08', 'MATARA', 'P08', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D09', 'HAMBANTOTA', 'P08', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D10', 'JAFFNA', 'P04', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D11', 'KILINOCHCHI', 'P04', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D12', 'MANNAR', 'P04', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D13', 'VAVUNIA', 'P04', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D14', 'MULLATIVU', 'P04', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D15', 'BATTICALOA', 'P02', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D16', 'AMPARA', 'P02', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D17', 'TRINCOMALEE', 'P02', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D18', 'KURUNEGALA', 'P06', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D19', 'PUTTALAM', 'P06', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D20', 'ANURADHAPURA', 'P03', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D21', 'POLONNARUWA', 'P03', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D22', 'BADULLA', 'P09', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D23', 'MONARAGALA', 'P09', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D24', 'RATNAPURA', 'P07', '', '', '1');
INSERT INTO district (distcode, distname, procode, distname_si, distname_ta, status) VALUES ('D25', 'KEGALLE', 'P07', '', '', '1');
