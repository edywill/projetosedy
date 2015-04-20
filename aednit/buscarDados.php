<?php
require 'conect.php';
  mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');

if(empty($_POST['email'])){
	?>
       <script type="text/javascript">
       alert("Informe o Email.");
       history.back();
       </script>
       <?php
	}else{
		$sqlEmail=mysql_query("SELECT name,user,pass FROM usuarios WHERE email='".$_POST['email']."'") or die(mysql_error());
		$arrayEmail=mysql_fetch_array($sqlEmail);
		if(empty($arrayEmail)){
			?>
       <script type="text/javascript">
       alert("Cadastro não encontrado no sistema. Faça um novo cadastro ou entre em contato com a associação!");
       history.back();
       </script>
       <?php
			}else{
include "function.php";
$assunto="[AEDNIT] Recuperacao de Senha";
$mensagemHtml="Prezado(a) ".$arrayEmail['name'].",<br>
Segue, conforme solicitado, seus dados de acesso ao site da AEDNIT:<br>
<strong>Usuário</strong>:".$arrayEmail['user']." <br>
<strong>Senha</strong>: ".$arrayEmail['pass']."<br>
Caso não tenha  solicitado, ignore a mensagem.<br><br>
Atenciosamente,<br><br>
AEDNIT.";
$emailRetorno='contato@aednit.org.br';
$paginaRetorno="login.php";
$para=trim($_POST['email']);
enviaEmail($assunto,$mensagemHtml,$emailRetorno,$paginaRetorno,$para);
				}
		
		}
?>