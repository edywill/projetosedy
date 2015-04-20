<?php
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";

$idGeren=$_GET['idgeren'];
if($idGeren<>0){
	$_SESSION['gerenSession']=$idGeren;
echo "<div id='tabela'>
<form action='autEmLote.php' method='post' name='form'>
";
echo "<table border='1' width='100%'>
<tr><td colspan='5' align='right'><input type='submit' name='ok' value='Continuar>>' class='button'/></td></tr>
<tr><th width=5%'></th><th width='8%'>CI</th><th width='34%'>Nome</th><th width='33%'>Evento</th><th width='20%'>Datas</th></tr>";

$selectUsers=odbc_exec($conCab,"SELECT COISOLIC.Cd_solicitacao,
COISOLIC.Sequencia,
COSOLICI.Desc_cond_pag
FROM COISOLIC (nolock) INNER JOIN COSOLICI (nolock) ON
COSOLICI.Solicitacao=COISOLIC.Cd_solicitacao WHERE COISOLIC.Cd_conta_gerenc='".$idGeren."' AND COISOLIC.Campo65<>'90'
ORDER BY COISOLIC.Cd_solicitacao DESC");
$cont=0;
while($objUserAut=odbc_fetch_object($selectUsers)){
	$sqlPassagem=odbc_exec($conCab,"SELECT TEITEMSOLPASSAGEM.*,GEEMPRES.Nome_completo FROM TEITEMSOLPASSAGEM (nolock) LEFT JOIN GEEMPRES (nolock) ON TEITEMSOLPASSAGEM.Cd_empresa=GEEMPRES.Cd_empresa
	WHERE TEITEMSOLPASSAGEM.Cd_solicitacao='".$objUserAut->Cd_solicitacao."' AND TEITEMSOLPASSAGEM.Sequencia='".$objUserAut->Sequencia."'
	ORDER BY TEITEMSOLPASSAGEM.Dt_partida DESC");
	while($objPassagemUser=odbc_fetch_object($sqlPassagem)){
		$dtIda='';
		$dtVolta='';
		if(!empty($objPassagemUser->dt_partida)){
			$dtIda="IDA: ".date("d/m/Y",strtotime($objPassagemUser->dt_partida));
			}
		if(!empty($objPassagemUser->dt_chegada)){
			if(!empty($dtIda)){
				$dtVolta="<br>";
				}
			$dtVolta.="VOLTA: ".date("d/m/Y",strtotime($objPassagemUser->dt_chegada));
			}
echo "<tr><td align='center'><input type='checkbox' name='marcar[".$cont."]' value='".$objPassagemUser->id_registro."'/></td><td>".$objUserAut->Cd_solicitacao."</td><td>".utf8_encode($objPassagemUser->Nome_completo)."</td><td>".utf8_encode($objUserAut->Desc_cond_pag)."</td><td>".$dtIda."".$dtVolta."</td></tr>";
$cont++;
	}
}
echo "</table></form>";
echo "</div>";
}
?>