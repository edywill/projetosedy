<?php
	define("HOST", "localhost"); // O host no qual voc� deseja se conectar.
	define("USER", "root"); // O nome de usu�rio do banco de dados.
	define("PASSWORD", ""); // A senha do usu�rio do banco de dados. 
	define("DATABASE", "statusdia"); // O nome do banco de dados.
 
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
?>