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
  <!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="jqueryDown/jquery-1.8.2.js"></script> 
<script src="jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="jqueryDown/jquery-1.9.0-ui.css" /> 
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
   <strong> CI N&ordm; <font size="3" color="red"><?php echo $solicitacao; ?></font></strong><br />
   Item: <?php echo $sequencia; ?><br />
   <?php
   $contador=0;
   if($_SESSION['readOnly']==''){
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
   echo "<br/><table><tr><td><form action='ciWExcMult.php' name='exclusivoMult' method='post'><input class='input' name='sequencia' id='sequencia' type='hidden' size='8' value='".$sequencia."'  /><input class='input' name='retorno' id='retorno' type='hidden' size='8' value='atualiza'  /><input class='input' name='solicitacao' id='solicitacao' type='hidden' size='8' value='".$solicitacao."'  /><input class='input' name='tipo' id='tipo' type='hidden' size='8' value='".$tipo."'  /><input class='input' name='usuario' id='usuario' type='hidden' size='8' value='".$usuario."'  /><input class='buttonVerde' value='Selecionar M&uacute;ltiplos' type='submit' name='multiplos'/></form></td>";
	if($nova==1){
	//Botão para copiar itens de outro exclusivo
	echo "<td><form action='ciWExcCop.php' name='exclusivoCopia' method='post'><input class='input' name='sequencia' id='sequencia' type='hidden' size='8' value='".$sequencia."'  /><input class='input' name='tipo' id='tipo' type='hidden' size='8' value='".$tipo."'  /><input class='input' name='retorno' id='retorno' type='hidden' size='8' value='atualiza'  /><input class='input' name='solicitacao' id='solicitacao' type='hidden' size='8' value='".$solicitacao."'  /><input class='input' name='usuario' id='usuario' type='hidden' size='8' value='".$usuario."'  /><input class='buttonVerde' value='Copiar Itens' type='submit' name='copia'/></form></td></tr>";
	}
   }
   echo "</table><br><br><form action='ciWAtExAt.php' name='exclusivo' method='post' onsubmit=\"this.elements['atJus'].disabled=true;\">
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
	   if($_SESSION['readOnly']<>''){
		   ?>
       <script type="text/javascript">
       alert("Item n\u00e3o est\u00e1 dispon\u00edvel para altera\u00e7\u00e3o e\u00e3o possui nenhum dado exclusivo cadastrado.");
        window.location="ciWItens.php";
       </script>
       <?php
		   }else{
	   $contador=1;
   echo "<strong>CADASTRAR NOVO ITEM EXCLUSIVO</strong><br /><br />
	   <input type='hidden' name='tipo' value='".$tipo."'/>";
	   if($tipo=='rpa'){
		  echo "<table border='0'>
		  <div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td colspan='2'><h3>RPA - Recibo Pagamento Aut&ocirc;nomo</h3></td></tr>
		  <tr><td><strong><font color=red>*</font>Benefici&aacute;rio:</strong> </td><td colspan='2'> <input class='input' name='rpaCod' id='rpaCod' type='text' size='85' value='".$_SESSION['codRpaS']."'/>
  </td></tr>
  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td colspan='2'><input class='input' name='cargoRpa' id='cargoRpa' type='text' size='40' maxlength='39' value='".$_SESSION['cargoRpaS']."' /><font size='-2'>Preencher somente se quiser alterar a fun&ccedil&atildeo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  
  <tr><td>
	<strong><font color=red>*</font>In&iacute;cio:</strong></td><td><input class='input' name='inicioRpa' id='inicioRpa' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" readonly value='".$_SESSION['inicioRpaS']."'/>
  <span style='padding-left:53px'>
	<strong><font color=red>*</font>Fim:</strong><input class='input' name='fimRpa' id='fimRpa' type='text' size='10' value='".$_SESSION['fimRpaS']."' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" readonly/>
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor:</strong></td><td><input class='input' name='valorRpa' id='valorRpa' type='text' value='".$_SESSION['vlRpaS']."' size='10' maxlength='11' onkeyup=\"somenteNumeros(this)\"/><br />
  </td></tr>
  </table>";
	   }elseif($tipo=='diaria'){
		  echo "<table border='0'>
		   <div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td colspan='2'><h3>DI&Aacute;RIAS/AUX&Iacute;LIO VIAGEM</h3></td></tr>
		  <tr><td><strong><font color=red>*</font>Benefici&aacute;rio:</strong></td><td> <input type='text' name='diaCod' id='diaCod' class='input' size='85' value='".$_SESSION['codDiaS']."'/>
  </td></tr>
  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td> <input class='input' name='cargoDia' id='cargoDia' type='text' size='40' maxlength='39' value='".$_SESSION['cargoDiaS']."'/> <font size='-2'>Preencher somente se quiser alterar a fun&ccedil&atildeo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>In&iacute;cio:</strong></td><td><input class='input' name='inicioDia' id='inicioDia' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" readonly value='".$_SESSION['inicioDiaS']."'/>
<span style='padding-left:53px'>
	<strong><font color=red>*</font>Fim:</strong><input readonly class='input' name='fimDia' id='fimDia' type='text' size='10' value='".$_SESSION['fimDiaS']."' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" />
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor:</strong></td><td><input class='input' name='valorDia' id='valorDia' type='text' size='10' value='".$_SESSION['vlDiaS']."' onkeyup=\"somenteNumeros(this)\" maxlength='11'/><br />
  </td></tr>
  </table>";
	   }elseif($tipo=='passagem'){
		  echo "<table border='0'>
		  <div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td><h3>PASSAGENS</h3></td></tr>
		  <tr><td><strong><font color=red>*</font>Passageiro:</strong></td><td> <input type='text' name='pasCod' id='pasCod' class='input' value='".$_SESSION['codPasS']."' size='80' />
  </td></tr>
  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td><input class='input' name='cargoPas' id='cargoPas' type='text' size='30' maxlength='39' value='".$_SESSION['cargoPasS']."' /> <font size='-2'>Preencher campo somente se quiser alterar o cargo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Dt. Partida:</strong></td><td><input readonly class='input' name='inicioPas' id='inicioPas' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['inicioPasS']."' />
<span style='padding-left:50px'>
  <strong><font color=red>*</font>Hora de Partida:</strong><input class='input' name='horaPtPas' value='".$_SESSION['horaInicioS']."' id='horaPtPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2'/>:<input class='input' name='minutoPtPas' value='".$_SESSION['minutoInicioS']."' id='minutoPtPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2'/><br />
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Dt. Retorno:</strong></td><td><input readonly class='input' name='fimPas' id='fimPas' value='".$_SESSION['fimPasS']."' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" />
<span style='padding-left:40px'>
  <strong><font color=red>*</font>Hora de Retorno:</strong><input class='input' name='horaRetPas' id='horaRetPas' type='text' size='2'  value='".$_SESSION['horaFimS']."' onkeypress=\"return validNumb(event)\" maxlength='2'/>:<input class='input' name='minutoRetPas' value='".$_SESSION['minutoFimS']."' id='minutoRetPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2'/><br />
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
		  <tr><td><h3>HOSPEDAGEM</h3></td></tr>
		  <tr><td><strong>H&oacute;spede:</strong></td><td><input type='text' name='hotCod' id='hotCod' class='input' value='".$_SESSION['codHotS']."' size='85' />
  </td></tr>
		  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td><input class='input' name='cargoHot' id='cargoHot' type='text' size='40' value='".$_SESSION['cargoHotS']."' maxlength='39'/> <font size='-2'>Preencher somente se quiser alterar a fun&ccedil&atildeo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  <tr><td>
  <strong>Reserva (RL):</strong></td><td><input class='input' name='rlHot' id='rlHot' type='text' size='10' onkeyup=\"somenteNumeros(this)\" value='".$_SESSION['rlHotS']."' maxlength='11'/><br />
  </td></tr>
  <tr><td>
	<strong>Dt. In&iacute;cio:</strong></td><td><input readonly class='input' name='inicioHot' id='inicioHot' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['inicioHotS']."' />
<span style='padding-left:35px'>
	<strong>Dt. Fim:</strong><input class='input' readonly name='fimHot' value='".$_SESSION['fimHotS']."' id='fimHot' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" />
  </td></tr>
  </table>";
  }else{
	?>
       <script type="text/javascript">
       alert("Esse item n\u00e3o permite a inclus\u00e3o de exclusivos.");
       window.location="ciWItens.php";
       </script>
       <?php  
	  }
		  echo "<tr><td><input name='atJus' class='buttonVerde' type='submit' value='Cadastrar' /></td></tr></table></form>";
     }
   }elseif($rpa==1){
							  $SQLItemRPAImp = " Select Distinct
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
							  
							  from
							  TEITEMSOLRPA rpa with (nolock) 
								 inner join GEEMPRES nom with (nolock) on
									nom.Cd_empresa = rpa.cd_empresa
								left join GEPFISIC pes with (nolock) on
									pes.Cd_empresa = nom.Cd_empresa
							  where
								 rpa.cd_solicitacao = '".$solicitacao."'
								 AND rpa.sequencia='".$sequencia."'";
					  $resItemRPAImp = odbc_exec($conCab, $SQLItemRPAImp);
							  if(odbc_num_rows($resItemRPAImp)>0){
								  echo "<div id='tabela' ><table width='100%' border='0'>
								  <tr><th colspan='7' align='center'><p align='center'>RPA - Recibo de Pagamento Aut&ocirc;nomo</p></th></tr>
								  <tr bgcolor='#D8D8D8'><td><strong>PROFISSIONAL/BENEFICI&Aacute;RIO</strong></td><td><strong>CARGO</strong></td><td><strong>IN&Iacute;CIO</strong></td><td><strong>T&Eacute;RMINO</strong></td><td><strong>VALOR</strong></td><td><strong>EDITAR</strong></td><td><strong>EXCLUIR</strong></td></tr>";
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
										if($objItemRPAImp->id_registro<>$idAnterior){
											$idAnterior=$objItemRPAImp->id_registro;
									  echo "<tr><td>".$objItemRPAImp->Profissional."</td><td>".$cargoImpCiRpa."</td><td>".date('d/m/Y',strtotime($objItemRPAImp->dt_inicio))."</td><td>".date('d/m/Y',strtotime($objItemRPAImp->dt_fim))."</td><td>R$ ".number_format($objItemRPAImp->valor, 2, ',', '.')."</td>";
									  if($_SESSION['readOnly']<>''){
		   echo "<td colspan='2'>N&atilde;o edit&aacute;vel";
		   }else{
									  echo "<td><a href='ciWRpaEditAt.php?id=".$objItemRPAImp->id_registro."'><input  class='button' type='button' value='Editar' /></a></td><td><center><a href='ciWRpaDelAt.php?id=".$objItemRPAImp->id_registro."' onclick=\"return confirm('Deseja realmente remover esse item?')\"><input  class='button' type='button' value='X' /></a></center>";
		   }
									  echo "</td></tr>";
									  $totalRpa=$totalRpa+$objItemRPAImp->valor;			
										}
									  }
								  
								  echo "<tr><th colspan='4'>TOTAL</th><th colspan='3'>R$".number_format($totalRpa, 2, ',', '.')."</th></table></div>";
								  }
								  $totalGeral=$totalRpa;
								  if($_SESSION['readOnly']==''){
	   echo"<br><br> <table width='100%' border='0'>
	   <div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td colspan='2'><h3>RPA - Recibo Pagamento Aut&ocirc;nomo</h3></td></tr>
		  <tr><td><strong><font color=red>*</font>Benefici&aacute;rio:</strong> </td><td colspan='2'> <input class='input' name='rpaCod' id='rpaCod' type='text' size='85' value='".$_SESSION['codRpaS']."'/>
  </td></tr>
  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td colspan='2'><input class='input' name='cargoRpa' id='cargoRpa' type='text' size='40' maxlength='39' value='".$_SESSION['cargoRpaS']."' /><font size='-2'>Preencher somente se quiser alterar a fun&ccedil&atildeo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  
  <tr><td>
	<strong><font color=red>*</font>In&iacute;cio:</strong></td><td><input class='input' name='inicioRpa' id='inicioRpa' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" readonly value='".$_SESSION['inicioRpaS']."'/>
  <span style='padding-left:50px'>
	<strong><font color=red>*</font>Fim:</strong><input class='input' name='fimRpa' id='fimRpa' type='text' size='10' value='".$_SESSION['fimRpaS']."' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" readonly/>
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor:</strong></td><td><input class='input' name='valorRpa' id='valorRpa' type='text' value='".$_SESSION['vlRpaS']."' size='10' maxlength='11' onkeyup=\"somenteNumeros(this)\"/><input class='input' name='TotalRpa' id='TotalRpa' type='hidden' size='8' value='".$totalRpa."'/><input class='input' name='contRpa' id='contRpa' type='hidden' size='8' value='".$contador."'/><br />
  </td></tr>
  </td></tr>
  <tr><td><input name='atJus' class='buttonVerde' type='submit' value='Cadastrar Item' /></td></tr>
  </table>";
		}
   }elseif($diaria==1){
	   $SQLItemDiariaImp = "Select Distinct dia.id_registro,
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
								  echo "<div id='tabela'><table width='100%' border='0'>
								  <tr><th colspan='7' align='center'><p align='center'>Di&aacute;ria / Aux&iacute;lio Viagem</p></th></tr>
								  <tr bgcolor='#D8D8D8'><td><strong>PROFISSIONAL/BENEFICI&Aacute;RIO</strong></td><td><strong>CARGO</strong></td><td><strong>IN&Iacute;CIO</strong></td><td><strong>T&Eacute;RMINO</strong></td><td><strong>VALOR</strong></td><td><strong>EDITAR</STRONG></Td><td><strong>EXCLUIR</STRONG></Td></tr>";
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
									  echo "<tr><td>".$objItemDiariaImp->Profissional."</td><td>".$cargoImpCiDiaria."</td><td>".date('d/m/Y',strtotime($objItemDiariaImp->dt_inicio))."</td><td>".date('d/m/Y',strtotime($objItemDiariaImp->dt_termino))."</td><td>R$ ".number_format($objItemDiariaImp->valor, 2, ',', '.')."</td>";
									  if($_SESSION['readOnly']<>''){
		   echo "<td colspan='2'>N&atilde;o edit&aacute;vel";
		   }else{
									  echo "<td><a href='ciWDiaEditAt.php?id=".(int)$objItemDiariaImp->id_registro."'><input  class='button' type='button' value='Editar' /></a></td><td><center><a href='ciWDiaDelAt.php?id=".(int)$objItemDiariaImp->id_registro."' onclick=\"return confirm('Deseja realmente remover esse item?')\"><input  class='button' type='button' value='X' /></center></a>";
		   }
									  echo "</td></tr>";
				  $totalDiaria=$totalDiaria+$objItemDiariaImp->valor;			
				  }
								  }
								  
								  echo "<tr><th colspan='4'>TOTAL</th><th colspan='3'>R$ ".number_format($totalDiaria, 2, ',', '.')."</td></table></div>";
								  }
								  $totalGeral=$totalDiaria;
	   if($_SESSION['readOnly']==''){
	   echo "<br><br><table width='100%' border='0'>
	      <div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td colspan='2'><h3>DI&Aacute;RIAS/AUX&Iacute;LIO VIAGEM</h3></td></tr>
		  <tr><td><strong><font color=red>*</font>Benefici&aacute;rio:</strong></td><td> <input type='text' name='diaCod' id='diaCod' class='input' size='85' value='".$_SESSION['codDiaS']."'/>
  </td></tr>
  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td> <input class='input' name='cargoDia' id='cargoDia' type='text' size='40' maxlength='39' value='".$_SESSION['cargoDiaS']."'/> <font size='-2'>Preencher somente se quiser alterar a fun&ccedil&atildeo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>In&iacute;cio:</strong></td><td><input class='input' name='inicioDia' id='inicioDia' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" readonly value='".$_SESSION['inicioDiaS']."'/>
<span style='padding-left:50px'>
	<strong><font color=red>*</font>Fim:</strong><input readonly class='input' name='fimDia' id='fimDia' type='text' size='10' value='".$_SESSION['fimDiaS']."' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" />
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor:</strong></td><td><input class='input' name='valorDia' id='valorDia' type='text' size='8' value='".$_SESSION['vlDiaS']."' onkeyup=\"somenteNumeros(this)\" maxlength='11'/><input class='input' name='TotalDia' id='valorDia' type='hidden' size='8' value='".$totalDiaria."'/><input class='input' name='contDia' id='contDia' type='hidden' size='8' value='".$contador."'/><br />
  </td></tr>
  <tr><td><input name='atJus' class='buttonVerde' type='submit' value='Cadastrar' /></td></tr>
  </table>";
	      }
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
								  echo "<div id='tabela'><table border='0'>
								  <tr><th colspan='8' align='center'><p align='center'>PASSAGENS</p></th></tr>
								  <tr bgcolor='#D8D8D8'><td><strong>NOME</strong></td><td><strong>TRECHO</strong></td><td><strong>IDA</strong></td><td><strong>VOLTA</strong></td><td><strong>CADEIRANTE</strong></td><td><strong>VALOR</STRONG></Td><td><strong>EDITAR</STRONG></Td><td><strong>EXCLUIR</STRONG></Td></tr>";
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
								  echo "<tr><td>".$objItemPassImp->nome_completo."</td><td>".$objItemPassImp->trecho."</td><td>".date('d/m/Y',strtotime($objItemPassImp->dt_partida))."-".date('H:i',strtotime($objItemPassImp->hr_partida))."</td><td>".$chegadaPassagem."-".$hrchegadaPassagem."</td><td>".$objItemPassImp->cadeirante."</td><td>".number_format($objItemPassImp->valor, 2, ',', '.')."</td>";
								  if($_SESSION['readOnly']<>''){
		   echo "<td colspan='2'>N&atilde;o edit&aacute;vel";
		   }else{
								  echo "<td><a href='ciWPasEditAt.php?id=".$objItemPassImp->id_registro."'><input  class='button' type='button' value='Editar' /></a></td><td><a href='ciWPasDelAt.php?id=".$objItemPassImp->id_registro."' onclick=\"return confirm('Deseja realmente remover esse item?')\"><input  class='button' type='button' value='X' /></a>";
								  }
								  echo "</td></tr>";
				  $totalPassagem=$totalPassagem+$objItemPassImp->valor;
								  }
  }
  
								  echo "<tr><th colspan='5'>TOTAL</th><th colspan='3'>".number_format($totalPassagem, 2, ',', '.')."</th></table></div>";
								  }
								  $totalGeral=$totalPassagem;
	   if($_SESSION['readOnly']==''){
		    echo "<br><br><br><br><table border='0'>
			<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		   <tr><td><h3>PASSAGENS</h3></td></tr>
		  <tr><td><strong><font color=red>*</font>Passageiro:</strong></td><td> <input type='text' name='pasCod' id='pasCod' class='input' value='".$_SESSION['codPasS']."' size='85' />
  </td></tr>
  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td><input class='input' name='cargoPas' id='cargoPas' type='text' size='35' maxlength='39' value='".$_SESSION['cargoPasS']."' /> <font size='-2'>Preencher campo somente se quiser alterar o cargo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Dt. Partida:</strong></td><td><input readonly class='input' name='inicioPas' id='inicioPas' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['inicioPasS']."' />
<span style='padding-left:50px'>
  <strong><font color=red>*</font>Hora de Partida:</strong><input class='input' name='horaPtPas' value='".$_SESSION['horaInicioS']."' id='horaPtPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2'/>:<input class='input' name='minutoPtPas' value='".$_SESSION['minutoInicioS']."' id='minutoPtPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2'/><br />
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Dt. Retorno:</strong></td><td><input readonly class='input' name='fimPas' id='fimPas' value='".$_SESSION['fimPasS']."' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" />
<span style='padding-left:40px'>
  <strong><font color=red>*</font>Hora de Retorno:</strong><input class='input' name='horaRetPas' id='horaRetPas' type='text' size='2'  value='".$_SESSION['horaFimS']."' onkeypress=\"return validNumb(event)\" maxlength='2'/>:<input class='input' name='minutoRetPas' value='".$_SESSION['minutoFimS']."' id='minutoRetPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2'/><br />
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor:</strong></td><td><input class='input' name='valorPas' id='valorPas' type='text' size='10' value='".$_SESSION['vlPasS']."'  onkeyup=\"somenteNumeros(this)\" maxlength='11'/><br />
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
  <tr><td colspan='2'><input class='input' name='TotalPas' id='TotalPas' type='hidden' size='8' value='".$totalPassagem."'/><input class='input' name='contPas' id='contPas' type='hidden' size='8' value='".$contador."'/><input name='atJus' class='buttonVerde' type='submit' value='Cadastrar Passageiro' /></td></tr>
  </table>";
	   		}
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
								  echo "<div id='tabela'><table width='100%' border='0'><tr><th colspan='7' align='center'><p align='center'>HOSPEDAGEM</p></th></tr>
								  <tr bgcolor='#D8D8D8'><td><strong>RL</strong></td><td><strong>NOME</strong></td><td><strong>CARGO</strong></td><td><strong>IDA</strong></td><td><strong>VOLTA</strong></td><td><strong>EDITAR</STRONG></Td><td><strong>EXCLUIR</STRONG></Td></tr>";
								  $idAnterior='';
								  while($objItemHotelImp = odbc_fetch_object($resItemHotelImp)){
									  if(empty($objItemHotelImp->cargo)){
										  $cargoImpCiHotel=$objItemHotelImp->funcao;
										  }else{
											  $cargoImpCiHotel=$objItemHotelImp->cargo;
											  }
											  if($objItemHotelImp->id_registro<>$idAnterior){
												  $idAnterior=$objItemHotelImp->id_registro;
									  echo "<tr><td>".(int)$objItemHotelImp->reserva."</td><td>".$objItemHotelImp->Nome_completo."</td><td>".$cargoImpCiHotel."</td><td>".date('d/m/Y',strtotime($objItemHotelImp->dt_entrada))."</td><td>".date('d/m/Y',strtotime($objItemHotelImp->dt_saida))."</td>";
									  if($_SESSION['readOnly']<>''){
		   echo "<td colspan='2'>N&atilde;o edit&aacute;vel";
		   }else{									  
									  echo "<td><a href='ciWHotEditAt.php?id=".$objItemHotelImp->id_registro."'><input  class='button' type='button' value='Editar' /></a></td><td><center><a href='ciWHotDelAt.php?id=".$objItemHotelImp->id_registro."' onclick=\"return confirm('Deseja realmente remover esse item?')\"><input  class='button' type='button' value='X' /></center></a>";
								       } 
									  echo "</td></tr>";
									  }
								  }
								  echo "</table></div>";
								  }			
								  $totalGeral="hotel";
	  if($_SESSION['readOnly']==''){
	  echo "<br><br><table border='0'>
		 <div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td colspan='2'><h3>HOSPEDAGEM</h3></td></tr>
		  <tr><td><strong><font color=red>*</font>H&oacute;spede:</strong></td><td><input type='text' name='hotCod' id='hotCod' class='input' value='".$_SESSION['codHotS']."' size='85' />
  </td></tr>
		  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td><input class='input' name='cargoHot' id='cargoHot' type='text' size='40' value='".$_SESSION['cargoHotS']."' maxlength='39'/> <font size='-2'>Preencher somente se quiser alterar a fun&ccedil&atildeo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  <tr><td>
  <strong>Reserva (RL):</strong></td><td><input class='input' name='rlHot' id='rlHot' type='text' size='10' onkeyup=\"somenteNumeros(this)\" value='".$_SESSION['rlHotS']."' maxlength='11'/><br />
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Dt. In&iacute;cio:</strong></td><td><input readonly class='input' name='inicioHot' id='inicioHot' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$_SESSION['inicioHotS']."' />
<span style='padding-left:35px'>
	<strong><font color=red>*</font>Dt. Fim:</strong><input class='input' readonly name='fimHot' value='".$_SESSION['fimHotS']."' id='fimHot' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" />
 </td></tr>
  <tr>
  
  <td colspan='2'><input name='atJus' class='buttonVerde' type='submit' value='Cadastrar H&oacute;spede' /></td></tr>
  </table>";
	   }
	 }
	  echo "<br/><a href=\"ciWItens.php\"><input  class='button' type='button' value='Voltar' /></a></body>
  </div></html>";
  ?>