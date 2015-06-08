<?php 
session_start();
unset($_SESSION['usuarioApCiweb']);
unset($_SESSION['controleApCiweb']);
unset($_SESSION['userApCiweb']);
unset($_SESSION['cigamApCiweb']);
require('conexaomysql.php');
include "enviaEmail.php";

$idCi=$_POST["id_ci"];
$UserCi=$_POST["user_ci"];
$descricao=$_POST["desc_ci"];
$controle='90';
$pgRetorno="ciweb";
$idTipo='IN';
$listaEmail='';
    $SQLIdIntranet =  mysql_query("SELECT * FROM usuarios WHERE usuario = '".$UserCiUpdate."'") or die(mysql_error());
    $resIdIntranet = mysql_fetch_array($SQLIdIntranet);
	$SQLIdIntranetEmail =  mysql_query("SELECT * FROM usuarios WHERE controle = '".$controleNovoCiUpdate."'") or die(mysql_error());
    $resIdIntranetEmail = mysql_fetch_array($SQLIdIntranetEmail);
	$idUserIntranet=$resIdIntranet['cigam'];
	require "conectsqlserverciprod.php";

	$SQLConsContrCI = "SELECT COCSO.descricao,
       						  COCSO.sit_solicitacao,
       						  COCSO.situac_item_sol,
							  COCSO.controle
					   FROM COCSO WITH(nolock)
					   WHERE controle = '".$controleNovoCiUpdate."'";
			$resConsContrCI = odbc_exec($conCab, $SQLConsContrCI);
			$arrayConsContrCI = odbc_fetch_array($resConsContrCI);
			$SQLConsStatusCi = "SELECT 
								COSOLICI.campo27,
								GEUSUARI.Campo23
					   FROM COSOLICI (nolock) 
					   LEFT JOIN GEUSUARI (nolock) ON
					   COSOLICI.Usuario_criacao=GEUSUARI.Cd_usuario
					   WHERE COSOLICI.Solicitacao = '".$ciUpdate."'";
			$resConsStatusCi = odbc_exec($conCab, $SQLConsStatusCi);
			$arrayConsStatusCi = odbc_fetch_array($resConsStatusCi);
			$SQLConsContrCIAnt = "SELECT COCSO.descricao,
       						  COCSO.sit_solicitacao,
       						  COCSO.situac_item_sol,
							  COCSO.controle
					   FROM COCSO WITH(nolock)
					   WHERE controle = '".$arrayConsStatusCi['campo27']."'";
			$resConsContrCIAnt = odbc_exec($conCab, $SQLConsContrCIAnt);
			$arrayConsContrCIAnt = odbc_fetch_array($resConsContrCIAnt);
	        $dataCi=date("d.m.y");
			$horaCi=date("H:i:s");
			$horaSessaoCi=date("His");
			$SQLConsItemCI = "SELECT campo65,
									 situacao,
									 Sequencia
							  FROM COISOLIC with(nolock)
							  WHERE cd_especie_esto='E'
							  AND cd_solicitacao='".$ciUpdate."'";
			$resConsItemCI = odbc_exec($conCab, $SQLConsItemCI);

