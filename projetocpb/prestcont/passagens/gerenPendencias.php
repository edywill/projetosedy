<?php
//Ajustar layout
//Fazer novos testes
//Incluir with NOLOCK nos selects e deixar (nolock) nos joins

session_start();
if($_SESSION['usuario']=='' || empty($_SESSION['usuario'])){
	echo "<script>alert('Efetue o login!');top.location.href='loginad.php';</script>"; 
	}
require "../../conectsqlserver.php";
require "../../sav/conectsqlserversav.php";
require "../../conect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../../sav/css/estilo.css"/>
<link rel="stylesheet" href="../../datatables/estilo/table_jui.css" />
<link rel="stylesheet" href="../../datatables/estilo/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" href="../../jquery.autocomplete.css" />
<script type="text/javascript" src="../../datatables/js/jquery.mim.js"></script>
<script type="text/javascript" src="../../datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var oTable = $('#tabela4').dataTable({
		"bPaginate": true,
		"bNext":'Proximo',
		"bJQueryUI": true,
		"bDestroy":true,
		"bProcessing": true,
		"bServerSide": false,
		"sPaginationType": "full_numbers",
		"order": [[ 0, "desc" ]]
	});
});
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
</head>
<body onKeyDown="javascript:return bloqueioTeclas();">
<div id='box3' style="height:auto">
<div id='lendo' style="padding-top:60px; padding-left:10px">
<h1 id="h1">Carregando dados...</h1>
<img src="../../datatables/ajax-loader.gif" alt="preload" border="0" />
</div>
<div id='conteudo' style='visibility:hidden'>
    <br/>
    
<h1 id="h1">Usuários com Pendência - Boarding Pass</h1>
<?php
$sqlRegistros=mysql_query("SELECT * FROM prestbloqueados");
$countRegistros=mysql_num_rows($sqlRegistros);
if($countRegistros>0){
?>
<table id="tabela4"  cellpadding='0' cellspacing='0' border='0' class='display' name='tabela4'>
<thead>
				<tr>
					<th width='60%'><strong>Nome</strong></th>
                    <th width='20%'><strong>Status</strong></th>
                    <th width='20%'><strong>Ação</strong></th>
				</tr>				
			</thead>
       <tbody>
<?php 
while($objRegistros=mysql_fetch_object($sqlRegistros)){
$editar='';
$inativar='';
$nomeFuncionario='';
$sqlFuncionario=odbc_fetch_array(odbc_exec($conCab2,"select Nome_completo FROM GEEMPRES (nolock) where Cd_empresa='".$objRegistros->cdempres."'"));
$nomeFuncionario=utf8_encode($sqlFuncionario['Nome_completo']);
$status='Suspenso';
if($objRegistros->status==0){
	$status='Liberado 24h';
	}
echo "<tr>
<td>".$nomeFuncionario."</td>
<td>".$status."</td>";
if($objRegistros->status==1){
	echo "<td><input type='button' name='removr' value='Liberar 24h'/>";
}else{
	echo "<td><input type='button' name='removr' value='Suspender'/>";
}
echo "<input type='button' name='removr' value='Excluir'/></td>
</tr>";
}
?>       
     </tbody>
  </table>
  <?php
}
   ?>
</div>

</div>
</div>
</body>
</html>
<?PHP 

?>