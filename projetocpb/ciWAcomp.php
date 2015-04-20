<?php
session_start();
require "conectsqlserverci.php";
include "mb.php";
$justificativaCi='';
if(!empty($_POST['numCi'])){
   $solic=$_POST['numCi'];
   $readOnlyP=$_POST['readOnly'];
   $_SESSION['numCiAcomp']=$solic;
   $_SESSION['readOnlyAcomp']=$readOnlyP;
   $_SESSION['justAcompCiS']='';
   $sqlAcomp=odbc_exec($conCab,"SELECT Embarque_pedido,historico FROM GEACOMP(nolock) WHERE Codigo_titulo='801' AND tipo_acompanham='R' AND rtrim(ltrim(Embarque_pedido))='".$solic."'");
$arrayAcomp=odbc_fetch_array($sqlAcomp);
$justificativaCi=$arrayAcomp['historico'];
	}else{
	 $solic=$_SESSION['numCiAcomp'];
     $readOnlyP=$_SESSION['readOnlyAcomp'];
	$justificativaCi=$_SESSION['justAcompCiS'];
		}
$solicitacaoAcomp=str_pad($solic, 8, " ", STR_PAD_LEFT);
$readOnly='';
if(!empty($arrayAcomp['historico']) && $readOnlyP<>''){
//if($readOnlyP<>''){
	$readOnly=" readonly='readonly' ";
	}
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
<style>
  .invisivel { display: none; }
  .visivel { visibility: visible; }
  </style>

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
<script type="text/javascript">
function goBack()
  {
  window.history.back()
  }
</script>
<script type="text/javascript">
$(document).ready(function(e) {
    $('#justificativa').keydown(function(){
		 document.getElementById('btnat').style.display="none"
		 document.getElementById('btat').style.visibility="visible"
	});	
	$('input[type=file]').on("change", function(){
		 document.getElementById('btnat').style.display="none"
		 document.getElementById('btat').style.visibility="visible"
	});
});
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
<strong>JUSTIFICATIVA / ACOMPANHAMENTO DA CI</strong><br/>
<?php  ?>
<form action="ciWAtuAcomp.php" method="post" enctype="multipart/form-data" name="ciWCriar" onSubmit="this.elements['cont'].disabled=true;">
<input name="solic" type="hidden" size="10" value="<?php echo $solic; ?>" /> 
<input name="user" type="hidden" size="10" value="<?php echo $_POST['user']; ?>" /> 
<strong>CI N&ordm;: <font size="3" color="red"><?php echo $solic; ?></strong></font><br /><br/>
<strong>Tipo de Acompanhamento:</strong> 801 - Texto Inicial da CI<br/>
<br />
<?php 
$justItemAt=trim($justificativaCi);
$posicao=explode("<<",$justItemAt);
$i=0;
$quebra=chr(13).chr(10);
$anexoAnt='';
foreach($posicao AS $pos){
	require("conectftp.php");
	$stringAnexoI='';
	$stringAnexoArray='';
	$stringAnexoResult='';
    $stringAnexoCompara='';
	$stringAnexo='';
	$arrayPastasLocais='';
	$endFinal='';
	$array='';
	$cont='';
	
	$stringAnexoI[$i]=strstr($pos,"An:W");
	if($stringAnexoI[$i]<>''){
	$stringAnexo[$i]=str_replace(" ","",str_replace("An:W:\\Anexos_CI\\","",str_replace(">>","",str_replace("<br>","",$stringAnexoI[$i]))));
	$stringAnexoArray[$i]=explode("\\",$stringAnexo[$i]);
	$stringAnexoResult[$i]=end($stringAnexoArray[$i]);
//Verifica se o arquivo existe no FTP e na pasta local. Se não existir no FTP ele oculta o link, se não existir local ele da um ftp_get(), cria as pastas necessárias e salva o arquivo na pasta.
//Terá que verificar cada pasta se existe antes de criar
$stringAnexoCompara[$i]=str_replace("\\","/",$stringAnexo[$i]);
if(is_file(trim($cheqftp.$stringAnexoCompara[$i]))){
	if(!is_file('Anexos\\'.trim($stringAnexoCompara[$i]))){
	  if(!is_dir('Anexos\\'.str_replace($stringAnexoResult[$i],"",$stringAnexo[$i]))){
		  $arrayPastasLocais[$i]=explode("\\",str_replace($stringAnexoResult[$i],"",$stringAnexo[$i]));
		  $contPt[$i]=0;
		  $endFinal[$i]='Anexos\\';
		  while($array[$i][$cont[$i]]<>end($arrayPastasLocais[$i])){
			  $endFinal[$i].=$arrayPastasLocais[$i][$contPt[$i]]."\\";
			  if(!is_dir($endFinal[$i])){
				  mkdir($endFinal[$i], 0700);
				  }
			 $contPt[$i]++;
			 }
		  }
		  if(is_file(trim($cheqftp.$stringAnexoCompara[$i]))){
		  //Nesse ponto dou ftp_get e copio o arquivo para ca no endereço citado.
		  ftp_get($con_id, trim($stringAnexo[$i]),'Anexos\\'.$stringAnexo[$i], FTP_BINARY );
		  }
	  }
	  
	  //echo "<a href='Anexos/".utf8_encode($stringAnexo[$i])."' target='_blank'><font size='-2'><strong>".utf8_encode($stringAnexoResult[$i])."</strong></a> - <a href='ciWdelAnexo.php?end=".utf8_encode($stringAnexoResult[$i])."&ci=".$solic."&tp=2'>Remover</a></font><br>";
   	  $anexoAnt.=$quebra."<<".utf8_encode(str_replace($quebra,"",$stringAnexoI[$i]));
   }
  }
  $i++;
ftp_close($con_id);
}
  echo "<input type='hidden' name='anexant' value='".$anexoAnt."' />";
$justificativaCi=str_replace($quebra.$quebra,"",preg_replace("'<<[^>]+>>'", "",utf8_encode($justificativaCi)));
?>
<strong>Justificativa da CI: </strong><br/>
  <textarea name="justificativa" id="justificativa" cols="100" rows="10" <?php echo $readOnly; ?> onKeyUp="limitaTextarea(this.value)"><?php echo str_replace("<br><br>","",$justificativaCi); ?></textarea><br />
  <strong>Campo (caracteres restantes: <span id="contador">2000</span>)</strong>
<br />
<?php if($readOnly==''){
	?><div id='btnat'>Sem altera&ccedil;&atilde;o</div><div id='btat' style='visibility:hidden'>
<input name="cont" type="submit" class="buttonVerde" value="Continuar &gt;&gt;" /></div>
<?php 
}else{
	echo "<br/>N&atilde;o dispon&iacute;vel para altera&ccedil;&atilde;o";
	}
?>
</form><br/>
<a href="ciWResCons.php"><input name="cont" class="button" type="button" value="Voltar" /></a>
</div>
</body>
</html>