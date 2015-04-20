<?php 
session_start();
require "../../../conectsqlserverci.php";
require "../../../conect.php";
if(!empty($_GET['usuario'])){
$userCriac=$_GET['usuario'];
$_SESSION['userAquis']=$userCriac;
}else{
	$userCriac=$_SESSION['userAquis'];
	}
$_SESSION['tipoLicSession']='';
$_SESSION['tipoSession']='';
$_SESSION['processoSession']='';
$_SESSION['processoSessionDesc']='';
$_SESSION['empresaSession']='';
$_SESSION['empresaSessionDesc']='';
$_SESSION['dataInicioSession']='';
$_SESSION['licitSessionDesc']='';
$_SESSION['acaoSession']='';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../../../css/estilo.css"/>
<link rel="stylesheet" href="../../../datatables/estilo/table_jui.css" />
<link rel="stylesheet" href="../../../datatables/estilo/jquery-ui-1.8.4.custom.css" />
<script type="text/javascript" src="../../../datatables/js/jquery.mim.js"></script>
<script type="text/javascript" src="../../../datatables/js/jquery.dataTables.min.js"></script>
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
<div id='box3' style="height:auto">
<div id='lendo'>
<h2>AQUISIÇÕES</h2>
<h3>Ordem de Serviço/Compra</h3> 
Carregando dados...
<img src="../../../datatables/ajax-loader.gif" alt="preload" border="0" />
</div>
<div id='conteudo' style='visibility:hidden'>
    <br/>
    
<h2>AQUISIÇÕES</h2>
<h3>Ordem de Serviço/Compra</h3>  
<br />
<h3>Nova Ordem</h3>
<form action="novaOrdem.php" method="post" name="nova">
<select name="tipo" id="tipo">
<option selected="selected" value="0">Escolha a modalidade</option>
<option value="pr">Pregão</option>
<option value="co">Convite</option>
<option value="cr">Concorrência</option>
</select>
<input type="submit" name="botao" value="Criar Ordem" class="button"/>
</form>
<h3>Editar Ordem</h3>

<table id="tabela2"  cellpadding='0' cellspacing='0' border='0' class='display' name='tabela2'>
			<thead>
				<tr>
					<th width='5%'>Ordem</th>
                    <th width='15%'>Tipo</th>
					<th width='30%'>Empresa</th>
					<th width='10%'>Valor</th>
					<th width='25%'>Evento</th>
					<th width='8%'>Editar</th>
                    <th width='8%'>Excluir</th>
				</tr>				
			</thead><tbody>
<?php 
$sqlOrdem=mysql_query("SELECT aquiordemlic.id AS idordem,
aquiordemlic.idos,
aquiordemlic.ano,
					  aquilic.cdempres,
					  aquiordemlic.vlunit AS valor,
					  aquiordemlic.evento,
					  aquilic.tplicit,
					  aquilic.id AS idreg 
					  FROM aquiordemlic 
					  INNER JOIN aquilic ON aquiordemlic.idreg=aquilic.id 
					  ORDER BY aquiordemlic.id") or die(mysql_error());
while($objOrdem=mysql_fetch_object($sqlOrdem)){
	switch ($objOrdem->tplicit) {
    			case "cd":
        			$descTipo='Compra Direta';
        			break;
    			case "pr":
        			$descTipo='Pregão Eletrônico';
        			break;
    			case "co":
        			$descTipo='Carta Convite';
        			break;
				case "cr":
        			$descTipo='Concorrência';
        			break;
				default:
					$descTipo='Indefinido';
	}
	$sqlEmpresaEdit2=odbc_fetch_array(odbc_exec($conCab,"select Cd_empresa,Nome_completo
from GEEMPRES (nolock) 
where Cd_empresa='".$objOrdem->cdempres."'"));
	$empresa2=$sqlEmpresaEdit2['Cd_empresa']."-".$sqlEmpresaEdit2['Nome_completo'];
	echo "<tr>
	<td>".$objOrdem->idos."/".$objOrdem->ano."</td>
	<td>".$descTipo."</td>
	<td>".utf8_encode($empresa2)."</td>
	<td>R$ ".utf8_encode($objOrdem->valor)."</td>
	<td>".utf8_encode($objOrdem->evento)."</td>
	<td><form action='novaOrdem.php' method='POST' name='edit'>
	<input name='idatu' value='$objOrdem->idreg' type='hidden'/>
	<input type='submit' name='buton' value='Editar' class='button'/></form></td>
	<td><form action='excluiOrdem.php' method='POST' name='edit'>
	<input name='idOrdem' value='$objOrdem->idordem' type='hidden'/>
	<input type='submit' name='buton' value='Excluir' class='button'/></form></td></tr>";
	}

?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</body>
</html>