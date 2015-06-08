<?php 
session_start();
set_time_limit (0);
$homolog=0;
function converteData($data){
       if (strstr($data, "/")){//verifica se tem a barra /
           $d = explode ("/", $data);//tira a barra
           $rstData = "$d[2]-$d[1]-$d[0]";//separa as datas $d[2] = ano $d[1] = mes etc...
           return $rstData;
       }
       else if(strstr($data, "-")){
          $data = substr($data, 0, 10);
          $d = explode ("-", $data);
          $rstData = "$d[2]/$d[1]/$d[0]";
          return $rstData;
       }
       else{
           return '';
      }
}
$_SESSION['nomeFuncSav']='';
require "../conectsqlserver.php";
require "conectsqlserversav.php";
include "funcoesGerais.php";
include "atualizarFinanceiro.php";
odbc_autocommit($conCab2,FALSE);
require "../conect.php";
include "diasUteis.php";
$valida=0;
$countError=0;
$errorMsg='';
$passagem=0;
$hospedagem=0;
$translado=0;
$userCriac=$_SESSION['userCigamSav'];
$numSav=$_SESSION['numSav'];
$numCi=$_SESSION['numCiSav'];
$ArrayGestor=explode("-",$_SESSION['gestorSav']);
$gestor=$ArrayGestor[0];
$_SESSION['tpSav']=3;
//Compara se existe passagem, hospedagem e translado marcados, 
	if($_SESSION['passagemSav']=='sim' || $_SESSION['diariaSav'] == 'sim' ||$_SESSION['transladoSav']=='sim'){
		include "validacoesItens.php";
		}
//Calcula diárias com base nas referências levando em conta que:
  //Chegada manhã, diária comum
  //Chegada tarde, + meia diária
  //Chegada noite, + 1 diária
  //Caso haja hospedagem marcado, o valor da diária é sempre a metade

$sqlRegistro=mysql_query("SELECT * FROM savregistros WHERE id='".$numSav."'");
$arrayRegistro=mysql_fetch_array($sqlRegistro);
$contarDias=0;
$numDiasDiaria=0;
$numDiasGeral=0;
$diaExtra=0;
$diasUteis=0;
$descontoVR =0;
$sqlRegistro=mysql_query("SELECT * FROM savregistros WHERE id='".$numSav."'");
$arrayRegistro=mysql_fetch_array($sqlRegistro);	
$numDiasGeral=$arrayRegistro['dtvolta']-$arrayRegistro['dtida'];
$diaExtra=0;
if($arrayRegistro['horariovolta']=='tarde'){
	$diaExtra=0.5;
	}elseif($arrayRegistro['horariovolta']=='noite'){
		$diaExtra=1;
		}
 $numDiasGeral=$diaExtra+$numDiasGeral;
 $numDiasDiaria=$numDiasGeral;
 if(!empty($arrayRegistro['dtida'])){
 $diasUteis = DiasUteis($arrayRegistro['dtida'], $arrayRegistro['dtvolta']);
 if($diaExtra==0){
	 $diasUteis=$diasUteis-1;
	 }
   $descontoVR = $diasUteis*28.5;
 }
 $valorDia=0;
 $sqlClasse=mysql_query("SELECT classe FROM savcargos WHERE id='".$_SESSION['idCargo']."'");
 $arrayClasse=mysql_fetch_array($sqlClasse);
 //Atualiza Dados do Registro
 //Verifica se no registro possui dados de ida e volta, senão, busca nas passagens, hospedagens e locação de veículo a informação, para atualizar. Caso não haja, ou seja apenas ida, marca a volta com a mesma data
  
include "processamentoSav.php";

