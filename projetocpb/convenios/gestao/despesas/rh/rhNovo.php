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
function buscarValorRh() {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}
valor=document.getElementById('nome').value;
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "consValorRh.php?valor="+valor;

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {
// Resposta retornada pelo busca.php
var resposta = req.responseText;

// Abaixo colocamos a(s) resposta(s) na div resultado que está lá no teste.php
//document.getElementById('resultado').innerHTML = resposta;
vl=float2moeda(moeda2float(resposta));
document.getElementById('vlunit').value= vl;
tr=moeda2float(vl)*0.2;
qtdpes=float2moeda(document.getElementById('qtdpes').value);
qtdtem=float2moeda(document.getElementById('qtdtem').value);
tot=((moeda2float(vl)+tr)*moeda2float(qtdpes))*moeda2float(qtdtem);
document.getElementById('tributo').value= float2moeda(tr);
document.getElementById('total').value= float2moeda(tot);
}
}
req.send(null);
}

// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarValorRhV() {

vl=document.getElementById('vlunit').value;
document.getElementById('vlunit').value= vl;
tr=moeda2float(vl)*0.2;
qtdpes=float2moeda(document.getElementById('qtdpes').value);
qtdtem=float2moeda(document.getElementById('qtdtem').value);
tot=((moeda2float(vl)+tr)*moeda2float(qtdpes))*moeda2float(qtdtem);
document.getElementById('tributo').value= float2moeda(tr);
document.getElementById('total').value= float2moeda(tot);
}
// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarValorRhT() {

vl=document.getElementById('vlunit').value;
document.getElementById('vlunit').value= vl;
tr=moeda2float(document.getElementById('tributo').value);
qtdpes=float2moeda(document.getElementById('qtdpes').value);
qtdtem=float2moeda(document.getElementById('qtdtem').value);
tot=((moeda2float(vl)+tr)*moeda2float(qtdpes))*moeda2float(qtdtem);
document.getElementById('tributo').value= float2moeda(tr);
document.getElementById('total').value= float2moeda(tot);
}
</script>
<script type="text/Javascript">
function desabilitaControle(controle)
{
	
if(document.getElementById('tcont').value=="clt"){
     document.getElementById('tributo').readOnly = false;
	 document.getElementById('vlunit').readOnly = false;
  }else{
	  document.getElementById('tributo').readOnly = true;
	 document.getElementById('vlunit').readOnly = true;
	  }
}
</script>
<script type="text/javascript">
  $().ready(function() {
	  $("#nome").autocomplete("suggest_cargos.php", {
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
  $(document).ready(function(){
      $('#tributo').priceFormat({
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
$idEvento=$_POST['idEvento'];
}else{
$tipoId=$_SESSION['tipoIdSessionConv'];
$id=$_SESSION['projetoConvS'];
$titMod=$_SESSION['titModSession'];
$id=$idProj;
$idEvento=$_SESSION['idEventoSession'];
	}
include "../../projetos/detalhesProj.php";
echo "<br><h2>".$titMod."</h2>";
include "../../eventos/detalhesEventos.php";
echo "<h3>Cadastro RH</h3>";
$sqlDadosProj=mysql_query("SELECT * FROM convprojetos WHERE id='".$id."'");
// Calcula a diferença em segundos entre as datas
//$dtInicial=date("Y-m-d",strtotime($arrayDetEvento['dtinicio']));
//$dtFinal=date("Y-m-d",strtotime($arrayDetEvento['dtfim']));
function geraTimestamp($data) {
$partes = explode('/', $data);
return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
}
$dtInicial=geraTimestamp($arrayDetEvento['dtinicio']);
$dtFinal=geraTimestamp($arrayDetEvento['dtfim']);
$diferenca=$dtFinal-$dtInicial;
$calculaDias = (int)floor($diferenca / (60 * 60 * 24));
$nomecargo='';
$idcargo='';
$qtdpes='';
$qtdtem=$calculaDias;
$um='Dias';
$vlunit='';
$tributos='';
$total='';
$tcont='';
$titButton='Cadastrar';
echo "<form action='insereNovoRh.php' name='formProjConv' method='post'>";
echo "<input type='hidden' name='idproj' value='".$idProj."'/>
<input type='hidden' name='tipoId' value='".$tipoId."'/>
<input type='hidden' name='idEvento' value='".$idEvento."'/>
<input type='hidden' name='titMod' value='".$titMod."'/>
<div id='tabela'>";
include "cadastraNovoRh.php";
echo "</div></form>";
?>
<a href="../projec.php"><input type="button" name="voltar" value="<<Voltar"/></a>
</div>
</body>
</html>