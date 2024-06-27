DROP TABLE IF EXISTS `province`;
CREATE TABLE IF NOT EXISTS `province` (
procode varchar(3) primary key,
province varchar(50)
)ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;
COMMIT;

INSERT INTO `province` (`procode`, `province`) VALUES
('P01', 'Central Province'),
('P02', 'Eastern Province'),
('P03', 'North Central Province'),
('P04', 'Northern Province'),
('P05', 'Western Province'),
('P06', 'North Western Province'),
('P07', 'Sabaragamuwa Province'),
('P08', 'Southern Province'),
('P09', 'Uva Province');