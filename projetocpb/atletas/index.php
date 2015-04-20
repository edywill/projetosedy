<?php 
session_start();
//require "../conectsqlserverci.php";
//require "../conect.php";
require "conectAtleta.php";
$_SESSION['tipoAcao']='';
$_SESSION['atletaSession']='';
$_SESSION['idAtletaSession']='';
$_SESSION['classeSession']='';
$_SESSION['idmodSession']='';
$_SESSION['descModSession']='';
$_SESSION['categoriaSession']='';
$_SESSION['bolsaSession']='';
$_SESSION['dtatletaSession']='';
$_SESSION['dtheroiSession']='';
$_SESSION['primProvaSession']='';
$_SESSION['primProvaDescSession']='';
$_SESSION['primProvaPosSession']='';
$_SESSION['princProvaSession']='';
$_SESSION['princProvaDescSession']='';
$_SESSION['mmarcprovaSession']='';
$_SESSION['mmarcprovaDescSession']='';
$_SESSION['mmarcaPosSession']='';
$_SESSION['mmarcaEventoSession']='';
$_SESSION['provAtDescSession']='';
$_SESSION['provAtSession']='';
$_SESSION['projAtDescSession']='';
$_SESSION['projVlDescSession']='';
$_SESSION['provMaDescSession']='';
$_SESSION['provMaSession']='';
$_SESSION['anoMarcSession']='';
$_SESSION['marcaAtSession']='';
$_SESSION['posMarcSession']='';
if(!empty($_GET['usuario'])){
$userCriac=$_GET['usuario'];
$_SESSION['userAtleta']=$userCriac;
}else{
	$userCriac=$_SESSION['userAtleta'];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/estilo.css"/>
<link rel="stylesheet" href="../datatables/estilo/table_jui.css" />
<link rel="stylesheet" href="../datatables/estilo/jquery-ui-1.8.4.custom.css" />
<script type="text/javascript" src="../datatables/js/jquery.mim.js"></script>
<script type="text/javascript" src="../datatables/js/jquery.dataTables.min.js"></script>
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
Carregando dados...
<img src="../datatables/ajax-loader.gif" alt="preload" border="0" />
</div>
<div id='conteudo' style='visibility:hidden'>
    <br/>
    
<h2>DITEC - Atletas</h2>
<h3>Avaliação de Atletas de Alto Rendimento</h3> 
<h4>Cadastrar Modalidade/Provas</h4>
<table border="0"><tr><td>
<form action="modalidades.php" method="post" name="nova">
<input type="submit" name="botao" value="Modalidades" class="button"/>
</form>
</td><td>
<form action="provas.php" method="post" name="nova">
<input type="submit" name="botao" value="Provas" class="button"/>
</form>
</td></tr></table>
<h4>Cadastrar Novo Atleta</h4>
<form action="novoAtleta.php" method="post" name="nova">
Nome: <input type="input" name="atleta" class="input" size="40"/><br />Patrocínio: <select name="patrocinio"><option value="0">Selecione</option>
<?php 
$sqlPatr=odbc_exec($conCab,"SELECT * from patrocinio (nolock)");
while($objPatr=odbc_fetch_object($sqlPatr)){
	echo "<option value='".$objPatr->id."'>".$objPatr->patrocinio."</option>";
	}
?>
</select>
<input type="submit" name="botao" value="Cadastrar" class="button"/>
</form>
<h4>Listagem de Atletas Cadastrados</h4>
<a href="planilhaGeral.php"><input type="button" class="button" value="Planilha Geral" name="planilha" /></a>
<table id="tabela2"  cellpadding='0' cellspacing='0' border='0' class='display' name='tabela2'>
			<thead>
				<tr>
					<th width='35%'>Atleta</th>
					<th width='15%'>Patrocínio</th>
                    <th width='35%'>Mod./Classe/Cat.</th>
					<th width='10%'>Editar</th>
                    <th width='10%'>Avaliação</th>
					<th width='10%'>Excluir</th>
				</tr>				
			</thead>
            <tbody>
<?php 
$sqlAtleta=odbc_exec($conCab,"SELECT atleta.*,
										 modalidade.id AS modid, 
										 modalidade.descricao AS modalidade,
										 patrocinio.patrocinio
										 FROM atleta (nolock) LEFT JOIN modalidade (nolock)  ON 
										 modalidade.id=atleta.id_modal LEFT JOIN patrocinio (nolock) ON atleta.patrocinio_id=patrocinio.id");
while($objAt=odbc_fetch_object($sqlAtleta)){
	echo "<tr>
	<td>".$objAt->id."-".utf8_encode($objAt->nome)."</td>
	<td>".utf8_encode($objAt->patrocinio)."</td>
	<td>".utf8_encode($objAt->modalidade)." / ".utf8_encode($objAt->classe)." / ".utf8_encode($objAt->categoria)."</td>
	<td><form action='novoAtleta.php' method='POST' name='edit'>
	<input name='idAtleta' value='$objAt->id' type='hidden'/>
	<input type='submit' name='buton' value='Editar' class='button'/></form></td>
	<td><form action='avaliacao.php' method='POST' name='edit'>
	<input name='idAtleta' value='$objAt->id' type='hidden'/>
	<input type='submit' name='buton' value='Avaliação' class='button'/></form></td>
	<td>
	<a href='excluiAtleta.php?id=".$objAt->id."'><input type='button' name='buton' value='Excluir' class='button'/></a></td>
	</tr>";
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