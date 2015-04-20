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
echo "<div id='outro' style='display: none;'>";
include "function.php";
$usuario=$_GET['usuario'];
require('conexaomysql.php');
$resultadoGres1 =  mysql_query("SELECT * FROM usuarios WHERE nome = '".$usuario."'") or die(mysql_error());
$resultadoGres = mysql_fetch_array($resultadoGres1);
$controle=$resultadoGres['controle'];
$usuario2=$resultadoGres['usuario'];//consulta
echo "</div>";
listagemOC($usuario2,$controle);
?>
</div>
</body>
</html>