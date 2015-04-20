<?php
$host = "localhost"; //Local onde o MySQL está instalado, no nosso caso no LOCALHOST
$basededados = "cpb"; // Nome do banco de Dados
$login = "cpb_user"; // Login do MySQL, no EasyPHP o login padrão é "root"
$senha = "rio2016"; // Senha do MySQL, no EasyPHP  não temos senha por padrão, mas nada te impede de colocar.

//Conexão com o Banco de Dados
$conexao = mysql_connect($host, $login, $senha) or die(mysql_error());

mysql_select_db($basededados) or die("MySQL: Não foi possível conectar-se ao banco de dados [".$basededados."].");
?>