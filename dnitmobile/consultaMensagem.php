<?php 
require("valida.php");
include ("conexaobd/conectbd.php");
$valor=trim($_GET['valor']);

$consulta="SELECT mensagem FROM acompanhamento WHERE id=".$valor."";
$sql = odbc_exec($conCab,$consulta);


$pesquisa = odbc_fetch_array($sql);

if(!empty($pesquisa)){
echo utf8_encode($pesquisa['mensagem'])."\n";
		  }
?>