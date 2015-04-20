<?php 
require "conectsqlserverci.php";
include "mb.php";

// Recebe o valor enviado 
$valor=trim($_GET['valor']);
$valor = explode('-', $valor);

$consulta="select Cd_portador,Nome
			  from GFPORTAD (nolock) 
			  where Cd_portador ='".$valor[0]."' AND 
			  ativo = 1";
$sql = odbc_exec($conCab, $consulta);


$pesquisa = odbc_fetch_array($sql);


echo trim($pesquisa['Cd_portador'])."\n";

//echo $valor;
?>