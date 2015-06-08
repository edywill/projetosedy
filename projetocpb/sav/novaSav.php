<?php 
session_start();
if($_SESSION['usuario']=='' || empty($_SESSION['usuario'])){
	echo "<script>alert('Efetue o login!');top.location.href='loginad.php';</script>"; 
	}
require "../conectsqlserver.php";
require "../conect.php";
require "conectsqlserversav.php";
include "funcoesGerais.php";
//Inicializando Variáveis
$titulo=$_SESSION['tituloSav'];
$numSav=0;
$tipoFunc='FUNCIONÁRIO';
$dirigente=0;
$valida=0;
$countError=0;
$errorMsg='';
$userCriac=$_SESSION['userSav'];

if(!empty($_POST['tp'])){
$tipo=$_POST['tp'];
$_SESSION['tpSav']=$tipo;
}else{
	$tipo=$_SESSION['tpSav'];
	}

if($_SESSION['tpSav']=='criar'){
$_SESSION['numSav']='';
$titulo="<h2 id='h2'>NOVA SOLICITAÇÃO</h2>";
$_SESSION['tituloSav']=$titulo;
$idFunc=explode("-",trim($_POST['nome']));
$nome=str_replace($idFunc[0]."-","",trim($_POST['nome']));
$_SESSION['cotacaoDiaSav']='';
$_SESSION['cotacaoDataSav']='';
$_SESSION['gestorSavNome']='';
$_SESSION['diariaSav']='sim';
$_SESSION['diariaSolSav']='sim';
$_SESSION['passagemSav']='sim';
$_SESSION['transladoSav']='nao';
$_SESSION['abrangenciaSav']=$_POST['tipoevento'];
$abrangencia=$_SESSION['abrangenciaSav'];
if(empty($_SESSION['origemidaSav']) && $abrangencia=='Internacional'){
	$_SESSION['origemidaSav']="BR-Brasil(BRA)";
	}
$_SESSION['nomeSav']=$nome;
$_SESSION['idFuncSav']=$idFunc[0];
$_SESSION['tituloSav']=$titulo;
if(!is_numeric($idFunc[0])){
	    $_SESSION['funcValidSav']=$_POST['nome'];
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Selecione um funcionario na lista.\\n';
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
  RHPESSOAS (nolock) Inner Join
  RHCONTRATOS (nolock) On RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHESCALAS (nolock) On RHCONTRATOS.ESCALA = RHESCALAS.ESCALA Inner Join
  RHSETORES (nolock) On RHCONTRATOS.SETOR = RHSETORES.SETOR Inner Join
  RHCARGOS (nolock) On RHCONTRATOS.CARGO = RHCARGOS.CARGO Inner Join
  RHBANCOS (nolock) On RHCONTRATOS.BANCOCREDOR = RHBANCOS.BANCO
Where
  RHCONTRATOS.DATARESCISAO Is Null AND RHPESSOAS.PESSOA='".$idFunc[0]."'";
  $dadosFuncionario=odbc_fetch_array(odbc_exec($conCab,$sqlFunc));
  //Consulta Tabela de Cargos da SAV e verifica se o cargo em questão pertence a classe I ou II
  $consultaClasse=mysql_fetch_array(mysql_query("SELECT classe FROM savcargos WHERE id='".$dadosFuncionario['CARGO']."'"));
  if($consultaClasse['classe']<3){
	  $tipoFunc="DIRIGENTE";
	  }
	  $_SESSION['idCargo']=$dadosFuncionario['CARGO'];
	  $_SESSION['tpFuncSav']=$tipoFunc;
  	  $_SESSION['cpfSav']=mask($dadosFuncionario['CPF'],"###.###.###-##");
	  $_SESSION['setorSav']=$dadosFuncionario['SETORCOMPLETO']."/".$dadosFuncionario['SETORSIGLA'];
	  $_SESSION['cargoSav']=$dadosFuncionario['NOMECARGO'];
	  $_SESSION['bancoSav']=$dadosFuncionario['NROBANCO']."-".$dadosFuncionario['NOMEBANCO'];
	  $_SESSION['agenciaSav']=$dadosFuncionario['AGENCIA'];
	  $_SESSION['contCorrenteSav']=$dadosFuncionario['CONTACORRENTE'];
	}

}elseif($_SESSION['tpSav']=='edit'){
	$numSav=$_POST['id'];
	$_SESSION['numSav']=$numSav;
	$sqlSav=mysql_fetch_array(mysql_query("SELECT * FROM savregistros WHERE id='".$_SESSION['numSav']."'"));
	$_SESSION['cidorigemidaSav']=utf8_encode($sqlSav['cidorigemida']);
	$_SESSION['cidorigemvoltaSav']=utf8_encode($sqlSav['cidorigemvolta']);
	$_SESSION['ciddestinoidaSav']=utf8_encode($sqlSav['ciddestinoida']);
	$_SESSION['ciddestinovoltaSav']=utf8_encode($sqlSav['ciddestinovolta']);
	if(!empty($_POST['ci'])){
	$numCi=$_POST['ci'];
	$_SESSION['numCiSav']=$numCi;
	$titulo="<h2 id='h2'> SAV Criada - CIº <font color='#FF0000'>".$numCi."</font> </h2>";
	}else{
		$titulo="<h4> SAV em Elaboração </h4>";
		}
	$_SESSION['gerenSav']=$sqlSav['cgeren'];
	$_SESSION['gestorSav']=$sqlSav['gestor'];
	$_SESSION['tituloSav']=$titulo;
	//Fazer consulta nos registros da SAV
	$_SESSION['abrangenciaSav']=$sqlSav['abrangencia'];
	$abrangencia=$_SESSION['abrangenciaSav'];
	$_SESSION['idFuncSav']=$sqlSav['funcionario'];
    $_SESSION['objetivoSav']=utf8_encode($sqlSav['objetivo']);
	$_SESSION['eventoSav']=utf8_encode($sqlSav['evento']);
	$_SESSION['dtidaSav']=$sqlSav['dtida'];
	$_SESSION['dtvoltaSav']=$sqlSav['dtvolta'];
	$_SESSION['horarioidaSav']=$sqlSav['horarioida'];
	$_SESSION['horariovoltaSav']=$sqlSav['horariovolta'];
	$_SESSION['ultimaViagSav']=utf8_encode($sqlSav['ultimaviagem']);
	$_SESSION['bilheteSav']=$sqlSav['devbilhete'];
	$_SESSION['passagemSav']=$sqlSav['passagem'];
	$_SESSION['diariaSolSav']=$sqlSav['diarias'];
	$_SESSION['diariaSav']=$sqlSav['hospedagem'];
	$_SESSION['transladoSav']=$sqlSav['translado'];
	$_SESSION['observacaoSav']=utf8_encode($sqlSav['observ']);
	$camposdeConsulta1='id';
	$camposdeConsulta2='municipio';
	$idConsulta='id';
	$tabelasdeConsulta='municipios';
	//Sql de consulta Cotações caso seja internacional
	$_SESSION['cotacaoDataSav']='';
	$_SESSION['cotacaoDiaSav']='';
	if($_SESSION['abrangenciaSav']=='Internacional'){
		$sqlCotacaoSavs=mysql_fetch_array(mysql_query("SELECT cotacao,data FROM savcotacao WHERE idsav='".$_SESSION['numSav']."' ORDER BY data"));
		if(!empty($sqlCotacaoSavs['cotacao'])){
		$_SESSION['cotacaoDataSav']=trim($sqlCotacaoSavs['data']);
		$_SESSION['cotacaoDiaSav']=trim($sqlCotacaoSavs['cotacao']);
		}
		$camposdeConsulta1='iso';
		$camposdeConsulta2='nome';
		$tabelasdeConsulta='paises';
		$idConsulta='iso';
		}
	//Buscar dados de origem, destino
	$scriptDeslocamentos=mysql_query("SELECT 
													(SELECT ".$camposdeConsulta1." 
													 FROM ".$tabelasdeConsulta." 
													 WHERE ".$idConsulta."=savregistros.origemida) AS idorigemida,
													(SELECT ".$camposdeConsulta1." 
													 FROM ".$tabelasdeConsulta." 
													 WHERE ".$idConsulta."=savregistros.origemvolta) AS idorigemvolta,
													(SELECT ".$camposdeConsulta2." 
													 FROM ".$tabelasdeConsulta." 
													 WHERE ".$idConsulta."=savregistros.origemida) AS nomeorigemida,
													(SELECT ".$camposdeConsulta2." 
													 FROM ".$tabelasdeConsulta." 
													 WHERE ".$idConsulta."=savregistros.origemvolta) AS nomeorigemvolta,
													(SELECT ".$camposdeConsulta1." 
													 FROM ".$tabelasdeConsulta." 
													 WHERE ".$idConsulta."=savregistros.destinoida) AS iddestinoida,
													(SELECT ".$camposdeConsulta2." 
													 FROM ".$tabelasdeConsulta." 
													 WHERE ".$idConsulta."=savregistros.destinoida) AS nomedestinoida,
													(SELECT ".$camposdeConsulta1." 
													 FROM ".$tabelasdeConsulta." 
													 WHERE ".$idConsulta."=savregistros.destinovolta) AS iddestinovolta,
													(SELECT ".$camposdeConsulta2." 
													 FROM ".$tabelasdeConsulta." 
													 WHERE ".$idConsulta."=savregistros.destinovolta) AS nomedestinovolta
													FROM savregistros WHERE id='".$numSav."'
													") or die(mysql_error());
	$sqlDeslocamentos=mysql_fetch_array($scriptDeslocamentos);
	$_SESSION['origemidaSav']=$sqlDeslocamentos['idorigemida']."-".utf8_encode($sqlDeslocamentos['nomeorigemida']);
	$_SESSION['origemvoltaSav']=$sqlDeslocamentos['idorigemvolta']."-".utf8_encode($sqlDeslocamentos['nomeorigemvolta']);
	$_SESSION['destinoidaSav']=$sqlDeslocamentos['iddestinoida']."-".utf8_encode($sqlDeslocamentos['nomedestinoida']);
	$_SESSION['destinovoltaSav']=$sqlDeslocamentos['iddestinovolta']."-".utf8_encode($sqlDeslocamentos['nomedestinovolta']);
												//Buscar dados no META
	$dadosFuncionario=odbc_fetch_array(odbc_exec($conCab,"Select
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
  RHPESSOAS (nolock) Inner Join
  RHCONTRATOS (nolock) On RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHESCALAS (nolock) On RHCONTRATOS.ESCALA = RHESCALAS.ESCALA Inner Join
  RHSETORES (nolock) On RHCONTRATOS.SETOR = RHSETORES.SETOR Inner Join
  RHCARGOS (nolock) On RHCONTRATOS.CARGO = RHCARGOS.CARGO Inner Join
  RHBANCOS (nolock) On RHCONTRATOS.BANCOCREDOR = RHBANCOS.BANCO
Where
  RHCONTRATOS.DATARESCISAO Is Null AND RHPESSOAS.PESSOA='".$_SESSION['idFuncSav']."'"));
	$consultaClasse=mysql_fetch_array(mysql_query("SELECT classe FROM savcargos WHERE id='".$dadosFuncionario['CARGO']."'"));
  if($consultaClasse['classe']<3){
	  $tipoFunc="Dirigente";
	  }
	  $_SESSION['idCargo']=$dadosFuncionario['CARGO'];
	  $_SESSION['tpFuncSav']=$tipoFunc;
  	  $_SESSION['cpfSav']=mask($dadosFuncionario['CPF'],"###.###.###-##");
	  $_SESSION['setorSav']=$dadosFuncionario['SETORCOMPLETO']."/".$dadosFuncionario['SETORSIGLA'];
	  $_SESSION['cargoSav']=$dadosFuncionario['NOMECARGO'];
	  $_SESSION['bancoSav']=$dadosFuncionario['NROBANCO']."-".$dadosFuncionario['NOMEBANCO'];
	  $_SESSION['agenciaSav']=$dadosFuncionario['AGENCIA'];
	  $_SESSION['contCorrenteSav']=$dadosFuncionario['CONTACORRENTE'];
      $_SESSION['nomeSav']=$dadosFuncionario['NOME'];

	//Pegar dados do gestor no CIGAM
	}
//Buscar usuario em GEEMXRHP

$sqlBloqUser=odbc_fetch_array(odbc_exec($conCab2,"select GEEMXRHP.Cd_empresa from GEEMXRHP (NOLOCK) WHERE GEEMXRHP.Cd_pessoa='".$_SESSION['idFuncSav']."'"));
$sqlBloqueio=mysql_num_rows(mysql_query("SELECT * FROM prestbloqueados WHERE cdempres='".$sqlBloqUser['Cd_empresa']."' AND status=1"));
if($sqlBloqueio>0){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Funcionário com pendência junto ao setor de Diárias e Passagens.\\n';	
	}
if($valida>0){
		?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="index.php";
       </script>
       <?php
	}else{
		$_SESSION['funcValidSav']='';
	$queryGestorCigam=mysql_query("select * from savgestores 
			  where 
			  codigo='".$_SESSION['gestorSav']."'") or die(mysql_error());
	$sqlGestorCigam=mysql_fetch_array($queryGestorCigam);
	$_SESSION['gestorSav']=trim($sqlGestorCigam['codigo']);
	$_SESSION['gestorSavNome']=trim(utf8_encode($sqlGestorCigam['nome']));	
	$sqlCGERENome="Select
    cg.Pcc_nome_conta,
	cg.Pcc_classific_c,
	cg.Cd_pcc_reduzid
From
  CCPCC cg With(nolock)
where 
substring(cg.livre_alfa_18,1,1) <> 'N'
and cg.pcc_tipo = 'A'
and cg.pcc_classific_c between dbo.CGFC_BUSCA_CONFIGURACAO(35,null) 
and dbo.CGFC_BUSCA_CONFIGURACAO(36,null)
and cg.Pcc_classific_c='".trim($_SESSION['gerenSav'])."'";
$rsCGERENome = odbc_exec($conCab2,$sqlCGERENome) or die(odbc_error());
$arrayCGERENome=odbc_fetch_array($rsCGERENome);
$cgeren=trim($arrayCGERENome['Pcc_classific_c']);
$cgerenNome=trim(utf8_encode($arrayCGERENome['Pcc_nome_conta']));
$_SESSION['gerenSav']=$cgeren;
$_SESSION['gerenSavNome']=$cgerenNome;
if($_SESSION['tpSav']<>'criar'){
$_SESSION['tpSav']=2;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="stylesheet" href="../jqueryDown/jquery-ui.css" />
<script src="../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../jqueryDown/jquery-1.9.0-ui.css" />

<script src="../jqueryDown/jquery-ui.js"></script>
<script src="jquerymensagem/jquery_jui_alert.js"></script>
<script language="javascript" src="scriptNova.js" type="text/javascript"></script>
<link rel="stylesheet" href="../jqueryDown/jquery-ui.css" /> 
<script type='text/javascript' src='../jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="../jquery.autocomplete.css" />  
<script>
  function goBack()
	{
	window.history.back()
	}
  </script>
<script type='text/javascript'>
function bloqueioTeclas()   // Verificação das Teclas
{
    var tecla=window.event.keyCode;
    var alt=window.event.altKey;      // Para Controle da Tecla ALT
    
    if (tecla==116)    //Evita feclar via Teclado através do ALT+F4
    {
        event.keyCode=0;
        event.returnValue=false;
    }
}
</script>
<script>
$(function() {
    $( "#dtida" ).datepicker({dateFormat: 'dd/mm/yy'});
});
</script>
<script>
$(function() {
    $( "#dtvolta" ).datepicker({dateFormat: 'dd/mm/yy'});
});
</script>
<script type="text/javascript">
   function somenteNumeros (num) {
		  var er = /[^0-9.,]/;
		  er.lastIndex = 0;
		  var campo = num;
		  if (er.test(campo.value)) {
		  campo.value = "";
		  }
	  }
  </script>
   <script type="text/javascript">
$().ready(function() {
	$("#geren").autocomplete("../suggest_cgeren.php", {
        width: 342,
        matchContains: true,
        selectFirst: true
    });
});
</script>
<script type="text/javascript">
function limita(campo,valor){
		var tamanho = document.form1[campo].value.length;
		var tex=document.form1[campo].value;
	if (tamanho>=valor) {
		document.form1[campo].value=tex.substring(0,valor);
	}
return true;
}
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
<br />
<div id='conteudo' style='visibility:hidden'>
  <h1 id="h1">SAV - Solicitação de Auxílio Viagem</h1>
  <h2 id="h2">Evento <?php echo $_SESSION['abrangenciaSav']; ?></h2>
<?php 
echo $titulo;
?>
<form action="complementaSav.php" name="sav1" method="post" onSubmit="setarCampos(this); enviarForm('insereSav.php', campos, 'divResultado'); return false; this.elements['ok'].disabled=true;">
<h2 id="h2">DADOS DO VIAJANTE</h2>
<strong>NOME:</strong> <?php echo utf8_encode($_SESSION['nomeSav']); ?><br />
<strong>TIPO: </strong> <?php echo $_SESSION['tpFuncSav']; ?><br />
<strong>CPF:</strong> <?php echo $_SESSION['cpfSav']; ?>
<br />
<strong>SETOR:</strong> <?php echo utf8_encode($_SESSION['setorSav']); ?><br />

<strong>CARGO:</strong> <?php echo utf8_encode($_SESSION['cargoSav']); ?>
<br />
<strong>BANCO:</strong> <?php echo utf8_encode($_SESSION['bancoSav']); ?>
<br />
<strong>AGÊNCIA:</strong> <?php echo $_SESSION['agenciaSav']; ?><br />
<strong>CONTA CORRENTE:</strong> <?php echo $_SESSION['contCorrenteSav']; ?>
<br />
<br />
<strong>OBJETIVO DA VIAGEM:</strong><br />
<textarea name="objetivo" id="objetivo" cols="64" rows="5" onKeyPress="javascript:limita('objetivo',450);"><?php echo $_SESSION['objetivoSav']; ?></textarea>
<br /><br />
<table border="0" width="100%" class="tabelasimples">
<tr height="34"><td width="21%">
<strong>EVENTO:</strong></td><td width="79%"><input type="text" class="input" name="evento" id="evento" size="40" maxlength="50" value='<?php echo $_SESSION['eventoSav']; ?>' onBlur="this.value=this.value.toUpperCase()"/></td></tr><tr height="34"><td>
<strong>GESTOR RESPONSÁVEL:</strong></td><td>
<select name="gestor" id="gestor">
<?php 
if(!empty($_SESSION['gestorSav'])){
echo "<option selected='selected' value='".$_SESSION['gestorSav']."'>".$_SESSION['gestorSavNome']."</option>";
}else{
	echo "<option value='0' selected='selected'>Selecione o Gestor</option>";
	}
	$sqlGestorSav=mysql_query("SELECT * FROM savgestores WHERE codigo<>'".$_SESSION['gestorSav']."' ORDER BY nome");
	while($objGestorSav=mysql_fetch_object($sqlGestorSav)){
		echo "<option value='".$objGestorSav->codigo."'>".utf8_encode($objGestorSav->nome)."</option>";
		}
	?>
</select>
</td></tr><tr height="34"><td>
<strong>CONTA GERENCIAL:</strong></td><td>
<input type="text" class="input" name="geren" id="geren" size="40" value='<?php 
if(!empty($_SESSION['gerenSav'])){
echo $_SESSION['gerenSav']."-".$_SESSION['gerenSavNome'];
}?>' style="background: url(css/icone_lupa.png) no-repeat right;"/>
<font style="font-size:10px; color:#949292">(*) Selecione na lista</font></td></tr>
</table>
<br />
<hr />
<div id="divResultado" align="center" style="backface-visibility:visible; background-color:#FBE5E6; height:auto"></div>
<table border="0" width="100%">
<tr height="34"><td colspan="4"><h2 id="h2">SERVIÇOS</h2></td></tr>
<tr><td colspan="2">

</td>
</tr>
<tr height="34"><td>
<?php 
if($_SESSION['passagemSav']=='sim'){
	echo '<input type="checkbox" name="passag"  id="passag" value="sim" checked="checked">';
	}else{
	echo '<input type="checkbox" name="passag" id="passag" value="sim">';	
		}
?>
<strong>PASSAGENS AÉREAS</strong></td>
<td>
<?php 
if($_SESSION['diariaSav']=='sim'){
		echo '<input type="checkbox" name="diar"  id="diar" value="sim" checked="checked">';
	}else{
	echo '<input type="checkbox" name="diar" id="diar" value="sim">';
		}
?>
<strong>HOSPEDAGEM</strong></td>
<td>
<?php 
if($_SESSION['transladoSav']=='sim'){
	echo '<input type="checkbox" name="trans"  id="trans" value="sim" checked="checked">';
	}else{
		echo '<input type="checkbox" name="trans" id="trans" value="sim">';
		}
?>
<strong>TRANSPORTE</strong></td>
<td>
	<?php 
	if($_SESSION['diariaSolSav']=='sim'){
		echo '<input type="checkbox" name="soldia"  id="soldia" value="sim" checked="checked">';
	}else{
	echo '<input type="checkbox" name="soldia"  id="soldia" value="sim">';
		}
	?>
    
    <strong>DIÁRIAS</strong></td>
</tr>
</table>
<br />
<hr />
<strong>OBSERVAÇÕES:</strong><br /><textarea name="observacao" id="observacao" cols="64" rows="8" onKeyPress="javascript:limita('observacao',600);"><?php echo $_SESSION['observacaoSav']; ?></textarea>
<br />
<hr />
<table border='0' width="100%">
<tr><td><a href="index.php"><input type="button" class="button" name="voltar" value="<<Voltar" /></a></td><td align="right">
<div id="formsubmitbutton">
<input type="submit" id='ok' name="ok" class="button" value="Continuar>>" onClick="ButtonClicked()"/>
</div>
<div id="buttonreplacement" style="margin-left:30px; display:none;">
<img src="../imagens/loading.gif" alt="loading...">
</div>
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
</td></tr>
</table>
</div>
</div>
</div>
</form>
</div>
</div>
<script>
//Cria a função com os campos para envio via parâmetro
function setarCampos() {
	var trans=0;
	var pass=0;
	var diar=0;
	var soldia=0;
	var radsTrans = document.getElementsByName('trans');
	var radsPass = document.getElementsByName('passag');
	var radsDiar = document.getElementsByName('diar');
	var radsSolDiar = document.getElementsByName('soldia');
  
  for(var i = 0; i < radsTrans.length; i++){
   if(radsTrans[i].checked){
    trans=radsTrans[i].value;
   }
  }
  for(var i = 0; i < radsPass.length; i++){
   if(radsPass[i].checked){
    pass=radsPass[i].value;
   }
  }
  for(var i = 0; i < radsDiar.length; i++){
   if(radsDiar[i].checked){
    diar=radsDiar[i].value;
   }
  }
  for(var i = 0; i < radsSolDiar.length; i++){
   if(radsSolDiar[i].checked){
    soldia=radsSolDiar[i].value;
   }
  }
	campos = "geren="+encodeURI(document.getElementById('geren').value)+"&gestor="+encodeURI(document.getElementById('gestor').value)+"&evento="+encodeURI(document.getElementById('evento').value)+"&objetivo="+encodeURI(document.getElementById('objetivo').value)+"&passag="+encodeURI(pass)+"&diar="+encodeURI(diar)+"&soldia="+encodeURI(soldia)+"&trans="+encodeURI(trans)+"&observacao="+encodeURI(document.getElementById('observacao').value);

}

</script>
</body>
</html>
<?php 
}
?>