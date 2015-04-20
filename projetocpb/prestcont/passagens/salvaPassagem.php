<?php 
session_start();
//Recebo as variáveis totais
$solicitacao=$_REQUEST['ci'];
$contadorOriginal=$_REQUEST['contador'];
$proj=explode("-",$_REQUEST['txprojeto']);
$projeto=$proj[0];
$assunto=str_replace($projeto."-",'',$_REQUEST['txprojeto']);
//$autorizacao=$_POST['id'];
$datainicial=$_POST['datainicial'];
$datafinal=$_POST['datafinal'];
$evento=$_POST['evento'];
//$assunto=$_REQUEST['assunto'];

//Faço a conexão com o banco CIGAM para pegar as informações do cabeçalho
require "../../conectsqlserverciprod.php";


//Faço a consulta no banco para identificar os dados que preciso da passagem (usuario e etc)
//Escolhi alguns campos que julguei necessário. Mas pode-se escolher outros ou retirar.
//Pode-se também trazer esses dados do formulário por $_POST da página anterior, para evitar essa consulta no banco, lembrando de coloca-los dentro do While que temos abaixo.
$consultaPassageiro="Select
  (case when TEITEMSOLPASSAGEM.cadeirante = 1 then '* ' + GEEMPRES.Nome_completo else GEEMPRES.Nome_completo end) Nome_completo,
  TEITEMSOLPASSAGEM.dt_partida,
  TEITEMSOLPASSAGEM.hr_partida,
  TEITEMSOLPASSAGEM.dt_chegada,
  TEITEMSOLPASSAGEM.hr_chegada,
  case when TEITEMSOLPASSAGEM.cadeirante = 1 then 'X' end cadeirante,
  TEITEMSOLPASSAGEM.observacao,
  TEITEMSOLPASSAGEM.sequencia,
  TEITEMSOLPASSAGEM.trecho
From
 -- COISOLIC with(nolock) Inner Join
 -- COSOLICI with(nolock) On COISOLIC.Cd_solicitacao = COSOLICI.Solicitacao Inner Join
COSOLICI with(nolock) Inner Join
  TEITEMSOLPASSAGEM with(nolock) On COSOLICI.Solicitacao = TEITEMSOLPASSAGEM.cd_solicitacao
  Inner Join
  GEEMPRES On TEITEMSOLPASSAGEM.cd_empresa = GEEMPRES.Cd_empresa 
  WHERE COSOLICI.Solicitacao='".$solicitacao."'";
$resconsultaPas=odbc_exec($conCab, $consultaPassageiro) or die("<p>".odbc_errormsg()); 

//Nesse Select pode-se declarar mais informações da CI caso julgue necessário.
//Quando precisar chamar, chame-os no campo array declaro abaixo. Serve para escrever o título da tabela por exemplo.
$consultaCi="Select
  COSOLICI.Desc_cond_pag,
  COSOLICI.Local_entrega as local
From
  COSOLICI (nolock) 
  WHERE COSOLICI.Solicitacao='".$solicitacao."'";
$resconsultaCi=odbc_exec($conCab, $consultaCi) or die("<p>".odbc_errormsg()); 
$arrayConsultaCi=odbc_fetch_array($resconsultaCi);


// Formata data dd/mm/aaaa para aaaa-mm-dd
    function datasql($databr) {
            if (!empty($databr)){
                    $p_dt = explode('-',$databr);
                    $data_sql = $p_dt[2].'-'.$p_dt[1].'-'.$p_dt[0];
            return $data_sql;}
    }
//---------------------------------//
$dataf=  '';
$datai= '';
        

