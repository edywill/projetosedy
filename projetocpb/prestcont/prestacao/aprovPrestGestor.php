<?php
//Ajustar layout
//Fazer novos testes
//Incluir with NOLOCK nos selects e deixar (nolock) nos joins

session_start();
if($_SESSION['usuario']=='' || empty($_SESSION['usuario'])){
	echo "<script>alert('Efetue o login!');top.location.href='loginad.php';</script>"; 
	}
require "../../conectsqlserver.php";
require "../../sav/conectsqlserversav.php";
require "../../conect.php";
$_SESSION['gerenSavNome']='';
$_SESSION['gerenSav']='';
$_SESSION['ciddestinoPasSav']='';
$_SESSION['cidorigemPasSav']='';
$_SESSION['cidHosSav']='';
$_SESSION['cotacaoDiaSav']='';
$_SESSION['cotacaoDataSav']='';
$_SESSION['cadeiranteSav']='';
$_SESSION['gestorSav']='';
$_SESSION['gestorSavNome']='';
$_SESSION['valorPasSav']='';
$_SESSION['valorHosSav']='';
$_SESSION['idaeVoltaSav']='';
$_SESSION['numSav']='';
$_SESSION['numCiSav']='';
$_SESSION['tpFuncSav']='';
$_SESSION['cpfSav']='';
$_SESSION['nomeSav']='';
$_SESSION['idFuncSav']='';
$_SESSION['tituloSav']='';
$_SESSION['tpSav']='';
$_SESSION['setorSav']='';
$_SESSION['cargoSav']='';
$_SESSION['bancoSav']='';
$_SESSION['agenciaSav']='';
$_SESSION['contCorrenteSav']='';
$_SESSION['idCargo']='';
$_SESSION['abrangenciaSav']='';
$_SESSION['eventoSav']='';
$_SESSION['objetivoSav']='';
$_SESSION['dtidaSav']='';
$_SESSION['dtvoltaSav']='';
$_SESSION['origemidaSav']='';
$_SESSION['destinoidaSav']='';
$_SESSION['origemvoltaSav']='';
$_SESSION['destinovoltaSav']='';
$_SESSION['horarioidaSav']='';
$_SESSION['horariovoltaSav']='';
$_SESSION['ultimaViagSav']='';
$_SESSION['bilheteSav']='';
$_SESSION['passagemSav']='';
$_SESSION['diariaSav']='';
$_SESSION['transladoSav']='';
$_SESSION['observacaoSav']='';
$_SESSION['dtidaSavEvento']='';
$_SESSION['dtvoltaSavEvento']='';
$_SESSION['cidorigemvoltaSav']='';
$_SESSION['ciddestinovoltaSav']='';
$_SESSION['cidorigemidaSav']='';
$_SESSION['ciddestinoidaSav']='';
if(!empty($_GET['usuario'])){
$userCriac=$_GET['usuario'];
$_SESSION['userSav']=$userCriac;
$_SESSION['funcValidSav']='';
$_SESSION['funcValidSavCons']='';
}else{
	$userCriac=$_SESSION['userSav'];
	}
if($_SESSION['userSav']=='A02' || empty($_SESSION['userSav'])){
?>
       <script type="text/javascript">
       alert("Para acessar esse m\u00f3dulo, solicite a vincula\u00e7\u00e3o do seu usu\u00e1rio do CIGAM a intranet!");
       window.location='../home.php';
       </script>
       <?php

}else{
$sqlEmail=mysql_fetch_array(mysql_query("SELECT email FROM usuarios WHERE nome LIKE '".$userCriac."'"));
$_SESSION['emailSav']=trim($sqlEmail['email']);
$sqlConsultaUsuario="Select
  RHPESSOAS.NOME,
  RHPESSOAS.PESSOA,
  RHSETORES.SETOR
From
  RHPESSOAS with (nolock) Inner Join
  RHCONTRATOS with (nolock) On RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHESCALAS with (nolock) On RHCONTRATOS.ESCALA = RHESCALAS.ESCALA Inner Join
  RHSETORES with (nolock) On RHCONTRATOS.SETOR = RHSETORES.SETOR Inner Join
  RHCARGOS with (nolock) On RHCONTRATOS.CARGO = RHCARGOS.CARGO Inner Join
  RHBANCOS with (nolock) On RHCONTRATOS.BANCOCREDOR = RHBANCOS.BANCO
Where
  RHCONTRATOS.DATARESCISAO Is Null AND RHPESSOAS.EMAILCORPORATIVO='".$_SESSION['emailSav']."'";
$execConsUsuario=odbc_exec($conCab,$sqlConsultaUsuario);
$arrayConsUsuario=odbc_fetch_array($execConsUsuario);
$_SESSION['usuarioAtualSav']=trim($arrayConsUsuario['PESSOA'])."-".trim($arrayConsUsuario['NOME']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../../sav/css/estilo.css"/>
<link rel="stylesheet" href="../../datatables/estilo/table_jui.css" />
<link rel="stylesheet" href="../../datatables/estilo/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" href="../../jquery.autocomplete.css" />
<script type="text/javascript" src="../../datatables/js/jquery.mim.js"></script>
<script type="text/javascript" src="../../datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var oTable = $('#tabela4').dataTable({
		"bPaginate": true,
		"bNext":'Proximo',
		"bJQueryUI": true,
		"bDestroy":true,
		"bProcessing": true,
		"bServerSide": false,
		"sPaginationType": "full_numbers",
		"order": [[ 0, "desc" ]]
	});
});
</script>
  <script type="text/javascript">
  function mostra(){
	  if(window.onload){
		  document.getElementById('lendo').style.display="none"
		  document.getElementById('conteudo').style.visibility="visible"
		  }
	  }
	  window.onload=mostra
  </script>
  <style>
  .invisivel { display: none; }
  .visivel { visibility: visible; }
  </style>
  <style type="text/css">
  .imgpos{
	  position:absolute;
	  left:50%;
	  top:50%;
	  margin-left:-110px;
	  margin-top:-60px;
	  width:200px;
	  height:200px;
	  z-index:2;
	  }
  </style>
