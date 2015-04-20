<?php
require "conectsqlserverci.php";
include "mb.php";
session_start();
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
	$cdMaterialS=$_SESSION['cdMaterialS'];
	$quantidadeS=$_SESSION['quantidadeItemS'];
	$precoUnitS=$_SESSION['precoUnitS'];
	$pzentS=$_SESSION['pzentS'];
	$justItemS=$_SESSION['justItemS'];
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

$sqlUsuario="select campo20, Nome
from GEUSUARI (nolock)
where cd_usuario = '".$usuario."' ";
$resSqlUsuario=odbc_exec($conCab, $sqlUsuario) or die("<p>".odbc_errormsg());
$arraySqlUsuario=odbc_fetch_array($resSqlUsuario);

$_SESSION['solicitacao'] = $solicitacao;
$_SESSION['userCi'] = $usuario;
$solicitacaoAcomp=str_pad($_POST['solic'], 8, " ", STR_PAD_LEFT);
$justificativa=$_POST['justificativa'];
$_SESSION['justCapa']=$justificativa;
$valida2=0;
$i = 0;
$quebra = chr(13).chr(10);
				if(empty($_POST['anexo'])){
				$endArquivo='';
				}else{
					$endArquivo=str_replace(" ","",$_POST['anexo']);
					}
if(strlen($justificativa.$quebra.$endArquivo)>2000){
	//echo strlen($justificativa);
	$valida2=1;
	?>
       <script type="text/javascript">
       alert("Erro[1]: O texto possui mais de 2000 caracteres.");
       window.location.href='ciWInserir.php';
       </script>
       <?php
	}
