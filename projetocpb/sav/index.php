<?php
//Ajustar layout
//Fazer novos testes
//Incluir with NOLOCK nos selects e deixar (nolock) nos joins

session_start();
if($_SESSION['usuario']=='' || empty($_SESSION['usuario'])){
	echo "<script>alert('Efetue o login!');top.location.href='loginad.php';</script>"; 
	}
require "../conectsqlserver.php";
require "conectsqlserversav.php";
require "../conect.php";
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
$_SESSION['userCigamSav']=$_GET['cigam'];
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
<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
<link rel="stylesheet" href="../datatables/estilo/table_jui.css" />
<link rel="stylesheet" href="../datatables/estilo/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" href="../jquery.autocomplete.css" />
<script type="text/javascript" src="../datatables/js/jquery.mim.js"></script>
<script type="text/javascript" src="../datatables/js/jquery.dataTables.min.js"></script>
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
<img src="../datatables/ajax-loader.gif" alt="preload" border="0" />
</div>
<div id='conteudo' style='visibility:hidden'>
    <br/>
    
<h1 id="h1">SAV - Solicitação de Auxílio Viagem</h1>

<form action="novaSav.php" name="nova" method="post">
<table border="0" width="100%">
<tr><td colspan="2">
<h2 id="h2">Criar SAV</h2>
</td></tr><tr><td>
<strong>Funcionário:</strong> 
<input type="hidden" class="input" name="tp" id="tp" value="criar"/>