$updCoisolic=TRUE;
			$descContCIItemNovo='';
			while($objConsItemCI = odbc_fetch_object($resConsItemCI)){
				$descContCIItem=mb_convert_encoding($arrayConsContrCIAnt['descricao'],"UTF-8","ISO-8859-1");
				$descContCIItemNovo=mb_convert_encoding($arrayConsContrCI['descricao'],"UTF-8","ISO-8859-1");
				$historicoCiItens="O controle do item da solicitação foi alterado de ".$objConsItemCI->campo65." - ".rtrim($descContCIItem)." para ".$controleNovoCiUpdate." - ".rtrim($descContCIItemNovo)." . Alteração realizada pelo usuário ".strtoupper($UserCiUpdate)." em ".$dataCi." às ".$horaCi.".";
			$converterHistoricoCiItens=mb_convert_encoding($historicoCiItens,"ISO-8859-1","UTF-8");
			$SQLupdCoisolic="UPDATE COISOLIC
							 SET campo65='".$controleNovoCiUpdate."',
							 situacao='".$arrayConsContrCI['situac_item_sol']."',
							 usuario_modific='".$idUserIntranet."',
							 dt_modificacao=dbo.CGFC_DATAATUAL()
							 WHERE cd_especie_esto='E'
							 AND cd_solicitacao='".$ciUpdate."'
							 AND Sequencia='".$objConsItemCI -> Sequencia."'";
		    $updCoisolic=odbc_exec($conCab,$SQLupdCoisolic) or die("<p>".odbc_errormsg());
			$ciUpdateItensSol=str_pad($ciUpdate, 8, "0", STR_PAD_LEFT);
			$ciUpdateItensSeq=str_pad($objConsItemCI -> Sequencia, 3, "0", STR_PAD_LEFT);
			$ciUpdateItens=$ciUpdateItensSol."/".$ciUpdateItensSeq;
			$SQLInsAcompItens="INSERT INTO GEACOMP VALUES('','".$ciUpdateItens."',".$ciUpdate.",".$objConsItemCI -> Sequencia.",'R','',null,null,null,null,'".$idUserIntranet."',".$horaSessaoCi.",null,null,null,null,'',0,0,0,0,0,0,0,0,'N','','','','','','".$idUserIntranet."','','','','','','',1,1,0,0,'',dbo.CGFC_DATAATUAL(),'".$horaSessaoCi."',null,null,'','".$converterHistoricoCiItens."')";
			$InsAcompItens=odbc_exec($conCab,$SQLInsAcompItens) or die("<p>".odbc_errormsg());
			}
			$descContCI=mb_convert_encoding($arrayConsContrCIAnt['descricao'],"UTF-8","ISO-8859-1");
			$descContCINovo=mb_convert_encoding($arrayConsContrCI['descricao'],"UTF-8","ISO-8859-1");
			$historicoCi="O controle da solicitação foi alterado de ".$arrayConsStatusCi['campo27']." - ".rtrim($descContCI)." para ".$controleNovoCiUpdate." - ".rtrim($descContCINovo).". Alteração realizada pelo usuário ".strtoupper($UserCiUpdate)." em ".$dataCi." às ".$horaCi.".";
			$converterHistoricoCi=mb_convert_encoding($historicoCi,"ISO-8859-1","UTF-8");
			$SQLupdCosolici="UPDATE COSOLICI
							 SET campo27='".$controleNovoCiUpdate."',
							 situacao='".$arrayConsContrCI['sit_solicitacao']."'
							 WHERE solicitacao='".$ciUpdate."'";
		    $updCosolici=odbc_exec($conCab,$SQLupdCosolici) or die("<p>".odbc_errormsg());
			$ciUpdateCapa=str_pad($ciUpdate, 8, " ", STR_PAD_LEFT);
			$SQLInsAcompSol="INSERT INTO GEACOMP VALUES('','".$ciUpdateCapa."',0,0,'R','',null,null,null,null,'".$idUserIntranet."',".$horaSessaoCi.",null,null,null,null,'',0,0,0,0,0,0,0,0,'N','','','','','','".$idUserIntranet."','','','','','','',1,1,0,0,'',dbo.CGFC_DATAATUAL(),'".$horaSessaoCi."',null,null,'','".$converterHistoricoCi."')";
			$InsAcompSol=odbc_exec($conCab,$SQLInsAcompSol) or die("<p>".odbc_errormsg());
			if($InsAcompSol){
			if ($updCoisolic) {
			                  
			if ($updCosolici) {
	
		$descContCIEmail=mb_convert_encoding($arrayConsContrCIAnt['descricao'],"UTF-8","ISO-8859-1");
		$recusaCiEmail=$_POST['recusa'];
$controleCIEmail=$arrayConsContrCIAnt['controle'];
//$descContCIItemEmailNovo=mb_convert_encoding($arrayConsContrCIAnt['descricao'],"UTF-8","ISO-8859-1");
    
	$emailSent[0]=$arrayConsStatusCi['Campo23'];
	//$emailSent[0]='edy@cpb.org.br';
	ciReprovadaEmail($resIdIntranet['nome'],$resIdIntranetEmail['nome'],$emailSent,$ciUpdate,$descricaoCiUpdate,$controleCIEmail,rtrim(	$descContCIEmail),$controleNovoCiUpdate,$descContCINovo,$pgRetornoUp,0,$recusaCiEmail);
			}
			}
			}
//alertaF("CI Nº ".$idCi." aprovada com sucesso.","principal.php");


//Função Alerta
function alertaF($mensagem2, $caminho2){  
echo "<script>alert('".$mensagem2."');top.location.href='".$caminho2."';</script>"; 
global $_SG;
}

?>