<?php 
session_start();
//Recebe a conexão com o banco
require "../../conectsqlserverciprod.php";
include "../../mb.php";
//recebe a variável mandada por POST da tela anterior e utiliza o trim para excluir espaços em branco que podem ser digitados.
$solicitacao=trim($_POST['ci']);
$tipo=$_POST['tipo'];
if($tipo==''){
?>
       <script type="text/javascript">
       alert("Selecione o tipo de passagem.");
       window.location="indexPas.php";
       </script>
<?php	
	}
//Faço a consulta no banco para identificar os dados que preciso da passagem
//Escolhi alguns campos que julguei necessário. Mas pode-se escolher outros ou retirar.
$consultaPassageiro="Select
  (Case When TEITEMSOLPASSAGEM.cadeirante = 1 Then '* ' + GEEMPRES.Nome_completo
    Else GEEMPRES.Nome_completo End) Nome_completo,
  TEITEMSOLPASSAGEM.cd_empresa,
  TEITEMSOLPASSAGEM.dt_partida,
  TEITEMSOLPASSAGEM.sequencia,
  TEITEMSOLPASSAGEM.hr_partida,
  TEITEMSOLPASSAGEM.dt_chegada,
  TEITEMSOLPASSAGEM.hr_chegada,
  Case When TEITEMSOLPASSAGEM.cadeirante = 1 Then 'X' End cadeirante,
  TEITEMSOLPASSAGEM.observacao,
  TEITEMSOLPASSAGEM.trecho
From
  COSOLICI With(NoLock) Inner Join
  TEITEMSOLPASSAGEM With(NoLock) On COSOLICI.Solicitacao =
    TEITEMSOLPASSAGEM.cd_solicitacao Inner Join
  GEEMPRES With(NoLock) On TEITEMSOLPASSAGEM.cd_empresa = GEEMPRES.Cd_empresa
  WHERE COSOLICI.Solicitacao='".$solicitacao."'";
$resconsultaPas=odbc_exec($conCab, $consultaPassageiro) or die("<p>".odbc_errormsg()); 
//Conto para identificar se existe passagem nessa CI
$countConsultaPas=odbc_num_rows($resconsultaPas);

//Caso não exista eu finalizo e volto para a página anterior
 if($countConsultaPas==0){
?>
       <script type="text/javascript">
       alert("N\u00e3o foi encontrado nenhuma passagem nessa solicita\u00e7\u00e3o.");
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
		  width: 670,
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
<style>
    .sel { width: 70px; }
    
</style>

</head>
    
<body>
<div id='box3' style="height:auto">
    
    <?php
       $selectAutorizacao=mysql_query("select * from registros where solicitacao='".$solicitacao."' AND tipo='".$tipo."'");
       $arrayAut=mysql_fetch_array($selectAutorizacao);
       $arrayAut['autorizacao'];
       
       if(!empty($arrayAut['autorizacao'])){
            $autorizacaoId=$arrayAut['autorizacao']; 
			$autorizacaoId="Nº: <font color='blue'>".$autorizacaoId."/".$arrayAut['ano']."</font>";
        } else {
            $autorizacaoId='';
        }
		echo  "<div id='content' style=\"width:100%\"><h3>AUTORIZAÇÃO DE PASSAGEM ".$autorizacaoId."</h3>";
		echo "<form action='salvaPassagem.php' method='post' target='_blank'><input type='hidden' class='input' size='90' name='tipo' id='tipo' value='".$tipo."'/>";
    ?>    
        
      
    
    <?php
     $selectProj=mysql_query("select solicitacao, projeto from registros where solicitacao= '".$solicitacao."' AND tipo='".$tipo."'") or die(mysql_error());
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
		    echo "<td><input type='text' class='input' size='85' name='txprojeto' id='txprojeto' value='".trim($arrProj['projeto'])."-".trim(mb_convert_encoding($arrProj['assunto'],"UTF-8","ISO-8859-1"))."'/></td> ";	  
			  }
                 else { 
                     echo "<td><input type='text' name='txprojeto' class='input' size='85' id='txprojeto' /></td> "; 
                     
                 }          
         $selectPeriodo=mysql_query("SELECT datainicial, datafinal, evento FROM registros WHERE solicitacao='".$solicitacao."' AND tipo='".$tipo."'") or die(mysql_error());
	 $arrayPeriodo=mysql_fetch_array($selectPeriodo);
          
    ?></tr><br/>
    
            <tr>
            <?php 
			     $dtInCi='';
				 $dtFimCi='';
				 $sqlDtCi=odbc_exec($conCab,"SELECT dt_partida, dt_chegada FROM TEITEMSOLPASSAGEM(nolock) WHERE cd_solicitacao='".$solicitacao."'");
		   		 while($objDtCi=odbc_fetch_object($sqlDtCi)){
										 if(empty($dtInCi)){
											 $dtInCi=date("d/m/Y",strtotime($objDtCi->dt_partida));
											 }elseif(date("d/m/Y",strtotime($objDtCi->dt_partida))<$dtInCi){
												 $dtInCi=date("d/m/Y",strtotime($objDtCi->dt_partida));
												 }
										if(empty($dtFimCi)){
											 $dtFimCi=date("d/m/Y",strtotime($objDtCi->dt_chegada));
											 }elseif(date("d/m/Y",strtotime($objDtCi->dt_chegada))>$dtFimCi){
												 $dtFimCi=date("d/m/Y",strtotime($objDtCi->dt_chegada));
												 }
										 }