<select name="nome" id="nome">
<?php
$sqlUsuarios=odbc_exec($conCab,"Select
  RHPESSOAS.NOME,
  RHPESSOAS.PESSOA,
  RHSETORES.SETOR
From
  RHPESSOAS With(NoLock) Inner Join
  RHCONTRATOS With(NoLock) On RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA inner Join
  RHESCALAS With(NoLock) On RHCONTRATOS.ESCALA = RHESCALAS.ESCALA inner Join
  RHSETORES With(NoLock) On RHCONTRATOS.SETOR = RHSETORES.SETOR Inner Join
  RHCARGOS With(NoLock) On RHCONTRATOS.CARGO = RHCARGOS.CARGO
Where
  RHCONTRATOS.DATARESCISAO Is Null
Order By
  RHPESSOAS.NOME");
if($_SESSION['usuarioAtualSav']<>'-'){
	$arrayUser=explode("-",$_SESSION['usuarioAtualSav']);
	echo "<option value='".$arrayUser[0]."-".$arrayUser[1]."' selected='selected'>".$arrayUser[1]."</option>";
	while($objUsuarios=odbc_fetch_object($sqlUsuarios)){
		if(($objUsuarios->PESSOA=='9249' && $arrayConsUsuario['PESSOA']=='75')|| ($objUsuarios->PESSOA=='20' && $arrayConsUsuario['PESSOA']=='16')){
				  echo "<option value='".$objUsuarios->PESSOA."-".utf8_encode($objUsuarios->NOME)."'>".utf8_encode($objUsuarios->NOME)."</option>";
		}
		if($arrayUser[0]<>$objUsuarios->PESSOA){
			if($arrayConsUsuario['SETOR']=='0010' || $arrayConsUsuario['SETOR']=='0011' ||$arrayConsUsuario['SETOR']=='0018' ||$arrayConsUsuario['SETOR']=='0013' ||$arrayConsUsuario['SETOR']=='0024' ||$arrayConsUsuario['SETOR']=='0008' ||$arrayConsUsuario['SETOR']=='0022'){
				if($objUsuarios->SETOR=='0010' || $objUsuarios->SETOR=='0011' ||$objUsuarios->SETOR=='0018' ||$objUsuarios->SETOR=='0013' ||$objUsuarios->SETOR=='0024' ||$objUsuarios->SETOR=='0008' ||$objUsuarios->SETOR=='0022'){
				echo "<option value='".$objUsuarios->PESSOA."-".utf8_encode($objUsuarios->NOME)."'>".utf8_encode($objUsuarios->NOME)."</option>";				
				}
				}elseif($arrayConsUsuario['SETOR']==$objUsuarios->SETOR){
			echo "<option value='".$objUsuarios->PESSOA."-".utf8_encode($objUsuarios->NOME)."'>".utf8_encode($objUsuarios->NOME)."</option>";
			  }
			}
		}
	}else{
		echo "<option value='0' selected='selected'>Selecione</option>";
		while($objUsuarios=odbc_fetch_object($sqlUsuarios)){
			echo "<option value='".$objUsuarios->PESSOA."-".utf8_encode($objUsuarios->NOME)."'>".utf8_encode($objUsuarios->NOME)."</option>";
			}
		}?>
    </select>
    <br /><strong>Tipo de Evento:</strong> 
    <select name="tipoevento">
<option value="Nacional" selected="selected">Nacional</option>
<option value="Internacional">Internacional</option>
</select></td><td><input type="submit" class="buttonVerde" name="novo" value="Nova SAV" /></td></tr></table></form>
<br /><br />
<?php
$sqlRegistros=mysql_query("SELECT * FROM savregistros");
$countRegistros=mysql_num_rows($sqlRegistros);
if($countRegistros>0){
?>
<div align="right">
<a href="../prestcont/prestacao/prestUser.php">
<input type="button" class="buttonVerde" name="prest" value="Prestação de Contas" />
</a></div>
<table id="tabela4"  cellpadding='0' cellspacing='0' border='0' class='display' name='tabela4'>
<thead>
				<tr>
					<th width='10%'><strong>CI</strong></th>
					<th width='25%'><strong>Nome</strong></th>
                    <th width='35%'><strong>Evento</strong></th>
                    <th width='10%'><strong>Status</strong></th>
                  
					<th width='20%'><strong>Ação</strong></th>
				</tr>				
			</thead>
       <tbody>
<?php 
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
$numeroCi='N/A';
$status='Elaboração';
$idCiEdit='';
if($arrayConsUsuario['SETOR']==$sqlFuncionario['SETOR'] || (($arrayConsUsuario['SETOR']=='0010' || $arrayConsUsuario['SETOR']=='0011' ||$arrayConsUsuario['SETOR']=='0018' ||$arrayConsUsuario['SETOR']=='0013' ||$arrayConsUsuario['SETOR']=='0024' ||$arrayConsUsuario['SETOR']=='0008' ||$arrayConsUsuario['SETOR']=='0022')&&($sqlFuncionario['SETOR']=='0010' || $sqlFuncionario['SETOR']=='0011' ||$sqlFuncionario['SETOR']=='0018' ||$sqlFuncionario['SETOR']=='0013' ||$sqlFuncionario['SETOR']=='0024' ||$sqlFuncionario['SETOR']=='0008' ||$sqlFuncionario['SETOR']=='0022')) || ($objRegistros->funcionario=='9249' && $arrayConsUsuario['PESSOA']=='75') || ($objRegistros->funcionario=='4' && $arrayConsUsuario['PESSOA']=='16') || ($objRegistros->funcionario=='20' && $arrayConsUsuario['PESSOA']=='16')){
 if(!empty($objRegistros->numci) || $objRegistros->numci<>0){
	 
	$numeroCi=$objRegistros->numci;
	$scriptControleCi=odbc_exec($conCab2,"SELECT campo27 FROM COSOLICI with (nolock) Where Solicitacao='".$objRegistros->numci."'")or die("<p>".odbc_errormsg());
	$sqlControleCi=odbc_fetch_array($scriptControleCi);
	
	if($sqlControleCi['campo27']=='03'){
		$status='Elaboração';
		$idCiEdit=$objRegistros->numci;
		$updateSav=mysql_query("UPDATE savregistros SET status='".$status."' AND situacao='Pendente de Aprovacao' WHERE id='".$objRegistros->id."'");
		$editar="<form action='novaSav.php' method='post' name='editar'><input type='hidden' name='tp' value='edit'/><input type='hidden' name='id' value='".$objRegistros->id."'/><input type='hidden' name='ci' value='".$idCiEdit."'/><input type=image src='css/iconeEditar.png' alt='Editar' title='Editar'/></form>";
		$inativar="<form action='excluiSav.php' method='post' name='exclui'><input type='hidden' name='id' value='".$objRegistros->id."'/><input type='hidden' name='ci' value='".$idCiEdit."'/><input type='hidden' name='acao' value='inativa'/><input type=image src='css/icone_excluir.png' alt='Excluir' title='Excluir'/></form>";		
		}elseif($sqlControleCi['campo27']=='AP'){
			$status='CI Aprovada';
			$editar="";
			$updateSav=mysql_query("UPDATE savregistros SET status='".$status."' AND situacao='Aprovada'");
			}else{
				$status='Em Andamento';
				$editar="";
				if($objRegistros->situacao<>'Aprovada'){
				$updateSav=mysql_query("UPDATE savregistros SET status='".$status."' AND situacao='Em Andamento'");
				}else{
					$updateSav=mysql_query("UPDATE savregistros SET status='".$status."'");
					}
				}
	}
$statusSav=utf8_encode($objRegistros->situacao);
			if($statusSav=='Aprovada'){
				$statusSav='SAV Aprovada';
			    $editar="";
				}elseif($statusSav=='Cancelada'){
					$status='Cancelada';
					$statusSav='Cancelada';
					$editar="";
					$inativar="";
					}
echo "<tr>
<td>".$numeroCi."</td>
<td>".$nomeFuncionario."</td>
<td>".utf8_encode($objRegistros->evento)."-".$objRegistros->abrangencia."<br>Ida: ".$objRegistros->dtida." <br> Volta: ".$objRegistros->dtvolta."</td>
<td align='center'><strong>".$status."</strong></td>
<td><table border='0' width='100%'><tr><td><a href='geraPdfSav.php?gest=".$objRegistros->id."' target='_blank'><img src='css/iconeVisualiza.png' title='Visualizar' alt='Visualizar'/></a></td><td>".$editar."</td><td>".$inativar."</td></tr></table></td>
</tr>";
 }
}
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