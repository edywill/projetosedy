<?php 
session_start();
$_SESSION['tipoSession']='';
require "../../conectsqlserverci.php";
require "../../conect.php";
$tipo='criar';
$_SESSION['tipoAcaoSession']='criar';
$_SESSION['idregistroSession']='';
$_SESSION['anoSession']='';
$textTitulo='';
$processo='';
$evento='';
$cdgeren='';
if(!empty($_SESSION['gerenSession'])){
$cdgeren=$_SESSION['gerenSession'];
}
if(!empty($_POST['id'])){
	$tipo='atualiza';
	$_SESSION['tipoAcaoSession']='atualiza';
	$textTitulo="Nº: <font color='blue'>".$_POST['id']."</font>";
	$arrayRegistro=explode("/",trim($_POST['id']));
	$idRegistro=$arrayRegistro[0];
	$_SESSION['idregistroSession']=$idRegistro;
	$ano=$arrayRegistro[1];
	$_SESSION['anoSession']=$ano;
	$sqlDadosRegistro=mysql_fetch_array(mysql_query("SELECT * FROM registros WHERE autorizacao='".$idRegistro."' AND ano='".$ano."' LIMIT 1"));
	$descProcesso=odbc_fetch_array(odbc_exec($conCab,"select projeto, assunto
from GMPROCDOC (nolock) 
where projeto='".trim($sqlDadosRegistro['projeto'])."'"));
	$processo=$sqlDadosRegistro['projeto'].'-'.utf8_encode(trim($descProcesso['assunto']));
	$evento=utf8_encode($sqlDadosRegistro['evento']);
	$cdgeren=$sqlDadosRegistro['gerencial'];
	}
$sqlNomeGerencial=odbc_fetch_array(odbc_exec($conCab,"select cg.Pcc_nome_conta
from CCPCC cg (nolock)
where substring(cg.livre_alfa_18,1,1) <> 'N'
and cg.pcc_tipo = 'A'
and cg.pcc_classific_c between dbo.CGFC_BUSCA_CONFIGURACAO(35,null) and dbo.CGFC_BUSCA_CONFIGURACAO(36,null)
AND cg.Pcc_classific_c='".$cdgeren."'"));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../../ajax/funcs.js"></script>
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='../../jquery.autocomplete.js'></script>
  <link rel="stylesheet" type="text/css" href="../../jquery.autocomplete.css" />
<script type="text/javascript">
  $().ready(function() {
	  $("#txprojeto").autocomplete("../suggest_projeto.php", {
		  width: 670,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script>
  $(function() {
	  $( "#datainicial" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#datafinal" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
<script type='text/javascript' src='../../jquery_price.js'></script>
<style>
    .sel { width: 70px; }
    
</style>

</head>
    
<body>
<div id='box3' style="height:auto">
<div id='content' style="width:100%">
<h3>AUTORIZAÇÃO DE PASSAGEM EM LOTE<?php echo $textTitulo; ?></h3>
<form action='salvaPassagemLote.php' method='post' target='_blank'>
<div id="tabela">
<table width="100%" border="1">
			<tr>
			  <th colspan='2' align="center"><strong>Dados Gerais da Autorização</strong></th></tr>
            <tr><th>
			Processo:</th><td><input type='text' name='txprojeto' class='input' size='65' id='txprojeto' value='<?php echo $processo ?>'/><br />Digite parte do nome ou o n&uacute;mero para pesquisar</td>
            </tr>
            <tr>
            <th>Complemento:</th><td><input class="input" type="text" size="65" maxlength="145" name="evento" value="<?php echo $evento; ?>"/></td>
            </tr>
        </table>
            <br /><br />
    <table width="100%"><tr><th colspan="2" align="center"><h2>LISTAGEM DE PASSAGENS</h2></th></tr>

    <tr>
        <th align="left" width="20%"><strong><u>GERENCIAL </u></strong>:</th><td align="left"><?php echo $cdgeren."-".utf8_encode($sqlNomeGerencial['Pcc_nome_conta']);?></td>
    </tr>
    </table>
    <table width="100%">
    <tr>
        <th width="20%">Nome</th><th width="30%">Trecho</th><th width="10%">Localizador</th><th width="7%">Valor da Passagem</th><th width="5%">Taxa de Embarque</th><th width="5%">Taxa de Serviço</th><th width="7%">CIA Aérea</th><th width="7%">Desconto</th><th width="7%">Valor Final</th>
    </tr>
    
<?php
	$cont=0;
	$vlTipo=0;
	$id[]='';
	if($_SESSION['tipoAcaoSession']=='criar'){
	foreach($_POST['marcar'] AS $key){
		$id[$cont]=$key;
		$cont++;
	}
	$contadorReg=$cont;
	$cont=0;
	for($f=0;$f<$contadorReg;$f++){
		$vlTipo++;
	//Busca os dados por usuário
	//Verifica se existe autorização gerada para esse usuário e com a mesma CI
	//Caso sim, retorna o Erro (em grupo)
	//Caso não, apresenta a tela de autorização
	$queryDadosUser=odbc_exec($conCab,"Select
  (Case When TEITEMSOLPASSAGEM.cadeirante = 1 Then '* ' + GEEMPRES.Nome_completo
    Else GEEMPRES.Nome_completo End) Nome_completo,
  TEITEMSOLPASSAGEM.cd_empresa,
  TEITEMSOLPASSAGEM.dt_partida,
  TEITEMSOLPASSAGEM.sequencia,
  TEITEMSOLPASSAGEM.hr_partida,
  TEITEMSOLPASSAGEM.dt_chegada,
  TEITEMSOLPASSAGEM.hr_chegada,
  Case When TEITEMSOLPASSAGEM.cadeirante = 1 Then 'X' End cadeirante,
  TEITEMSOLPASSAGEM.observacao,
  TEITEMSOLPASSAGEM.trecho,
  ESMATERI.Cd_reduzido,
  COISOLIC.Cd_solicitacao
From
  COISOLIC With(NoLock) Inner Join
  ESMATERI (nolock) On COISOLIC.Cd_material = ESMATERI.Cd_material
  inner Join
  TEITEMSOLPASSAGEM With(NoLock) On COISOLIC.Cd_solicitacao =
    TEITEMSOLPASSAGEM.cd_solicitacao Inner Join
  GEEMPRES With(NoLock) On TEITEMSOLPASSAGEM.cd_empresa = GEEMPRES.Cd_empresa
  WHERE 
   TEITEMSOLPASSAGEM.id_registro='".$id[$f]."'
   AND (ESMATERI.Cd_reduzido='226' OR ESMATERI.Cd_reduzido='227' OR ESMATERI.Cd_reduzido='228' OR ESMATERI.Cd_reduzido='229')");
	$sqlDadosUser=odbc_fetch_array($queryDadosUser);
  $tipo='';
 if($sqlDadosUser['Cd_reduzido']==226 || $sqlDadosUser['Cd_reduzido']==227){
	 $tipo='I';
	 
	 }elseif($sqlDadosUser['Cd_reduzido']==228 || $sqlDadosUser['Cd_reduzido']==229){
		 $tipo='N';
		 }
if(!empty($tipo)){  
$cont++;
$_SESSION['tipoSession']=$tipo;
  if(empty($sqlDadosUser['dt_chegada']) || is_null($sqlDadosUser['dt_chegada']) ){
  echo "<script type='text/javascript'>
  	  $(document).ready(function(){
      $('#vlOrg".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#txServico".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#txEmbarque".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#vlTot".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  </script>
	  <script type=\"text/javascript\">
function float2moeda(num) {

   x = 0;

   if(num<0) {
      num = Math.abs(num);
      x = 1;
   }
   if(isNaN(num)) num = \"0\";
      cents = Math.floor((num*100+0.5)%100);

   num = Math.floor((num*100+0.5)/100).toString();

   if(cents < 10) cents = \"0\" + cents;
      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
         num = num.substring(0,num.length-(4*i+3))+'.'
               +num.substring(num.length-(4*i+3));
   ret = num + ',' + cents;
   if (x == 1) ret = ' - ' + ret;
   return ret;

}

function moeda2float(moeda){

   moeda = moeda.replace(\".\",\"\");

   moeda = moeda.replace(\",\",\".\");

   return parseFloat(moeda);

}
var req;

// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarDescontos".$cont."(valor) {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject(\"Microsoft.XMLHTTP\");
}
valor2=document.getElementById('cia".$cont."').value;
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = \"consultaDesconto.php?valor=\"+valor2;

// Chamada do método open para processar a requisição
req.open(\"Get\", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;
// Abaixo colocamos a(s) resposta(s) na div resultado que está lá no teste.php
a=(moeda2float(document.getElementById('vlOrg".$cont."').value)*resposta)/100;
document.getElementById('desconto".$cont."').value = float2moeda(a);
b=moeda2float(document.getElementById('vlOrg".$cont."').value)-a;
c=moeda2float(document.getElementById('txServico".$cont."').value)+moeda2float(document.getElementById('txEmbarque".$cont."').value);
d=b+c;
document.getElementById('vlTot".$cont."').value=float2moeda(d);
}
}
req.send(null);
}
</script>";

if($_SESSION['tipoAcaoSession']=='criar'){
  echo "<tr><td><input type='hidden' name='ci".$cont."' id='ci".$cont."' class='input' size='7' value='".trim($sqlDadosUser['Cd_solicitacao'])."'/><input type='hidden' name='idBen".$cont."' id='idBen".$cont."' class='input' size='7' value='".trim($sqlDadosUser['cd_empresa'])."'/>".utf8_encode($sqlDadosUser['Nome_completo'])."</td><td>".utf8_encode($sqlDadosUser['trecho'])."</td>
 <td><input type='text' name='txLocalizador".$cont."' id='txLocalizador".$cont."' class='input' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\" size='7' value=''/></td><td>R$<input type='text' name='vlOrg".$cont."' id='vlOrg".$cont."' class='input' size='5' value='' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td><td>R$<input type='text' name='txEmbarque".$cont."' id='txEmbarque".$cont."' class='input' size='3' value='' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\" /></td><td>R$<input type='text' name='txServico".$cont."' id='txServico".$cont."' class='input' size='3' value=''  onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td><td><br><div id='select'><select class='sel' name='cia".$cont."' id='cia".$cont."' onchange=\"buscarDescontos".$cont."(this.value)\" />";
   $selectCompanhia=mysql_query("SELECT id,nome FROM cia") or die(mysql_error());
	  echo "<option value='' selected='selected'>Selecione</option>";
	  while($objCia=mysql_fetch_object($selectCompanhia)){
		  
		echo "<option value='".$objCia->id."'>".$objCia->nome."</option>";
			}
		  $descUni=0;
  echo "</select></div></td><td>R$<br><input type='text' name='desconto".$cont."' id='desconto".$cont."' class='input'  size='1' value='".$descUni."' readonly='readonly'/></td><td>R$<input type='text' name='vlTot".$cont."' id='vlTot".$cont."' class='input' size='5' value='' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td></tr>";
}}else{
		$tp='';
		echo "<tr><td rowspan='2'>".utf8_encode($sqlDadosUser['Nome_completo'])."</td><td rowspan='2'>".utf8_encode($sqlDadosUser['trecho'])."</td>";
		for($i=0;$i<2;$i++){
		    echo "
	  <script type='text/javascript'>
  	  $(document).ready(function(){
      $('#vlOrg".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#txServico".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#txEmbarque".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#vlTot".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  </script>
	  <script type=\"text/javascript\">
function float2moeda(num) {

   x = 0;

   if(num<0) {
      num = Math.abs(num);
      x = 1;
   }
   if(isNaN(num)) num = \"0\";
      cents = Math.floor((num*100+0.5)%100);

   num = Math.floor((num*100+0.5)/100).toString();

   if(cents < 10) cents = \"0\" + cents;
      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
         num = num.substring(0,num.length-(4*i+3))+'.'
               +num.substring(num.length-(4*i+3));
   ret = num + ',' + cents;
   if (x == 1) ret = ' - ' + ret;
   return ret;

}

function moeda2float(moeda){

   moeda = moeda.replace(\".\",\"\");

   moeda = moeda.replace(\",\",\".\");

   return parseFloat(moeda);

}
var req;

// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarDescontos".$cont."(valor) {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject(\"Microsoft.XMLHTTP\");
}
valor2=document.getElementById('cia".$cont."').value;
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = \"consultaDesconto.php?valor=\"+valor2;

// Chamada do método open para processar a requisição
req.open(\"Get\", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

// Abaixo colocamos a(s) resposta(s) na div resultado que está lá no teste.php
document.getElementById('desconto".$cont."').value = resposta;
a=(moeda2float(document.getElementById('vlOrg".$cont."').value)*resposta)/100;
document.getElementById('desconto".$cont."').value = float2moeda(a);
b=moeda2float(document.getElementById('vlOrg".$cont."').value)-a;
c=moeda2float(document.getElementById('txServico".$cont."').value)+moeda2float(document.getElementById('txEmbarque".$cont."').value);
d=b+c;
document.getElementById('vlTot".$cont."').value=float2moeda(d);
}
}
req.send(null);
}
</script>
";	 
		 if($i==0){
			 $tp="IDA";
			 }else{
				 $tp="VOLTA";
				 }
				 $trf="";
		  if($i==0){
			 $trf="</tr>";
			 }
			 if($_SESSION['tipoAcaoSession']=='criar'){
			echo "<td>".$tp."<br><input type='hidden' name='ci".$cont."' id='ci".$cont."' class='input' size='7' value='".trim($sqlDadosUser['Cd_solicitacao'])."'/><input type='hidden' name='idBen".$cont."' id='idBen".$cont."' class='input' size='7' value='".trim($sqlDadosUser['cd_empresa'])."'/><input type='text' name='txLocalizador".$cont."' id='txLocalizador".$cont."' class='input' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\" size='7' value=''/></td><td>R$<input type='text' name='vlOrg".$cont."' id='vlOrg".$cont."' class='input' size='5' value='' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td><td>R$<input type='text' name='txEmbarque".$cont."' id='txEmbarque".$cont."' class='input' size='3' value='' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\" /></td><td>R$<input type='text' name='txServico".$cont."' id='txServico".$cont."' class='input' size='3' value=''  onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td><td><br><div id='select'><select class='sel' name='cia".$cont."' id='cia".$cont."' onchange=\"buscarDescontos".$cont."(this.value)\" />";
   $selectCompanhia=mysql_query("SELECT id,nome FROM cia") or die(mysql_error());
	  echo "<option value='' selected='selected'>Selecione</option>";
	  while($objCia=mysql_fetch_object($selectCompanhia)){
		  
		echo "<option value='".$objCia->id."'>".$objCia->nome."</option>";
			}
		  $descUni=0;
  echo "</select></div></td><td>R$<br><input type='text' name='desconto".$cont."' id='desconto".$cont."' class='input'  size='1' value='".$descUni."' readonly='readonly'/></td><td>R$<input type='text' name='vlTot".$cont."' id='vlTot".$cont."' class='input' size='5' value='' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td>".$trf."";
			 }
  			if($i==0){
			 $cont++;
			  }				
			}
		   }
	     }
		 if($vlTipo==0){
		 ?>
       <script type="text/javascript">
       alert("N\u00e3o foi selecionado nenhum passageiro.");
       window.location="autLot.php";
       </script>
       <?php
		 }
	  }
	  //Caso seja uma edição
	  }else{
		  
		$arrayAut=explode("/",$_POST['id']);
		$sqlRegistros=mysql_query("SELECT solicitacao,idben FROM registros WHERE autorizacao='".$arrayAut[0]."' AND ano='".$arrayAut[1]."'");
		$empresa='';
		$cont=0;
while($objRegistroPas=mysql_fetch_object($sqlRegistros)){
	$queryDadosUser=odbc_exec($conCab,"Select
  (Case When TEITEMSOLPASSAGEM.cadeirante = 1 Then '* ' + GEEMPRES.Nome_completo
    Else GEEMPRES.Nome_completo End) Nome_completo,
  TEITEMSOLPASSAGEM.cd_empresa,
  TEITEMSOLPASSAGEM.dt_partida,
  TEITEMSOLPASSAGEM.sequencia,
  TEITEMSOLPASSAGEM.hr_partida,
  TEITEMSOLPASSAGEM.dt_chegada,
  TEITEMSOLPASSAGEM.hr_chegada,
  Case When TEITEMSOLPASSAGEM.cadeirante = 1 Then 'X' End cadeirante,
  TEITEMSOLPASSAGEM.observacao,
  TEITEMSOLPASSAGEM.trecho,
  ESMATERI.Cd_reduzido,
  COISOLIC.Cd_solicitacao
From
  COISOLIC With(NoLock) Inner Join
  ESMATERI (nolock) On COISOLIC.Cd_material = ESMATERI.Cd_material
  inner Join
  TEITEMSOLPASSAGEM With(NoLock) On COISOLIC.Cd_solicitacao =
    TEITEMSOLPASSAGEM.cd_solicitacao Inner Join
  GEEMPRES With(NoLock) On TEITEMSOLPASSAGEM.cd_empresa = GEEMPRES.Cd_empresa
  WHERE 
   TEITEMSOLPASSAGEM.cd_solicitacao='".$objRegistroPas->solicitacao."' AND TEITEMSOLPASSAGEM.cd_empresa='".$objRegistroPas->idben."'
   AND (ESMATERI.Cd_reduzido='226' OR ESMATERI.Cd_reduzido='227' OR ESMATERI.Cd_reduzido='228' OR ESMATERI.Cd_reduzido='229')");
	$sqlDadosUser=odbc_fetch_array($queryDadosUser);
	      $tp='';
		  $i=0;
		  if(empty($empresa)){
		  $empresa=$sqlDadosUser['cd_empresa'];
		echo "<tr><td rowspan='2'>".utf8_encode($sqlDadosUser['Nome_completo'])."</td><td rowspan='2'>".utf8_encode($sqlDadosUser['trecho'])."</td>";
		  }else{
			  $empresa='';
			  }
		for($i=0;$i<2;$i++){
		    echo "
	  <script type='text/javascript'>
  	  $(document).ready(function(){
      $('#vlOrg".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#txServico".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#txEmbarque".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#vlTot".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  </script>
	  <script type=\"text/javascript\">
function float2moeda(num) {

   x = 0;

   if(num<0) {
      num = Math.abs(num);
      x = 1;
   }
   if(isNaN(num)) num = \"0\";
      cents = Math.floor((num*100+0.5)%100);

   num = Math.floor((num*100+0.5)/100).toString();

   if(cents < 10) cents = \"0\" + cents;
      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
         num = num.substring(0,num.length-(4*i+3))+'.'
               +num.substring(num.length-(4*i+3));
   ret = num + ',' + cents;
   if (x == 1) ret = ' - ' + ret;
   return ret;

}

function moeda2float(moeda){

   moeda = moeda.replace(\".\",\"\");

   moeda = moeda.replace(\",\",\".\");

   return parseFloat(moeda);

}
var req;

// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarDescontos".$cont."(valor) {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject(\"Microsoft.XMLHTTP\");
}
valor2=document.getElementById('cia".$cont."').value;
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = \"consultaDesconto.php?valor=\"+valor2;

// Chamada do método open para processar a requisição
req.open(\"Get\", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

// Abaixo colocamos a(s) resposta(s) na div resultado que está lá no teste.php
document.getElementById('desconto".$cont."').value = resposta;
a=(moeda2float(document.getElementById('vlOrg".$cont."').value)*resposta)/100;
document.getElementById('desconto".$cont."').value = float2moeda(a);
b=moeda2float(document.getElementById('vlOrg".$cont."').value)-a;
c=moeda2float(document.getElementById('txServico".$cont."').value)+moeda2float(document.getElementById('txEmbarque".$cont."').value);
d=b+c;
document.getElementById('vlTot".$cont."').value=float2moeda(d);
}
}
req.send(null);
}
</script>
";	 
		 if($i==0){
			 $tp="IDA";
			 }else{
				 $tp="VOLTA";
				 }
				 $trf="";
		  if($i==0){
			 $trf="</tr>";
			 }
			echo "<td>".$tp."<br><input type='hidden' name='ci".$cont."' id='ci".$cont."' class='input' size='7' value='".trim($sqlDadosUser['Cd_solicitacao'])."'/><input type='hidden' name='idBen".$cont."' id='idBen".$cont."' class='input' size='7' value='".trim($sqlDadosUser['cd_empresa'])."'/><input type='text' name='txLocalizador".$cont."' id='txLocalizador".$cont."' class='input' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\" size='7' value=''/></td><td>R$<input type='text' name='vlOrg".$cont."' id='vlOrg".$cont."' class='input' size='5' value='' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td><td>R$<input type='text' name='txEmbarque".$cont."' id='txEmbarque".$cont."' class='input' size='3' value='' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\" /></td><td>R$<input type='text' name='txServico".$cont."' id='txServico".$cont."' class='input' size='3' value=''  onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td><td><br><div id='select'><select class='sel' name='cia".$cont."' id='cia".$cont."' onchange=\"buscarDescontos".$cont."(this.value)\" />";
   $selectCompanhia=mysql_query("SELECT id,nome FROM cia") or die(mysql_error());
	  echo "<option value='' selected='selected'>Selecione</option>";
	  while($objCia=mysql_fetch_object($selectCompanhia)){
		  
		echo "<option value='".$objCia->id."'>".$objCia->nome."</option>";
			}
		  $descUni=0;
  echo "</select></div></td><td>R$<br><input type='text' name='desconto".$cont."' id='desconto".$cont."' class='input'  size='1' value='".$descUni."' readonly='readonly'/></td><td>R$<input type='text' name='vlTot".$cont."' id='vlTot".$cont."' class='input' size='5' value='' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td>".$trf."";
			 }
  			if($i==0){
			 $cont++;
			  }				
			}
		}
?>

    </table>
</div>
<table border="0" width="100%">
<tr><td align="left">
<a href='autLot.php'><input type='button' class='button' value='<<VOLTAR'></a>
</td><td align="right">
<input type='hidden' name='contador' id='contador' class='input' size='8' value='<?php echo $cont; ?>'/><input type='submit' align= 'center' class='buttonVerde' value='SALVAR'>
</td></tr></table>
</form>
</div>
</div>
</body>
</html>