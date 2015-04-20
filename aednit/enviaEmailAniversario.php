<?php 
include "function.php";
require "conect.php";
$sql=mysql_query("SELECT name,email FROM usuarios WHERE dtnasc LIKE '".date("d")."/".date("m")."/%'");
//$array=mysql_fetch_array($sql);
while($obj=mysql_fetch_object($sql)){
//Criar função genérica de envio de e-mail
$assunto="[AEDNIT] Feliz Aniversario";
$mensagemHtml="Prezado(a) ".$obj->name.",\n
E com muita alegria que viemos desejar-lhe um feliz aniversario Com muitas alegrias, realizacoes. Que nesse novo ano voce possa contar ainda mais com a AEDNIT.
<br>

Sao os sinceros votos da Associacao dos Servidores do Departamento de Infraestrutura em Transportes - AEDNIT";
$emailRetorno="contato@aednit.org.br";
$paginaRetorno="admin.php";
$para=$obj->email;
enviaEmail($assunto,$mensagemHtml,$emailRetorno,$paginaRetorno,$para);
}
?>