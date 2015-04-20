<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exemplo DataTables</title>
<link rel="stylesheet" href="datatables/estilo/table_jui.css" />
<link rel="stylesheet" href="datatables/estilo/jquery-ui-1.8.4.custom.css" />
<script type="text/javascript" src="datatables/js/jquery.mim.js"></script>
<script type="text/javascript" src="datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	oTable = $('#example').dataTable({
		"bPaginate": true,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	});
});
</script>
</head>
<body>
<?php 
require "conect.php";
$sql=mysql_query("SELECT * FROM usuarios WHERE status='A' OR status='I'");
?>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
				<tr>
					<th width='30%'>Nome</th>
					<th width='10%'>SIAPE</th>
					<th width='20%'>Email</th>
					<th width='10%'>Lotação/UF</th>
					<th width='10%'>Celular</th>
                    <th width='10%'>Ativ./Inat.</th>
                    <th width='10%'>Editar</th>
                    <th width='10%'>Ficha</th>
				</tr>
                </thead>
	<tbody>
    <?php
	while($obj=mysql_fetch_object($sql)){
		$botao='Inativar';
		$color='';
		if($obj->status=='I'){
			$botao='Ativar';
			$color="bgcolor='gray'";
			}
		echo "<tr ".$color."><td ".$color.">".utf8_encode($obj->name)."</td><td ".$color.">".$obj->matsiape."</td><td ".$color.">".$obj->email."</td><td ".$color.">".$obj->lotacao."/".$obj->uflot."</td><td ".$color.">".$obj->celular."</td><td ".$color."><a href='aprovUser.php?id=".$obj->id."&status=".$obj->status."' target='_top'><input type='button' value='".$botao."'/></a></td><td ".$color."><a href='cadastro.php?id=".$obj->id."' target='_top'><input type='button' value='Editar'/></a></td><td ".$color."><a href='fichaUser.php?id=".$obj->id."' target='_blank'><input type='button' value='Ficha Cadastral'/></a></td></tr>";
		}
	
	?>
	</tbody>
	<tfoot>
	</tfoot>
</table>
</body>
</html>
