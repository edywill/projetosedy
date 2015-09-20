<?php 
session_start();
require "../conectsqlserver.php";
require "conectsqlserversav.php";
require "../conect.php";
$idFunc=$_SESSION['idFuncSav'];
$nomeSav=$_SESSION['nomeSav'];
$titulo=$_SESSION['tituloSav'];
$valida=0;
$countError=0;
$errorMsg='';
$cgeren='';
$_SESSION['dadosDiaSav']='';
$tipoSav=$_SESSION['tpSav'];
$idCargo=$_SESSION['idCargo'];
$tpFunc=$_SESSION['tpFuncSav'];
$setor=$_SESSION['setorSav'];
$cargo=$_SESSION['cargoSav'];
$abrangencia=$_SESSION['abrangenciaSav'];
$acao=0;
$nautor='';
$qtddias='';
$valordia='';
$numproc='';
$dtida='';
$dtvolta='';
$origemida='';
$origemvolta='';
$cidorigemida='';
$cidorigemvolta='';
$destinoida='';
$destinovolta='';
$ciddestinoida='';
$ciddestinovolta='';
$horarioida='';
$horariovolta='';
$sqlDadosDiaria=mysql_fetch_array(mysql_query("SELECT * FROM savdiarias WHERE idsav='".$_SESSION['numSav']."'"));
if(!empty($sqlDadosDiaria['valortotal'])){
		$nautor=$sqlDadosDiaria['nautor'];
		$anoautor=$sqlDadosDiaria['ano'];
		$qtddias=number_format($sqlDadosDiaria['qtddias'],1,',','.');
		$valordia=number_format($sqlDadosDiaria['valortotal'],2,',','.');
		$numproc=$sqlDadosDiaria['numproc'];
		}else{
			$sqlNumAutMax=mysql_fetch_array(mysql_query("SELECT MAX(nautor)AS autor FROM savdiarias WHERE ano='".date('Y')."'"));
			$nautor=$sqlNumAutMax['autor']+1;
			$anoautor=date('Y');
			$updateDiariasSav=mysql_query("INSERT INTO savdiarias(idsav,nautor,ano) VALUES ('".$_SESSION['numSav']."','".$nautor."','".$anoautor."')");
			}
$novosDadosDiaria=0;
if($_SESSION['passagemSav']<>'sim' && $_SESSION['diariaSav'] <> 'sim' && $_SESSION['transladoSav']<>'sim'){
	$sqlDiarDados=mysql_fetch_array(mysql_query("SELECT * FROM savregistros WHERE id='".$_SESSION['numSav']."'"));
	if(!empty($sqlDiarDados['dtida'])){
		$dtida=$sqlDiarDados['dtida'];
		$dtvolta=$sqlDiarDados['dtvolta'];
		if($_SESSION['abrangenciaSav']=='Nacional'){
	$consultaLocais1="SELECT municipio AS nome FROM municipios WHERE id='".$sqlDiarDados['destinoida']."'";
	}else{
		$consultaLocais1="SELECT nome FROM paises WHERE iso='".$sqlDiarDados['destinoida']."'";
		}
		$queryConsultaLocais1=mysql_query($consultaLocais1);
$executaConsultaLocais1=mysql_fetch_array($queryConsultaLocais1);

		$destinoida=$sqlDiarDados['destinoida']."-".utf8_encode($executaConsultaLocais1['nome']);
		$ciddestinoida=$sqlDiarDados['ciddestinoida'];
		$horariovolta=$sqlDiarDados['horariovolta'];
		}
	$novosDadosDiaria=1;
	$_SESSION['dadosDiaSav']='sim';
	}

if($_SESSION['tpSav']<>'3'){
	$_SESSION['tpSav']='2';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="stylesheet" href="../jqueryDown/jquery-ui.css" />
<script src="../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../jqueryDown/jquery-1.9.0-ui.css" />
<script src="../jqueryDown/jquery-ui.js"></script>
<script src="jquerymensagem/jquery_jui_alert.js"></script>
<link rel="stylesheet" href="../jqueryDown/jquery-ui.css" /> 
<script type='text/javascript' src='../jquery.autocomplete.js'></script>
<script language="javascript" src="script.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../jquery.autocomplete.css" />  
<script type='text/javascript' src='../jquery_price.js'></script>
<script>
  function goBack()
	{
	window.history.back()
	}
  </script>
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
<script>
$(function() {
    $( "#dtida" ).datepicker({dateFormat: 'dd/mm/yy'});
	$( "#dtvolta" ).datepicker({dateFormat: 'dd/mm/yy'});
	$( "#dtida2" ).datepicker({dateFormat: 'dd/mm/yy'});
	$( "#dtvolta2" ).datepicker({dateFormat: 'dd/mm/yy'});
	$( "#dtida4" ).datepicker({dateFormat: 'dd/mm/yy'});
	$( "#dtvolta4" ).datepicker({dateFormat: 'dd/mm/yy'});
	$( "#dtida5" ).datepicker({dateFormat: 'dd/mm/yy'});
	$( "#dtvolta5" ).datepicker({dateFormat: 'dd/mm/yy'});
	$( "#dtida10" ).datepicker({dateFormat: 'dd/mm/yy'});
	$( "#dtvolta10" ).datepicker({dateFormat: 'dd/mm/yy'});
});
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
  <script type="text/javascript">
  	function carregaVolta(){
	  document.getElementById('origemvolta').value=document.getElementById('destinoida').value;
	  document.getElementById('destinovolta').value=document.getElementById('origemida').value;
	  }
  </script>
<script type="text/javascript">
function limita(campo,valor){
		var tamanho = document.form1[campo].value.length;
		var tex=document.form1[campo].value;
	if (tamanho>=valor) {
		document.form1[campo].value=tex.substring(0,valor);
	}
return true;
}
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('#idaevolta').change(function(){
        if(this.value==1)
            $('#retorno').fadeIn('slow');
			//$('#retorno2').fadeIn('slow');
        else
            $('#retorno').fadeOut('slow');
			//$('#retorno2').fadeOut('slow');

    });
});

