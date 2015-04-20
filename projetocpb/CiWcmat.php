<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<script>
function retorna(retorno)
        {
           window.opener.document.getElementById('cdMaterial').value = retorno;
           window.opener.document.getElementById('cdMaterial').focus();
		   window.self.close();
        }
</script>
<body>
C&oacute;digo Material
<br />
Digite parte do nome do Material para buscar
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
$SQLCiItensV="select Cd_material,Descricao,Cd_reduzido
from ESMATERI (nolock) 
where 
Descricao LIKE '%".$palavra."%' 
AND tipo <> 'I' AND
(tipo <> 'O' and dbo.CGFC_BUSCA_CONFIGURACAO(1772,null) = 0 
     or dbo.CGFC_BUSCA_CONFIGURACAO(1772,null) = 1)
";
		$resCiItensV = odbc_exec($conCab, $SQLCiItensV);
		$numRegistros = odbc_num_rows($resCiItensV);
		if($numRegistros!=0){
while($objCiItensV = odbc_fetch_object($resCiItensV)){
	$Cd_material=str_replace(".","",$objCiItensV->Cd_reduzido);
	$Cd_material=(int)$Cd_material;
echo "<a href=javascript:retorna('".$Cd_material."');>".$objCiItensV->Cd_reduzido." - ".$objCiItensV->Descricao."</a><BR><BR>";
}
		}else{
			echo "Nenhum registro encontrado";
			}
		
		}
?>
</body>
</html>