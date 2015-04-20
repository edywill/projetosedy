<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
</head>
<body>
<div id='box3'>
<br/><strong>CIWEB  - Solicita&ccedil;&otilde;es por Setor:</strong><br/><br/>
<?php
echo "<div id='outro' style='display: none;'>";
include "mb.php";
require "conectsqlserverciprod.php";
require('conexaomysql.php');
$usuario=$_GET['usuario'];

$consultaEmailUser="SELECT email,s1 FROM usuarios WHERE nome='".$usuario."'";
$resultadoEmail =  mysql_query($consultaEmailUser) or die(mysql_error());
$resultadom = mysql_fetch_array($resultadoEmail);

$consultaCiWeb="SELECT * FROM ciweb WHERE resp LIKE '".$usuario."'";
$resultadoCiWeb =  mysql_query($consultaCiWeb) or die(mysql_error());
echo "</div>";
echo "<hr><h4>CIs Pendentes de An&aacute;lise</h4>";
$consultaEmails="Select DISTINCT
  COSOLICI.Solicitacao,
  COSOLICI.cd_unid_negoc,
  COSOLICI.Data,
  COSOLICI.Desc_cond_pag,
  COSOLICI.Dt_modificacao
From
  TEEMAILSOLICITACAO TE Inner Join
  ESGRUPO GRU On GRU.Cd_grupo = TE.cd_grupo Inner Join
  ESSUBGRU SUB On SUB.Cd_sub_grupo = TE.cd_Sub_Grupo Inner Join
  ESMATERI On TE.cd_grupo = ESMATERI.Cd_grupo And TE.cd_Sub_Grupo =
    ESMATERI.Cd_sub_grupo Inner Join
  COISOLIC On ESMATERI.Cd_material = COISOLIC.Cd_material Inner Join
  COSOLICI On COSOLICI.Solicitacao = COISOLIC.Cd_solicitacao
Where
  TE.email = '".$resultadom['email']."' and
   COSOLICI.Campo27='AP' AND
  COISOLIC.Campo65='AP' AND
  COSOLICI.Situacao<>'L' AND
  COISOLIC.Situacao<>'L'
  ORDER BY COSOLICI.Dt_modificacao DESC";
  
  
  $resConsultaEmails = odbc_exec($conCab, $consultaEmails);

			
	 while($objCiV = odbc_fetch_object($resConsultaEmails)){
			if(empty($objCiV)){
				?>
       <script type="text/javascript">
	     alert("Nenhuma CI Vinculada!");
         window.location.href = 'home.php';
       </script>
       <?php
				}else{
					$selectCi=mysql_query("SELECT idci FROM ciweb WHERE idci='".$objCiV->Solicitacao."'") or die (mysql_error());
					$arrayCi=mysql_fetch_array($selectCi);
					if(empty($arrayCi)){
					$SQLConsItemCIV = "SELECT 
										COISOLIC.*,
  										GEEMPRES.Nome_completo
							  FROM COISOLIC Inner Join
  								   GEEMPRES On GEEMPRES.Cd_empresa = COISOLIC.Cd_solicitante
							  WHERE COISOLIC.cd_especie_esto='E'
							  AND COISOLIC.cd_solicitacao='".$objCiV->Solicitacao."'";
			$resConsItemCIV = odbc_exec($conCab, $SQLConsItemCIV);
			$valorTotalItens=0;
			$nomeCompleto='CI Sem item Vinculado';
			while($objConsItemCIV = odbc_fetch_object($resConsItemCIV)){
			$valorCItemV=$objConsItemCIV->Quantidade*$objConsItemCIV->Pr_unitario;
			$valorTotalItens=$valorCItemV+$valorTotalItens;
			$nomeCompleto=$objConsItemCIV->Nome_completo;
			}
			echo "<div id='tabela'><table width='100%' border='1'><tr><th width='30'><strong>Data de Atualiza&ccedil;&atilde;o</strong></th><th width='80'><strong>Processo/Evento</strong></th><th width='30'><strong>N&ordm; CI</strong></th><th width='150'><strong>Solicitante</strong></th><th width='60'>Total(R$)</th></tr>";

			echo "<form action='atualizaCiAdm.php' method='post' name='form4.id_CI' > <tr><td>".date("d/m/Y",strtotime($objCiV->Dt_modificacao))."</td><td><input name='user_ci' id='user_ci' value='".$usuario."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$objCiV->Solicitacao."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$objCiV->Desc_cond_pag."' size='40' type='hidden' /><strong>".$objCiV->Desc_cond_pag."</strong></td><td>".$objCiV->Solicitacao."</td><td>".$nomeCompleto."</td><td>R$ ".number_format($valorTotalItens, 2, ',', '.')."</td></tr><tr><th width='40'>Situa&ccedil;&atilde;o</th><th width='50'><strong>Respons&aacute;vel</strong></th><th width='50'>Modificar</th><th width='50' colspan='2'>Visualizar CI</th></tr><tr><td><div id='select'><select name='controle'>";
			echo"<option selected='selected'>Escolha</option>";
			echo"<option value='Desginado'> Designado </option>
			<option value='Finalizado'> Finalizado </option>
			</select></div></td><td>";
			echo "<div id='select'><select name='resp'><option selected='selected'>Escolha</option>";
			
			$selectResp="SELECT nome FROM usuarios WHERE s1='".$resultadom['s1']."'";
			$resultadoResp =  mysql_query($selectResp) or die(mysql_error());
			while($objselectResp = mysql_fetch_object($resultadoResp)){
			 echo "<option value='".$objselectResp->nome."'>".$objselectResp->nome."</option>";
			 }
			echo "</select></div>";
			
			echo"</td><td><input name='enviar5' class='buttonVerde' type='submit' value='Atualizar' /></form></td><td colspan='2'> </form><form action='imprimeCi.php' method='post' name='form4.id_CIImprimir' target='_blank'><input name='id_ciImpressao' id='id_ciImpressao' value='".$objCiV->Solicitacao."' size='40' type='hidden' /><input name='enviar7' class='buttonVerde' type='submit' value='Visualizar CI' /></form></td></tr></table></div><br/><br/>";
					}
			   }
			}
