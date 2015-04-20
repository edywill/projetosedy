<?php 
require('conexaoconv.php');
mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
$sqlPerm=mysql_query("SELECT rhpermanente.*,modalidade.id AS idMod,modalidade.modalidade FROM rhpermanente,modalidade WHERE rhpermanente.id=".$_POST['idEvento']." AND rhpermanente.idmodalidade=modalidade.id") or die(mysql_error());
$arrayPerm=mysql_fetch_array($sqlPerm);

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
<script type="text/javascript">

function float2moeda(num) {

   x = 0;

   if(num<0) {
      num = Math.abs(num);
      x = 1;
   }
   if(isNaN(num)) num = "0";
      cents = Math.floor((num*100+0.5)%100);

   num = Math.floor((num*100+0.5)/100).toString();

   if(cents < 10) cents = "0" + cents;
      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
         num = num.substring(0,num.length-(4*i+3))+'.'
               +num.substring(num.length-(4*i+3));
   ret = num + ',' + cents;
   if (x == 1) ret = ' - ' + ret;
   return ret;

}

function moeda2float(moeda){

   moeda = moeda.replace(".","");

   moeda = moeda.replace(",",".");

   return parseFloat(moeda);

}
var req;

// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarDescontos() {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}

a=(document.getElementById('quantidade').value) * (moeda2float(document.getElementById('vlUnit').value));
document.getElementById('vlTot').value=float2moeda(a);
}
</script>
<script type="text/javascript">
 function somenteNumeros (num) {
		var er = /[^0-9,.]/;
		er.lastIndex = 0;
		var campo = num;
		if (er.test(campo.value)) {
		campo.value = "";
		}
	}
</script>
<title>Untitled Document</title>
</head>

<body>
<div id='box3'><br/>
<strong>ATUALIZAR RECURSOS HUMANOS PERMANENTES:</strong><br /><br />
<div id="tabela">
<form action="atEventoConvPerm.php" method="post" onsubmit="this.elements['ok'].disabled=true;">
<table border="1" width="400">
<tr><th width="18%">Modalidade</th><td width="82%"><input type="hidden" name="validador" value="2" /><input type="hidden" name="id" value="<?php echo $arrayPerm['id']; ?>" /><select id='modal' name="modal">
<option value="<?php echo $arrayPerm['idMod']; ?>" selected="selected"><?php echo $arrayPerm['modalidade']; ?></option>
<?php 
$sqlMod=mysql_query("SELECT * FROM modalidade");
while($objMod=mysql_fetch_object($sqlMod)){
   if($objMod->id<>$arrayPerm['idMod']){
	echo "<option value='".$objMod->id."'>".utf8_encode ($objMod->modalidade)."</option>";
	}}

?>
</select>
</td></tr>
<tr>
  <th>Especificação (Função):</th><td><input name="funcao" type="text" size="40" class="input" value="<?php echo $arrayPerm['funcao']; ?>"/></td></tr>
<tr>
  <th>Quantidade:</th><td><input name="quantidade" id="quantidade" type="text" size="40" class="input" onkeyup="somenteNumeros(this)" value="<?php echo $arrayPerm['quantidade']; ?>"/></td></tr>
<tr>
  <th>Unid. de Medida:</th><td><select name="um">
<option value="<?php echo $arrayPerm['um']; ?>"><?php echo $arrayPerm['um']; ?></option>
<option value="Unid.">Unid.</option>
<option value="Dias">Dias</option>
<option value="Mês">Mês</option>
<option value="Horas">Horas</option>
</select></td></tr>
<tr>
  <th>Valor Unitário(R$):</th><td><input name="vlUnit" id="vlUnit" type="text" size="40" class="input" onkeyup="somenteNumeros(this)" onblur="buscarDescontos()" value="<?php echo $arrayPerm['vlunit']; ?>"/></td></tr>
<tr>
  <th>Valor Original(R$):</th><td><input name="vlTot" id="vlTot" type="text" size="40" class="input" onkeyup="somenteNumeros(this)" value="<?php echo $arrayPerm['vltot']; ?>"/></td></tr>
<tr><td><a href="gestConv.php"><input type="button" value="Voltar" name="voltar" /></a></td><td><input id="ok" type="submit" class="button" value="Cadastrar" name="ok" /></td></tr>
</table>
</form>
</div>
</div>
</body>
</html>