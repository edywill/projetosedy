<?php 
session_start();
//Recebo as variáveis totais
$contadorOriginal=$_POST['contador'];
$proj=explode("-",$_POST['txprojeto']);
$projeto=$proj[0];
$assunto=str_replace($projeto."-",'',$_POST['txprojeto']);
$evento=$_POST['evento'];

//Faço a conexão com o banco CIGAM para pegar as informações do cabeçalho
require "../../conectsqlserverciprod.php";

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
$idCi="ci".$seq;
$solicitacao=$_POST[$idCi];
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
if($_SESSION['tipoAcaoSession']=='atualizar'){
	
	$atualizaDados=mysql_query("UPDATE registros SET autorizacao='".$autorizacao."', evento='".$evento."', idcia='".$idcia."',vlorg='".$vlorg."',txEmbarque='".$txEmbarque."',localizador='".$txLocalizador."',projeto='".$projeto."', datainicial='".$datai."', datafinal='".$dataf."', txServico='".$txServico."',vltot='".$vltot."' WHERE gerencial='".$_SESSION['gerenSession']."' AND idben='".$idben."' AND tipo='".$_SESSION['tipoSession']."'");
	}else{
		$aut=0;
		if(!empty($arrayMaxAut['autatual'])){
        $aut=$arrayMaxAut['autatual'];
		}
		$autorizacao =  $aut + 1;
	$insereDados=mysql_query("INSERT INTO registros (id,idben ,idcia, autorizacao,ano,solicitacao, evento, projeto, datainicial, datafinal, localizador, seq, vlorg, txEmbarque, txServico, vltot, bdpass,tipo,gerencial) VALUES('','".$idben."','".$idcia."', '".$autorizacao."' ,'".date('Y')."','".$solicitacao."','".$evento."','".$projeto."', '".$datai."', '".$dataf."','".$txLocalizador."','".$seq."','".$vlorg."','".$txEmbarque."','".$txServico."','".$vltot."',0,'".$_SESSION['tipoSession']."','".$_SESSION['gerenSession']."')") or die(mysql_error());
		}	
$contadorAt++;
}

