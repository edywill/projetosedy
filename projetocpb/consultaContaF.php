<?php 
require "conectsqlserverci.php";
include "mb.php";

// Recebe o valor enviado 
$valor=trim($_GET['valor']);
$valor = explode('-', $valor);

$consulta="select Cd_conta
			  from GFCONTA (nolock) 
			  where Cd_conta ='".$valor[0]."' AND 
			  ativo = 1 AND
			  tipo_conta = 'A'";
$sql = odbc_exec($conCab, $consulta);


$pesquisa = odbc_fetch_array($sql);


echo trim($pesquisa['Cd_conta'])."\n";

//echo $valor;
?>