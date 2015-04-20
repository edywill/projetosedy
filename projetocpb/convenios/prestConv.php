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

<script type="text/javascript">

var req;

// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarEventos(valor) {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "consConvPrest.php?valor="+valor;

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Exibe a mensagem "Buscando usuario..." enquanto carrega
if(req.readyState == 1) {
document.getElementById('resultado').innerHTML = 'aguarde ...';
}
// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

// Abaixo colocamos a(s) resposta(s) na div resultado que está lá no teste.php
document.getElementById('resultado').innerHTML = resposta;

}
}
req.send(null);
}
</script>
<title>Untitled Document</title>
</head>

<body>
<div id='box3'><br/>
<?php
//include "function.php";
//include "mb.php";
//$usuario=$_GET['usuario'];
//require('conexaomysql.php');
require('conexaoconv.php');
?>

<strong>Prestação de Contas:</strong><br /><br />
Escolha uma modalidade:<select id='modal' name="modal" onchange="buscarEventos(this.value)">
<option value="0" selected="selected">Selecione</option>
<?php 
require "conexaoconv.php";
$sqlMod=mysql_query("SELECT * FROM modalidade");
while($objMod=mysql_fetch_object($sqlMod)){
	echo "<option value='".$objMod->id."'>".utf8_encode ($objMod->modalidade)."</option>";
	}

?>
</select><br />
<div id="resultado">

</div>
</div>
</body>
</html>