$sqlInfoEvento=mysql_fetch_array(mysql_query("SELECT * FROM registros WHERE autorizacao='".$autorizacao."' AND gerencial='".$_SESSION['gerenSession']."' LIMIT 1 "));
$descGerencial='';
$assunto='';
$sqlNomeGerencial=odbc_fetch_array(odbc_exec($conCab,"select cg.Pcc_nome_conta
from CCPCC cg (nolock)
where substring(cg.livre_alfa_18,1,1) <> 'N'
and cg.pcc_tipo = 'A'
and cg.pcc_classific_c between dbo.CGFC_BUSCA_CONFIGURACAO(35,null) and dbo.CGFC_BUSCA_CONFIGURACAO(36,null)
AND cg.Pcc_classific_c='".$_SESSION['gerenSession']."'"));
$descGerencial=utf8_encode($sqlNomeGerencial['Pcc_nome_conta']);
$descProcesso=odbc_fetch_array(odbc_exec($conCab,"select projeto, assunto
from GMPROCDOC (nolock) 
where projeto='".trim($sqlInfoEvento['projeto'])."'"));
$assunto=utf8_encode($descProcesso['assunto']);
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
    <tr><td colspan='2'><strong>Nº da Autorização: <?php echo $sqlInfoEvento['autorizacao']."/".$sqlInfoEvento['ano']; ?></strong></td></tr> 
    <tr><td colspan='2'><strong>Gerencial: <?php echo $sqlInfoEvento['gerencial']."-".$descGerencial; ?></strong></td></tr> 
    <tr><td width="25%"><strong>Número do Processo: </strong><?php echo trim($sqlInfoEvento['projeto']) ?></td><td width="75%"><?php echo trim($assunto); ?></td></tr>
    <tr>
      <td colspan='2'><strong>Complemento: </strong><?php echo utf8_encode($sqlInfoEvento['evento']); ?></td></tr>    
    </table>   
</div><br>
  
<div id="table">  
        
<table  width="100%">
<tr>
  <tr>
        <th width="20%">Nome</th><th width="8%">Trecho</th><th width="10%">Localizador</th><th width="13%">Valor da Passagem</th><th width="8%">Taxa de Embarque</th><th width="8%">Taxa de Serviço</th><th width="7%">CIA Aerea</th><th width="7%">Desconto</th><th width="13%">Valor Final</th>
    </tr>   
  <?php
  
  $sqlRegistros=mysql_query("SELECT * FROM registros WHERE autorizacao='".$autorizacao."' AND gerencial='".$_SESSION['gerenSession']."' ORDER BY idben");
   $totalPassagem=0;
		  $totalTxEmb=0;
		  $totalTxServ=0;
		  $totalDesc=0;
		  $totalFinal=0;
		  $idBenef=0;
  while($objPassagens=mysql_fetch_object($sqlRegistros)){
	  if($idBenef<>$objPassagens->idben){
	  //Coloquei um contador zerado ao qual incremento ele aqui
	  $sqlCoisolicDados=odbc_fetch_array(odbc_exec($conCab,"SELECT GEEMPRES.Nome_completo,TEITEMSOLPASSAGEM.trecho FROM TEITEMSOLPASSAGEM (nolock) LEFT JOIN GEEMPRES (nolock) ON GEEMPRES.Cd_empresa=TEITEMSOLPASSAGEM.Cd_empresa
	  WHERE TEITEMSOLPASSAGEM.Cd_empresa='".$objPassagens->idben."' AND TEITEMSOLPASSAGEM.Cd_solicitacao='".$objPassagens->solicitacao."'"));
	  $contadorEx++;
	  $nomeBenef=utf8_encode($sqlCoisolicDados['Nome_completo']);
	  $trecho=utf8_encode($sqlCoisolicDados['trecho']);  
	  if(empty($objPassagens->datafinal) || $objPassagens->datafinal=='0000-00-00'){
	  $valorOriginal=$objPassagens->vlorg;
	  $txEmbarqueImp=$objPassagens->txEmbarque;
	  $txServImp=$objPassagens->txServico;
	  $valTotalImp=$objPassagens->vltot;
	  $descontoImp=($valorOriginal+$txEmbarqueImp+$txServImp)-$valTotalImp;
	  
	  $selectNameCia=mysql_query("SELECT nome FROM cia WHERE id='".$objPassagens->idcia."'");
	  $arrayNameCia=mysql_fetch_array($selectNameCia);
	  echo "<tr><td>".$nomeBenef."</td>
                <td>".$trecho."</td>
                <td>".$objPassagens->localizador."</td>
                <td>R$ ".number_format($valorOriginal,2,",",".")."</td>
                <td>R$".number_format($txEmbarqueImp,2,",",".")."</td>
                <td>R$".number_format($txServImp,2,",",".")."</td>
                <td>".$arrayNameCia['nome']."</td>
				<td>R$".number_format($descontoImp,2,",",".")."</td>
                <td>R$ ".number_format($valTotalImp,2,",",".")."</td></tr>";
          $totalPassagem=$totalPassagem + $valorOriginal;
		  $totalTxEmb=$totalTxEmb + $txEmbarqueImp;
		  $totalTxServ=$totalTxServ + $txServImp;
		  $totalDesc=$totalDesc + (float)$descontoImp;
		  $totalFinal=$totalFinal + $valTotalImp;                    
    }else{
		echo "<tr><td rowspan='2'>".$nomeBenef."</td>
                <td rowspan='2'>".$trecho."</td>";
	  for($j=0;$j<2;$j++){
	  if($j==0){
			  $tp='IDA';
			  }else{
				  $tp='VOLTA';
				  }
	  $valorOriginal=$objPassagens->vlorg;
	  $txEmbarqueImp=$objPassagens->txEmbarque;
	  $txServImp=$objPassagens->txServico;
	  $valTotalImp=$objPassagens->vltot;
	  $descontoImp=($valorOriginal+$txEmbarqueImp+$txServImp)-$valTotalImp;
	  
	  $selectNameCia=mysql_query("SELECT nome FROM cia WHERE id='".$objPassagens->idcia."'");
	  $arrayNameCia=mysql_fetch_array($selectNameCia);
                $trf="";
		  	 if($j==0){
			 	$trf="</tr>";
			 }
				echo "<td>$tp : ".$objPassagens->localizador."</td>
                <td>R$ ".number_format($valorOriginal,2,",",".")."</td>
                <td>R$".number_format($txEmbarqueImp,2,",",".")."</td>
                <td>R$".number_format($txServImp,2,",",".")."</td>
                <td>".$arrayNameCia['nome']."</td>
				<td>R$".number_format($descontoImp,2,",",".")."</td>
                <td>R$ ".number_format($valTotalImp,2,",",".")."</td></tr>";
          $totalPassagem=$totalPassagem + $valorOriginal;
		  $totalTxEmb=$totalTxEmb + $txEmbarqueImp;
		  $totalTxServ=$totalTxServ + $txServImp;
		  $totalDesc=$totalDesc + (float)$descontoImp;
		  $totalFinal=$totalFinal + $valTotalImp;
          if($j==0){
			  $contadorEx++;
			  }
		  } //FOR
		  echo "</tr>";
  	} //IF
	}
	$idBenef=$objPassagens->idben;
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