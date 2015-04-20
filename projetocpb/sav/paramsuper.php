<?php
//Ajustar layout
//Fazer novos testes
//Incluir with NOLOCK nos selects e deixar (nolock) nos joins

session_start();
if($_SESSION['usuario']=='' || empty($_SESSION['usuario'])){
	echo "<script>alert('Efetue o login!');top.location.href='loginad.php';</script>"; 
	}
require "../conectsqlserver.php";
require "conectsqlserversav.php";
require "../conect.php";
$countValor=1;
$sqlValor=mysql_query("SELECT * FROM savdirex where tipo=1");
$valorVigente='';
$inicioVigente='';
$valorFuturo='';
$inicioFuturo='';
while($objValor=mysql_fetch_object($sqlValor)){
	$arrayVigencia=explode("/",$objValor->dtalt);
	
	if(strtotime(date("Y-m-d")) >= strtotime($arrayVigencia[2]."-".$arrayVigencia[1]."-".$arrayVigencia[0])){
		$valorVigente=utf8_encode($objValor->nome);
		$inicioVigente=$objValor->dtalt;
	  }else{
		  $countValor++;
		  $valorFuturo=utf8_encode($objValor->nome);
		  $inicioFuturo=$objValor->dtalt;
		  }
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
<link rel="stylesheet" href="../jqueryDown/jquery-ui.css" />
<script src="../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../jqueryDown/jquery-1.9.0-ui.css" />

<script src="../jqueryDown/jquery-ui.js"></script>
<script src="jquerymensagem/jquery_jui_alert.js"></script>
<script language="javascript" src="scriptNova.js" type="text/javascript"></script>
<link rel="stylesheet" href="../jqueryDown/jquery-ui.css" />
  <script type="text/javascript">
  function mostra(){
	  if(window.onload){
		  document.getElementById('lendo').style.display="none"
		  document.getElementById('conteudo').style.visibility="visible"
		  }
	  }
	  window.onload=mostra
  </script>
  <script>
$(function() {
    $( "#novavigencia" ).datepicker({dateFormat: 'dd/mm/yy'});
});
</script>
<script type='text/javascript' src='../jquery_price.js'></script>
<script type="text/javascript">
  $(document).ready(function(){
      $('#novovalor').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
  });
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
<h2 id="h2">SUPERINTENDENTE</h2>
<form action="atparamsuper.php" method="post" name="vr">
<table border="0" width="50%">
<tr>
<td width="60%" height="20"><strong>SUPERINTENDENTE ATUAL:</strong></td><td><?php echo $valorVigente; ?></td>
</tr>
<tr>
<td><strong>SUPERINTENDENTE DESDE:</strong></td><td><?php echo $inicioVigente; ?></td>
</tr>
<tr>
<td colspan="2" bgcolor="#D5D5D5" height="4"></td>
</tr>
<?php 
if($countValor>1){
?>
<tr>
<td width="60%" height="20"><strong>SUPERINTENDENTE PRESIDENTE:</strong></td><td><?php echo $valorFuturo; ?></td>
</tr>
<tr>
<td><strong>INÍCIO DA VIGÊNCIA:</strong></td><td><?php echo $inicioFuturo; ?></td>
</tr>
<tr>
<td colspan="2" bgcolor="#D5D5D5" height="4"></td>
</tr>
<?php
}
?>
<tr>
<td><strong>NOVO SUPERINTENDENTE:</strong></td><td><input type="hidden" name="futuro" id="futuro" value='<?php echo $countValor; ?>'/><input type="text" name="novovalor" id="novo" class="input" size="25" maxlength="40"/></td>
</tr>
<tr>
<td><strong>VIGENTE A PARTIR DE:</strong></td><td><input type="text" name="novavigencia" id="novavigencia" class="input" size="13" readonly="readonly" style="background: url(css/icone_calendario.png) no-repeat right;"/></td>
</tr>
<tr>
<td colspan="2" height="8"></td>
</tr>
<tr>
<td><a href="parametros.php"><input type="button" class="button" name="ok" value="<<Voltar" /></a></td><td align="right"><input type="submit" class="button" name="ok" value="Atualizar" /></td>
</tr>
</table>
</form>
</div>
</div>
</body>
</html>
