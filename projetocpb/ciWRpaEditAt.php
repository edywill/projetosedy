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
<script src="jqueryDown/jquery-1.8.2.js"></script> 
<script src="jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="jqueryDown/jquery-1.9.0-ui.css" /> 
  <script src="jqueryDown/jquery-ui.js"></script>
<link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> 
  <script type='text/javascript' src='jquery.autocomplete.js'></script>
  <link rel="stylesheet" type="text/css" href="jquery.autocomplete.css" />
  
  <script type='text/javascript' src='jquery_price.js'></script>
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
<body onKeyDown="javascript:return bloqueioTeclas();">
  <div id='box3'>
   <p><strong>Dados Exclusivos</strong></p>
   <strong>CI N&ordm; <font size="3" color="red"><?php echo $solicitacao; ?></strong></font><br />
   Item: <?php echo $sequencia; ?><br />
   <?php 
   echo "<form action='ciWAtTodos.php' name='exclusivo' method='post' onsubmit=\"this.elements['atJus'].disabled=true;\">
      <input class='input' name='sequencia' id='sequencia' type='hidden' size='8' value=".$sequencia."  />
	  <input class='input' name='solicitacao' id='solicitacao' type='hidden' size='8' value=".$solicitacao."  />
	  <input class='input' name='usuario' id='usuario' type='hidden' size='8' value=".$usuario."  />
	   <input class='input' name='tipo' id='tipo' type='hidden' size='8' value='rpa'  />";
	
   
							  $SQLItemRPAImp = " select
								 rpa.id_registro,
								 rpa.cd_solicitacao,
								 rpa.sequencia,
								 rpa.cd_empresa,
								 nom.Nome_completo Profissional,
								 pes.Cargo,
								 rpa.dt_inicio,
								 rpa.dt_fim,
								 rpa.valor,
								 rpa.cargo As cargo1,
								 rpa.cd_lancamento
							  
							  from TEITEMSOLRPA rpa with (nolock) 
								 inner join GEEMPRES nom with (nolock) on
									nom.Cd_empresa = rpa.cd_empresa
								 left join GEPFISIC pes with (nolock) on
									pes.Cd_empresa = nom.Cd_empresa
							  where
								 rpa.id_registro=".$id."";
					  $resItemRPAImp = odbc_exec($conCab, $SQLItemRPAImp);
	                  $arrayItemRpaImp=odbc_fetch_array($resItemRPAImp);
					  if($arrayItemRpaImp['cd_lancamento']>0){
						   ?>
					   <script type="text/javascript">
                       alert("Aten\u00e7\u00e3o! Esse item n\u00e3o pode ser editado por possuir lan\u00e7amento financeiro.");
                       window.location="ciWItensExclusivosAt.php";
                       </script>
                       <?php
						  }else{
							  $cargo='';
							  if(empty($arrayItemRpaImp['cargo1'])){
								  $cargo=$arrayItemRpaImp['Cargo'];
								  }else{
									  $cargo=$arrayItemRpaImp['cargo1'];
									  }
	   echo "<br><br><table border='0'>
	   <input class='input' name='id' id='id' type='hidden' value='".trim($id)."'/>
	   <input class='input' name='valorAnt' id='valor' type='hidden' value='".trim($arrayItemRpaImp['valor'])."'/>
	      <div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td colspan='2'><h3>ATUALIZAR RPA - Recibo Pagamento Aut&ocirc;nomo</h3></td></tr>
		  <tr><td><strong><font color=red>*</font>Benefici&aacute;rio:</strong></td><td> <input type='text' name='rpaCod' id='rpaCod' class='input' size='80' value='".trim($arrayItemRpaImp['cd_empresa'])."-".trim($arrayItemRpaImp['Profissional'])."'/>
  </td></tr>
  <tr><td>
	<strong>Fun&ccedil;&atilde;o:</strong></td><td><input class='input' name='cargoRpa' id='cargoRpa' type='text' size='30' maxlength='39' value='".trim($cargo)."'/> <font size='-2'>Preencher campo somente se quiser alterar a fun&ccedil;&atilde;o para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>In&iacute;cio:</strong></td><td><input class='input' name='inicioRpa' id='inicioRpa' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".date("d/m/Y",strtotime($arrayItemRpaImp['dt_inicio']))."' readonly='readonly' onclick='comparar()'/>
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Fim:</strong></td><td><input class='input' name='fimRpa' id='fimRpa' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" value='".date("d/m/Y",strtotime($arrayItemRpaImp['dt_fim']))."' readonly='readonly' onclick='comparar()'/>
  </td></tr>
  <tr><td>
	<strong><font color=red>*</font>Valor:</strong></td><td><input class='input' name='valorRpa' id='valorRpa' type='text' size='10' onkeyup=\"somenteNumeros(this)\" maxlength='11' value='".number_format($arrayItemRpaImp['valor'],2,',','.')."'/>
  </td></tr>
  <tr><td><div id='btnat'>Sem altera&ccedil;&atilde;o</div><div id='btat' style='visibility:hidden'><input name='atJus' class='buttonVerde' type='submit' value='Atualizar Item' /></div><br/><br/></td></tr>
   <tr><td> <a href=\"ciWItensExclusivosAt.php\"><input  class='button' type='button' value='Voltar' /></a> </td></tr>
  </table></div>";
						  }
  ?>
  
