<?php 
include "valida.php";
include "conect.php";
include "conectsqlserverci.php";
$cigam=$_SESSION['cigamMenu'];
//echo $_SESSION['usuario'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />

<title>Untitled Document</title>
</head>

<body>

<div id='box'>
<p><strong>Intranet CPB</strong></p>
<?php 
if(!empty($cigam) || $cigam<>'A02'){
$sqlBoardingGeral=mysql_query("SELECT solicitacao,datafinal,datainicial,idben FROM registros WHERE bdpass=0 AND (datainicial+10)<='".date("Ymd")."'") or die(mysql_error());
		$numBoardingGeral=mysql_num_rows($sqlBoardingGeral);
		$countBdPas=0;
		$matrizTabela='';
		if($numBoardingGeral>0){
		  while($arrayBoardingGeral=mysql_fetch_array($sqlBoardingGeral)){
			if($arrayBoardingGeral['datafinal'] == '' || $arrayBoardingGeral['datafinal']=='0000-00-00' || $arrayBoardingGeral['datafinal']=='1969-12-31'){
	          	$sqlConsCiBdPas=odbc_exec($conCab,"SELECT TEITEMSOLPASSAGEM.Cd_solicitacao,TEITEMSOLPASSAGEM.usu_criacao,GEEMPRES.Nome_completo,TEITEMSOLPASSAGEM.dt_partida FROM TEITEMSOLPASSAGEM (nolock) LEFT JOIN GEEMPRES (nolock) ON TEITEMSOLPASSAGEM.cd_empresa=GEEMPRES.Cd_empresa WHERE TEITEMSOLPASSAGEM.usu_criacao='".$cigam."' AND TEITEMSOLPASSAGEM.Cd_solicitacao='".$arrayBoardingGeral['solicitacao']."' AND TEITEMSOLPASSAGEM.cd_empresa='".$arrayBoardingGeral['idben']."'") or die("<p>".odbc_errormsg());
				while($arrayConsCiBdPas=odbc_fetch_array($sqlConsCiBdPas)){
			  	if(!empty($arrayConsCiBdPas['Usuario_criacao'])){
				  $matrizTabela.="<tr><td>".$arrayConsCiBdPas['Solicitacao']."</td><td>".utf8_encode($arrayConsCiBdPas['Nome_completo'])."</td></tr>";
				  }
				}
				}else{
					$sqlBoardingFGeral=mysql_query("SELECT idben,datafinal,datainicial FROM registros WHERE bdpass=0 AND (datafinal+10)<='".date("Ymd")."'");
				    $numBoardingFGeral=mysql_num_rows($sqlBoardingFGeral);
				   if($numBoardingFGeral>0){
	                   
					   $sqlConsCiBdPas2=odbc_exec($conCab,"SELECT TEITEMSOLPASSAGEM.Cd_solicitacao,TEITEMSOLPASSAGEM.usu_criacao,GEEMPRES.Nome_completo,TEITEMSOLPASSAGEM.dt_partida FROM TEITEMSOLPASSAGEM (nolock) LEFT JOIN GEEMPRES (nolock) ON TEITEMSOLPASSAGEM.cd_empresa=GEEMPRES.Cd_empresa WHERE TEITEMSOLPASSAGEM.usu_criacao='".$cigam."' AND TEITEMSOLPASSAGEM.Cd_solicitacao='".$arrayBoardingGeral['solicitacao']."' AND TEITEMSOLPASSAGEM.cd_empresa='".$arrayBoardingGeral['idben']."'") or die("<p>".odbc_errormsg());
					   while($arrayConsCiBdPas2=odbc_fetch_array($sqlConsCiBdPas2)){
						if(!empty($arrayConsCiBdPas2['Usuario_criacao'])){
				 			  $matrizTabela.="<tr><td>".$arrayConsCiBdPas2['Solicitacao']."</td><td>".utf8_encode($arrayConsCiBdPas2['Nome_completo'])."</td></tr>";
				  		}
					   }
					  }
					}
			    }
			}
if(!empty($matrizTabela)){
?>
<div class="pre-spoiler"><br />
<input id="xs" value="Mostrar Boarding Pass" class="buttonVerde" onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = '';this.innerText = ''; this.value = 'Ocultar Boarding Pass'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.value = 'Mostrar Boarding Pass';}" type="button"> </div><br />
<div>
<div class="spoiler" style="display: none;">
<?php
echo "<div id='tabela'><table border=0 width='100%'>
			<tr><th colspan='2'><strong>BOARDING PASS PENDENTES</strong></th></tr>
			<tr><th><strong>Nº CI</strong></th><th><strong>PASSAGEIRO</strong></th></tr>";
echo $matrizTabela;
echo "</table></div>
</div>
</div>";
 	}
}
?>

<p>Nesse portal você pode:</p>
<ul>
  <li>Imprimir sua folha de frequência para preenchimento</li>
  <li>Imprimir o seu recibo de pagamento (Contra-cheque)</li>
  <li>Solicitar férias </li>
</ul>

</div>
</body>
</html>