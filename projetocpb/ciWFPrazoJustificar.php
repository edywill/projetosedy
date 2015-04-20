<?php
require "conectsqlserverci.php";
$solicitacao=$_POST['id_ci'];
$iduser=$_POST['iduser'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script type="text/javascript">
function goBack()
  {
  window.history.back()
  }
</script>
<script type="text/javascript">
function limitaTextarea(valor) {
	quantidade = 4999;
	total = valor.length;

	if(total <= quantidade) {
		resto = quantidade- total;
		document.getElementById('contador').innerHTML = resto;
	} else {
		document.getElementById('justificativa').value = valor.substr(0, quantidade);
	}
}
</script>
<script type="text/javascript">
function goBack()
  {
  window.history.back()
  }
</script>
</head>
<body>
<div id='box3'>
<br/>
<strong>CIWEB  - Justificativa de Prazo</strong><br/>
<form action="ciWInserirJust.php" method="post" name="ciWCriar">
<input name="solic" type="hidden" size="10" value="<?php echo $solicitacao; ?>" />
<input name="iduser" type="hidden" size="10" value="<?php echo $iduser; ?>" /> 
CI Nº <strong><?php echo $solicitacao; ?></strong><br />
<strong>Justificativa para prazo: </strong>
  <textarea name="justificativa" id="justificativa" cols="100" rows="15" onKeyUp="limitaTextarea(this.value)"></textarea><br />
  <strong>Campo (caracteres restantes:</strong> <span id="contador">5000</span>)
<br /><input name="cont" type="button" value="Cancelar" onclick="goBack()"/>
<input name="cont" type="submit" class="button" value="Justificar" />
</form>
</div>
</body>
</html>