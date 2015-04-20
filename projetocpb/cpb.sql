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
-- Estrutura da tabela `gestores`
--

CREATE TABLE IF NOT EXISTS `gestores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Extraindo dados da tabela `gestores`
--

INSERT INTO `gestores` (`id`, `nome`) VALUES
(1, 'ADRIANO OSORIO DE FREITAS'),
(2, 'GESTOR DE OUTRA AREA');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Extraindo dados da tabela `solferias`
--

INSERT INTO `solferias` (`id`, `funcionario`, `datainicio`, `datafinal`, `gestor`, `status`, `abono`, `posterior`, `ad13`) VALUES
(1, 'ADRIANO OSORIO DE FREITAS', '1/5/2013', '15/5/2013', 'ADRIANO OSORIO DE FREITAS', 3, '', '', ''),
(4, 'ADRIANO OSORIO DE FREITAS', '6/5/2013', '20/5/2013', 'ADRIANO OSORIO DE FREITAS', 3, '', '', ''),
(6, 'ADRIANO OSORIO DE FREITAS', '1/5/2013', '27/5/2013', 'GESTOR DE OUTRA AREA', 1, '', '', ''),
(7, 'ADRIANO OSORIO DE FREITAS', '6/5/2013', '26/5/2013', 'GESTOR DE OUTRA AREA', 2, '', '', ''),
(9, 'ADRIANO OSORIO DE FREITAS', '26/5/2013', '31/5/2013', 'ADRIANO OSORIO DE FREITAS', 3, '', '', ''),
(10, 'FABIO BORGES DOS SANTOS', '6/6/2013', '11/6/2013', 'ADRIANO OSORIO DE FREITAS', 2, '', '', ''),
(11, 'FABIO BORGES DOS SANTOS', '6/6/2013', '25/6/2013', 'ADRIANO OSORIO DE FREITAS', 3, '', '', ''),
(12, 'FABIO BORGES DOS SANTOS', '6/6/2013', '27/6/2013', 'ADRIANO OSORIO DE FREITAS', 2, '', '', ''),
(13, 'FABIO BORGES DOS SANTOS', '2/6/2013', '23/6/2013', 'ADRIANO OSORIO DE FREITAS', 2, '', '', ''),
(14, 'FABIO BORGES DOS SANTOS', '16/6/2013', '28/6/2013', 'ADRIANO OSORIO DE FREITAS', 2, 'abono', 'no', 'sim'),
(15, 'FABIO BORGES DOS SANTOS', '2/6/2013', '24/6/2013', 'GESTOR DE OUTRA AREA', 1, 'abono', 'no', 'nao'),
(16, 'FABIO BORGES DOS SANTOS', '2/6/2013', '30/6/2013', 'GESTOR DE OUTRA AREA', 1, 'no', 'posterior', 'nao'),
(17, 'FABIO BORGES DOS SANTOS', '1/7/2013', '18/6/2013', 'ADRIANO OSORIO DE FREITAS', 1, 'abono', 'no', 'SIM');

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `usuario`, `senha`, `status`) VALUES
(7, 'ANDERSON DO NASCIMENTO SANTANA', 'andersonnascimento@cpb.org.br', 'anderson', '12345', 3),
(6, 'AMARANTA ADJUTO VELOSO', 'amaranta@cpb.org.br', 'amaranta', '12345', 3),
(5, 'ADRIANO OSORIO DE FREITAS', 'adrianofreitas@cpb.org.br', 'adriano', '12345', 1),
(8, 'ANDREW GEORGE WILLIAM PARSONS', 'aparsons@cpb.org.br', 'andrew', '12345', 3),
(9, 'ANGELA ALENCAR FERREIRA DE MELO', 'angela.melo@cpb.org.br', 'angela.melo', '12345', 3),
(10, 'BARBARA MAGALHAES DE CARVALHO', 'barbara.carvalho@cpb.org.br', 'barbara.carvalho', '12345', 3),
(11, 'BERNARDO LEAL RIGO', 'bernardo@cpb.org.br', 'bernardo', '12345', 3),
(12, 'CAMILA CHAVES GOES', 'camila.goes@cpb.org.br', 'camila.goes', '12345', 3),
(13, 'CARLOS EDUARDO DE SOUSA MATOS MELO', 'carlos.eduardo@cpb.org.br', 'carlos.eduardo', '12345', 3),
(14, 'CARLOS JOSE VIEIRA DE SOUZA', 'carlosvieira@cpb.org.br', 'carlos', '12345', 3),
(15, 'CLAUDIO PEREIRA DE SOUZA JUNIOR', 'claudio.junior@cpb.org.br', 'claudio.junior', '12345', 3),
(16, 'CONCEIÇÃO DE MARIA BORGES COSTA', 'conceicao.costa@cpb.org.br', 'conceicao.costa', '12345', 3),
(17, 'DANIEL ALMEIDA DE FARIAS BRITO', 'daniel.brito@cpb.org.br', 'daniel.brito', '12345', 3),
(18, 'DANIEL GROTA ROMANELLO', 'daniel.romanello@cpb.org.br', 'daniel.romanello', '12345', 3),
(19, 'EDILSON ALVES DA ROCHA', 'tubiba@cpb.org.br', 'tubiba', '12345', 3),
(20, 'EDOARDO  COUTINHO LAZARETTI', 'edoardo@cpb.org.br', 'edoardo', '12345', 3),
(21, 'EDY WILLIAM SIQUEIRA DE MENESES', 'edy@cpb.org.br', 'edy', '12345', 2),
(22, 'ELCIO HENRIQUE SANTOS MOREIRA', 'elcio@cpb.org.br', 'elcio', '12345', 3),
(23, 'EZEQUIEL ECKHARDT TRANCOSO', 'ezequiel.trancoso@cpb.org.br', 'ezequiel.trancoso', '12345', 3),
(24, 'ANTONIO FABIANO ARAUJO', 'fabiano.araujo@cpb.org.br', 'fabiano.araujo', '12345', 3),
(25, 'FABIO BORGES DOS SANTOS', 'fabio.santos@cpb.org.br', 'fabio', '12345', 3),
(26, 'FELIPE MACHADO COSTA ERNEST DIAS', 'felipedias@cpb.org.br', 'felipe.dias', '12345', 3),
(27, 'ANTONIO FERNANDO PARTELLI DE MELLO', 'fernando@cpb.org.br', 'fernando', '12345', 3),
(28, 'FREDERICO LAGES MOTTA', 'motta.frederico@cpb.org.br', 'fred.motta', '12345', 3),
(29, 'GLEICE FERREIRA DA SILVA', 'gleice@cpb.org.br', 'gleice', '12345', 3),
(30, 'GLEDIANA FERREIRA DE ALMEIDA', 'gleidi@cpb.org.br', 'gleidiana.almeida', '12345', 3),
(31, 'GRACIELLE DEBORA MARIA DIAS', 'gracielle@cpb.org.br', 'gracielle', '12345', 3),
(32, 'HELTON ELVIS ALVES LOBO', 'helton@cpb.org.br', 'helton', '12345', 3),
(33, 'IGOR SILVA BARBOSA', 'igor.barbosa@cpb.org.br', 'igor.barbosa', '12345', 3),
(34, 'IGOR SILVA SOUZA', 'igor.souza@cpb.org.br', 'igor.souza', '12345', 3),
(35, 'IVALDO BRANDAO VIEIRA', 'ivaldo.brandao@cpb.org.br', 'ivaldobrandao', '12345', 3),
(36, 'IZABEL PATRICIA SOARES DE ARAUJO', 'izabel.araujo@cpb.org.br', 'izabel.araujo', '12345', 3),
(37, 'JACQUELINE MARTINS PATATAS', 'jacqueline@cpb.org.br', 'jacqueline', '12345', 3),
(38, 'JANAINA PEREIRA DA SILVA LAZZARETTI', 'janaina.lazzaretti@cpb.org.br', 'janaina.lazzaretti', '12345', 3),
(39, 'JANE MARIA DA SILVA BENTO', 'jane@cpb.org.br', 'jane', '12345', 3),
(40, 'JOAO LUIZ DE FRANÇA MOURA', 'joaomoura@cpb.org.br', 'joaomoura', '12345', 3),
(41, 'JONAS RODRIGO ALVES PEREIRA FREIRE', 'jonas@cpb.org.br', 'jonas', '12345', 3),
(42, 'JULIANA MUCURY VIEIRA DA ROCHA', 'juliana.mucury@cpb.org.br', 'juliana.mucury', '12345', 3),
(43, 'JULIANA PEREIRA SOARES', 'juliana.soares@cpb.org.br', 'juliana.soares', '12345', 3),
(44, 'KELBIA FONSECA LOUREIRO', 'kelbia@cpb.org.br', 'kelbia', '12345', 3),
(45, 'LORENA SOTE DE ELAGE', 'lorena@cpb.org.br', 'lorena', '12345', 3),
(46, 'LUCAS DE OLIVEIRA SOUSA SANTOS', 'lucas@cpb.or.br', 'lucas@cpb.or.br', '12345', 3),
(47, 'LUCIANA SCHEID', 'luciana.scheid@cpb.org.br', 'luciana.scheid', '12345', 3),
(48, 'LUIZ FELIPE DE FRANCA MOURA', 'luiz.felipe@cpb.org.br', 'luiz.felipe', '12345', 3),
(49, 'LUIZ FERNANDO DE MORAES', 'luiz.moraes@cpb.org.br', 'luiz.moraes', '12345', 3),
(50, 'LUIZ CARLOS GARCIA COELHO JUNIOR', 'luiz.garcia@cpb.org.br', 'luiz.garcia', '12345', 3),
(51, 'MANUELA BAILÃO', 'manuela.bailao@cpb.org.br', 'manuela.bailao', '12345', 3),
(52, 'MARCELA MOTA MOREIRA LOPES', 'marcela@cpb.org.br', 'marcela', '12345', 3),
(53, 'MARIANA DA MALVA RANGEL', 'mariana.rangel@cpb.org.br', 'mariana.rangel', '12345', 3),
(54, 'MARINEZ LEMOS COSTA', 'marinezcosta@cpb.org.br', 'marinez', '12345', 3),
(55, 'MARIO GOMES BAGGIO DE CASTRO', 'mario@cpb.org.br', 'mario', '12345', 3),
(56, 'MATHEUS BERSAN ROVERE', 'matheus@cpb.org.br', 'matheus', '12345', 3),
(57, 'MAYARA PEREIRA DANTAS', 'mayara@cpb.org.br', 'mayara', '12345', 3),
(58, 'MICHELL ALVES DA SILVA', 'michell@cpb.org.br', 'michell', '12345', 3),
(59, 'MICHELLY FLEITAS', 'michelly@cpb.org.br', 'michelly.fleitas', '12345', 3),
(60, 'MIZAEL CONRADO DE OLIVEIRA', 'mizaelconrado@cpb.org.br', 'mizael', '12345', 3),
(61, 'MONICA MAEDA VALENTIN', 'monica.valentin@cpb.org.br', 'monica.valentin', '12345', 3),
(62, 'NADIA XAVIER MEDEIROS', 'nadia.medeiros@cpb.org.br', 'nadia.medeiros', '12345', 3),
(63, 'NATACHA MANCHADO PEREIRA', 'natacha@cpb.org.br', 'natacha', '12345', 3),
(64, 'ERINEIDE PEREIRA DANTAS', 'neide.dantas@cpb.org.br', 'neide.dantas', '12345', 2),
(65, 'PATRICK CASSIMIRO GONÇALVES', 'patrick@cpb.org.br', 'patrick', '12345', 3),
(66, 'PAULO ATAIDES DE OLIVEIRA', 'paulo@cpb.org.br', 'paulo', '12345', 3),
(67, 'PRISCILA DRIELE SILVA', 'priscila@cpb.org.br', 'priscila', '12345', 3),
(68, 'RAFAEL SILVA VILA NOVA', 'rafaelsilva@cpb.org.br', 'rafaelsilva', '12345', 3),
(69, 'REJANE REIS MOTA LIMA', 'rejane.lima@cpb.org.br', 'rejane.lima', '12345', 3),
(70, 'RICARDO SILVA MELO', 'ricardo.melo@cpb.org.br', 'ricardo.melo', '12345', 3),
(71, 'RONALDO DE ARAUJO LEMOS', 'ronaldo@cpb.org.br', 'ronaldo', '12345', 3),
(72, 'RONAN SANTOS VIEIRA DE SOUZA', 'ronan.santos@cpb.org.br', 'ronan.santos', '12345', 3),
(73, 'ROSANGELA GUILHERME DE ABREU', 'rosangela.abreu@cpb.org.br', 'rosangela.abreu', '12345', 3),
(74, 'ROUZILEIDE GOMES DE FARIAS', 'rouzi@cpb.org.br', 'rouzileide', '12345', 3),
(75, 'TAYNÁ CUNHA DE ARAUJO', 'tayna.araujo@cpb.org.br', 'tayna.araujo', '12345', 3),
(76, 'THAINA CERQUEIRA CARNEIRO', 'thaina@cpb.org.br', 'thaina', '12345', 3),
(77, 'THIAGO HENRIQUE SILVA DE SOUZA', 'thiago@cpb.org.br', 'thiago', '12345', 3),
(78, 'JOSE TIAGO SANTANA DOS SANTOS', 'tiago.santos@cpb.org.br', 'tiago.santos', '12345', 3),
(79, 'VALERIA BATISTA DE CASTRO', 'valeria@cpb.org.br', 'valeria', '12345', 3),
(80, 'WELLINGTON KENIO COSTA MARQUES', 'wellington@cpb.org.br', 'wellington', '12345', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
