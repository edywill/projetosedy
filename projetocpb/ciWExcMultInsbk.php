<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
 <script type="text/javascript" src="ajax/funcs.js"></script>
 <script type='text/javascript' src='jquery_price.js'></script>
 <script type="text/javascript">
  $(document).ready(function(){
      $('#valorRpa').priceFormat({
        prefix: '',
        centsSeparator: '.',
        thousandsSeparator: ''
      });
    });
  </script>
  <script type="text/javascript">
  $(document).ready(function(){
      $('#valorDia').priceFormat({
        prefix: '',
        centsSeparator: '.',
        thousandsSeparator: ''
      });
    });
  </script>
  <script type="text/javascript">
  $(document).ready(function(){
      $('#valorPas').priceFormat({
        prefix: '',
        centsSeparator: '.',
        thousandsSeparator: ''
      });
    });
  </script>
  <script type="text/javascript">
  $().ready(function() {
	  $("#rpaCod").autocomplete("suggest_user.php", {
		  width: 260,
		  matchContains: true,
		  selectFirst: false
	  });
  });
  </script>
  <script type="text/javascript">
  $().ready(function() {
	  $("#diaCod").autocomplete("suggest_user.php", {
		  width: 260,
		  matchContains: true,
		  selectFirst: false
	  });
  });
  </script>
  <script type="text/javascript">
  $().ready(function() {
	  $("#pasCod").autocomplete("suggest_user.php", {
		  width: 260,
		  matchContains: true,
		  selectFirst: false
	  });
  });
  </script>
  <script type="text/javascript">
  $().ready(function() {
	  $("#hotCod").autocomplete("suggest_user.php", {
		  width: 260,
		  matchContains: true,
		  selectFirst: false
	  });
  });
  </script>
  <script>
  $(function() {
	  $( "#inicioRpa" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#fimRpa" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#inicioDia" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#fimDia" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#inicioPas" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#fimPas" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#inicioHot" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#fimHot" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script language='Javascript'>
  function validNumb(e){
  var tecla=(window.event)?event.keyCode:e.which;   
  if((tecla > 47 && tecla < 58)) return true;
  else{
  if(tecla==8 || tecla==0) return true;
  else
  return false;
  }
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
  <script>
  function goBack()
	{
	window.history.back()
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
  <script language="Javascript">
  function showDiv(div)
  {
  document.getElementById("rpa").className = "invisivel";
  document.getElementById("diaria").className = "invisivel";
  document.getElementById("passagem").className = "invisivel";
  document.getElementById("hotel").className = "invisivel";
  
  document.getElementById(div).className = "visivel";
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
    <link rel="stylesheet" href="jquerymulti2side/css/jquery.multiselect2side.css" type="text/css" media="screen" />
    <script type="text/javascript" src="jquerymulti2side/js/jquery.js" ></script>
	<script type="text/javascript" src="jquerymulti2side/js/jquery.multiselect2side.js" ></script>
	<script type="text/javascript">
		$().ready(function() {
			$('#selectBen').multiselect2side({
				search: "Buscar: "
			});
			$('#first').multiselect2side({
				optGroupSearch: "Group: ",
				search: "<img src='img/search.gif' />"
			});
			$('#second').multiselect2side({
				selectedPosition: 'right',
				moveOptions: false,
				labelsx: '',
				labeldx: '',
				autoSort: true,
				autoSortAvailable: true
				});
			$('#third').multiselect2side({
				selectedPosition: 'left',
				moveOptions: true,
				labelTop: '+ +',
				labelBottom: '- -',
				labelUp: '+',
				labelDown: '-',
				labelsx: '* Selected *',
				labeldx: '* Available *',
				search: "Find: "
				});
			$('#fourth').multiselect2side({maxSelected: 4});

			$('.clickToView2').click(function() {
				$(this).parent().prevAll("select:first").toggle();
				return false;
			});

			$('.clickToView').click(function() {
				elClick = $(this);
				selEl = elClick.prevAll("select:first");

				$.ajax({
					url: 'jmultiselect2side.php',
					data: selEl.serialize() + '&SELECTNAME=' + selEl.attr("name"),
					success: function(data) {
						elClick.next().next().next().html(data);
					}
				});
				return false;
			});


		$('#fourth')
			.multiselect2side('addOption', {name: 'test selected', value: 'test1', selected: true})
			.multiselect2side('addOption', {name: 'test not selected', value: 'test2', selected: false});
		$('#third')
			.multiselect2side('addOption', {name: 'test selected', value: 'test1', selected: true})
			.multiselect2side('addOption', {name: 'test not selected', value: 'test2', selected: false});
		//$('#third').multiselect2side('destroy');
		});
	</script>
    <link rel="stylesheet" href="jquerymulti2side/css/jquery.multiselect2side.css" type="text/css" media="screen" />
  <style>
  .invisivel { display: none; }
  .visivel { visibility: visible; }
  </style>
</head>
<body onLoad="prettyPrint();">
<div id='box3'>
<br/><strong>CIWEB  - Selecionar Benefici&aacute;rios:</strong><br/><br/>
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
		$valorRpa=(float)$_POST['valorRpa'];
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
		$valorDia=(float)$_POST['valorDia'];
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
        $valorPas=(float)$_POST['valorPas'];
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

echo "<form action='ciWExcMultAt.php' method='post' style='margin:20px 0'>
 CI n&ordm;: ".$_POST['solicitacao']."<br>
	  Item: ".$_POST['sequencia']."<br>
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

/*echo "Clique uma vez no campo abaixo e aguarde a lista de nomes aparecer.<br><br>
<select id='select' name='select[]' multiple=\"multiple\" style=\"width:570px\">";
$consultaUsuarios="select Cd_empresa,Nome_completo
from GEEMPRES (nolock) 
where ativo = 1 AND
Nome_completo<>''
ORDER BY Nome_completo";
  $resConsultaUsuarios = odbc_exec($conCab, $consultaUsuarios);		
	 while($objCiV = odbc_fetch_object($resConsultaUsuarios)){		
		echo "<option value='".$objCiV->Cd_empresa."'>".mb_convert_encoding($objCiV->Nome_completo,"UTF-8","ISO-8859-1")."</option>";
	 }
		echo "</select>";
	*/
	echo "Selecione os nomes na primeira coluna e passe para a segunda coluna.<br><br>";
    $consultaUsuarios="select Cd_empresa,Nome_completo
from GEEMPRES (nolock) 
where ativo = 1 AND
Nome_completo<>''
ORDER BY Nome_completo";
  $resConsultaUsuarios = odbc_exec($conCab, $consultaUsuarios);
	echo "<select name=\"select[]\" id='selectBen' multiple='multiple' >";
	 while($objCiV = odbc_fetch_object($resConsultaUsuarios)){		
		echo "<option value='".$objCiV->Cd_empresa."'>".mb_convert_encoding($objCiV->Nome_completo,"UTF-8","ISO-8859-1")."</option>";
	 }
		echo "</select>";
   echo "<br><br>
   <input type='submit' name='continue' id='continue' value='Continuar' />"; 


echo "</form>";
?>
</div>
</body>
</html>