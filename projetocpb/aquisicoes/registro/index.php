<?php 
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";
if(!empty($_GET['usuario'])){
$userCriac=$_GET['usuario'];
$_SESSION['userAquis']=$userCriac;
}else{
	$userCriac=$_SESSION['userAquis'];
	}
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
<h3>Registro de Preço</h3>  
<br />
<a href="novoSrp.php"><input type="button" value="Novo Registro" name="nreg" class="buttonVerde"/></a>
<div id='tabela'>
<table width="100%" border="0">
<tr><th width="55%">Empresa</th><th width="15%">Editar Registro</th><th width="20%">Relatório por Registro</th><th width="10%">Inativar</th></tr>
<?php 

$sqlSrp=mysql_query("select * from aquireg where inativo=0 ORDER BY id DESC");
while($objSrp=mysql_fetch_object($sqlSrp)){
	$consultaEmpresa=odbc_fetch_array(odbc_exec($conCab,"SELECT Cd_empresa,Nome_completo FROM GEEMPRES (nolock) WHERE Cd_empresa='".$objSrp->cdempres."'"));
echo "<tr><td>".utf8_encode($consultaEmpresa['Nome_completo'])."</td><td><form action='novoSrp.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objSrp->id."'/><input type='submit' name='edit' value='Editar' class='button'/></form></td><td><form action='relatorioSrp.php' method='post' name='rel'><input type='hidden' name='idsrp' value='".$objSrp->id."'/>
<input type='hidden' name='pagsrp' value='index.php'/><input type='submit' name='rel' value='Relatório' class='button'/></form></td><td><form action='inativarSrp.php' method='post' name='rel'><input type='hidden' name='idinat' value='".$objSrp->id."'/><input type='submit' name='inat' value='Inativar' class='button'/></form></td></tr>";
}
?>
</table>
</div>
</div>
</body>
</html>