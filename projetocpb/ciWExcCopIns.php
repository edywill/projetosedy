<?php 
session_start();
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
<body onKeyDown="javascript:return bloqueioTeclas();" onLoad="prettyPrint();">
<div id='box3'>
<br/><strong>CIWEB  - Selecionar Benefici&aacute;rios:</strong><br/><br/>
<?php
//include "mb.php";
require "conectsqlserverci.php";
require('conexaomysql.php');
$rpa=0;
$diaria=0;
$passagem=0;
$hotel=0;
$retornar='ciWExcCop.php';
if(!empty($_POST['solicitacao'])){
$sequencia=$_POST['sequencia'];
$solicitacao=$_POST['solicitacao'];
$usuario=$_POST['usuario'];
$retorno=$_POST['retorno'];
$tipo=trim($_POST['tipo']);
$origem=$_POST['referencia'];
$_SESSION['sequenciaMult']=$sequencia;
$_SESSION['solicitacaoMult']=$solicitacao;
$_SESSION['usuarioMult']=$usuario;
$_SESSION['retornoMult']=$retorno;
$_SESSION['tipoMult']=$tipo;
$_SESSION['origemMult']=$origem;
$_SESSION['inicioRpaCp']='';
$_SESSION['inicioDiaCp']='';
$_SESSION['inicioPasCp']='';
$_SESSION['inicioHotCp']='';
$_SESSION['fimRpaCp']='';
$_SESSION['fimDiaCp']='';
$_SESSION['fimPasCp']='';
$_SESSION['fimHotCp']='';
$_SESSION['vlRpaCp']='';
$_SESSION['vlDiaCp']='';
$_SESSION['vlPasCp']='';
$_SESSION['horaInicioCp']='';
$_SESSION['minutoInicioCp']='';
$_SESSION['horaFimCp']='';
$_SESSION['minutoFimCp']='';
$_SESSION['obsPasCp']='';
$_SESSION['trechoCp']='';
}else{
$sequencia=$_SESSION['sequenciaMult'];
$solicitacao=$_SESSION['solicitacaoMult'];
$usuario=$_SESSION['usuarioMult'];
$retorno=$_SESSION['retornoMult'];
$tipo=$_SESSION['tipoMult'];
$origem=$_SESSION['origemMult'];
	}
