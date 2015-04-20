<?php 
error_reporting(E_WARNING);
require "conectsqlserverci.php";
include "mb.php";

// Recebe o valor enviado 
$valor=trim($_GET['valor']);
$valor = explode('-', $valor);
$consulta="Select
  (ESPARPLA.Tempo_repos+ dbo.CGFC_DATAATUAL()) AS Pzent,
  ESMATERI.Cd_reduzido
 From
  ESPARPLA(nolock) Inner Join
  ESMATERI(nolock) On ESMATERI.Cd_material = ESPARPLA.Cd_material
Where
  ESPARPLA.Tipo = 'P' AND
  ESMATERI.Cd_reduzido='".(int)$valor[0]."'";
$sql = odbc_exec($conCab, $consulta);

if($sql){
$pesquisa = odbc_fetch_array($sql);
if(!empty($pesquisa)){
   echo trim(date("d/m/Y", strtotime($pesquisa['Pzent'])));
   }else{
   echo trim(date("d/m/Y"));
	   }
  }
?>