//Faço a conexão com o banco MySQL, para pegar as companhias aéras e descontos
require "../../conexaomysql.php";
$contadorEx=0;
$contadorAt=1;
$tipo=$_POST['tipo'];
$selectMaxAutorizacao=  mysql_query("select max(autorizacao) as autatual from registros where ano='".date('Y')."'");
$arrayMaxAut=mysql_fetch_array($selectMaxAutorizacao);
while($contadorAt<=$contadorOriginal){
$dataf='';
$datai='';
$seq=$contadorAt;
$idBenN="idBen".$seq;
$idben=$_POST[$idBenN];
$vlorgN="vlOrg".$seq;
$vlorg=str_replace(".", "", $_POST[$vlorgN]);
$vlorg=str_replace(",", ".", $vlorg);
$vltotN="vlTot".$seq;
$vltot=str_replace(".", "", $_POST[$vltotN]);
$vltot=str_replace(",", ".", $vltot);
$txEmbarqueN="txEmbarque".$seq;
$txEmbarque=str_replace(".", "", $_POST[$txEmbarqueN]);
$txEmbarque=str_replace(",", ".", $txEmbarque);
$txServicoN="txServico".$seq;
$txServico=str_replace(".", "", $_POST[$txServicoN]);
$txServico=str_replace(",", ".", $txServico);
$idCiaN="cia".$seq;
$idcia=$_POST[$idCiaN];
$txLocalizadorN="txLocalizador".$seq;
$txLocalizador=$_POST[$txLocalizadorN];

						
$consExiste=mysql_query("SELECT * FROM registros WHERE solicitacao='".$solicitacao."' AND seq='".$seq."' AND tipo='".$tipo."'");
$contExiste=mysql_num_rows($consExiste);
$selectDadosPassagem=odbc_fetch_array(odbc_exec($conCab,"SELECT dt_partida, dt_chegada FROM TEITEMSOLPASSAGEM(nolock) WHERE cd_solicitacao='".$solicitacao."' AND  cd_empresa='".$idben."'"));
	if(!empty($selectDadosPassagem['dt_chegada'])){
		$dataChegadaArr=explode(" ",$selectDadosPassagem['dt_chegada']);
	$dataChegadaArr2=explode("-",$dataChegadaArr[0]);
    $dataf=$dataChegadaArr2[0]."-".$dataChegadaArr2[1]."-".$dataChegadaArr2[2];
	}else{
		$dataf='0000-00-00';
		}
	if(!empty($selectDadosPassagem['dt_partida'])){
	$dataPartidaArr=explode(" ",$selectDadosPassagem['dt_partida']);
	$dataPartidaArr2=explode("-",$dataPartidaArr[0]);
	$datai=$dataPartidaArr2[0]."-".$dataPartidaArr2[1]."-".$dataPartidaArr2[2];
	}else{
		$datai='0000-00-00';
		}
if($contExiste>0){
	$arrayExiste=mysql_fetch_array($consExiste);
	$autorizacao=$arrayExiste['autorizacao'];
	$atualizaDados=mysql_query("UPDATE registros SET autorizacao='".$autorizacao."', evento='".$evento."', idcia='".$idcia."',vlorg='".$vlorg."',txEmbarque='".$txEmbarque."',localizador='".$txLocalizador."',projeto='".$projeto."', datainicial='".$datai."', datafinal='".$dataf."', txServico='".$txServico."',vltot='".$vltot."' WHERE solicitacao='".$solicitacao."' AND seq='".$seq."' AND tipo='".$tipo."'");
	}else{
		$aut=0;
		if(!empty($arrayMaxAut['autatual'])){
        $aut=$arrayMaxAut['autatual'];
		}
		$autorizacao =  $aut + 1;
	$insereDados=mysql_query("INSERT INTO registros (id,idben ,idcia, autorizacao,ano,solicitacao, evento, projeto, datainicial, datafinal, localizador, seq, vlorg, txEmbarque, txServico, vltot, bdpass,tipo) VALUES('','".$idben."','".$idcia."', '".$autorizacao."' ,'".date('Y')."','".$solicitacao."','".$evento."','".$projeto."', '".$datai."', '".$dataf."','".$txLocalizador."','".$seq."','".$vlorg."','".$txEmbarque."','".$txServico."','".$vltot."',0,'".$tipo."')") or die(mysql_error());
		}	
$contadorAt++;
}
$sqlPassagem=mysql_fetch_array(mysql_query("SELECT * FROM registros WHERE autorizacao='".$autorizacao."' AND solicitacao='".$solicitacao."'"));

$anoPas=$sqlPassagem['ano'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../ajax/funcs.js"></script>
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../jqueryDown/jquery-1.9.0-ui.css" /> 
<script language="JavaScript" type="text/javascript"> 
// função usada para carregar o código 
function fecha() { 
// fechando a janela atual ( popup ) 
window.close(); 
// dando um refresh na página principal 
opener.location.href="../index.php"; 
// fim da função 
} 
</script>  
<style media="print">
.botao {
display: none;
}

#table th, td {
	border: 1px solid #000000;
	border-collapse: collapse;
	font-family: "Trebuchet MS", Arial, sans-serif;  
}


#table td, th {
	padding: 4px;
	
}

#table th {
	text-align: center;
	background: #E6EDF5;
	color: #000;
	font-size: 90% !important;
}
#table td{
	font-size: 70%;
}

tbody th {
	font-weight: bold;  
        background: #CFCFCF;
}

#table tbody tr { background: #FCFDFE; }

#table tbody tr.odd { background: #F7F9FC; }

#table table a:link {
	color: #718ABE;
	text-decoration: none;
}

