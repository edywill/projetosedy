<?php

//Determina o tipo da codifica��o da p�gina
//header("content-type: text/html; charset=iso-8859-1"); 

//Extrai os dados do formul�rio
extract($_GET); 

//Verifica se algum nome foi digitado
$nome = ($origemida != "") ? $origemida : "desconhecido"; 

//Verifica se algum email foi digitado
$email = ($destinoida != "") ? $destinoida : "desconhecido";

//Retorna com a resposta
echo "Ol� <b>".$nome."</b>, seu email �: <a href='mailto:".$email."'><b>".$email."</b></a>"; 

?>
