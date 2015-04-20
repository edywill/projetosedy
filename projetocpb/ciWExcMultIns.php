<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
	<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="jqueryDown/jquery-1.8.2.js"></script> 
<script src="jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="jqueryDown/jquery-1.9.0-ui.css" /> 
	<script type="text/javascript" src="tabelamulti/script.js"></script>
 <script type="text/javascript" src="ajax/funcs.js"></script>
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
<body onLoad="prettyPrint();">
<div id='box3'>
<br/><strong>CIWEB  - Selecionar Benefici&aacute;rios:</strong><br/><br/>
<div id="lendo">
Carregando dados...
<img src="datatables/ajax-loader.gif" alt="preload" border="0" />
</div>
<div id="conteudo" style="visibility:hidden">
<?php
//include "mb.php";
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

require "conectsqlserverci.php";
require('conexaomysql.php');
$rpa=0;
$diaria=0;
$passagem=0;
$hotel=0;
$inicioRPA='';
$fimRPA='';
$valorRpa='';
$inicioDia='';
$fimDia='';
$valorDia='';
$inicioPas='';
$horaPtPas='';
$minutoPtPas='';
$fimPas='';
$horaRetPas='';
$minutoRetPas='';
$valorPas='';
$trechoPas='';
$obsPas='';
$rlHot='';
$inicioHot='';
$fimHot='';
$retornar='ciWExcMult.php';
$tipo=trim($_POST['tipo']);
if($_POST['tipo']=='rpa'){
	$rpa=1;
	    //$inicioRPA=converteData($_POST['inicioRpa']);
		$inicioRPA=$_POST['inicioRpa'];
		$inicioRPA=str_replace("'","\"",$inicioRPA);
		if(empty($inicioRPA)){
					?>
       <script type="text/javascript">
       alert("Necessario selecionar a data de inicio.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
			}
		//$fimRPA=converteData($_POST['fimRpa']);
		$fimRPA=$_POST['fimRpa'];
		$fimRPA=str_replace("'","\"",$fimRPA);
		if(empty($fimRPA)){
					?>
       <script type="text/javascript">
       alert("Necessario selecionar a data final.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
			}
			if($fimRPA<$inicioRPA){
					?>
       <script type="text/javascript">
       alert("A data final deve ser superior a final!");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
			}
		$valorRpa=str_replace(".","",$_POST['valorRpa']);
		$valorRpa=str_replace(",",".",$valorRpa);
		$valorRpa=(float)$valorRpa;
		$valorRpa=str_replace("'","\"",$valorRpa);
		if(empty($valorRpa)){
					?>
       <script type="text/javascript">
       alert("O valor e campo obrigatorio.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
			}

	}elseif($_POST['tipo']=='diaria'){
		$diaria=1;
		//$inicioDia=converteData($_POST['inicioDia']);
		$inicioDia=$_POST['inicioDia'];
		$inicioDia=str_replace("'","\"",$inicioDia);
		if(empty($inicioDia)){
					?>
       <script type="text/javascript">
       alert("Necessario selecionar a data de inicio.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
			}
		//$fimDia=converteData($_POST['fimDia']);
		$fimDia=$_POST['fimDia'];
		$fimDia=str_replace("'","\"",$fimDia);
		if(empty($fimDia)){
					?>
       <script type="text/javascript">
       alert("Necessario selecionar a data final.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
			}
			if($fimDia<$inicioDia){
					?>
       <script type="text/javascript">
       alert("A data final deve ser superior a final!");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
			}
		$valorDia=str_replace(".","",$_POST['valorDia']);
		$valorDia=str_replace(",",".",$valorDia);
		$valorDia=(float)$valorDia;
		    if(empty($valorDia)){
					?>
       <script type="text/javascript">
       alert("O valor e campo obrigatorio.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
			}
		}elseif($_POST['tipo']=='passagem'){
			$passagem=1;
			//$inicioPas=converteData($_POST['inicioPas']);
		    $inicioPas=$_POST['inicioPas'];
		$inicioPas=str_replace("'","\"",$inicioPas);
//Inicio da validação do campo Inicio (data)
		if(empty($inicioPas)){
					?>
       <script type="text/javascript">
       alert("Necessario selecionar a data de Partida.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
			}
		//Fechou
		
        $horaPtPas=$_POST['horaPtPas'];
		$horaPtPas=str_replace("'","\"",$horaPtPas);
		//Abriu
		if(empty($horaPtPas)){
					?>
       <script type="text/javascript">
       alert("Necessario Informar horario de partida.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
			}elseif($_POST['horaPtPas']>23){
			?>
       <script type="text/javascript">
       alert("A hora nao deve ser superior a 23.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;	
			}else{
				
	      $minutoPtPas=$_POST['minutoPtPas'];
		  $minutoPtPas=str_replace("'","\"",$minutoPtPas);
	      
		  if(empty($minutoPtPas)){
					?>
       <script type="text/javascript">
       alert("Favor preencher o campo referente aos minutos.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
		  }elseif($minutoPtPas>59){
			?>
     			  <script type="text/javascript">
       			alert("Os minutos nao devem ser superiores a 59.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;	
			}else{
				
				$horaPtPas=$_POST['horaPtPas'].$minutoPtPas."00";
				$horaPtPas=str_replace("'","\"",$horaPtPas);
				}}
		
		//Ok
		
		$horaRetPas='';
				if(!empty($_POST['horaRetPas'])){
				   if($_POST['horaRetPas']>23){
			?>
       <script type="text/javascript">
       alert("A hora nao deve ser superior a 23.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;	
			}else{
				$minutoRetPas=$_POST['minutoRetPas'];
				$minutoRetPas=str_replace("'","\"",$minutoRetPas);
				
				if(empty($minutoRetPas)){
					?>
       <script type="text/javascript">
       alert("Favor preencher o campo referente aos minutos.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
				}elseif($_POST['minutoRetPas']>59){
			?>
     			  <script type="text/javascript">
       			alert("Os minutos nao devem ser superiores a 59.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;	
			}else{
				   $horaRetPas=$_POST['horaRetPas'].$_POST['minutoRetPas']."00";		 
				   $horaRetPas=str_replace("'","\"",$horaRetPas);
				 }
			
			   }
 
				  				
			 }//Primeiro
		

//ok
		
		if(!empty($_POST['fimPas'])){
		
		$fimPas=$_POST['fimPas'];
		$fimPas=str_replace("'","\"",$fimPas);
		//$fimPas=converteData($fimPas);
		$fimPas=$fimPas;
		
		if(empty($_POST['horaRetPas']) || empty($_POST['minutoRetPas'])){
					?>
       <script type="text/javascript">
       alert("Necessario preencher o horario da volta, quando informar data de retorno.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
			}elseif($_POST['fimPas']==$_POST['inicioPas']){
				if($horaRetPas<$horaPtPas){
					?>
       <script type="text/javascript">
       alert("O horario de ida nao pode ser superior ao da volta, em viagens no mesmo dia!");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
			}
		 }elseif($_POST['fimPas']<$_POST['inicioPas']){
					?>
       <script type="text/javascript">
       alert("A data final deve ser superior a final!");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
			}
		
				}else{
			$fimPas="null";
		    }
        $valorPas=str_replace(".","",$_POST['valorPas']);
		$valorPas=str_replace(",",".",$valorPas);
		$valorPas=(float)$valorPas;
		$valorPas=str_replace("'","\"",$valorPas);
		$trechoPas=$_POST['trechoPas'];
		$trechoPas=str_replace("'","\"",$trechoPas);
		$obsPas=$_POST['obsPas'];
		$obsPas=str_replace("'","\"",$obsPas);
		    if(empty($valorPas)){
					?>
       <script type="text/javascript">
       alert("O valor e campo obrigatorio.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
			}
			}elseif($_POST['tipo']=='hotel'){
				$hotel=1;
				$inicioHot=$_POST['inicioHot'];
		//$inicioHot=converteData($_POST['inicioHot']);
		$inicioHot=str_replace("'","\"",$inicioHot);
		if(empty($inicioHot)){
					?>
       <script type="text/javascript">
       alert("Necessario selecionar a data de inicio.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
			}
		$fimHot=$_POST['fimHot'];
		//$fimHot=converteData($_POST['fimHot']);
		$fimHot=str_replace("'","\"",$fimHot);
		if(empty($fimHot)){
					?>
       <script type="text/javascript">
       alert("Necessario selecionar a data final.");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
	   }
	   if($fimHot<$inicioHot){
					?>
       <script type="text/javascript">
       alert("A data final deve ser superior a final!");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	   break;
			}
		$rlHot=$_POST['rlHot'];
		$rlHot=str_replace("'","\"",$rlHot);
				}else{
							?>
       <script type="text/javascript">
       alert("Escolha um tipo!");
       window.location="ciWExcMult.php";
       </script>
       <?php
	   break;
					}
echo " CI n&ordm;: ".$_POST['solicitacao']."<br>
	  Item: ".$_POST['sequencia']."<br>";
			echo "      <form action='ciWExcMultAt.php' method='post' name='mult' style='margin:20px'>
	  <input class='input' name='retorno' id='retorno' type='hidden' size='8' value='".$_POST['retorno']."'  />
	  <input class='input' name='sequencia' id='sequencia' type='hidden' size='8' value='".$_POST['sequencia']."'  />
	  <input class='input' name='solicitacao' id='solicitacao' type='hidden' size='8' value='".$_POST['solicitacao']."'  />
	  <input class='input' name='usuario' id='usuario' type='hidden' size='8' value='".$_POST['usuario']."'  />
   		<input name='inicioRpa' type='hidden' value='".$inicioRPA."'/>
		<input name='fimRpa' type='hidden' value='".$fimRPA."'/>
		<input name='valorRpa' type='hidden' value='".$valorRpa."'/>
		<input name='inicioDia' type='hidden' value='".$inicioDia."'/>
		<input name='fimDia' type='hidden' value='".$fimDia."'/>
		<input name='valorDia' type='hidden' value='".$valorDia."'/>
		<input name='inicioPas' type='hidden' value='".$inicioPas."'/>
		<input name='horaPtPas' type='hidden' value='".$horaPtPas."'/>
		<input name='horaRetPas' type='hidden' value='".$horaRetPas."'/>
		<input name='fimPas' type='hidden' value='".$fimPas."'/>
		<input name='valorPas' type='hidden' value='".$valorPas."'/>
		<input name='trechoPas' type='hidden' value='".$trechoPas."'/>
		<input name='obsPas' type='hidden' value='".$obsPas."'/>
		<input name='inicioHot' type='hidden' value='".$inicioHot."'/>
		<input name='fimHot' type='hidden' value='".$fimHot."'/>
		<input name='rlHot' type='hidden' value='".$rlHot."'/>
		<input name='tipoInsert' type='hidden' value='".$tipo."'/>";
	echo "Utilize os filtros para refinar a busca.<br><br>";
    $consultaUsuarios="Select Distinct
  GEEMPRES.Cd_empresa,
  GEEMPRES.Nome_completo,
  VETIPOEM.Descricao,
  GEPFISIC.Cargo,
  GEEMPRES.Cnpj_cpf,
  VETIPOEM.Tipo_de_empresa
From
  GEPFISIC(NoLock),
  GEEMPRES With(NoLock) Left Join
  VETIPOEM With(NoLock) On GEEMPRES.Tipo_de_empresa = VETIPOEM.Tipo_de_empresa
Where
GEEMPRES.Nome_completo <> '' And
  GEEMPRES.Ativo = 1 AND
  GEEMPRES.Divisao<>'20' AND
  GEEMPRES.Cd_empresa = GEPFISIC.Cd_empresa
Order By
  GEEMPRES.Nome_completo";
  $resConsultaUsuarios = odbc_exec($conCab, $consultaUsuarios) or die("<p>".odbc_errormsg());
  
	echo "<div style=\"width: 100%; height: 400px; overflow-y: scroll;\">
	<div id='divConteudo'>
	<div id='tabela'>
	<table id='tabela'>
			<thead>
				<tr>
					<th width='10%'>C&oacute;digo</th>
					<th width='10%'>Modalidade</th>
					<th width='30%'>Nome</th>
					<th width='15%'>Cargo</th>
					<th width='20%'>CNPJ/CPF</th>
				</tr>
				<tr>
					<th><input type='text' id='txtCodigo' size='5'/></th>
					<th><input type='text' id='txtModalidade' size='10'/></th>
					<th><input type='text' id='txtNome' size='25'/></th>
					<th><input type='text' id='txtCargo' size='15'/></th>
					<th><input type='text' id='txtCNPJ' size='15'/></th>
				</tr>				
			</thead><tbody>";
	$cdEmpresa='';
	$i=0;
	while($objCiV = odbc_fetch_object($resConsultaUsuarios)){
		echo "<tr><td><input id='select[]' name='select[]' type=\"checkbox\"  value='".trim($objCiV->Cd_empresa)."'/><br>".$objCiV->Cd_empresa."</td><td>".mb_convert_encoding($objCiV->Descricao,"UTF-8","ISO-8859-1")."</td><td>".mb_convert_encoding($objCiV->Nome_completo,"UTF-8","ISO-8859-1")."</td><td>".mb_convert_encoding($objCiV->Cargo,"UTF-8","ISO-8859-1")."</td><td>".mb_convert_encoding($objCiV->Cnpj_cpf,"UTF-8","ISO-8859-1")."</td></tr>";
	}
   echo "</tbody></table></div></div></div>";
   echo "<input type='submit' name='continue' id='continue' value='Continuar' class='button' /></form>"; 



?>
</div>
</div>
</body>
</html>