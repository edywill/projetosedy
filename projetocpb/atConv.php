<?php 
require('conexaoconv.php');
mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
$sqlEvento=mysql_query("SELECT eventos.*,modalidade.modalidade,modalidade.id AS idMod,estados.estados FROM eventos,modalidade,estados WHERE eventos.id=".$_POST['idEvento']." AND eventos.idmodalidade=modalidade.id AND eventos.uf=estados.id") or die(mysql_error());
$arrayEvento=mysql_fetch_array($sqlEvento);

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
<title>Untitled Document</title>
</head>

<body>
<div id='box3'><br/>
<strong>ATUALIZAR DADOS DO EVENTO</strong><br /><br />
<div id="tabela">
<form action="atEventoConv.php" method="post" onsubmit="this.elements['ok'].disabled=true;">
<table border="1" width="400">
<tr><th width="18%">Modalidade</th><td width="82%"><input type="hidden" name="validador" value="2" /><input type="hidden" name="id" value="<?php echo $arrayEvento['id']; ?>" /><select id='modal' name="modal">
<option value="<?php echo $arrayEvento['idMod']; ?>" selected="selected"><?php echo $arrayEvento['modalidade']; ?></option>
<?php 
$sqlMod=mysql_query("SELECT * FROM modalidade");
while($objMod=mysql_fetch_object($sqlMod)){
   if($objMod->id<>$arrayEvento['idMod']){
	echo "<option value='".$objMod->id."'>".$objMod->modalidade."</option>";
	}
  }
?>
</select>
</td></tr>
<tr><th>Nome do Evento:</th><td><input name="nome" type="text" size="40" class="input" value="<?php echo $arrayEvento['nome']; ?>"/></td></tr>
<tr><th>Cidade:</th><td><input name="cidade" type="text" size="40" class="input" value="<?php echo $arrayEvento['cidade']; ?>" /></td></tr>
<tr><th>Estado:</th><td><select name="uf">
<option value="<?php echo $arrayEvento['uf']; ?>" selected="selected"><?php echo $arrayEvento['estados']; ?></option>
<?php 
$sqlUf=mysql_query("SELECT * FROM estados");
while($objUf=mysql_fetch_object($sqlUf)){
	if($objUf->id<>$arrayEvento['uf']){
	echo "<option value='".$objUf->id."'>".$objUf->estados."</option>";
	}}

?></select></td></tr>
<tr><th>Data de Início:</th><td><input name="dtinicio" id="dtinicio" type="text" size="40" class="input" value="<?php echo $arrayEvento['dtinicio']; ?>"/></td></tr>
<tr><th>Data de Términio:</th><td><input name="dtfim" id="dtfim" type="text" size="40" class="input" value="<?php echo $arrayEvento['dtfim']; ?>"/></td></tr>
<tr><td><a href="gestConv.php"><input type="button" value="Voltar" name="voltar" /></a></td><td><input id="ok" type="submit" class="button" value="Cadastrar" name="ok" /></td></tr>
</table>
</form>
</div>
</div>
</body>
</html>