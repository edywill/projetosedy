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
$_SESSION['inicioRpaMx']='';
$_SESSION['inicioDiaMx']='';
$_SESSION['inicioPasMx']='';
$_SESSION['inicioHotMx']='';
$_SESSION['fimRpaMx']='';
$_SESSION['fimDiaMx']='';
$_SESSION['fimPasMx']='';
$_SESSION['fimHotMx']='';
$_SESSION['vlRpaMx']='';
$_SESSION['vlDiaMx']='';
$_SESSION['vlPasMx']='';
$_SESSION['horaInicioMx']='';
$_SESSION['minutoInicioMx']='';
$_SESSION['horaFimMx']='';
$_SESSION['minutoFimMx']='';
$_SESSION['obsPasMx']='';
$_SESSION['trechoMx']='';
require "conexaomysql.php";
mysql_query("DELETE FROM cimulttemp WHERE ci='".$solicitacao."' AND seq='".$sequencia."'");
}else{
$sequencia=$_SESSION['sequenciaMult'];
$solicitacao=$_SESSION['solicitacaoMult'];
$usuario=$_SESSION['usuarioMult'];
$retorno=$_SESSION['retornoMult'];
$tipo=$_SESSION['tipoMult'];
mysql_query("DELETE FROM cimulttemp WHERE ci='".$solicitacao."' AND seq='".$sequencia."'");
	}
