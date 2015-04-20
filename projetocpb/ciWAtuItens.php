<?php
session_start();
require "conectsqlserverci.php";
include "mb.php";
if(!empty($_POST['solic'])){
$user=$_POST['user'];
$solic=$_POST['solic'];
$sequencia=$_POST['sequencia'];
$voltaRes=$_POST['volta'];
$_SESSION['voltaCiItensAt']=$voltaRes;
$_SESSION['userCiItenAt']=$user;
$_SESSION['solicCiItenAt']=$solic;
$_SESSION['sequenciaCiItenAt']=$sequencia;
$solicAcomp=str_pad($solic, 8, "0", STR_PAD_LEFT);
$seqAcomp=str_pad($sequencia, 3, "0", STR_PAD_LEFT);
$embarquePedido=$solicAcomp."/".$seqAcomp;
$sqlAcomp=odbc_exec($conCab,"SELECT historico FROM GEACOMP (nolock) WHERE embarque_pedido='".$embarquePedido."' AND (codigo_titulo='802' OR codigo_titulo='803')");
$arrayAcomp=odbc_fetch_array($sqlAcomp);
$sqlItem=odbc_exec($conCab,"Select
  COISOLIC.Quantidade,
  COISOLIC.Pr_unitario,
  COISOLIC.Dt_prazo_de_ent,
  COISOLIC.Descricao AS Descricao1,
  GEEMPRES.Nome_completo,
  GEEMPRES.Cd_empresa,
  ESMATERI.Cd_reduzido,
  ESMATERI.Descricao
From
  COISOLIC with (nolock) Inner Join
  GEEMPRES with (nolock) On COISOLIC.Cd_solicitante = GEEMPRES.Cd_empresa Inner Join
  ESMATERI with (nolock) On COISOLIC.Cd_material = ESMATERI.Cd_material
  WHERE COISOLIC.Cd_solicitacao='".$solic."'
		AND COISOLIC.Sequencia='".$sequencia."'");
$arrayItem=odbc_fetch_array($sqlItem);

$sqlConsRPA="SELECT * FROM
			   TEITEMSOLRPA (nolock)
			   WHERE
			   cd_solicitacao=".$solic." AND
			   sequencia=".$sequencia."";
  $rsConsRPA = odbc_exec($conCab,$sqlConsRPA) or die(odbc_error());
  $contConsRPA=odbc_num_rows($rsConsRPA);
  if($contConsRPA==0){
			  $sqlConsDiaria="SELECT * FROM
			   TEITEMSOLDIARIAVIAGEM (nolock)
			   WHERE
			   solicitacao=".$solic." AND
			   sequencia=".$sequencia."";
			  $rsConsDiaria = odbc_exec($conCab,$sqlConsDiaria) or die(odbc_error());
			  $contConsDiaria=odbc_num_rows($rsConsDiaria);
			  if($contConsDiaria==0){
				  $sqlConsPassagem="SELECT * FROM
			   TEITEMSOLPASSAGEM (nolock)
			   WHERE
			   cd_solicitacao=".$solic." AND
			   sequencia=".$sequencia."";
				  $rsConsPassagem = odbc_exec($conCab,$sqlConsPassagem) or die(odbc_error());
				  $contConsPassagem=odbc_num_rows($rsConsPassagem);
					   if($contConsPassagem==0){
						  $sqlConsHotel="SELECT * FROM
			   TEITEMSOLHOTEL (nolock)
			   WHERE
			   cd_solicitacao=".$solic." AND
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
$vlUnit=trim($arrayItem['Pr_unitario']);

$cdMaterial2=trim($arrayItem['Cd_reduzido'])."-".trim($arrayItem['Descricao']);
$quantidade=number_format(trim($arrayItem['Quantidade']),0,'','.');
$prUnit=number_format($vlUnit, 2, ',', '.');
$pzentAt=date("d/m/Y",strtotime($arrayItem['Dt_prazo_de_ent']));
$justItemAt=trim($arrayAcomp['historico']);

}else{
	$user=$_SESSION['userCiItenAt'];
	$solic=$_SESSION['solicCiItenAt'];
	$sequencia=$_SESSION['sequenciaCiItenAt'];
	$cdMaterial2=$_SESSION['cdmaterialCiItenAt'];
	$quantidade=$_SESSION['quantidadeCiItenAt'];
	$precoUnit=$_SESSION['prunitCiItenAt'];
	$pzentAt=$_SESSION['pzentCiItenAt'];
	$justItemAt=$_SESSION['justCiItenAt'];
	$voltaRes=$_SESSION['voltaCiItensAt'];
	$solicAcomp=str_pad($solic, 8, "0", STR_PAD_LEFT);
	$seqAcomp=str_pad($sequencia, 3, "0", STR_PAD_LEFT);
	$embarquePedido=$solicAcomp."/".$seqAcomp;
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
$(document).ready(function(e) {
    $('input').keydown(function(){
		 document.getElementById('btnat').style.display="none"
		 document.getElementById('btat').style.visibility="visible"
	});	
	$('#justificativa').keypress(function(){
		 document.getElementById('btnat').style.display="none"
		 document.getElementById('btat').style.visibility="visible"
	});
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
<strong>CIWEB  - Atualizar Solicita&ccedil;&atilde;o:</strong><br/>

 <strong>CI N&ordm;:<font size="3" color="red"> <?php echo $solic; ?></strong></font><br />
<form action="ciWAtIt.php" enctype="multipart/form-data" method="post" onsubmit="this.elements['caditem'].disabled=true;"><table border="0"><tr><td colspan='2'>
  <br/><p><strong>ATUALIZAR ITEM</strong></p>
  </td></tr>
  <tr><td>
  <?php $cdMaterial=''; 
  if($voltaRes==1){
	  $readOnly='';
	  }else{
		  $readOnly=$_SESSION['readOnly'];
		  }
  ?>
<strong>C&oacute;digo do Material:</strong> </td><td><br/>
<input type="text" name="cdMaterial" id="cdMaterial" <?php echo $readOnly; ?> class="input" size="88" onkeyup="buscarPrazo(this.value)" onkeydown="buscarPrazo(this.value)" onblur="buscarPrazo(this.value)" onfocus="buscarPrazo(this.value)" value="<?php echo $cdMaterial2; ?>"/>
<input type="hidden" name="idComp" id="idComp" class="input" size="20" value="1" /><input type="hidden" name="solic" id="solic" class="input" size="20" value="<?php echo $solic; ?>" /><input type="hidden" name="seq" id="seq" class="input" size="20" value="<?php echo $sequencia; ?>" /><input type="hidden" name="embarquePedido" id="embarquePedido" class="input" size="20" value="<?php echo $embarquePedido; ?>" /><input type="hidden" name="volta" id="volta" class="input" size="20" value="<?php echo $voltaRes; ?>" /><br /><br />
</td></tr>
<tr><td>
<strong>Quantidade:</strong></td><td> <input class="input" name="quantidade" id="quantidade" <?php echo $readOnly; ?> type="text" size="12" onkeyup="somenteNumeros(this)" maxlength="6" value="<?php echo $quantidade; ?>" <?php echo $precoUnit; ?>/><br />
</td></tr>
<tr><td>
<strong>Pre&ccedil;o Unit&aacute;rio:</strong></td><td><input class="input" name="pr_unitario" id="pr_unitario" type="text" <?php echo $precoUnit; ?> size="12" maxlength="11" value="<?php echo $prUnit; ?>" /><br />
</td></tr>
<tr><td>
  <strong>Prazo de Entrega:</strong></td><td><input class="input" id="pzent" name="pzent" type="text" size="12" maxlength="30" readonly="readonly" value="<?php echo $pzentAt; ?>"/>
</td></tr>
<tr>
<td>
  <strong>Anexo(s) do Item:</strong></td>
<td>
<?php

$posicao=explode("<<",$justItemAt);
$i=0;
$quebra=chr(13).chr(10);
$anexoAnt='';
foreach($posicao AS $pos){
	echo "<div style='display:none'>";
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
	echo "</div>";
	if($stringAnexoI[$i]<>''){
		echo "<div style='display:none'>";
	$stringAnexo[$i]=str_replace(" ","",str_replace("An:W:\\Anexos_CI\\","",str_replace(">>","",str_replace("<br>","",$stringAnexoI[$i]))));
	$stringAnexoArray[$i]=explode("\\",$stringAnexo[$i]);
	$stringAnexoResult[$i]=end($stringAnexoArray[$i]);
//Verifica se o arquivo existe no FTP e na pasta local. Se não existir no FTP ele oculta o link, se não existir local ele da um ftp_get(), cria as pastas necessárias e salva o arquivo na pasta.
//Terá que verificar cada pasta se existe antes de criar
$stringAnexoCompara[$i]=str_replace("\\","/",$stringAnexo[$i]);
echo "</div>";
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
	  
	  echo "<a href='Anexos/".$stringAnexo[$i]."' target='_blank'><font size='-2'><strong>".$stringAnexoResult[$i]."</strong></a> - <a href='ciWdelAnexo.php?end=".$stringAnexoResult[$i]."&ci=".$solic."&tp=3&sq=".$sequencia."' onclick=\"return confirm('Deseja realmente remover esse arquivo?')\"><font color='red'>Remover</font></a></font><br>";
   	  $anexoAnt.=$quebra."<<".str_replace($quebra,"",$stringAnexoI[$i]);
   }
  }
  $i++;
ftp_close($con_id);
}
echo "</td></tr><tr><td height='10px' ></td></tr><tr><td><strong>Anexar:</strong></td><td>";
  echo "<input type='hidden' name='anexant' value='".$anexoAnt."' />";
$justItemAt=str_replace($quebra.$quebra,"",preg_replace("'<<[^>]+>>'", "",$justItemAt));
?>
<input name="anexo[]" id='anexo[]' type=file multiple /><br />
(Selecione os arquivos segurando CTRL ou Shift / Max de 10Mb por arquivo)
</td></tr>
   <tr><td>
   <strong>Detalhamento do Item:</strong> </td><td><textarea name="justificativa" id="justificativa" cols="80" rows="10" <?php echo $readOnly; ?> onkeyup="limitaTextarea(this.value)"><?php echo str_replace("<br><br>","",$justItemAt);?></textarea><br />
  <strong>Campo (caracteres restantes: <span id="contador">2000</span>)</strong></textarea><br />
   </td></tr>
    <tr><td>
    <?php 
	
	?><div id='btnat'>Sem altera&ccedil;&atilde;o</div><div id='btat' style='visibility:hidden'>
   <input name="caditem" type="submit" value="Atualizar Item" class="buttonVerde"/></div>
    </td></tr></table></form>
    <?php 
	if($voltaRes==2){
		$retIt='ciWItens.php';
		}else{
			$retIt='ciWInserirItens.php';
			}
	?>
<form action="<?php echo $retIt; ?>"><br/><input class="button" type="submit" value="Voltar"></form>
</div>
</body>
</html>