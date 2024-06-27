DROP TABLE IF EXISTS zone;
CREATE TABLE IF NOT EXISTS zone (
  zonecode varchar(6) NOT NULL,
  zonename varchar(30) DEFAULT '',
  distcode varchar(3) DEFAULT '',
  zonename_si varchar(50) DEFAULT '',
  zonename_ta varchar(50) DEFAULT '',
  status int DEFAULT '0',
  PRIMARY KEY (zonecode),
  KEY zonecode (zonecode),
  KEY distcode (distcode)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;
COMMIT;




INSERT INTO zone (zonecode, zonename, distcode, zonename_si, zonename_ta, status) VALUES ('ZN0101', 'COLOMBO', 'D01', '', '', 1),
('ZN0102', 'HOMAGAMA', 'D01', '', '', 1),
('ZN0103', 'SRI JAYAWARDANAPURA', 'D01', '', '', 1),
('ZN0104', 'PILIYANDALA', 'D01', '', '', 1),
('ZN0201', 'GAMPAHA', 'D02', '', '', 1),
('ZN0202', 'MINUWANGODA', 'D02', '', '', 1),
('ZN0203', 'NEGOMBO', 'D02', '', '', 1),
('ZN0204', 'KELANIYA', 'D02', '', '', 1),
('ZN0301', 'KALUTARA', 'D03', '', '', 1),
('ZN0302', 'MATUGAMA', 'D03', '', '', 1),
('ZN0303', 'HORANA', 'D03', '', '', 1),
('ZN0401', 'KANDY', 'D04', '', '', 1),
('ZN0403', 'DENUWARA', 'D04', '', '', 1),
('ZN0404', 'GAMPOLA', 'D04', '', '', 1),
('ZN0405', 'TELDENIYA', 'D04', '', '', 1),
('ZN0406', 'WATHTHEGAMA', 'D04', '', '', 1),
('ZN0407', 'KATUGASTOTA', 'D04', '', '', 1),
('ZN0501', 'MATALE', 'D05', '', '', 1),
('ZN0502', 'GALEWELA', 'D05', '', '', 1),
('ZN0503', 'NAULA', 'D05', '', '', 1),
('ZN0504', 'WILGAMUWA', 'D05', '', '', 1),
('ZN0601', 'NUWARA ELIYA', 'D06', '', '', 1),
('ZN0602', 'KOTMALE', 'D06', '', '', 1),
('ZN0603', 'HATTON', 'D06', '', '', 1),
('ZN0604', 'WALAPANE', 'D06', '', '', 1),
('ZN0605', 'HANGURANKETHA', 'D06', '', '', 1),
('ZN0701', 'GALLE', 'D07', '', '', 1),
('ZN0702', 'ELPITIYA', 'D07', '', '', 1),
('ZN0703', 'AMBALANGODA', 'D07', '', '', 1),
('ZN0705', 'UDUGAMA', 'D07', '', '', 1),
('ZN0801', 'MATARA', 'D08', '', '', 1),
('ZN0802', 'AKURESSA', 'D08', '', '', 1),
('ZN0803', 'MULATIYANA (HAKMANA)', 'D08', '', '', 1),
('ZN0804', 'MORAWAKA (DENIYAYA)', 'D08', '', '', 1),
('ZN0901', 'TANGALLE', 'D09', '', '', 1),
('ZN0902', 'HAMBANTOTA', 'D09', '', '', 1),
('ZN0903', 'WALASMULLA', 'D09', '', '', 1),
('ZN1001', 'JAFFNA', 'D10', '', '', 1),
('ZN1002', 'ISLANDS', 'D10', '', '', 1),
('ZN1003', 'THENMARACHCHI', 'D10', '', '', 1),
('ZN1004', 'VALIKAMAM', 'D10', '', '', 1),
('ZN1005', 'VADAMARACHCHI', 'D10', '', '', 1),
('ZN1101', 'KILINOCHCHI NORTH', 'D11', '', '', 1),
('ZN1102', 'KILINOCHCHI SOUTH', 'D11', '', '', 1),
('ZN1201', 'MANNAR', 'D12', '', '', 1),
('ZN1202', 'MADHU', 'D12', '', '', 1),
('ZN1301', 'VAVUNIYA SOUTH', 'D13', '', '', 1),
('ZN1302', 'VAVUNIYA NORTH', 'D13', '', '', 1),
('ZN1401', 'MULLAITIVU', 'D14', '', '', 1),
('ZN1402', 'THUNUKKAI', 'D14', '', '', 1),
('ZN1501', 'BATTICALOA', 'D15', '', '', 1),
('ZN1502', 'KALKUDAH', 'D15', '', '', 1),
('ZN1503', 'PADDRIPPU', 'D15', '', '', 1),
('ZN1504', 'BATTICALOA CENTRAL', 'D15', '', '', 1),
('ZN1505', 'BATTICALOA WEST', 'D15', '', '', 1),
('ZN1601', 'AMPARA', 'D16', '', '', 1),
('ZN1602', 'KALMUNAI', 'D16', '', '', 1),
('ZN1603', 'SAMMANTHURAI', 'D16', '', '', 1),
('ZN1604', 'MAHAOYA', 'D16', '', '', 1),
('ZN1605', 'DEHIATTAKANDIYA', 'D16', '', '', 1),
('ZN1606', 'AKKARAIPATTU', 'D16', '', '', 1),
('ZN1607', 'THIRUKKOVIL', 'D16', '', '', 1),
('ZN1701', 'TRINCOMALEE', 'D17', '', '', 1),
('ZN1702', 'MUTTUR', 'D17', '', '', 1),
('ZN1703', 'KANTALE', 'D17', '', '', 1),
('ZN1704', 'KINNIYA', 'D17', '', '', 1),
('ZN1705', 'TRINCOMALEE NORTH', 'D17', '', '', 1),
('ZN1801', 'KURUNEGALA', 'D18', '', '', 1),
('ZN1802', 'KULIYAPITIYA', 'D18', '', '', 1),
('ZN1803', 'NIKAWERATIYA', 'D18', '', '', 1),
('ZN1804', 'MAHO', 'D18', '', '', 1),
('ZN1805', 'GIRIULLA', 'D18', '', '', 1),
('ZN1806', 'IBBAGAMUWA', 'D18', '', '', 1),
('ZN1901', 'PUTTALAM', 'D19', '', '', 1),
('ZN1902', 'CHILAW', 'D19', '', '', 1),
('ZN2001', 'ANURADHAPURA', 'D20', '', '', 1),
('ZN2002', 'THAMBUTTEGAMA', 'D20', '', '', 1),
('ZN2003', 'KEKIRAWA', 'D20', '', '', 1),
('ZN2004', 'GALENBINDUNUWEWA', 'D20', '', '', 1),
('ZN2005', 'KEBITHIGOLLEWA', 'D20', '', '', 1),
('ZN2101', 'POLONNARUWA', 'D21', '', '', 1),
('ZN2102', 'HINGURAKGODA', 'D21', '', '', 1),
('ZN2103', 'DIMBULAGALA', 'D21', '', '', 1),
('ZN2201', 'BADULLA', 'D22', '', '', 1),
('ZN2202', 'BANDARAWELA', 'D22', '', '', 1),
('ZN2203', 'MAHIYANGANAYA', 'D22', '', '', 1),
('ZN2204', 'WELIMADA', 'D22', '', '', 1),
('ZN2205', 'PASSARA', 'D22', '', '', 1),
('ZN2206', 'VIYALUWA', 'D22', '', '', 1),
('ZN2301', 'MONERAGALA', 'D23', '', '', 1),
('ZN2302', 'WELLAWAYA', 'D23', '', '', 1),
('ZN2303', 'BIBILE', 'D23', '', '', 1),
('ZN2304', 'THANAMALVILA', 'D23', '', '', 1),
('ZN2401', 'RATNAPURA', 'D24', '', '', 1),
('ZN2403', 'BALANGODA', 'D24', '', '', 1),
('ZN2404', 'NIVITIGALA', 'D24', '', '', 1),
('ZN2405', 'EMBILIPITIYA', 'D24', '', '', 1),
('ZN2501', 'KEGALLE', 'D25', '', '', 1),
('ZN2503', 'MAWANELLA', 'D25', '', '', 1),
('ZN2504', 'DEHIOWITA', 'D25', '', '', 1);