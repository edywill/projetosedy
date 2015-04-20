<?php 
session_start();
//Recebe a conexão com o banco
require "../../conectsqlserverci.php";
//recebe a variável mandada por POST da tela anterior e utiliza o trim para excluir espaços em branco que podem ser digitados.
$solicitacao=trim($_POST['ci']);
//Faço a consulta no banco para identificar os dados que preciso da passagem
//Escolhi alguns campos que julguei necessário. Mas pode-se escolher outros ou retirar.
$consultaPassageiro="Select
GEEMPRES.Nome_completo,
  TEITEMSOLHOTEL.cd_empresa,
  TEITEMSOLHOTEL.dt_entrada,
  TEITEMSOLHOTEL.dt_saida,
  TEITEMSOLHOTEL.cargo,
  TEITEMSOLHOTEL.reserva,
  GEPFISIC.cargo AS cargo2
From
  COSOLICI With(NoLock) Inner Join
 TEITEMSOLHOTEL With(NoLock) On COSOLICI.Solicitacao =
    TEITEMSOLHOTEL.cd_solicitacao Inner Join
  GEEMPRES On TEITEMSOLHOTEL.cd_empresa = GEEMPRES.Cd_empresa
  left join GEPFISIC with (nolock) on
	GEPFISIC.Cd_empresa = TEITEMSOLHOTEL.cd_empresa
Where COSOLICI.Solicitacao='".$solicitacao."'
ORDER BY TEITEMSOLHOTEL.reserva";
$resconsultaPas=odbc_exec($conCab, $consultaPassageiro) or die("<p>".odbc_errormsg()); 
//Conto para identificar se existe passagem nessa CI
$countConsultaPas=odbc_num_rows($resconsultaPas);

