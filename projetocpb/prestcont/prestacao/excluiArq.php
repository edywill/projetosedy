<?php 
session_start();
require "../../conectsqlserver.php";
require "../../sav/conectsqlserversav.php";
require "../../conect.php";
$selecionaArquivo=mysql_fetch_array(mysql_query("SELECT arquivo FROM prestsavarq WHERE id='".trim($_GET['idarq'])."'"));
$sqlArquivo=mysql_query("DELETE FROM prestsavarq WHERE id='".trim($_GET['idarq'])."'") or die(mysql_error());
$linkArquivo=utf8_encode($selecionaArquivo['arquivo']);

if(file_exists($linkArquivo)){
unlink($linkArquivo);
}

if($sqlArquivo){

echo "<script>alert('Processado com sucesso');window.location.href='prestContUser.php';</script>"; 
	}else{
		echo "<script>alert('Ocorreu um erro! Tente novamente!');window.location.href='prestContUser.php';</script>";
		}
?>