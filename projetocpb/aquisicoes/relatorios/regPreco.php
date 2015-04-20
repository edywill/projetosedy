<?php 
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";
if(!empty($_GET['usuario'])){
	unset($_SESSION['userAquis']);
	$_SESSION['userAquis']=$_GET['usuario'];
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
  <h3><strong>Relatórios</strong> - Registro de Preço<br />
      
  </h3>
  Selecione o Registro de Preço:<br />
  <form action="../registro/relatorioSrp.php" name="relsrp" method="post">
  <input type='hidden' name='pagsrp' value='../relatorios/regPreco.php'/>
  <select name="idsrp" id="idsrp">
  <option selected="selected" value="0">Selecione</option>
  <?php 
  $sqlRegistros=mysql_query("SELECT * FROM aquireg WHERE inativo=0 ORDER BY id");
while($objRegistros=mysql_fetch_object($sqlRegistros)){
$sqlEmpresaEdit=odbc_fetch_array(odbc_exec($conCab,"select Cd_empresa,Nome_completo
from GEEMPRES (nolock) 
where Cd_empresa='".$objRegistros->cdempres."'"));
				$empresa=$sqlEmpresaEdit['Cd_empresa']."-".$sqlEmpresaEdit['Nome_completo'];
echo "<option value='".$objRegistros->id."'>".utf8_encode($empresa)."</option>";
}
?>  
  </select>
  <input type="submit" name="ok" class="button" value="OK" />
  </form>
  <br /><br />
  <a href="../relatorios.php"><input class="button" type="button" name="voltar" value="Voltar" /></a>
</div>
</body>
</html>