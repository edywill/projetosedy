<?php 
include ('valida.php');
if(empty($_SESSION['usuario'])){
		?>
       <script type="text/javascript">
       alert("Por favor efetue login!");
       window.location='loginad.php';
       </script>
       <?php
	}else{
//session_start();
unset($_SESSION['numCi']);
unset($_SESSION['solicitacao']);
unset($_SESSION['sequencia']);
unset($_SESSION['geremCompPadrao']);
if(!empty($_SESSION['readOnly'])){
unset($_SESSION['readOnly']);
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
<script src="jqueryDown/jquery-ui.js"></script>
<link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> 
<script type='text/javascript' src='jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="jquery.autocomplete.css" /> 
<script type="text/javascript">
$().ready(function() {
    $("#gestor").autocomplete("suggest_gestor.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
});
</script>
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
$().ready(function() {
    $("#cdMaterial").autocomplete("suggest_material.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
});
</script>
<script type="text/javascript">
$().ready(function() {
    $("#controle").autocomplete("suggest_controle.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
});
</script>
<script type="text/javascript">
$().ready(function() {
    $("#controlefim").autocomplete("suggest_controlefim.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
});
</script>
<script type='text/javascript' src='jquery_price.js'></script>
<script type="text/javascript">
  $(document).ready(function(){
      $('#solic').priceFormat({
        prefix: '',
        centsSeparator: '',
        thousandsSeparator: '',
		centsLimit: 0,
		clearOnEmpty:true
      });
    });
  </script>
  <script type="text/javascript">
  $(document).ready(function(){
      $('#solicfim').priceFormat({
        prefix: '',
        centsSeparator: '',
        thousandsSeparator: '',
		centsLimit: 0,
		clearOnEmpty:true
      });
    });
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
<strong>CIWEB  - Consultar Solicitações:</strong><br/> <br/> 
Escolha uma das opções abaixo de consulta de CI:
<br/><br/>
<?php
echo "<div id='outro' style='display: none;'>";
//include "function.php";
$usuario=$_GET['usuario'];
require('conexaomysql.php');
$resultadoGres1 =  mysql_query("SELECT * FROM usuarios WHERE nome = '".$usuario."'") or die(mysql_error());
$resultadoGres = mysql_fetch_array($resultadoGres1);
$controle=$resultadoGres['controle'];
$usuario2=$resultadoGres['cigam'];//consulta
$_SESSION['userCiCigam']=$usuario2;
echo "</div>";
if($usuario2=='A02' || empty($usuario2)){
?>
       <script type="text/javascript">
       alert("Para acessar esse m\u00f3dulo, solicite a vincula\u00e7\u00e3o do seu usu\u00e1rio do CIGAM a intranet!");
       window.location='home.php';
       </script>
       <?php

}else{

?>
<form action="ciWResCons.php" method="post" name="ciWCons">
<table>
<tr>
	<td><strong>Nº CI Inicial:</strong></td><td><input class="input"  name="usuario" type="hidden" value='<?php echo $usuario2;?>'/><input class="input"  name="solic" id="solic" type="text" size="14" maxlength="10"/> <strong>Final:</strong><input class="input" id="solicfim" name="solicfim" type="text" size="14" maxlength="10" /></td>
</tr>
<tr>
	<td><strong>Descrição da CI:</strong> </td><td><input class="input"  name="desc" type="text" size="41" maxlength="80" /></td>
</tr>
<tr>
	<td><strong>Local: </strong></td><td><input class="input"  name="local" type="text" size="41" value="" /></td>
</tr>
<!--colocar auto-suggest para o controle-->
<tr>
	<td><strong>Controle Inicial: </strong></td><td><input class="input"  name="controle" id="controle" type="text" size="14" value="" maxlength="20"/><strong>Final:</strong><input class="input"  name="controlefim" id="controlefim" type="text" size="14" value="" maxlength="20"/></td>
</tr>
<!--colocar auto-suggest para o gestor-->
<tr>
	<td><strong>Gestor: </strong></td><td><input class="input" name="gestor" id="gestor" type="text" size="41"/></td>
</tr>
<tr>
	<td><strong>Data Inicial: </strong></td><td><input class="input" readonly name="dtinicio" id="dtinicio" type="text" size="14" value="" /><strong>Final:</strong><input class="input"  name="dtfim" id="dtfim" type="text" size="14" value="" readonly/></td>
</tr>
<tr>
	<td><strong>Contém o material: </strong></td><td><input class="input"  name="cdMaterial" id="cdMaterial" type="text" size="41" value="" /></td>
</tr>
<td><br/>
	<input name="pesq" class="buttonVerde" type="submit" value="Pesquisar" />
</td></tr>
</table>
</form>
<?PHP 
}
?>
</div>
</body>
</html>
<?php 
	}
?>