if($tipo=='0' || $origem=='0'){
					?>
       <script type="text/javascript">
       alert("Erro[1]: Informe a origem e destino dos dados.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	}elseif($tipo==$origem){
		?>
       <script type="text/javascript">
       alert("As op\u00e7\u00f5es s\u00e3o iguais.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
		}
echo "<form action='ciWExcCopFinal.php' method='post' style='margin:20px 0'>
 <strong>CI N&ordm;: <font size='3' color='red'>".$solicitacao."</strong></font><br>
	  Item: ".$sequencia."<br><br>
      <input class='input' name='retorno' id='retorno' type='hidden' size='8' value='".$retorno."'  />
	  <input class='input' name='sequencia' id='sequencia' type='hidden' size='8' value='".$sequencia."'  />
	  <input class='input' name='solicitacao' id='solicitacao' type='hidden' size='8' value='".$solicitacao."'  />
	  <input class='input' name='usuario' id='usuario' type='hidden' size='8' value='".$usuario."'  />
   	  <input name='tipoIns' type='hidden' value='".$tipo."'/>";
echo "<div id='tabela'>";
$colspan=3;
$dtInicio='';
$dtFim='';
$valor=0;
$cadeiranteTit='';
if($tipo=='passagem'){
	$colspan=4;
	$cadeiranteTit="<th width='10%'>Cadeirante</th>";
	}elseif($tipo=='hotel'){
		$colspan=4;
		$cadeiranteTit="<th width='10%'>R.L.</th>";
		}
echo "<table border='1' width='100%'><tr><th colspan='".$colspan."'>Escolha quais deseja copiar</th><tr>
<tr><th width='10%'>Selecione</th><th width='50%'>Nome</th><th width='40%'>Cargo<font size='-2' color='white'><br/>*Preencher campo somente se quiser alterar o cargo para essa solicita&ccedil;&atilde;o.</font></th>".$cadeiranteTit."</tr>";
$empresaCd='';
$dtEnt='';
$dtSaida='';
if($origem=='rpa'){
	$sql=odbc_exec($conCab,"Select
  TEITEMSOLRPA.cd_solicitacao,
  TEITEMSOLRPA.sequencia,
  TEITEMSOLRPA.cd_empresa,
  TEITEMSOLRPA.dt_inicio,
  TEITEMSOLRPA.dt_fim,
  TEITEMSOLRPA.valor,
  TEITEMSOLRPA.cargo,
  GEEMPRES.Nome_completo,
  GEPFISIC.Cargo As Cargo1
From
  TEITEMSOLRPA With(NoLock) Inner Join
  GEEMPRES With(NoLock) On TEITEMSOLRPA.cd_empresa = GEEMPRES.Cd_empresa
  Inner Join
  GEPFISIC with(nolock) On GEEMPRES.Cd_empresa = GEPFISIC.Cd_empresa
WHERE TEITEMSOLRPA.cd_solicitacao='".$solicitacao."'");
$empresaCd='cd_empresa';
$dtEnt='dt_inicio';
$dtSaida='dt_fim';
}elseif($origem=='diaria'){
	$sql=odbc_exec($conCab,"Select
  GEEMPRES.Nome_completo,
  TEITEMSOLDIARIAVIAGEM.solicitacao,
  TEITEMSOLDIARIAVIAGEM.sequencia,
  TEITEMSOLDIARIAVIAGEM.dt_inicio,
  TEITEMSOLDIARIAVIAGEM.dt_termino,
  TEITEMSOLDIARIAVIAGEM.valor,
  TEITEMSOLDIARIAVIAGEM.cargo,
  TEITEMSOLDIARIAVIAGEM.empresa,
  GEPFISIC.Cargo As Cargo1
From
  GEEMPRES With(NoLock) Inner Join
  TEITEMSOLDIARIAVIAGEM With(NoLock) On TEITEMSOLDIARIAVIAGEM.empresa =
    GEEMPRES.Cd_empresa Inner Join
  GEPFISIC with(nolock) On GEEMPRES.Cd_empresa = GEPFISIC.Cd_empresa
WHERE TEITEMSOLDIARIAVIAGEM.solicitacao='".$solicitacao."'") or die("<p>".odbc_errormsg());
	$empresaCd='empresa';
$dtEnt='dt_inicio';
$dtSaida='dt_termino';
	}elseif($origem=='hotel'){
	$sql=odbc_exec($conCab,"Select
  TEITEMSOLHOTEL.cd_solicitacao,
  TEITEMSOLHOTEL.sequencia,
  TEITEMSOLHOTEL.cd_empresa,
  TEITEMSOLHOTEL.dt_saida,
  TEITEMSOLHOTEL.dt_entrada,
  TEITEMSOLHOTEL.cargo,
  GEEMPRES.Nome_completo,
  GEPFISIC.Cargo As Cargo1
From
  TEITEMSOLHOTEL With(NoLock) Inner Join
  GEEMPRES With(NoLock) On TEITEMSOLHOTEL.cd_empresa = GEEMPRES.Cd_empresa
  Inner Join
  GEPFISIC with(nolock) On GEEMPRES.Cd_empresa = GEPFISIC.Cd_empresa
WHERE TEITEMSOLHOTEL.cd_solicitacao='".$solicitacao."'");
	$empresaCd='cd_empresa';
	$dtEnt='dt_entrada';
	$dtSaida='dt_saida';
	}elseif($origem=='passagem'){
	$sql=odbc_exec($conCab,"Select
  GEEMPRES.Nome_completo,
  TEITEMSOLPASSAGEM.cd_solicitacao,
  TEITEMSOLPASSAGEM.sequencia,
  TEITEMSOLPASSAGEM.cd_empresa,
  TEITEMSOLPASSAGEM.dt_partida,
  TEITEMSOLPASSAGEM.dt_chegada,
  TEITEMSOLPASSAGEM.valor,
  TEITEMSOLPASSAGEM.cargo,
  GEPFISIC.Cd_empresa As Cd_empresa1,
  GEPFISIC.Cargo As Cargo1,
  GEEMPRES.Cd_empresa As Cd_empresa2
From
  GEEMPRES With(NoLock) Inner Join
  TEITEMSOLPASSAGEM With(NoLock) On TEITEMSOLPASSAGEM.cd_empresa =
    GEEMPRES.Cd_empresa Inner Join
  GEPFISIC With(NoLock) On GEPFISIC.Cd_empresa = GEEMPRES.Cd_empresa
WHERE TEITEMSOLPASSAGEM.cd_solicitacao='".$solicitacao."'");
	$empresaCd='cd_empresa';
	$dtEnt='dt_partida';
	$dtSaida='dt_chegada';
	}
$cargo='';	
if($tipo=='rpa'){ 
$contagem=0;
 while($obj=odbc_fetch_object($sql)){
	 if(empty($obj->cargo)){
		 $cargo=$obj->Cargo1;
		 }else{
			 $cargo=$obj->cargo;
			 }
	echo "<tr><td><input type='checkbox' name='id".$contagem."' checked value='".$obj->$empresaCd."'/></td><td>".mb_convert_encoding($obj->Nome_completo,"UTF-8","ISO-8859-1")."</td><td><input type='text' class='input' name='cargo".$contagem."' value='".mb_convert_encoding($cargo,"UTF-8","ISO-8859-1")."' size='40'/><br></td></tr>";
	$dtInicio=date("d/m/Y", strtotime($obj->$dtEnt));
	if($obj->$dtSaida=='' || $obj->$dtSaida=='0000-00-00' || $obj->$dtSaida=='null'){
		$dtFim='';
	}else{
		$dtFim=date("d/m/Y", strtotime($obj->$dtSaida));
		}
	  if($origem=='hotel'){
		  $valor='';
		  }else{
	  $valor=number_format($obj->valor, 2, ',', '.');
		  }
      $contagem++;
	  }
	}elseif($tipo=='diaria'){	
 $contagem=0;
 while($obj=odbc_fetch_object($sql)){
	if(empty($obj->cargo)){
		 $cargo=$obj->Cargo1;
		 }else{
			 $cargo=$obj->cargo;
			 }
	echo "<tr><td><input type='checkbox' name='id".$contagem."' checked value='".$obj->$empresaCd."'/></td><td>".mb_convert_encoding($obj->Nome_completo,"UTF-8","ISO-8859-1")."</td><td><input type='text' class='input' name='cargo".$contagem."' value='".mb_convert_encoding($cargo,"UTF-8","ISO-8859-1")."' size='40'/><br></td></tr>";
	$dtInicio=date("d/m/Y", strtotime($obj->$dtEnt));
	if($obj->$dtSaida=='' || $obj->$dtSaida=='0000-00-00' || $obj->$dtSaida=='null'){
		$dtFim='';
	}else{
		$dtFim=date("d/m/Y", strtotime($obj->$dtSaida));
		}
	 if($origem=='hotel'){
		  $valor='';
		  }else{
	  $valor=number_format($obj->valor, 2, ',', '.');
		  }
      $contagem++;
	  }
	}elseif($tipo=='hotel'){
 $contagem=0;
 while($obj=odbc_fetch_object($sql)){
	if(empty($obj->cargo)){
		 $cargo=$obj->Cargo1;
		 }else{
			 $cargo=$obj->cargo;
			 }
	echo "<tr><td><input type='checkbox' name='id".$contagem."' checked value='".$obj->$empresaCd."'/></td><td>".mb_convert_encoding($obj->Nome_completo,"UTF-8","ISO-8859-1")."</td><td><input type='text' class='input' name='cargo".$contagem."' value='".mb_convert_encoding($cargo,"UTF-8","ISO-8859-1")."' size='40'/><br></td><td><input type='text' class='input' name='rlHot".$contagem."' value='' size='25' onkeyup=\"somenteNumeros(this)\" maxlenght='10'/></td></tr>";
	$dtInicio=date("d/m/Y", strtotime($obj->$dtEnt));
	if($obj->$dtSaida=='' || $obj->$dtSaida=='0000-00-00' || $obj->$dtSaida=='null' || $obj->$dtSaida=='1900-01-01 00:00:00.000'){
		$dtFim='';
	}else{
		$dtFim=date("d/m/Y", strtotime($obj->$dtSaida));
		}
      $contagem++;
	  }
	}elseif($tipo=='passagem'){
 $contagem=0;
 while($obj=odbc_fetch_object($sql)){
	 if(empty($obj->cargo)){
		 $cargo=$obj->Cargo1;
		 }else{
			 $cargo=$obj->cargo;
			 }
	echo "<tr><td><center><input type='checkbox' name='id".$contagem."' checked value='".$obj->$empresaCd."'/></center></td><td>".mb_convert_encoding($obj->Nome_completo,"UTF-8","ISO-8859-1")."</td><td><input type='text' class='input' name='cargo".$contagem."' value='".mb_convert_encoding($cargo,"UTF-8","ISO-8859-1")."' size='40'/><br></td><td><center><input type='checkbox' name='cadeirante".$contagem."' value='1'/></center></td></tr>";
	$dtInicio=date("d/m/Y", strtotime($obj->$dtEnt));
	if($obj->$dtSaida=='' || $obj->$dtSaida=='0000-00-00' || $obj->$dtSaida=='null'){
		$dtFim='';
	}else{
		$dtFim=date("d/m/Y", strtotime($obj->$dtSaida));
		}
	 if($origem=='hotel'){
		  $valor='';
		  }else{
	  $valor=number_format($obj->valor, 2, ',', '.');
		  }
      $contagem++;
	  }
	}
echo "<input class='input' name='contagem' id='tipo' type='hidden' size='20' value='".$contagem."'/></table>";
echo "<table border='1'>";

if($tipo=='rpa'){
	if(empty($_POST['solicitacao'])){
	$dtInicio=$_SESSION['inicioRpaCp'];
	$dtFim=$_SESSION['fimRpaCp'];
	$valor=$_SESSION['vlRpaCp'];
	}
	echo "<input class='input' name='tipo' id='tipo' type='hidden' size='20' value='rpa'/><br><br><table border='1'>
		  <tr><th colspan='2'><strong>Dados B&aacute;sicos: RPA - Recibo Pagamento Aut&ocirc;nomo</strong></th></tr>
  <tr><td>
	<strong>In&iacute;cio:</strong></td><td><input readonly class='input' name='inicioRpa' id='inicioRpa' type='text' size='10' maxlength='10' value='".$dtInicio."' OnKeyPress=\"formatar(this, '##/##/####')\" />
  </td></tr>
  <tr><td>
	<strong>Fim:</strong></td><td><input readonly class='input' name='fimRpa' id='fimRpa' type='text' size='10' maxlength='10' value='".$dtFim."' OnKeyPress=\"formatar(this, '##/##/####')\" />
  </td></tr>
  <tr><td>
  <strong>Valor Unit&aacute;rio:</strong></td><td><input class='input' name='valorRpa' id='valorRpa' type='text' size='10' value='".$valor."' maxlength='11'/><br />
  </td></tr>
  </table>";
	}elseif($tipo=='diaria'){
		if(empty($_POST['solicitacao'])){
	$dtInicio=$_SESSION['inicioDiaCp'];
	$dtFim=$_SESSION['fimDiaCp'];
	$valor=$_SESSION['vlDiaCp'];
	}
		echo "<br><br><input class='input' name='tipo' id='tipo' type='hidden' size='20' value='diaria'/><table border='1'>
		  <tr><th colspan='2'><strong>Dados B&aacute;sicos: Di&aacute;ria / Aux&iacute;lio Viagem</strong></th></tr>
  <tr><td>
	<strong>In&iacute;cio:</strong></td><td><input readonly class='input' name='inicioDia' id='inicioDia' type='text' size='10' maxlength='10' value='".$dtInicio."' OnKeyPress=\"formatar(this, '##/##/####')\" />
  </td></tr>
  <tr><td>
	<strong>Fim:</strong></td><td><input class='input' readonly name='fimDia' id='fimDia' type='text' size='10' maxlength='10' value='".$dtFim."' OnKeyPress=\"formatar(this, '##/##/####')\" />
  </td></tr>
  <tr><td>
  <strong>Valor Unit&aacute;rio:</strong></td><td><input class='input' name='valorDia' id='valorDia' type='text' size='10' value='".$valor."' maxlength='11'/><br />
  </td></tr>
  </table>";
		}elseif($tipo=='passagem'){
			$horaPtPas='';
			$minutoPtPas='';
			$horaRetPas='';
			$minutoRetPas='';
			$trecho='';
			$obs='';
			if(empty($_POST['solicitacao'])){
				$dtInicio=$_SESSION['inicioPasCp'];
				$dtFim=$_SESSION['fimPasCp'];
				$valor=$_SESSION['vlPasCp'];
				$horaPtPas=$_SESSION['horaInicioCp'];
				$minutoPtPas=$_SESSION['minutoInicioCp'];
				$horaRetPas=$_SESSION['horaFimCp'];
				$minutoRetPas=$_SESSION['minutoFimCp'];
				$trecho=$_SESSION['trechoCp'];
				$obs=$_SESSION['obsPasCp'];
			}
			echo "<br><br><input class='input' name='tipo' id='tipo' type='hidden' size='20' value='passagem'/><table border='1'>
		  <div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><th colspan='2'><strong>Dados B&aacute;sicos: Passagens</strong></th></tr>
  <tr><td>
	<strong><font color=red>*</font>Dt. Partida:</strong></td><td><input class='input' readonly name='inicioPas' id='inicioPas' type='text' size='12' maxlength='10' value='".$dtInicio."' OnKeyPress=\"formatar(this, '##/##/####')\" />
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Hora de Partida:</strong></td><td><input class='input' name='horaPtPas' id='horaPtPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2' value='".$horaPtPas."'/>:<input class='input' name='minutoPtPas' id='minutoPtPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2' value='".$minutoPtPas."'/><br />
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Dt. Retorno:</strong></td><td><input class='input' readonly name='fimPas' id='fimPas' type='text' size='12' maxlength='10' value='".$dtFim."' OnKeyPress=\"formatar(this, '##/##/####')\" />
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Hora de Retorno:</strong></td><td><input class='input' name='horaRetPas' id='horaRetPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2' value='".$horaRetPas."'/>:<input class='input' name='minutoRetPas' id='minutoRetPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2' value='".$minutoRetPas."'/><br />
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor Unit&aacute;rio:</strong></td><td><input class='input' name='valorPas' id='valorPas' type='text' size='12' value='".$valor."' maxlength='11'/><br />
  </td></tr>
  <tr><td>
  <strong>Trecho:</strong></td><td><input class='input' name='trechoPas' id='trechoPas' type='text' size='20' maxlength='500' value='".$trecho."'/><br />
  </td></tr>
  <tr><td>
  <strong>Observa&ccedil;&atilde;o:</strong></td><td><input class='input' name='obsPas' id='obs' type='text' size='20' maxlength='500' value='".$obs."'/><br />
  </td></tr>
  </table>";
			}elseif($tipo=='hotel'){
				if(empty($_POST['solicitacao'])){
				   $dtInicio=$_SESSION['inicioHotCp'];
				   $dtFim=$_SESSION['fimHotCp'];
				   }
				echo "<br><br><input class='input' name='tipo' id='tipo' type='hidden' size='20' value='hotel'/><table border='1'>
		  <tr><th colspan='2'><strong>Dados B&aacute;sicos: Hotel</strong></th></tr>
  <tr><td>
	<strong>Dt. In&iacute;cio:</strong></td><td><input class='input' readonly name='inicioHot' id='inicioHot' type='text' size='10' value='".$dtInicio."' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" />
  </td></tr>
  <tr><td>
	<strong>Dt. Fim:</strong></td><td><input class='input' name='fimHot' readonly id='fimHot' type='text' size='10' maxlength='10' value='".$dtFim."' OnKeyPress=\"formatar(this, '##/##/####')\" />
  </td></tr>
  </table>";
				}	
 
 echo "</div><br><br>
   <input type='submit' class='buttonVerde' value='Cadastrar' />"; 
echo "</form><br><br><a href=\"ciWExcCop.php\"><img src='imagens/botaoVoltar.png'></a></body>";
?>
</div>
</body>
</html>