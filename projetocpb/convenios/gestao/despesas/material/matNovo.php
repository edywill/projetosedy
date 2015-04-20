<?php 
if(!isset($_SESSION)){
session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />

<title>Untitled Document</title>
<script type="text/javascript" src="../../../../ajax/funcs.js"></script>
<script src="../../../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../../../jqueryDown/jquery-1.9.0-ui.css" />
<script type='text/javascript' src='../../../../jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="../../../../jquery.autocomplete.css" />
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
function buscarValorMat() {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}
valor=document.getElementById('moeda').value;
document.getElementById('moedaText').innerHTML=valor;
document.getElementById('moedaText1').innerHTML=valor;
calc=document.getElementById('qtd').value*moeda2float(document.getElementById('vlunitmoeda').value);
document.getElementById('totalmoeda').value=float2moeda(calc);
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "consValorMat.php?valor="+valor;

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {
// Resposta retornada pelo busca.php
var resposta = req.responseText;
var myarr = resposta.split("-");
if(valor=='R$' || valor=='Outros'){
	document.getElementById('txcamb').value="1,00";
	document.getElementById('horaText').innerHTML="";
	document.getElementById('dataText').innerHTML="";
	document.getElementById('vlunitreal').value=document.getElementById('vlunitmoeda').value;
	document.getElementById('totalreal').value=float2moeda(calc);
}else{
	document.getElementById('dataText').innerHTML="Cota&ccedil;&atilde;o: "+myarr[1];
	document.getElementById('horaText').innerHTML=myarr[2];
	document.getElementById('dtcotacao').value="Cota&ccedil;&atilde;o: "+myarr[1]+" "+myarr[2];
	document.getElementById('txcamb').value=float2moeda(myarr[0]);
document.getElementById('vlunitreal').value=float2moeda(moeda2float(document.getElementById('txcamb').value)*moeda2float(document.getElementById('vlunitmoeda').value));
document.getElementById('totalreal').value=float2moeda(moeda2float(document.getElementById('txcamb').value)*moeda2float(document.getElementById('totalmoeda').value));
}
}
}
req.send(null);
}
// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarValorMat2() {
calc2=document.getElementById('qtd').value*moeda2float(document.getElementById('vlunitmoeda').value);
document.getElementById('totalmoeda').value=float2moeda(calc2);
if(document.getElementById('txcamb').value=='' || document.getElementById('txcamb').value=='0,00'){
if(document.getElementById('moeda').value=='R$' || document.getElementById('moeda').value=='Outros'){
	document.getElementById('txcamb').value='1,00'
	}
}
document.getElementById('vlunitreal').value=float2moeda(moeda2float(document.getElementById('vlunitmoeda').value)*moeda2float(document.getElementById('txcamb').value));
document.getElementById('totalreal').value=float2moeda(document.getElementById('qtd').value*moeda2float(document.getElementById('totalmoeda').value));
}
</script>
  <script type='text/javascript' src='../../../../jquery_price.js'></script>
  <script type="text/javascript">
  $(document).ready(function(){
      $('#vlunitreal').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  $(document).ready(function(){
      $('#vlunitmoeda').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  $(document).ready(function(){
      $('#totalreal').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  $(document).ready(function(){
      $('#totalmoeda').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  $(document).ready(function(){
      $('#txcamb').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  </script>
<script type="text/javascript">
 function somenteNumeros (num) {
		var er = /[^0-9.]/;
		er.lastIndex = 0;
		var campo = num;
		if (er.test(campo.value)) {
		campo.value = "";
		}
	}
</script>
</head>

<body>
<div id="box3">
<?php 
require "../../../common/tagsConv.php";
require "../../../../conexaomysql.php";
echo $titulo;
if(!empty($_POST['id'])){
$idProj=$_POST['id'];
$id=$idProj;
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
}else{
$tipoId=$_SESSION['tipoIdSessionConv'];
$id=$_SESSION['projetoConvS'];
$titMod=$_SESSION['titModSession'];
$id=$idProj;
	}
include "../../projetos/detalhesProj.php";
echo "<br><h2>".$titMod."</h2>";

echo "<h3>Cadastro de Material Esportivo</h3>";
$sqlDadosProj=mysql_query("SELECT * FROM convprojetos WHERE id='".$id."'");
$descricao='';
$qtd='';
$vlunitreal='';
$totalreal='';
$txcamb='';
$vlunitmoeda='';
$totalmoeda='';
$dtcotacao='';
$tipo='';
$titButton='Cadastrar';
echo "<form action='insereNovoMat.php' name='formProjConv' method='post'>";
echo "<input type='hidden' name='idproj' value='".$idProj."'/>
<input type='hidden' name='tipoId' value='".$tipoId."'/>
<input type='hidden' name='titMod' value='".$titMod."'/>
<div id='tabela'>";
include "cadastraNovoMat.php";
echo "</div></form>";
?>
<a href="../material.php"><input type="button" name="voltar" value="<<Voltar"/></a>
</div>
</body>
</html>