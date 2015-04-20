<?php 
require "conectsqlserverci.php";
include "mb.php";

// Recebe o valor enviado 
$valor=trim($_GET['valor']);
$valor = explode('-', $valor);

$consulta="select cg.Pcc_nome_conta,cg.Cd_pcc_reduzid
from CCPCC cg (nolock)
where cg.Cd_pcc_reduzid = '".$valor[0]."'
and substring(cg.livre_alfa_18,1,1) <> 'N'
and cg.pcc_tipo = 'A'
";
$sql = odbc_exec($conCab, $consulta);


$pesquisa = odbc_fetch_array($sql);


echo trim($pesquisa['Cd_pcc_reduzid'])."\n";

//echo $valor;
?>