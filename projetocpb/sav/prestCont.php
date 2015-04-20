<?php
//Ajustar layout
//Fazer novos testes
//Incluir with NOLOCK nos selects e deixar (nolock) nos joins

session_start();
require "../conectsqlserver.php";
require "conectsqlserversav.php";
require "../conect.php";
$_SESSION['numSav']='';
$_SESSION['numCiSav']='';

if($_SESSION['usuario']=='' || empty($_SESSION['usuario'])){
	echo "<script>alert('Efetue o login!');top.location.href='loginad.php';</script>"; 
	}
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
<h2 id='h2'> Inserir Parâmetros da SAV</h2>
<?php
echo "<a href='parametros.php?usuario=$userCriac'><input type='button' class='button' value='Parâmetros' name='novoparam'/></a><br>";
$sqlRegistros=mysql_query("SELECT * FROM savregistros WHERE situacao<>'Cancelada'");
$countRegistros=mysql_num_rows($sqlRegistros);
if($countRegistros>0){
?>
<h2 id="h2">Relação de SAV Cadastradas</h2>
<table id="tabela4"  cellpadding='0' cellspacing='0' border='0' class='display' name='tabela4'>
<thead>
				<tr>
					<th width='10%'><strong>CI</strong></th>
					<th width='25%'><strong>Nome</strong></th>
                    <th width='33%'><strong>Evento</strong></th>
                    <th width='20%'><strong>Status</strong></th>
					<th width='32%'><strong>Ações</strong></th>
				</tr>				
			</thead>
       <tbody>
<?php 
while($objRegistros=mysql_fetch_object($sqlRegistros)){
$editar='';
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
 if(!empty($objRegistros->numci) || $objRegistros->numci<>0){
	$numeroCi=$objRegistros->numci;
	$scriptControleCi=odbc_exec($conCab2,"SELECT campo27 FROM COSOLICI with (nolock) Where Solicitacao='".$objRegistros->numci."'")or die("<p>".odbc_errormsg());
	$sqlControleCi=odbc_fetch_array($scriptControleCi);
	
	if($sqlControleCi['campo27']=='03'){
		$status='Elaboração';
		$idCiEdit=$objRegistros->numci;
		$updateSav=mysql_query("UPDATE savregistros SET status='".$status."' AND situacao='Pendente de Aprovacao' WHERE id='".$objRegistros->id."'");
		$editar="<form action='novaSav.php' method='post' name='editar'><input type='hidden' name='tp' value='edit'/><input type='hidden' name='id' value='".$objRegistros->id."'/><input type='hidden' name='ci' value='".$idCiEdit."'/><input type=image src='css/iconeEditar.png' alt='Editar' title='Editar'/> </form>";
		
		}elseif($sqlControleCi['campo27']=='AP'){
			$status='CI Aprovada';
			$editar="<a href='geraPdfSav.php?gest=".$objRegistros->id."' target='_blank'><img src='css/iconeVisualiza.png' title='Visualizar' alt='Visualizar'/></a>";
			$updateSav=mysql_query("UPDATE savregistros SET status='".$status."' AND situacao='Aprovada'");
			}else{
				$status='Em andamento';
				$editar="<a href='geraPdfSav.php?gest=".$objRegistros->id."' target='_blank'><img src='css/iconeVisualiza.png' title='Visualizar' alt='Visualizar'/></a>";
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
			    $editar="<a href='geraPdfSav.php?gest=".$objRegistros->id."' target='_blank'><img src='css/iconeVisualiza.png' title='Visualizar' alt='Visualizar'/></a>";
				} 
if(empty($editar)){
$editar="<form action='novaSav.php' method='post' name='editar'><input type='hidden' name='tp' value='edit'/><input type='hidden' name='id' value='".$objRegistros->id."'/><input type='hidden' name='ci' value='".$idCiEdit."'/><input type=image src='css/iconeEditar.png' alt='Editar' title='Editar'/></form>";
}
$inativar='';
if($sqlControleCi['campo27']<>'AP'){
	$inativar="<form action='excluiSav.php' method='post' name='exclui'><input type='hidden' name='id' value='".$objRegistros->id."'/><input type='hidden' name='ci' value='".$idCiEdit."'/><input type='hidden' name='acao' value='inativapc'/><input type=image src='css/icone_excluir.png' alt='Excluir' title='Excluir'/></form>";
	}
echo "<tr>
<td>".$numeroCi."</td>
<td>".$nomeFuncionario."</td>
<td>".utf8_encode($objRegistros->evento)."-".$objRegistros->abrangencia."<br>Ida: ".$objRegistros->dtida." <br>Volta: ".$objRegistros->dtvolta."</td>
<td align='center'><font size='-1'><strong>".$status."</strong></font></td>
<td><table border='0' width='100%'><tr><td>".$editar."</td><td>".$inativar."</td></tr></table></td>
</tr>";
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