#table table a:visited {
	//color: #718ABE;
        color:#E8E8E8;
	text-decoration: none;
}

#table table a:hover {
	color: #718ABE;
	text-decoration: underline !important;
}

#table tfoot th, tfoot td {
	font-size: 85%; 
}


</style>
<style>
body{
    width:800px;
	
}

</style>
</head>
<body onunload="javascript:fecha()">
<div id="container">
    <div id="content">
            
<div id="notable" class='botao'>
    <table width="100%">
        <tr  valign="bottom"><td width='37'><a href="javascript:fecha()">FECHAR</a></td>
        <td align=right ><div id='link'>           Clique em imprimir, alterando a orientação da página caso julgue necessário.<br><a href='javascript:;'  class='botao' onclick='window.print();return false'><input type='button' class='button' name='enviar' id='enviar' value='IMPRIMIR' /></a></td></tr>
    </table> 
             
  </div>   
    
 <div align="center"><img width="100px" src="../css/Logo_CPB_transparente.png" ></div>                
                
<div id="table">  
    
<table width="100%">
    <th colspan='2'><strong>AUTORIZAÇÃO DE PASSAGENS AÉREAS</strong></th>  
    
    <tr><td><strong>Entidade: </strong>Comitê Paralímpico Brasileiro - CPB</td><td><strong>Fone/Fax: </strong>(61)3031-3030</td></tr>  
    <tr><td colspan='2'><strong>Endereço: </strong>Setor Bancário Norte, Quadra 02, Bloco F - Edifício Via Capital, 14º Andar</td></tr> 
    <tr><td colspan='2'><strong>Email: </strong>contato@cpb.org.br</td></tr> 
</table>   
</div><br>

    
<div id="table">    
<table width="100%">
    <th colspan='2'><strong>INFORMAÇÕES DO EVENTO</strong></th> 
    <tr><td colspan='2'><strong>Nº da Autorização: <?php echo $autorizacao."/".$anoPas; ?></strong></td></tr> 
    <tr><td colspan='2'><strong>Nº da CI: <?php echo $solicitacao; ?></strong></td></tr> 
    <tr><td width="25%"><strong>Número do Processo: </strong><?php echo trim($projeto) ?></td><td width="75%"><?php echo trim($assunto); ?></td></tr>
    <tr>
      <td colspan='2'><strong>Complemento: </strong><?php echo $evento; ?></td></tr> 
    
    <?php  while($objCI=odbc_fetch_object($resconsultaCi)){ ?>
    
    <tr><td colspan='2'><strong>Local: </strong><?php $objCI->local_entrega ?></td></tr> 
    
    <?php } ?>
    
    <tr><td colspan='2'><strong>Período: </strong><?php echo $datainicial; ?> a <?php echo $datafinal; ?></td></tr> 
</table>   
</div><br>
  
<div id="table">  
        
