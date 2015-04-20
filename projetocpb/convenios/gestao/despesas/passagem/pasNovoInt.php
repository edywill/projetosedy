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
function buscarValorPas() {
// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}
valor=document.getElementById('trecho').value;
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "consValorPasInt.php?valor="+valor;

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {
// Resposta retornada pelo busca.php
var resposta = req.responseText;
var myarr = resposta.split("-");
// Abaixo colocamos a(s) resposta(s) na div resultado que está lá no teste.php
//document.getElementById('resultado').innerHTML = resposta;
if(myarr[1]=="int"){
document.getElementById('abrg').innerHTML="Internacional";
  }else if(myarr[1]=="nac"){
	document.getElementById('abrg').innerHTML="Nacional";
	}else{
		document.getElementById('abrg').innerHTML="Trecho Inexistente";
		}
document.getElementById('idref').value= myarr[2];
document.getElementById('vlunit').value= float2moeda(moeda2float(myarr[0]));
document.getElementById('total').value= float2moeda((moeda2float(float2moeda(myarr[0])))*moeda2float(float2moeda(document.getElementById('qtd').value)));
}
}
req.send(null);
}

// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarValorPasV(){
document.getElementById('total').value=float2moeda(moeda2float(document.getElementById('vlunit').value)*document.getElementById('qtd').value);
}
// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarValorPasT() {
document.getElementById('total').value=float2moeda(moeda2float(document.getElementById('vlunit').value)*document.getElementById('qtd').value);
}
</script>
<script type="text/javascript">
  	 $().ready(function() {
	  $("#trecho").autocomplete("suggest_trechosint.php", {
		  width: 315,
		  matchContains: true,
		  selectFirst: false
	  });
	});
</script>
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
  <script type='text/javascript' src='../../../../jquery_price.js'></script>
  <script type="text/javascript">
  $(document).ready(function(){
      $('#vlunit').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  $(document).ready(function(){
      $('#total').priceFormat({
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
$idProj=$_POST['id'];
$id=$idProj;
$tipoId=$_POST['tipoId'];
$idEvento=$_POST['idEvento'];
include "../../projetos/detalhesProj.php";
$titMod=$_POST['titMod'];
echo "<br><h2>".$titMod."</h2>";
include "../../eventos/detalhesEventos.php";
echo "<h3>Cadastro de Trecho Internacional</h3>";
$sqlDadosProj=mysql_query("SELECT * FROM convprojetos WHERE id='".$id."'");
$dtfim=$arrayDetEvento['dtfim'];
$dtinicio=$arrayDetEvento['dtinicio'];
$trecho='';
$idRef='';
$abrg='';
$qtd='';
$vlunit='';
$total='';
$titButton='Cadastrar';
echo "<form action='insereNovoPas.php' name='formProjConv' method='post'>";
echo "<input type='hidden' name='idproj' value='".$idProj."'/>
<input type='hidden' name='tipoId' value='".$tipoId."'/>
<input type='hidden' name='idEvento' value='".$idEvento."'/>
<input type='hidden' name='abrg' value='int'/>
<input type='hidden' name='titMod' value='".$titMod."'/>
<div id='tabela'>";
include "cadastraNovoPasInt.php";
echo "</div></form>";
?>
</div>
</body>
</html>