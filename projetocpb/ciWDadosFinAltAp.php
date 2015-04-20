<?php

require "conectsqlserverciprod.php";
include "mb.php";

$solicitacao=$_POST['solic'];
$sequencia=$_POST['sequencia'];
$usuario=$_POST['user'];
$botao='<a href="ciWAlteraItAp.php"><input name="cont" class="button" type="button" value="Voltar" /></a>';

if(!empty($solicitacao) && !empty($sequencia)){	
$sqlCGEREN="Select
  it.Cd_conta_gerenc,
  it.Campo41,
  it.Pr_unitario
From
  COISOLIC it With(NoLock)
where it.cd_solicitacao='".$solicitacao."' and
      it.sequencia='".$sequencia."'";
	$rsCGEREN = odbc_exec($conCab,$sqlCGEREN) or die(odbc_error());
	$arrayCGEREN=odbc_fetch_array($rsCGEREN);
//$cgeren=trim($arrayCGEREN['Cd_conta_gerenc']);
$redcont= (int)$arrayCGEREN['Campo41'];
$prUnit=number_format($arrayCGEREN['Pr_unitario'],2, '.','');

$sqlCGERENome="Select
    cg.Pcc_nome_conta,
	cg.Pcc_classific_c,
	cg.Cd_pcc_reduzid
From
  CCPCC cg With(nolock)
where 
substring(cg.livre_alfa_18,1,1) <> 'N'
and cg.pcc_tipo = 'A'
and cg.pcc_classific_c between dbo.CGFC_BUSCA_CONFIGURACAO(35,null) 
and dbo.CGFC_BUSCA_CONFIGURACAO(36,null)
and cg.Pcc_classific_c='".trim($arrayCGEREN['Cd_conta_gerenc'])."'";
$rsCGERENome = odbc_exec($conCab,$sqlCGERENome) or die(odbc_error());
$arrayCGERENome=odbc_fetch_array($rsCGERENome);
$cgeren=trim($arrayCGERENome['Pcc_classific_c']);
$cgerenNome=trim($arrayCGERENome['Pcc_nome_conta']);
$redCont2=trim($arrayCGERENome['Cd_pcc_reduzid']);
$gerenComp='';
if(!empty($cgeren)){
$gerenComp=trim($cgeren)."-".trim($cgerenNome);
}

$selectRedCont="select cg.Pcc_nome_conta,cg.Cd_pcc_reduzid
from CCPCC cg (nolock)
where cg.Cd_pcc_reduzid = '".$redcont."'
and substring(cg.livre_alfa_18,1,1) <> 'N'
and cg.pcc_tipo = 'A'";
$rsRedCont = odbc_exec($conCab,$selectRedCont) or die(odbc_error());
$arrayRedCont=odbc_fetch_array($rsRedCont);

$redcont=trim($arrayRedCont['Cd_pcc_reduzid']);
$redcontNome=trim($arrayRedCont['Pcc_nome_conta']);
$redcontComp='';
if(!empty($redcont)){
$redcontComp=trim($redcont)."-".trim($redcontNome);
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
    $("#cgeren").autocomplete("suggest_cgeren.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
});
</script>
<script type="text/javascript">
$().ready(function() {
    $("#redcont").autocomplete("suggest_redcont.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
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
</head>
<body onLoad=”document.ciWCriar.cgeren.focus();“>
<div id='box3'>
<br/>
<strong>CIWEB  - Aprovar CI - Dados Financeiros:</strong><br/>
Cadastrar Dados Complementares

<p>
    CI N&ordm; <strong><?php echo $solicitacao; ?></strong><br />
    Item Seq.:<strong><?php echo $sequencia; ?></strong>
  </p>
  
<form action="ciWAlteraDFexcluir.php" method="post" name="ciWCriar"> 
  <div id='tabela3'><table width="550px" border="1"><tr><td bgcolor='#658BF3'>
  <strong>ALTERAR DADOS FINANCEIROS</strong>
  </td></tr>
  <tr><td>
<strong>Conta Gerencial:</strong><input type="hidden" name="user" value="<?php echo $usuario; ?>"/><input type="hidden" name="solicitacao" value="<?php echo $solicitacao; ?>"/><input type="hidden" name="sequencia" value="<?php echo $sequencia; ?>"/> 
<input class="input" name="cgeren" id="cgeren" autofocus type="text" size="40"  value="<?php echo $gerenComp; ?>" />
<input type="hidden" name="endereco" id="endereco" class="input" size="8" value="2"/><br /><br />
</td></tr>
<tr><td>
<strong>Reduzido Contabil:</strong>
<input class="input" name="pr_unitario" id="pr_unitario" type="hidden" size="8" value="<?php echo $prUnit; ?>" /><input class="input" name="redcont" id="redcont" type="text" size="40"  value="<?php echo $redcontComp; ?>"/>
<br /><br />
</td></tr>
    <tr><td>
   <input name="caditem" type="submit" value="Atualizar Dados" class="buttonVerde"/>
    </td></tr></table>
  </form>
  </p><?php echo $botao; ?>
</div>
</body>
</html>
<?php }else{
	?>
       <script type="text/javascript">
       alert("Dado não pode ser vazio.");
       window.history.back();
       </script>
       <?php
	}
	
	?>