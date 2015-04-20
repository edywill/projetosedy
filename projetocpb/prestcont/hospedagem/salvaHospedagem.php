<?php 
session_start();
//Recebo as variáveis totais
$solicitacao=$_REQUEST['ci'];
$contadorOriginal=$_REQUEST['contador'];
$contCampos=$_REQUEST['contCampos'];
$proj=explode("-",$_REQUEST['txprojeto']);
$projeto=$proj[0];
$assunto=str_replace($projeto."-",'',$_REQUEST['txprojeto']);
//$autorizacao=$_REQUEST['id'];
$datainicial=$_POST['datainicial'];
$datafinal=$_POST['datafinal'];
$evento=$_POST['evento'];
$tGeral=$_POST['totalG'];
$tServ=$_POST['totServ'];
$tIss=$_POST['totIss'];
$tCont=$_POST['totCont'];
$tGeralF=$_POST['totGFinal'];
//$assunto=$_REQUEST['assunto'];

//Faço a conexão com o banco CIGAM para pegar as informações do cabeçalho
require "../../conectsqlserverci.php";


//Faço a consulta no banco para identificar os dados que preciso da passagem (usuario e etc)
//Escolhi alguns campos que julguei necessário. Mas pode-se escolher outros ou retirar.
//Pode-se também trazer esses dados do formulário por $_POST da página anterior, para evitar essa consulta no banco, lembrando de coloca-los dentro do While que temos abaixo.
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
                    $p_dt = explode('/',$databr);
                    $data_sql = $p_dt[2].'-'.$p_dt[1].'-'.$p_dt[0];
            return $data_sql;}
    }
//---------------------------------//
$dataf=  datasql($datafinal);
$datai= datasql($datainicial);
        

//Faço a conexão com o banco MySQL, para pegar as companhias aéras e descontos
require "../../conexaomysql.php";
$contadorEx=0;
$contadorAt=1;
$selectMaxAutorizacao=  mysql_query("select max(autorizacao) as autatual from registroshos");
        $arrayMaxAut=mysql_fetch_array($selectMaxAutorizacao);
while($contadorAt<=$contCampos){
$seq=$contadorAt;
$idBenN="idBen".$seq;
$idben=$_POST[$idBenN];
$qtdDiasN="qtdDias".$seq;
$qtdDias=$_POST[$qtdDiasN];
$vlDiaN="vlDia".$seq;
$vlDia=$_POST[$vlDiaN];
$vlDia=str_replace(".","",$vlDia);
$vlDia=str_replace(",",".",$vlDia);
$vlTotHN="vlTotH".$seq;
$vlTot=$_POST[$vlTotHN];
$consExiste=mysql_query("SELECT * FROM registroshos WHERE solicitacao='".$solicitacao."' AND seq='".$seq."'");
$contExiste=mysql_num_rows($consExiste);
if($contExiste>0){
	$arrayExiste=mysql_fetch_array($consExiste);
	$autorizacao=$arrayExiste['autorizacao'];
	$atualizaDados=mysql_query("UPDATE registroshos SET autorizacao='".$autorizacao."', evento='".$evento."', tgeral='".$tGeral."',tserv='".$tServ."',tiss='".$tIss."',projeto='".$projeto."', datainicial='".$datai."', datafinal='".$dataf."', tcont='".$tCont."',tgeralf='".$tGeralF."',qtddias='".$qtdDias."',vldia='".$vlDia."',vltot='".$vlTot."' WHERE solicitacao='".$solicitacao."' AND seq='".$seq."'");
	}else{
        $aut=$arrayMaxAut['autatual'];
        $autorizacao =  $aut + 1;
	$insereDados=mysql_query("INSERT INTO registroshos (id,idben , autorizacao, solicitacao, evento, projeto, datainicial, datafinal, seq, qtddias, vldia, vltot, tgeral,tserv,tiss,tcont,tgeralf) VALUES('','".$idben."','".$autorizacao."' ,'".$solicitacao."','".$evento."','".$projeto."', '".$datai."', '".$dataf."','".$seq."','".$qtdDias."','".$vlDia."','".$vlTot."','".$tGeral."','".$tServ."','".$tIss."','".$tCont."','".$tGeralF."')") or die(mysql_error());
		}	
$contadorAt++;
}



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
	border: 1px solid #D4E0EE;
	border-collapse: collapse;
	font-family: "Trebuchet MS", Arial, sans-serif;  
}


