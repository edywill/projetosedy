<?php 
session_start();
require "../conectsqlserver.php";
require "conectsqlserversav.php";
require "../conect.php";

if(!empty($_POST['id'])){
$numSav=$_POST['id'];
$_SESSION['numSav']=$numSav;
}

$sqlDadosSav=mysql_fetch_array(mysql_query("SELECT * FROM savregistros WHERE id='".$_SESSION['numSav']."'"));

$nautor='';
$anoautor='';
$qtddias='';
$valordia='';
$numproc='';

$sqlDadosDiaria=mysql_fetch_array(mysql_query("SELECT * FROM savdiarias WHERE idsav='".$_SESSION['numSav']."'"));
if(!empty($sqlDadosDiaria)){
		$nautor=$sqlDadosDiaria['nautor'];
		$anoautor=$sqlDadosDiaria['ano'];
		$qtddias=$sqlDadosDiaria['qtddias'];
		$valordia=$sqlDadosDiaria['valortotal'];
		$numproc=$sqlDadosDiaria['numproc'];
		}else{
			$sqlNumAutMax=mysql_fetch_array(mysql_query("SELECT MAX(nautor)AS autor FROM savdiarias WHERE ano='".date('Y')."'"));
			$nautor=$sqlNumAutMax['autor']+1;
			$anoautor=date('Y');
			}
$dadosFuncionario=odbc_fetch_array(odbc_exec($conCab,"Select
  RHPESSOAS.NOME,
  RHPESSOAS.PESSOA,
  RHSETORES.DESCRICAO40 As SETORCOMPLETO,
  RHSETORES.DESCRICAO20 As SETORSIGLA,
  RHCARGOS.CARGO,
  RHCARGOS.DESCRICAO20 As NOMECARGO,
  RHPESSOAS.CPF,
  RHCONTRATOS.BANCOCREDOR,
  RHBANCOS.DESCRICAO40 As NOMEBANCO,
  RHBANCOS.AGENCIA,
  RHBANCOS.NROBANCO,
  RHCONTRATOS.CONTACORRENTE
From
  RHPESSOAS (nolock) Inner Join
  RHCONTRATOS (nolock) On RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHESCALAS (nolock) On RHCONTRATOS.ESCALA = RHESCALAS.ESCALA Inner Join
  RHSETORES (nolock) On RHCONTRATOS.SETOR = RHSETORES.SETOR Inner Join
  RHCARGOS (nolock) On RHCONTRATOS.CARGO = RHCARGOS.CARGO Inner Join
  RHBANCOS (nolock) On RHCONTRATOS.BANCOCREDOR = RHBANCOS.BANCO
Where
  RHCONTRATOS.DATARESCISAO Is Null AND RHPESSOAS.PESSOA='".$sqlDadosSav['funcionario']."'"));
  $tipoFunc='Funcionário';
  $consultaClasse=mysql_fetch_array(mysql_query("SELECT classe FROM savcargos WHERE id='".$dadosFuncionario['CARGO']."'"));
  if($consultaClasse['classe']<3){
	  $tipoFunc="Dirigente";
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
$().ready(function() {
	$("#proc").autocomplete("../prestcont/suggest_processo.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
});
</script>
<script type="text/javascript">
  $(document).ready(function(){
      $('#vltot').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  </script>
</head>
<body onKeyDown="javascript:return bloqueioTeclas();">
<div id='box3' style="height:auto">
  <h1 id="h1">SAV - Solicita&ccedil;&atilde;o de Aux&iacute;lio Viagem</h1>
  <h2 id="h2"> DADOS DIÁRIA SAV - CI nº: <?php echo $sqlDadosSav['numci']; ?></h2>
<form action="atualizaDadosPrest.php" method="post" name="dadosdiaria">      
 <table border="0" width="100%">
<tr><td width="10%"><strong>Nome:</strong></td><td width="40%"><?php echo utf8_encode($dadosFuncionario['NOME']); ?></td><td width="10%"><strong>Tipo:</strong></td><td width="40%"><?php echo $tipoFunc; ?></td></tr>
<tr><td width="10%"><strong>Cargo:</strong></td><td width="40%"><?php echo utf8_encode($dadosFuncionario['NOMECARGO']); ?></td><td><strong>Setor:</strong></td><td><?php echo utf8_encode($dadosFuncionario['SETORCOMPLETO']); ?></td></tr>
<tr><td><strong>Evento:</strong></td><td colspan="3"><?php echo utf8_encode($sqlDadosSav['evento']); ?></td></tr>
  </table>
 <br /><br />
<table border="0" width="100%">
<tr><td width="10%"><strong>Autorização:</strong></td><td width="40%">
<?php echo $nautor."/".$anoautor; ?>
</td><td width="10%"><strong>Qtd. Diárias:</strong></td><td width="40%"><input class="input" type="number" name="qtd" id="qtd" maxlength="3" size="20" value="<?php echo $qtddias; ?>"/></td></tr>

<tr><td width="10%"><strong>Processo:</strong></td><td width="40%"><input class="input" type="text" name="proc" id="proc" size="40" value="<?php echo utf8_encode($numproc); ?>"/></td><td><strong>Valor Total(R$):</strong></td><td><input class="input" type="text" name="vltot" id="vltot" size="20" value="<?php echo number_format($valordia,2,',','.'); ?>"/></td></tr>
<tr><td colspan="2"><a href="prestCont.php"><input type="button" name="voltar" class="button" value="<<Voltar"/></a></td><td colspan="2" align="right"><input type="submit" name="voltar" class="button" value="ATUALIZAR"/></td></tr>
  </table>
</form>
  </div>
</body>
</html>