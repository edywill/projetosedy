<?php
session_start();
ini_set('max_execution_time', 0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
<link rel="stylesheet" href="datatables/estilo/table_jui.css" />
<link rel="stylesheet" href="datatables/estilo/jquery-ui-1.8.4.custom.css" />
<script type="text/javascript" src="datatables/js/jquery.mim.js"></script>
<script type="text/javascript" src="datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var oTable = $('#tabela2').dataTable({
		"bPaginate": true,
		"bNext":'Proximo',
		"bJQueryUI": true,
		"bDestroy":true,
		"bProcessing": true,
		"bServerSide": false,
		"sPaginationType": "full_numbers",
		"order": [[ 2, "asc" ]]
	});
	$checado=false;
	$('#tabela2 tbody').on('click',"tr",function(){
												 var id = $("td",this).eq(0).text();
												 var status = $("input[name='select[]']",this).prop('checked') ? 1 : 0;
												 $.ajax({
														url: 'altera.php',
														type: 'GET',
														data: 'status='+status+'&id='+id+'&ci='+<?php echo $_POST['solicitacao']; ?>+'&seq='+<?php echo $_POST['sequencia']; ?>,
													});
												 });
});
</script>
  <script>
  function goBack()
	{
	window.history.back()
	}
  </script>
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
<br/><strong>CIWEB  - Selecionar Benefici&aacute;rios:</strong><br/><br/>
<div id='lendo'>
Carregando dados...
<img src="datatables/ajax-loader.gif" alt="preload" border="0" />
</div>
<div id='conteudo' style='visibility:hidden'>
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
$valida=0;
$countError=0;
$errorMsg='';
if($_POST['tipo']=='rpa'){
	$rpa=1;
	    //$inicioRPA=converteData($_POST['inicioRpa']);
		$inicioRPA=$_POST['inicioRpa'];
		$_SESSION['inicioRpaMx']=$inicioRPA;
		$inicioRPA=str_replace("'","\"",$inicioRPA);
		if(empty($inicioRPA)){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe a data inicial.\\n';
			}
		//$fimRPA=converteData($_POST['fimRpa']);
		$fimRPA=$_POST['fimRpa'];
		$_SESSION['fimRpaMx']=$fimRPA;
		$fimRPA=str_replace("'","\"",$fimRPA);
		if(empty($fimRPA)){
					$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe a data final.\\n';
			}
			if(converteData($fimRPA)<converteData($inicioRPA)){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: A data final deve ser superior a inicial.\\n';
			}
		$valorRpa=str_replace(".","",$_POST['valorRpa']);
		$_SESSION['vlRpaMx']=$valorRpa;
		$valorRpa=str_replace(",",".",$valorRpa);
		$valorRpa=(float)$valorRpa;
		$valorRpa=str_replace("'","\"",$valorRpa);
		if(empty($valorRpa)){
			$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe a valor.\\n';
			}

	}elseif($_POST['tipo']=='diaria'){
		$diaria=1;
		//$inicioDia=converteData($_POST['inicioDia']);
		$inicioDia=$_POST['inicioDia'];
		$_SESSION['inicioDiaMx']=$inicioDia;
		$inicioDia=str_replace("'","\"",$inicioDia);
		if(empty($inicioDia)){
					$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe a data inicial.\\n';
			}
		//$fimDia=converteData($_POST['fimDia']);
		$fimDia=$_POST['fimDia'];
		$_SESSION['fimDiaMx']=$fimDia;
		$fimDia=str_replace("'","\"",$fimDia);
		if(empty($fimDia)){
					$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe a data final.\\n';
			}
			if(converteData($fimDia)<converteData($inicioDia)){
					$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe a data final deve ser superior a inicial.\\n';
			}
		$valorDia=str_replace(".","",$_POST['valorDia']);
		$_SESSION['vlDiaMx']=$valorDia;
		$valorDia=str_replace(",",".",$valorDia);
		$valorDia=(float)$valorDia;
		    if(empty($valorDia)){
					$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe a valor.\\n';
			}
		}elseif($_POST['tipo']=='passagem'){
			$passagem=1;
			//$inicioPas=converteData($_POST['inicioPas']);
		    $inicioPas=$_POST['inicioPas'];
			$_SESSION['inicioPasMx']=$inicioPas;
		$inicioPas=str_replace("'","\"",$inicioPas);
//Inicio da validação do campo Inicio (data)
		if(empty($inicioPas)){
					$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe a data de partida.\\n';
			}
		//Fechou
		
        $horaPtPas=$_POST['horaPtPas'];
		$_SESSION['horaInicioMx']=$horaPtPas;
		$horaPtPas=str_replace("'","\"",$horaPtPas);
		//Abriu
		if(empty($horaPtPas)){
					$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe a hora de partida.\\n';
			}elseif($_POST['horaPtPas']>23){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Hora de partida inv\\u00e1lida.\\n';	
			}else{
				
	      $minutoPtPas=$_POST['minutoPtPas'];
		  $_SESSION['minutoInicioMx']=$minutoPtPas;
		  $minutoPtPas=str_replace("'","\"",$minutoPtPas);
	      
		  if(empty($minutoPtPas)){
					$minutoPtPas='00';
		  }elseif($minutoPtPas>59){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Minuto de partida inv\\u00e1lido.';
			}else{
				
				$horaPtPas=$_POST['horaPtPas'].$minutoPtPas."00";
				$horaPtPas=str_replace("'","\"",$horaPtPas);
				}}
		
		//Ok
		
		$horaRetPas='';
				if(!empty($_POST['horaRetPas'])){
				   if($_POST['horaRetPas']>23){
			$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Hora de partida inv\\u00e1lida.\\n';	
			}else{
				$minutoRetPas=$_POST['minutoRetPas'];
				$_SESSION['minutoFimMx']=$minutoRetPas;
				$minutoRetPas=str_replace("'","\"",$minutoRetPas);
				
				if(empty($minutoRetPas)){
					$minutoRetPas='00';
				}elseif($_POST['minutoRetPas']>59){
			$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Minuto de retorno inv\\u00e1lid.\\n';	
			}else{
				   $horaRetPas=$_POST['horaRetPas'].$_POST['minutoRetPas']."00";
				   $_SESSION['horaFimMx']=$_POST['horaRetPas'];
				   $horaRetPas=str_replace("'","\"",$horaRetPas);
				 }
			
			   }
 
				  				
			 }//Primeiro
		

//ok
		
		if(!empty($_POST['fimPas'])){
		
		$fimPas=$_POST['fimPas'];
		$_SESSION['fimPasMx']=$fimPas;
		$fimPas=str_replace("'","\"",$fimPas);
		//$fimPas=converteData($fimPas);
		$fimPas=$fimPas;
		
		if(empty($_POST['horaRetPas']) || empty($_POST['minutoRetPas'])){
			    $valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe o horario de retorno nos casos de ida e volta.\\n';	
			}
			
			if(converteData($_POST['fimPas'])==converteData($_POST['inicioPas'])){
				if($horaRetPas<$horaPtPas){
					$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Em viagens no mesmo dia, a hora de retorno deve ser superior a de partida.\\n';	
			}
		 }
		 
		 if(converteData($_POST['inicioPas'])>converteData($_POST['fimPas'])){
					$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: A data de retorno deve ser superior a de partida.\\n';	
			}
		
				}else{
			$fimPas="null";
		    }
			
        $valorPas=str_replace(".","",$_POST['valorPas']);
		$_SESSION['vlPasMx']=$_POST['valorPas'];
		$valorPas=str_replace(",",".",$valorPas);
		$valorPas=(float)$valorPas;
		$valorPas=str_replace("'","\"",$valorPas);
		$trechoPas=utf8_encode($_POST['trechoPas']);
		$_SESSION['trechoMx']=$_POST['trechoPas'];
		$trechoPas=str_replace("'","\"",$trechoPas);
		$obsPas=utf8_encode($_POST['obsPas']);
		$_SESSION['obsPasMx']=$_POST['obsPas'];
		$obsPas=str_replace("'","\"",$obsPas);
		    if(empty($valorPas)){
					$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe o valor.\\n';	
			}
			}elseif($_POST['tipo']=='hotel'){
				$hotel=1;
				$inicioHot=$_POST['inicioHot'];
				$_SESSION['inicioHotMx']=$inicioHot;
		//$inicioHot=converteData($_POST['inicioHot']);
		$inicioHot=str_replace("'","\"",$inicioHot);
		if(empty($inicioHot)){
					$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe a data inicial.\\n';	
			}
		$fimHot=$_POST['fimHot'];
		$_SESSION['fimHotMx']=$fimHot;
		//$fimHot=converteData($_POST['fimHot']);
		$fimHot=str_replace("'","\"",$fimHot);
		if(empty($fimHot)){
					$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Informe a data final.\\n';	
	   }
	   if(converteData($fimHot)<converteData($inicioHot)){
					$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: A data final deve ser superior a inicial.\\n';	
			}
		}
				
