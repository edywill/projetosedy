﻿<?php 
require('conexaoconv.php');
  mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
  session_start();
  if(!empty($_POST['idEvento'])){
	  $idEvento=$_POST['idEvento'];
	  $descEvento=$_POST['descEvento'];
	  $_SESSION['idEvento']=$idEvento;
	  $_SESSION['descEvento']=$descEvento;
	  }else{
		  $idEvento=$_SESSION['idEvento'];
		  $descEvento=$_SESSION['descEvento'];
	}
  
$sqlProj=mysql_query("SELECT projecao.*,despesa.despesa AS nomeDesp,eventos.nome FROM projecao,eventos,despesa WHERE projecao.idevento=".$idEvento." AND eventos.id=projecao.idevento AND despesa.id=projecao.despesa ORDER BY projecao.despesa") or die(mysql_error());
$countProj=mysql_num_rows($sqlProj);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="ajax/funcs.js"></script>
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="jqueryDown/jquery-1.8.2.js"></script> 
<script src="jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='jquery.autocomplete.js'></script>
<script>
$(function() {
    $( "#dtinicio" ).datepicker({dateFormat: 'dd/mm/yy'});
});
</script>
<script>
$(function() {
    $( "#dtfim" ).datepicker({dateFormat: 'dd/mm/yy'});
});
</script>
<script type="text/javascript">

function float2moeda(num) {

   x = 0;

   if(num<0) {
      num = Math.abs(num);
      x = 1;
   }
   if(isNaN(num)) num = "0";
      cents = Math.floor((num*100+0.5)%100);

   num = Math.floor((num*100+0.5)/100).toString();

   if(cents < 10) cents = "0" + cents;
      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
         num = num.substring(0,num.length-(4*i+3))+'.'
               +num.substring(num.length-(4*i+3));
   ret = num + ',' + cents;
   if (x == 1) ret = ' - ' + ret;
   return ret;

}

function moeda2float(moeda){

   moeda = moeda.replace(".","");

   moeda = moeda.replace(",",".");

   return parseFloat(moeda);

}
var req;

// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarDescontos() {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}

a=(document.getElementById('quantidade').value) * (moeda2float(document.getElementById('vlUnit').value));
document.getElementById('vlTot').value=float2moeda(a);
}
</script>
<script type="text/javascript">
 function somenteNumeros (num) {
		var er = /[^0-9,.]/;
		er.lastIndex = 0;
		var campo = num;
		if (er.test(campo.value)) {
		campo.value = "";
		}
	}
</script>
<title>Untitled Document</title>
</head>

<body>
<div id='box3'>
  <p><br/>
  <strong>ATUALIZAR PROJEÇÕES</strong> - <?php echo $descEvento; ?></p>
  <?php
  if($countProj>0){
  ?>
  <div id="tabela">
  <table cellspacing="0" cellpadding="0">
    <col width="187" />
    <col width="59" />
    <col width="260" />
    <col width="66" span="2" />
    <col width="103" />
    <col width="108" />
    <tr>
      <th rowspan="2" width="216">Tipo de Despesa</th>
      <th rowspan="2" width="108">Etapa</th>
      <th rowspan="2" width="299">Especificação</th>
      <th colspan="4">Valores Projetados</th>
    </tr>
    <tr>
      <th width="65">Qtd.</th>
      <th width="103">Unid.</th>
      <th width="164">Valor Unitario </th>
      <th width="226">Valor Original</th>
    </tr>
    <form action='atProj.php' method='POST' name='editar'>
    <?php 
	$cont=0;
	while($objProj=mysql_fetch_object($sqlProj)){
		$cont++;
		//$sqlCountDesp=mysql_query("SELECT * FROM projecao WHERE projecao.id=".$objProj->id." AND projecao.despesa=".$objProj->despesa.")";
		//$countDesp=mysql_num_rows($sqlCountDesp);
		echo "<script type=\"text/javascript\">

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
function buscarDescontos".$cont."() {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject(\"Microsoft.XMLHTTP\");
}

a=(document.getElementById('quantidade".$cont."').value) * (moeda2float(document.getElementById('vlUnit".$cont."').value));
document.getElementById('vlTot".$cont."').value=float2moeda(a);
}
</script>";
		echo "<tr><td><input type='hidden' name='id".$cont."' class='input' value='".$objProj->id."'>".$objProj->nomeDesp."</td><td>".$objProj->etapa."</td><td><input type='text' name='especific".$cont."' class='input' value='".$objProj->especific."' size='20'></td><td><input type='text' name='quantidade".$cont."' id='quantidade".$cont."' class='input' value='".$objProj->quantidade."' size='4' onkeyup=\"somenteNumeros(this)\" onblur=\"buscarDescontos".$cont."()\"></td><td><input type='text' name='um".$cont."' class='input' value='".$objProj->um."' size='4'></td><td><input type='text' name='vlUnit".$cont."' id='vlUnit".$cont."' class='input' value='".$objProj->vlunit."' size='8' onkeyup=\"somenteNumeros(this)\" onblur=\"buscarDescontos".$cont."()\" ></td><td><input type='text' name='vlTot".$cont."' id='vlTot".$cont."' class='input' value='".$objProj->vltot."' size='8' onkeyup=\"somenteNumeros(this)\"></td></tr>";
		}
	echo "<tr><td><input name='idEvento' type='hidden' value='".$idEvento."'/><input type='submit' class='button' value='Atualizar' /></td></tr>";
	?>
    </form>
  </table>
  </div>
  <p><br />  
  </p>
<?php 
  }
?>    
    <div id="tabela">
  <form action="inserirProj.php" method="post" onsubmit="this.elements['ok'].disabled=true;">
<table border="1" width="400">
<tr><th colspan="2">CADASTRAR NOVA PROJEÇÃO</th></tr>
<tr><th width="18%">Tipo de Despesa</th><td width="82%"><select id='despesa' name="despesa">
<option value="0" selected="selected">Selecione</option>
<?php 
$sqlDesp=mysql_query("SELECT * FROM despesa");
while($objDesp=mysql_fetch_object($sqlDesp)){
   echo "<option value='".$objDesp->id."'>".$objDesp->despesa."</option>";
	}
?>
</select>
</td></tr>
<tr>
  <th>Etapa:</th><td><input name="idEventoI" type="hidden" size="40" class="input" value="<?php echo $idEvento; ?>"/><input name="etapa" type="text" size="40" class="input" /></td></tr>
<tr>
  <th>Especificação:</th><td><input name="especific" type="text" size="40" class="input" /></td></tr>
<tr>
<th>Quantidade:</th><td><input name="quantidade" id="quantidade" type="text" size="40" class="input" /></td></tr>
<tr>
  <th>Unid. de Medida:</th><td><select name="um">
<option value="0">Selecione</option>
<option value="Unid.">Unid.</option>
<option value="Dias">Dias</option>
<option value="Mês">Mês</option>
<option value="Horas">Horas</option>
</select></td></tr>
<tr>
  <th>Valor Unitário(R$):</th><td><input name="vlUnit" id="vlUnit" type="text" size="40" class="input" onkeyup="somenteNumeros(this)" onblur="buscarDescontos()" value=""/></td></tr>
<tr>
  <th>Valor Original(R$):</th><td><input name="vlTot" id="vlTot" type="text" size="40" class="input" onkeyup="somenteNumeros(this)" value=""/></td></tr>
<tr><td><a href="gestConv.php"><input type="button" value="Voltar" name="voltar" /></a></td><td><input id="ok" type="submit" class="button" value="Cadastrar" name="ok" /></td></tr>
</table>
</form>
</div>
</div>
</body>
</html>