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
<script type='text/javascript' src='jquery_price.js'></script>
 <script type="text/javascript">
  $(document).ready(function(){
      $('#lei').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
</script>
</head>

<body>
<div id="box3">
<h2>Or&ccedil;amento - Lan&ccedil;amentos Financeiros</h2>
<?php 
include "funcOrc.php";
include "mb.php";
$nomeConta=buscaNomeConta($_POST['conta']);
require "conectOrc.php";
$selectValores=mysql_query("SELECT * FROM limites WHERE conta='".$_POST['conta']."'") or die(mysql_error());
$arrayValores=mysql_fetch_array($selectValores);
$insere=0;
if(empty($arrayValores)){
			?>
       <script type="text/javascript">
       alert("Não existem valores de limites lançados para essa Conta Gerencial.");
       history.back();
       </script>
       <?php
	}else{
echo "<h2>".$nomeConta."</h2><input type='hidden' name='conta' class='input' value='".$_POST['conta']."'/>";

$totalPrevisto=(float)$arrayValores['lei']+(float)$arrayValores['patcef']+(float)$arrayValores['patdiv']+(float)$arrayValores['siconv']+(float)$arrayValores['testesp']+(float)$arrayValores['timerio']+(float)$arrayValores['timesp']+(float)$arrayValores['jogosochi']+(float)$arrayValores['reserva'];

$totalDisponivel=(float)$arrayValores['utlei']+(float)$arrayValores['utpatcef']+(float)$arrayValores['utpatdiv']+(float)$arrayValores['utsiconv']+(float)$arrayValores['uttestesp']+(float)$arrayValores['uttimerio']+(float)$arrayValores['uttimesp']+(float)$arrayValores['utjogosochi']+(float)$arrayValores['utreserva'];
echo "<div id='tabela' align='right'><table border=0 class='tabela'>
<tr><th>Tipo</th><th>Inicial</th><th>Provisionado</th><th>Dispon&iacute;vel</th></tr>
<tr>
<td>LEI</td><td><strong>R$</strong>".$arrayValores['lei']."</td><td></td><td><strong>R$</strong>".$arrayValores['utlei']."</td></tr>
<td>Patroc&iacute;nio CEF</td><td><strong>R$</strong>".$arrayValores['patcef']."</td><td></td><td><strong>R$</strong>".$arrayValores['utpatcef']."</td></tr>
<td>Patroc&iacute;nio Diversos</td><td><strong>R$</strong>".$arrayValores['patdiv']."</td><td></td><td><strong>R$</strong>".$arrayValores['utpatdiv']."</td></tr>
<td>SICONV</td><td><strong>R$</strong>".$arrayValores['siconv']."</td><td></td><td><strong>R$</strong>".$arrayValores['utsiconv']."</td></tr>
<td>Fundo Reserva</td><td><strong>R$</strong>".$arrayValores['reserva']."</td><td></td><td><strong>R$</strong>".$arrayValores['utreserva']."</td></tr>
<td>Testes Especiais</td><td><strong>R$</strong>".$arrayValores['testesp']."</td><td></td><td><strong>R$</strong>".$arrayValores['uttestesp']."</td></tr>
<td>Time Rio</td><td><strong>R$</strong>".$arrayValores['timerio']."</td><td></td><td><strong>R$</strong>".$arrayValores['uttimerio']."</td></tr>
<td>Time S&atilde;o Paulo</td><td><strong>R$</strong>".$arrayValores['timesp']."</td><td></td><td><strong>R$</strong>".$arrayValores['uttimesp']."</td></tr>
<td>Jogos Socchi</td><td><strong>R$</strong>".$arrayValores['jogosochi']."</td><td></td><td><strong>R$</strong>".$arrayValores['utjogosochi']."</td></tr>
<th>TOTAL CONTA</th><th><strong>R$ </strong>".number_format($totalPrevisto, 2, '.', ' ')."</th><th></th><th><strong>R$ </strong>".number_format($totalDisponivel, 2, '.', ' ')."</th>
</tr>

</table></div><br>";
require "conectsqlserverci.php";
$sqlLancamentosGeral="Select
  GFLANCAM.Cd_lancamento,
  GFLANCAM.Historico,
  GFLANCAM.Cd_conta,
  GFCONTA.Cd_conta As Cd_conta1,
  GFCONTA.Descricao,
  GFLANCAM.Documento,
  GFLANCAM.Projeto,
  GFCONTA.Cd_contabil_con,
  GFRGEREN.Cd_conta_gerenc,
  CCPCC.Pcc_nome_conta,
  GFLANCAM.Numero_no_banco,
  CCPCC.Pcc_classific_c,
  GFLANCAM.Valor,
  GFLANCAM.Data
From
  GFLANCAM Inner Join
  GFCONTA On GFLANCAM.Cd_conta = GFCONTA.Cd_conta Inner Join
  GFRGEREN On GFLANCAM.Cd_lancamento = GFRGEREN.Cd_lancamento Inner Join
  CCPCC On GFRGEREN.Cd_conta_gerenc = CCPCC.Pcc_classific_c
Where
CCPCC.Pcc_classific_c LIKE '".trim($_POST['conta'])."%' And 
 GFLANCAM.Situacao <> 'L'
 ORDER BY
GFLANCAM.Documento,
GFLANCAM.Projeto";
  $exec=odbc_exec($conCab,$sqlLancamentosGeral);
  echo "<div id='tabela'>
		  <table border='0'>
		  <tr>
		     <th colspan='5'>Lan&ccedil;amentos Financeiros Vinculados</td>
		  </tr>
		  <tr>
		      <th>Data</th><th>N&ordm; CI</th><th>Processo</th><th>Descricao</th><th>Valor(R$)</th><th>Selecione<br> Conta</th><th>Liquidado</th>
		  </tr>";
  while($objLanc=odbc_fetch_object($exec)){
	  $numCi=trim($objLanc->Documento);
	  if(!empty($numCi)){
		  echo "<tr><td>".date('d/m/Y',strtotime($objLanc->Data))."</td><td>".$numCi."</td><td>".$objLanc->Projeto."</td><td>".$objLanc->Descricao."</td><td>".number_format(-($objLanc->Valor), 2, '.', ' ')."</td><td><select name='tipoConta'><option selected value=''>Selecione</option>
		  <option value='lei'>Lei</option>
		  <option value='patcef'>Pat. CEF</option>
		  <option value='patdiv'>Pat. Diversos</option>
		  <option value='siconv'>SICONV</option>
		  <option value='reserva'>Fundo Reserva</option>
		  <option value='testesp'>Testes Esp.</option>
		  <option value='timerio'>Time Rio</option>
		  <option value='timesp'>Time SP</option>
		  <option value='jogosochi'>Jogos Socchi</option>
		  </td><td><input name='liquidado' type='checkbox' value='' /></td></tr>";
		  }
	  }
	  echo "
		  <tr><td colspan='7' align='right'><input type='submit' class='button' name='sub' value='Salvar'/></td></tr>
		  </table>
		  </div>";
echo "<div id='tabela'>
		  <table border='0'>
		  <tr>
		     <th colspan='5'>Lan&ccedil;amentos Financeiros Sem V&iacute;nculo</td>
		  </tr>
		  <tr>
		      <th>Data</th><th>N&ordm; CI</th><th>Processo</th><th>Descricao</th><th>Valor(R$)</th>
		  </tr>";
		  $exec2=odbc_exec($conCab,$sqlLancamentosGeral);
  while($objLancP=odbc_fetch_object($exec2)){
	  $processo=trim($objLancP->Projeto);
	  if(!empty($processo)){
		  echo "<tr><td>".date('d/m/Y',strtotime($objLancP->Data))."</td><td><input type='text' name='ci' size=10/></td><td>".$objLancP->Projeto."</td><td>".$objLancP->Descricao."</td><td>".number_format(-($objLancP->Valor), 2, '.', ' ')."</td></tr>";
		  }
	  }
	  echo "
	  <tr><td colspan='7' align='right'><input type='submit' class='button' name='sub' value='Salvar'/></td></tr>
		  </table>
		  </div>";
?>
</div>
</body>
</html>
<?php 
	}
?>