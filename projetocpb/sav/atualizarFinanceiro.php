<?php 
function atualizaDadosFinanceiros($idSavFin,$solicitacaoFin,$sequenciaFin){
require "../conect.php";
require "conectsqlserversav.php";
$sqlCGEREN="SELECT cgeren FROM savregistros WHERE id='".$idSavFin."'";
$rsCGEREN = mysql_query($sqlCGEREN);
$arrayCGEREN=mysql_fetch_array($rsCGEREN);
$cgeren=$arrayCGEREN['cgeren'];

$sqlUpdtItemGeren="UPDATE COISOLIC SET 
   cd_conta_gerenc='".$cgeren."'
   where cd_solicitacao='".$solicitacaoFin."' and
		 sequencia='".$sequenciaFin."'";
   $resInsertItem = odbc_exec($conCab2, $sqlUpdtItemGeren) or die("<p>".odbc_errormsg());
}
?>