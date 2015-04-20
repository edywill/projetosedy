<?php 
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";
	$userCriac=$_SESSION['userAquis'];
	$_SESSION['idGrupoSession']='';
	$_SESSION['dadosGrupoSession']='';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
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
<h3>Materiais</h3>  
<br />
<a href="novoMat.php"><input type="button" value="Novo Material" name="nreg" class="buttonVerde"/></a>
<div id='tabela'>
<table width="100%" border="0">
<tr><th width="35%">Grupo de Despesa</th><th width="40%">Material</th><th width="15%">Editar</th><th width="10%">Inativar</th></tr>
<?php 

$sqlMaterial=mysql_query("SELECT aquigrupo.codigo,aquigrupo.descricao,aquicadmat.id,aquicadmat.nome FROM aquicadmat LEFT JOIN aquigrupo ON aquicadmat.grupo=aquigrupo.id
WHERE aquigrupo.inativo=0 AND aquicadmat.inativo=0
ORDER BY aquigrupo.id");
while($objMaterial=mysql_fetch_object($sqlMaterial)){
	
echo "<tr><td>".utf8_encode($objMaterial->codigo)."-".utf8_encode($objMaterial->descricao)."</td><td>".utf8_encode($objMaterial->nome)."</td><td><form action='novoMat.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMaterial->id."'/><input type='submit' name='edit' value='Editar' class='button'/></form></td><td><form action='inativarMat.php' method='post' name='rel'><input type='hidden' name='idinat' value='".$objMaterial->id."'/><input type='submit' name='inat' value='Inativar' class='button'/></form></td></tr>";
}
?>
</table>
</div>
</div>
</body>
</html>