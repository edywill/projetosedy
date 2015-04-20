<?php

require "conectsqlserverci.php";
include "mb.php";
session_start();

$botao='<a href="ciWinserirItens.php"><input name="cont" class="button" type="button" value="Voltar" /></a>';

if(!empty($_POST['solic']) && !empty($_POST['sequencia'])){	
$_SESSION['geremCompS']='';
$_SESSION['redContCompS']='';
$solicitacao=$_POST['solic'];
$sequencia=$_POST['sequencia'];
$usuario=$_POST['user'];
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
							  $precoUnit="";
							  }else{
								  $precoUnit="";
								  }
					   }else{
						   $precoUnit=" readonly='readonly' ";
						   }
			  }else{
				  $precoUnit=" readonly='readonly' ";
				  }
  }else{
	  $precoUnit=" readonly='readonly' ";
  }
//$cgeren=trim($arrayCGEREN['Cd_conta_gerenc']);
$redcont= (int)$arrayCGEREN['Campo41'];
$prUnit=number_format($arrayCGEREN['Pr_unitario'],2, ',','.');

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
}else{
	$solicitacao=$_SESSION['solicitacao'];
	$usuario=$_SESSION['userCi'];
	$sequencia=$_SESSION['sequencia'];
	$validador=1;
	$gerenComp=$_SESSION['geremCompS'];
	$redcontComp=$_SESSION['redContCompS'];
	$prUnit=$_SESSION['prUnitSC'];
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
        width: 393,
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
<script type="text/javascript">
  $(document).ready(function(){
      $('#pr_unitario').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
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
<script type='text/javascript' src='jquery_price.js'></script>
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
<body onLoad=”document.ciWCriar.cgeren.focus();“ onKeyDown="javascript:return bloqueioTeclas();">
<div id='box3'>
<br/>
<strong>CIWEB  - Criar nova Solicita&ccedil;&atilde;o:</strong><br/>
<strong>Cadastrar Dados Complementares</strong>

<p>
    <strong>CI N&ordm; <font size="3" color="red"><?php echo $solicitacao; ?></font></strong><br />
    Item Seq.:<?php echo $sequencia; ?>
  </p>
  
<form action="ciWAlteraDF.php" method="post" name="ciWCriar" onsubmit="this.elements['caditem'].disabled=true;"> 
  <table border="0"><tr><td colspan='2'>
  <p><font size="3"><strong>ALTERAR DADOS FINANCEIROS</strong></font></p>
  <div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
  </td></tr>
  <tr><td>
<strong><font color=red>*</font>Conta Gerencial:</strong></td><td><br/><input type="hidden" name="user" value="<?php echo $usuario; ?>"/><input type="hidden" name="solicitacao" value="<?php echo $solicitacao; ?>"/><input type="hidden" name="sequencia" value="<?php echo $sequencia; ?>"/> 
<input class="input" name="cgeren" id="cgeren" autofocus type="text" size="40"  value="<?php echo $gerenComp; ?>" />
<input type="hidden" name="endereco" id="endereco" class="input" size="8" value="0"/><br /><br />
<input class="input" name="redcont" id="redcont" type="hidden" size="40"  value="<?php echo $redcontComp; ?>"/>
</td></tr>
<tr><td>
<strong>Pre&ccedil;o Unit&aacute;rio:</strong></td><td><input class="input" name="pr_unitario" id="pr_unitario" type="text" size="8" value="<?php echo $prUnit; ?>" maxlength="11" <?php echo $precoUnit; ?>><br />
</td></tr>
    <tr><td>
   <input name="caditem" type="submit" value="Atualizar Dados" class="buttonVerde"/>
    </td></tr></table>
  </form>
  </p><?php echo $botao; ?>
</div>
</body>
</html>
<?php 
	
	?>