//Caso não exista eu finalizo e volto para a página anterior
 if($countConsultaPas==0){
?>
       <script type="text/javascript">
       alert("Nao foi encontrado nenhuma hospedagem nessa Solicitacao.");
       window.location="../index.php";
       </script>
<?php

}
//Senão eu continuo o script
else{

//Nesse Select pode-se declarar mais informações da CI caso julgue necessário.
//Quando precisar chamar, chame-os no campo array declaro abaixo. Serve para escrever o título da tabela por exemplo.

$consultaCi="Select
  COSOLICI.Desc_cond_pag
From
  COSOLICI (nolock) 
  WHERE COSOLICI.Solicitacao='".$solicitacao."'";
$resconsultaCi=odbc_exec($conCab, $consultaCi) or die("<p>".odbc_errormsg()); 
$arrayConsultaCi=odbc_fetch_array($resconsultaCi);

//Faço a conexão com o banco MySQL, para pegar as companhias aéras e descontos
require "../../conexaomysql.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../../ajax/funcs.js"></script>
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='../../jquery.autocomplete.js'></script>
  <link rel="stylesheet" type="text/css" href="../../jquery.autocomplete.css" />
<script type="text/javascript">
  $().ready(function() {
	  $("#txprojeto").autocomplete("../suggest_projeto.php", {
		  width: 360,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script>
  $(function() {
	  $( "#datainicial" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#datafinal" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
<script type='text/javascript' src='../../jquery_price.js'></script>
<script type='text/javascript'>
  	  $(document).ready(function(){
      $('#totTxServ').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
	  $('#totTxIss').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
	  $('#totTxCont').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
  </script>
<style>
    .sel { width: 70px; }
    
</style>

</head>
    
<body>
<div id='box3' style="height:auto">
    <?php
       $selectAutorizacao=mysql_query("select * from registroshos where solicitacao='$solicitacao'");
       $arrayAut=mysql_fetch_array($selectAutorizacao);
       $arrayAut['autorizacao'];
       
       if(!empty($arrayAut['autorizacao'])){
            $autorizacaoId=$arrayAut['autorizacao']; 
			$autorizacaoId="Nº: <font color='blue'>".$autorizacaoId."</font>";
        } else {
            $autorizacaoId='';
        }?>
    <div id='content' style=\"width:100%\">
    <h3>AUTORIZAÇÃO DE FATURAMENTO DE HOSPEDAGEM <?php echo $autorizacaoId; ?> </h3>
		<form action='salvaHospedagem.php' method='post' target='_blank'>
        <input type='hidden' name='ci' id='ci' value='<?php  echo $solicitacao; ?>'/>
    <?php
    
    
     $selectProj=mysql_query("select solicitacao, projeto from registroshos where solicitacao= '".$solicitacao."'") or die(mysql_error());
     $arrayProj=mysql_fetch_array($selectProj);
    
    echo "   
       <hr/>
            
            <br/>
			<div id='notable' style='width:96%'><table>
			<tr><td colspan='2'>
			<strong>Digite parte do nome ou o n&uacute;mero para pesquisar:</strong><br></td></tr>
            <tr><td>
			<strong>Processo: </strong></td>";
       if(!empty($arrayProj['projeto'])){
		   $sqlProj=odbc_exec($conCab,"SELECT projeto, assunto FROM GMPROCDOC(nolock) WHERE projeto like '".$arrayProj['projeto']."'");
		   $arrProj=odbc_fetch_array($sqlProj);
		    echo "<td><input type='text' class='input' size='90' name='txprojeto' id='txprojeto' value='".trim($arrProj['projeto'])."-".trim(mb_convert_encoding($arrProj['assunto'],"UTF-8","ISO-8859-1"))."'/></td> ";	  
			  }
                 else { 
                     echo "<td><input type='text' name='txprojeto' class='input' size='90' id='txprojeto' /></td> "; 
                     
                 }          
         $selectPeriodo=mysql_query("SELECT datainicial, datafinal, evento FROM registroshos WHERE solicitacao='".$solicitacao."'") or die(mysql_error());
	 $arrayPeriodo=mysql_fetch_array($selectPeriodo);
          
    ?></tr><br/>
    
            <tr>
            <?php 
			if ($arrayPeriodo['datainicial'] == '' || $arrayPeriodo['datainicial']=='0000-00-00') { 
			     echo '';
				}else{
					 date('d/m/Y', strtotime($arrayPeriodo['datainicial']) );
					} ?>
                <td><strong>Período: </strong></td><td><input class="input" type="text" name="datainicial" id="datainicial"  readonly="readonly" value="<?php 
			if ($arrayPeriodo['datainicial'] == '' || $arrayPeriodo['datainicial']=='0000-00-00') { 
			     echo '';
				}else{
					echo date('d/m/Y', strtotime($arrayPeriodo['datainicial']) );
					} ?>" maxlength='10' size='10'  /> 
                            a 
                                    <input class="input" type="text" name="datafinal" id="datafinal"  value="<?php 
			if ($arrayPeriodo['datafinal'] == '' || $arrayPeriodo['datafinal']=='0000-00-00') { 
			     echo '';
				}else{
					echo date('d/m/Y', strtotime($arrayPeriodo['datafinal']) );
					} ?>"  maxlength='10' size='10' readonly='readonly'/></td>
            </tr><tr>
                <td><strong>Complemento: </strong></td><td><input class="input" type="text" size="90" maxlength="145" name="evento" value="<?php echo $arrayPeriodo['evento']; ?>"/></td>
            </tr>
    </table></div>
    <br><hr/>
    <br>
  
<div id="tabela" style="width:96%">

    <table width="100%">
    <tr><th colspan="8" align="center"><h2>LISTAGEM DE HOSPEDAGENS</h2></th></tr>

    <tr>
        <th align="left"><strong><u>CI Nº</u>: <?php echo $solicitacao; ?></strong></th><th colspan="7" align="right"><strong><u>DESCRI&Ccedil;&Atilde;O DA CI</u>: </strong><?php echo mb_convert_encoding($arrayConsultaCi['Desc_cond_pag'],"UTF-8","ISO-8859-1"); ?></th>
    </tr>
    <tr>
        <th width="25%">Nome</th><th width="17%">Cargo</th><th width="7%">Apto.</th><th width="11%">Entrada</th><th width="11%">Saída</th><th width="8%">Qtd. Diárias</th><th width="7%">VLR/Dia</th><th width="7%">Total</th></tr>
  <?php 
  $VrJs2=0;
  $cont=0;
  $vlTipo=0;
  //Função javascript para pegar valores totais
  echo "<script type=\"text/javascript\">

var req2;

// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarDesc(valor) {

// Abaixo colocamos a(s) resposta(s) na div resultado que está lá no teste.php
ab=(moeda2float(document.getElementById('totTxServ').value)*document.getElementById('totalG').value)/100;
document.getElementById('totServ').value=ab;
document.getElementById('VtotServ').innerHTML=float2moeda(ab);

cd=(moeda2float(document.getElementById('totTxIss').value)*document.getElementById('totalG').value)/100;
document.getElementById('totIss').value=cd;
document.getElementById('VtotIss').innerHTML=float2moeda(cd);

ef=(moeda2float(document.getElementById('totTxCont').value)*document.getElementById('totalG').value)/100;
document.getElementById('totCont').value=ef;
document.getElementById('VtotCont').innerHTML=float2moeda(ef);

gh=(ef*1)+(cd*1)+(ab*1)+(document.getElementById('totalG').value*1);
document.getElementById('totGFinal').value=gh;
document.getElementById('totGeralFinal').innerHTML=float2moeda(gh);
}
</script>";
//Contador para trabalhar o Javascript de valores
  for($i=1;$i<=$countConsultaPas;$i++){
	  $VrJs=0;
	  echo "
	  <script type='text/javascript'>
  	  $(document).ready(function(){
      $('#vlDia".$i."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
	  $('#qtdDias".$i."').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: '.'
      });
    });
  </script>
	  <script type=\"text/javascript\">
function float2moeda(num) {

   x = 0;

   if(num<0) {
      num = Math.abs(num);
      x = 1;
   }
   if(isNaN(num)) num = \"0\";
      cents = Math.floor((num*100+0.5)%100);

   num = Math.floor((num*100+0.5)/100).toString();

   if(cents < 10) cents = \"0\" + cents;
      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
         num = num.substring(0,num.length-(4*i+3))+'.'
               +num.substring(num.length-(4*i+3));
   ret = num + ',' + cents;
   if (x == 1) ret = ' - ' + ret;
   return ret;

}

function moeda2float(moeda){

   moeda = moeda.replace(\".\",\"\");

   moeda = moeda.replace(\",\",\".\");

   return parseFloat(moeda);

}
var req;

// FUNÇÃO PARA BUSCA DO QUE PROCURA
function buscarDescontos".$i."(valor) {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject(\"Microsoft.XMLHTTP\");
}

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = \"consultaDesconto.php?valor=\"+valor;

// Chamada do método open para processar a requisição
req.open(\"Get\", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

// Abaixo colocamos a(s) resposta(s) na div resultado que está lá no teste.php
f=document.getElementById('vlTotH".$i."').value;
a=(moeda2float(document.getElementById('vlDia".$i."').value)*moeda2float(document.getElementById('qtdDias".$i."').value));
document.getElementById('totalLinha".$i."').innerHTML=float2moeda(a);
document.getElementById('vlTotH".$i."').value=a;

d=((document.getElementById('totalG').value*1)-f)+a;
document.getElementById('totalG').value=d;
document.getElementById('totalGeral').innerHTML=float2moeda(d);
g=d+(document.getElementById('totIss').value*1)+(document.getElementById('totServ').value*1)+(document.getElementById('totCont').value*1);
document.getElementById('totGFinal').value=g;
document.getElementById('totGeralFinal').innerHTML=float2moeda(g);
	buscarDesc(g);
	}
}
req.send(null);
}
</script>";
}

$vlTipo=0;
$contCampos=0;
$numReserva=0;
while($objPassagens=odbc_fetch_object($resconsultaPas)){
$cont++;
$cargoTemp='';
if(!empty($objPassagens->cargo)){
	$cargoTemp=mb_convert_encoding($objPassagens->cargo,"UTF-8","ISO-8859-1");
	}else{
		$cargoTemp=mb_convert_encoding($objPassagens->cargo2,"UTF-8","ISO-8859-1");
		}
$sqlRl=odbc_exec($conCab,"SELECT reserva FROM TEITEMSOLHOTEL (nolock) WHERE cd_solicitacao='".$solicitacao."' AND reserva='".$objPassagens->reserva."'");
$countRl=odbc_num_rows($sqlRl);
$tipo='';
if($countRl<2){
	$tipo='Single';
	}else{
		$tipo='Duplo';
		}
echo "<tr><td>".mb_convert_encoding($objPassagens->Nome_completo,"UTF-8","ISO-8859-1")."<input type='hidden' name='idBen".$cont."' id='idBen".$cont."' size='5'/></td><td>".$cargoTemp."</td>";
if($tipo=='Duplo'){
	if($objPassagens->reserva<>$numReserva){
		$numReserva=$objPassagens->reserva;
		$contCampos++;
	  $selectDados=mysql_query("SELECT * FROM registroshos as reg WHERE reg.solicitacao='".$solicitacao."' AND reg.seq='".$contCampos."'") or die(mysql_error());
	  $arrayDados=mysql_fetch_array($selectDados);
	echo "<td rowspan='2' valign='center'>".$tipo."</td>";
	echo "<td rowspan='2' valign='center'>".date('d/m/y', strtotime($objPassagens->dt_entrada))."</td><td rowspan='2' valign='center'>".date('d/m/y', strtotime($objPassagens->dt_saida))."</td><td rowspan='2' valign='center'><input type='text' name='qtdDias".$contCampos."' id='qtdDias".$contCampos."' class='input' size='1' value='".$arrayDados['qtddias']."' onblur=\"buscarDescontos".$contCampos."(this.value)\"/></td><td rowspan='2' valign='center'><input type='text' name='vlDia".$contCampos."' id='vlDia".$contCampos."' class='input' size='5' value='".number_format($arrayDados['vldia'], 2, ',', '.')."' onblur=\"buscarDescontos".$contCampos."(this.value)\"/></td><td rowspan='2' valign='center'>R$ <input type='hidden' name='vlTotH".$contCampos."' id='vlTotH".$contCampos."' size='5' value='".number_format($arrayDados['vltot'], 2, '.', '')."'/><div id='totalLinha".$contCampos."'>".number_format($arrayDados['vltot'], 2, ',', '.')."</div></td>";
		}
	}else{
		$contCampos++;
		$selectDados=mysql_query("SELECT * FROM registroshos as reg WHERE reg.solicitacao='".$solicitacao."' AND reg.seq='".$contCampos."'") or die(mysql_error());
	    $arrayDados=mysql_fetch_array($selectDados);
		echo "<td>".$tipo."</td>";
		echo "<td>".date('d/m/y', strtotime($objPassagens->dt_entrada))."</td><td>".date('d/m/y', strtotime($objPassagens->dt_saida))."</td><td><input type='text' name='qtdDias".$contCampos."' id='qtdDias".$contCampos."' class='input' size='1' value='".$arrayDados['qtddias']."' onblur=\"buscarDescontos".$contCampos."(this.value)\"/></td><td><input type='text' name='vlDia".$contCampos."' id='vlDia".$contCampos."' class='input' size='5' value='".number_format($arrayDados['vldia'], 2, ',', '.')."' onblur=\"buscarDescontos".$contCampos."(this.value)\"/></td><td>R$ <input type='hidden' name='vlTotH".$contCampos."' id='vlTotH".$contCampos."' size='5' value='".number_format($arrayDados['vltot'], 2, '.', '')."'/><div id='totalLinha".$contCampos."'>".number_format($arrayDados['vltot'], 2, ',', '.')."</div></td>";
		}
	echo "</tr>";
}
$selectDados=mysql_query("SELECT * FROM registroshos as reg WHERE reg.solicitacao='".$solicitacao."'") or die(mysql_error());
$arrayDados=mysql_fetch_array($selectDados);
$pServ=0;
$pCont=0;
$pIss=0;
if(!empty($arrayDados)){
	if(((float)$arrayDados['tgeral'])>0){
		$pServ=($arrayDados['tserv']*100)/$arrayDados['tgeral'];
		$pCont=($arrayDados['tcont']*100)/$arrayDados['tgeral'];
		$pIss=($arrayDados['tiss']*100)/$arrayDados['tgeral'];
	}
}
echo "<tr><td colspan='3' rowspan='9'></td><td colspan='2'><strong>Total diárias</strong></td><td>-</td><td colspan='2' align='right'>R$ <input type='hidden' name='totalG' id='totalG' size='5' value='".number_format($arrayDados['tgeral'], 2, '.', '')."'/><spam id='totalGeral'> ".number_format($arrayDados['tgeral'], 2, ',', '.')." </spam></td><tr>
      <tr><td colspan='2'><strong>Total taxa de serviço</strong></td><td><input type='text' name='totTxServ' id='totTxServ' class='input' size='1'  onblur=\"buscarDesc(this.value)\" value='".number_format($pServ, 2, ',', '.')."'/>%</td><td colspan='2' align='right'>R$ <spam id='VtotServ'>".number_format($arrayDados['tserv'], 2, ',', '.')."</spam><input type='hidden' name='totServ' id='totServ' class='input' size='1' value='".number_format($arrayDados['tserv'], 2, '.', ',')."'/></td><tr>
	  <tr><td colspan='2'><strong>Total taxa de ISS</strong></td><td><input type='text' name='totTxIss' id='totTxIss' onblur=\"buscarDesc(this.value)\" class='input' size='1' value='".number_format($pIss, 2, ',', '.')."'/>%</td><td colspan='2' align='right'>R$ <spam id='VtotIss'>".number_format($arrayDados['tiss'], 2, ',', '.')."</spam><input type='hidden' name='totIss' id='totIss' class='input' size='1' value='".number_format($arrayDados['tiss'], 2, '.', '')."'/></td><tr>
	  <tr><td colspan='2'><strong>Total contratual</strong></td><td><input type='text' name='totTxCont' id='totTxCont' onblur=\"buscarDesc(this.value)\" class='input' size='1' value='".number_format($pCont, 2, ',', '.')."'/>%</td><td colspan='2' align='right'>R$ <spam id='VtotCont'>".number_format($arrayDados['tcont'], 2, ',', '.')."</spam><input type='hidden' name='totCont' id='totCont' class='input' size='1' value='".number_format($arrayDados['tcont'], 2, '.', ',')."'/></td><tr>
	  <tr><th colspan='2'><strong>Total com taxas</strong></th><th></th><th colspan='2' align='right'>R$ <input type='hidden' name='totGFinal' id='totGFinal' class='input' size='1' value='".number_format($arrayDados['tgeralf'], 2, '.', '')."'/><spam id='totGeralFinal'>".number_format($arrayDados['tgeralf'], 2, ',', '.')."</spam></th><tr>";
     ?>
	 </table>
     <a href='../index.php'><input type='button' class='button' value='<<VOLTAR'></a><div align='right'><input type='hidden' name='contador' id='contador' class='input' size='8' value='<?php echo $cont; ?>'/><input type='hidden' name='contCampos' id='contCampos' class='input' size='8' value='<?php echo $contCampos; ?>'/><input type='submit' align= 'center' class='buttonVerde' value='SALVAR'></div>
</form>
<br/><br/>
</div></div></div>

</body>
</html>
<?php 
}
?>