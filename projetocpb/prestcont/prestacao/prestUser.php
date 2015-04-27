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
$_SESSION['idPrestCont']='';
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

<form action="prestContUser.php" name="nova" method="post">
<table border="0" width="100%">
<tr><td colspan="2">
<h2 id="h2">Iniciar Prestação de Contas</h2>
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
  RHPESSOAS with (nolock) Inner Join
  RHCONTRATOS with (nolock) On RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHESCALAS with (nolock) On RHCONTRATOS.ESCALA = RHESCALAS.ESCALA Inner Join
  RHSETORES with (nolock) On RHCONTRATOS.SETOR = RHSETORES.SETOR Inner Join
  RHCARGOS with (nolock) On RHCONTRATOS.CARGO = RHCARGOS.CARGO Inner Join
  RHBANCOS with (nolock) On RHCONTRATOS.BANCOCREDOR = RHBANCOS.BANCO
Where
  RHCONTRATOS.DATARESCISAO Is Null
  ORDER BY RHPESSOAS.NOME");
if($_SESSION['usuarioAtualSav']<>'-'){
	$arrayUser=explode("-",$_SESSION['usuarioAtualSav']);
	echo "<option value='".$arrayUser[0]."' selected='selected'>".$arrayUser[1]."</option>";
	while($objUsuarios=odbc_fetch_object($sqlUsuarios)){
		if($arrayUser[0]<>$objUsuarios->PESSOA){
			if($arrayConsUsuario['SETOR']=='0010' || $arrayConsUsuario['SETOR']=='0011' ||$arrayConsUsuario['SETOR']=='0018' ||$arrayConsUsuario['SETOR']=='0013' ||$arrayConsUsuario['SETOR']=='0024' ||$arrayConsUsuario['SETOR']=='0008' ||$arrayConsUsuario['SETOR']=='0022'){
				if($objUsuarios->SETOR=='0010' || $objUsuarios->SETOR=='0011' ||$objUsuarios->SETOR=='0018' ||$objUsuarios->SETOR=='0013' ||$objUsuarios->SETOR=='0024' ||$objUsuarios->SETOR=='0008' ||$objUsuarios->SETOR=='0022'){
				echo "<option value='".$objUsuarios->PESSOA."'>".utf8_encode($objUsuarios->NOME)."</option>";				
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
    </select></td><td><input type="submit" class="buttonVerde" name="novo" value="INICIAR" /></td></tr></table></form>
<br /><br />
<?php
$sqlRegistros=mysql_query("SELECT savregistros.*,prestsav.status AS stprest,prestsav.id AS idprest,prestsav.data AS dataprest FROM savregistros INNER JOIN prestsav WHERE prestsav.savid=savregistros.id");
$countRegistros=mysql_num_rows($sqlRegistros);
//$countRegistros=1;
if($countRegistros>0){
?>
<table id="tabela4"  cellpadding='0' cellspacing='0' border='0' class='display' name='tabela4'>
<thead>
				<tr>
					<th width='10%'><strong>CI</strong></th>
					<th width='25%'><strong>Nome</strong></th>
                    <th width='30%'><strong>Evento/Abrangência</strong></th>
					<th width='15%'><strong>Data da<br /> Prestação</strong></th>
                    <th width='20%'><strong>Status</strong></th>
                    <th width='18%'><strong>Ações</strong></th>
				</tr>				
			</thead>
       <tbody>
<?php 
while($objRegistros=mysql_fetch_object($sqlRegistros)){
$editar="<form action='prestContUser.php' method='post' name='editar'><input type='hidden' name='tp' value='edit'/><input type='hidden' name='id' value='".$objRegistros->idprest."'/><input type=image src='../../sav/css/iconeEditar.png' alt='Editar' title='Editar'/></form>";

$editarRec="<form action='aprovaPrest.php' method='post' name='editar'><input type='hidden' name='retorno' value='prestUser.php'/><input type='hidden' name='tp' value='envia'/><input type='hidden' name='id' value='".$objRegistros->idprest."'/><input type=image src='../../sav/css/iconeAprov.png' alt='Enviar Gestor' title='Enviar Gestor'/></form>";
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
	$numeroCi=$objRegistros->numci;
	}
if($objRegistros->stprest=='pg'){
	$status='Enviado para Gestor';
	$editar='';
	$editarRec='';
	}elseif($objRegistros->stprest=='pt'){
		$status='Enviado para Prest. Contas';
		$editar='';
		$editarRec='';
		}elseif($objRegistros->stprest=='fi'){
			$status='Finalizado';
			$editar='';
			$editarRec='';
			}elseif($objRegistros->stprest=='rec'){
				$status='Recusada';
				}
echo "<tr>
	  <td>".$numeroCi."</td>
		<td>".$nomeFuncionario."</td>
		<td>".utf8_encode($objRegistros->evento)."-".				$objRegistros->abrangencia."</td>
		<td>".$objRegistros->dataprest."</td>
		<td>".$status."</td>
		<td><table border='0' width='100%'><tr><td><a href='visualizaPrest.php?gest=".$objRegistros->idprest."' target='_blank'><img src='../../sav/css/iconeVisualiza.png' title='Visualizar' alt='Visualizar'/></a></td><td>".$editar."</td><td>".$editarRec."</td></tr></table></td>
</tr>";
 }
}
//Colocar botões de ação
?>       
     </tbody>
  </table>
  <?php
}
   ?>
</div>
<a href="../../sav/index.php"><input type="button" class="button" value="<<Voltar"></a>
</div>
</div>
</body>
</html>
<?PHP 
}
?>