<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<script>
function retorna(retorno)
        {
           window.opener.document.getElementById('redcont').value = retorno;
		   window.opener.document.getElementById('redcont').focus();
           window.self.close();
        }
</script>
<body>
Reduzido Cont&aacute;bil
<br />
Digite parte do nome da conta gerencial e clique em buscar. A busca lan&ccedil;ar&aacute; o reduzido da conta.
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
$SQLCiItensV="select cg.Pcc_nome_conta,cg.Cd_pcc_reduzid
from CCPCC cg (nolock)
where cg.Pcc_nome_conta LIKE '%".$palavra."%'
and substring(cg.livre_alfa_18,1,1) <> 'N'
and cg.pcc_tipo = 'A'";
		$resCiItensV = odbc_exec($conCab, $SQLCiItensV);
		$numRegistros = odbc_num_rows($resCiItensV);
		if($numRegistros!=0){
while($objCiItensV = odbc_fetch_object($resCiItensV)){
	$Cd_cgen=(int)$objCiItensV->Cd_pcc_reduzid;
echo "<a href=javascript:retorna(\"".$Cd_cgen."\");>".$objCiItensV->Cd_pcc_reduzid." - ".$objCiItensV->Pcc_nome_conta."</a><BR><BR>";
}
		}else{
			echo "Nenhum registro encontrado";
			}
		
		}
?>
</body>
</html>