if(!empty($justificativa) || ($endArquivo<>'' || !empty($endArquivo)) && $valida2==0 ){
$sqlConsAcomp="SELECT codigo_titulo FROM GEACOMP(nolock) WHERE embarque_pedido='".$solicitacaoAcomp."' AND codigo_titulo='801'";
$resSqlConsAcomp=odbc_exec($conCab, $sqlConsAcomp) or die("<p>".odbc_errormsg());
$countSqlConsAcomp=odbc_num_rows($resSqlConsAcomp);
if(empty($countSqlConsAcomp)){
$justificativa=mb_convert_encoding($justificativa,"ISO-8859-1","UTF-8");
$justificativa=str_replace("?","-",$justificativa);
$justificativa=str_replace("'","\"",$justificativa);
$justificativa=addslashes($justificativa);
$justificativa=str_replace("\\\\","\\",$justificativa);
//$justificativa=$justificativa
$sqlInsAcomp="insert into GEACOMP
   (
   cd_empresa,
   embarque_pedido,
   contato_os_lanc,
   sequencia_item,
   tipo_acompanham,
   codigo_titulo,
   dt_prevista,
   dt_realizada,
   hora_prevista,
   hora_realizada,
   usuario,
   sessao,
   campo13,
   campo14,
   campo15,
   campo16,
   campo17,
   campo18,
   campo19,
   campo20,
   campo21,
   campo22,
   campo23,
   campo24,
   campo25,
   campo26,
   campo27,
   campo28,
   campo29,
   campo30,
   campo31,
   campo32,
   campo33,
   campo34,
   campo35,
   campo36,
   campo37,
   campo38,
   campo39,
   campo40,
   campo41,
   sequencia_conta,
   contato,
   data,
   hora,
   dt_repr1,
   dt_repr2,
   cd_contatante,
   historico
   )
values
   (
   '      ',                           --  Cd_empresa  char(6)
   '".$solicitacaoAcomp."',            --  Embarque_pedido  char(12). Veja os espaços a frente…
   0,                                  --  Contato_os_lanc  int 
   0,                                  --  Sequencia_item  int 
   'R',                                --  Tipo_acompanham  char(1)
   '801',                              --  Codigo_titulo  char(3)
   NULL,                               --  Dt_prevista  datetime 
   NULL,                               --  Dt_realizada  datetime 
   NULL,                               --  Hora_prevista  char(6)
   NULL,                               --  Hora_realizada  char(6)
   '".$usuario."',                     --  Usuario  char(3)
   0,                                  --  Sessao  int 
   NULL,                               --  Campo13  datetime 
   NULL,                               --  Campo14  datetime 
   NULL,                               --  Campo15  datetime 
   NULL,                               --  Campo16  datetime 
   NULL,                               --  Campo17  char(6)
   0,                                  --  Campo18  float 
   0,                                  --  Campo19  float 
   0,                                  --  Campo20  float 
   0,                                  --  Campo21  float 
   0,                                  --  Campo22  float 
   0,                                  --  Campo23  float 
   0,                                  --  Campo24  float 
   0,                                  --  Campo25  float 
   'N',                                --  Campo26  char(1)
   ' ',                                --  Campo27  char(1)
   ' ',                                --  Campo28  char(1)

   '  ',                               --  Campo29  char(2)
   '  ',                               --  Campo30  char(2)
   '  ',                               --  Campo31  char(2)
   '   ',                              --  Campo32  char(3)
   '   ',                              --  Campo33  char(3)
   '   ',                              --  Campo34  char(3)
   '      ',                           --  Campo35  char(6)
   '      ',                           --  Campo36  char(6)
   '      ',                           --  Campo37  char(6)
   '            ',                     --  Campo38  char(12)
   1,                                  --  Campo39  bit 
   0,                                  --  Campo40  bit 
   0,                                  --  Campo41  bit 
   0,                                  --  Sequencia_conta  int 
   '',                                 --  Contato  char(30)
   dbo.CGFC_DATAATUAL(),               --  Data  datetime 
   '".date("His")."',                  --  Hora  char(6)
   NULL,                               --  Dt_repr1  datetime 
   NULL,                               --  Dt_repr2  datetime 
   '      ',                           --  Cd_contatante  char(6)
   '".$justificativa.$endArquivo."' 			   --  Historico  varchar(2001)
   )";
}else{
	$justificativa=mb_convert_encoding($justificativa,"ISO-8859-1","UTF-8");
	$justificativa=str_replace("?","-",$justificativa);
	$justificativa=str_replace("'","\"",$justificativa);
	$justificativa=addslashes($justificativa);
	$justificativa=str_replace("\\\\","\\",$justificativa);
	$sqlInsAcomp="UPDATE GEACOMP SET historico='".$justificativa.$anexo."'
							          WHERE tipo_acompanham= 'R'
									  AND codigo_titulo='801'
									  AND embarque_pedido='".$solicitacaoAcomp."'";
		}
$resSqlInsAcomp=odbc_exec($conCab, $sqlInsAcomp) or die("<p>".odbc_errormsg());
if(!$resSqlInsAcomp){
		echo "<script type=\"text/javascript\">
		alert(\"Erro[1]: Ocorreu um erro ao inserir o acompanhamento. Tente novamente.\");
		window.location.href='ciWInserir.php';
       </script>";
		}
  }
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


<?php

?>

<p>
    <font size="3" ><strong>CADASTRAR ITENS</strong></font><BR/><BR/>
    <strong>CI WEB N&ordm; <font size="3" color="red"><?php echo $solicitacao; ?></font></strong><br /><br /><br />
</p>

  <font size="3" ><strong>LISTA DE ITENS DA CI</strong></font>
  
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
  $contarItensImprimir=0;
  if(empty($countConsItensCi)){
	  echo "<br/>Nenhum item cadastrado at&eacute; o momento.<br/>";
	  
	  }else{
		  $contarItensImprimir=1;
		  $totalCi=0;
		  echo "<div id='tabela3'><table border='0'> <tr><th width='21%'><strong>MATERIAL</strong></th><th width='13%'><strong>QUANTIDADE</strong></th><th width='15%'><strong>PRE&Ccedil;O UNIT&Aacute;RIO</strong></th><th width='12%'><strong>ALTERAR ITEM</strong></th><th width='12%'><strong>DADOS FINANCEIROS</strong></th><th width='12%'><strong>CADASTRAR EXCLUSIVO</strong></th><th width='12%'><strong>EXCLUIR?</strong></th></tr>"; 
		  while($objConsItemCI = odbc_fetch_object($execConsItensCi)){
			 $btExc='<strong>N/D</strong>';
		     $tipo='';
	   if(($objConsItemCI->habilitar_rpa=='1')||($objConsItemCI->habilitar_hotel=='1')||($objConsItemCI->habilitar_passagem=='1')||($objConsItemCI->habilitar_diaria=='1') || ($objConsItemCI->habilitar_auxilio_viagem=='1') || ($objConsItemCI->habilitar_ajuda_custo=='1')){
		  $btExc="<form action='ciWItensExclusivos.php' method='post' name='ciWCriar'><input name='solic' type='hidden' size='10' value=".$solicitacao." /><input name='sequencia' type='hidden' size='10' value=".$objConsItemCI->Sequencia." /><input name='user' type='hidden' size='10' value=".$usuario." /><input name='exclusivo' type='submit' class='button' value='Exclusivo' /></form>";
		   } 			 
			 echo "<tr><td>".$objConsItemCI->Descricao."</td><td><center>".(int)$objConsItemCI->Quantidade."</center></td><td><div align='right'>R$".number_format($objConsItemCI->Pr_unitario, 2, ',', '.')."</div></td>
			 <td>
			 <form action='ciWAtuItens.php' method='post' name='ciWalterar'>
			 <input name='solic' type='hidden' size='10' value=".$solicitacao." />
			 <input name='sequencia' type='hidden' size='10' value=".$objConsItemCI->Sequencia." />
			 <input name='user' type='hidden' size='10' value=".$usuario." />
			 <input name='AlteraI' type='submit' class='button' value='Alterar Item' />
			 <input name='volta' type='hidden' size='10' value='1' />
			 </form></td>
			 <td><form action='ciWItensDComplementar.php' method='post' name='ciWCriar'><input name='solic' type='hidden' size='10' value=".$solicitacao." /><input name='sequencia' type='hidden' size='10' value=".$objConsItemCI->Sequencia." /><input name='user' type='hidden' size='10' value=".$usuario." /><input name='AlteraF' type='submit' class='button' value='Dados Financeiros' /></form></td><td align='center'>".$btExc."</td>
			 <td><form action='ciWExcluiItem.php' method='post' name='ciWCriar'><input name='retorno' type='hidden' size='10' value='ciWInserirItens.php' /><input name='solic' type='hidden' size='10' value=".$solicitacao." /><input name='sequencia' type='hidden' size='10' value=".$objConsItemCI->Sequencia." /> <input name='excluir' type='submit' class='button' value='Excluir' /></form></td></tr>"; 
			  $totalCi=($objConsItemCI->Pr_unitario*$objConsItemCI->Quantidade)+$totalCi;
			  $_SESSION['totalCi']=$totalCi;
			  }
?><tr >
    <th colspan="2" align="right"><strong>VALOR TOTAL DA SOLICITA&Ccedil;&Atilde;O</strong></th><th  align="right"><?php echo "R$".number_format($totalCi, 2, ',', '.'); ?></th><th colspan="4" ></th></tr>  </table>
    </div><br />
	<?php	  
	}
  ?>
  <table border='0' width='100%'>
<tr><td colspan='2'>
<div align='right'><br/>
<?php if($contarItensImprimir==1){
	?>
    <form action='imprimeCi.php' method='post' name='form4.id_CIImprimir' target="_blank" >
    <input name='id_ciImpressao' id='id_ciImpressao' value='<?php echo $solicitacao; ?>' size='40' type='hidden' />
	<input name='imp' id='imp' value='home' size='40' type='hidden' />
  <input name="cont" class="button" type="submit" value="IMPRIMIR CI" />
</form>
<?php 
}
?>
</div>
 </td></tr></table>
<BR/>  
<form action="ciWItensDComp.php" enctype="multipart/form-data" method="post" name="ciWCriar" onSubmit="this.elements['caditem'].disabled=true;"> 
<table border='0' width='100%'>
  <tr><td colspan='6'>
  <font size="3" ><strong>INSER&Ccedil&AtildeO DE NOVO ITEM</strong></font>
  <div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
  </td></tr>
  <tr><td>
  <?php $cdMaterial=''; ?>
<strong><font color=red>*</font>Material:</strong> 
</td>
<td colspan='5'>
	<br/><input type="text" name="cdMaterial" id="cdMaterial" class="input" size="70" onKeyUp="buscarPrazo(this.value)" onKeyDown="buscarPrazo(this.value)" onBlur="buscarPrazo(this.value)" onFocus="buscarPrazo(this.value)" value="<?php echo $cdMaterialS; ?>"/>
<input type="hidden" name="idComp" id="idComp" class="input" size="20" value="1" /><input type="hidden" name="sol" id="sol" class="input" size="20" value="<?php echo $solicitacao;?>" /><br />
</td></tr>

<tr><td>
<strong><font color=red>*</font>Quantidade:</strong>
</td>
<td>
	<input class="input" name="quantidade" id="quantidade" type="text" size="14" onKeyUp="somenteNumeros(this)" maxlength="6" value="<?php echo $quantidadeS; ?>"/><br />
</td>
<td>
<strong><font color=red>*</font>Pre&ccedil;o Unit&aacute;rio:</strong>
</td>
<td>
	<input class="input" name="pr_unitario" id="pr_unitario" type="text" size="14" maxlength="11" value="<?php echo $precoUnitS; ?>"/><br />
</td>
</tr>
<tr>
<td>
  <strong>Prazo de Entrega:</strong>
  </td>
<td>
	<input class="input" id="pzent" name="pzent" type="text" size="15" maxlength="30" readonly="readonly" value="<?php echo $pzentS; ?>"/>
</td>
</tr>
<tr>
<td>
  <strong>Anexo(s) do Item:</strong>
  </td>
<td>
	<input name="anexo[]" id='anexo[]' type=file multiple /><br />
	(Selecione os arquivos segurando CTRL ou Shift / Max de 10Mb por arquivo)
</td>
</tr>
   <tr>
   <td> <strong>Detalhamento<br/> do Item:  </strong><br/>
   </td>
<td colspan='5'>
   <input class="input" name="userSol" id="userSol" type="hidden" size="40" onBlur="" value="<?php echo trim($arraySqlUsuario['campo20'])."-".trim($arraySqlUsuario['Nome']); ?>" /><input class="input" name="desc" type="hidden" size="102" maxlength="59"/><input name="embarquePedido" value="<?php echo $embarquePedido; ?>" type="hidden" /><textarea name="justificativa" id="justificativa" cols="87" rows="10" onKeyUp="limitaTextarea(this.value)"><?php echo $justItemS; ?></textarea><br />
  <strong>(Caracteres restantes: <span id="contador">2000</span></strong> )</textarea><br />
</td></tr>
<tr><td colspan='7'>
<div align='right'>	
   <input name="caditem" type="submit" value="Cadastrar Item" class="buttonVerde"/>
</div>
</td></tr>
<tr></tr>
</table>
</form>
<table border='0' width='100%'>
<tr><td colspan='2'>
<?php 
$queryCi="select sol.solicitacao,
       sol.cd_unid_negoc,
       sol.data,
       sol.desc_cond_pag,
       sol.local_entrega,
       sol.campo33 as setor,
       sol.campo27 as controle,
       sol.situacao,
       sol.campo32 as conta,
       sol.cod_cliente,
       --busca o nome completo da unidade de negócio
       (select un.nome_completo
        from GEUNIDNE un (nolock)
        where un.cd_unidade_de_n = sol.cd_unid_negoc) as nmUN,
       --busca a descrição do controle
       (select con.descricao
        from COCSO con (nolock)
        where con.controle = sol.campo27) as descControle,
        --busca a descrição da conta financeira
       (select cf.descricao
        from GFCONTA cf (nolock)
        where cf.cd_conta = sol.campo32) as descContaFinanc,
       --busca o nome completo do gestor
       (select emp.nome_completo
        from GEEMPRES emp (nolock)
        where emp.cd_empresa = sol.cod_cliente) as nmEmpresa
from COSOLICI sol (nolock)
where 
sol.solicitacao = '".$solicitacao."'";
$sqlCi=odbc_exec($conCab,$queryCi) or die(odbc_error());
$objResultados=odbc_fetch_array($sqlCi);
?>
<tr><td colspan='6'>
<div align='right'><br/>
<form action='ciWControle.php' method='post' name='form4.id_CIControle'>
<input type="hidden" name="numCi" value="<?php echo trim($objResultados['solicitacao']); ?>" />
<input type="hidden" name="usuario" value="<?php echo trim($usuario); ?>" />
<input type="hidden" name="codControle" value="<?php echo trim($objResultados['controle']); ?>" />
<input type="hidden" name="descControle" value="<?php echo trim($objResultados['descControle']); ?>" />
<input type="hidden" name="descCi" value="<?php echo trim($objResultados['desc_cond_pag']); ?>" />
<input type="hidden" name="retorno" value="ciWInserirItens.php" />
  <input name="cont" class="button" type="submit" value="FINALIZAR / ALTERAR CONTROLE" />
</form>
</div>

<a href="ciWInserir.php"><img src="imagens/botaoVoltar.png" /></a>
</td></tr>
</table>
</div>
</div>
</body>
</html>