if($valida==1){
		?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="complementaSav.php";
       </script>
       <?php
odbc_rollback($conCab2);
$_SESSION['numCiSav']='';
		}else{
if(odbc_commit($conCab2)){
	
	$updateCiSav=mysql_query("UPDATE savregistros SET numci=".(int)$_SESSION['numCiSav']." where id='".$numSav."'");
	$funcionario='X';
	$dirigente='';
	$sqlSavImpressao=mysql_fetch_array(mysql_query("SELECT * FROM savregistros WHERE id='".$numSav."'"));
	$sqlSuperIntendente=mysql_query("SELECT nome,dtalt FROM savdirex WHERE tipo=1");
	$superintendente='';
	while($objValorSuper=mysql_fetch_object($sqlSuperIntendente)){
	$arrayVigencia=explode("/",$objValorSuper->dtalt);
	$arrayDtIda=explode("/",$sqlSavImpressao['dtida']);
	if(strtotime($arrayDtIda[2]."-".$arrayDtIda[1]."-".$arrayDtIda[0]) >= strtotime($arrayVigencia[2]."-".$arrayVigencia[1]."-".$arrayVigencia[0])){
		$superintendente=utf8_encode($objValorSuper->nome);
	  }
	}
	$sqlFunc="Select
  RHPESSOAS.NOME,
  RHPESSOAS.PESSOA,
  RHSETORES.DESCRICAO40 As SETORCOMPLETO,
  RHSETORES.DESCRICAO20 As SETORSIGLA,
  RHCARGOS.CARGO,
  RHCARGOS.DESCRICAO20 As NOMECARGO,
  RHPESSOAS.CPF,
  RHCONTRATOS.BANCOCREDOR,
  RHBANCOS.DESCRICAO40 As NOMEBANCO,
  RHBANCOS.AGENCIA,
  RHBANCOS.NROBANCO,
  RHCONTRATOS.CONTACORRENTE
From
  RHPESSOAS (nolock) Inner Join
  RHCONTRATOS (nolock) On RHCONTRATOS.PESSOA = RHPESSOAS.PESSOA Inner Join
  RHESCALAS (nolock) On RHCONTRATOS.ESCALA = RHESCALAS.ESCALA Inner Join
  RHSETORES (nolock) On RHCONTRATOS.SETOR = RHSETORES.SETOR Inner Join
  RHCARGOS (nolock) On RHCONTRATOS.CARGO = RHCARGOS.CARGO Inner Join
  RHBANCOS (nolock) On RHCONTRATOS.BANCOCREDOR = RHBANCOS.BANCO
Where
  RHCONTRATOS.DATARESCISAO Is Null AND RHPESSOAS.PESSOA='".$sqlSavImpressao['funcionario']."'";
  $dadosFuncionario=odbc_fetch_array(odbc_exec($conCab,$sqlFunc));
  //Consulta Tabela de Cargos da SAV e verifica se o cargo em questão pertence a classe I ou II
  $consultaClasse=mysql_fetch_array(mysql_query("SELECT classe FROM savcargos WHERE id='".$dadosFuncionario['CARGO']."'"));
  if($consultaClasse['classe']<3){
	  $funcionario='';
	  $dirigente='X';
	}
if($_SESSION['diariaSolSav']=='sim'){
//Inserir dados de diária
$selectDadosDiaria=mysql_fetch_array(mysql_query("SELECT id FROM savdiarias WHERE idsav='".$numSav."'"));
if(empty($selectDadosDiaria['id'])){
$insereDadosDiaria=mysql_query("INSERT INTO savdiarias (idsav,qtddias,valortotal) VALUES ('".$numSav."','".$numDiasDiaria."','".$valorTotal."')");
}else{
	$insereDadosDiaria=mysql_query("UPDATE savdiarias SET qtddias='".$numDiasDiaria."',valortotal='".$valorTotal."' WHERE id='".$selectDadosDiaria['id']."'");
	}
}
	  $_SESSION['nomeFuncSav']=$dadosFuncionario['NOME'];
	  $_SESSION['idCargo']=$dadosFuncionario['CARGO'];
  	  $_SESSION['cpfSav']=mask($dadosFuncionario['CPF'],"###.###.###-##");
	  $_SESSION['setorSav']=$dadosFuncionario['SETORCOMPLETO']."/".$dadosFuncionario['SETORSIGLA'];
	  $_SESSION['cargoSav']=$dadosFuncionario['NOMECARGO'];
	  $_SESSION['bancoSav']=$dadosFuncionario['NROBANCO']."-".$dadosFuncionario['NOMEBANCO'];
	  $_SESSION['agenciaSav']=$dadosFuncionario['AGENCIA'];
	  $_SESSION['contCorrenteSav']=$dadosFuncionario['CONTACORRENTE'];
?>
<!-- Criar página da SAV para impressão -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../ajax/funcs.js"></script>
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../jqueryDown/jquery-1.9.0-ui.css" /> 
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
<script type="text/javascript">
  function mostra(){
	  if(window.onload){
		  document.getElementById('lendo').style.display="none"
		  document.getElementById('conteudo').style.visibility="visible"
		  }
	  }
	  window.onload=mostra
  </script>
  <style>
  .invisivel { display: none; }
  .visivel { visibility: visible; }
  </style>
  <style type="text/css">
  .imgpos{
	  position:absolute;
	  left:50%;
	  top:50%;
	  margin-left:-110px;
	  margin-top:-60px;
	  width:200px;
	  height:200px;
	  z-index:2;
	  }
  </style>
</head>
<body>
<div id="container" style="padding-left:30px">
    <div id='lendo' style="padding-top:60px; padding-left:10px">
<h1 id="h1">Carregando dados...</h1>
<img src="../datatables/ajax-loader.gif" alt="preload" border="0" />
</div>
<br />
<div id='conteudo' style='visibility:hidden'>
    <div id="content">
            
<div id="notable" class='botao'>
    <table width="100%">
        <tr  valign="bottom"><td width='37'><a href="complementaSav.php"><input type="button" class="button" value="<<Voltar"></a></td>
        <td align=right ><a href='geraPdfSav.php' target="_blank"><input type='button' class='button' name='enviar' id='enviar' value='IMPRESSÃO (PDF)' /></a></td></tr>
                   <tr><td colspan="2" align="center"><font size="+2"><strong>CI Nº: </strong><?php echo $_SESSION['numCiSav']; ?></font></td></tr>
    </table> 
             
  </div>   
<p align="center" style="font-size:16px"><strong>ANEXO I</strong><br />
  <strong>COMITÊ PARALÍMPICO  BRASILEIRO</strong></p>
<table border="1" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td valign="top" align="center" bgcolor="#CCCCCC"><p align="center"><strong>SOLICITAÇÃO DE VIAGENS E PASSAGENS</strong><br />
      <strong>( <?php echo $dirigente; ?>)  DIRIGENTE                    ( <?php echo $funcionario; ?>)  FUNCIONÁRIO</strong></p></td>
  </tr>
</table>
<br />
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td valign="top" bgcolor="#000066"><strong><font color="#FFFFFF">I - DADOS DO PROPONENTE:</font></strong></td>
  </tr>
</table>
<br />
<strong>Nome:</strong> <?php echo $superintendente; ?><strong>                               </strong><br />
  <strong>Cargo: </strong>SUPERINTENDENTE<br /><br />
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td width="654" valign="top" bgcolor="#000066"><strong><font color="#FFFFFF">II - DADOS DO VIAJANTE:</font></strong></td>
  </tr>
</table>
<br />
<strong>Nome:</strong> <?php echo utf8_encode($_SESSION['nomeFuncSav']); ?> <br />
  <strong>CPF: </strong><?php echo $_SESSION['cpfSav']; ?><br />
  <strong>Cargo: </strong><?php echo utf8_encode($_SESSION['cargoSav']); ?><strong></strong><br />
  <strong>Banco: </strong><?php echo utf8_encode($_SESSION['bancoSav']); ?><br />
  <strong>Agência: </strong><?php echo $_SESSION['agenciaSav']; ?><strong> </strong><br />
  <strong>Conta Corrente: </strong><?php echo $_SESSION['contCorrenteSav']; ?><br /><br />
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td width="654" valign="top" bgcolor="#000066"><strong><font color="#FFFFFF">III – OBJETIVO DA VIAGEM: </font> </strong></td>
  </tr>
</table>
<br />
<?php echo utf8_encode($sqlSavImpressao['objetivo']); ?> <br /><br />

<table border="0" cellspacing="0" cellpadding="0" width="100%" >
  <tr>
    <td valign="top" bgcolor="#000066"><strong><font color="#FFFFFF">IV – DESLOCAMENTO:  </font></strong></td>
  </tr>
</table>
  <?PHP 
  if($_SESSION['passagemSav']=='sim'){
  ?>
  <table border="1" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    <td valign="top" align="center"></td>
    <th valign="top" align="center"><strong>Data</strong></th>
    <th valign="top" align="center"><strong>Trecho</strong></th>
    <th valign="top" align="center"><strong>Horário</strong></th>
  </tr>
  <?php 
  $sqlPassagemImp=mysql_query("SELECT * FROM savpassagem WHERE idsav='".$numSav."'");
  $countPassagemImp=mysql_num_rows($sqlPassagemImp);
  $countPassagemImpContador=0;
  while($objPassagemImp=mysql_fetch_object($sqlPassagemImp)){ 
	  if($objPassagemImp->inter<>'itn'){
				  $sqlTrechoNacImpIda=mysql_fetch_array(mysql_query("SELECT municipio,uf FROM municipios WHERE id='".$objPassagemImp->origem."'"));
				  $sqlTrechoNacImpVolta=mysql_fetch_array(mysql_query("SELECT municipio,uf FROM municipios WHERE id='".$objPassagemImp->destino."'"));
				  $idaImpressao=$sqlTrechoNacImpIda['municipio']."(".$sqlTrechoNacImpIda['uf'].")";
				  $voltaImpressao=$sqlTrechoNacImpVolta['municipio']."(".$sqlTrechoNacImpVolta['uf'].")";
				  }else{
					  $idaImpressao=$objPassagemImp->cidorigem."(".$objPassagemImp->origem.")";
				  	  $voltaImpressao=$objPassagemImp->ciddestino."(".$objPassagemImp->destino.")";
					  }
		$horarioViagem='';
		
	  $countPassagemImpContador++;
	  if($objPassagemImp->tipo==1){
		  if($objPassagemImp->horarioida=='manha'){
			  $horarioViagem='Manhã (4h-12h)';
			  }elseif($objPassagemImp->horarioida=='tarde'){
			  			$horarioViagem='Tarde (12h01-18h)';
			  }elseif($objPassagemImp->horarioida=='noite'){
			  			$horarioViagem='Noite (18h01-3h59)';
			  }
		  
		  if($countPassagemImpContador<$countPassagemImp || ($countPassagemImp==1 && $objPassagemImp->tipo==1)){
		  echo " <tr>
    			<td ><strong>IDA</strong></td>
    			<td align='center'>".$objPassagemImp->dtida."</td>
    			<td align='center'>".utf8_encode($idaImpressao)." x ".utf8_encode($voltaImpressao)."</td>
    			<td align='center'>".$horarioViagem."</td>
  				</tr>";
		  }else{
			echo " <tr>
    			<td ><strong>VOLTA</strong></td>
    			<td align='center'>".$objPassagemImp->dtida."</td>
    			<td align='center'>".utf8_encode($idaImpressao)." x ".utf8_encode($voltaImpressao)."</td>
    			<td align='center'>".$horarioViagem."</td>
  				</tr>";
			}
	 	}else{
			for($i=0;$i<=1;$i++){
			   if($i==0){
			   if($objPassagemImp->horarioida=='manha'){
			  $horarioViagem='Manhã (4h-12h)';
			  }elseif($objPassagemImp->horarioida=='tarde'){
			  			$horarioViagem='Tarde (12h01-18h)';
			  }elseif($objPassagemImp->horarioida=='noite'){
			  			$horarioViagem='Noite (18h01-3h59)';
			  }
			   echo " <tr>
    			<td ><strong>IDA</strong></td>
    			<td align='center'>".$objPassagemImp->dtida."</td>
    			<td align='center'>".utf8_encode($idaImpressao)." x ".utf8_encode($voltaImpressao)."</td>
    			<td align='center'>".$horarioViagem."</td>
  				</tr>";
			   }else{
				  if($objPassagemImp->horariovolta=='manha'){
			  $horarioViagem='Manhã (4h-12h)';
			  }elseif($objPassagemImp->horariovolta=='tarde'){
			  			$horarioViagem='Tarde (12h01-18h)';
			  }elseif($objPassagemImp->horariovolta=='noite'){
			  			$horarioViagem='Noite (18h01-3h59)';
			  }
				  echo " <tr>
    			<td ><strong>VOLTA</strong></td>
    			<td align='center'>".$objPassagemImp->dtvolta."</td>
    			<td align='center'>".utf8_encode($voltaImpressao)." x ".utf8_encode($idaImpressao)."</td>
    			<td align='center'>".$horarioViagem."</td>
  				</tr>";
				   }
			   }
			}
	  }
  echo "</table>";
  }else{
	  echo "<h3 class='h3'>SEM DESLOCAMENTO</h3>";
	  }
  ?>

<br />
<table border="0" cellspacing="0" cellpadding="0" width="100%" >
  <tr>
    <td valign="top" bgcolor="#000066"><strong><font color="#FFFFFF">V – DADOS COMPLEMENTARES:</font></strong></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%" >
<tr>
<td width="20%"><strong>Última Viagem realizada:</strong></td><td><?php echo utf8_encode($sqlSavImpressao['ultimaviagem']); ?></td></tr>
<tr><td> <strong>Devolveu Bilhete:</strong> </td>
<td>
<?php 
if($sqlSavImpressao['devbilhete']=='sim'){
	echo "(X) Sim                ( ) Não";
	}else{
		echo "( ) Sim                (X) Não";
		}
?>
</td></tr>
 <tr><td> <strong>Passagens:</strong>                 </td>
 <td>
 <?php 
if($sqlSavImpressao['passagem']=='sim'){
	echo "(X) Sim                ( ) Não";
	}else{
		echo "( ) Sim                (X) Não";
		}
?>
 </td></tr>
 <tr><td> <strong>Diárias com hospedagem:</strong>             </td>
 <td><?php 
if($sqlSavImpressao['hospedagem']=='sim'){
	echo "(X) Sim                ( ) Não";
	}else{
		echo "( ) Sim                (X) Não";
		}
?></td></tr>
 <tr><td> <strong>Translado Intermunicipal:</strong>            </td>
 <td>
 <?php 
if($sqlSavImpressao['translado']=='sim'){
	echo "(X) Sim                ( ) Não";
	}else{
		echo "( ) Sim                (X) Não";
		}
?>
 </td></tr>
 </table>
 <div id='footer'>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td width="100%" valign="top" bgcolor="#000066"><strong><font color="#FFFFFF">VI - OBSERVAÇÕES:</font></strong></td>
  </tr>
</table>
<br />
<?php 
echo utf8_encode($sqlSavImpressao['observ']);
?>
<br /></div>
 </div>
 </div>
 </div>
    <BR/><BR/>
</body>
</html>		
<?php
}else{
	?>
       <script type="text/javascript">
       alert("Erro ao inserir o registro. Tente novamente.");
       window.location="complementaSav.php";
       </script>
       <?php
				   }
			}
?>