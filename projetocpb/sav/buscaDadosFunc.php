<?php 
$sqlBuscaCpfFunc=odbc_exec($conCab,"Select
  RHPESSOAS.CPF
  From
  RHPESSOAS WITH(NOLOCK) Inner Join
  RHCONTRATOS WITH(NOLOCK) On RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA
  Where
  RHPESSOAS.PESSOA = '".$_SESSION['idFuncSav']."' And
  RHCONTRATOS.DATARESCISAO Is Null AND RHPESSOAS.EMPRESA='0001'") or die("<p>".odbc_errormsg());
$buscaCPFFuncionario=odbc_fetch_array($sqlBuscaCpfFunc);
$scriptDadosCigam="Select
  GEEMPRES.Cnpj_cpf,
  GEEMPRES.Cd_empresa As Cd_empresa1,
  GEPFISIC.Cargo
From
  GEEMPRES WITH(NOLOCK) left Join
  GEPFISIC WITH(NOLOCK) On GEPFISIC.Cd_empresa = GEEMPRES.Cd_empresa
Where
GEEMPRES.Cnpj_cpf='".trim($buscaCPFFuncionario['CPF'])."'";
		$sqlDadosCigam=odbc_exec($conCab2,$scriptDadosCigam);
$arrayDadosCigam=odbc_fetch_array($sqlDadosCigam);
$idBenef=$arrayDadosCigam['Cd_empresa1'];
$cargoBenef=$arrayDadosCigam['Cargo'];
?>