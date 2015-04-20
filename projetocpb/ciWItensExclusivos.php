  <?php 
  require "conectsqlserverci.php";
  include "mb.php";
  session_start();
  $totalGeral=0;
  $usuario=$_SESSION['userCi'];
  if(!empty($_POST['sequencia'])){
  $sequencia=$_POST['sequencia'];
  $solicitacao=$_POST['solic'];
  $_SESSION['sequenciaEx']=$sequencia;
  $_SESSION['solicitacaoEx']=$solicitacao;
  $_SESSION['codRpaS']='';
  $_SESSION['codDiaS']='';
  $_SESSION['codPasS']='';
  $_SESSION['codHotS']='';
  $_SESSION['cargoRpaS']='';
  $_SESSION['cargoDiaS']='';
  $_SESSION['cargoPasS']='';
  $_SESSION['cargoHotS']='';
  $_SESSION['inicioRpaS']='';
  $_SESSION['inicioDiaS']='';
  $_SESSION['inicioPasS']='';
  $_SESSION['inicioHotS']='';
  $_SESSION['fimRpaS']='';
  $_SESSION['fimDiaS']='';
  $_SESSION['fimPasS']='';
  $_SESSION['fimHotS']='';
  $_SESSION['vlRpaS']='';
  $_SESSION['vlDiaS']='';
  $_SESSION['vlPasS']='';
  $_SESSION['rlHotS']='';
  $_SESSION['horaInicioS']='';
  $_SESSION['minutoInicioS']='';
  $_SESSION['horaFimS']='';
  $_SESSION['minutoFimS']='';
  $_SESSION['obsPasS']='';
  $_SESSION['cadeiranteS']='';
  $_SESSION['trechoS']='';
  }else{
	  $sequencia=$_SESSION['sequenciaEx'];
	  $solicitacao=$_SESSION['solicitacaoEx'];
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
  
  <?php 
  $SQLCoisolic="select Quantidade,Pr_unitario,Cd_material
  from COISOLIC (nolock) 
  where Cd_solicitacao='".$solicitacao."'
  AND Sequencia='".$sequencia."'
  ";
  $arrayCoisolic = odbc_exec($conCab, $SQLCoisolic);
  $rsCoisolic=odbc_fetch_array($arrayCoisolic);
  ?>
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
		  width: 605,
		  matchContains: true,
		  selectFirst: false
	  });
  });
  </script>
  <script type="text/javascript">
  $().ready(function() {
	  $("#diaCod").autocomplete("suggest_user.php", {
		  width: 605,
		  matchContains: true,
		  selectFirst: false
	  });
  });
  </script>
  <script type="text/javascript">
  $().ready(function() {
	  $("#pasCod").autocomplete("suggest_user.php", {
		  width: 605,
		  matchContains: true,
		  selectFirst: false
	  });
  });
  </script>
  <script type="text/javascript">
  $().ready(function() {
	  $("#hotCod").autocomplete("suggest_user.php", {
		  width: 605,
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
   <p><strong>DADOS EXCLUSIVOS</strong></p>
   <strong>CI N&ordm; <font size="3" color="red"><?php echo $solicitacao; ?></font></strong><br />
   Item: <?php echo $sequencia; ?><br />
   <?php 
   $contador=0;
   $sqlTipo=odbc_exec($conCab,"SELECT * FROM TEANALIVERMATERIAL (nolock) WHERE material='".$rsCoisolic['Cd_material']."'");
	   $arrayTipo=odbc_fetch_array($sqlTipo);
	   $tipo='';
	   if($arrayTipo['habilitar_rpa']=='1'){
		   $tipo='rpa';
		   }elseif($arrayTipo['habilitar_hotel']=='1'){
			   $tipo='hotel';
			   }elseif($arrayTipo['habilitar_passagem']=='1'){
			   		$tipo='passagem';
			   		}elseif($arrayTipo['habilitar_diaria']=='1' || $arrayTipo['habilitar_auxilio_viagem']=='1' || $arrayTipo['habilitar_ajuda_custo']=='1'){
			   			$tipo='diaria';
			   			}
   //Botão para selecionar varios beneficiarios
   echo "<br/><table><tr><td><form action='ciWExcMult.php' name='exclusivoMult' method='post'><input class='input' name='sequencia' id='sequencia' type='hidden' size='8' value='".$sequencia."'  /><input class='input' name='retorno' id='retorno' type='hidden' size='8' value='inserir'  /><input class='input' name='solicitacao' id='solicitacao' type='hidden' size='8' value='".$solicitacao."'  /><input class='input' name='tipo' id='tipo' type='hidden' size='8' value='".$tipo."'  /><input class='input' name='usuario' id='usuario' type='hidden' size='8' value='".$usuario."'  /><input class='buttonVerde' value='Selecionar M&uacute;ltiplos' type='submit' name='multiplos'/></form></td>";
	if($nova==1){
	//Botão para copiar itens de outro exclusivo
	echo "<td><form action='ciWExcCop.php' name='exclusivoCopia' method='post'><input class='input' name='sequencia' id='sequencia' type='hidden' size='8' value='".$sequencia."'  /><input class='input' name='retorno' id='retorno' type='hidden' size='8' value='inserir'  /><input class='input' name='retorno' id='retorno' type='hidden' size='8' value='inserir'  /><input class='input' name='solicitacao' id='solicitacao' type='hidden' size='8' value='".$solicitacao."'  /><input class='input' name='tipo' id='tipo' type='hidden' size='8' value='".$tipo."'  /><input class='input' name='usuario' id='usuario' type='hidden' size='8' value='".$usuario."'  /><input class='buttonVerde' value='Copiar Itens' type='submit' name='copia'/></form></td></tr>";
	}
   echo "</table><br><br><form action='ciWAtEx.php' name='exclusivo' method='post' onsubmit=\"this.elements['atJus'].disabled=true;\">
	<input class='input' name='rpa' id='rpaI' type='hidden' size='8' value=".$rpa."  />
	<input class='input' name='TotalRpa' id='TotalRpa' type='hidden' size='8' value='0'  />
   <input class='input' name='diaria' id='diariaI' type='hidden' size='8' value=".$diaria."  />
   <input class='input' name='TotalDia' id='TotalRpa' type='hidden' size='8' value='0'  />
   <input class='input' name='passagem' id='passagemI' type='hidden' size='8' value=".$passagem."  />
   <input class='input' name='TotalPas' id='TotalRpa' type='hidden' size='8' value='0'  />
   <input class='input' name='hotel' id='hotelI' type='hidden' size='8' value=".$hotel."  />
   <input class='input' name='TotalHotel' id='TotalHotel' type='hidden' size='8' value='0'  />
	<input class='input' name='nova' id='novaI' type='hidden' size='8' value=".$nova."  />
	 <input class='input' name='sequencia' id='sequencia' type='hidden' size='8' value=".$sequencia."  />
	  <input class='input' name='solicitacao' id='solicitacao' type='hidden' size='8' value=".$solicitacao."  />
	  <input class='input' name='usuario' id='usuario' type='hidden' size='8' value=".$usuario."  />";
   if($nova==1){
	   $contador=1;  
		 echo "<strong><font size='+0,5'>CADASTRAR NOVO ITEM EXCLUSIVO</font></strong><br /><br />
	   <input type='hidden' name='tipo' value='".$tipo."'/>";
	   if($tipo=='rpa'){
		 echo" <table border='0'>
		  <tr><td colspan='2'><strong><font size='+1'>RPA - Recibo Pagamento Aut&ocirc;nomo</font></strong></td></tr>
	<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td><strong><font color=red>*</font>Benefici&aacute;rio:</strong> </td><td colspan='2'> <input class='input' name='rpaCod' id='rpaCod' type='text' size='80' value='".$_SESSION['codRpaS']."'/>
  </td></tr>
  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td colspan='2'><input class='input' name='cargoRpa' id='cargoRpa' type='text' size='35' maxlength='39' value='".$_SESSION['cargoRpaS']."' /><font size='-2'>Preencher somente se quiser alterar a fun&ccedil&atildeo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  
  <tr><td>
	<strong><font color=red>*</font>In&iacute;cio:</strong></td><td><input class='input' name='inicioRpa' id='inicioRpa' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" readonly value='".$_SESSION['inicioRpaS']."'/>
	<strong><font color=red>*</font>Fim:</strong><input class='input' name='fimRpa' id='fimRpa' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" readonly  value='".$_SESSION['fimRpaS']."'/>
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor:</strong></td><td><input class='input' name='valorRpa' id='valorRpa' type='text' value='".$_SESSION['vlRpaS']."' size='10' maxlength='11' onkeyup=\"somenteNumeros(this)\"/><br />
  </td></tr>
  </table>";
	   }elseif($tipo=='diaria'){

		  echo "<table border='0'>
		  <tr><td colspan='2'><strong><font size='+1'>DI&Aacute;RIAS/AUX&Iacute;LIO VIAGEM</font></strong></td></tr>
	<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td><strong><font color=red>*</font>Benefici&aacute;rio:</strong></td><td> <input type='text' name='diaCod' id='diaCod' class='input' size='80' value='".$_SESSION['codDiaS']."'/>
  </td></tr>
  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td> <input class='input' name='cargoDia' id='cargoDia' type='text' size='30' maxlength='39' value='".$_SESSION['cargoDiaS']."'/> <font size='-2'>Preencher somente se quiser alterar a fun&ccedil&atildeo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>In&iacute;cio:</strong></td><td><input class='input' name='inicioDia' id='inicioDia' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" readonly value='".$_SESSION['inicioDiaS']."'/>
<span style='padding-left:50px'>
	<strong><font color=red>*</font>Fim:</strong><input readonly class='input' name='fimDia' id='fimDia' type='text' size='10' value='".$_SESSION['fimDiaS']."' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" />
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor:</strong></td><td><input class='input' name='valorDia' id='valorDia' type='text' size='8' value='".$_SESSION['vlDiaS']."' onkeyup=\"somenteNumeros(this)\" maxlength='11'/><br />
  </td></tr>
  </table>
		  ";
	   }elseif($tipo=='passagem'){
echo "<table border='0'>
		  <tr><td><strong><font size='+1'>PASSAGENS</FONT></strong></td></tr>
	<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td><strong><font color=red>*</font>Passageiro:</strong></td><td> <input type='text' name='pasCod' id='pasCod' class='input' value='".$_SESSION['codPasS']."' size='80' />
  </td></tr>
  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td><input class='input' name='cargoPas' id='cargoPas' type='text' size='30' maxlength='39' value='".$_SESSION['cargoPasS']."' /> <font size='-2'>Preencher campo somente se quiser alterar a fun&ccedil&atildeo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Dt. Partida:</strong></td><td><input readonly class='input' name='inicioPas' id='inicioPas' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['inicioPasS']."' />
<span style='padding-left:45px'>
  <strong><font color=red>*</font>Hora de Partida:</strong><input class='input' name='horaPtPas' value='".$_SESSION['horaInicioS']."' id='horaPtPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2'/>:<input class='input' name='minutoPtPas' value='".$_SESSION['minutoInicioS']."' id='minutoPtPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2'/><br />
  </td></tr>
  <tr><td>
	<strong>Dt. Retorno:</strong></td><td><input readonly class='input' name='fimPas' id='fimPas' value='".$_SESSION['fimPasS']."' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" />
<span style='padding-left:40px'>
  <strong>Hora de Retorno:</strong><input class='input' name='horaRetPas' id='horaRetPas' type='text' size='2'  value='".$_SESSION['horaFimS']."' onkeypress=\"return validNumb(event)\" maxlength='2'/>:<input class='input' name='minutoRetPas' value='".$_SESSION['minutoFimS']."' id='minutoRetPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2'/><br />
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor:</strong></td><td><input class='input' name='valorPas' id='valorPas' type='text' size='8' value='".$_SESSION['vlPasS']."'  onkeyup=\"somenteNumeros(this)\" maxlength='11'/><br />
  </td></tr>
  <tr><td>
  <strong>Cadeirante:</strong></td><td>";
  if(empty($_SESSION['cadeiranteS']) || $_SESSION['cadeiranteS']<>'1' ){
  echo "<input name='cadeirantePas'  id='cadeirantePas' type='checkbox' value='1'>";
	   }else{
		   echo "<input name='cadeirantePas'  id='cadeirantePas' type='checkbox' value='1' checked>";
		   }
  echo "</td></tr>
  <tr><td>
  <strong>Trecho:</strong></td><td><input class='input' name='trechoPas' value='".$_SESSION['trechoS']."' id='trechoPas' type='text' size='20' maxlength='500'/><br />
  </td></tr>
  <tr><td>
  <strong>Observa&ccedil;&atilde;o:</strong></td><td><input class='input' name='obsPas' id='obs' value='". $_SESSION['obsPasS']."' type='text' size='40' maxlength='500'/><br />
  </td></tr>
  
  </table>";
	   }elseif($tipo=='hotel'){
  echo "<table border='0'>
		  <tr><td><strong><font size='+1'>HOSPEDAGEM</font></strong></td></tr>
	<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td><strong><font color=red>*</font>H&oacute;spede:</strong></td><td><input type='text' name='hotCod' id='hotCod' class='input' value='".$_SESSION['codHotS']."' size='80' />
  </td></tr>
		  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td><input class='input' name='cargoHot' id='cargoHot' type='text' size='30' value='".$_SESSION['cargoHotS']."' maxlength='39'/> <font size='-2'>Preencher somente se quiser alterar a fun&ccedil&atildeo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  <tr><td>
  <strong>Reserva (RL):</strong></td><td><input class='input' name='rlHot' id='rlHot' type='text' size='20' onkeyup=\"somenteNumeros(this)\" value='".$_SESSION['rlHotS']."' maxlength='11'/><br />
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Dt. In&iacute;cio:</strong></td><td><input readonly class='input' name='inicioHot' id='inicioHot' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['inicioHotS']."' />
<span style='padding-left:50px'>
	<strong><font color=red>*</font>Dt. Fim:</strong><input class='input' readonly name='fimHot' value='".$_SESSION['fimHotS']."' id='fimHot' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" />
  </td></tr>
  </table>";
	   }else{
	?>
       <script type="text/javascript">
       alert("Esse item n\u00e3o permite a inclus\u00e3o de exclusivos.");
       history.back();
       </script>
       <?php  
		   }
		  echo "<tr><td><input name='atJus' class='buttonVerde' type='submit' value='Incluir' /></td></tr></table></form>";
   }elseif($rpa==1){
							  $SQLItemRPAImp = "Select Distinct
								 rpa.id_registro,
								 rpa.cd_solicitacao,
								 rpa.sequencia,
								 rpa.cd_empresa,
								 nom.Nome_completo Profissional,
								 pes.Cargo,
								 rpa.dt_inicio,
								 rpa.dt_fim,
								 rpa.valor,
								 rpa.cargo As cargo1
							  
							  from TEITEMSOLRPA rpa with (nolock) 
								 inner join GEEMPRES nom with (nolock) on
									nom.Cd_empresa = rpa.cd_empresa
								 left join GEPFISIC pes with (nolock) on
									pes.Cd_empresa = nom.Cd_empresa
							  where
								 rpa.cd_solicitacao = '".$solicitacao."'
								 AND rpa.sequencia='".$sequencia."'";
					  $resItemRPAImp = odbc_exec($conCab, $SQLItemRPAImp);
							  if(odbc_num_rows($resItemRPAImp)>0){
								  echo "<div id='tabela3'><table width='100%' border='1'>
								  <tr><th colspan='6' align='center'><p align='center'>RPA - Recibo de Pagamento Aut&ocirc;nomo</p></th></tr>
								  <tr><th><strong>PROFISSIONAL/BENEFICI&Aacute;RIO</strong></th><th><strong>FUN&Ccedil&AtildeO</strong></th><th><strong>IN&Iacute;CIO</strong></th><th><strong>T&Eacute;RMINO</strong></th><th><strong>VALOR</strong></th><th><strong>EXCLUIR</strong></th></tr>";
								  $totalRpa=0;
								  $contador=0;
								  $idAnterior='';
								  while($objItemRPAImp = odbc_fetch_object($resItemRPAImp)){
									  $contador++;
									  if(empty($objItemRPAImp->cargo1)){
										  $cargoImpCiRpa=$objItemRPAImp->Cargo;
										  }else{
											  $cargoImpCiRpa=$objItemRPAImp->cargo1;
											  }
											  if($idAnterior<>$objItemRPAImp->id_registro){
												  $idAnterior=$objItemRPAImp->id_registro;
									  echo "<tr><td>".$objItemRPAImp->Profissional."</td><td>".$cargoImpCiRpa."</td><td>".date('d/m/Y',strtotime($objItemRPAImp->dt_inicio))."</td><td>".date('d/m/Y',strtotime($objItemRPAImp->dt_fim))."</td><td>R$ ".number_format($objItemRPAImp->valor, 2, ',', '.')."</td><td><a href='ciWRpaDel.php?id=".$objItemRPAImp->id_registro."' onclick=\"return confirm('Deseja realmente remover esse item?')\"><img align='middle' src='imagens/excluir.png'></a></td></tr>";
									  $totalRpa=$totalRpa+$objItemRPAImp->valor;			
									  }
								  }
								  
								  echo "<tr bgcolor='#DCDCDC'><td colspan='4'><strong><center>TOTAL</center></strong></td><td colspan='2'><center><strong>R$ ".number_format($totalRpa, 2, ',', '.')."</strong></center></td></table></div>";
								  }
								  $totalGeral=$totalRpa;
	   echo"<br><br> <table border='0'>
		  <tr><td colspan='2'><strong><font size='+1'>RPA - Recibo Pagamento Aut&ocirc;nomo</font></strong></td></tr>
	<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td><strong><font color=red>*</font>Benefici&aacute;rio:</strong> </td><td colspan='2'> <input class='input' name='rpaCod' id='rpaCod' type='text' size='80' value='".$_SESSION['codRpaS']."'/>
  </td></tr>
  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td colspan='2'><input class='input' name='cargoRpa' id='cargoRpa' type='text' size='35' maxlength='39' value='".$_SESSION['cargoRpaS']."' /><font size='-2'>Preencher somente se quiser alterar a fun&ccedil&atildeo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  
  <tr><td>
	<strong><font color=red>*</font>In&iacute;cio:</strong></td><td><input class='input' name='inicioRpa' id='inicioRpa' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" readonly value='".$_SESSION['inicioRpaS']."'/>
  <span style='padding-left:15px'>
	<strong><font color=red>*</font>Fim:</strong><input class='input' name='fimRpa' id='fimRpa' type='text' size='10' value='".$_SESSION['fimRpaS']."' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" readonly/>
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor:</strong></td><td><input class='input' name='valorRpa' id='valorRpa' type='text' value='".$_SESSION['vlRpaS']."' size='10' maxlength='11' onkeyup=\"somenteNumeros(this)\"/><input class='input' name='TotalRpa' id='TotalRpa' type='hidden' size='8' value='".$totalRpa."'/><input class='input' name='contRpa' id='contRpa' type='hidden' size='8' value='".$contador."'/><br />
  </td></tr>
  </td></tr>
  <tr><td><input name='atJus' class='buttonVerde' type='submit' value='Incluir' /></td></tr>
  </table>";
   }elseif($diaria==1){
	   $SQLItemDiariaImp = "Select Distinct
	   									 dia.id_registro,
										 dia.solicitacao,
										 dia.sequencia,
										 dia.empresa,
										 nom.Nome_completo Profissional,
										 pes.Cargo,
										 dia.dt_inicio,
										 dia.dt_termino,
										 dia.valor,
										 dia.cargo cargo1
									  
									  from TEITEMSOLDIARIAVIAGEM dia with (nolock) 
										 inner join GEEMPRES nom with (nolock) on
											nom.Cd_empresa = dia.empresa
										 left join GEPFISIC pes with (nolock) on
											pes.Cd_empresa = nom.Cd_empresa
									  where
										 dia.solicitacao = '".$solicitacao."'
										 AND dia.sequencia='".$sequencia."'";
					  $resItemDiariaImp = odbc_exec($conCab, $SQLItemDiariaImp);
							  if(odbc_num_rows($resItemDiariaImp)>0){
								  echo "<div id='tabela3'><table width='100%' border='1'>
								  <tr><th colspan='6' align='center'><p align='center'>DI&Aacute;RIA / AUX&Iacute;LIO VIAGEM</p></th></tr>
								  <tr><th><strong>PROFISSIONAL/BENEFICI&Aacute;RIO</strong></th><th><strong>CARGO</strong></th><th><strong>IN&Iacute;CIO</strong></th><th><strong>T&Eacute;RMINO</strong></th><th><strong>VALOR</strong></th><th><strong>EXCLUIR</STRONG></TH></tr>";
								  $totalDiaria=0;
								 $contador=0;
								 $idAnterior='';
								 while($objItemDiariaImp = odbc_fetch_object($resItemDiariaImp)){
									  $contador++;
									  if(empty($objItemDiariaImp->cargo1)){
										  $cargoImpCiDiaria=$objItemDiariaImp->Cargo;
										  }else{
											  $cargoImpCiDiaria=$objItemDiariaImp->cargo1;
											  }
									  if($idAnterior<>$objItemDiariaImp->id_registro){
												  $idAnterior=$objItemDiariaImp->id_registro;
									  echo "<tr><td>".$objItemDiariaImp->Profissional."</td><td>".$cargoImpCiDiaria."</td><td>".date('d/m/Y',strtotime($objItemDiariaImp->dt_inicio))."</td><td>".date('d/m/Y',strtotime($objItemDiariaImp->dt_termino))."</td><td>R$ ".number_format($objItemDiariaImp->valor, 2, ',', '.')."</td><td><a href='ciWDiaDel.php?id=".$objItemDiariaImp->id_registro."' onclick=\"return confirm('Deseja realmente remover esse item?')\"><img src='imagens/excluir.png'></a></td></tr>";
				  $totalDiaria=$totalDiaria+$objItemDiariaImp->valor;			
				    		}
					}
								  
								  echo "<tr bgcolor='#DCDCDC'><td colspan='4'><strong><center>TOTAL</center></strong></td><td colspan='2'><center><strong>R$ ".number_format($totalDiaria, 2, ',', '.')."</strong></td></table></div>";
								  }
								  $totalGeral=$totalDiaria;
	   echo "<br><br><table border='0'>
		  <tr><td colspan='2'><strong><font size='+1'>DI&Aacute;RIAS/AUX&Iacute;LIO VIAGEM</font></strong></td></tr>
	<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td><strong><font color=red>*</font>Benefici&aacute;rio:</strong></td><td> <input type='text' name='diaCod' id='diaCod' class='input' size='80' value='".$_SESSION['codDiaS']."'/>
</td></tr>
  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td> <input class='input' name='cargoDia' id='cargoDia' type='text' size='30' maxlength='39' value='".$_SESSION['cargoDiaS']."'/> <font size='-2'>Preencher somente se quiser alterar a fun&ccedil&atildeo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>In&iacute;cio:</strong></td><td><input class='input' name='inicioDia' id='inicioDia' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" readonly value='".$_SESSION['inicioDiaS']."'/>
<span style='padding-left:50px'>
	<strong><font color=red>*</font>Fim:</strong><input readonly class='input' name='fimDia' id='fimDia' type='text' size='10' value='".$_SESSION['fimDiaS']."' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" />
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor:</strong></td><td><input class='input' name='valorDia' id='valorDia' type='text' size='8' value='".$_SESSION['vlDiaS']."' onkeyup=\"somenteNumeros(this)\" maxlength='11'/><input class='input' name='TotalDia' id='valorDia' type='hidden' size='8' value='".$totalDiaria."'/><input class='input' name='contDia' id='contDia' type='hidden' size='8' value='".$contador."'/><br />
  </td></tr>
  <tr><td><input name='atJus' class='buttonVerde' type='submit' value='Incluir' /></td></tr>
  </table>";
	   }elseif($passagem==1){
		   $contador=0;
	   $SQLItemPassImp = "Select Distinct
								 ROW_NUMBER() over (partition by psg.cd_solicitacao,psg.sequencia order by psg.sequencia) num, 
								 psg.cd_solicitacao,
								 psg.id_registro,
								 psg.sequencia,
								 psg.cargo,
								 psg.cd_empresa,
								 (case when psg.cadeirante = 1 then '* ' + nom.Nome_completo else nom.Nome_completo end) nome_completo,
								 psg.trecho,
								 (psg.dt_partida) ,
								 psg.dt_chegada,
								 psg.observacao,
								 psg.valor,
								 psg.hr_partida,
								 psg.hr_chegada,
								 case when psg.cadeirante = 1 then 'X' end cadeirante 
							  from TEITEMSOLPASSAGEM psg with (nolock)
								 inner join GEEMPRES nom with (nolock) on
									nom.Cd_empresa = psg.cd_empresa
							  where
								 psg.cd_solicitacao = '".$solicitacao."'
								 AND psg.sequencia='".$sequencia."'";
							  $resItemPassImp = odbc_exec($conCab, $SQLItemPassImp);
							  if(odbc_num_rows($resItemPassImp)>0){
								  echo "<div id='tabela3'><table width='100%' border='1'>
								  <tr><th colspan='7' align='center'><p align='center'>PASSAGENS</p></th></tr>
								  <tr><th><strong>NOME</strong></th><th><strong>TRECHO</strong></th><th><strong>IDA</strong></th><th><strong>VOLTA</strong></th><th><strong>CADEIRANTE</strong></th><th><strong>VALOR</STRONG></TH><th><strong>EXCLUIR</STRONG></TH></tr>";
								  $totalPassagem=0;
								  $idAnterior='';
								  while($objItemPassImp = odbc_fetch_object($resItemPassImp)){
								  $contador++;
								  $chegadaPassagem='';
								  $hrchegadaPassagem='';
								  if(!empty($objItemPassImp->dt_chegada)){
								  $chegadaPassagem=date('d/m/Y',strtotime($objItemPassImp->dt_chegada));
								  }
								  if($objItemPassImp->hr_chegada<>0){
								  $hrchegadaPassagem=date('H:i',strtotime($objItemPassImp->hr_chegada));
								  }
								  if($idAnterior<>$objItemPassImp->id_registro){
												  $idAnterior=$objItemPassImp->id_registro;
								  echo "<tr><td>".$objItemPassImp->nome_completo."</td><td>".$objItemPassImp->trecho."</td><td>".date('d/m/Y',strtotime($objItemPassImp->dt_partida))."-".date('H:i',strtotime($objItemPassImp->hr_partida))."</td><td>".$chegadaPassagem."-".$hrchegadaPassagem."</td><td><center>".$objItemPassImp->cadeirante."</center></td><td>".number_format($objItemPassImp->valor, 2, ',', '.')."</td><td><a href='ciWPasDel.php?id=".$objItemPassImp->id_registro."' onclick=\"return confirm('Deseja realmente remover esse item?')\"><img src='imagens/excluir.png'></a></td></tr>";
				  $totalPassagem=$totalPassagem+$objItemPassImp->valor;
  }
								  }
  
								  echo "<tr bgcolor='#DCDCDC'><td colspan='5'><strong><center>TOTAL</center></strong></td><td colspan='2'><center><strong>R$ ".number_format($totalPassagem, 2, ',', '.')."</center></strong></td></table></div>";
								  }
								  $totalGeral=$totalPassagem;
	   echo "<br><br><br><br><table border='0'>
		   <tr><td><strong><font size='+1'>PASSAGENS</font></strong></td></tr>
	<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td><strong><font color=red>*</font>Passageiro:</strong></td><td> <input type='text' name='pasCod' id='pasCod' class='input' value='".$_SESSION['codPasS']."' size='80' />
  </td></tr>
  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td><input class='input' name='cargoPas' id='cargoPas' type='text' size='30' maxlength='39' value='".$_SESSION['cargoPasS']."' /> <font size='-2'>Preencher campo somente se quiser alterar a fun&ccedil&atildeo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Dt. Partida:</strong></td><td><input readonly class='input' name='inicioPas' id='inicioPas' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['inicioPasS']."' />
<span style='padding-left:50px'>
  <strong><font color=red>*</font>Hora de Partida:</strong><input class='input' name='horaPtPas' value='".$_SESSION['horaInicioS']."' id='horaPtPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2'/>:<input class='input' name='minutoPtPas' value='".$_SESSION['minutoInicioS']."' id='minutoPtPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2'/><br />
  </td></tr>
  <tr><td>
	<strong>Dt. Retorno:</strong></td><td><input readonly class='input' name='fimPas' id='fimPas' value='".$_SESSION['fimPasS']."' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" />
<span style='padding-left:48px'>
  <strong>Hora de Retorno:</strong><input class='input' name='horaRetPas' id='horaRetPas' type='text' size='2'  value='".$_SESSION['horaFimS']."' onkeypress=\"return validNumb(event)\" maxlength='2'/>:<input class='input' name='minutoRetPas' value='".$_SESSION['minutoFimS']."' id='minutoRetPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2'/><br />
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor:</strong></td><td><input class='input' name='valorPas' id='valorPas' type='text' size='8' value='".$_SESSION['vlPasS']."'  onkeyup=\"somenteNumeros(this)\" maxlength='11'/><br />
  </td></tr>
  <tr><td>
  <strong>Cadeirante:</strong></td><td>";
  if(empty($_SESSION['cadeiranteS']) || $_SESSION['cadeiranteS']<>'1' ){
  echo "<input name='cadeirantePas'  id='cadeirantePas' type='checkbox' value='1'>";
	   }else{
		   echo "<input name='cadeirantePas'  id='cadeirantePas' type='checkbox' value='1' checked>";
		   }
  echo "</td></tr>
  <tr><td>
  <strong>Trecho:</strong></td><td><input class='input' name='trechoPas' value='".$_SESSION['trechoS']."' id='trechoPas' type='text' size='20' maxlength='500'/><br />
  </td></tr>
  <tr><td>
  <strong>Observa&ccedil;&atilde;o:</strong></td><td><input class='input' name='obsPas' id='obs' value='". $_SESSION['obsPasS']."' type='text' size='40' maxlength='500'/><br />
  </td></tr>
  <tr><td colspan='2'><input class='input' name='TotalPas' id='TotalPas' type='hidden' size='8' value='".$totalPassagem."'/><input class='input' name='contPas' id='contPas' type='hidden' size='8' value='".$contador."'/><input name='atJus' class='buttonVerde' type='submit' value='Incluir Passageiro' /></td></tr>
  </table>";
	   }elseif($hotel==1){
	   $SQLItemHotelImp = "Select Distinct htl.id_registro,
			 htl.cd_solicitacao,
			 htl.sequencia, 
			 ROW_NUMBER() over (partition by htl.cd_solicitacao,htl.sequencia order by htl.sequencia) num, 
			 htl.reserva,
			 htl.cargo,
			 htl.cd_empresa,
			 nom.Nome_completo,
			 pes.Cargo funcao,
			 htl.dt_entrada,
			 htl.dt_saida
		  
		  from TEITEMSOLHOTEL htl with (nolock)
		  inner join GEEMPRES nom with (nolock) on
				nom.Cd_empresa = htl.cd_empresa
		  left join GEPFISIC pes with (nolock) on
			 pes.Cd_empresa = nom.Cd_empresa
		  where
			 htl.cd_solicitacao = '".$solicitacao."'
			 AND htl.sequencia='".$sequencia."'";
			  $resItemHotelImp = odbc_exec($conCab, $SQLItemHotelImp);
			  if(odbc_num_rows($resItemHotelImp)>0){
								  echo "<div id='tabela3'><table width='100%' border='1'><tr><th colspan='6' align='center'><p align='center'>HOSPEDAGEM</p></th></tr>
								  <tr><th><strong>RL</strong></th><th><strong>NOME</strong></th><th><strong>CARGO</strong></th><th><strong>IDA</strong></th><th><strong>VOLTA</strong></th><th><strong>EXCLUIR</STRONG></TH></tr>";
								  while($objItemHotelImp = odbc_fetch_object($resItemHotelImp)){
									  if(empty($objItemHotelImp->cargo)){
										  $cargoImpCiHotel=$objItemHotelImp->funcao;
										  }else{
											  $cargoImpCiHotel=$objItemHotelImp->cargo;
											  }
									  echo "<tr><td>".(float)$objItemHotelImp->reserva."</td><td>".$objItemHotelImp->Nome_completo."</td><td>".$cargoImpCiHotel."</td><td>".date('d/m/Y',strtotime($objItemHotelImp->dt_entrada))."</td><td>".date('d/m/Y',strtotime($objItemHotelImp->dt_saida))."</td><td><center><a href='ciWHotDel.php?id=".$objItemHotelImp->id_registro."' onclick=\"return confirm('Deseja realmente remover esse item?')\"><img src='imagens/excluir.png'></a></center></td></tr>";
									  }
								  echo "</table></div>";
								  }			
		#B6174A						  $totalGeral="hotel";
	   echo "<br><br><table border='0'>
		  
		  <tr><td><strong><font size='+1'>HOSPEDAGEM</font></strong></td></tr>
	<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td><strong><font color=red>*</font>H&oacute;spede:</strong></td><td><input type='text' name='hotCod' id='hotCod' class='input' value='".$_SESSION['codHotS']."' size='80' />
  </td></tr>
		  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td><input class='input' name='cargoHot' id='cargoHot' type='text' size='30' value='".$_SESSION['cargoHotS']."' maxlength='39'/> <font size='-2'>Preencher somente se quiser alterar a fun&ccedil&atildeo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  <tr><td>
  <strong>Reserva (RL):</strong></td><td><input class='input' name='rlHot' id='rlHot' type='text' size='20' onkeyup=\"somenteNumeros(this)\" value='".$_SESSION['rlHotS']."' maxlength='11'/><br />
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Dt. In&iacute;cio:</strong></td><td><input readonly class='input' name='inicioHot' id='inicioHot' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['inicioHotS']."' />
<span style='padding-left:50px'>
	<strong><font color=red>*</font>Dt. Fim:</strong><input class='input' readonly name='fimHot' value='".$_SESSION['fimHotS']."' id='fimHot' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" />
  </td></tr>
  <tr><td colspan='2'><input name='atJus' class='buttonVerde' type='submit' value='Incluir H&oacute;spede' /></td></tr>
  </table>";
	   }
	  echo "<br><br><br><p align='left'><a href=\"ciWInserirItens.php\"><img width='62px' height='27px' src='imagens/botaoVoltar.png'></a></p></div></body>
  </html>";
  ?>
  
