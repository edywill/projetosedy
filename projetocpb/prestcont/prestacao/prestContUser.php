<?php
//Ajustar layout
//Fazer novos testes
//Incluir with NOLOCK nos selects e deixar (nolock) nos joins

session_start();
require "../../conectsqlserver.php";
require "../../sav/conectsqlserversav.php";
require "../../conect.php";
if(!empty($_POST['nome'])){
$funcionario=$_POST['nome'];
$_SESSION['funcPrestCont']=$funcionario;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../../sav/css/estilo.css"/>
<link rel="stylesheet" href="../../datatables/estilo/table_jui.css" />
<link rel="stylesheet" href="../../datatables/estilo/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" href="../../jquery.autocomplete.css" />
<script type="text/javascript" src="../../datatables/js/jquery.mim.js"></script>
<script type="text/javascript" src="../../datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var oTable = $('#tabela4').dataTable({
		"bPaginate": true,
		"bNext":'Proximo',
		"bJQueryUI": true,
		"bDestroy":true,
		"bProcessing": true,
		"bServerSide": false,
		"sPaginationType": "full_numbers",
		"order": [[ 0, "desc" ]]
	});
});
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
</head>
<body onKeyDown="javascript:return bloqueioTeclas();">
<div id='box3' style="height:auto">
<div id='lendo' style="padding-top:60px; padding-left:10px">
<h1 id="h1">Carregando dados...</h1>
<img src="../../datatables/ajax-loader.gif" alt="preload" border="0" />
</div>
<div id='conteudo' style='visibility:hidden'>
    <br/>
    
<h1 id="h1">Prestação de Contas - (SAV)</h1>

<form action="salvaPrestCont.php" name="nova" method="post">
<table border="0" width="100%">
<tr><td colspan="2">
<h2 id="h2">Iniciar Prestação de Contas</h2>
</td></tr><tr><td>
<strong>Viagem:</strong> 
<input type="hidden" class="input" name="tp" id="tp" value="criar"/>
<?php 
$sqlRegistros=mysql_query("SELECT savregistros.* FROM savregistros where savregistros.funcionario='".$funcionario."'");
$countReg=mysql_num_rows($sqlRegistros);
?>
<select name="sav" id="sav">
<option selected="selected" value="">Selecione</option>
<?php
while($objRegistros=mysql_fetch_object($sqlRegistros)){
	$sqlPrestCont=mysql_query("SELECT status FROM prestsav WHERE savid='".$objRegistros->id."' AND status<>'el'") or die(mysql_error());
	$numPrestCont=mysql_num_rows($sqlPrestCont);
	if($numPrestCont==0){
echo "<option value='".$objRegistros->id."'>".utf8_encode($objRegistros->evento)."-".$objRegistros->abrangencia." (Ida: ".$objRegistros->dtida." / Volta: ".$objRegistros->dtvolta.")</option>";
	}
}
?>

    </select></td><td></td></tr></table>
<br /><br />
<?php 
//Possibilitar a criação de vários arquivos simulâneos
?>
Bilhete de IDA: <input type="file" name="ida" /><br />
Bilhete de VOLTA: <input type="file" name="volta" /><br />
Descrição das atividades:<br />
<textarea name="obs" rows="10" cols="50"></textarea><br />
<input type="submit" class="button" value="INCLUIR" />
</form>
</div>
</div>
</body>
</html>