$nova=0;
  $hotel=0;
  $passagem=0;
  $diaria=0;
  $rpa=0;
  $sqlConsRPA="SELECT * FROM
			   TEITEMSOLRPA (nolock)
			   WHERE
			   cd_solicitacao=".$solicitacao." AND
			   sequencia=".$sequencia."";
  $rsConsRPA = odbc_exec($conCab,$sqlConsRPA) or die(odbc_error());
  $contConsRPA=odbc_num_rows($rsConsRPA);
  if($contConsRPA==0){
			  $sqlConsDiaria="SELECT * FROM
			   TEITEMSOLDIARIAVIAGEM (nolock)
			   WHERE
			   solicitacao=".$solicitacao." AND
			   sequencia=".$sequencia."";
			  $rsConsDiaria = odbc_exec($conCab,$sqlConsDiaria) or die(odbc_error());
			  $contConsDiaria=odbc_num_rows($rsConsDiaria);
			  if($contConsDiaria==0){
				  $sqlConsPassagem="SELECT * FROM
			   TEITEMSOLPASSAGEM (nolock)
			   WHERE
			   cd_solicitacao=".$solicitacao." AND
			   sequencia=".$sequencia."";
				  $rsConsPassagem = odbc_exec($conCab,$sqlConsPassagem) or die(odbc_error());
				  $contConsPassagem=odbc_num_rows($rsConsPassagem);
					   if($contConsPassagem==0){
						  $sqlConsHotel="SELECT * FROM
			   TEITEMSOLHOTEL (nolock)
			   WHERE
			   cd_solicitacao=".$solicitacao." AND
			   sequencia=".$sequencia."";
						  $rsConsHotel = odbc_exec($conCab,$sqlConsHotel) or die(odbc_error());
						  $contConsHotel=odbc_num_rows($rsConsHotel);
						  if($contConsHotel==0){
							  $nova=1;
							  }else{
								  $hotel=1;
								  }
					   }else{
						   $passagem=1;
						   }
			  }else{
				  $diaria=1;
				  }
  }else{
	  $rpa=1;
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
  <link rel="stylesheet" href="jqueryDown/jquery-ui.css" />
<script src="jqueryDown/jquery-1.8.2.js"></script> 
<script src="jqueryDown/jquery-1.9.0-ui.js"></script>
<script src="jqueryDown/jquery-ui.js"></script>
<link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> 
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
		  var er = /[^0-9.,]/;
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
echo "<form action='ciWExcMultInsdatatable.php' method='post'>
	  <strong>CI N&ordm; <font size='3' color='red'>".$solicitacao."</font></strong><br />
	
	  Item: ".$sequencia."<br><br><br>
	  <input class='input' name='retorno' id='retorno' type='hidden' size='8' value='".$retorno."'  />
	  <input class='input' name='sequencia' id='sequencia' type='hidden' size='8' value='".$sequencia."'  />
	  <input class='input' name='solicitacao' id='solicitacao' type='hidden' size='8' value='".$solicitacao."'  />
	  <input class='input' name='usuario' id='usuario' type='hidden' size='8' value='".$usuario."'  />";
if($nova==1){
	   $contador=1;
   echo "<strong><font size='+0,5'>CADASTRAR NOVO ITEM EXCLUSIVO</font></strong><br /><br />";
	  echo"<table border='0'>
	   <input class='input' name='tipo' id='tipo' type='hidden' size='20' value='".$tipo."'/>
		<input name='tipoSelect' type='hidden' value='".$tipo."'>
		</tr></table>";
	if($tipo=='rpa'){
	echo "<table border='0'>
		<tr><td colspan='2'><strong><font size='+1'>RPA - Recibo Pagamento Aut&ocirc;nomo</font></strong></td></tr>
	<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>	  
  <tr><td>
	<strong><font color=red>*</font>In&iacute;cio:</strong></td><td><input class='input' readonly name='inicioRpa' id='inicioRpa' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['inicioRpaMx']."' />
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Fim:</strong></td><td><input class='input' name='fimRpa' readonly id='fimRpa' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['fimRpaMx']."'/>
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor Unit&aacute;rio:</strong></td><td><input class='input' name='valorRpa' id='valorRpa' type='text' size='10' maxlength='11' onkeyup=\"somenteNumeros(this)\" value='".$_SESSION['vlRpaMx']."'/><br />
  </td></tr>
  </table>";
		 }elseif($tipo=='diaria'){
		  echo "<table border='0'>
		  <tr><td colspan='2'><strong><font size='+1'>DI&Aacute;RIAS/AUX&Iacute;LIO VIAGEM</font></strong></td></tr>
	<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td>
	<strong><font color=red>*</font>In&iacute;cio:</strong></td><td><input class='input' name='inicioDia' readonly id='inicioDia' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['inicioDiaMx']."'/>
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Fim:</strong></td><td><input class='input' name='fimDia' id='fimDia' readonly type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['fimDiaMx']."'/>
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor Unit&aacute;rio:</strong></td><td><input class='input' name='valorDia' id='valorDia' type='text' size='8' onkeyup=\"somenteNumeros(this)\" maxlength='11' value='".$_SESSION['vlDiaMx']."'/><br />
  </td></tr>
  </table>";
		 }elseif($tipo=='passagem'){
		  echo "<table border='0'>
		  <tr><td colspan='2'><strong><font size='+1'>PASSAGENS</font></strong></td></tr>
		  <div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td>
	<strong><font color=red>*</font>Dt. Partida:</strong></td><td><input class='input' readonly name='inicioPas' id='inicioPas' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['inicioPasMx']."'/>
<span style='padding-left:35px'>
  <strong><font color=red>*</font>Hora de Partida:</strong><input class='input' name='horaPtPas' id='horaPtPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2' value='".$_SESSION['horaInicioMx']."'/>:<input class='input' name='minutoPtPas' id='minutoPtPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2' value='".$_SESSION['minutoInicioMx']."'/><br />
  </td></tr>
  <tr><td>
	<strong>Dt. Retorno:</strong></td><td><input class='input' readonly name='fimPas' id='fimPas' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['fimPasMx']."' />
<span style='padding-left:34px'>
  <strong>Hora de Retorno:</strong><input class='input' name='horaRetPas' id='horaRetPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2' value='".$_SESSION['horaFimMx']."'/>:<input class='input' name='minutoRetPas' id='minutoRetPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2' value='".$_SESSION['minutoFimMx']."'/><br />
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor Unit&aacute;rio:</strong></td><td><input class='input' name='valorPas' id='valorPas' type='text' size='10' onkeyup=\"somenteNumeros(this)\" maxlength='11' value='".$_SESSION['vlPasMx']."'/><br />
  </td></tr>
  <tr><td>
  <strong>Trecho:</strong</td><td><input class='input' name='trechoPas' id='trechoPas' type='text' size='20' maxlength='500' value='".$_SESSION['trechoMx']."'/><br />
  </td></tr>
  <tr><td>
  <strong>Observa&ccedil;&atilde;o:</strong></td><td><input class='input' name='obsPas' id='obs' type='text' size='20' maxlength='500' value='".$_SESSION['obsPasMx']."'/><br />
  </td></tr>
  
  </table>";
		 }elseif($tipo=='hotel'){
		  echo "<table border='0'>
		  <tr><td colspan='2'><strong><font size='+1'>HOSPEDAGEM</font></strong></td></tr>
	<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
  <tr><td>
	<strong><font color=red>*</font>Dt. In&iacute;cio:</strong></td><td><input class='input' readonly name='inicioHot' id='inicioHot' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['inicioHotMx']."'/>
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Dt. Fim:</strong></td><td><input class='input' name='fimHot' readonly id='fimHot' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['fimHotMx']."'/>
  </td></tr>
  </table>";
		 }
		  echo "<tr><td><input name='atJus' class='buttonVerde' type='submit' value='Cadastrar' /></td></tr></table>";
}elseif($rpa==1){
	
	echo "<input class='input' name='tipo' id='tipo' type='hidden' size='20' value='rpa'/><br><br><table border='0'>
		  <tr><td colspan='2'><strong><font size='+1'>RPA - Recibo Pagamento Aut&ocirc;nomo</font></strong></td></tr>
	<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
  <tr><td>
	<strong><font color=red>*</font>In&iacute;cio:</strong></td><td><input class='input' readonly name='inicioRpa' id='inicioRpa' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['inicioRpaMx']."' />
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Fim:</strong></td><td><input class='input' name='fimRpa' readonly id='fimRpa' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['fimRpaMx']."'/>
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor Unit&aacute;rio:</strong></td><td><input class='input' name='valorRpa' id='valorRpa' type='text' size='10' maxlength='11' onkeyup=\"somenteNumeros(this)\" value='".$_SESSION['vlRpaMx']."'/><br />
  </td></tr>
  <tr><td colspan='2'><input name='atJus' class='buttonVerde' type='submit' value='Escolher Benefici&aacute;rios' /></td></tr>
  </table>";
	}elseif($diaria==1){
		echo "<br><br><input class='input' name='tipo' id='tipo' type='hidden' size='20' value='diaria'/><table border='0'>
		  <tr><td colspan='2'><strong><font size='+1'>DI&Aacute;RIA / AUX&Iacute;LIO VIAGEM</font></strong></td></tr>
	<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
  <tr><td>
	<strong><font color=red>*</font>In&iacute;cio:</strong></td><td><input class='input' name='inicioDia' readonly id='inicioDia' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['inicioDiaMx']."'/>
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Fim:</strong></td><td><input class='input' name='fimDia' id='fimDia' readonly type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['fimDiaMx']."'/>
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor Unit&aacute;rio:</strong></td><td><input class='input' name='valorDia' id='valorDia' type='text' size='8' onkeyup=\"somenteNumeros(this)\" maxlength='11' value='".$_SESSION['vlDiaMx']."'/><br />
  </td></tr>
  <tr><td colspan='2'><input name='atJus' class='buttonVerde' type='submit' value='Escolher Benefici&aacute;rios' /></td></tr>
  </table>";
		}elseif($passagem==1){
			echo "<br><br><input class='input' name='tipo' id='tipo' type='hidden' size='20' value='passagem'/><table border='0'>
		  <tr><td colspan='2'><strong><font size='+1'>PASSAGENS</font></strong></td></tr>
		  <div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
  <tr><td>
	<strong><font color=red>*</font>Dt. Partida:</strong></td><td><input class='input' readonly name='inicioPas' id='inicioPas' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['inicioPasMx']."'/>
<span style='padding-left:35px'>
  <strong><font color=red>*</font>Hora de Partida:</strong><input class='input' name='horaPtPas' id='horaPtPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2' value='".$_SESSION['horaInicioMx']."'/>:<input class='input' name='minutoPtPas' id='minutoPtPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2' value='".$_SESSION['minutoInicioMx']."'/><br />
  </td></tr>
  <tr><td>
	<strong>Dt. Retorno:</strong></td><td><input class='input' readonly name='fimPas' id='fimPas' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['fimPasMx']."' />
<span style='padding-left:34px'>
  <strong>Hora de Retorno:</strong><input class='input' name='horaRetPas' id='horaRetPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2' value='".$_SESSION['horaFimMx']."'/>:<input class='input' name='minutoRetPas' id='minutoRetPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2' value='".$_SESSION['minutoFimMx']."'/><br />
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor Unit&aacute;rio:</strong></td><td><input class='input' name='valorPas' id='valorPas' type='text' size='10' onkeyup=\"somenteNumeros(this)\" maxlength='11' value='".$_SESSION['vlPasMx']."'/><br />
  </td></tr>
  <tr><td>
  <strong>Trecho:</strong</td><td><input class='input' name='trechoPas' id='trechoPas' type='text' size='20' maxlength='500' value='".$_SESSION['trechoMx']."'/><br />
  </td></tr>
  <tr><td>
  <strong>Observa&ccedil;&atilde;o:</strong></td><td><input class='input' name='obsPas' id='obs' type='text' size='20' maxlength='500' value='".$_SESSION['obsPasMx']."'/><br />
  </td></tr>
  <tr><td><input name='atJus' class='buttonVerde' type='submit' value='Escolher Passageiros' /></td></tr>
  </table>";
			}elseif($hotel==1){
				echo "<br><br><input class='input' name='tipo' id='tipo' type='hidden' size='20' value='hotel'/><table border='0'>
		  <tr><td colspan='2'><strong><font size='+1'>HOSPEDAGEM</font></strong></td></tr>
	<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
  <tr><td>
	<strong><font color=red>*</font>Dt. In&iacute;cio:</strong></td><td><input class='input' readonly name='inicioHot' id='inicioHot' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['inicioHotMx']."'/>
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Dt. Fim:</strong></td><td><input class='input' name='fimHot' readonly id='fimHot' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['fimHotMx']."'/>
  </td></tr>
  <tr><td><input name='atJus' class='buttonVerde' type='submit' value='Escolher H&oacute;spedes' /></td></tr>
  </table>";
				}
echo "</form>";
if($retorno=='inserir'){
	echo "<a href=\"ciWItensExclusivos.php\"><img src='imagens/botaoVoltar.png'></a>";
	}else{
		echo "<a href=\"ciWItensExclusivosAt.php\"><img src='imagens/botaoVoltar.png'></a>";
		}

?>
</div>
</body>
</html>