echo "<hr><h4>CIs Designadas</h4>";  
while($objresCiWeb = mysql_fetch_object($resultadoCiWeb)){
if($objresCiWeb->situacao<>"Finalizado"){
$consultaCiWebCigam="Select DISTINCT TOP 30
  COSOLICI.Solicitacao,
  COSOLICI.cd_unid_negoc,
  COSOLICI.Data,
  COSOLICI.Desc_cond_pag,
  COSOLICI.Dt_modificacao
From
	COSOLICI
WHERE
    COSOLICI.Solicitacao=".$objresCiWeb->idci."
	AND COSOLICI.Situacao<>'L'
	ORDER BY COSOLICI.Dt_modificacao DESC";
	$resConsultaCiWebCigam = odbc_exec($conCab, $consultaCiWebCigam);
	while($objCiVCigam = odbc_fetch_object($resConsultaCiWebCigam)){
			if(empty($objCiVCigam)){
				?>
       <script type="text/javascript">
	     alert("Nenhuma CI Vinculada!");
         window.location.href = 'home.php';
       </script>
       <?php
				}else{
					$SQLConsItemCIVCigam = "SELECT 
										COISOLIC.*,
  										GEEMPRES.Nome_completo
							  FROM COISOLIC Inner Join
  								   GEEMPRES On GEEMPRES.Cd_empresa = COISOLIC.Cd_solicitante
							  WHERE COISOLIC.cd_especie_esto='E'
							  AND COISOLIC.cd_solicitacao='".$objCiVCigam->Solicitacao."'";
			$resConsItemCIVCigam = odbc_exec($conCab, $SQLConsItemCIVCigam);
			$valorTotalItensCigam=0;
			$nomeCompletoCigam='CI Sem item Vinculado';
			while($objConsItemCIVCigam = odbc_fetch_object($resConsItemCIVCigam)){
			$valorCItemVCigam=$objConsItemCIVCigam->Quantidade*$objConsItemCIVCigam->Pr_unitario;
			$valorTotalItensCigam=$valorCItemVCigam+$valorTotalItensCigam;
			$nomeCompletoCigam=$objConsItemCIVCigam->Nome_completo;
			}
			
			echo "<div id='tabela'><table width='100%' border='1'><tr><th width='30'><strong>Data de Atualiza&ccedil;&atilde;o</strong></th><th width='80'><strong>Processo/Evento</strong></th><th width='30'><strong>N&ordm; CI</strong></th><th width='150'><strong>Solicitante</strong></th><th width='60'>Total(R$)</th></tr>";

			
			echo "<form action='atualizaCiAdm.php' method='post' name='form4.id_CI' > <tr><td>".date("d/m/Y",strtotime($objCiVCigam->Dt_modificacao))."</td><td>".$objCiVCigam->Desc_cond_pag."</td><td><input name='user_ci' id='user_ci' value='".$usuario."' size='40' type='hidden' /><input name='id_ci' id='id_ci' value='".$objCiVCigam->Solicitacao."' size='40' type='hidden' /><input name='desc_ci' id='desc_ci' value='".$objCiVCigam->Desc_cond_pag."' size='40' type='hidden' /><strong>".$objCiVCigam->Solicitacao."</strong></td><td>".$nomeCompletoCigam."</td><td>R$ ".number_format($valorTotalItensCigam, 2, ',', '.')."</td></tr><tr><th width='40'>Situa&ccedil;&atilde;o</th><th width='50'><strong>Respons&aacute;vel</strong></th><th width='50'>Modificar</th><th width='50' colspan='2'>Visualizar CI</th></tr><tr><td><select name='controle'>";
			echo"<option selected='selected' value='".$objresCiWeb->situacao."'>".$objresCiWeb->situacao."</option>";	
			echo"<option value='Desginado'> Designado </option><option value='Finalizado'> Finalizado </option></select></td><td>";
			
			echo "<select name='resp'><option selected='selected'>Escolha</option>";
			
			$selectRespCigam="SELECT nome FROM usuarios";
			$resultadoRespCigam =  mysql_query($selectRespCigam) or die(mysql_error());
			   	echo"<option selected='selected' value='".$usuario."'>".$usuario."</option>";	
			while($objselectRespCigam = mysql_fetch_object($resultadoRespCigam)){
			 echo "<option value='".$objselectRespCigam->nome."'>".$objselectRespCigam->nome."</option>";
			 }
			echo "</select>";
			
			echo"</td><td><input name='enviar7' class='buttonVerde' type='submit' value='Atualizar' /></form></td><td colspan='2'> </form><form action='imprimeCi.php' method='post' name='form4.id_CIImprimir' target='_blank'><input name='id_ciImpressao' id='id_ciImpressao' value='".$objCiVCigam->Solicitacao."' size='40' type='hidden' /><input name='enviar7' class='buttonVerde' type='submit' value='Visualizar CI' /></form></td></tr></table></div><br/><br/>";}
					
			} 
  }
}
$arrayresCiWeb = mysql_fetch_object($resultadoCiWeb);
			
?>
</div>
</body>
</html>