$(document).ready(function(){
    $('#idaevolta').change(function(){
        if(this.value==1)
            $('#retorno3').fadeIn('slow');
			//$('#retorno2').fadeIn('slow');
        else
            $('#retorno3').fadeOut('slow');
			//$('#retorno2').fadeOut('slow');

    });
});
$(document).ready(function(){
    $('#idaevolta5').change(function(){
       if(this.value==1)
            $('#retorno6').fadeIn('slow');
			//$('#retorno2').fadeIn('slow');
        else
            $('#retorno6').fadeOut('slow');
			//$('#retorno2').fadeOut('slow');

    });
});
$(document).ready(function(){
    $('#idaevolta').change(function(){
        if(this.value==1)
            //$('#retorno').fadeIn('slow');
			$('#retorno2').fadeIn('slow');
        else
            //$('#retorno').fadeOut('slow');
			$('#retorno2').fadeOut('slow');

    });
});
$(document).ready(function(){
    $('#idaevolta').change(function(){
        if(this.value==1)
            //$('#retorno').fadeIn('slow');
			$('#retorno4').fadeIn('slow');
        else
            //$('#retorno').fadeOut('slow');
			$('#retorno4').fadeOut('slow');

    });
});
</script>
   <script type="text/javascript">
$().ready(function() {
	$("#origemida").autocomplete("suggest_local.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
	$("#origemida5").autocomplete("suggest_localNac.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
	$("#origemida10").autocomplete("suggest_localNac.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
	$("#destinoida5").autocomplete("suggest_localNac.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
	$("#destinoida2").autocomplete("suggest_local.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
	$("#origemida4").autocomplete("suggest_local.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
	$("#destinoida4").autocomplete("suggest_local.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
	$("#destinoida").autocomplete("suggest_local.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
	$("#destinoida10").autocomplete("suggest_local.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
});
</script>
<script type="text/javascript">
  $(document).ready(function(){
      $('#valorpass').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
	  $('#valorhos').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
	  $('#idCotacao').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
	  $('#valorpass5').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
	   $('#valorpass4').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  </script>
  <script type="text/javascript">
	$(document).ready(function(){ 
		$("#content div:nth-child(1)").show(); 
			$(".abas li:first div").addClass("selected");				$(".aba").click(function(){ 						
			$(".aba").removeClass("selected");
			$(this).addClass("selected");
		var indice = $(this).parent().index();
		    indice++; 
		    $("#content div").hide(); 
		    $("#content div:nth-child("+indice+")").show();
 		});

		$(".aba").hover( 
			function(){
				$(this).addClass("ativa")},
				function(){$(this).removeClass("ativa")} 
		);	
});

</script>
<script type="text/javascript">
function  reescreveTabelas(){
// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "reescreveDados.php";

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

document.getElementById('mensagens').innerHTML=resposta;
}
}
req.send(null);
	}

</script>
<?php 
if($_SESSION['passagemSav']=='sim' && $_SESSION['diariaSav']=='sim'){
?>
<script type="text/javascript">
  	function carregaVolta(){
		//Verificar se ida e volta e selecionado (se sim colcoar data de ida e data de volta para hospedagem)
		idaevolta=document.getElementById('idaevolta').value;
	  if(idaevolta==1){
		  document.getElementById('dtida2').value=document.getElementById('dtida').value;
		  document.getElementById('dtvolta2').value=document.getElementById('dtvolta').value;
		  }
		  
	  document.getElementById('cidhos').value=document.getElementById('ciddestino').value;
	  document.getElementById('destinoida2').value=document.getElementById('destinoida').value;
	  }
  </script>
<?php 
}else{
	
?>
<script type="text/javascript">
  	function carregaVolta(){
	  }
  </script>
<?php
}
?>
</head>
<body onKeyDown="javascript:return bloqueioTeclas();">
<div id='box3' style="height:auto">
  <h1 id="h1">SAV - Solicita&ccedil;&atilde;o de Aux&iacute;lio Viagem</h1>
  <h2 id="h2"> DADOS COMPLEMENTARES SAV<?php 
  if(!empty($_SESSION['numCiSav'])){
  echo "- CI: ".$_SESSION['numCiSav'];
  
  }else{
	  echo "- Em elabora&ccedil;&atilde;o";
	  }?> </h2>
      
 <table border="0" width="100%">
<tr><td width="10%"><strong>Nome:</strong></td><td width="40%"><?php echo utf8_encode($_SESSION['nomeSav']); ?></td><td width="10%"><strong>Tipo:</strong></td><td width="40%"><?php echo $_SESSION['tpFuncSav']; ?></td></tr>
<tr><td width="10%"><strong>Cargo:</strong></td><td width="40%"><?php echo utf8_encode($cargo); ?></td><td><strong>Setor:</strong></td><td><?php echo utf8_encode($setor); ?></td></tr>
<tr><td><strong>Evento:</strong></td><td colspan="3"><?php echo $_SESSION['eventoSav']; ?></td></tr>
<?php 
if($abrangencia=='Internacional'){
?>
<form action="alteraCotacao.php" name="altcot" method="post">
<tr><td><strong>Cotação do Dólar:</strong></td><td colspan="3"><input type="text" class="input" value="<?php echo $_SESSION['cotacaoDiaSav']; ?>" name="cotacaoDolar" id="cotacao" /><font style="font-size:10px; color:#949292">Data da Cotação: <?php echo $_SESSION['cotacaoDataSav'];?> </font> <input type="submit" name="button" class="button" value="Alterar Cotação" /></td></tr>
</form>
<?php 
}
?>
  </table>
 <br /><br />
<?php 
if($_SESSION['passagemSav']=='sim' || $_SESSION['diariaSav'] == 'sim' ||$_SESSION['transladoSav']=='sim' || trim($_SESSION['diariaSolSav'])=='sim' || $novosDadosDiaria==1){
//echo "ATENÇÃO: As informações complementares abaixo são obrigatórias.<br> Caso necessário, inclua mais de uma informação referente a cada item (Passagem, hospedagem e locação).";	
echo '<div id="mensagens">
<div id="tabela">';
if($_SESSION['passagemSav']=='sim'){
	$complementoInt='';
	if($abrangencia=='Nacional'){
		$abrangTipo=' (SELECT municipio FROM municipios WHERE id=savpassagem.origem) AS origemTrecho, (SELECT municipio FROM municipios WHERE id=savpassagem.destino) AS destinoTrecho ';
		}else{
			$abrangTipo=' (SELECT nome FROM paises WHERE iso=savpassagem.origem) AS origemTrecho, (SELECT nome FROM paises WHERE iso=savpassagem.destino) AS destinoTrecho ';
			$complementoInt=" AND inter='itn'";
			}
	$sqlPassagemConsulta=mysql_query("SELECT savpassagem.id,savpassagem.valor,savpassagem.cadeirante,savpassagem.horarioida,savpassagem.horariovolta,savpassagem.dtida,savpassagem.dtvolta,".$abrangTipo.",savpassagem.tipo,savpassagem.cidorigem,savpassagem.ciddestino FROM savpassagem WHERE savpassagem.idsav='".$_SESSION['numSav']."' ".$complementoInt."");
	$countPassagemConsulta=mysql_num_rows($sqlPassagemConsulta);
	if($countPassagemConsulta>0){	
		echo "<table border='1' width='100%'>
		<tr><th colspan='4'>PASSAGEM AÉREA ".strtoupper($abrangencia)."</th></tr>
		<tr><th width='45%'>Trecho</th><th width='30%'>Datas</th><th width='15%'>Valor</th><th width='10%'>Excluir</th></tr>";
		$trechoPassagem='';
		$datasViagem='';
		while($objPassagemConsulta=mysql_fetch_object($sqlPassagemConsulta)){
			$cadeirante3="";
		if($objPassagemConsulta->cadeirante==1){
			$cadeirante3="*";
			}
		if($objPassagemConsulta->tipo==2){
			if(!empty($objPassagemConsulta->cidorigem)){
			  $trechoPassagem=$cadeirante3.$objPassagemConsulta->cidorigem."-".$objPassagemConsulta->origemTrecho." x ".$objPassagemConsulta->ciddestino."-".$objPassagemConsulta->destinoTrecho." x ".$objPassagemConsulta->cidorigem."-".$objPassagemConsulta->origemTrecho;
			}else{
			  $trechoPassagem=$cadeirante3.$objPassagemConsulta->origemTrecho." x ".$objPassagemConsulta->destinoTrecho." x ".$objPassagemConsulta->origemTrecho;
				}
			$datasViagem=$objPassagemConsulta->dtida."(".strtoupper($objPassagemConsulta->horarioida).") - ".$objPassagemConsulta->dtvolta."(".strtoupper($objPassagemConsulta->horariovolta).")";
		}else{
			if(!empty($objPassagemConsulta->cidorigem)){
			$trechoPassagem=$cadeirante3.$objPassagemConsulta->cidorigem."-".$objPassagemConsulta->origemTrecho." x ".$objPassagemConsulta->ciddestino."-".$objPassagemConsulta->destinoTrecho;	
			}else{
			$trechoPassagem=$cadeirante3.$objPassagemConsulta->origemTrecho." x ".$objPassagemConsulta->destinoTrecho;
			}
			$datasViagem=$objPassagemConsulta->dtida."(".strtoupper($objPassagemConsulta->horarioida).")";
			}
		echo "<tr><td>".utf8_encode($trechoPassagem)."</td><td>".$datasViagem."</td><td>R$ ".$objPassagemConsulta->valor."</td><td align='center'><a href='excluirPassagem.php?id=".$objPassagemConsulta->id."'><img src='css/icone_excluir.png'/></a></td></tr>";	
			}
			echo "</table>";
	}
}
	if(trim($_SESSION['diariaSav'])=='sim'){
	if($abrangencia=='Nacional'){
		$abrangTipo=' (SELECT municipio FROM municipios WHERE id=savhospedagem.destino) AS destinoTrecho ';
		}else{
			$abrangTipo=' (SELECT nome FROM paises WHERE iso=savhospedagem.destino) AS destinoTrecho ';
			}
	$sqlHospedagemConsulta=mysql_query("SELECT savhospedagem.id,savhospedagem.dtida,savhospedagem.dtvolta,".$abrangTipo.",savhospedagem.tipo,savhospedagem.cidhos FROM savhospedagem WHERE savhospedagem.idsav='".$_SESSION['numSav']."'");
	$countHospedagemConsulta=mysql_num_rows($sqlHospedagemConsulta);
	if($countHospedagemConsulta>0){	
		echo "<div id='tabela'><table border='1' width='100%'>
		<tr><th colspan='4'>HOSPEDAGEM</th></tr>
		<tr><th width='45%'>Cidade</th><th width='30%'>Datas</th><th width='15%'>Tipo Quarto</th><th width='10%'>Excluir</th></tr>";
		while($objHospedagemConsulta=mysql_fetch_object($sqlHospedagemConsulta)){
			$destinoTrecho=$objHospedagemConsulta->destinoTrecho;
			if(!empty($objHospedagemConsulta->cidhos)){
				$destinoTrecho=$objHospedagemConsulta->cidhos."-".$objHospedagemConsulta->destinoTrecho;
				}
		echo "<tr><td>".utf8_encode($destinoTrecho)."</td><td>".$objHospedagemConsulta->dtida." - ".$objHospedagemConsulta->dtvolta."</td><td>".$objHospedagemConsulta->tipo."</td><td align='center'><a href='excluirHospedagem.php?id=".$objHospedagemConsulta->id."'><img src='css/icone_excluir.png'></a></td></tr>";	
			}
			echo "</table></div>";
	}
}
if($_SESSION['transladoSav']=='sim'){
	$sqlTransConsulta=mysql_query("SELECT savtranslado.id,savtranslado.valor,savtranslado.dtida,savtranslado.dtvolta FROM savtranslado WHERE savtranslado.idsav='".$_SESSION['numSav']."'");
	$countTransConsulta=mysql_num_rows($sqlTransConsulta);
	if($countTransConsulta>0){	
		echo "<div id='tabela'><table border='1' width='100%'>
		<tr><th colspan='4'>LOCAÇÃO DE VEÍCULO - TRANSPORTE</th></tr>
		<tr><th width='75%'>Datas</th><th width='15%'>Valor</th><th width='10%'>Excluir</th></tr>";
		$datasViagem2='';
		while($objTransConsulta=mysql_fetch_object($sqlTransConsulta)){
		$datasViagem2=$objTransConsulta->dtida." - ".$objTransConsulta->dtvolta."";
		echo "<tr><td>".$datasViagem2."</td><td>R$ ".$objTransConsulta->valor."</td><td align='center'><a href='excluirTranslado.php?id=".$objTransConsulta->id."'><img src='css/icone_excluir.png'></a></td></tr>";	
			}
			echo "</table></div>";
	}
}
$textoComplemento='';
if($_SESSION['passagemSav']=='sim'){
$textoComplemento.='Passagem Aérea';
}

if(trim($_SESSION['diariaSav'])=='sim'){
$textoComplemento.=' - Hospedagem';
}
$translado=0;
if(trim($_SESSION['transladoSav'])=='sim'){
	$textoComplemento.=' - Locação de Veículo';
	}
if(!empty($textoComplemento)){
	echo "Preencha as informações referente aos itens ( ".$textoComplemento.") nas abas abaixo:";
	}
?>
</div>
</div>
<br />


<div id="divResultado"></div>
<br />
<!-- Divisão em abas -->
<div class="TabControl">
	<div id="header">
    	<ul class="abas"> 
        	<?php
if($_SESSION['passagemSav']=='sim'){
		?>
            <li>
            	 <div class="aba">
            		 <span><strong>PASSAGEM AÉREA</strong></span>
                 </div>
            </li>
            <?php
			}
	if(trim($_SESSION['diariaSav'])=='sim'){
		?>
            <li> 
            	<div class="aba">
                	<span><strong>HOSPEDAGEM</strong></span>
                </div> </li>
                 <?php
			}
	if(trim($_SESSION['transladoSav'])=='sim'){
		?>
            <li>
            	<div class="aba">
                	<span><strong>LOCAÇÃO DE VEÍCULO</strong></span>
                </div>
            </li>
            <?php 
	}
	if(trim($_SESSION['diariaSolSav'])=='sim' || $novosDadosDiaria==1){
		?>
            <li>
            	<div class="aba">
                	<span><strong>DIÁRIAS</strong></span>
                </div>
            </li>
            <?php 
	}
			?>
        </ul>
   </div>
   <hr />
 <div id="content">
 
 <?php
if($_SESSION['passagemSav']=='sim'){
		?>
	<div class="conteudo3">
    
    	<form name="passagem" id="passagem" action="inserePassagem.php" method="post" onSubmit="setarCampos(this); enviarForm('inserePassagem.php', campos, 'divResultado'); return false;"> 
        
<h2 id="h2">INSERIR PASSAGEM AÉREA <?php echo strtoupper($abrangencia); ?></h2>
<font size="-1">Ida e Volta </font> 
<select name="idaevolta" id='idaevolta'>
<?php
if($_SESSION['idaeVoltaSav']==1){
		echo '
		<option value="1">SIM</option>
		<option value="0" selected="selected">NÃO</option>';
		}else{
		echo '<option value="1" selected="selected">SIM</option>
		<option value="0">NÃO</option>';
			}
?>
</select>
<br />
<font size="-1">Cadeirante? </font>
<select name="cadeirante" id='cadeirante'>
<?php
if($_SESSION['cadeiranteSav']<>1){
		echo '
		<option value="1">SIM</option>
		<option value="0" selected="selected">NÃO</option>';
		}else{
		echo '<option value="1" selected="selected">SIM</option>
		<option value="0">NÃO</option>';
			}
?>
</select>
<br />

<table border="0" width="100%">
<tr><td width="40%">
<strong>Datas</strong>
<br />
<br />
<table border="0" width="100%">
<tr height='34'><td align="right">
<strong>Ida:</strong></td><td><input type="text" class="input" name="dtida" id="dtida" size="20" readonly value='<?php echo $_SESSION['dtidaSav2']; ?>' style="background: url(css/icone_calendario.png) no-repeat right;"/></td></tr>
<tr height='34'><td align="right">
<div id='retorno'><strong>Volta:</strong></div></td><td><div id='retorno3'><input type="text" class="input" name="dtvolta" id="dtvolta" size="20" readonly value='<?php echo $_SESSION['dtvoltaSav2']; ?>' style="background: url(css/icone_calendario.png) no-repeat right;"/></div>
</td></tr>
</table>

</td><td width="60%">
<strong>Trecho
<?php
echo $abrangencia;
?></strong>
<br><br>
<table border="0" width="100%">
<?php 
if($_SESSION['abrangenciaSav']=='Internacional'){
echo "<tr height='34'><td><strong>Cidade Origem:</strong></td><td> <input type='text' class='input' name='cidorigem' id='cidorigem' size='40' onBlur='carregaVolta()' value='".utf8_encode($_SESSION['cidorigemPasSav'])."' autocomplete='off'/></td></tr>
<tr height='34'><td>
<strong>País </strong>"; 
}else{
	echo "<tr height='34'><td><input type='hidden' class='input' name='cidorigem' id='cidorigem' size='40' onBlur='carregaVolta()' autocomplete='off'/>";
	}
?><strong>Origem:</strong></td><td> <input type="text" class="input" name="origemida" id="origemida" size="30" value='<?php echo $_SESSION['origemidaSav2']; ?>' style="background: url(css/icone_lupa.png) no-repeat right;" autocomplete='off' onBlur='carregaVolta()'/><font style="font-size:10px; color:#949292">(*) Selecione na lista</font>
</td></tr>
<?php 
if($_SESSION['abrangenciaSav']=='Internacional'){

echo "<tr height='34'><td><strong>Cidade Destino:</strong></td><td> <input type='text' class='input' name='ciddestino' id='ciddestino' size='40' onBlur='carregaVolta()' value='".$_SESSION['ciddestinoPasSav']."'/></td></tr>
<tr height='34'><td>
<strong>País</strong> "; 
}else{
	echo "<tr height='34'><td><input type='hidden' class='input' name='ciddestino' id='ciddestino' size='40' onBlur='carregaVolta()'/>";
	}
?><strong>Destino:</strong></td><td> <input type="text" class="input" name="destinoida" id="destinoida" size="30" value='<?php echo $_SESSION['destinoidaSav2']; ?>' style="background: url(css/icone_lupa.png) no-repeat right;" onBlur='carregaVolta()'/><font style="font-size:10px; color:#949292">(*) Selecione na lista</font></td></tr>
</table>
</td></tr><tr><td>
<br /><strong>Horário</strong><br /><br />
<table border="0" width="100%"><tr><td align="right"><strong>Ida:</strong></td><td>
<select name="horarioIda" id='horarioIda'>
<?php 
if(empty($_SESSION['horarioidaSav2']) || $_SESSION['horarioidaSav2']=='0'){
   echo "<option value='0' selected='selected'>Selecione</option>"; 
	echo '<option value="manha">Manhã (4h->12h)</option>
<option value="tarde">Tarde (12h01->18h)</option>
<option value="noite">Noite (18h01->3h59)</option>';
}else{
	if($_SESSION['horarioidaSav2']=='manha'){
		echo '<option value="manha" selected="selected">Manhã (4h->12h)</option>
<option value="tarde">Tarde (12h01->18h)</option>
<option value="noite">Noite (18h01->3h59)</option>';
		}elseif($_SESSION['horarioidaSav2']=='tarde'){
			echo '<option value="manha">Manhã (4h->12h)</option>
<option value="tarde" selected="selected">Tarde (12h01->18h)</option>
<option value="noite">Noite (18h01->3h59)</option>';
			}elseif($_SESSION['horarioidaSav2']=='noite'){
				echo '<option value="manha">Manhã (4h->12h)</option>
<option value="tarde">Tarde (12h01->18h)</option>
<option value="noite" selected="selected">Noite (18h01->3h59)</option>';
				}
	}
?>
</select>
</td></tr>

<tr><td align="right"><div id='retorno2'><strong>Volta:</strong></div></td><td><div id='retorno4'>
<select name="horarioVolta" id='horarioVolta'>
<?php 
if(empty($_SESSION['horariovoltaSav2']) || $_SESSION['horariovoltaSav2']=='0'){
   echo "<option value='0' selected='selected'>Selecione</option>";
   echo '<option value="manha">Manhã (4h->12h)</option>
<option value="tarde">Tarde (12h01->18h)</option>
<option value="noite">Noite (18h01->3h59)</option>';
}else{
	if($_SESSION['horariovoltaSav2']=='manha'){
		echo '<option value="manha" selected="selected">Manhã (4h->12h)</option>
<option value="tarde">Tarde (12h01->18h)</option>
<option value="noite">Noite (18h01->3h59)</option>';
		}elseif($_SESSION['horariovoltaSav2']=='tarde'){
			echo '<option value="manha">Manhã (4h->12h)</option>
<option value="tarde" selected="selected">Tarde (12h01->18h)</option>
<option value="noite">Noite (18h01->3h59)</option>';
			}elseif($_SESSION['horariovoltaSav2']=='noite'){
				echo '<option value="manha">Manhã (4h->12h)</option>
<option value="tarde">Tarde (12h01->18h)</option>
<option value="noite" selected="selected">Noite (18h01->3h59)</option>';
				}
	}
?>
</select></div>
</td></tr>
</table>
</td><td valign="middle">
<strong>Valor:</strong> R$ <input type="text" name="valorpass" id="valorpass" class="input" value='<?php echo $_SESSION['valorPasSav']; ?>'/>
</td></tr>
<tr><td colspan="4" align="center"> <input type="submit" name="ok" class="button" value="Inserir" /></td></tr>
</table>
  </form>
  <br /><br />
  <script>

//Cria a função com os campos para envio via parâmetro

function setarCampos() {
	campos = "origemida="+encodeURI(document.getElementById('origemida').value)+"&destinoida="+encodeURI(document.getElementById('destinoida').value)+"&horarioIda="+encodeURI(document.getElementById('horarioIda').value)+"&horarioVolta="+encodeURI(document.getElementById('horarioVolta').value)+"&dtida="+encodeURI(document.getElementById('dtida').value)+"&dtvolta="+encodeURI(document.getElementById('dtvolta').value)+"&valorpass="+encodeURI(document.getElementById('valorpass').value)+"&cadeirante2="+encodeURI(document.getElementById('cadeirante').value)+"&idaevolta="+encodeURI(document.getElementById('idaevolta').value)+"&cidorigem="+encodeURI(document.getElementById('cidorigem').value)+"&ciddestino="+encodeURI(document.getElementById('ciddestino').value);

}

</script>
    </div>
    <?php
		}
	if(trim($_SESSION['diariaSav'])=='sim'){
		?>
    <div class="conteudo3">
		<form name="hospedagem" action="insereHospedagem.php" method="post" onSubmit="setarCamposHos(this); enviarForm('insereHospedagem.php', camposHos, 'divResultado'); return false;">
        <h2 id="h2">INSERIR HOSPEDAGEM</h2>
        <table border="0" width="100%">
<td width="40%"><strong>Datas</strong>
<table border="0" width='100%'>
<tr><td height="34" valign="middle" align="right">
<strong>Entrada:</strong></td><td><input type="text" class="input" name="dtida" id="dtida2" size="20" readonly value='<?php echo $_SESSION['dtidaSav3']; ?>' style="background: url(css/icone_calendario.png) no-repeat right;"/></td></tr><tr><td height="34" valign="middle" align="right">
<strong>Saída:</strong></td><td><input type="text" class="input" name="dtvolta" id="dtvolta2" size="20" readonly value='<?php echo $_SESSION['dtvoltaSav3']; ?>' style="background: url(css/icone_calendario.png) no-repeat right;"/></td></tr></table>


</td><td width="60%"><strong>Localidade 
<?php
echo $abrangencia;
?></strong>
<table border="0" width="100%">
<tr>
<td height="34"><?php
if($abrangencia=='Nacional'){
	echo "<strong>Cidade</strong><input type='hidden' class='input' name='cidhos' id='cidhos' size='30'/>";
	}else{
		echo "<strong>Cidade:</strong> <input type='text' class='input' name='cidhos' id='cidhos' size='30' value='".$_SESSION['cidHosSav']."'/><br><strong>País</strong>";
		}
?>: <input type="text" class="input" name="destinoida2" id="destinoida2" size="30" value='<?php echo utf8_encode($_SESSION['destinoidaSav3']); ?>' style="background: url(css/icone_lupa.png) no-repeat right;"/><font style="font-size:10px; color:#949292">(*) Selecione na lista</font></td></tr>
<tr><td height='34'><strong>Tipo Quarto:</strong>
<select name="tipoQuarto" id="tipoQuarto">
<option value="Triplo">Triplo</option>
<option selected="selected" value="Duplo">Duplo</option>
<option value="Single">Single</option>
</select>
</td>
</tr>
<tr><td>
<strong>Valor:</strong> R$ <input type="text" name="valorhos" id="valorhos" class="input" value='<?php echo $_SESSION['valorHosSav']; ?>'/>
</td></tr>
</table>
<tr>
<td colspan="2" align="center"><input type="submit" name="ok" class="button" value="Inserir" /></td></tr>
  </td></tr></table>
  </form>
  <br /><br />
     <script>

//Cria a função com os campos para envio via parâmetro

function setarCamposHos() {
	camposHos = "destinoida2="+encodeURI(document.getElementById('destinoida2').value)+"&dtida="+encodeURI(document.getElementById('dtida2').value)+"&dtvolta="+encodeURI(document.getElementById('dtvolta2').value)+"&tipoQuarto="+encodeURI(document.getElementById('tipoQuarto').value)+"&cidhos="+encodeURI(document.getElementById('cidhos').value)+"&valorhos="+encodeURI(document.getElementById('valorhos').value);
}

</script>
    </div>
    <?php
		}
if($_SESSION['transladoSav']=='sim'){
		?>
    <div class="conteudo3">
		<form action="insereTranslado.php" name="translado" method="post" onSubmit="setarCamposLoc(this); enviarForm('insereTranslado.php', camposLoc, 'divResultado'); return false;">
        <h2 id="h2">INSERIR LOCAÇÃO DE VEÍCULO</h2>
        <table border="0" width="100%">
<tr>
<td width="50%"><strong>Datas</strong>
<table border="0" width="100%">
<tr><td height="34" align="right">
<strong>Início</strong>:</td><td><input type="text" class="input" name="dtida" id="dtida4" size="20" readonly value='<?php echo $_SESSION['dtidaSav4']; ?>' style="background: url(css/icone_calendario.png) no-repeat right;"/>
</td></tr><tr><td height="34" align="right">
<strong>Fim</strong>:</td><td><input type="text" class="input" name="dtvolta" id="dtvolta4" size="20" readonly value='<?php echo $_SESSION['dtvoltaSav4']; ?>' style="background: url(css/icone_calendario.png) no-repeat right;"/></td></tr></table>

</td><td width="50%"><strong>Valor:</strong> R$ <input type="text" name="valorpass" id="valorpass4" class="input" value='<?php echo $_SESSION['valorTransSav']; ?>'/>
</td></tr>
<tr><td colspan="2" align="center"><input type="submit" name="ok" class="button" value="Inserir" /></td></tr>
</table>
  </form>
  <script>

//Cria a função com os campos para envio via parâmetro

function setarCamposLoc() {
	camposLoc = "dtida="+encodeURI(document.getElementById('dtida4').value)+"&dtvolta="+encodeURI(document.getElementById('dtvolta4').value)+"&valorpass="+encodeURI(document.getElementById('valorpass4').value);
}

</script>
  <br /><br />
		</div>
        <?php
		}
		if($_SESSION['diariaSolSav']=='sim' || $novosDadosDiaria==1){
		?>
    <div class="conteudo3">
	  <form action="incluiDadosDiaria.php" name="diar" method="post" onSubmit="setarCamposDiar(this); enviarForm('incluiDadosDiaria.php', camposDiar, 'divResultado'); return false;">
        <h2 id="h2">DADOS SOLICITAÇÃO DE DIÁRIA</h2>
        <?php 
		if($_SESSION['diariaSolSav']=='sim'){
		?>
        <font size="-1">(*)Esses dados são preenchidos no decorrer do processamento da SAV.</font>
<table border="0" width="100%">
<tr>
<td width="50%"><strong>Quantidade: </strong><?php echo $qtddias; ?>
</td><td width="50%"><strong>Valor Total:</strong> R$ <?php echo $valordia; ?>
</td>
</tr>
<tr>
<td width="50%" colspan="2"><strong>Autorização: </strong>
<?php 
echo $nautor."/".$anoautor;
?>
</td>
</tr>
<tr>
<td width="50%" colspan="2"><strong>Processo nº:</strong> <?php echo $numproc; ?>
</td>
</tr>
</table>
<br /><br />
<?php 
$mostraCampos=0;
if(!empty($dtida) || !empty($dtvolta) || !empty($destinoida)){
	$mostraCampos=1;
	}
if($novosDadosDiaria==1){
	$mostraCampos=1;
	}
if(1==1){
?>
<font size="-1">(**)Campos obrigatórios apenas se não houver passagem e/ou hospedagem</font>
<table border="0" width="100%">
<?php 
if($_SESSION['abrangenciaSav']=='Internacional'){
echo "<tr height='34'><td><strong>Cidade Destino:</strong></td><td> <input type='text' class='input' name='ciddestinoida10' id='ciddestinoida10' size='40' onBlur='carregaVolta()' value='".$ciddestinoida."'/><tr height='34'><td>
<strong>País "; 
}else{
	echo "<input type='hidden' class='input' name='ciddestinoida10' id='ciddestinoida10' size='40' onBlur='carregaVolta()' value=''/><tr height='34'><td><strong>";
	}
?>
Destino:</strong> </td><td>
<input type="text" class="input" name="destinoida10" id="destinoida10" size="40" onBlur="carregaVolta()" value='<?php echo $destinoida;?>' style="background: url(css/icone_lupa.png) no-repeat right;"/><font style="font-size:10px; color:#949292"> (*) Selecione na Lista</font></td></tr>
<tr height="34">
  <td>
    <strong>Data de Ida:</strong></td><td><input type="text" class="input" name="dtida10" id="dtida10" size="20" readonly value='<?php echo $dtida;?>' style="background: url(css/icone_calendario.png) no-repeat right;"/></td></tr>
<tr height="34">
  <td>
    <strong>Data de Retorno:</strong></td><td><input type="text" class="input" name="dtvolta10" id="dtvolta10" size="20" readonly value='<?php echo $dtvolta;?>' style="background: url(css/icone_calendario.png) no-repeat right;"/></td></tr>
<tr height='34'><td>
  <strong>Horário de Retorno:</strong></td><td> 
<select name="horarioVolta10" id="horarioVolta10">
<?php 
 if(empty($horariovolta) || $horariovolta=='0'){
   echo "<option value='0' selected='selected'>Selecione</option>"; 
	echo '<option value="manha">Manhã (4h->12h)</option>
<option value="tarde">Tarde (12h01->18h)</option>
<option value="noite">Noite (18h01->3h59)</option>';
}else{
	if($horariovolta=='manha'){
		echo '<option value="manha" selected="selected">Manhã (4h->12h)</option>
<option value="tarde">Tarde (12h01->18h)</option>
<option value="noite">Noite (18h01->3h59)</option>';
		}elseif($horariovolta=='tarde'){
			echo '<option value="manha">Manhã (4h->12h)</option>
<option value="tarde" selected="selected">Tarde (12h01->18h)</option>
<option value="noite">Noite (18h01->3h59)</option>';
			}elseif($horariovolta=='noite'){
				echo '<option value="manha">Manhã (4h->12h)</option>
<option value="tarde">Tarde (12h01->18h)</option>
<option value="noite" selected="selected">Noite (18h01->3h59)</option>';
				}
}
?>
</select>
</td></tr>
<tr><td colspan="2" align="center"><input type="submit" name="inserir" value="Inserir" class="button" /></td></tr>

 </table>
 <?php 
		}
?>
  </form>
  <script>

//Cria a função com os campos para envio via parâmetro

function setarCamposDiar() {
	camposDiar = "&dtida="+encodeURI(document.getElementById('dtida10').value)+"&dtvolta="+encodeURI(document.getElementById('dtvolta10').value)+"&destinoida="+encodeURI(document.getElementById('destinoida10').value)+"&ciddestinoida="+encodeURI(document.getElementById('ciddestinoida10').value)+"&horarioVolta="+encodeURI(document.getElementById('horarioVolta10').value);
}

</script>
  <br /><br />
		</div>
        <?php
		   }
		}
?>
  </div>
 </div>
<?php 
}
?>
<hr />
<script language="javascript" src="scriptNova2.js" type="text/javascript"></script>
<form action="concluiSav.php" name="sav2" method="post" onSubmit="setarCamposFinal(this); enviarForm2('finalizarSav.php', camposFinal, 'divResultado'); return false; this.elements['ok'].disabled=true;">
<table border="0" width="100%">
<tr><td><a href="novaSav.php"><input type="button" name="volta" class="button" value="Voltar" /></a></td><td align="right">
<div id="formsubmitbutton">
<input type="submit" name="ok" value="CONCLUIR" class="button" onclick="ButtonClicked()"/>
</div>
<div id="buttonreplacement" style="margin-left:30px; display:none;">
<img src="../imagens/loading.gif" alt="loading...">
</div>
<script type="text/javascript">
/*
   Replacing Submit Button with 'Loading' Image
   Version 2.0
   December 18, 2012

   Will Bontrager Software, LLC
   http://www.willmaster.com/
   Copyright 2012 Will Bontrager Software, LLC

   This software is provided "AS IS," without 
   any warranty of any kind, without even any 
   implied warranty such as merchantability 
   or fitness for a particular purpose.
   Will Bontrager Software, LLC grants 
   you a royalty free license to use or 
   modify this software provided this 
   notice appears on all copies. 
*/
function ButtonClicked()
{
   document.getElementById("formsubmitbutton").style.display = "none"; // to undisplay
   document.getElementById("buttonreplacement").style.display = ""; // to display
   return true;
}
var FirstLoading = true;
function RestoreSubmitButton()
{
   if( FirstLoading )
   {
      FirstLoading = false;
      return;
   }
   document.getElementById("formsubmitbutton").style.display = ""; // to display
   document.getElementById("buttonreplacement").style.display = "none"; // to undisplay
}
// To disable restoring submit button, disable or delete next line.
document.onfocus = RestoreSubmitButton;
</script>
</td></tr>
</table>
</form>
<script>
//Cria a função com os campos para envio via parâmetro
function setarCamposFinal() {
	camposFinal = "";
}
</script>
</div>
  </div>
</body>
</html>