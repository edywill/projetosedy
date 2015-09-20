<?php 
session_start();
$_SESSION['usuario']='ADF';
if($_SESSION['usuario']=='' || empty($_SESSION['usuario'])){
	echo "<script>alert('Efetue o login!');top.location.href='../loginad.php';</script>"; 
	}
//require "../conectsqlserver.php";
require "../conect.php";
//Inicializando Variáveis

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="stylesheet" href="../jqueryDown/jquery-ui.css" />
<link rel="stylesheet" href="../jqueryDown/jquery-1.9.0-ui.css" />
<link rel="stylesheet" href="../jqueryDown/jquery-ui.css" /> 
<link rel="stylesheet" type="text/css" href="../jquery.autocomplete.css" />
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
<script src="../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../jqueryDown/jquery-1.9.0-ui.js"></script>
<script src="../jqueryDown/jquery-ui.js"></script>
<script src="jquerymensagem/jquery_jui_alert.js"></script>
<script language="javascript" src="scriptNova.js" type="text/javascript"></script>
<script type='text/javascript' src='../jquery_price.js'></script>
<script type='text/javascript' src='../jquery.autocomplete.js'></script>
<script type="text/javascript">
jQuery(document).ready(function () {
    //hide a div after 3 seconds
    setTimeout( "jQuery('#mensagensArquivo').hide();document.getElementById('mensagensArquivo').innerHTML='';",10000 );
});
function mostraDiv(){
	jQuery('#mensagensArquivo').show();
	setTimeout( "jQuery('#mensagensArquivo').hide();					 document.getElementById('mensagensArquivo').innerHTML='';",10000 );
	}
</script>
<script type='text/javascript' src='bpopup.js'></script>
<script type="text/javascript">
function clickModal(){
	$('#popup').bPopup({
		follow: [false, false], //x, y
        position: [25, 700] //x, y
	});
	}
</script>
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
    $( "#prazo" ).datepicker({dateFormat: 'dd/mm/yy'});
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
    $(document).ready(function(){
      $('#vlunit').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
	});
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
  <script type="text/javascript">
$(document).ready(function(){
    $('#new').change(function(){
        if(this.value==1){
            $('#hid1').fadeIn('slow');
			//$('#retorno2').fadeIn('slow');
		}else{
            $('#hid1').fadeOut('slow');
			//$('#retorno2').fadeOut('slow');
		}
    });
});
</script>
<script type="text/javascript">
function  buscarDados(){
// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "reescreveDados.php";

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

document.getElementById('registros').innerHTML=resposta;
}
}
req.send(null);
	}
function  buscarDadosItem(){
// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "reescreveItem.php";

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

document.getElementById('caditem').innerHTML=resposta;
}
}
req.send(null);
	}

</script>
</head>
<div id="popup" style="display:none; background-color:#FFF">
        <br /><div align="right"><span class="button b-close"><span>X</span></span></div>
        <br />
        <table border='0'>
		  <tr><td colspan='2'><h2 id="h2">RPA - RECIBO DE PAGAMENTO AUTÔNOMO</h2></td></tr>
	<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td><strong><font color=red>*</font>BENEFICIÁRIO:</strong> </td><td colspan='2'> <input class='input' name='rpaCod' id='rpaCod' type='text' size='80' value=''/>
  </td></tr>
  <tr><td>
	<strong>FUNÇÃO:</strong></td><td colspan='2'><input class='input' name='cargoRpa' id='cargoRpa' type='text' size='35' maxlength='39' value='' /><font size='-2'>Preencher somente se quiser alterar a fun&ccedil&atildeo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  
  <tr><td>
	<strong><font color=red>*</font>INÍCIO:</strong></td><td><input class='input' name='inicioRpa' id='inicioRpa' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" readonly value=''/>
	<strong><font color=red>*</font>FIM:</strong><input class='input' name='fimRpa' id='fimRpa' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" readonly  value=''/>
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>VALOR:</strong></td><td><input class='input' name='valorRpa' id='valorRpa' type='text' value='' size='10' maxlength='11' onkeyup=\"somenteNumeros(this)\"/><br />
  </td></tr>
  <tr><td>
  </td><td align="right"><input type="button" class="button" value="INSERIR" name="inserir" /><br />
  </td></tr>
  </table>
    </div>
<body onKeyDown="javascript:return bloqueioTeclas();">
<div id='box3' style="height:auto">
  <div id='lendo' style="padding-top:60px; padding-left:10px">
<h1 id="h1">Carregando dados...</h1>
<img src="../datatables/ajax-loader.gif" alt="preload" border="0" />
</div>
<br />
<div id='conteudo' style='visibility:hidden'>
  <h1 id="h1">CI Web</h1>
  <strong>TIPO:</strong>
<select name="new" id='new'>
  <option value="2" selected="selected">NOVA SOLICITAÇÃO</option>
  <option value="1">EDIÇÃO</option>
