<?php 
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";
/*
Tipos
0-Geral
1-Outras
2-CompraDireta
*/
if(!empty($_GET['id'])){
	$tipo=$_GET['id'];
	$_SESSION['tipoRelatorio']=$tipo;
	}
switch($_SESSION['tipoRelatorio']){
	case(0):
		$tipoRel="Geral";
		break;
	case(1):
		$tipoRel="Outras Modalidades";
		break;
	case(2):
		$tipoRel="Compra Direta";
		break;
	}
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>

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
<script type="text/javascript" language="javascript">
function CarregaMateriais(codGrupo)
{
	// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "carregaMaterial.php?grupo="+codGrupo;

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;
document.getElementById('materialAjax').innerHTML=resposta;
}
}
req.send(null);
}
</script>
</head>
       
<body>
<div id='box3' style="height:auto">
    <br/>
    
  <h2>AQUISIÇÕES</h2>
  <h3><strong>Relatórios</strong> - <?php echo $tipoRel;?>
  <br />
  </h3>
  <form action="relatorioGrupo.php" name="relsrp" method="post">
   <table border="0" width="100%">
   <tr>
     <td width="30%" align="right"><strong>Grupo de Despesa:</strong></td>
     <td>
     <input type='hidden' name='pagsrp' value='grupoDesp.php'/>
   <select name="grupo" id="grupo" onChange="CarregaMateriais(this.value)">
  <option selected="selected" value="0">Todos</option>
  <?php 
  $SQLGrupo=mysql_query("SELECT * FROM aquigrupo WHERE inativo=0");
while($objGrupo=mysql_fetch_object($SQLGrupo)){
	echo "<option value='".$objGrupo->id."'>".$objGrupo->codigo."-".utf8_encode($objGrupo->descricao)."</option>";	
	}
?>  
  </select>
  </td></tr>
  <tr>
    <td align="right"><strong>Material:</strong></td>
    <td>
  <div id="materialAjax">
  <select name="material">
  <option value="0">Todos</option>
   </select>
  </div>
  </td></tr>
  <tr><td><a href="../relatorios.php"><input class="button" type="button" name="voltar" value="Voltar" /></a></td><td align="right"><input type="submit" name="ok" class="button" value="CONTINUAR" /></td>
  </tr></table>
</form>
</div>
</body>
</html>