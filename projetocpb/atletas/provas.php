<?php 
session_start();
require "conectAtleta.php";
$userCriac=$_SESSION['userAtleta'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../ajax/funcs.js"></script>
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='../jquery.autocomplete.js'></script>
  <link rel="stylesheet" type="text/css" href="../jquery.autocomplete.css" />
<script type="text/javascript">
  $().ready(function() {
	  $("#proc").autocomplete("suggest_projeto.php", {
		  width: 510,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script type="text/javascript">
  $().ready(function() {
	  $("#empresa").autocomplete("../suggest_user.php", {
		  width: 510,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script type="text/javascript">
  $().ready(function() {
	  $("#material").autocomplete("suggest_material_ordem.php", {
		  width: 352,
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
<style>
    .sel { width: 70px; }
    
</style>
<script language="javascript">
<!--
function aumenta(obj){
    obj.height=obj.height*1.2;
	obj.width=obj.width*1.2;
}
 
function diminui(obj){
	obj.height=obj.height/1.2;
	obj.width=obj.width/1.2;
}
//-->
</script>
<script type='text/javascript' src='../jquery_price.js'></script>
<script type='text/javascript'>
  	  $(document).ready(function(){
      $('#bolsa').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
	  $('#mmarcpos').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: '.'
      });
	$('#pmelhormarcapos').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: '.'
      });
	$('#dtatleta').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: ''
      });
	$('#dtheroi').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: ''
      });
    });
	 </script>
</head>
       
<body>
<div id='box3' style="height:auto">
    <br/>
    
<h2>DITEC - Atletas</h2>
<h3>Cadastro de Provas</h3> 
<br />
<?php 
$sqlProv=odbc_exec($conCab,"SELECT prova.nome,modalidade.descricao,prova.id FROM prova (nolock) LEFT JOIN modalidade (nolock) ON prova.modalidade_id=modalidade.id");
$numProv=odbc_num_rows($sqlProv);
if($numProv>0){
?>
<div id="tabela">
<table width="50%" border="0">
<tr><th colspan="3"><center>PROVAS</center></th></tr>
<tr><th width="50%">DESCRIÇÃO</th><th width="40%">MODALIDADE</th></tr>
<?php 
while($objProv=odbc_fetch_object($sqlProv)){
	echo "<tr><td>".utf8_encode($objProv->nome)."</td><td>".utf8_encode($objProv->descricao)."</td></tr>";
	}
?>
</table>
</div>
<br/><br/>
<?php 
}
?>

<form action="insereProva.php" method="post" name="modal">
<table width="50%" border="0">
<tr><td colspan="2"><b><font size="+1">INCLUIR PROVA</font></b></td></tr>
<tr><td width="30%"><b>Modalidade</b></td><td>
<div id='select'>
<select name="modalidade">
<option value="0" selected="selected">Selecione</option>
<?php 
$sqlModal=odbc_exec($conCab,"SELECT id,descricao FROM modalidade (nolock) ORDER BY descricao");
while($objMod=odbc_fetch_object($sqlModal)){
	echo "<option value=".$objMod->id.">".utf8_encode($objMod->descricao)."</option>";
	}
?>
</select></div>
</td></tr>
<tr><td width="30%"><b>Nome da Prova</b></td><td>
<input type="text" size="36" name="descricao" class="input"/>
</td></tr>
<tr><td width="30%"><a href="index.php"><input class="buttonVerde"  type="button" name="voltar" value="<<Voltar" /></a></td>
<td align="right"><input type="submit" class="buttonVerde" name="modal" value="Inserir" />
</td></tr>
</table>
</form>

</div>
</body>
</html>