<table  width="100%">
<tr>
<!--  <th colspan="12"><strong>Descri&ccedil;&atilde;o da Solicita&ccedil;&atilde;o <?php echo $solicitacao; ?>:</strong> <?php echo mb_convert_encoding($arrayConsultaCi['Desc_cond_pag'],"UTF-8","ISO-8859-1") ?></th></tr>
 -->
     <tr>
        <th width="20%">Nome</th><th width="8%">Trecho</th><th width="10%">Localizador</th><th width="13%">Valor da Passagem</th><th width="8%">Taxa de Embarque</th><th width="8%">Taxa de Serviço</th><th width="7%">CIA Aerea</th><th width="7%">Desconto</th><th width="13%">Valor Final</th>
    </tr>
    
   <!-- <tr><th width="22%">Nome</th><th width="14%">Trecho</th><th width="10%">Partida</th><th width="10%">Chegada</th><th width="7%">Cadeirante</th><th width="9%">Valor da Passagem</th><th width="10%">CIA Aerea</th><th width="9%">Desconto</th><th width="9%">Valor Final</th></tr>-->
  <?php 
  $totalPassagem=0;
  $totalTxEmb=0;
  $totalTxServ=0;
  $totalDesc=0;
  $totalFinal=0;
  $contadorEx=0;
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
	  //Coloquei um contador zerado ao qual incremento ele aqui
	  $contadorEx++;
	  if(empty($objPassagens->dt_chegada)){
	  $vlOrgNex="vlOrg".$contadorEx;
	  $vlTotNex="vlTot".$contadorEx;
	  $descontoNex="desconto".$contadorEx;
          $txServicoNex="txServico".$contadorEx;
          $txLocalizadorNex="txLocalizador".$contadorEx;
          $txEmbarqueNex="txEmbarque".$contadorEx;
	  $ciaNex="cia".$contadorEx;
	  $selectNameCia=mysql_query("SELECT nome FROM cia WHERE id='".$_POST[$ciaNex]."'");
	  $arrayNameCia=mysql_fetch_array($selectNameCia);
	  echo "<tr><td>".mb_convert_encoding($objPassagens->Nome_completo,"UTF-8","ISO-8859-1")."</td>
                <td>".mb_convert_encoding($objPassagens->trecho,"UTF-8","ISO-8859-1")."</td>
                <td>".$_POST[$txLocalizadorNex]."</td>
                <td>R$ ".$_POST[$vlOrgNex]."</td>
                <td>R$".$_POST[$txEmbarqueNex]."</td>
                <td>R$".$_POST[$txServicoNex]."</td>
                <td>".$arrayNameCia['nome']."</td>
				<td>R$".$_POST[$descontoNex]."</td>
                <td>R$ ".$_POST[$vlTotNex]."</td></tr>";
          $totalPassagem=$totalPassagem + str_replace(',','.',str_replace('.','',$_POST[$vlOrgNex]));
		  $totalTxEmb=$totalTxEmb + str_replace(',','.',str_replace('.','',$_POST[$txEmbarqueNex]));
		  $totalTxServ=$totalTxServ + str_replace(',','.',str_replace('.','',$_POST[$txServicoNex]));
		  $totalDesc=$totalDesc + (float)$_POST[$descontoNex];
		  $totalFinal=$totalFinal + str_replace(',','.',str_replace('.','',$_POST[$vlTotNex]));                    
    }else{
		echo "<tr><td rowspan='2'>".mb_convert_encoding($objPassagens->Nome_completo,"UTF-8","ISO-8859-1")."</td>
                <td rowspan='2'>".mb_convert_encoding($objPassagens->trecho,"UTF-8","ISO-8859-1")."</td>";
	  for($j=0;$j<2;$j++){
	  if($j==0){
			  $tp='IDA';
			  }else{
				  $tp='VOLTA';
				  }
	  $vlOrgNex="vlOrg".$contadorEx;
	  $vlTotNex="vlTot".$contadorEx;
	  $descontoNex="desconto".$contadorEx;
          $txServicoNex="txServico".$contadorEx;
          $txLocalizadorNex="txLocalizador".$contadorEx;
          $txEmbarqueNex="txEmbarque".$contadorEx;
	  $ciaNex="cia".$contadorEx;
	  $selectNameCia=mysql_query("SELECT nome FROM cia WHERE id='".$_POST[$ciaNex]."'");
	  $arrayNameCia=mysql_fetch_array($selectNameCia);
                $trf="";
		  	 if($j==0){
			 	$trf="</tr>";
			 }
				echo "<td>$tp : ".$_POST[$txLocalizadorNex]."</td>
                <td>R$ ".$_POST[$vlOrgNex]."</td>
                <td>R$".$_POST[$txEmbarqueNex]."</td>
                <td>R$".$_POST[$txServicoNex]."</td>
                <td>".$arrayNameCia['nome']."</td>
				<td>R$".$_POST[$descontoNex]."</td>
                <td>R$ ".$_POST[$vlTotNex]."</td>".$trf."";
          $totalPassagem=$totalPassagem + str_replace(',','.',str_replace('.','',$_POST[$vlOrgNex]));
		  $totalTxEmb=$totalTxEmb + str_replace(',','.',str_replace('.','',$_POST[$txEmbarqueNex]));
		  $totalTxServ=$totalTxServ + str_replace(',','.',str_replace('.','',$_POST[$txServicoNex]));
		  $totalDesc=$totalDesc + (float)$_POST[$descontoNex];
		  $totalFinal=$totalFinal + str_replace(',','.',str_replace('.','',$_POST[$vlTotNex]));
          if($j==0){
			  $contadorEx++;
			  }
		  } //FOR
		  echo "</tr>";
  	} //IF
   }//If
  }//While
          echo "<tr><th colspan='3'><center>TOTAL</center></th><th>R$ ".number_format($totalPassagem, 2, ',', '.')."</th><th>R$ ".number_format($totalTxEmb, 2, ',', '.')."</th><th>R$ ".number_format($totalTxServ, 2, ',', '.')."</th><th></th><th>R$".number_format($totalDesc, 2, ',', '.')."</th><th>R$ ".number_format($totalFinal, 2, ',', '.')."</th></tr>";
  ?>
</table>
    <table border="0" width="100%"><tr align="right"><td><strong>ELABORADO POR:</strong> <?php echo trim($_SESSION['userPas']); ?></td></tr></table>
</form>
</div>
 </div>
 </div>
    <BR/><BR/>
</body>
</html>