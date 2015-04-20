-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tempo de Geração: 
-- Versão do Servidor: 5.5.27
-- Versão do PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `cpb`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cia`
--

CREATE TABLE IF NOT EXISTS `cia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `desconto` float(11,1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `cia`
--

INSERT INTO `cia` (`id`, `nome`, `desconto`) VALUES
(1, 'INFORME', 0.0),
(2, 'TAM', 10.0),
(3, 'AZUL', 15.0),
(4, 'AVIANCA', 2.0),
(5, 'GOL', 5.0),
(8, 'America Air Lines', 11.0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cia_aerea`
--

CREATE TABLE IF NOT EXISTS `cia_aerea` (
  `id_cia` int(11) NOT NULL AUTO_INCREMENT,
  `cia_aerea` varchar(15) NOT NULL,
  PRIMARY KEY (`id_cia`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `cia_aerea`
--

INSERT INTO `cia_aerea` (`id_cia`, `cia_aerea`) VALUES
(1, 'GOL'),
(2, 'TAM'),
(3, 'AZUL'),
(4, 'Avianca'),
(9, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cimulttemp`
--

CREATE TABLE IF NOT EXISTS `cimulttemp` (
  `ci` varchar(20) NOT NULL,
  `seq` int(11) NOT NULL,
  `id` varchar(20) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ciweb`
--

CREATE TABLE IF NOT EXISTS `ciweb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idci` varchar(11) NOT NULL,
  `resp` varchar(100) NOT NULL,
  `situacao` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `ciweb`
--

INSERT INTO `ciweb` (`id`, `idci`, `resp`, `situacao`) VALUES
(1, '6769', 'EDY WILLIAM SIQUEIRA DE MENESES', 'Finalizado'),
(2, '6712', 'PAULO ATAIDES DE OLIVEIRA', 'Desginado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `desconto`
--

CREATE TABLE IF NOT EXISTS `desconto` (
  `id_desconto` int(11) NOT NULL AUTO_INCREMENT,
  `id_cia_aerea` int(11) NOT NULL,
  `percentual` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_desconto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `desconto`
--

INSERT INTO `desconto` (`id_desconto`, `id_cia_aerea`, `percentual`) VALUES
(1, 1, 0.05),
(2, 2, 0.14),
(3, 3, 0.15),
(4, 4, 0.07);

-- --------------------------------------------------------

--
-- Estrutura da tabela `gestores`
--

CREATE TABLE IF NOT EXISTS `gestores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Extraindo dados da tabela `gestores`
--

INSERT INTO `gestores` (`id`, `nome`) VALUES
(2, 'GESTOR DE OUTRA AREA'),
(21, 'ADRIANO OSORIO DE FREITAS');

-- --------------------------------------------------------

--
-- Estrutura da tabela `msg`
--

CREATE TABLE IF NOT EXISTS `msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `msg`
--

INSERT INTO `msg` (`id`, `msg`) VALUES
(1, 'Mensagem exemplo para impressao no contracheque.'),
(6, 'Mensagem 2'),
(5, 'Nova mensagem exemplo para impressao no contracheque.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `registros`
--

CREATE TABLE IF NOT EXISTS `registros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idben` varchar(20) NOT NULL,
  `idcia` int(11) NOT NULL,
  `autorizacao` int(11) NOT NULL,
  `solicitacao` int(11) NOT NULL,
  `siconv` varchar(45) NOT NULL,
  `projeto` varchar(45) NOT NULL,
  `datainicial` date NOT NULL,
  `datafinal` date NOT NULL,
  `localizador` varchar(45) NOT NULL,
  `seq` int(11) NOT NULL,
  `vlorg` decimal(10,2) NOT NULL,
  `txEmbarque` decimal(10,2) NOT NULL,
  `txServico` decimal(10,2) NOT NULL,
  `vltot` decimal(10,2) NOT NULL,
  `bdpass` smallint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sol13`
--

CREATE TABLE IF NOT EXISTS `sol13` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `funcionario` varchar(100) NOT NULL,
  `dt_sol` varchar(20) NOT NULL,
  `gestor` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `sol13`
--

INSERT INTO `sol13` (`id`, `funcionario`, `dt_sol`, `gestor`, `status`) VALUES
(5, 'ADRIANO OSORIO DE FREITAS', '26/01/14', 'ADRIANO OSORIO DE FREITAS', 2),
(6, 'EDY WILLIAM SIQUEIRA DE MENESES', '06/05/14', 'ADRIANO OSORIO DE FREITAS', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `solferias`
--

CREATE TABLE IF NOT EXISTS `solferias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `funcionario` varchar(100) NOT NULL,
  `datainicio` varchar(20) NOT NULL,
  `datafinal` varchar(20) NOT NULL,
  `gestor` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `abono` varchar(10) NOT NULL,
  `posterior` varchar(10) NOT NULL,
  `ad13` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Extraindo dados da tabela `solferias`
--

INSERT INTO `solferias` (`id`, `funcionario`, `datainicio`, `datafinal`, `gestor`, `status`, `abono`, `posterior`, `ad13`) VALUES
(1, 'ADRIANO OSORIO DE FREITAS', '1/5/2013', '15', 'ADRIANO OSORIO DE FREITAS', 3, '', '', ''),
(4, 'ADRIANO OSORIO DE FREITAS', '6/5/2013', '10', 'ADRIANO OSORIO DE FREITAS', 3, '', '', ''),
(6, 'ADRIANO OSORIO DE FREITAS', '1/5/2013', '30', 'GESTOR DE OUTRA AREA', 1, '', '', ''),
(7, 'ADRIANO OSORIO DE FREITAS', '6/5/2013', '20', 'GESTOR DE OUTRA AREA', 2, '', '', ''),
(9, 'ADRIANO OSORIO DE FREITAS', '26/5/2013', '15', 'ADRIANO OSORIO DE FREITAS', 3, '', '', ''),
(10, 'FABIO BORGES DOS SANTOS', '6/6/2013', '12', 'ADRIANO OSORIO DE FREITAS', 2, '', '', ''),
(11, 'FABIO BORGES DOS SANTOS', '6/6/2013', '20', 'ADRIANO OSORIO DE FREITAS', 3, '', '', ''),
(12, 'FABIO BORGES DOS SANTOS', '6/6/2013', '14', 'ADRIANO OSORIO DE FREITAS', 2, '', '', ''),
(13, 'FABIO BORGES DOS SANTOS', '2/6/2013', '10', 'ADRIANO OSORIO DE FREITAS', 2, '', '', ''),
(14, 'FABIO BORGES DOS SANTOS', '16/6/2013', '20', 'ADRIANO OSORIO DE FREITAS', 2, 'abono', 'no', 'sim'),
(15, 'FABIO BORGES DOS SANTOS', '2/6/2013', '10', 'GESTOR DE OUTRA AREA', 1, 'abono', 'no', 'nao'),
(16, 'FABIO BORGES DOS SANTOS', '2/6/2013', '15', 'GESTOR DE OUTRA AREA', 1, 'no', 'posterior', 'nao'),
(17, 'FABIO BORGES DOS SANTOS', '1/6/2013', '20', 'ADRIANO OSORIO DE FREITAS', 2, 'abono', 'no', 'SIM'),
(18, 'FABIO BORGES DOS SANTOS', '10/6/2013', '20', 'ADRIANO OSORIO DE FREITAS', 2, 'abono', 'no', 'SIM'),
(19, 'FABIO BORGES DOS SANTOS', '6/6/2013', '23', 'ADRIANO OSORIO DE FREITAS', 3, 'no', '1', 'SIM'),
(20, 'FABIO BORGES DOS SANTOS', '3/6/2013', '11', 'ADRIANO OSORIO DE FREITAS', 2, 'abono', '1', 'SIM'),
(21, 'FABIO BORGES DOS SANTOS', '17/6/2013', '12', 'ADRIANO OSORIO DE FREITAS', 3, 'abono', '1', 'NAO'),
(22, 'ADRIANO OSORIO DE FREITAS', '6/1/2014', '10', 'ADRIANO OSORIO DE FREITAS', 2, 'abono', '1', 'SIM'),
(23, 'EDY WILLIAM SIQUEIRA DE MENESES', '7/5/2014', '10', 'ADRIANO OSORIO DE FREITAS', 3, 'no', '1', 'SIM'),
(24, 'ADRIANO OSORIO DE FREITAS', '28/5/2014', '10', 'ADRIANO OSORIO DE FREITAS', 1, 'no', '1', 'SIM');

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusdia`
--

CREATE TABLE IF NOT EXISTS `statusdia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dia` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=121 ;

--
-- Extraindo dados da tabela `statusdia`
--

INSERT INTO `statusdia` (`id`, `dia`, `mes`, `ano`, `status`) VALUES
(8, 18, 5, 2013, 1),
(2, 1, 5, 2013, 3),
(3, 4, 5, 2013, 1),
(4, 5, 5, 2013, 2),
(5, 11, 5, 2013, 1),
(7, 12, 5, 2013, 2),
(9, 19, 5, 2013, 2),
(10, 25, 5, 2013, 1),
(11, 26, 5, 2013, 1),
(12, 30, 5, 2013, 3),
(13, 31, 5, 2013, 4),
(14, 1, 1, 2013, 3),
(15, 5, 1, 2013, 1),
(16, 6, 1, 2013, 2),
(17, 12, 1, 2013, 1),
(18, 13, 1, 2013, 2),
(19, 19, 1, 2013, 2),
(20, 20, 1, 2013, 2),
(21, 26, 1, 2013, 1),
(22, 27, 1, 2013, 2),
(23, 29, 12, 2012, 1),
(24, 30, 12, 2012, 2),
(25, 31, 12, 2012, 4),
(26, 2, 2, 2013, 1),
(27, 3, 2, 2013, 2),
(28, 9, 2, 2013, 1),
(29, 10, 2, 2013, 2),
(30, 11, 2, 2013, 4),
(31, 12, 2, 2013, 3),
(32, 13, 2, 2013, 4),
(33, 16, 2, 2013, 1),
(34, 17, 2, 2013, 2),
(35, 23, 2, 2013, 1),
(36, 24, 2, 2013, 2),
(37, 2, 3, 2013, 1),
(38, 3, 3, 2013, 2),
(39, 9, 3, 2013, 1),
(40, 10, 3, 2013, 2),
(41, 16, 3, 2013, 1),
(42, 17, 3, 2013, 2),
(43, 23, 3, 2013, 1),
(44, 24, 3, 2013, 2),
(45, 29, 3, 2013, 3),
(46, 30, 3, 2013, 1),
(47, 31, 3, 2013, 2),
(48, 6, 4, 2013, 1),
(49, 7, 4, 2013, 2),
(50, 13, 4, 2013, 1),
(51, 14, 4, 2013, 2),
(52, 20, 4, 2013, 1),
(53, 21, 4, 2013, 2),
(54, 27, 4, 2013, 1),
(55, 28, 4, 2013, 2),
(56, 1, 6, 2013, 1),
(57, 2, 6, 2013, 2),
(58, 8, 6, 2013, 1),
(59, 9, 6, 2013, 2),
(60, 15, 6, 2013, 1),
(61, 16, 6, 2013, 2),
(62, 22, 6, 2013, 1),
(63, 23, 6, 2013, 2),
(64, 29, 6, 2013, 1),
(65, 30, 6, 2013, 2),
(66, 6, 7, 2013, 1),
(67, 7, 7, 2013, 2),
(68, 13, 7, 2013, 1),
(69, 14, 7, 2013, 2),
(70, 20, 7, 2013, 1),
(71, 21, 7, 2013, 2),
(72, 27, 7, 2013, 1),
(73, 28, 7, 2013, 2),
(74, 3, 8, 2013, 1),
(75, 4, 8, 2013, 2),
(76, 10, 8, 2013, 1),
(77, 11, 8, 2013, 2),
(78, 17, 8, 2013, 1),
(79, 18, 8, 2013, 2),
(80, 24, 8, 2013, 1),
(81, 25, 8, 2013, 2),
(82, 31, 8, 2013, 1),
(83, 1, 9, 2013, 2),
(84, 7, 9, 2013, 1),
(85, 8, 9, 2013, 2),
(86, 14, 9, 2013, 1),
(87, 15, 9, 2013, 2),
(88, 21, 9, 2013, 1),
(89, 22, 9, 2013, 2),
(90, 28, 9, 2013, 1),
(91, 29, 9, 2013, 2),
(92, 5, 10, 2013, 1),
(93, 6, 10, 2013, 2),
(94, 12, 10, 2013, 1),
(95, 13, 10, 2013, 2),
(96, 19, 10, 2013, 1),
(97, 20, 10, 2013, 2),
(98, 26, 10, 2013, 1),
(99, 27, 10, 2013, 2),
(100, 2, 11, 2013, 1),
(101, 3, 11, 2013, 2),
(102, 9, 11, 2013, 1),
(103, 10, 11, 2013, 2),
(104, 15, 11, 2013, 3),
(105, 16, 11, 2013, 1),
(106, 17, 11, 2013, 2),
(107, 23, 11, 2013, 1),
(108, 24, 11, 2013, 2),
(109, 30, 11, 2013, 1),
(110, 1, 12, 2013, 2),
(111, 7, 12, 2013, 1),
(112, 8, 12, 2013, 2),
(113, 14, 12, 2013, 1),
(114, 15, 12, 2013, 2),
(115, 21, 12, 2013, 1),
(116, 22, 12, 2013, 2),
(117, 25, 12, 2013, 3),
(118, 28, 12, 2013, 1),
(119, 29, 12, 2013, 2),
(120, 1, 1, 2014, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `controle` varchar(11) NOT NULL,
  `cigam` varchar(11) NOT NULL,
  `s1` int(11) NOT NULL,
  `convenio` int(11) NOT NULL,
  `orcamento` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=178 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `usuario`, `senha`, `status`, `controle`, `cigam`, `s1`, `convenio`, `orcamento`) VALUES
(7, 'ANDERSON DO NASCIMENTO SANTANA', 'andersonnascimento@cpb.org.br', 'anderson', '12345', 3, '0', 'ANS', 0, 0, 0),
(6, 'AMARANTA ADJUTO VELOSO', 'amaranta@cpb.org.br', 'amaranta', '12345', 3, '0', 'ADV', 0, 0, 0),
(5, 'ADRIANO OSORIO DE FREITAS', 'adrianofreitas@cpb.org.br', 'adriano', '12345', 1, '05', 'ADF', 10401, 0, 1),
(8, 'ANDREW GEORGE WILLIAM PARSONS', 'aparsons@cpb.org.br', 'andrew', '12345', 4, 'EP', 'AWP', 0, 0, 0),
(9, 'ANGELA ALENCAR FERREIRA DE MELO', 'angela.melo@cpb.org.br', 'angela.melo', '12345', 3, '0', 'AFM', 0, 0, 0),
(163, 'JAKELINY FARIAS CANUTO', 'jakeliny@cpb.org.br', 'jakeliny', '12345', 3, '', 'A02', 0, 0, 0),
(11, 'BERNARDO LEAL RIGO', 'bernardo@cpb.org.br', 'bernardo', '12345', 1, '0', 'BLR', 0, 0, 0),
(12, 'CAMILA CHAVES GOES', 'camila.goes@cpb.org.br', 'camila.goes', '12345', 3, '0', 'CCG', 0, 0, 0),
(13, 'CARLOS EDUARDO DE SOUSA MATOS MELO', 'carlos.eduardo@cpb.org.br', 'carlos.eduardo', '12345', 3, '0', 'CES', 0, 2, 0),
(14, 'CARLOS JOSE VIEIRA DE SOUZA', 'carlosvieira@cpb.org.br', 'carlos', '12345', 1, '17', 'CAV', 0, 0, 0),
(15, 'CLAUDIO PEREIRA DE SOUZA JUNIOR', 'claudio.junior@cpb.org.br', 'claudio.junior', '12345', 3, '0', 'CSJ', 0, 0, 0),
(16, 'CONCEICAO DE MARIA BORGES COSTA', 'conceicao.costa@cpb.org.br', 'conceicao.costa', '12345', 3, '0', 'COC', 0, 0, 0),
(17, 'DANIEL ALMEIDA DE FARIAS BRITO', 'daniel.brito@cpb.org.br', 'daniel.brito', '12345', 1, '18', 'DAB', 0, 0, 0),
(18, 'DANIEL GROTA ROMANELLO', 'daniel.romanello@cpb.org.br', 'daniel.romanello', '12345', 1, '16', 'DGR', 0, 1, 0),
(19, 'EDILSON ALVES DA ROCHA', 'tubiba@cpb.org.br', 'tubiba', '12345', 1, '15', 'EAR', 0, 0, 0),
(20, 'EDOARDO  COUTINHO LAZARETTI', 'edoardo@cpb.org.br', 'edoardo', '12345', 3, '0', 'EDL', 0, 0, 0),
(21, 'EDY WILLIAM SIQUEIRA DE MENESES', 'administrativo@cpb.org.br', 'edy', '12345', 4, '15', 'ADF', 104, 1, 0),
(22, 'ELCIO HENRIQUE SANTOS MOREIRA', 'elcio@cpb.org.br', 'elcio', '12345', 3, '0', 'A02', 0, 0, 0),
(23, 'EZEQUIEL ECKHARDT TRANCOSO', 'ezequiel.trancoso@cpb.org.br', 'ezequiel.trancoso', '12345', 3, '0', 'EET', 0, 0, 0),
(24, 'ANTONIO FABIANO ARAUJO', 'fabiano.araujo@cpb.org.br', 'fabiano.araujo', '12345', 3, '0', 'FAA', 0, 0, 0),
(25, 'FABIO BORGES DOS SANTOS', 'fabio.santos@cpb.org.br', 'fabio', '12345', 3, '0', 'FBS', 0, 0, 0),
(26, 'FELIPE MACHADO COSTA ERNEST DIAS', 'felipedias@cpb.org.br', 'felipe.dias', '12345', 3, '0', 'FMD', 0, 0, 0),
(27, 'ANTONIO FERNANDO PARTELLI DE MELLO', 'fernando@cpb.org.br', 'fernando', '12345', 3, '0', 'AFP', 0, 0, 0),
(29, 'GLEICE FERREIRA DA SILVA', 'gleice@cpb.org.br', 'gleice', '12345', 3, '0', 'GFS', 0, 0, 0),
(31, 'GRACIELLE DEBORA MARIA DIAS', 'gracielle@cpb.org.br', 'gracielle', '12345', 3, '0', 'GDD', 0, 0, 0),
(32, 'HELTON ELVIS ALVES LOBO', 'helton@cpb.org.br', 'helton', '12345', 3, '0', 'HAL', 0, 0, 0),
(33, 'IGOR SILVA BARBOSA', 'igor.barbosa@cpb.org.br', 'igor.barbosa', '12345', 3, '0', 'ISB', 0, 0, 0),
(34, 'IGOR SILVA SOUZA', 'igor.souza@cpb.org.br', 'igor.souza', '12345', 3, '0', 'ISS', 0, 0, 0),
(35, 'IVALDO BRANDAO VIEIRA', 'ivaldo.brandao@cpb.org.br', 'ivaldobrandao', '12345', 3, '0', 'A02', 0, 0, 0),
(36, 'IZABEL PATRICIA SOARES DE ARAUJO', 'izabel.araujo@cpb.org.br', 'izabel.araujo', '12345', 3, '0', 'ISA', 0, 0, 0),
(37, 'JACQUELINE MARTINS PATATAS', 'jacqueline@cpb.org.br', 'jacqueline', '12345', 3, '0', 'JMP', 0, 0, 0),
(38, 'JANAINA PEREIRA DA SILVA LAZZARETTI', 'janaina.lazzaretti@cpb.org.br', 'janaina.lazzaretti', '12345', 3, '0', 'A02', 0, 0, 0),
(39, 'JANE MARIA DA SILVA BENTO', 'jane@cpb.org.br', 'jane', '12345', 1, '0', 'JMB', 0, 0, 0),
(41, 'JONAS RODRIGO ALVES PEREIRA FREIRE', 'jonas@cpb.org.br', 'jonas', '12345', 3, '0', 'A02', 0, 0, 0),
(161, 'RHEYDER FERNANDES ABUD', 'rheyder@cpb.org.br', 'rheyder', '12345', 3, '', 'A02', 0, 0, 0),
(160, 'LIDIA DA SILVA OLIVEIRA', 'lidia@cpb.org.br', 'lidia', '12345', 3, '', 'A02', 0, 0, 0),
(44, 'KELBIA FONSECA LOUREIRO', 'kelbia@cpb.org.br', 'kelbia', '12345', 3, '0', 'KEL', 0, 0, 0),
(45, 'LORENA SOTE DE ELAGE', 'lorena@cpb.org.br', 'lorena', '12345', 3, '0', 'LOR', 0, 0, 0),
(153, 'LUCAS DE OLIVEIRA SOUSA SANTOS', 'lucas@cpb.org.br', 'lucas', '12345', 3, '', 'LUC', 0, 0, 0),
(47, 'LUCIANA SCHEID', 'luciana.scheid@cpb.org.br', 'luciana.scheid', '12345', 3, '0', 'LSC', 0, 0, 0),
(48, 'LUIZ FELIPE DE FRANCA MOURA', 'luiz.felipe@cpb.org.br', 'luiz.felipe', '12345', 3, '0', 'LFS', 0, 0, 0),
(49, 'LUIZ FERNANDO DE MORAES', 'luiz.moraes@cpb.org.br', 'luiz.moraes', '12345', 3, '0', 'A02', 0, 0, 0),
(50, 'LUIZ CARLOS GARCIA COELHO JUNIOR', 'luiz.garcia@cpb.org.br', 'luiz.garcia', '12345', 3, '0', 'LGJ', 0, 0, 0),
(51, 'MANUELA BAILAO', 'manuela.bailao@cpb.org.br', 'manuela.bailao', '12345', 3, '0', 'MBA', 0, 0, 0),
(175, 'AMANDA RABELO CARDOSO', 'amanda.rabelo@cpb.org.br', 'amanda.rabelo@cpb.org.br', '12345', 3, '', 'A02', 0, 0, 0),
(53, 'MARIANA DA MALVA RANGEL', 'mariana.rangel@cpb.org.br', 'mariana.rangel', '12345', 3, '0', 'A02', 0, 0, 0),
(54, 'MARINEZ LEMOS COSTA', 'marinezcosta@cpb.org.br', 'marinez', '12345', 3, '0', 'A02', 0, 0, 0),
(55, 'MARIO GOMES BAGGIO DE CASTRO', 'mario@cpb.org.br', 'mario', '12345', 3, '0', 'MGB', 0, 0, 0),
(56, 'MATHEUS BERSAN ROVERE', 'matheus@cpb.org.br', 'matheus', '12345', 3, '0', 'MBR', 0, 0, 0),
(159, 'ANA CLAUDIA COUTO BACELLAR', 'ana.barcellar@cpb.org.br', 'ana.barcellar', '12345', 1, '19', 'A02', 0, 0, 0),
(58, 'MICHELL ALVES DA SILVA', 'michell@cpb.org.br', 'michell', '12345', 3, '0', 'MCL', 0, 0, 0),
(59, 'MICHELLY FLEITAS', 'michelly@cpb.org.br', 'michelly.fleitas', '12345', 3, '0', 'MIC', 0, 0, 0),
(60, 'MIZAEL CONRADO DE OLIVEIRA', 'mizaelconrado@cpb.org.br', 'mizael', '12345', 1, '13', 'MCO', 0, 0, 0),
(61, 'MONICA MAEDA VALENTIN', 'monica.valentin@cpb.org.br', 'monica.valentin', '12345', 3, '0', 'MOV', 0, 0, 0),
(62, 'NADIA XAVIER MEDEIROS', 'nadia.medeiros@cpb.org.br', 'nadia.medeiros', '12345', 3, '0', 'NXM', 0, 0, 0),
(63, 'NATACHA MANCHADO PEREIRA', 'natacha@cpb.org.br', 'natacha', '12345', 3, '0', 'NMP', 0, 0, 0),
(64, 'ERINEIDE PEREIRA DANTAS', 'neide.dantas@cpb.org.br', 'neide.dantas', '12345', 2, '0', 'EPD', 0, 0, 0),
(65, 'PATRICK CASSIMIRO GONCALVES', 'patrick@cpb.org.br', 'patrick', '12345', 3, '0', 'PAC', 0, 0, 0),
(66, 'PAULO ATAIDES DE OLIVEIRA', 'paulo@cpb.org.br', 'paulo', '12345', 1, '0', 'PAO', 0, 0, 0),
(67, 'PRISCILA DRIELE SILVA', 'priscila@cpb.org.br', 'priscila', '12345', 3, '0', 'PDS', 0, 0, 0),
(68, 'RAFAEL SILVA VILA NOVA', 'rafaelsilva@cpb.org.br', 'rafaelsilva', '12345', 1, '0', 'RSV', 0, 0, 0),
(69, 'REJANE REIS MOTA LIMA', 'rejane.lima@cpb.org.br', 'rejane.lima', '12345', 3, '0', 'RML', 0, 0, 0),
(70, 'RICARDO SILVA MELO', 'ricardo.melo@cpb.org.br', 'ricardo.melo', '12345', 3, '0', 'RSM', 0, 0, 0),
(71, 'RONALDO DE ARAUJO LEMOS', 'ronaldo@cpb.org.br', 'ronaldo', '12345', 3, '0', 'A02', 0, 0, 0),
(72, 'RONAN SANTOS VIEIRA DE SOUZA', 'ronan.santos@cpb.org.br', 'ronan.santos', '12345', 3, '0', 'RSS', 0, 0, 0),
(73, 'ROSANGELA GUILHERME DE ABREU', 'rosangela.abreu@cpb.org.br', 'rosangela.abreu', '12345', 1, '0', 'RGA', 0, 0, 0),
(74, 'ROUZILEIDE GOMES DE FARIAS', 'rouzi@cpb.org.br', 'rouzileide', '12345', 3, '0', 'ROU', 0, 0, 0),
(75, 'TAYNA CUNHA DE ARAUJO', 'tayna.araujo@cpb.org.br', 'tayna.araujo', '12345', 3, '0', 'TCA', 0, 0, 0),
(76, 'THAINA CERQUEIRA CARNEIRO', 'licitacao@cpb.org.br', 'thaina', '12345', 3, '0', 'TAI', 0, 0, 0),
(77, 'THIAGO HENRIQUE SILVA DE SOUZA', 'thiago@cpb.org.br', 'thiago', '12345', 3, '0', 'THS', 0, 0, 0),
(78, 'JOSE TIAGO SANTANA DOS SANTOS', 'tiago.santos@cpb.org.br', 'tiago.santos', '12345', 3, '0', 'A02', 0, 0, 0),
(79, 'VALERIA BATISTA DE CASTRO', 'valeria@cpb.org.br', 'valeria', '12345', 3, '0', 'VBC', 0, 0, 0),
(80, 'WELLINGTON KENIO COSTA MARQUES', 'wellington@cpb.org.br', 'wellington', '12345', 3, '0', 'WEI', 0, 0, 0),
(81, 'Recursos Humanos', 'paulo@cpb.org.br', 'rh', '12345', 2, '0', 'A02', 0, 0, 0),
(82, 'HENRIQUE ALBERTO AMARAL JUNIOR', 'henrique@cpb.org.br', 'henrique', '12345', 3, '', 'A02', 0, 0, 0),
(83, 'WEMERSON PEREIRA DE LIMA', 'wemerson@cpb.org.br', 'wemerson', '12345', 3, '', 'A02', 0, 0, 0),
(84, 'HUGO LEONARDO COSTA NETO', 'leonardo@cpb.org.br', 'leonardo', '12345', 3, '', 'A02', 0, 0, 0),
(85, 'THIAGO RIZERIO SANCHES LIMA', 'thiago.rizerio@cpb.org.br', 'thiago.rizerio', '12345', 3, '', 'TRS', 0, 0, 0),
(86, 'LILIAN NATHÃLIA DE OLIVEIRA SANTANA', 'lilian@cpb.org.br', 'lilian', '12345', 3, '', 'LNO', 0, 0, 0),
(87, 'RODRIGO F SOUZA DE ALMEIDA', 'rodrigo@cpb.org.br', 'rodrigo', '12345', 3, '', 'RFS', 0, 0, 0),
(88, 'MARINA PAIM CARNEIRO', 'marina@cpb.org.br', 'marina', '12345', 3, '', 'MPC', 0, 0, 0),
(89, 'LOURRANY ALVES LOBO DA SILVA', 'lourrany@cpb.org.br', 'lourrany', '12345', 3, '', 'A02', 0, 0, 0),
(90, 'FABIO HENRIQUE SANTOS DA SILVA ALVES', 'fabio.alves@cpb.org.br', 'fabio.alves', '12345', 3, '', 'FHS', 0, 0, 0),
(144, 'BRENO HIGOR COSTA SILVA', 'breno@cpb.org.br', 'breno', '12345', 3, '', 'A02', 0, 0, 0),
(92, 'LUCAS MATHEUS MARQUES SILVA LIMA', 'lucas.lima@cpb.org.br', 'lucas.lima', '12345', 3, '', 'LMM', 0, 0, 0),
(93, 'EVERSON DE ALENCAR CAMPOS', 'everson@cpb.org.br', 'everson', '12345', 3, '', 'EAC', 0, 0, 0),
(94, 'AMAURY WAGNER VERISSIMO', 'amauriwv@hotmail.com', 'amauriwv', '12345', 3, '', 'A02', 0, 0, 0),
(143, 'ALBERTO MARTINS DA COSTA', 'amcosta@cpb.org.br', 'amcosta', '12345', 3, '', 'A02', 0, 0, 0),
(96, 'ALEXANDRE DE ALMEIDA GARCIA', 'garciajudo2010@gmail.com', 'garciajudo2010', '12345', 3, '', 'A02', 0, 0, 0),
(97, 'ANA CAROLINA LEMOS ALVES', 'karu.edf@hotmail.com', 'karu.edf', '12345', 3, '', 'A02', 0, 0, 0),
(150, 'ANDREA  MARIA PIRES AZEVEDO', 'andrea.azevedo@cpb.org.br', 'andrea.azevedo', '12345', 3, '', 'A02', 0, 0, 0),
(99, 'DANILLO VIEIRA NASCIMENTO', 'danillo@cpb.org.br', 'danillo', '12345', 3, '', 'DVN', 0, 0, 0),
(100, 'BIANCA MAGALHÃES DE CARVALHO', 'bianca@cpb.org.br', 'bianca', '12345', 3, '', 'BMS', 0, 0, 0),
(162, 'KLEBER DOS SANTOS MOURAO', 'kleber@cpb.org.br', 'kleber', '12345', 3, '', 'A02', 0, 0, 0),
(102, 'ALINE BORGES DE CAMPOS SILVA', 'aline@cpb.org.br', 'aline', '12345', 3, '', 'ABC', 0, 0, 0),
(103, 'DANIEL PADUAN JOAQUIM', 'daniel_paduan@hotmail.com', 'daniel_paduan', '12345', 3, '', 'A02', 0, 0, 0),
(104, 'DOMINGOS ANTONIO CAMARGO GUIMARAES', 'veinhomingo@hotmail.com', 'veinhomingo', '12345', 3, '', 'A02', 0, 0, 0),
(105, 'EVERALDO BRAZ LUCIO', 'brazlucioeveraldo@gmail.com', 'brazlucioeveraldo', '12345', 3, '', 'A02', 0, 0, 0),
(106, 'FELIPE VAZ DOMINGUES', 'felipedomingues@yahoo.com.br', 'felipedomingues', '12345', 3, '', 'A02', 0, 0, 0),
(107, 'GERSON CARVALHO DOS SANTOS', 'gersondiscus@hotmail.com', 'gersondiscus', '12345', 3, '', 'A02', 0, 0, 0),
(108, 'JOSE PAULO SABADINI DE LIMA', 'jpsl79@yahoo.com.br', 'jpsl79', '12345', 3, '', 'A02', 0, 0, 0),
(109, 'JOSE RICARDO RIZZONE DE SOUSA VALE', 'josericardo@cbtm.org.br', 'josericardo', '12345', 3, '', 'A02', 0, 0, 0),
(110, 'LINCON KOO TOMITA YASUDA', 'lincon@cbtm.org.br', 'lincon', '12345', 3, '', 'A02', 0, 0, 0),
(111, 'MARCOS ROJO PRADO', 'coachmarcao@hotmail.com', 'coachmarcao', '12345', 3, '', 'A02', 0, 0, 0),
(112, 'MARIA CRISTINA NUNES MIGUEL', 'mcristinamn@hotmail.com', 'mcristinamn', '12345', 3, '', 'A02', 0, 0, 0),
(113, 'MARILIA PASSOS MAGNO E SILVA', 'mariliamagno@hotmail.com', 'mariliamagno', '12345', 3, '', 'A02', 0, 0, 0),
(114, 'PAULO BARBOSA DA SILVA', 'paulocanoa@gmail.com', 'paulocanoa', '12345', 3, '', 'A02', 0, 0, 0),
(115, 'RENATO MONTEIRO BARTHOLO', 'barthaeng@terra.com.br', 'barthaeng', '12345', 3, '', 'A02', 0, 0, 0),
(116, 'RODRIGO SOLLA IGLESIAS', 'rsollafisio@hotmail.com', 'rsollafisio', '12345', 3, '', 'A02', 0, 0, 0),
(117, 'VINICIUS SAVIOLI', 'vsavioli@sedpcd.sp.gov.br', 'vsavioli', '12345', 3, '', 'A02', 0, 0, 0),
(118, 'VITOR HUGO PINHEIRO MARCELINO', 'hugovt@ig.com.br', 'hugovt', '12345', 3, '', 'A02', 0, 0, 0),
(119, 'CLAUDIO DIEHL NOGUEIRA', 'cdnogueira@hotmail.com', 'cdnogueira', '12345', 3, '', 'A02', 0, 0, 0),
(120, 'CRISTIANO DA SILVA CERQUEIRA', ' ccparalympicsswimming@gmail.com', ' ccparalympicsswimming', '12345', 3, '', 'A02', 0, 0, 0),
(121, 'DANIEL BRANDAO MARTINS', 'danielmartins.fisio@gmail.com', 'danielmartins.fisio', '12345', 3, '', 'A02', 0, 0, 0),
(122, 'ERINALDO BATISTA DAS CHAGAS', 'pit@cpb.org.br', 'pit', '12345', 3, '', 'A02', 0, 0, 0),
(123, 'FABIO DE SOUZA LIMA ANTONUCCI', 'fabioantonucci@ig.com.br', 'fabioantonucci', '12345', 3, '', 'A02', 0, 0, 0),
(124, 'FABIO DIAS DE OLIVEIRA SILVA', 'biodias@gmail.com', 'biodias', '12345', 3, '', 'A02', 0, 0, 0),
(125, 'JORGE SOUZA DE FREITAS', 'jorge.riovaa@gmail.com', 'jorge.riovaa', '12345', 3, '', 'A02', 0, 0, 0),
(126, 'JUCINEI GONÃ‡ALVES DA COSTA', 'jucineicosta@yahoo.com.br', 'jucineicosta', '12345', 3, '', 'A02', 0, 0, 0),
(127, 'LUCIANA BARBOSA DE MENEZES', 'lumenezes.timerio@gmail.com', 'lumenezes.timerio', '12345', 3, '', 'A02', 0, 0, 0),
(128, 'MICHELLE DE MEDEIROS DOMICIANO', 'chelledomiciano@hotmail.com', 'chelledomiciano', '12345', 3, '', 'A02', 0, 0, 0),
(129, 'MURILO MOREIRA BARRETO', ' murilo@cpb.org.br', ' murilo', '12345', 3, '', 'A02', 0, 0, 0),
(130, 'RAFAEL MORAIS DIAS', 'rafaelmoraisdias@yahoo.com.br', 'rafaelmoraisdias', '12345', 3, '', 'A02', 0, 0, 0),
(131, 'VANESSA MARIA PEREIRA DE MELO', 'vanessapersonal@hotmail.com', 'vanessapersonal', '12345', 3, '', 'A02', 0, 0, 0),
(132, 'VITOR DO NASCIMENTO PEREIRA', 'vitortimerio@hotmail.com', 'vitortimerio', '12345', 3, '', 'A02', 0, 0, 0),
(133, 'WALQUIRIA DA SILVA CAMPELO', 'wal_treinadora@hotmail.com', 'wal_treinadora', '12345', 3, '', 'A02', 0, 0, 0),
(134, 'ALEXANDRE SILVA VIEIRA', 'xanxovieira@hotmail.com', 'xanxovieira', '12345', 3, '', 'A02', 0, 0, 0),
(135, 'CIRO WINCKLER DE OLIVEIRA FILHO', 'cirowin@gmail.com', 'cirowin', '12345', 3, '', 'A02', 0, 0, 0),
(136, 'FABIO LEANDRO BREDA', 'fabio.breda@ig.com.br', 'fabio.breda', '12345', 3, '', 'A02', 0, 0, 0),
(137, 'JOAO PAULO ALVES DA CUNHA', 'jopa@uol.com.br', 'jopa', '12345', 3, '', 'A02', 0, 0, 0),
(138, 'LIGIA ZAGORAC BAHU', 'ligia.bahu@cbdn.org.br', 'ligia.bahu', '12345', 3, '', 'A02', 0, 0, 0),
(139, 'JOSE ANTONIO FERREIRA FREIRE', 'joseantonio@cbdv.org.br', 'joseantonio', '12345', 3, '', 'A02', 0, 0, 0),
(140, 'LUIZ EDMUNDO COSTA', 'luizedc@uol.com.br', 'luizedc', '12345', 3, '', 'A02', 0, 0, 0),
(141, 'FILIPE LOPES BARBOZA', 'lipejpa@hotmail.com', 'lipejpa', '12345', 3, '', 'A02', 0, 0, 0),
(145, 'MONICA APARECIDA MENDES DE O.  SANTOS', 'mogiparaolimpico@gmail.com', 'mogiparaolimpico', '12345', 3, '', 'A02', 0, 0, 0),
(146, 'ZAIRA DO NASCIMENTO MELO', 'zaira-melo@ig.com.br', 'zaira-melo', '12345', 3, '', 'A02', 0, 0, 0),
(147, 'RUI DAVID MARQUES', 'rui.marques@inas.org', 'rui.marques', '12345', 3, '', 'A02', 0, 0, 0),
(154, 'GLEDIANA FERREIRA DE ALMEIDA', 'confirmacao@cpb.org.br', 'glediana.almeida', '12345', 5, '', 'GFA', 0, 0, 0),
(155, 'TESTE DE CONVÊNIOS', 'teste', 'teste.convenios', '12345', 3, '16', 'A02', 0, 1, 0),
(156, 'SANDRA PASSOS XAVIER', 'sandra@cpb.org.br', 'sandra', '12345', 2, '', 'SPX', 0, 0, 0),
(157, 'KLAUS RAINER SCHWIETZER FILHO', 'klaus@cpb.org.br', 'klaus', '12345', 3, '', 'KRF', 0, 0, 0),
(174, 'NAILTON PONTES DINIZ DE OLIVEIRA', 'nailton.oliveira@cpb.org.br', 'nailton.oliveira', '12345', 3, '', 'A02', 0, 0, 0),
(166, 'DAYANA MARTINS COSTA', 'dayana@cpb.org.br', 'dayana', '12345', 3, '', 'DMC', 0, 0, 0),
(167, 'JANAINA ALVES CATULIO', 'janaina@cpb.org.br', 'janaina', '12345', 3, '', 'A02', 0, 0, 0),
(168, 'PHREDERICO SILVA FERNANDES', 'phrederico@cpb.org.br', 'phrederico', '12345', 3, '', 'A02', 0, 0, 0),
(169, 'LILIANA BARROS BRANDAO SOARES', 'liliana@cpb.org.br', 'liliana', '12345', 3, '', 'LBS', 0, 0, 0),
(170, 'ARTHUR DIMITRIE LAGARES TOMASI', 'arthur@cpb.org.br', 'arthur', '12345', 3, '', 'ADL', 0, 0, 0),
(171, 'LUCIANO MARTINS MATOS', 'luciano@cpb.org.br', 'luciano', '12345', 3, '', 'A02', 0, 0, 0),
(172, 'SILVANA NOLETO DA SILVA', 'silvana@cpb.org.br', 'silvana', '12345', 3, '', 'SNS', 0, 0, 0),
(173, 'MARCOS VINICIUS NERY', 'marcos@cpb.org.br', 'marcos', '12345', 3, '', 'A02', 0, 0, 0),
(176, 'JULIANA DOS SANTOS LOIOLA', 'juliana.loiola@cpb.org.br', 'juliana.loiola', '12345', 3, '', 'A02', 0, 0, 0),
(177, 'Licitação', 'licitacao@cpb.org.br', 'licitacao', '12345', 3, '0', 'A00', 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
