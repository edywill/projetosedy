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
-- Banco de Dados: `convenioscpb`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `despesa`
--

CREATE TABLE IF NOT EXISTS `despesa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `despesa` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `despesa`
--

INSERT INTO `despesa` (`id`, `despesa`) VALUES
(1, 'Passagens Aéreas - Nacionais'),
(2, 'Passagens Aéreas - Internacionais');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estados`
--

CREATE TABLE IF NOT EXISTS `estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uf` varchar(3) NOT NULL,
  `estados` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Extraindo dados da tabela `estados`
--

INSERT INTO `estados` (`id`, `uf`, `estados`, `status`) VALUES
(1, 'AC', 'Acre', 1),
(2, 'AL', 'Alagoas', 1),
(3, 'AM', 'Amazonas', 1),
(4, 'AP', 'Amapá', 1),
(5, 'BH', 'Bahia', 1),
(6, 'CE', 'Ceará', 1),
(7, 'DF', 'Distrito Federal', 1),
(8, 'ES', 'Espírito Santo', 1),
(9, 'GO', 'Goiás', 1),
(10, 'MA', 'Maranhão', 1),
(11, 'MG', 'Minas Gerais', 1),
(12, 'MS', 'Mato Grosso do Sul', 1),
(13, 'MT', 'Mato Grosso', 1),
(14, 'PA', 'Pará', 1),
(15, 'PB', 'Paraíba', 1),
(16, 'PE', 'Pernambuco', 1),
(17, 'PI', 'Piauí', 1),
(18, 'PR', 'Paraná', 1),
(19, 'RJ', 'Rio de Janeiro', 1),
(20, 'RN', 'Rio Grande do Norte', 1),
(21, 'RO', 'Rondônia', 1),
(22, 'RR', 'Roraima', 1),
(23, 'RS', 'Rio Grande do Sul', 1),
(24, 'SC', 'Santa Catarina', 1),
(25, 'SE', 'Sergipe', 1),
(26, 'SP', 'São Paulo', 1),
(27, 'TO', 'Tocantins', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos`
--

CREATE TABLE IF NOT EXISTS `eventos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idmodalidade` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `dtinicio` varchar(20) NOT NULL,
  `dtfim` varchar(20) NOT NULL,
  `cidade` varchar(40) NOT NULL,
  `uf` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `eventos`
--

INSERT INTO `eventos` (`id`, `idmodalidade`, `nome`, `dtinicio`, `dtfim`, `cidade`, `uf`) VALUES
(1, 2, 'I PERÍODO DE TREINAMENTO', '24/02/13', '02/03/13', 'Uberlândia', 0),
(2, 1, 'Evento de Teste Ã©', '11/03/2014', '24/03/2014', 'BrasÃ­lia', 0),
(3, 2, 'Evento de Teste ÃƒÂ©', '31/03/2014', '25/03/2014', 'BrasÃƒÂ­lia', 0),
(4, 1, 'Evento de Teste ÃƒÂ©', '31/03/2014', '24/03/2014', 'BrasÃƒÂ­lia', 0),
(5, 1, 'Evento de Teste Ã©', '24/03/2014', '29/03/2014', 'BrasÃ­lia', 0),
(6, 1, 'Evento de Teste ÃƒÂ©', '24/03/2014', '31/03/2014', 'BrasÃƒÂ­lia', 0),
(7, 1, 'Evento de Teste é', '17/03/2014', '26/03/2014', 'Brasília', 0),
(8, 1, 'Evento de Teste é', '17/03/2014', '26/03/2014', 'Brasília', 0),
(9, 1, 'Evento de Teste é', '16/03/2014', '31/03/2014', 'Brasília', 0),
(10, 2, 'Evento de Teste é', '24/03/2014', '31/03/2014', 'Guará', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `modalidade`
--

CREATE TABLE IF NOT EXISTS `modalidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modalidade` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `modalidade`
--

INSERT INTO `modalidade` (`id`, `modalidade`) VALUES
(1, 'ATLETISMO'),
(2, 'HALTEROFILISMO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pcontas`
--

CREATE TABLE IF NOT EXISTS `pcontas` (
  `id` int(11) NOT NULL DEFAULT '0',
  `idevento` int(11) NOT NULL,
  `despesa` int(11) NOT NULL,
  `etapa` varchar(20) NOT NULL,
  `especific` varchar(80) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `um` varchar(10) NOT NULL,
  `vlunit` varchar(20) NOT NULL,
  `vltot` varchar(20) NOT NULL,
  `just` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pcontas`
--

INSERT INTO `pcontas` (`id`, `idevento`, `despesa`, `etapa`, `especific`, `quantidade`, `um`, `vlunit`, `vltot`, `just`) VALUES
(1, 10, 1, '1', 'CAMPO GRANDE/SP/CAMPO GRANDE', 8, 'Unid.', '600', '4.800,00', 'teste'),
(2, 10, 2, '1', 'RECIFE/SP/RECIFE', 1, 'Unid.', '4000', '4.000,00', ''),
(3, 10, 1, '1', 'Guarulhos X Brasília', 6, 'Unid.', '200', '1.200,00', ''),
(4, 10, 2, 'Nacional', 'Miami x Rio', 2, 'Unid.', '3000', '6.000,00', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `prhpermanente`
--

CREATE TABLE IF NOT EXISTS `prhpermanente` (
  `id` int(11) NOT NULL DEFAULT '0',
  `idmodalidade` int(11) NOT NULL,
  `funcao` varchar(100) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `um` varchar(20) NOT NULL,
  `vlunit` varchar(20) NOT NULL,
  `vltot` varchar(20) NOT NULL,
  `just` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `prhpermanente`
--

INSERT INTO `prhpermanente` (`id`, `idmodalidade`, `funcao`, `quantidade`, `um`, `vlunit`, `vltot`, `just`) VALUES
(1, 1, 'Coordenador de Prova - Edy', 10, 'Mês', '2000', '20.000,00', 'Inflação');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projecao`
--

CREATE TABLE IF NOT EXISTS `projecao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idevento` int(11) NOT NULL,
  `despesa` int(11) NOT NULL,
  `etapa` varchar(20) NOT NULL,
  `especific` varchar(80) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `um` varchar(10) NOT NULL,
  `vlunit` varchar(20) NOT NULL,
  `vltot` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `projecao`
--

INSERT INTO `projecao` (`id`, `idevento`, `despesa`, `etapa`, `especific`, `quantidade`, `um`, `vlunit`, `vltot`) VALUES
(1, 10, 1, '1', 'CAMPO GRANDE/SP/CAMPO GRANDE', 3, 'Unid.', '300', '900,00'),
(2, 10, 2, '1', 'RECIFE/SP/RECIFE', 5, 'Unid.', '580', '2.900,00'),
(3, 10, 1, '1', 'Guarulhos X Brasília', 10, 'Unid.', '900', '9.000,00'),
(4, 10, 2, 'Nacional', 'Miami x Rio', 2, 'Unid.', '800', '1.600,00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rhpermanente`
--

CREATE TABLE IF NOT EXISTS `rhpermanente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idmodalidade` int(11) NOT NULL,
  `funcao` varchar(100) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `um` varchar(20) NOT NULL,
  `vlunit` varchar(20) NOT NULL,
  `vltot` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `rhpermanente`
--

INSERT INTO `rhpermanente` (`id`, `idmodalidade`, `funcao`, `quantidade`, `um`, `vlunit`, `vltot`) VALUES
(1, 1, 'Coordenador de Prova - Edy', 10, 'Mês', '2000', '20.000,00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
