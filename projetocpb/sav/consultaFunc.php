<?php 
require "../conectsqlserver.php";
include "../mb.php";
// Recebe o valor enviado 
//$valor = str_replace(",", ".", $valor);
$valor=explode("-",trim($_GET['nm']));
if(!is_numeric($valor[0])){
	echo "inv";
	}else{
$sqlFunc="Select
  RHPESSOAS.NOME,
  RHPESSOAS.PESSOA,
  RHSETORES.DESCRICAO40 As SETORCOMPLETO,
  RHSETORES.DESCRICAO20 As SETORSIGLA,
  RHCARGOS.CARGO,
  RHCARGOS.DESCRICAO20 As NOMECARGO,
  RHPESSOAS.CPF,
  RHCONTRATOS.BANCOCREDOR,
  RHBANCOS.DESCRICAO40 As NOMEBANCO,
  RHBANCOS.AGENCIA,
  RHBANCOS.NROBANCO,
  RHCONTRATOS.CONTACORRENTE
From
  RHPESSOAS Inner Join
  RHCONTRATOS On RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHESCALAS On RHCONTRATOS.ESCALA = RHESCALAS.ESCALA Inner Join
  RHSETORES On RHCONTRATOS.SETOR = RHSETORES.SETOR Inner Join
  RHCARGOS On RHCONTRATOS.CARGO = RHCARGOS.CARGO Inner Join
  RHBANCOS On RHCONTRATOS.BANCOCREDOR = RHBANCOS.BANCO
Where
  RHCONTRATOS.DATARESCISAO Is Null AND RHPESSOAS.PESSOA='".$valor[0]."'";
  $pesquisa=odbc_fetch_array(odbc_exec($conCab,$sqlFunc));
//echo $valor[0];
if(!empty($pesquisa)){
	echo trim($pesquisa['CARGO'])."/".trim($pesquisa['NOMECARGO'])."\n";
		  }else{
			  echo "inex";
			  }
}
?>