#table td, th {
	padding: 4px;
	
}

#table th {
	text-align: center;
	background: #E6EDF5;
	color: #4F76A3;
	font-size: 80% !important;
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
    <th colspan='2'><strong>AUTORIZAÇÃO DE FATURAMENTO DE HOSPEDAGEM</strong></th>  
    
    <tr><td><strong>Entidade: </strong>Comitê Paralímpico Brasileiro - CPB</td><td><strong>Fone/Fax: </strong>(61)3031-3030</td></tr>  
    <tr><td colspan='2'><strong>Endereço: </strong>Setor Bancário Norte, Quadra 02, Bloco F - Edifício Via Capital, 14º Andar</td></tr> 
    <tr><td colspan='2'><strong>Email: </strong>contato@cpb.org.br</td></tr> 
</table>   
</div><br>

    
<div id="table">    
<table width="100%">
    <th colspan='2'><strong>INFORMAÇÕES DO EVENTO</strong></th> 
    <tr><td colspan='2'><strong>Nº da Autorização: <?php echo $autorizacao."/".date("Y"); ?></strong></td></tr> 
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
        <th width="25%">Nome</th><th width="20%">Cargo</th><th width="7%">Apto.</th><th width="11%">Entrada</th><th width="11%">Saída</th><th width="5%">Qtd. Diárias</th><th width="7%">VLR/Dia</th><th width="7%">Total</th></tr>
    </tr>
    
   <!-- <tr><th width="22%">Nome</th><th width="14%">Trecho</th><th width="10%">Partida</th><th width="10%">Chegada</th><th width="7%">Cadeirante</th><th width="9%">Valor da Passagem</th><th width="10%">CIA Aerea</th><th width="9%">Desconto</th><th width="9%">Valor Final</th></tr>-->
  <?php 
  $contadorEx=0;
  $vlTipo=0;
  $contCamposEx=0;
  $numReserva=0;
  while($objPassagens=odbc_fetch_object($resconsultaPas)){
	  //Coloquei um contador zerado ao qual incremento ele aqui
	  $contadorEx++;
          if(!empty($objPassagens->cargo)){
			  $cargoEx=mb_convert_encoding($objPassagens->cargo,"UTF-8","ISO-8859-1");
			  }else{
			  $cargoEx=mb_convert_encoding($objPassagens->cargo2,"UTF-8","ISO-8859-1");
				  }
	  echo "<tr><td>".mb_convert_encoding($objPassagens->Nome_completo,"UTF-8","ISO-8859-1")."</td>
                <td>".$cargoEx."</td>";
                $sqlRl=odbc_exec($conCab,"SELECT reserva FROM TEITEMSOLHOTEL (nolock) WHERE cd_solicitacao='".$solicitacao."' AND reserva='".$objPassagens->reserva."'");
$countRl=odbc_num_rows($sqlRl);
$tipo='';
if($countRl<2){
	$tipo='Single';
	}else{
		$tipo='Duplo';
		}
		if($tipo=='Duplo'){
	$vlTipo++;
	if($objPassagens->reserva<>$numReserva){
		$numReserva=$objPassagens->reserva;
		$contCamposEx++;
		$vlDiaEx="vlDia".$contCamposEx;
	    $qtdDiasEx="qtdDias".$contCamposEx;
	    $vlTotEx="vlTotH".$contCamposEx;
	echo "<td rowspan='2' valign='center'>".$tipo."</td>";
	echo"<td rowspan='2' valign='center'>".date('d/m/y', strtotime($objPassagens->dt_entrada))."</td>
                <td rowspan='2' valign='center'>".date('d/m/y', strtotime($objPassagens->dt_saida))."</td>
                <td rowspan='2' valign='center'>".$_POST[$qtdDiasEx]."</td>
                <td rowspan='2' valign='center'>R$ ".$_POST[$vlDiaEx]."</td>
                <td rowspan='2' valign='center'>R$ ".number_format($_POST[$vlTotEx], 2, ',', '.')."</td>";
	}
	}else{
		$contCamposEx++;
		$vlDiaEx="vlDia".$contCamposEx;
	    $qtdDiasEx="qtdDias".$contCamposEx;
	    $vlTotEx="vlTotH".$contCamposEx;
		echo "<td>".$tipo."</td>";
		echo"<td>".date('d/m/y', strtotime($objPassagens->dt_entrada))."</td>
                <td>".date('d/m/y', strtotime($objPassagens->dt_saida))."</td>
                <td>".$_POST[$qtdDiasEx]."</td>
                <td>R$ ".$_POST[$vlDiaEx]."</td>
                <td>R$ ".number_format($_POST[$vlTotEx], 2, ',', '.')."</td>";
		}
                echo "</tr>";                  
  }//While
          $tGeral=$_POST['totalG'];
