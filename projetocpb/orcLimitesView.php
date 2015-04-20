<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<script type="text/javascript" src="ajax/funcs.js"></script>
  <!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="jqueryDown/jquery-1.8.2.js"></script> 
<script src="jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='jquery_price.js'></script>
 <script type="text/javascript">
  $(document).ready(function(){
      $('#lei').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  $(document).ready(function(){
      $('#patcef').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  $(document).ready(function(){
      $('#patdiv').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  $(document).ready(function(){
      $('#siconv').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  $(document).ready(function(){
      $('#testesp').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  $(document).ready(function(){
      $('#timerio').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  $(document).ready(function(){
      $('#timesp').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  $(document).ready(function(){
      $('#jogosochi').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  $(document).ready(function(){
      $('#reserva').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  
  </script>
  <script type="text/javascript">
var req;
// FUNÇÃO PARA BUSCA DO QUE PROCURA
function calculaTotal(valor) {
function moeda2float(moeda){

   moeda = moeda.replace(".","");

   moeda = moeda.replace(",",".");

   return parseFloat(moeda);

}
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
lei=moeda2float(document.getElementById('lei').value);
patcef=moeda2float(document.getElementById('patcef').value);
patdiv=moeda2float(document.getElementById('patcef').value);
siconv=moeda2float(document.getElementById('siconv').value);
testesp=moeda2float(document.getElementById('testesp').value);
timerio=moeda2float(document.getElementById('timerio').value);
timesp=moeda2float(document.getElementById('timesp').value);
jogosochi=moeda2float(document.getElementById('jogosochi').value);
reserva=moeda2float(document.getElementById('reserva').value);
total=lei+patcef+patdiv+siconv+testesp+timerio+timesp+jogosochi+reserva;
document.getElementById('total').value=float2moeda(total);
req.send(null);
}
</script>
</head>

<body>
<div id="box3">
<h2>Or&ccedil;amento - Visualizar Limites</h2>
<?php 
include "funcOrc.php";
include "mb.php";
$nomeConta=buscaNomeConta($_POST['conta']);
require "conectOrc.php";
$selectValores=mysql_query("SELECT * FROM limites WHERE conta='".$_POST['conta']."'") or die(mysql_error());
$arrayValores=mysql_fetch_array($selectValores);
$insere=0;
if(empty($arrayValores)){
	$insere=1;
	}
echo "<h2>".$nomeConta."</h2><input type='hidden' name='insere' class='input' value='".$insere."'/><input type='hidden' name='conta' class='input' value='".$_POST['conta']."'/>";

$totalPrevisto=(float)$arrayValores['lei']+(float)$arrayValores['patcef']+(float)$arrayValores['patdiv']+(float)$arrayValores['siconv']+(float)$arrayValores['testesp']+(float)$arrayValores['timerio']+(float)$arrayValores['timesp']+(float)$arrayValores['jogosochi']+(float)$arrayValores['reserva'];

$totalDisponivel=(float)$arrayValores['utlei']+(float)$arrayValores['utpatcef']+(float)$arrayValores['utpatdiv']+(float)$arrayValores['utsiconv']+(float)$arrayValores['uttestesp']+(float)$arrayValores['uttimerio']+(float)$arrayValores['uttimesp']+(float)$arrayValores['utjogosochi']+(float)$arrayValores['utreserva'];
echo "<div id='tabela'><table border=0 class='tabela'>
<tr><th>Tipo</th><th>Inicial</th><th>Dispon&iacute;vel</th></tr>
<tr>
<td>LEI</td><td><strong>R$</strong>".$arrayValores['lei']."</td><td><strong>R$</strong>".$arrayValores['utlei']."</td></tr>
<td>Patroc&iacute;nio CEF</td><td><strong>R$</strong>".$arrayValores['patcef']."</td><td><strong>R$</strong>".$arrayValores['utpatcef']."</td></tr>
<td>Patroc&iacute;nio Diversos</td><td><strong>R$</strong>".$arrayValores['patdiv']."</td><td><strong>R$</strong>".$arrayValores['utpatdiv']."</td></tr>
<td>SICONV</td><td><strong>R$</strong>".$arrayValores['siconv']."</td><td><strong>R$</strong>".$arrayValores['utsiconv']."</td></tr>
<td>Fundo Reserva</td><td><strong>R$</strong>".$arrayValores['reserva']."</td><td><strong>R$</strong>".$arrayValores['utreserva']."</td></tr>
<td>Testes Especiais</td><td><strong>R$</strong>".$arrayValores['testesp']."</td><td><strong>R$</strong>".$arrayValores['uttestesp']."</td></tr>
<td>Time Rio</td><td><strong>R$</strong>".$arrayValores['timerio']."</td><td><strong>R$</strong>".$arrayValores['uttimerio']."</td></tr>
<td>Time S&atilde;o Paulo</td><td><strong>R$</strong>".$arrayValores['timesp']."</td><td><strong>R$</strong>".$arrayValores['uttimesp']."</td></tr>
<td>Jogos Socchi</td><td><strong>R$</strong>".$arrayValores['jogosochi']."</td><td><strong>R$</strong>".$arrayValores['utjogosochi']."</td></tr>
<th>TOTAL CONTA</th><th><strong>R$ </strong>".number_format($totalPrevisto, 2, '.', ' ')."</th><th><strong>R$ </strong>".number_format($totalDisponivel, 2, '.', ' ')."</th>
</tr>
<tr><td colspan='3'><a href='orcMenu.php'><input type='button' name='button' value='Voltar'/></a></td></tr></table></div>"
?>
</div>
</body>
</html>