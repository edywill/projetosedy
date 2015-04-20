<?php 
require "../../conexaomysql.php";
//include "mb.php";

// Recebe o valor enviado 
//$valor = str_replace(",", ".", $valor);
$valor=trim($_GET['valor']);


$consulta="SELECT desconto FROM cia WHERE id=".$valor."";
$sql = mysql_query($consulta);


$pesquisa = mysql_fetch_array($sql);

if(!empty($pesquisa)){
echo trim($pesquisa['desconto'])."\n";
		  }
//echo $valor;
?>