$tServ=$_POST['totServ'];
$tIss=$_POST['totIss'];
$tCont=$_POST['totCont'];
$tGeralF=$_POST['totGFinal'];
		  echo "<tr><td colspan='3' rowspan='9'></td><td colspan='2'><strong>Total diárias</strong></td><td>-</td><td colspan='2' align='right'>R$ ".number_format($tGeral, 2, ',', '.')."</td><tr>
      <tr><td colspan='2'><strong>Total taxa de serviço</strong></td><td>".$_POST['totTxServ']."%</td><td colspan='2' align='right'>R$ ".number_format($tServ, 2, ',', '.')."</td><tr>
	  <tr><td colspan='2'><strong>Total taxa de ISS</strong></td><td>".$_POST['totTxIss']."%</td><td colspan='2' align='right'>R$ ".number_format($tIss, 2, ',', '.')."</td><tr>
	  <tr><td colspan='2'><strong>Total contratual</strong></td><td>".$_POST['totTxCont']."%</td><td colspan='2' align='right'>R$ ".number_format($tCont, 2, ',', '.')."</td><tr>
	  <tr><th colspan='2'><strong>Total com taxas</strong></th><th></th><th colspan='2' align='right'>R$ ".number_format($tGeralF, 2, ',', '.')."</th><tr>";
$dia = date('d');
$mes = date('m');
$ano = date('Y');
switch ($mes){ 
case 1: $mes = "JANEIRO"; break;
case 2: $mes = "FEVEREIRO"; break;
case 3: $mes = "MARÇO"; break;
case 4: $mes = "ABRIL"; break;
case 5: $mes = "MAIO"; break;
case 6: $mes = "JUNHO"; break;
case 7: $mes = "JULHO"; break;
case 8: $mes = "AGOSTO"; break;
case 9: $mes = "SETEMBRO"; break;
case 10: $mes = "OUTUBRO"; break;
case 11: $mes = "NOVEMBRO"; break;
case 12: $mes = "DEZEMBRO"; break;
}
  ?>
</table>
    <table border="0" width="100%"><tr align="right"><td><strong>ELABORADO POR:</strong> <?php echo trim($_SESSION['userPas']); ?></td></tr></table>
    <table border="0" width="100%"><tr align="center"><td>BRASÍLIA - DF, <?PHP echo $dia." de ".$mes." de ".$ano; ?></td></tr></table>
</form>
</div>
 </div>
 </div>
    <BR/><BR/>
</body>
</html>