if($dtFimCi=='31/12/1969'){
	$dtFimCi='';
	}
			?>
                <td><strong>Período: </strong></td><td><input class="input" type="text" name="datainicial" id="datainicial"  readonly="readonly" value="<?php 
			if ($arrayPeriodo['datainicial'] == '' || $arrayPeriodo['datainicial']=='0000-00-00') { 
			echo $dtInCi;
				}else{
					echo date('d/m/Y', strtotime($arrayPeriodo['datainicial']) );
					} ?>" maxlength='10' size='10'  /> 
                            a 
                                    <input class="input" type="text" name="datafinal" id="datafinal"  value="<?php 
			if ($arrayPeriodo['datafinal'] == '' || $arrayPeriodo['datafinal']=='0000-00-00') { 
			    echo $dtFimCi;
				}else{
					echo date('d/m/Y', strtotime($arrayPeriodo['datafinal']) );
					} ?>"  maxlength='10' size='10' readonly='readonly'/></td>
            </tr><tr>
                <td><strong>Complemento: </strong></td><td><input class="input" type="text" size="85" maxlength="145" name="evento" value="<?php echo $arrayPeriodo['evento']; ?>"/></td>
            </tr>
    </table></div>
    <br><hr/>
    <br>
  
<div id="tabela">
    <table width="838px"><tr><th colspan="9" align="center"><h2>LISTAGEM DE PASSAGENS</h2></th></tr>

    <tr>
        <th align="left"><strong><u>CI Nº</u>: <?php echo $solicitacao; ?></strong></th><th colspan="10" align="right"><strong><u>DESCRI&Ccedil;&Atilde;O DA CI</u>: </strong><?php echo mb_convert_encoding($arrayConsultaCi['Desc_cond_pag'],"UTF-8","ISO-8859-1"); ?></th>
    </tr>
    <tr>
        <th width="20%">Nome</th><th width="30%">Trecho</th><th width="10%">Localizador</th><th width="7%">Valor da Passagem</th><th width="5%">Taxa de Embarque</th><th width="5%">Taxa de Serviço</th><th width="7%">CIA Aérea</th><th width="7%">Desconto</th><th width="7%">Valor Final</th>
    </tr>
    
  <?php 
  
  $cont=0;
  $p1='';
  $p2='';
  $vlTipo=0;
  if($tipo=='I'){
	  $p1='226';
	  $p2='227';
	  }elseif($tipo=='N'){
		  $p1='228';
	  	  $p2='229';
		  }
  while($objPassagens=odbc_fetch_object($resconsultaPas)){
	  $sqlCoisolici=odbc_exec($conCab,"Select
  ESMATERI.Cd_reduzido
From
  COISOLIC with(nolock) Inner Join
  ESMATERI On COISOLIC.Cd_material = ESMATERI.Cd_material
  WHERE COISOLIC.Cd_solicitacao='".$solicitacao."' AND
  COISOLIC.Sequencia=".$objPassagens->sequencia."");
	  $arrayCoisolic=odbc_fetch_array($sqlCoisolici);
	  if($arrayCoisolic['Cd_reduzido']==$p1 || $arrayCoisolic['Cd_reduzido']==$p2){
	  //echo $p2."-".$p1."-".$objPassagens->Cd_reduzido."<br>"; 
	  $vlTipo++;
	  //Coloquei um contador zerado ao qual incremento ele aqui
	  $cont++;
	  if(empty($objPassagens->dt_chegada)){
	  //Chamo a função do Javascript adequando ela ao contador, essa função é responsável por pegar o valor do select de cia aerea, e jogar para consulta na página consultaDesconto.php e retornar o valor do desconto no campo Desconto e ainda calcula o valor original vezes esse percentual.
	  echo "
	  <script type='text/javascript'>
  	  $(document).ready(function(){
      $('#vlOrg".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#txServico".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#txEmbarque".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#vlTot".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
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
function buscarDescontos".$cont."(valor) {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject(\"Microsoft.XMLHTTP\");
}
valor2=document.getElementById('cia".$cont."').value;
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = \"consultaDesconto.php?valor=\"+valor2;

// Chamada do método open para processar a requisição
req.open(\"Get\", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

// Abaixo colocamos a(s) resposta(s) na div resultado que está lá no teste.php
a=(moeda2float(document.getElementById('vlOrg".$cont."').value)*resposta)/100;
document.getElementById('desconto".$cont."').value = float2moeda(a);
b=moeda2float(document.getElementById('vlOrg".$cont."').value)-a;
c=moeda2float(document.getElementById('txServico".$cont."').value)+moeda2float(document.getElementById('txEmbarque".$cont."').value);
d=b+c;
document.getElementById('vlTot".$cont."').value=float2moeda(d);
}
}
req.send(null);
}
</script>
";

	  //Busco os dados já salvos, caso tenha no banco do MySQL
	  $selectDados=mysql_query("SELECT cia.id,cia.nome,cia.desconto,reg.vlorg,reg.vltot, reg.txEmbarque, reg.txServico, reg.localizador FROM registros as reg LEFT JOIN cia ON reg.idcia=cia.id WHERE reg.solicitacao='".$solicitacao."' AND reg.seq='".$cont."' AND reg.tipo='".$tipo."'") or die(mysql_error());
	  $arrayDados=mysql_fetch_array($selectDados);
          
	  echo "<tr><td><strong>".mb_convert_encoding($objPassagens->Nome_completo,"UTF-8","ISO-8859-1")."</strong></td><td>".utf8_encode(wordwrap($objPassagens->trecho, 8, "\n", true))."</td>
                  
          <td><br><input type='hidden' name='idBen".$cont."' id='idBen".$cont."' class='input' size='7' value='".trim($objPassagens->cd_empresa)."'/>
		  <input type='text' name='txLocalizador".$cont."' id='txLocalizador".$cont."' class='input' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\" size='7' value='".$arrayDados['localizador']."'/></td>";
          
          
           if (($arrayDados['vlorg'] == "") or ($arrayDados['vlorg'] == "0.00") ) {     
                 echo "<td>R$<input type='text' name='vlOrg".$cont."' id='vlOrg".$cont."' class='input' size='5' value='' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td>"; 
           }else{  
                echo "<td>R$<input type='text' name='vlOrg".$cont."' id='vlOrg".$cont."' class='input' size='5' value='".number_format($arrayDados['vlorg'],2, ',', '.')."' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td>"; 
           }
	  
           if (($arrayDados['txEmbarque'] == "") or ($arrayDados['txEmbarque'] == "0.00"))  {   
                  echo "<td>R$<input type='text' name='txEmbarque".$cont."' id='txEmbarque".$cont."' class='input' size='3' value='' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\" /></td>";
           }else{
                 echo "<td>R$<input type='text' name='txEmbarque".$cont."' id='txEmbarque".$cont."' class='input' size='3' value='".number_format($arrayDados['txEmbarque'],2, ',', '.')."' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td>";
           }
           
           if (($arrayDados['txServico'] == "") or ($arrayDados['txServico'] == "0.00")) {   
                  echo "<td>R$<input type='text' name='txServico".$cont."' id='txServico".$cont."' class='input' size='3' value=''  onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td>";
           }else{
                  echo "<td>R$<input type='text' name='txServico".$cont."' id='txServico".$cont."' class='input' size='3' value='". number_format($arrayDados['txServico'],2, ',', '.')."' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td>";
           }
           
          echo "<td><br><div id='select'><select class='sel' name='cia".$cont."' id='cia".$cont."' onchange=\"buscarDescontos".$cont."(this.value)\" />";
	  //Busco os dados de desconto da CIA
	  $selectCompanhia=mysql_query("SELECT id,nome FROM cia") or die(mysql_error());
	  
	      if(!empty($arrayDados['nome'])){
		    echo "<option value='".$arrayDados['id']."' selected>".$arrayDados['nome']."</option>";	  
			  }
	  while($objCia=mysql_fetch_object($selectCompanhia)){
		  if(!empty($arrayDados['nome'])){
			  if($arrayDados['nome']<>$objCia->nome){
		         echo "<option value='".$objCia->id."'>".$objCia->nome."</option>";		  
				  }
			  }else{
		echo "<option value='".$objCia->id."'>".$objCia->nome."</option>";
			  }
		  }
		  $descUni=0;
		  if($arrayDados['vlorg']<>0){
		  $descUni=number_format(($arrayDados['vlorg']*$arrayDados['desconto'])/100,2, ',', '.');
		  }
	  echo "</select></div></td><td width='5px'>%<br><input type='text' name='desconto".$cont."' id='desconto".$cont."' class='input'  size='1' value='".$descUni."' readonly='readonly'/></td>";
          
          if (($arrayDados['vltot'] == "") or ($arrayDados['vltot'] == "0.00")) {   
                 echo "<td>R$<input type='text' name='vlTot".$cont."' id='vlTot".$cont."' class='input' size='5' value='' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td></tr>";
          }else{
                 echo "<td>R$<input type='text' name='vlTot".$cont."' id='vlTot".$cont."' class='input' size='5' value='".number_format($arrayDados['vltot'],2, ',', '.')."' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td></tr>";
          }
		  
		  //Caso nao tenha data de retorno
	  }else{
	  	echo "<tr><td rowspan='2'><strong>".mb_convert_encoding($objPassagens->Nome_completo,"UTF-8","ISO-8859-1")."</strong></td><td rowspan='2'>".utf8_encode(wordwrap($objPassagens->trecho, 8, "\n", true))."</td>";
     $tp='';
	 for($i=0;$i<2;$i++){
		 $selectDados=mysql_query("SELECT cia.id,cia.nome,cia.desconto,reg.vlorg,reg.vltot, reg.txEmbarque, reg.txServico, reg.localizador FROM registros as reg LEFT JOIN cia ON reg.idcia=cia.id WHERE reg.solicitacao='".$solicitacao."' AND reg.seq='".$cont."' AND reg.tipo='".$tipo."'") or die(mysql_error());
	  $arrayDados=mysql_fetch_array($selectDados);
		 //Chamo a função do Javascript adequando ela ao contador, essa função é responsável por pegar o valor do select de cia aerea, e jogar para consulta na página consultaDesconto.php e retornar o valor do desconto no campo Desconto e ainda calcula o valor original vezes esse percentual.
	  echo "
	  <script type='text/javascript'>
  	  $(document).ready(function(){
      $('#vlOrg".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#txServico".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#txEmbarque".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
      $('#vlTot".$cont."').priceFormat({
        prefix: '',
        centsSeparator: ',',
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
function buscarDescontos".$cont."(valor) {

// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject(\"Microsoft.XMLHTTP\");
}
valor2=document.getElementById('cia".$cont."').value;
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = \"consultaDesconto.php?valor=\"+valor2;

// Chamada do método open para processar a requisição
req.open(\"Get\", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

// Abaixo colocamos a(s) resposta(s) na div resultado que está lá no teste.php
document.getElementById('desconto".$cont."').value = resposta;
a=(moeda2float(document.getElementById('vlOrg".$cont."').value)*resposta)/100;
document.getElementById('desconto".$cont."').value = float2moeda(a);
b=moeda2float(document.getElementById('vlOrg".$cont."').value)-a;
c=moeda2float(document.getElementById('txServico".$cont."').value)+moeda2float(document.getElementById('txEmbarque".$cont."').value);
d=b+c;
document.getElementById('vlTot".$cont."').value=float2moeda(d);
}
}
req.send(null);
}
</script>
";	 
		 if($i==0){
			 $tp="IDA";
			 }else{
				 $tp="VOLTA";
				 }
     echo "<td>$tp<br><input type='hidden' name='idBen".$cont."' id='idBen".$cont."' class='input' size='7' value='".trim($objPassagens->cd_empresa)."'/>
	 <input type='text' name='txLocalizador".$cont."' id='txLocalizador".$cont."' class='input' size='7' value='".$arrayDados['localizador']."' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td>";
          
          
           if (($arrayDados['vlorg'] == "") or ($arrayDados['vlorg'] == "0.00") ) {     
                 echo "<td>R$<input type='text' name='vlOrg".$cont."' id='vlOrg".$cont."' class='input' size='5' value='' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td>"; 
           }else{  
                echo "<td>R$<input type='text' name='vlOrg".$cont."' id='vlOrg".$cont."' class='input' size='5' value='".number_format($arrayDados['vlorg'],2, ',', '.')."' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td>"; 
           }
	  
           if (($arrayDados['txEmbarque'] == "") or ($arrayDados['txEmbarque'] == "0.00"))  {   
                  echo "<td>R$<input type='text' name='txEmbarque".$cont."' id='txEmbarque".$cont."' class='input' size='3' value=''  onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td>";
           }else{
                 echo "<td>R$<input type='text' name='txEmbarque".$cont."' id='txEmbarque".$cont."' class='input' size='3' value='".number_format($arrayDados['txEmbarque'],2, ',', '.')."' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td>";
           }
           
           if (($arrayDados['txServico'] == "") or ($arrayDados['txServico'] == "0.00")) {   
                  echo "<td>R$<input type='text' name='txServico".$cont."' id='txServico".$cont."' class='input' size='3' value='' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td>";
           }else{
                  echo "<td>R$<input type='text' name='txServico".$cont."' id='txServico".$cont."' class='input' size='3' value='". number_format($arrayDados['txServico'],2, ',', '.')."' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td>";
           }
           
          echo "<td><br><div id='select'><select class='sel' name='cia".$cont."' id='cia".$cont."' onchange=\"buscarDescontos".$cont."(this.value)\" />";
	  //Busco os dados de desconto da CIA
	  $selectCompanhia=mysql_query("SELECT id,nome FROM cia") or die(mysql_error());
	  
	      if(!empty($arrayDados['nome'])){
		    echo "<option value='".$arrayDados['id']."' selected>".$arrayDados['nome']."</option>";	  
			  }
	  while($objCia=mysql_fetch_object($selectCompanhia)){
		  if(!empty($arrayDados['nome'])){
			  if($arrayDados['nome']<>$objCia->nome){
		         echo "<option value='".$objCia->id."'>".$objCia->nome."</option>";		  
				  }
			  }else{
		echo "<option value='".$objCia->id."'>".$objCia->nome."</option>";
			  }
		  }
		  $descUni=0;
		  if($arrayDados['vlorg']<>0){
		  $descUni=number_format(($arrayDados['vlorg']*$arrayDados['desconto'])/100,2, ',', '.');
		  }
	  echo "</select></div></td><td width='5px'>R$<br><input type='text' name='desconto".$cont."' id='desconto".$cont."' class='input' size='1' value='".$descUni."' readonly='readonly'/></td>";
          $trf="";
		  if($i==0){
			 $trf="</tr>";
			 }
          if (($arrayDados['vltot'] == "") or ($arrayDados['vltot'] == "0.00")) {   
                 echo "<td>R$<input type='text' name='vlTot".$cont."' id='vlTot".$cont."' class='input' size='5' value='' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td>".$trf."";
          }else{
                 echo "<td>R$<input type='text' name='vlTot".$cont."' id='vlTot".$cont."' class='input' size='5' value='".number_format($arrayDados['vltot'],2, ',', '.')."' onblur=\"buscarDescontos".$cont."(this.value)\" onkeyup=\"buscarDescontos".$cont."(this.value)\"/></td>".$trf."";
             }
			 if($i==0){
			 $cont++;
			  }
	        }
			echo "</tr>";
		  }
	  }
}
          echo "</table>";
	 if($vlTipo==0){
		 ?>
       <script type="text/javascript">
       alert("N\u00e3o foi encontrado nenhum passageiro para os dados informados.");
       window.location="indexPas.php";
       </script>
       <?php
		 }
	 echo "<a href='../index.php'><input type='button' class='button' value='<<VOLTAR'></a><div align='right'><input type='hidden' name='contador' id='contador' class='input' size='8' value='".$cont."'/><input type='hidden' name='ci' id='ci' class='input' size='8' value='".$solicitacao."'/><input type='submit' align= 'center' class='buttonVerde' value='SALVAR'></div>";
  ?>
</form>
<br/><br/>
</div></div></div>

</body>
</html>
<?php 
}
?>