<?php 
session_start();
require "../../../conectsqlserverci.php";
require "../../../conect.php";
	$userCriac=$_SESSION['userAquis'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>

<script language="javascript">
<!--
function aumenta(obj){
    obj.height=obj.height*1.2;
	obj.width=obj.width*1.2;
}
 
function diminui(obj){
	obj.height=obj.height/1.2;
	obj.width=obj.width/1.2;
}
//-->
</script>

</head>
       
<body>
<div id='box3' style="height:auto">
    <br/>
    
<h2>AQUISIÇÕES</h2>
<h3>Grupo de Despesa</h3>  
<br />
<a href="novoGrupo.php"><input type="button" value="Novo Grupo" name="nreg" class="buttonVerde"/></a>
<div id='tabela'>
<table width="100%" border="0">
<tr><th width="15%">Nº Grupo</th><th width="40%">Descrição</th><th width="15%">Editar</th><th width="10%">Inativar</th></tr>
<?php 

$sqlGrupo=mysql_query("select * from aquigrupo where inativo=0 ORDER BY id DESC");
while($objGrupo=mysql_fetch_object($sqlGrupo)){
	
echo "<tr><td>".utf8_encode($objGrupo->codigo)."</td><td>".utf8_encode($objGrupo->descricao)."</td><td><form action='novoGrupo.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objGrupo->id."'/><input type='submit' name='edit' value='Editar' class='button'/></form></td><td><form action='inativarGrupo.php' method='post' name='rel'><input type='hidden' name='idinat' value='".$objGrupo->id."'/><input type='submit' name='inat' value='Inativar' class='button'/></form></td></tr>";
}
?>
</table>
</div>
</div>
</body>
</html>