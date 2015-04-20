<?php 
include "function.php";

//Criar função genérica de envio de e-mail
$assunto="Mensagem do Site (Geral)";
$mensagemHtml="Olá,<br>
Segue mensagem do site.<br>
<strong>Nome</strong>:".$_POST['name']." <br>
<strong>Unidade/UF</strong>: ".$_POST['uf']."<br>
<strong>Email</strong>: ".$_POST['email']."<br>
<strong>Mensagem</strong>: ".$_POST['comments'].".";
$emailRetorno=$_POST['email'];
$paginaRetorno="index.php";
$para="contato@aednit.org.br";
enviaEmail($assunto,$mensagemHtml,$emailRetorno,$paginaRetorno,$para);

?>