<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<script>
function retorna(retorno)
        {
           window.opener.document.getElementById('portador').value = retorno;
           window.self.close();
        }
</script>
<body>
 Portador
<br />
Digite parte do nome do portador para buscar
<form name="frmbusca" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?a=buscar" >
<input type="text" name="palavra" />
<input type="submit" value="Buscar" />
</form>
<?php 
require "conectsqlserverci.php";
include "mb.php";
if(empty($_GET['a'])){
			   $a='';
			   }else{
				$a = $_GET['a'];
				   }
if ($a == "buscar") {
$palavra = trim($_POST['palavra']);
$SQLCiItensV="select Cd_portador,Nome
			  from GFPORTAD (nolock) 
			  where Nome LIKE '%".$palavra."%' AND 
			  ativo = 1";
		$resCiItensV = odbc_exec($conCab, $SQLCiItensV);
		$numRegistros = odbc_num_rows($resCiItensV);
		if($numRegistros!=0){
while($objCiItensV = odbc_fetch_object($resCiItensV)){
	$Cd_portador=(int)$objCiItensV->Cd_portador;
echo "<a href=javascript:retorna('".$Cd_portador."');>".$objCiItensV->Cd_portador." - ".$objCiItensV->Nome."</a><BR><BR>";
}
		}else{
			echo "Nenhum registro encontrado";
			}
		
		}
?>
</body>
</html>