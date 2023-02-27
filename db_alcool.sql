-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 02-Jul-2022 às 12:51
-- Versão do servidor: 5.7.36
-- versão do PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_alcool`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pedido`
--

DROP TABLE IF EXISTS `tb_pedido`;
CREATE TABLE IF NOT EXISTS `tb_pedido` (
  `id_pedido` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_pf` bigint(20) NOT NULL,
  `id_pj` bigint(20) NOT NULL,
  `id_produto` bigint(20) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pedido`),
  KEY `id_pf` (`id_pf`),
  KEY `id_pj` (`id_pj`),
  KEY `id_produto` (`id_produto`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_pedido`
--

INSERT INTO `tb_pedido` (`id_pedido`, `id_pf`, `id_pj`, `id_produto`, `quantidade`, `valor`, `data`) VALUES
(19, 56, 3, 12, 2, 40, '2022-06-09 16:17:21'),
(18, 55, 5, 20, 1, 15, '2022-06-09 15:31:57'),
(17, 53, 5, 20, 2, 31, '2022-06-09 15:28:58'),
(16, 53, 5, 20, 1, 15, '2022-06-09 15:28:00'),
(60, 53, 3, 12, 1, 20, '2022-06-17 21:43:58'),
(7, 54, 3, 19, 2, 43, '2022-06-08 15:40:59'),
(8, 54, 3, 19, 1, 22, '2022-06-08 15:55:55'),
(9, 54, 3, 19, 1, 22, '2022-06-08 15:56:45'),
(10, 54, 3, 19, 1, 22, '2022-06-08 15:57:56'),
(11, 54, 3, 19, 1, 22, '2022-06-08 16:01:00'),
(12, 54, 3, 15, 2, 70, '2022-06-08 16:01:45'),
(13, 53, 3, 22, 2, 100, '2022-06-08 16:10:19'),
(14, 53, 3, 22, 2, 100, '2022-06-08 16:10:50'),
(15, 53, 3, 22, 1, 50, '2022-06-08 16:19:19'),
(20, 59, 3, 14, 1, 40, '2022-06-10 15:11:50'),
(21, 60, 8, 11, 1, 20, '2022-06-10 15:38:33'),
(31, 53, 3, 19, 2, 43, '2022-06-11 17:11:34'),
(50, 56, 8, 11, 1, 20, '2022-06-13 15:35:50'),
(49, 53, 3, 12, 1, 20, '2022-06-13 15:33:05'),
(48, 53, 3, 12, 1, 20, '2022-06-13 15:28:05'),
(47, 58, 8, 11, 1, 20, '2022-06-13 15:26:28'),
(46, 53, 3, 14, 1, 40, '2022-06-13 15:24:02'),
(45, 53, 3, 12, 1, 20, '2022-06-13 15:23:52'),
(51, 53, 3, 12, 1, 20, '2022-06-13 15:36:30'),
(52, 61, 3, 22, 2, 100, '2022-06-13 18:41:06'),
(53, 61, 8, 11, 1, 20, '2022-06-13 18:48:52'),
(56, 64, 3, 22, 1, 100, '2022-06-13 18:58:25'),
(61, 62, 6, 17, 1, 15, '2022-06-20 15:21:59');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pf`
--

DROP TABLE IF EXISTS `tb_pf`;
CREATE TABLE IF NOT EXISTS `tb_pf` (
  `id_pf` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) NOT NULL DEFAULT '0',
  `nome_pf` text NOT NULL,
  `cpf` text NOT NULL,
  `cidade` text NOT NULL,
  `hipertensao` varchar(1) NOT NULL DEFAULT 'n',
  `asma` varchar(1) NOT NULL DEFAULT 'n',
  `diabet` varchar(1) NOT NULL DEFAULT 'n',
  `fuma` varchar(1) NOT NULL DEFAULT 'n',
  `prioridade` int(11) DEFAULT NULL,
  `ultima_compra` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pf`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_pf`
--

INSERT INTO `tb_pf` (`id_pf`, `id_usuario`, `nome_pf`, `cpf`, `cidade`, `hipertensao`, `asma`, `diabet`, `fuma`, `prioridade`, `ultima_compra`) VALUES
(55, 60, 'teste3', '123.928.116-03', 'Pouso Alegre', 'n', 's', 'n', 'n', 1, 1655089200),
(54, 59, 'teste2', '123.928.116-02', 'Santa Rita do Sapucai', 'n', 's', 's', 's', 3, 0),
(53, 58, 'teste1', '123.928.116-01', 'Santa Rita do Sapucai', 's', 'n', 'n', 'n', 1, 0),
(56, 61, 'teste4', '123.928.116-04', 'Itajuba', 'n', 'n', 'n', 'n', 0, 1655089200),
(57, 62, 'teste5', '123.928.116-05', 'Pouso Alegre', 'n', 's', 'n', 'n', 1, 1653706800),
(59, 71, 'cliente1', '893.928.116-45', 'Santa Rita do Sapucai', 'n', 'n', 'n', 'n', 0, 1654743600),
(60, 72, 'Cleiton', '723.928.116-45', 'Itajuba', 'n', 'n', 's', 'n', 1, 1655002800),
(61, 73, 'prio1', '123.968.116-45', 'Itajuba', 's', 'n', 'n', 'n', 1, 1655089200),
(62, 74, 'prio2', '123.925.116-78', 'Pouso Alegre', 's', 's', 'n', 'n', 2, 1655694000),
(63, 75, 'prio3', '123.928.116-82', 'Santa Rita do Sapucai', 's', 's', 's', 'n', 3, 0),
(64, 76, 'prio4', '863.928.116-78', 'Pouso Alegre', 's', 's', 's', 's', 4, 1655089200),
(65, 77, 'teste41', '123.928.286-45', 'Santa Rita do Sapucai', 's', 'n', 'n', 'n', 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pj`
--

DROP TABLE IF EXISTS `tb_pj`;
CREATE TABLE IF NOT EXISTS `tb_pj` (
  `id_pj` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) NOT NULL,
  `nome_pj` text NOT NULL,
  `cnpj` text NOT NULL,
  `cidade` text NOT NULL,
  PRIMARY KEY (`id_pj`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_pj`
--

INSERT INTO `tb_pj` (`id_pj`, `id_usuario`, `nome_pj`, `cnpj`, `cidade`) VALUES
(9, 78, 'estab31', '12.123.123/7601-16', 'Santa Rita do Sapucai'),
(3, 63, 'estab1', '12.123.123/0001-02', 'Santa Rita do Sapucai'),
(4, 64, 'estab2', '12.123.123/0001-03', 'Santa Rita do Sapucai'),
(5, 65, 'estab3', '12.123.123/0001-04', 'Santa Rita do Sapucai'),
(6, 66, 'estab4', '12.123.123/0001-05', 'Pouso Alegre'),
(7, 67, 'estab5', '12.123.123/0001-06', 'Pouso Alegre'),
(8, 68, 'estab10', '12.123.123/0001-17', 'Itajuba');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_produto`
--

DROP TABLE IF EXISTS `tb_produto`;
CREATE TABLE IF NOT EXISTS `tb_produto` (
  `id_produto` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_pj` bigint(20) NOT NULL,
  `nome_produto` text NOT NULL,
  `valor` text NOT NULL,
  `quantidade` int(11) NOT NULL,
  PRIMARY KEY (`id_produto`),
  KEY `id_pj` (`id_pj`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_produto`
--

INSERT INTO `tb_produto` (`id_produto`, `id_pj`, `nome_produto`, `valor`, `quantidade`) VALUES
(14, 3, 'Master Alcool', '40.00', 74),
(15, 3, 'Alcool Plus', '35.00', 77),
(12, 3, 'Master Gel', '20.00', 24),
(11, 8, 'Master Alcool', '20.00', 45),
(16, 6, 'Master Alcool', '20.00', 46),
(17, 6, 'Alcool+', '15.00', 67),
(18, 6, 'Alcool-', '14.00', 50),
(19, 3, 'Alcool', '21.50', 77),
(20, 5, 'Alcool Mil', '15.40', 85),
(21, 5, 'Alcool Minas', '8.00', 50),
(22, 3, 'Alcool Raro', '55.00', 4),
(26, 3, 'Alcool Minas', '20.00', 50),
(27, 3, 'Alcool Futura', '15.50', 70),
(29, 5, 'Askov', '25.00', 6),
(30, 5, 'Smirnoff', '45.00', 30);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

DROP TABLE IF EXISTS `tb_usuario`;
CREATE TABLE IF NOT EXISTS `tb_usuario` (
  `id_usuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `nivel` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`id_usuario`, `email`, `senha`, `nivel`) VALUES
(72, 'cleiton@alcool.br', '202cb962ac59075b964b07152d234b70', 1),
(71, 'cliente1@alcool.br', '202cb962ac59075b964b07152d234b70', 1),
(70, 'cliente1@alcool.br', '202cb962ac59075b964b07152d234b70', 1),
(36, 'adm@alcool.br', '202cb962ac59075b964b07152d234b70', 3),
(68, 'estab10@alcool.br', '202cb962ac59075b964b07152d234b70', 2),
(67, 'estab5@alcool.br', '202cb962ac59075b964b07152d234b70', 2),
(66, 'estab4@alcool.br', '202cb962ac59075b964b07152d234b70', 2),
(65, 'estab3@alcool.br', '202cb962ac59075b964b07152d234b70', 2),
(64, 'estab2@alcool.br', '202cb962ac59075b964b07152d234b70', 2),
(63, 'estab1@alcool.br', '202cb962ac59075b964b07152d234b70', 2),
(62, 'teste5@alcool.br', '202cb962ac59075b964b07152d234b70', 1),
(61, 'teste4@alcool.br', '202cb962ac59075b964b07152d234b70', 1),
(60, 'teste3@alcool.br', '202cb962ac59075b964b07152d234b70', 1),
(59, 'teste2@alcool.br', '202cb962ac59075b964b07152d234b70', 1),
(58, 'teste1@alcool.br', '202cb962ac59075b964b07152d234b70', 1),
(73, 'prio1@alcool.br', '202cb962ac59075b964b07152d234b70', 1),
(74, 'prio2@alcool.br', '202cb962ac59075b964b07152d234b70', 1),
(75, 'prio3@alcool.br', '202cb962ac59075b964b07152d234b70', 1),
(76, 'prio4@alcool.br', '202cb962ac59075b964b07152d234b70', 1),
(77, 'teste41@alcool.br', '202cb962ac59075b964b07152d234b70', 1),
(78, 'estab31@alcool.br', '202cb962ac59075b964b07152d234b70', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