</head>
<body onKeyDown="javascript:return bloqueioTeclas();">
<div id='box3' style="height:auto">
<div id='lendo' style="padding-top:60px; padding-left:10px">
<h1 id="h1">Carregando dados...</h1>
<img src="../../datatables/ajax-loader.gif" alt="preload" border="0" />
</div>
<div id='conteudo' style='visibility:hidden'>
    <br/>
    
<h1 id="h1">Prestação de Contas - (SAV)</h1>
<?php
$sqlRegistros=mysql_query("SELECT savregistros.*,prestsav.status AS stprest,prestsav.id AS idprest,prestsav.data AS dataprest FROM savregistros INNER JOIN prestsav WHERE prestsav.savid=savregistros.id");
//$countRegistros=mysql_num_rows($sqlRegistros);
$countRegistros=1;
if($countRegistros>0){
?>
<table id="tabela4"  cellpadding='0' cellspacing='0' border='0' class='display' name='tabela4'>
<thead>
				<tr>
					<th width='10%'><strong>SAV<br />CI</strong></th>
					<th width='25%'><strong>Nome</strong></th>
                    <th width='30%'><strong>Evento/Abrangência</strong></th>
					<th width='15%'><strong>Data da<br /> Prestação</strong></th>
                    <th width='20%'><strong>Visualizar</strong></th>
                    <th width='8%'><strong>Aprovar</strong></th>
                    <th width='10%'><strong>Rejeitar</strong></th>
				</tr>				
			</thead>
       <tbody>
<?php 
/*
while($objRegistros=mysql_fetch_object($sqlRegistros)){
$editar='';
$inativar='';
$nomeFuncionario='';
$sqlFuncionario=odbc_fetch_array(odbc_exec($conCab,"Select
  RHPESSOAS.NOME,
  RHPESSOAS.PESSOA,
  RHCONTRATOS.SETOR 
From
  RHPESSOAS with (nolock) INNER JOIN
  RHCONTRATOS with (nolock) On RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA
Where
RHPESSOAS.PESSOA='".$objRegistros->funcionario."'"));
$nomeFuncionario=utf8_encode($sqlFuncionario['NOME']);
$numeroCi='<br>Sem CI Vinculada';
$status='Elaboração';
$idCiEdit='';
if($arrayConsUsuario['SETOR']==$sqlFuncionario['SETOR'] || (($arrayConsUsuario['SETOR']=='0010' || $arrayConsUsuario['SETOR']=='0011' ||$arrayConsUsuario['SETOR']=='0018' ||$arrayConsUsuario['SETOR']=='0013' ||$arrayConsUsuario['SETOR']=='0024' ||$arrayConsUsuario['SETOR']=='0008' ||$arrayConsUsuario['SETOR']=='0022')&&($sqlFuncionario['SETOR']=='0010' || $sqlFuncionario['SETOR']=='0011' ||$sqlFuncionario['SETOR']=='0018' ||$sqlFuncionario['SETOR']=='0013' ||$sqlFuncionario['SETOR']=='0024' ||$sqlFuncionario['SETOR']=='0008' ||$sqlFuncionario['SETOR']=='0022'))){
$statusSav=utf8_encode($objRegistros->situacao);
		
if(empty($editar)){
$editar="";
}
if(empty($inativar)){
	$inativar="";
	}
if(!empty($objRegistros->numci)){
	$numeroCi='<br>'.$objRegistros->numci;
	}
if($objRegistros->numci=='pg'){
	$status='Gestor';
	}elseif($objRegistros->numci=='pt'){
		$status='Prest. Contas';
		}elseif($objRegistros->numci=='fi'){
			$status='Finalizado';
			}
echo "<tr>
<td>".$objRegistros->id.$numeroCi."</td>
<td>".$nomeFuncionario."</td>
<td>".utf8_encode($objRegistros->evento)."-".$objRegistros->abrangencia."</td>
<td>".$objRegistros->dataprest."</td>
<td>".$status."</td>
<td>".$editar."</td>
<td>".$inativar."</td>
</tr>";
 }
}
*/
echo "<tr>
<td>37<br>7669</td>
<td>GLEDIANA FERREIRA</td>
<td>OPEN CAIXA LOTERIAS 2 -NACIONAL</td>
<td>06/04/2015</td>
<td><a href=''>VISUALIZAR</a></td>
<td><a href=''>Aprovar</a></td>
<td><a href=''>Rejeitar</a></td>
</tr>";
?>       
     </tbody>
  </table>
  <?php
}
   ?>
</div>

</div>
</div>
</body>
</html>
<?PHP 
}
?>