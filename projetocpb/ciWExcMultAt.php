<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8891" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<script type="text/javascript" src="ajax/funcs.js"></script>
  <!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="jqueryDown/jquery-1.8.2.js"></script> 
<script src="jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="jqueryDown/jquery-1.9.0-ui.css" /> 
  <script type='text/javascript' src='jquery.autocomplete.js'></script>
  <link rel="stylesheet" type="text/css" href="jquery.autocomplete.css" />
  <script type='text/javascript' src='jquery_price.js'></script>
 <script type="text/javascript">
  $(document).ready(function(){
      $('#valorRpa').priceFormat({
        prefix: '',
        centsSeparator: '.',
        thousandsSeparator: ''
      });
    });
  </script>
  <script type="text/javascript">
  $(document).ready(function(){
      $('#valorDia').priceFormat({
        prefix: '',
        centsSeparator: '.',
        thousandsSeparator: ''
      });
    });
  </script>
  <script type="text/javascript">
  $(document).ready(function(){
      $('#valorPas').priceFormat({
        prefix: '',
        centsSeparator: '.',
        thousandsSeparator: ''
      });
    });
  </script>
  <script type="text/javascript">
  $().ready(function() {
	  $("#rpaCod").autocomplete("suggest_user.php", {
		  width: 260,
		  matchContains: true,
		  selectFirst: false
	  });
  });
  </script>
  <script type="text/javascript">
  $().ready(function() {
	  $("#diaCod").autocomplete("suggest_user.php", {
		  width: 260,
		  matchContains: true,
		  selectFirst: false
	  });
  });
  </script>
  <script type="text/javascript">
  $().ready(function() {
	  $("#pasCod").autocomplete("suggest_user.php", {
		  width: 260,
		  matchContains: true,
		  selectFirst: false
	  });
  });
  </script>
  <script type="text/javascript">
  $().ready(function() {
	  $("#hotCod").autocomplete("suggest_user.php", {
		  width: 260,
		  matchContains: true,
		  selectFirst: false
	  });
  });
  </script>
  <script>
  $(function() {
	  $( "#inicioRpa" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#fimRpa" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#inicioDia" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#fimDia" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#inicioPas" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#fimPas" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#inicioHot" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#fimHot" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script language='Javascript'>
  function validNumb(e){
  var tecla=(window.event)?event.keyCode:e.which;   
  if((tecla > 47 && tecla < 58)) return true;
  else{
  if(tecla==8 || tecla==0) return true;
  else
  return false;
  }
  }
  </script>
  
  <script>
  function abrir(programa,janela)
  {
	 if(janela=="") janela = "janela";
	 window.open(programa,janela,'height=350,width=640');
  }
  </script>
  <script language=javascript> 
  function janelaSecundaria (URL){ 
	 window.open(URL,"janela1","width=400,height=300,scrollbars=NO") 
  } 
  </script> 
  <script>
  function goBack()
	{
	window.history.back()
	}
  </script>
  <script language="javascript">
  /*----------------------------------------------------------------------------
  Formatação para qualquer mascara
  -----------------------------------------------------------------------------*/
  function formatar(src, mask){
	var i = src.value.length;
	var saida = mask.substring(0,1);
	var texto = mask.substring(i)
  if (texto.substring(0,1) != saida)
	{
	  src.value += texto.substring(0,1);
	}
  }
  </script>
  <script language="Javascript">
  function showDiv(div)
  {
  document.getElementById("rpa").className = "invisivel";
  document.getElementById("diaria").className = "invisivel";
  document.getElementById("passagem").className = "invisivel";
  document.getElementById("hotel").className = "invisivel";
  
  document.getElementById(div).className = "visivel";
  }
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
  <style>
  .invisivel { display: none; }
  .visivel { visibility: visible; }
  </style>
<script type='text/javascript'>
function bloqueioTeclas()   // Verificação das Teclas
{
    var tecla=window.event.keyCode;
    var alt=window.event.altKey;      // Para Controle da Tecla ALT
    
    if (tecla==116)    //Evita feclar via Teclado através do ALT+F4
    {
        event.keyCode=0;
        event.returnValue=false;
    }
}
</script>
</head>
<body onKeyDown="javascript:return bloqueioTeclas();">
<div id='box3'>

<br/><strong>CIWEB  - Confirma&ccedil;&atilde;o de Inclus&atilde;o:</strong><br/><br/>
<?php
$botao="<a href='ciWExcMult.php'><input name='cont' class='button' type='button' value='Voltar' /></a>";

include "mb.php";
require "conectsqlserverci.php";
require('conexaomysql.php');
$inicioRpa=$_POST['inicioRpa'];
$fimRpa=$_POST['fimRpa'];
$valorRpa=$_POST['valorRpa'];
$inicioDia=$_POST['inicioDia'];
$fimDia=$_POST['fimDia'];
$valorDia=$_POST['valorDia'];
$inicioPas=$_POST['inicioPas'];
$horaPtPas=$_POST['horaPtPas'];
$fimPas=$_POST['fimPas'];
$horaRetPas=$_POST['horaRetPas'];
$valorPas=$_POST['valorPas'];
$trechoPas=$_POST['trechoPas'];
$obsPas=$_POST['obsPas'];
$inicioHot=$_POST['inicioHot'];
$fimHot=$_POST['fimHot'];
//$retornar='ciWExcMult.php';
$tipo=trim($_POST['tipoInsert']);
$titulo='';
$dtInicio='';
$dtFim='';
$valor='';
$reservaHotel='';
$passagemExtras='';
$colspan='3';

if($tipo=='rpa'){
	$titulo='RPA - Recibo de Pagamento Autonomo';
	$dtInicio=$inicioRpa;
	$dtFim=$fimRpa;
	$valor="<tr><th>Valor Unit&aacute;rio(R$)</th><td>".number_format($valorRpa, 2, ',', '.')."</td></tr>";
	}elseif($tipo=='diaria'){
		$titulo='DI&Aacute;RIA / AUXILIO VIAGEM';
		$dtInicio=$inicioDia;
		$dtFim=$fimDia;
		$valor="<tr><th>Valor Unit&aacute;rio(R$)</th><td>".number_format($valorDia, 2, ',', '.')."</td></tr>";
		}elseif($tipo=='hotel'){
			$titulo='HOSPEDAGEM';
			$dtInicio=$inicioHot;
			$dtFim=$fimHot;
			$colspan='4';
			}elseif($tipo=='passagem'){
				$minutoImpPas=substr(substr($horaPtPas, -4), 2);
				$horaImpPas=str_replace(substr($horaPtPas, -4),"",$horaPtPas);
				$titulo='Passagens Nacionais / Internacionais';
				$dtInicio=$inicioPas." - ".$horaImpPas.":".$minutoImpPas;
				if($fimPas=='null'){
				$dtFim='';
				}else{
					$minutoImpPasRet=substr(substr($horaRetPas, -4), 2);
					$horaImpPasRet=str_replace(substr($horaRetPas, -4),"",$horaRetPas);
					$dtFim=$inicioPas." - ".$horaImpPasRet.":".$minutoImpPasRet;
					}
				$passagemExtras="<tr><th>Trecho</th><td>".$trechoPas."</td></tr><tr><th>Observa&ccedil;&atilde;o</th><td>".$obsPas."</td></tr>";
				$valor="<tr><th>Valor Unit&aacute;rio(R$)</th><td>".number_format($valorPas, 2, ',', '.')."</td></tr>";
				$colspan='4';
				}

echo "
<form action='ciWExcMultFinal.php' method='post' >
CI n&ordm;: <strong><font size='3' color='red'>".$_POST['solicitacao']."</font></strong><br>
	  Item: ".$_POST['sequencia']."<br><br>
<div id='tabela3'><table border='1'><tr><td bgcolor='#658BF3' colspan='2'><strong>
      <input class='input' name='retorno' id='retorno' type='hidden' size='8' value='".$_POST['retorno']."'  />
	  <input class='input' name='sequencia' id='sequencia' type='hidden' size='8' value='".$_POST['sequencia']."'  />
	  <input class='input' name='solicitacao' id='solicitacao' type='hidden' size='8' value='".$_POST['solicitacao']."'  />
	  <input class='input' name='usuario' id='usuario' type='hidden' size='8' value='".$_POST['usuario']."'  />
<input type='hidden' name='tipoIns' value='".$tipo."'/>
<input type='hidden' name='inicioRpa' value='".$inicioRpa."'/>
<input type='hidden' name='fimRpa' value='".$fimRpa."'/>
<input type='hidden' name='inicioHot' value='".$inicioHot."'/>
<input type='hidden' name='fimHot' value='".$fimHot."'/>
<input type='hidden' name='inicioPas' value='".$inicioPas."'/>
<input type='hidden' name='fimPas' value='".$fimPas."'/>
<input type='hidden' name='inicioDia' value='".$inicioDia."'/>
<input type='hidden' name='fimDia' value='".$fimDia."'/>
<input type='hidden' name='valorDia' value='".$valorDia."'/>
<input type='hidden' name='valorPas' value='".$valorPas."'/>
<input type='hidden' name='valorRpa' value='".$valorRpa."'/>
<input type='hidden' name='horaPtPas' value='".$horaPtPas."'/>
<input type='hidden' name='horaRetPas' value='".$horaRetPas."'/>
<input type='hidden' name='obsPas' value='".$obsPas."'/>
<input type='hidden' name='trechoPas' value='".$trechoPas."'/>
".$titulo."</strong></td></tr>
<tr><th>Data de Inicio</th><td>".$dtInicio."</td></tr>
<tr><th>Data de Fim</th><td>".$dtFim."</td></tr>
".$valor."
".$passagemExtras."
</table>
</div>";
//$itens= $_REQUEST['select'];
echo "<div id='tabela3'>
<table border='1' width='100%'>
<tr><td bgcolor='#658BF3' colspan='".$colspan."'><strong><center>BENEFICI&Aacute;RIOS</center></strong></td></tr>
<tr><th width='10%'>N&ordm;</th><th width='45%'>Nome</th><th width='45%'>Cargo</th>";
if($tipo=='passagem'){
	echo "<th>Cadeirante</th>";
	}elseif($tipo=='hotel'){
		echo "<th>R.L.</th>";
		}
echo "</tr>";
require "conexaomysql.php";
$ciTemp=mysql_query("SELECT id FROM cimulttemp WHERE ci='".$_POST['solicitacao']."' and seq='".$_POST['sequencia']."' AND status=1");
$contagem = mysql_num_rows($ciTemp);
$i=0;
       while ($itens=mysql_fetch_object($ciTemp)) {
		   $sqlNome=odbc_exec($conCab,"select GEEMPRES.Nome_completo as nome,
GEPFISIC.Cargo as cargo
From
  GEEMPRES with(nolock) left Join
  GEPFISIC with(nolock) On GEEMPRES.Cd_empresa = GEPFISIC.Cd_empresa
where GEEMPRES.Cd_empresa='".$itens->id."'");
		   $nome_completo=odbc_fetch_array($sqlNome);
		   if(empty($nome_completo)){
			   ?>
       <script type="text/javascript">
       alert("Por favor selecione novamente.");
       history.back();
       </script>
       <?php
			   }
            echo "<tr><td><input name='id".$i."' type='hidden' value='".$itens->id."'/>".$itens->id."</td><td>".mb_convert_encoding($nome_completo['nome'],"UTF-8","ISO-8859-1")."</td><td><input name='cargo".$i."' type='text' class='input' value='".trim(mb_convert_encoding($nome_completo['cargo'],"UTF-8","ISO-8859-1"))."' size='45'/></td>";
			if($tipo=='passagem'){
				echo "<td><center><input type='checkbox' name='cadeirante".$i."' value='1'/></center></td>";
				}elseif($tipo=='hotel'){
					echo "<td><input name='rlHot".$i."' type='text' class='input' value='' size='20'/></td>";
					}
			echo"</tr>";//imprime o item corrente
       $i++;
	   }
//echo "<input type='hidden' name='contagem' value='".$contagem."'/><tr><td><a href='javascript:history.back()'>VOLTAR</a></td><td></td><td><input type='submit' class='button' value='Confirmar'/></td></tr></table></form></div>";
echo "</table><br/><br/>";
echo "<input type='hidden' name='contagem' value='".$contagem."'/>".$botao."<span style='padding-left:698px'><input type='submit' class='buttonVerde' value='Confirmar'/></form></div>";
?>
</div>
</body>
</html>