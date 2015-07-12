<?php 
session_start();
if($_SESSION['usuario']=='' || empty($_SESSION['usuario'])){
	echo "<script>alert('Efetue o login!');top.location.href='../loginad.php';</script>"; 
	}
require "../conectsqlserver.php";
require "../conect.php";
//Inicializando Variáveis

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
<script type='text/javascript' src='../jquery_price.js'></script>
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
</head>
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
<form action="#" name="sav1" method="post" onSubmit="setarCampos(this); enviarForm('insereSav.php', campos, 'divResultado'); return false; this.elements['ok'].disabled=true;">
  <div id="hid1" style="display:none">
  <table border="0" width="100%" class="tablesimples">
  <tr><td colspan="2"><h2 id="h2">BUSCAR CI:</h2></td></tr>
  <tr height="34"><td width="21%"><strong>Nº CI:</strong></td><td><input type="text" class="input" name="ci" id="ci" size="20" maxlength="10" value=''/></td></tr>
  <tr height="34"><td width="21%"><strong>CONTROLE:</strong></td><td><input type="text" class="input" name="ci" id="ci" size="20" maxlength="10" value=''/></td></tr>
  <tr height="34"><td width="21%"><strong>DATA DE ELABORAÇÃO:</strong></td><td><input type="text" class="input" name="ci" id="ci" size="20" maxlength="10" value=''/></td></tr>
  <tr><td colspan="2" align="center"><input type="submit" id='ok' name="ok" class="button" value="BUSCAR" onClick="ButtonClicked()"/></td></tr>
  </table>
  <hr />
  </div>
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
</select>
</td></tr>
<tr height="34"><td colspan="2">
<strong>JUSTIFICATIVA DA CI:</strong> 
</td></tr><tr><td colspan="2">
<textarea name="justificativa" id="justificativa" cols="74" rows="5" onKeyPress="javascript:limita('objetivo',450);"></textarea>
</td></tr></table>
<hr />
<div id="divResultado" align="center" style="backface-visibility:visible; background-color:#FBE5E6; height:auto"></div>
<div id="itens"></div>
<table border="0" width="100%">
<tr height="34"><td colspan="4"><h2 id="h2">ITENS</h2></td></tr>
<tr height="34">
  <td width="21%"><strong>MATERIAL:</strong></td><td colspan="3"><input type="text" class="input" name="material" id="material" size="50" maxlength="50" value='' onblur="this.value=this.value.toUpperCase()" style="background: url(css/icone_lupa.png) no-repeat right;" autocomplete='off'/></td></tr>
<td><strong>QUANTIDADE:</strong></td><td><input type="text" class="input" name="material" id="material" size="20" maxlength="10" value=''/></td><td><strong>VALOR UNITÁRIO :</strong></td><td>R$<input type="text" class="input" name="vlunit" id="vlunit" size="20" maxlength="10" value=''/></td></tr>
<tr>
<td><strong>PRAZO DE ENTREGA:</strong></td><td colspan="3"><input type="text" class="input" name="prazo" id="prazo" size="20" maxlength="20" value='' onblur="this.value=this.value.toUpperCase()" style="background: url(css/icone_calendario.png) no-repeat right;"/></td></tr>
<tr><td><strong>GERENCIAL:</strong></td><td colspan="3"><input type="text" class="input" name="material" id="material" size="50" maxlength="50" value='' onblur="this.value=this.value.toUpperCase()" style="background: url(css/icone_lupa.png) no-repeat right;" autocomplete='off'/></td></tr>
<tr>
  <td colspan="4"><strong>DETALHAMENTO DO ITEM:</strong></td></tr>
<tr><td colspan="4"><textarea name="justificativa" id="justificativa" cols="74" rows="5" onKeyPress="javascript:limita('objetivo',450);"></textarea></td></tr>
<tr height="34"><td colspan="2"></td><td colspan="2" align="right"><input type="submit" id='ok' name="ok" class="button" value="INCLUIR ITEM" onClick="ButtonClicked()"/></td></tr>
</table>
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