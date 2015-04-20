
<?php 
echo "<div id='outro' style='display: none;'>";
session_start();
include "mb.php";
require "conectsqlserverci.php";
require('conexaomysql.php');
if(!empty($_POST['solicitacao'])){
$sequencia=$_POST['sequencia'];
$solicitacao=$_POST['solicitacao'];
$usuario=$_POST['usuario'];
$retorno=$_POST['retorno'];
$tipo=$_POST['tipo'];
$_SESSION['sequenciaMult']=$sequencia;
$_SESSION['solicitacaoMult']=$solicitacao;
$_SESSION['usuarioMult']=$usuario;
$_SESSION['retornoMult']=$retorno;
$_SESSION['tipoMult']=$tipo;
}else{
$sequencia=$_SESSION['sequenciaMult'];
$solicitacao=$_SESSION['solicitacaoMult'];
$usuario=$_SESSION['usuarioMult'];
$retorno=$_SESSION['retornoMult'];
$tipo=$_SESSION['tipoMult'];
	}
  $nova=0;
  $hotel=0;
  $passagem=0;
  $diaria=0;
  $rpa=0;
  if($retorno=='inserir'){
	  $retornar='ciWItensExclusivos.php';
	  }else{
		  $retornar='ciWItensExclusivosAt.php';
		  }
  $sqlConsRPA="SELECT * FROM
			   TEITEMSOLRPA (nolock)
			   WHERE
			   cd_solicitacao=".$solicitacao."";
  $rsConsRPA = odbc_exec($conCab,$sqlConsRPA) or die(odbc_error());
  $contConsRPA=odbc_num_rows($rsConsRPA);
  
			  $sqlConsDiaria="SELECT * FROM
			   TEITEMSOLDIARIAVIAGEM (nolock)
			   WHERE
			   solicitacao=".$solicitacao."";
			  $rsConsDiaria = odbc_exec($conCab,$sqlConsDiaria) or die(odbc_error());
			  $contConsDiaria=odbc_num_rows($rsConsDiaria);
			
			$sqlConsPassagem="SELECT * FROM
			   TEITEMSOLPASSAGEM (nolock)
			   WHERE
			   cd_solicitacao=".$solicitacao."";
			$rsConsPassagem = odbc_exec($conCab,$sqlConsPassagem) or die(odbc_error());
			$contConsPassagem=odbc_num_rows($rsConsPassagem);
			
			$sqlConsHotel="SELECT * FROM
			   TEITEMSOLHOTEL (nolock)
			   WHERE
			   cd_solicitacao=".$solicitacao."";
			$rsConsHotel = odbc_exec($conCab,$sqlConsHotel) or die(odbc_error());
			$contConsHotel=odbc_num_rows($rsConsHotel);
			$sqlConsItens="SELECT * FROM
			   COISOLIC (nolock)
			   WHERE
			   cd_solicitacao=".$solicitacao."";
			$rsConsItens = odbc_exec($conCab,$sqlConsItens) or die(odbc_error());
			$contConsItens=odbc_num_rows($rsConsItens);
if($contConsRPA>0){
	$rpa=1;
	}
if($contConsPassagem>0){
	$passagem=1;
	}
if($contConsDiaria>0){
	$diaria=1;
	}
if($contConsHotel>0){
	$hotel=1;
	}
if($contConsItens<2 || ($contConsHotel<1 && $contConsPassagem<1 && $contConsDiaria<1 && $contConsRPA<1)){
	?>
        <script type="text/javascript">
       alert("N\u00e3o existe item dispon\u00edvel para c\u00f3pia.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	}
 echo "</div>";
?>
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
  <script type='text/javascript' src='jquery.autocomplete.js'></script>
  <link rel="stylesheet" type="text/css" href="jquery.autocomplete.css" />
  <script type='text/javascript' src='jquery_price.js'></script>
 <script type="text/javascript">
  $(document).ready(function(){
      $('#valorRpa').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  </script>
  <script type="text/javascript">
  $(document).ready(function(){
      $('#valorDia').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  </script>
  <script type="text/javascript">
  $(document).ready(function(){
      $('#valorPas').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
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
  if(div=="rpa"){
	  document.getElementById('tipo').value = "rpa";
	  }else if(div=="diaria"){
		  document.getElementById('tipo').value = "diaria";
		  }else if(div=="hotel"){
			  document.getElementById('tipo').value = "hotel";
			  }else if(div=="passagem"){
				document.getElementById('tipo').value = "passagem";  
				  }else if(div==""){
					  document.getElementById('tipo').value = "";
					  }
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
<br/><strong>CIWEB  - Informa&ccedil;&otilde;es B&aacute;sicas:</strong><br/><br/>
<?php
echo "<form action='ciWExcCopIns.php' method='post'>
	  <strong>CI N&ordm; <font size='3' color='red'>".$solicitacao."</strong></font><br>
	  Item: ".$sequencia."<br><br>
	  <input class='input' name='retorno' id='retorno' type='hidden' size='8' value='".$retorno."'  />
	  <input class='input' name='sequencia' id='sequencia' type='hidden' size='8' value='".$sequencia."'  />
	  <input class='input' name='solicitacao' id='solicitacao' type='hidden' size='8' value='".$solicitacao."'  />
	  <input class='input' name='usuario' id='usuario' type='hidden' size='8' value='".$usuario."'  />";
echo "<div id='tabela'>";
echo "<table border=1><tr><th>COPIAR DE:</th><th>PARA:</th></tr>
<tr><td><div id='select'><select name='referencia'><option selected value='0'>Selecione</option>";
if($rpa==1){
	echo "<option value='rpa'>RPA</option>";
	}
if($diaria==1){
	echo "<option value='diaria'>Diaria/Auxilio Viagem</option>";
	}
if($passagem==1){
	echo "<option value='passagem'>Passagem</option>";
	}
if($hotel==1){
	echo "<option value='hotel'>Hospedagem</option>";
	}
echo "</select></div></td><td><input type='hidden' value='".$tipo."' name='tipo'>";
if($tipo=='rpa'){
	echo "RPA";
	}elseif($tipo=='diaria'){
		echo "Di&aacute;rias/Aux&iacute;lio Viagem";
		}elseif($tipo=='passagem'){
			echo "Passagem";
			}elseif($tipo=='hotel'){
				echo "Hospedagem";
				}
echo "</td></tr>";
echo "</table></div><br/>
<input name='atJus' class='buttonVerde' type='submit' value='Continuar' />
</form>";
if($retorno=='inserir'){
	echo "<a href=\"ciWItensExclusivos.php\"><img src='imagens/botaoVoltar.png'></a>";
	}else{
		echo "<a href=\"ciWItensExclusivosAt.php\"><img src='imagens/botaoVoltar.png'></a>";
		}
?>
</div>
</body>
</html>