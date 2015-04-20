<?php
require "conectsqlserverci.php";
include "mb.php";
session_start();
unset($_SESSION['sequencia']);
unset($_SESSION['prUnitSC']);
unset($_SESSION['geremCompS']);
unset($_SESSION['redContCompS']);
unset($_SESSION['prUnitSC2']);
unset($_SESSION['geremCompS2']);
unset($_SESSION['redContCompS2']);
$cdMaterialS='';
$quantidadeS='';
$precoUnitS='';
$pzentS='';
$justItemS='';
if(empty($_POST['solic'])){
	$solicitacao=$_SESSION['solicitacao'];
    $usuario=$_SESSION['userCi'];
	if(!empty($_SESSION['validComp'])){
	$cdMaterialS=$_SESSION['cdMaterialS'];
	$quantidadeS=$_SESSION['quantidadeItemS'];
	$precoUnitS=$_SESSION['precoUnitS'];
	$pzentS=$_SESSION['pzentS'];
	$justItemS=$_SESSION['justItemS'];
	}else{
		$_SESSION['validComp']='';
		}
	$sqlUsuario="select campo20, Nome
from GEUSUARI (nolock)
where cd_usuario = '".$usuario."' ";
$resSqlUsuario=odbc_exec($conCab, $sqlUsuario) or die("<p>".odbc_errormsg());
$arraySqlUsuario=odbc_fetch_array($resSqlUsuario);
	}else{
$solicitacao=$_POST['solic'];
$usuario=$_POST['user'];
$_SESSION['cdMaterial']='';
$_SESSION['quantidadeItem']='';
$_SESSION['precoUnit']='';
$_SESSION['pzent']='';
$_SESSION['justItem']='';
$_SESSION['validComp']='';
$sqlUsuario="select campo20, Nome
from GEUSUARI (nolock)
where cd_usuario = '".$usuario."' ";
$resSqlUsuario=odbc_exec($conCab, $sqlUsuario) or die("<p>".odbc_errormsg());
$arraySqlUsuario=odbc_fetch_array($resSqlUsuario);

$_SESSION['numCi'] = $solicitacao;
$_SESSION['solicitacao'] = $solicitacao;
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
<link rel="stylesheet" href="jqueryDown/jquery-ui.css" />
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
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  </script>
<script type="text/javascript">
$().ready(function() {
    $("#cdMaterial").autocomplete("suggest_material.php", {
        width: 715,
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
<br/>
<strong>CIWEB  - Atualizar Solicita&ccedil;&atilde;o:</strong><br/><br/>

     <strong>CI N&ordm;: <font size="3" color="red"><?php echo $solicitacao; ?></font></strong><br /><br/>	  
  <?php
  $sqlConsItensCi="Select
  ESMATERI.Descricao,
  ESMATERI.Cd_material,
  ESUMEDID.Descricao As Descricao1,
  COISOLIC.Quantidade,
  COISOLIC.Cd_centro_armaz,
  COISOLIC.Pr_unitario,
  COISOLIC.Cd_solicitacao,
  COISOLIC.Sequencia,
  TEANALIVERMATERIAL.*
From
  COISOLIC with (nolock) left Join
  TEANALIVERMATERIAL (nolock) On TEANALIVERMATERIAL.material=COISOLIC.Cd_material inner join
  ESMATERI with (nolock) On COISOLIC.Cd_material = ESMATERI.Cd_material Inner Join
  ESUMEDID with (nolock) On ESMATERI.Cd_unidade_medi = ESUMEDID.Cd_unidade_medi
  WHERE COISOLIC.Cd_solicitacao=".$solicitacao."
  AND COISOLIC.Cd_especie_esto='E'";
  $execConsItensCi=odbc_exec($conCab, $sqlConsItensCi) or die("<p>".odbc_errormsg());
  $countConsItensCi=odbc_num_rows($execConsItensCi);
  if(!empty($countConsItensCi)){
	    $totalCi=0;
		  ?>
		  <font size="3" ><strong>LISTA DE ITENS DA CI</strong></font>
 
  <div id='tabela3'><table border='0'> <tr><th width='21%'><strong>MATERIAL</strong></th><th width='13%'><strong>QUANTIDADE</strong></th><th width='15%'><strong>PRE&Ccedil;O UNIT&Aacute;RIO</strong></th><th width='12%'><strong>ALTERAR ITEM</strong></th><th width='12%'><strong>DADOS FINANCEIROS</strong></th><th width='12%'><strong>CADASTRAR EXCLUSIVO</strong></th><th width='12%'><strong>EXCLUIR?</strong></th></tr>
		  <?php
		  while($objConsItemCI = odbc_fetch_object($execConsItensCi)){
			 $btExc='<strong>N/D</strong>';
		     $tipo='';
	   if(($objConsItemCI->habilitar_rpa=='1')||($objConsItemCI->habilitar_hotel=='1')||($objConsItemCI->habilitar_passagem=='1')||($objConsItemCI->habilitar_diaria=='1') || ($objConsItemCI->habilitar_auxilio_viagem=='1') || ($objConsItemCI->habilitar_ajuda_custo=='1')){
		  $btExc="<form action='ciWItensExclusivosAt.php' method='post' name='ciWCriar'>
			 <input name='solic' type='hidden' size='10' value=".$solicitacao." />
			 <input name='sequencia' type='hidden' size='10' value=".$objConsItemCI->Sequencia." />
			 <input name='user' type='hidden' size='10' value=".$usuario." />
			 <input name='exclusivo' type='submit' class='button' value='Exclusivo' />
			 </form>";
		   } 
			 echo "<tr><td>".$objConsItemCI->Sequencia."-".$objConsItemCI->Descricao."</td><td><center>".(int)$objConsItemCI->Quantidade."</center></td><td><div align='right'>R$".number_format($objConsItemCI->Pr_unitario, 2, ',', '.')."</div></td><td>
			 <form action='ciWAtuItens.php' method='post' name='ciWalterar'>
			 <input name='solic' type='hidden' size='10' value=".$solicitacao." />
			 <input name='sequencia' type='hidden' size='10' value=".$objConsItemCI->Sequencia." />
			 <input name='user' type='hidden' size='10' value=".$usuario." />
			 <input name='volta' type='hidden' size='10' value='2' />
			 <input name='AlteraI' type='submit' class='button' value='Alterar Item' />
			 </form></td><td>
			 <form action='ciWAtuItDComp.php' method='post' name='ciWCriar'>
			 <input name='solic' type='hidden' size='10' value=".$solicitacao." />
			 <input name='sequencia' type='hidden' size='10' value=".$objConsItemCI->Sequencia." />
			 <input name='user' type='hidden' size='10' value=".$usuario." />
			 <input name='AlteraF' type='submit' class='button' value='Dados Financeiros' /></form>
			 </td>
			 <td align='center'>".$btExc."</td>
			 <td><form action='ciWExcluiItem.php' method='post' name='ciWCriar'>
			 <input name='solic' type='hidden' size='10' value=".$solicitacao." />
			 <input name='retorno' type='hidden' size='10' value='ciWItens.php' />
			 <input name='sequencia' type='hidden' size='10' value=".$objConsItemCI->Sequencia." /> 
			 <input name='excluir' type='submit' class='button' value='Excluir' onclick=\"return confirm('Deseja realmente remover esse item?')\"/></form></td></tr>"; 
			  $totalCi=($objConsItemCI->Pr_unitario*$objConsItemCI->Quantidade)+$totalCi;
			  $_SESSION['totalCi']=$totalCi;
			  }
?><tr>
    <th colspan="2" align="right"><strong>VALOR TOTAL DA SOLICITA&Ccedil;&Atilde;O</strong></th><th colspan="5" align="left"><span style='padding-left:20px'><?php echo "R$".number_format($totalCi, 2, ',', '.'); ?></th></tr>
	</table></div><br /><br />
	<?php	  
	
	}
  ?>
  <?php 
  if($_SESSION['readOnly']==''){
  ?>
<form action="ciWItDCompInsAt.php" method="post" enctype="multipart/form-data" name="ciWCriar" onsubmit="this.elements['caditem'].disabled=true;"> 
  <table border="0"><tr><td colspan='6'>
  <font size="3" ><strong>INSER&Ccedil&AtildeO DE NOVO ITEM</strong>
<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
  </td></tr>
  <tr><td>
  <?php $cdMaterial=''; ?>
<strong><font color=red>*</font>Material:</strong> 
</td><td>
<input type="text" name="cdMaterial" id="cdMaterial" class="input" size="70" onkeyup="buscarPrazo(this.value)" onkeydown="buscarPrazo(this.value)" onblur="buscarPrazo(this.value)" onfocus="buscarPrazo(this.value)" value="<?php echo $cdMaterialS; ?>"/>
<input type="hidden" name="idComp" id="idComp" class="input" size="20" value="1" /><input type="hidden" name="solicitacao" id="solicitacao" class="input" size="20" value="<?php echo $solicitacao;?>" /><br /><br />
</td></tr>
<tr><td>
<strong><font color=red>*</font>Quantidade:</strong> </td><td><input class="input" name="quantidade" id="quantidade" type="text" size="12" onkeyup="somenteNumeros(this)" maxlength="6" value="<?php echo $quantidadeS; ?>"/><br />
</td></tr>
<tr><td>
<strong><font color=red>*</font>Pre&ccedil;o Unit&aacute;rio:</strong></td><td><input class="input" name="pr_unitario" id="pr_unitario" type="text" size="12" maxlength="11" value="<?php echo $precoUnitS; ?>"/><br />
</td></tr>
<tr><td>
  <strong>Prazo de Entrega:</strong></td><td><input class="input" id="pzent" name="pzent" type="text" size="12" maxlength="30" readonly="readonly" value="<?php echo $pzentS; ?>"/>
</td></tr>
<tr>
<td>
  <strong>Anexo do Item:</strong></td>
<td>
	<input name="anexo[]" id='anexo[]' type=file multiple /><br />
(Selecione os arquivos segurando CTRL ou Shift / Max de 10Mb por arquivo)
</td></tr>
   <tr><td>
   <strong>Detalhamento do Item:  </strong><br/></td>
<td colspan='5'>   
   <input class="input" name="userSol" id="userSol" type="hidden" size="40" onblur="" value="<?php echo trim($arraySqlUsuario['campo20'])."-".trim($arraySqlUsuario['Nome']); ?>" />
<input class="input" name="desc" type="hidden" size="102" maxlength="59"/><textarea name="justificativa" id="justificativa" cols="80" rows="10" onkeyup="limitaTextarea(this.value)"><?php echo $justItemS; ?></textarea><br />
  <strong>Campo (caracteres restantes: <span id="contador">2000</span>)</strong></textarea><br />
   </td></tr>
    <tr><td>
   <input name="caditem" type="submit" value="Cadastrar Item" class="buttonVerde"/>
    </td></tr></table>
  </form>
  <?php 
  }else{
	  echo "<strong>CI n&atilde;o dispon&iacute;vel para adi&ccedil;&atilde;o de novos itens.</strong><BR><BR> Para isso solicite a altera&ccedil;&atilde;o do controle para 03 - EM PROCESSO DE ELABORA&Ccedil;&Atilde;O.";
	  }
  ?>
  </p><a href="ciWResCons.php"><input class="button" type="button" value="Voltar" /></a>
</div>
</body>
</html>