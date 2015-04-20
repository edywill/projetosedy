<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.titulo {
	font-size: 18px;
}
.titulo_footer {
	font-weight: bold;
	text-align: center;
}
-->
body{
	font:70% verdana; 
	color:#000000;
}
</style>

<style media="print">
.botao {
display: none;
}
body{
	font:60% verdana; 
	color:#000000;
	margin-right:35px;
	margin-left:50px;
	margin-top: 10px;
	margin-bottom:10px;
}
#tabela table{
	font-family:verdana;
	width:100%;
	border-collapse:collapse;
}
#tabela  table td, th
{
	/*border:1px solid #2424FF;*/
	border:1px solid #215D63;
	padding:3px 7px 2px 7px;
}
#tabela  table th
{
	font-size:11px;
	text-align:left;
	padding-top:5px;
	padding-bottom:4px;
	/*background-color:#0080FF;*/
	background-color:#4BB6D1;
	color:#fff;
	
}
#tabela  table tr.alt td
{
	color:#000;
	background-color:#D6EDFF;
}
</style>

</head>

<body>
<div id='impressao'>
<div id='container2' style="background-color:#ffffff">

<?php 
header('Content-Type: text/html; charset=ISO-8859-1');
echo "<div id='outro' style='display: none;'>";
include "function.php";
function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
$lmin = 'abcdefghijklmnopqrstuvwxyz';
$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$num = '1234567890';
$simb = '!@#$%*-';
$retorno = '';
$caracteres = '';

$caracteres .= $lmin;
if ($maiusculas) $caracteres .= $lmai;
if ($numeros) $caracteres .= $num;
if ($simbolos) $caracteres .= $simb;

$len = strlen($caracteres);
for ($n = 1; $n <= $tamanho; $n++) {
$rand = mt_rand(1, $len);
$retorno .= $caracteres[$rand-1];
}
return $retorno;
}
if(empty($_GET['idci'])){
$idCi=$_POST["id_ciImpressao"];
}else{
	$idCi=$_GET['idci'];
	}
if(!empty($_POST["imp"])){
$impRet="home.php";	
	}else{
$impRet="javascript:history.back();";
	}
//$UserCi=$_POST["user_ci"];
//$descricao=$_POST["desc"];
echo "</div>";
echo "<div align='right' ><a href='javascript:;' class='botao' onclick='window.print();return false'><strong>Imprimir</strong></a></div>";
//echo "<div id='link3'><a href='".$impRet."' class='botao' ><strong>Voltar</strong></a></div>";
impressaoCi($idCi);
//alertaF("CI Nº ".$idCi." aprovada com sucesso.","principal.php");

//Função Alerta
function alertaF($mensagem2, $caminho2){  
echo "<script>alert('".$mensagem2."');top.location.href='".$caminho2."';</script>"; 
global $_SG;
}

?>
</div>
</div>
</body>
</html>