CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `ImagePerfil` varchar(255) DEFAULT NULL,
  `Nome` varchar(55) DEFAULT NULL,
  `Sobrenome` varchar(55) DEFAULT NULL,
  `Sexo` int(11) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `ide_busines` int(11) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(14) DEFAULT NULL,
  `Cel` varchar(16) DEFAULT NULL,
  `Password` varchar(45) DEFAULT NULL,
  `AlterPass` varchar(255) DEFAULT NULL,
  `Permissions` text,
  `Cadastro` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO users VALUES ( NULL, '', 'Admin', 'Geral', '', '', '', 'admin@admin.com', '', '', '202cb962ac59075b964b07152d234b70', 'NULL', '', NOW() );