</select>
  <BR /><BR />
  <div align="right"><input type="button" class="button" name="impress" value="IMPRESSÃO" /></div>
  <div id="hid1" style="display:none">
  <table border="0" width="100%" class="tablesimples">
  <tr><td colspan="2"><h2 id="h2">BUSCAR CI:</h2></td></tr>
  <tr height="34"><td width="21%"><strong>Nº CI:</strong></td><td><input type="text" class="input" name="ci" id="ci" size="10" maxlength="10" value=''/></td></tr>
  <tr height="34"><td width="21%"><strong>CONTROLE:</strong></td><td><input type="text" class="input" name="ci" id="ci" size="10" maxlength="10" value=''/></td></tr>
  <tr height="34"><td width="21%"><strong>DATA DE ELABORAÇÃO:</strong></td><td><input type="text" class="input" name="ci" id="ci" size="10" maxlength="10" value=''/></td></tr>
  <tr height="34"><td width="21%"><strong>USUÁRIO DE CRIAÇÃO:</strong></td><td><input type="text" class="input" name="ci" id="ci" size="50" maxlength="10" value=''/></td></tr>
  <tr height="34"><td width="21%"><strong>CONTÉM O MATERIAL:</strong></td><td><input type="text" class="input" name="ci" id="ci" size="50" maxlength="10" value=''/></td></tr>
  <tr height="34"><td width="21%"><strong>DESCRIÇÃO:</strong></td><td><input type="text" class="input" name="ci" id="ci" size="50" maxlength="10" value=''/></td></tr>
  <tr><td colspan="2" align="center"><input type="submit" id='ok' name="ok" class="button" value="BUSCAR" onClick="buscarDados()"/></td></tr>
  </table>
  <hr />
  </div>
  <div id='registros'>
  <h2 id="h2">DADOS GERAIS</h2>
<table border="0" width="100%" class="tabelasimples">
<tr height="34"><td width="21%">
<strong>DESCRIÇÃO:</strong></td><td width="79%"><input type="text" class="input" name="desc" id="desc" size="50" maxlength="50" value='' onBlur="this.value=this.value.toUpperCase()"/></td></tr>
<tr height="34"><td width="21%">
<strong>LOCAL:</strong></td><td width="79%"><input type="text" class="input" name="local" id="local" size="50" maxlength="50" value='' onBlur="this.value=this.value.toUpperCase()"/></td></tr>
<tr height="44"><td height="48">
<strong>GESTOR RESPONSÁVEL:</strong></td><td>
<select name="gestor" id="gestor">
<option value="0" selected="selected">Selecione</option>
<option value="0" >CARLOS VIEIRA</option>
<option value="0" >EDILSON ALVES</option>
</select>
</td></tr>
<tr height="34"><td colspan="2">
<strong>JUSTIFICATIVA DA CI:</strong> 
</td></tr><tr><td colspan="2">
<textarea name="justificativa" id="justificativa" cols="74" rows="5" onKeyPress="javascript:limita('objetivo',450);"></textarea>
</td></tr></table>
<hr />
<div id="divResultado" align="center" style="backface-visibility:visible; background-color:#FBE5E6; height:auto"></div>
<BR><BR>
<div id="caditem">
<table border="0" width="100%">
<tr height="34"><td colspan="4"><h2 id="h2"> CADASTRO DE ITENS</h2></td></tr>
<tr height="34">
  <td width="21%"><strong>MATERIAL:</strong></td><td colspan="3"><input type="text" class="input" name="material" id="material" size="50" maxlength="50" value='' onblur="this.value=this.value.toUpperCase()" style="background: url(css/icone_lupa.png) no-repeat right;" autocomplete='off'/></td></tr>
<td><strong>QUANTIDADE:</strong></td><td><input type="text" class="input" name="material" id="material" size="20" maxlength="10" value=''/></td><td><strong>VALOR UNITÁRIO :</strong></td><td>R$<input type="text" class="input" name="vlunit" id="vlunit" size="20" maxlength="10" value=''/></td></tr>
<tr>
<td><strong>PRAZO DE ENTREGA:</strong></td><td colspan="3"><input type="text" class="input" name="prazo" id="prazo" size="20" maxlength="20" value='' onblur="this.value=this.value.toUpperCase()" style="background: url(css/icone_calendario.png) no-repeat right;"/></td></tr>
<tr><td><strong>GERENCIAL:</strong></td><td colspan="3"><input type="text" class="input" name="material" id="material" size="50" maxlength="50" value='' onblur="this.value=this.value.toUpperCase()" style="background: url(css/icone_lupa.png) no-repeat right;" autocomplete='off'/></td></tr>
<tr>
<td><strong>ARQUIVOS:</strong></td><td colspan="3">
<form action="upload.php" class="dropzone" enctype="multipart/form-data" method='post'>
</form>
</td></tr>
<tr>
  <td colspan="4"><strong>DETALHAMENTO DO ITEM:</strong></td></tr>
<tr><td colspan="4"><textarea name="justificativa" id="justificativa" cols="74" rows="5" onKeyPress="javascript:limita('objetivo',450);"></textarea></td></tr>
<tr height="34"><td colspan="2"></td><td colspan="2" align="right"><input type="submit" id='ok' name="ok" class="button" value="INCLUIR ITEM" onClick="ButtonClicked()"/></td></tr>
</table>
</DIV>
<br />
<table border='0' width="100%">
<tr><td><a href="../home.php"><input type="button" class="button" name="voltar" value="<<Voltar" /></a></td><td align="right">
<div id="formsubmitbutton">
<input type="submit" id='ok' name="ok" class="button" value="CONCLUIR" onClick="ButtonClicked()"/>
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
</div>
<script src="dropzone/dropzone.js"></script>
<link rel="stylesheet" href="dropzone/dropzone.css">
</body>
</html>
