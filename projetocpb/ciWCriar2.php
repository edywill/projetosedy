<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
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
</head>
<body>
<div id='box3'>
<br/>
<strong>CIWEB  - Criar nova Solicitação:</strong><br/>
DADOS GERAIS GERAIS DA CI
<br/><br/>
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
<form action="ciWInserir.php" method="post" name="ciWCriar">
Solicitação:
  <input class="input" name="solic" type="text" size="10" />
TG:<input class="input" name="tg" type="text" size="6" /> U.N.:<input class="input" name="un" type="text" size="20" value="001 - COMITE PARAOLIMPICO" /> Data:<input class="input" name="dthoje" type="text" size="10" value="<?php echo $data; ?>" /> Tipo Operação:<input class="input" name="toperacao" type="text" size="10" /> <br/><br />
Descrição: <input class="input" name="desc" type="text" size="115" /><br /><br/>
Local: <input class="input" name="local" type="text" size="80" /> Setor: <input class="input" name="setor" type="text" size="10" /><br /><br/>
Controle: <input class="input" name="controle" type="text" size="15" value="<?php echo $controle; ?>" />  Situação: 
<div id="select">
<select name="situacao" id="situacao">
  <option>Aberta</option>
  <option>Fechada</option>
  <option>Pendente</option>
</select>
</div>
Conta: <input class="input" name="conta" type="text" size="20" /><br /><br/>
Gestor: <input class="input" name="gestor" type="text" size="20" /> Portador: <input name="portador" type="text" size="8" />Data Ocorr.:<input name="dtocorrencia" type="text" size="10" />
<br />
<br />
<br/>
<input class='button' name="cont" type="button" value="Cancelar" onclick="goBack()"/><input class='button' name="cont" type="submit" value="Continuar &gt;&gt;" />
</form>
</div>
</body>
</html>