<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
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
<strong>CIWEB  - Criar nova Solicitação:</strong><br/>
JUSTIFICATIVA / ACOMPANHAMENTO DA CI
<?php
echo "<div id='outro' style='display: none;'>";
include "function.php";
$usuario=$_GET['usuario'];
require('conexaomysql.php');
$resultadoGres1 =  mysql_query("SELECT * FROM usuarios WHERE nome = '".$usuario."'") or die(mysql_error());
$resultadoGres = mysql_fetch_array($resultadoGres1);
$controle=$resultadoGres['controle'];
$usuario2=$resultadoGres['usuario'];//consulta
$data=date("d/m/y");
echo "</div>";
?>
<form action="ciWInserirItens.php" method="post" name="ciWCriar">
<input name="solic" type="hidden" size="10" value="<?php echo $_POST['solic']; ?>" /> 
CI Nº <strong><?php echo $_POST['solic']; ?></strong><br />
Tipo de Acompanhamento:
<input name="controle2" type="text" size="15" value="801" readonly="readonly"/>
<br />
Justificativa da CI: 
  <textarea name="justificativa" id="justificativa" cols="100" rows="10"></textarea>
<br />
<input name="cont" type="button" value="&lt;&lt; Voltar"  onclick="goBack()"/><input name="cont" type="submit" value="Continuar &gt;&gt;" />
</form>
</div>
</body>
</html>