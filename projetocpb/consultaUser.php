<?php 
require "conectsqlserverci.php";
include "mb.php";

// Recebe o valor enviado 
$valor=trim($_GET['valor']);
$valor = explode('-', $valor);

$consulta="select Cd_empresa
from GEEMPRES (nolock) 
where Cd_empresa='".$valor[0]."'
and ativo = 1";
$sql = odbc_exec($conCab, $consulta);


$pesquisa = odbc_fetch_array($sql);


echo trim($pesquisa['Cd_empresa'])."\n";

//echo $valor;
?>