if($valida==1){
	?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="<?php echo $retornar; ?>";
       </script>
       <?php
	}else{
echo "<form action='ciWExcMultAt.php' method='post' name='mult' style='margin:20px'>
 <strong>CI n&ordm;: <font size='3' color='red'>".$_POST['solicitacao']."</font></strong><br>
	  Item: ".$_POST['sequencia']."<br><br>
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

	echo "<strong>Utilize os filtros para refinar a busca.</strong><br><br>";
    $consultaUsuarios="Select Distinct
  GEEMPRES.Cd_empresa,
  GEEMPRES.Pessoa,
  GEEMPRES.Nome_completo,
  VETIPOEM.Descricao,
  GEPFISIC.Cargo,
  GEEMPRES.Cnpj_cpf,
  VETIPOEM.Tipo_de_empresa
From
  GEEMPRES With(NoLock) Left Join
  VETIPOEM With(NoLock) On GEEMPRES.Tipo_de_empresa = VETIPOEM.Tipo_de_empresa
  Left Join
  GEPFISIC With(NoLock) On GEEMPRES.Cd_empresa = GEPFISIC.Cd_empresa
Where
  GEEMPRES.Nome_completo <> '' And
  GEEMPRES.Ativo = 1 AND
  GEEMPRES.Divisao<>'20'
Order By
  GEEMPRES.Nome_completo ASC";
  $resConsultaUsuarios = odbc_exec($conCab, $consultaUsuarios);
  
  echo "<div class='label'>";
	echo "
	<table id=\"tabela2\"  cellpadding='0' cellspacing='0' border='0' class='display' name='tabela2'>
			<thead>
				<tr>
					<th width='10%'>C&oacute;digo</th>
					<th width='8%'>Modalidade</th>
					<th width='40%'>Nome</th>
					<th width='8%'>Cargo</th>
					<th width='15%'>CNPJ/CPF</th>
				</tr>				
			</thead><tbody>";
	$cdEmpresa='';
	$cpfCnpj='';
	
	while($objCiV = odbc_fetch_object($resConsultaUsuarios)){
		if(empty($objCiV->Pessoa)){
			$cpfCnjp=mask(mb_convert_encoding($objCiV->Cnpj_cpf,"UTF-8","ISO-8859-1"),'##.###.###/####-##');
			}else{
				$cpfCnjp=mask(mb_convert_encoding($objCiV->Cnpj_cpf,"UTF-8","ISO-8859-1"),'###.###.###-##');
				}
		echo "<tr><td><p style='font-size:12px'><input id='select[]' name='select[]' type=\"checkbox\"  value='".$objCiV->Cd_empresa."'/><input type='hidden' name='id[]' value='".$objCiV->Cd_empresa."' />".$objCiV->Cd_empresa."</p></td>
			<td><p style='font-size:12px'>".mb_convert_encoding($objCiV->Descricao,"UTF-8","ISO-8859-1")."</p></td>
			<td><p style='font-size:12px'>".mb_convert_encoding($objCiV->Nome_completo,"UTF-8","ISO-8859-1")."</p></td>
			<td><p style='font-size:12px'>".mb_convert_encoding($objCiV->Cargo,"UTF-8","ISO-8859-1")."</p></td>
			<td><p style='font-size:12px'>".$cpfCnjp."</p></td>
		</tr>";
	}
   echo "</tbody></table>";
   echo "<br/><input type='submit' name='continue' id='button2' value='Continuar' class='buttonVerde' /></form><br>"; 
	echo "<br/><a href=\"ciWExcMult.php\"><img src='imagens/botaoVoltar.png'></a></div>";
}
//Função de máscara de número
function mask($val, $mask)
{
 $maskared = '';
 $k = 0;
	 for($i = 0; $i<=strlen($mask)-1; $i++)
	  {
		if($mask[$i] == '#')
		{
		if(isset($val[$k]))
			$maskared .= $val[$k++];
		}
		else
		{
			if(isset($mask[$i]))
				$maskared .= $mask[$i];
			}
		}
	 return $maskared;
}
?>
</div>
</div>
</body>
</html>