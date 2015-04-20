<?php 
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";

foreach($_POST['marcar'] AS $key){
	//Busca os dados por usuário
	//Verifica se existe autorização gerada para esse usuário e com a mesma CI
	//Caso sim, retorna o Erro (em grupo)
	//Caso não, apresenta a tela de autorização
	echo "<br>".$key;
	}

?>