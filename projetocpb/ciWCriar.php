<?php 
session_start();
$usuario='';
if(!empty($_GET['usuario'])){
	$usuario=$_GET['usuario'];
    unset($_SESSION['nomeUsuario']);	
	unset($_SESSION['numCi']);
	unset($_SESSION['userCi']);
	unset($_SESSION['solicitacao']);
	unset($_SESSION['sequencia']);
	unset($_SESSION['descInicio']);	
	unset($_SESSION['localInicio']);
	unset($_SESSION['gestorInicio']);
	unset($_SESSION['justCapa']);
	unset($_SESSION['cdMaterialS']);
	unset($_SESSION['quantidadeItemS']);
	unset($_SESSION['precoUnitS']);
	unset($_SESSION['pzentS']);
	unset($_SESSION['justItemS']);
	unset($_SESSION['prUnitSC']);
	unset($_SESSION['geremCompS']);
	unset($_SESSION['redContCompS']);
	unset($_SESSION['totalCi']);
	unset($_SESSION['geremCompPadrao']);
	$_SESSION['nomeUsuario']=$usuario;
	$_SESSION['descInicio']='';	
	$_SESSION['localInicio']='';
	$_SESSION['gestorInicio']='';
	}else{
		$usuario=$_SESSION['nomeUsuario'];
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<link rel="stylesheet" href="jqueryDown/jquery-ui.css" />
<script src="jqueryDown/jquery-1.8.2.js"></script> 
<script src="jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="jquery.autocomplete.css" /> 
<!-- File Tools Css -->
<link rel="stylesheet" href="uploadfy/css/file-validator.css">

<script type="text/javascript">
$().ready(function() {
    $("#contaF").autocomplete("suggest_cfinan.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
});
</script>
<script type="text/javascript">
$().ready(function() {
    $("#gestor").autocomplete("suggest_gestor.php", {
        width: 323,
        matchContains: true,
        selectFirst: false
    });
});
</script>
<script type="text/javascript">
$().ready(function() {
    $("#portador").autocomplete("suggest_portador.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
});
</script>
<script>
$(function() {
    $( "#dtocorrencia" ).datepicker({dateFormat: 'dd/mm/yy'});
});
</script>

<script type="text/javascript" src="ajax/funcs.js"></script>
<script type="text/javascript">
function goBack()
  {
  window.history.back()
  }
</script>
<script language=javascript> 
function janelaSecundaria (URL){ 
   window.open(URL,"janela1","width=400,height=300,scrollbars=NO") 
} 
</script> 
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script>
function abrir(programa,janela)
{
   if(janela=="") janela = "janela";
   window.open(programa,janela,'height=350,width=640');
}
</script>
<script language="javascript">
/*----------------------------------------------------------------------------
Formatação para qualquer mascara
-----------------------------------------------------------------------------*/
function formatar(src, mask){
  var i = src.value.length;
  var saida = mask.substring(0,1);
  var texto = mask.substring(i)
if (texto.substring(0,1) != saida)
  {
    src.value += texto.substring(0,1);
  }
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
</head>
<body onKeyDown="javascript:return bloqueioTeclas();">
<div id='box3'>
<br/>
<strong>CIWEB  - Criar nova Solicitação:<br/><br/>
DADOS GERAIS GERAIS DA CI</strong>
<br/>
<?php
echo "<div id='outro' style='display: none;'>";
include "function.php";
//include "valida.php";
$usuario=$_GET['usuario'];
require('conexaomysql.php');
$resultadoGres1 =  mysql_query("SELECT * FROM usuarios WHERE nome = '".$usuario."'") or die(mysql_error());
$resultadoGres = mysql_fetch_array($resultadoGres1);
$controle=$resultadoGres['controle'];
$usuario2=$resultadoGres['usuario'];//consulta
$idUserIntranet=$resultadoGres['cigam'];
$data=date("d/m/y");
echo "</div>";
?>
<form action="ciWInserir.php" method="post" enctype="multipart/form-data" name="ciWCriar" onsubmit="this.elements['buttonEnv'].disabled=true;">
 <table border='0'> <div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
  <tr><td><input class="input" name="user" type="hidden" size="5" value="<?php echo $idUserIntranet; ?>" />
		<strong>Data:<?php echo " ".$data; ?></strong>
		
</td></tr>
<tr><td>
	<strong><br/><font color=red>*</font>Descrição:</strong> </td><td><br/><input class="input" name="desc" type="text" size="80" maxlength="59" value="<?php echo trim($_SESSION['descInicio']); ?>"/><br />
</td></tr>
<tr><td>
<strong><br/>Local:</strong></td><td><br/><input class="input" name="local" type="text" size="40" maxlength="39" value="<?php echo trim($_SESSION['localInicio']); ?>"/><br />
</td></tr>
<tr><td>
	<strong><br/><font color=red>*</font>Gestor:</strong></td><td><br/><input class="input" name="gestor" id="gestor" type="text" size="40" value="<?php echo trim($_SESSION['gestorInicio']); ?>"/><br />

</td></tr>
<tr><td>
	<strong><br/>
	Anexo(s):</strong></td><td><br/><input name="anexo[]" id='anexo[]' class='demo' type=file multiple  /><br />
	(Selecione os arquivos segurando CTRL ou Shift / Max de 10Mb por arquivo)<br />

</td></tr>
<br />
<tr><td colspan='2'>
<br/>
<input class='buttonVerde' name="cont" type="button" value="Cancelar" onclick="goBack()"/>
<input type="submit"  name="buttonEnv" class="buttonVerde" id="buttonEnv" value="Continuar &gt;&gt;" />
</td></tr></table>
</form>
</div>
</body>
</html>