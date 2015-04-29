<?php
//Ajustar layout
//Fazer novos testes
//Incluir with NOLOCK nos selects e deixar (nolock) nos joins

session_start();
$_SESSION['setorGestSav']='';
if($_SESSION['usuario']=='' || empty($_SESSION['usuario'])){
	echo "<script>alert('Efetue o login!');top.location.href='loginad.php';</script>"; 
	}
require "../conectsqlserver.php";
require "conectsqlserversav.php";
require "../conect.php";

if(!empty($_GET['usuario'])){
$userCriac=$_GET['usuario'];
$_SESSION['userSav']=$userCriac;
$userCigam=$_GET['cigam'];
$_SESSION['cigamSav']=$userCigam;
}else{
	$userCriac=$_SESSION['userSav'];
	$userCigam=$_SESSION['cigamSav'];
	}

$dadosIntranet=mysql_fetch_array(mysql_query("SELECT * FROM usuarios WHERE usuario='".$_SESSION['usuario']."'"));
$sqlGestor=odbc_fetch_array(odbc_exec($conCab,"Select
  RHPESSOAS.NOME,
  RHPESSOAS.PESSOA,
  RHCONTRATOS.SETOR 
From
  RHPESSOAS with (nolock) INNER JOIN
  RHCONTRATOS with (nolock) On RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA
Where
RHPESSOAS.EMAILCORPORATIVO='".$dadosIntranet['email']."'"));
$_SESSION['setorGestSav']=$sqlGestor['SETOR'];
if(empty($_SESSION['setorGestSav'])){
	?>
       <script type="text/javascript">
       alert("Acesso não Autorizado! \\n Caso necessite acessar, verifique com a DTI e-mail cadastrado na Intranet e META.");
       window.location="../home.php";
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
<div id='lendo' style="padding-top:60px; padding-left:10px">
<h1 id="h1">Carregando dados...</h1>
<img src="../datatables/ajax-loader.gif" alt="preload" border="0" />
</div>
<div id='conteudo' style='visibility:hidden'>
<div id='box3' style="height:auto">
    <br/>
    
<h1 id="h1">SAV - Solicitação de Auxílio Viagem</h1>
<table id="tabela4"  cellpadding='0' cellspacing='0' border='0' class='display' name='tabela4'>
<thead>
				<tr>
					<th width='10%'>CI</th>
					<th width='25%'>Nome</th>
                    <th width='35%'>Evento</th>
                    <th width='30%'>Ação</th>
				</tr>				
			</thead>
       <tbody>
<?php 
$sqlRegistros=mysql_query("SELECT * FROM savregistros WHERE gestor='".$userCriac."' AND  (situacao<>'Cancelada' AND situacao<>'Devolvida') AND numci <>0");
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
$numeroCi='N/D';
$status='Elaboração';
$idCiEdit='';
 $editarRec='';
 if(!empty($objRegistros->numci) || $objRegistros->numci<>0){
	$numeroCi=$objRegistros->numci;
	$scriptControleCi=odbc_exec($conCab2,"SELECT campo27 FROM COSOLICI (nolock) Where Solicitacao='".$objRegistros->numci."'")or die("<p>".odbc_errormsg());
	$sqlControleCi=odbc_fetch_array($scriptControleCi);
	if($sqlControleCi['campo27']=='03'){
		$status='Elaboração';
		$idCiEdit=$objRegistros->numci;
		$updateSav=mysql_query("UPDATE savregistros SET status='".$status."' AND situacao='Pendente de Aprovacao'");
		$editar="<form action='aprovaSav.php' method='post' name='editar' onSubmit=\"this.elements['aprov'].disabled=true;\"><input type='hidden' name='tp' value='aprov'/><input type='hidden' name='id' value='".$objRegistros->id."'/><input type='hidden' name='ci' value='".$idCiEdit."'/><input type='hidden' name='descci' value='".utf8_encode($objRegistros->evento)."'/><input type=image src='css/iconeAprov.png' id='aprov' name='aprov' alt='Aprovar' title='Aprovar'/></form>";
		$editarRec="<form action='aprovaSav.php' method='post' name='editar'><input type='hidden' name='tp' value='recusa'/><input type='hidden' name='id' value='".$objRegistros->id."'/><input type='hidden' name='ci' value='".$idCiEdit."'/><input type='hidden' name='descci' value='".utf8_encode($objRegistros->evento)."'/><input type=image src='css/icone_excluir.png' alt='Recusar' title='Recusar'/></form>";
		
		}else{
			$status='CI Aprovada';
			$editar="ND";
			$updateSav=mysql_query("UPDATE savregistros SET status='".$status."' AND situacao='Aprovada'");
			}
	}
$statusSav=utf8_encode($objRegistros->situacao);
	 
if(empty($editar)){
	//Desabilitar botao no submit
		$editar="<form action='aprovaSav.php' method='post' name='editar' onSubmit=\"this.elements['aprov'].disabled=true;\"><input type='hidden' name='tp' value='aprov'/><input type='hidden' name='id' value='".$objRegistros->id."'/><input type='hidden' name='ci' value='".$idCiEdit."'/><input type='hidden' name='descci' value='".utf8_encode($objRegistros->evento)."'/>
		<div id='formsubmitbutton'>
		<input type=image src='css/iconeAprov.png' name='aprov' id='aprov' alt='Aprovar' title='Aprovar' onClick=\"ButtonClicked()\"/>
</div>
<div id='buttonreplacement' style='margin-left:30px; display:none;'>
<img src='../imagens/loading.gif' alt='loading...'>
</div></form>";
		$editarRec="<form action='aprovaSav.php' method='post' name='editar'><input type='hidden' name='tp' value='recusa'/><input type='hidden' name='id' value='".$objRegistros->id."'/><input type='hidden' name='ci' value='".$idCiEdit."'/><input type='hidden' name='descci' value='".utf8_encode($objRegistros->evento)."'/><input type=image src='css/icone_excluir.png' alt='Recusar' title='Recusar'/></form>";
		}
if($editar<>'ND'){
echo "<tr>
<td><font size='-1'>".$numeroCi."</font></td>
<td><font size='-1'>".$nomeFuncionario."</font></td>
<td><font size='-1'>".utf8_encode($objRegistros->evento)."-".$objRegistros->abrangencia."<br><font size='-1'>Ida: ".$objRegistros->dtida." <br> Volta: ".$objRegistros->dtvolta."</font></font></td>
<td align='center'><table border='0' width='100%'><tr><td><a href='geraPdfSav.php?gest=".$objRegistros->id."' target='_blank'><img src='css/iconeVisualiza.png' title='Visualizar' alt='Visualizar'/></a></td><td>".$editar."</td><td>".$editarRec."</td></tr></table></td>
</tr>";
}
 }
?>       
     </tbody>
  </table>
<script type="text/javascript">
/*
   Replacing Submit Button with 'Loading' Image
   Version 2.0
   December 18, 2012

   Will Bontrager Software, LLC
   http://www.willmaster.com/
   Copyright 2012 Will Bontrager Software, LLC

   This software is provided "AS IS," without 
   any warranty of any kind, without even any 
   implied warranty such as merchantability 
   or fitness for a particular purpose.
   Will Bontrager Software, LLC grants 
   you a royalty free license to use or 
   modify this software provided this 
   notice appears on all copies. 
*/
function ButtonClicked()
{
   document.getElementById("formsubmitbutton").style.display = "none"; // to undisplay
   document.getElementById("buttonreplacement").style.display = ""; // to display
   return true;
}
var FirstLoading = true;
function RestoreSubmitButton()
{
   if( FirstLoading )
   {
      FirstLoading = false;
      return;
   }
   document.getElementById("formsubmitbutton").style.display = ""; // to display
   document.getElementById("buttonreplacement").style.display = "none"; // to undisplay
}
// To disable restoring submit button, disable or delete next line.
document.onfocus = RestoreSubmitButton;
</script>
</div>
</div>
</div>
</body>
</html>
<?php 
	}
?>