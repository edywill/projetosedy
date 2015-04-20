<?php 
require "conectsqlserverci.php";
include "mb.php";

// Recebe o valor enviado 
$valor=trim($_GET['valor']);
$valor = explode('-', $valor);

$consulta="select Cd_material,Descricao,Cd_reduzido
from ESMATERI (nolock) 
where 
Cd_reduzido = '".$valor[0]."' 
AND tipo <> 'I' AND
(tipo <> 'O' and dbo.CGFC_BUSCA_CONFIGURACAO(1772,null) = 0 
     or dbo.CGFC_BUSCA_CONFIGURACAO(1772,null) = 1)";
$sql = odbc_exec($conCab, $consulta);


$pesquisa = odbc_fetch_array($sql);


echo trim($pesquisa['Cd_material'])."\n";

//echo $valor;
?>