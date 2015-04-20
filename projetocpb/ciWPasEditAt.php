  <?php 
  require "conectsqlserverci.php";
  include "mb.php";
  session_start();
  $id=$_GET['id'];
  $sequencia=$_SESSION['sequenciaEx'];
  $solicitacao=$_SESSION['solicitacaoEx'];
  $usuario=$_SESSION['userCi'];
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
$(document).ready(function(e) {
    $('input').keydown(function(){
		 document.getElementById('btnat').style.display="none"
		 document.getElementById('btat').style.visibility="visible"
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
<script language="javascript">
var valor;
var i=0;

function carregadados()
{
for (i=0;i<document.forms[0].length;i++)
{
 valor=valor+ "," +document.forms[0].elements[i].value;
}
valor=valor.split(",");
}

function comparar()
{
 		document.getElementById('btnat').style.display="none"
		 document.getElementById('btat').style.visibility="visible"
}
</script>
</head>
<body onload="carregadados();" onKeyDown="javascript:return bloqueioTeclas();">
<div id='box3'>
   <p><strong>Dados Exclusivos</strong></p>
   <strong>CI N&ordm; <font size="3" color="red"><?php echo $solicitacao; ?></strong></font><br />
   Item: <?php echo $sequencia; ?><br />
   <?php 
   echo "<form action='ciWAtTodos.php' name='exclusivo' method='post' onsubmit=\"this.elements['atJus'].disabled=true;\">
      <input class='input' name='sequencia' id='sequencia' type='hidden' size='8' value=".$sequencia."  />
	  <input class='input' name='solicitacao' id='solicitacao' type='hidden' size='8' value=".$solicitacao."  />
	  <input class='input' name='usuario' id='usuario' type='hidden' size='8' value=".$usuario."  />
	   <input class='input' name='tipo' id='tipo' type='hidden' size='8' value='pas'  />";
	
   
							  $SQLItemPasImp = "select 
								 ROW_NUMBER() over (partition by psg.cd_solicitacao,psg.sequencia order by psg.sequencia) num, 
								 psg.cd_solicitacao,
								 psg.id_registro,
								 psg.sequencia,
								 psg.cargo as cargo1,
								 psg.cd_empresa,
								 nom.Nome_completo,
								 psg.trecho,
								 (psg.dt_partida) ,
								 psg.dt_chegada,
								 psg.observacao,
								 psg.valor,
								 psg.hr_partida,
								 psg.hr_chegada,
								 psg.observacao,
								 pes.Cargo,
								 case when psg.cadeirante = 1 then 'X' end cadeirante 
							  from TEITEMSOLPASSAGEM psg with (nolock)
								 inner join GEEMPRES nom with (nolock) on
									nom.Cd_empresa = psg.cd_empresa
									left join GEPFISIC pes with (nolock) on
											pes.Cd_empresa = nom.Cd_empresa
							  where
								 psg.id_registro=".$id."";
					  $resItemPasImp = odbc_exec($conCab, $SQLItemPasImp);
	                  $arrayItemPasImp=odbc_fetch_array($resItemPasImp);
					  
					  //$arpasHoraPt = explode(':', $arrayItemPasImp['hr_partida']);
					  $horaPt=substr($arrayItemPasImp['hr_partida'],0,2);
					  $minutoPt=substr($arrayItemPasImp['hr_partida'],2,2);
					  $arpasHoraCh = explode(':', $arrayItemPasImp['hr_chegada']);
					  $horaCh=substr($arrayItemPasImp['hr_chegada'],0,2);
					  $minutoCh=substr($arrayItemPasImp['hr_chegada'],2,2);
	   
	   $cargo='';
							  if(empty($arrayItemPasImp['cargo1'])){
								  $cargo=$arrayItemPasImp['Cargo'];
								  }else{
									  $cargo=$arrayItemPasImp['cargo1'];
									  }
									  if(!empty($arrayItemPasImp['dt_chegada'])){
										  $dataRetorno=date("d/m/Y",strtotime($arrayItemPasImp['dt_chegada']));
										  }else{
											  $dataRetorno='';
											  }
	   echo "<br><br><table border='0'>
		  <input class='input' name='id' id='id' type='hidden' value='".trim($id)."'/>
		  <input class='input' name='valorAnt' id='valor' type='hidden' value='".trim($arrayItemPasImp['valor'])."'/>
		  <div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td colspan='2'><h3>PASSAGENS</h3></td></tr>
		  <tr><td><strong><font color=red>*</font>Passageiro:</font></strong></td><td><input type='text' name='pasCod' id='pasCod' class='input' size='85' value='".trim($arrayItemPasImp['cd_empresa'])."-".trim($arrayItemPasImp['Nome_completo'])."'/>
  </td></tr>
  <tr><td>
	<strong>Cargo Novo:</strong></td><td><input class='input' name='cargoPas' id='cargoPas' type='text' size='35' maxlength='39' value='".trim($cargo)."'/> <font size='-2'>Preencher campo somente se quiser alterar a fun&ccedil;&atilde;o para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Dt. Partida:</strong></td><td><input class='input' name='inicioPas' id='inicioPas' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".date("d/m/Y",strtotime($arrayItemPasImp['dt_partida']))."' readonly='readonly' onclick='comparar()'/>
		<span style='padding-left:50px'>
  <strong><font color=red>*</font>Hora de Partida:</strong><input class='input' name='horaPtPas' id='horaPtPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2' value='".$horaPt."'/>:<input class='input' name='minutoPtPas' id='minutoPtPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2' value='".$minutoPt."'/><br />
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Dt. Retorno:</strong></td><td><input class='input' name='fimPas' id='fimPas' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".$dataRetorno."' onclick='comparar()'/>
		<span style='padding-left:40px'>
	<strong><font color=red>*</font>Hora de Retorno:</strong><input class='input' name='horaRetPas' id='horaRetPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2' value='".$horaCh."'/>:<input class='input' name='minutoRetPas' id='minutoRetPas' type='text' size='2' onkeypress=\"return validNumb(event)\" maxlength='2' value='".$minutoCh."'/><br />
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor:</strong></td><td><input class='input' name='valorPas' id='valorPas' type='text' size='8' onkeyup=\"somenteNumeros(this)\" maxlength='11' value='".number_format($arrayItemPasImp['valor'],2,',','.')."'/><br />
  </td></tr>
  <tr><td>
  <strong>Cadeirante:</strong></td><td>";
  if($arrayItemPasImp['cadeirante']=='X'){
   echo "<input name='cadeirantePas'  id='cadeirantePas' type='checkbox' value='1' checked onclick='comparar()'>";
  }else{
   echo "<input name='cadeirantePas'  id='cadeirantePas' type='checkbox' value='1' onclick='comparar()'>";
	  }
  echo "</td></tr>
  <tr><td>
  <strong>Trecho:</strong></td><td><input class='input' name='trechoPas' id='trechoPas' type='text' size='20' maxlength='500' value='".trim($arrayItemPasImp['trecho'])."'/><br />
  </td></tr>
  <tr><td>
  <strong>Observa&ccedil;&atilde;o:</strong></td><td><input class='input' name='obsPas' id='obs' type='text' size='20' maxlength='500' value='".trim($arrayItemPasImp['observacao'])."'/><br />
  </td></tr>
  <tr><td><div id='btnat'>Sem altera&ccedil;&atilde;o</div><div id='btat' style='visibility:hidden'><input name='atJus' class='buttonVerde' type='submit' value='Atualizar Passageiro' /></div><br/><br/></td></tr>
     <tr><td> <a href=\"ciWItensExclusivosAt.php\"><img src='imagens/botaoVoltar.png'></a> </td></tr>
  </table></div>";
  ?>
  
