<?php 
		//Resgata dados da CI
		$sqlConsSitControle="SELECT Sit_solicitacao
			   FROM COCSO WITH(NOLOCK)
			   WHERE controle = dbo.CGFC_BUSCA_CONFIGURACAO(490,null)";
$resConsSitControle = odbc_exec($conCab2, $sqlConsSitControle);
$arrayConsSitControle = odbc_fetch_array($resConsSitControle);
$situacao=$arrayConsSitControle['Sit_solicitacao'];
$cidadeUf='';
//Nacional
if($_SESSION['abrangenciaSav']=='Nacional'){
	$SqlcidadeUf=mysql_fetch_array(mysql_query("SELECT municipio,uf FROM municipios WHERE id='".$arrayRegistro['origemida']."'"));
	$cidadeUf=$SqlcidadeUf['municipio']."/".$SqlcidadeUf['uf'];
}else{
	$SqlcidadeUf=mysql_fetch_array(mysql_query("SELECT nome,iso FROM paises WHERE iso='".$arrayRegistro['origemida']."'"));
	$cidadeUf=$SqlcidadeUf['nome']."/".$SqlcidadeUf['iso'];
	}
$solicitacao=$numCi;
$_SESSION['numCiSav']=$solicitacao;
$SQLAtualizaCi="UPDATE COSOLICI SET 
   local_entrega= '".$cidadeUf."',
   cod_cliente='".$gestor."',
   desc_cond_pag='[SAV ".$numSav."]:".$arrayRegistro['evento']."',
   usuario_modific='".$userCriac."',
   Dt_modificacao=dbo.CGFC_DATAATUAL ()
   WHERE solicitacao='".$solicitacao."'";
$resAtCi = odbc_exec($conCab2, $SQLAtualizaCi) or die("<p>".odbc_errormsg());
?>