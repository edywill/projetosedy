<?php

//Determina o tipo da codificação da página
//header("content-type: text/html; charset=iso-8859-1"); 

//Extrai os dados do formulário
extract($_GET); 

//Verifica se algum nome foi digitado
$nome = ($origemida != "") ? $origemida : "desconhecido"; 

//Verifica se algum email foi digitado
$email = ($destinoida != "") ? $destinoida : "desconhecido";

//Retorna com a resposta
echo "Olá <b>".$nome."</b>, seu email é: <a href='mailto:".$email."'><b>".$email."</b></a>"; 

?>
