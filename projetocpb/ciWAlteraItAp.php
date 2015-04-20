<?php
require "conectsqlserverciprod.php";
include "mb.php";
session_start();
if(empty($_POST['solicitacao'])){
	$solicitacao=$_SESSION['solicitacao'];
    $usuario=$_SESSION['userCi'];
	$desc=$_SESSION['desc_ci'];
	}else{
$solicitacao=$_POST['solicitacao'];
$usuario=$_POST['userCi'];
$desc=$_POST['desc_ci'];
$_SESSION['solicitacao'] = $solicitacao;
$_SESSION['userCi'] = $usuario;
$_SESSION['desc_ci']=$desc;
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
<script type='text/javascript' src='jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="jquery.autocomplete.css" />
 
<script type="text/javascript">
$().ready(function() {
    $("#cdMaterial").autocomplete("suggest_material.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
});
</script>
<script type="text/javascript">
$().ready(function() {
    $("#userSol").autocomplete("suggest_user.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
});
</script>
<script>
$(function() {
    $( "#pzent" ).datepicker({dateFormat: 'dd/mm/yy'});
});
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
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script type="text/javascript">
function goBack()
  {
  window.history.back()
  }
</script>
<script type="text/javascript">
function limitaTextarea(valor) {
	quantidade = 1999;
	total = valor.length;

	if(total <= quantidade) {
		resto = quantidade- total;
		document.getElementById('contador').innerHTML = resto;
	} else {
		document.getElementById('justificativa').value = valor.substr(0, quantidade);
	}
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
		var er = /[^0-9.]/;
		er.lastIndex = 0;
		var campo = num;
		if (er.test(campo.value)) {
		campo.value = "";
		}
	}
</script>
<script type="text/javascript">
$().ready(function() {
    $("#portador").autocomplete("suggest_portador.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
});
</script>

</head>
<body>
<div id='box3'>
<br/>
<strong>CIWEB  - Itens / Portador:</strong><br/>
<?php

?>

<p>
    CI N&ordm; <strong><?php echo $solicitacao; ?></strong><br />
  </p>
  <p><strong>Lista de Itens da CI</strong></p>
  <div id='tabela3'><table border='1'> <tr bgcolor='#658BF3'><td width="21%"><strong>Material</strong></td><td width="13%"><strong>Quantidade</strong></td><td width="15%"><strong>Pre&ccedil;o Unit&aacute;rio</strong></td><td width="12%"><strong>U.M.</strong></td><td width="12%"><strong>Dados Financeiros</strong></td></tr>
  <?php
  $sqlConsItensCi="Select
  ESMATERI.Descricao,
  ESUMEDID.Descricao As Descricao1,
  COISOLIC.Quantidade,
  COISOLIC.Cd_centro_armaz,
  COISOLIC.Pr_unitario,
  COISOLIC.Cd_solicitacao,
  COISOLIC.Sequencia
From
  COISOLIC with (nolock) Inner Join
  ESMATERI with (nolock) On COISOLIC.Cd_material = ESMATERI.Cd_material Inner Join
  ESUMEDID with (nolock) On ESMATERI.Cd_unidade_medi = ESUMEDID.Cd_unidade_medi
  WHERE COISOLIC.Cd_solicitacao=".$solicitacao."";
  $execConsItensCi=odbc_exec($conCab, $sqlConsItensCi) or die("<p>".odbc_errormsg());
  $countConsItensCi=odbc_num_rows($execConsItensCi);
  if(empty($countConsItensCi)){
	  echo "Nenhum &iacute;tem cadastrado at&eacute; o momento.";
	  }else{
		  $totalCi=0;
		  while($objConsItemCI = odbc_fetch_object($execConsItensCi)){
			  
			 echo "<tr><td>".$objConsItemCI->Descricao."</td><td align='center'>".(int)$objConsItemCI->Quantidade."</td><td>R$ ".number_format($objConsItemCI->Pr_unitario, 2, '.', '')."</td><td>".$objConsItemCI->Descricao1."</td><td><form action='ciWDadosFinAltAp.php' method='post' name='ciWCriar'><input name='solic' type='hidden' size='10' value=".$solicitacao." /><input name='sequencia' type='hidden' size='10' value=".$objConsItemCI->Sequencia." /><input name='user' type='hidden' size='10' value=".$usuario." /><input name='AlteraF' type='submit' class='buttonVerde' value='Dados Financeiros' /></form></td></tr>"; 
			  $totalCi=($objConsItemCI->Pr_unitario*$objConsItemCI->Quantidade)+$totalCi;
			  $_SESSION['totalCi']=$totalCi;
			  }
?><tr>
    <td colspan="4" align="center" bgcolor='#658BF3'><strong>VALOR TOTAL DA SOLICITA&Ccedil;&Atilde;O</strong></td><td colspan="2" align="left" bgcolor='#658BF3'><font color="white"><?php echo "R$ ".number_format($totalCi, 2, '.', ''); ?></font></th></tr>
	<?php	  
	}
  ?>
  </table></div>
  <br /><br />
<form action="ciWAtualizaPortador.php" method="post" name="ciWCriar"> 
  <div id='tabela3'><table width="450px"><tr><td bgcolor='#658BF3' >
		<strong>DADOS GERAIS DA CI</strong>
  </td></tr>
<tr><td>
<?php 
$selectPortador=odbc_exec($conCab, "Select
  GFPORTAD.Nome,
  TEPORTADORSOL.cd_portador
From
  
  TEPORTADORSOL(nolock) Inner Join
  GFPORTAD(nolock) On GFPORTAD.Cd_portador = TEPORTADORSOL.cd_portador
Where
  TEPORTADORSOL.solicitacao = '".$solicitacao."' And
  Ativo = 1") or die("<p>".odbc_errormsg());
	$resSelectPortador=odbc_fetch_array($selectPortador);
	if(!empty($resSelectPortador['cd_portador']) || $resSelectPortador['cd_portador']<>' '){
          $dPortador=$resSelectPortador['cd_portador']."-".$resSelectPortador['Nome'];
	    }else{
			$dPortador='';
			}
	 if(trim($dPortador)=="-"){
		 $dPortador='';
		 }
?>
<strong>Portador:</strong> <input class="input" name="user" id="user" type="hidden" value="<?php echo $usuario; ?>"/><input class="input" name="desc_ci" id="user" type="hidden" value="<?php echo $desc; ?>"/><input class="input" name="solicitacao" id="solicitacao" type="hidden" value="<?php echo $solicitacao; ?>"/><input class="input" name="portador" id="portador" type="text" size="40" value="<?php echo trim($dPortador); ?>"/>
</td></tr>
<tr>
  <td><strong>Controle:</strong>    <select name='controle'><option selected='selected' value="0">Escolha</option><option value='16'> 16 </option><option value='EP'> EP </option></select></td></tr>
    <tr><td>
   <input name="caditem" type="submit" value="Atualizar CI" class="buttonVerde"/>
    </td></tr></table>
  </form>
  </p><a href="home.php"><input name="cont" class="button" type="button" value="Voltar" /></a>
</div>
</body>
</html>