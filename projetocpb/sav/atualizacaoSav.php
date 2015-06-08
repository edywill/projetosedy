<?php 
$situacao='P';
//ações de update diária
if($_SESSION['diariaSolSav']=='sim'){
include "diariasUpdate.php";
atualizaDadosFinanceiros($numSav,$solicitacao,$sequenciaDia);
}
if($_SESSION['passagemSav']=='sim'){
include "passagensUpdate.php";
atualizaDadosFinanceiros($numSav,$solicitacao,$sequenciaPas);
}
if($_SESSION['diariaSav'] == 'sim'){
include "hospedagemUpdate.php";
atualizaDadosFinanceiros($numSav,$solicitacao,$sequenciaHos);
}
include "transladoUpdate.php";
atualizaDadosFinanceiros($numSav,$solicitacao,$sequenciaLoc);
	?>