<?php 
require "conectsqlserverci.php";
include "mb.php";

// Recebe o valor enviado 
$valor=trim($_GET['valor']);
$valor = explode('-', $valor);

$consulta="select cg.Pcc_classific_c, cg.Pcc_nome_conta,cg.Cd_pcc_reduzid
from CCPCC cg (nolock)
where cg.Pcc_classific_c = '".$valor[0]."'
and substring(cg.livre_alfa_18,1,1) <> 'N'
and cg.pcc_tipo = 'A'
and cg.pcc_classific_c between dbo.CGFC_BUSCA_CONFIGURACAO(35,null) and dbo.CGFC_BUSCA_CONFIGURACAO(36,null)
";
$sql = odbc_exec($conCab, $consulta);


$pesquisa = odbc_fetch_array($sql);


echo trim($pesquisa['Pcc_classific_c'])."\n";

//echo $valor;
?>