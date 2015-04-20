<?php
require "conectsqlserverci.php";
include "mb.php";
session_start();
if(empty($_POST['solic'])){
	$solicitacao=$_SESSION['numCi'];
    $usuario=$_SESSION['userCi'];
	$sqlUsuario="select campo20, Nome
from GEUSUARI (nolock)
where cd_usuario = '".$usuario."' ";
$resSqlUsuario=odbc_exec($conCab, $sqlUsuario) or die("<p>".odbc_errormsg());
$arraySqlUsuario=odbc_fetch_array($resSqlUsuario);
	}else{
$solicitacao=$_POST['solic'];
$usuario=$_POST['user'];
$sqlUsuario="select campo20, Nome
from GEUSUARI (nolock)
where cd_usuario = '".$usuario."' ";
$resSqlUsuario=odbc_exec($conCab, $sqlUsuario) or die("<p>".odbc_errormsg());
$arraySqlUsuario=odbc_fetch_array($resSqlUsuario);

$_SESSION['numCi'] = $solicitacao;
$_SESSION['userCi'] = $usuario;
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
<script type='text/javascript' src='jquery_price.js'></script>
<link rel="stylesheet" type="text/css" href="jquery.autocomplete.css" />
 <script type="text/javascript">
  $(document).ready(function(){
      $('#pr_unitario').priceFormat({
        prefix: '',
        centsSeparator: '.',
        thousandsSeparator: ''
      });
    });
  </script>
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
<script type="text/javascript">
var req;   // FUNÇÃO PARA BUSCA NOTICIA 
function buscarPrazo(valor) {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "consultaMaterial.php?valor="+valor;

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

// Abaixo colocamos a(s) resposta(s) na div resultado que está lá no teste.php
document.getElementById('pzent').value = resposta;
}
}
req.send(null);
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
<script>
	function moeda(z){
		v = z.value;
		v=v.replace(/\D/g,"");
		v=v.replace(/^(\d{2})(\d)/,"$1,$2");
		z.value = v;
	}
</script>

</head>
<body>
<div id='box3'>
<br/>
<strong>CIWEB  - Atualizar Solicita&ccedil;&atilde;o:</strong><br/>
Cadastrar Itens
<?php

?>

<p>
    CI N&ordm; <strong><?php echo $solicitacao; ?></strong><br />
  </p>
  <p><strong>Lista de Itens da CI</strong></p>
  <div id='tabela'><table border='1'> <tr><th width="21%"><strong>Material</strong></th><th width="13%"><strong>Quantidade</strong></th><th width="15%"><strong>Pre&ccedil;o Unit&aacute;rio</strong></th><th width="12%"><strong>U.M.</strong></th><th width="12%"><strong>Dados Financeiros</strong></th><th width="12%"><strong>Cadastrar Exclusivo</strong></th><th width="12%"><strong>Excluir?</strong></th></tr>
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
			  
			 echo "<tr><td>".$objConsItemCI->Descricao."</td><td>".(int)$objConsItemCI->Quantidade."</td><td>R$".number_format($objConsItemCI->Pr_unitario, 2, '.', '')."</td><td>".$objConsItemCI->Descricao1."</td><td><form action='ciWItensDComplementar.php' method='post' name='ciWCriar'><input name='solic' type='hidden' size='10' value=".$solicitacao." /><input name='sequencia' type='hidden' size='10' value=".$objConsItemCI->Sequencia." /><input name='user' type='hidden' size='10' value=".$usuario." /><input name='AlteraF' type='submit' class='button' value='Dados Financeiros' /></form></td><td><form action='ciWItensExclusivos.php' method='post' name='ciWCriar'><input name='solic' type='hidden' size='10' value=".$solicitacao." /><input name='sequencia' type='hidden' size='10' value=".$objConsItemCI->Sequencia." /><input name='user' type='hidden' size='10' value=".$usuario." /><input name='exclusivo' type='submit' class='button' value='Exclusivo' /></form></td><td><form action='ciWExcluiItem.php' method='post' name='ciWCriar'><input name='solic' type='hidden' size='10' value=".$solicitacao." /><input name='sequencia' type='hidden' size='10' value=".$objConsItemCI->Sequencia." /> <input name='excluir' type='submit' class='button' value='Excluir' /></form></td></tr>"; 
			  $totalCi=($objConsItemCI->Pr_unitario*$objConsItemCI->Quantidade)+$totalCi;
			  $_SESSION['totalCi']=$totalCi;
			  }
?><tr>
    <th colspan="5" align="right"><strong>VALOR TOTAL DA SOLICITA&Ccedil;&Atilde;O</strong></th><td colspan="2" align="left"><?php echo "R$".number_format($totalCi, 2, '.', ''); ?></td></tr>
	<?php	  
	}
  ?>
  </table></div><br /><br />
<form action="ciWItensDComp.php" method="post" name="ciWCriar" onsubmit="this.elements['caditem'].disabled=true;"> 
  <table border="1"><tr><td>
  <p><strong>Inserir Novo Item</strong></p>
  </td></tr>
  <tr><td>
  <?php $cdMaterial=''; ?>
<strong>C&oacute;digo do Material:</strong> 
<input type="text" name="cdMaterial" id="cdMaterial" class="input" size="40" onkeyup="buscarPrazo(this.value)" onkeydown="buscarPrazo(this.value)" onblur="buscarPrazo(this.value)" onfocus="buscarPrazo(this.value)"/>
<input type="hidden" name="idComp" id="idComp" class="input" size="20" value="1" /><br /><br />
</td></tr>
<tr><td>
<strong>Quantidade:</strong> <input class="input" name="quantidade" id="quantidade" type="text" size="8" onkeyup="somenteNumeros(this)" maxlength="6"/><br />
</td></tr>
<tr><td>
<strong>Pre&ccedil;o Unit&aacute;rio:</strong><input class="input" name="pr_unitario" id="pr_unitario" type="text" size="12" maxlength="11"/><font size="-2" color="#FF0000">*Separar centavos com ponto.</font><br />
</td></tr>
<tr><td>
  <strong>Prazo de Entrega:</strong><input class="input" id="pzent" name="pzent" type="text" size="10" maxlength="30" readonly="readonly"/>
</td></tr>
<tr><td>
<strong>Solicitante:</strong> <input class="input" name="userSol" id="userSol" type="text" size="40" onblur="" value="<?php echo trim($arraySqlUsuario['campo20'])."-".trim($arraySqlUsuario['Nome']); ?>" />
</td></tr>
<tr><td>
<strong>Observa&ccedil;&atilde;o:</strong> <input class="input" name="desc" type="text" size="102" maxlength="59"/><br /><br/>
</td></tr>
   <tr><td>
   <br />Justificativa do Item: <textarea name="justificativa" id="justificativa" cols="60" rows="10" onkeyup="limitaTextarea(this.value)"></textarea><br />
  <strong>Campo (caracteres restantes:</strong> <span id="contador">2000</span>)</textarea><br />
   </td></tr>
    <tr><td>
   <input name="caditem" type="submit" value="Cadastrar Item" class="button"/>
    </td></tr></table>
  </form>
  </p><a href="home.php"><input name="cont" class="button" type="button" value="CONCLUIR CI" /></a>
</div>
</body>
</html>