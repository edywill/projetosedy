<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
</head>
<body>
<div id='box3'>
<br/><strong>OCWEB  - Ordens de Compra Pendentes de aprova&ccedil;&atilde;o:</strong><br/>
<?php 
header('Content-Type: text/html; charset=utf-8');
include "function.php";
$idOc=$_POST["id_ci"];
$UserOc=$_POST["user_ci"];
$descricao=$_POST["desc_ci"];
//$descricao=$_POST["desc"];

updateOc($idOc,$UserOc,$descricao);
//alertaF("CI Nº ".$idCi." aprovada com sucesso.","principal.php");

//Função Alerta
function alertaF($mensagem2, $caminho2){  
echo "<script>alert('".$mensagem2."');top.location.href='".$caminho2."';</script>"; 
global $_SG;
}

?>