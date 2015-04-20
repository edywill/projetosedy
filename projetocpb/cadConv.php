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
<title>Untitled Document</title>
</head>

<body>
<div id='box3'><br/>
<?php
//include "function.php";
//include "mb.php";
require('conexaoconv.php');
?>
<strong>CADASTRAR NOVO EVENTO:</strong><br /><br />
<div id="tabela">
<form action="atEventoConv.php" method="post" onsubmit="this.elements['ok'].disabled=true;">
<table border="1" width="400">
<tr><th width="18%">Modalidade</th><td width="82%"><input type="hidden" name="validador" value="1" /><select id='modal' name="modal">
<option value="0" selected="selected">Selecione</option>
<?php 
$sqlMod=mysql_query("SELECT * FROM modalidade");
while($objMod=mysql_fetch_object($sqlMod)){
	echo "<option value='".$objMod->id."'>".utf8_encode($objMod->modalidade)."</option>";
	}

?>
</select>
</td></tr>
<tr><th>Nome do Evento:</th><td><input name="nome" type="text" size="40" class="input" /></td></tr>
<tr><th>Cidade:</th><td><input name="cidade" type="text" size="40" class="input" /></td></tr>
<tr><th>Estado:</th><td><select name="uf">
<option value="0">Selecione o Estado</option>
<?php 
$sqlUf=mysql_query("SELECT * FROM estados");
while($objUf=mysql_fetch_object($sqlUf)){
	echo "<option value='".$objUf->id."'>".utf8_encode($objUf->estados)."</option>";
	}

?>
</select></td></tr>
<tr><th>Data de Início:</th><td><input name="dtinicio" id="dtinicio" type="text" size="40" class="input" /></td></tr>
<tr><th>Data de Términio:</th><td><input name="dtfim" id="dtfim" type="text" size="40" class="input" /></td></tr>
<tr><td><a href="gestConv.php"><input type="button" value="Voltar" name="voltar" /></a></td><td><input id="ok" type="submit" class="button" value="Cadastrar" name="ok" /></td></tr>
</table>
</form>
</div>
</div>
</body>
</html>