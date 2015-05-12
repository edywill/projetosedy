<?php 
$itens=$_REQUEST['bdpass'];
require "../../conexaomysql.php";
require "../../conectsqlserverciprod.php";
$valida=0;
$cont=count($itens);
foreach($itens AS $item) {
   $sql=mysql_query("UPDATE registros SET bdpass=1 WHERE id='".$item."'");
   $sqlDeletePendencia=mysql_query("DELETE FROM prestbloqueados WHERE idaut='".$item."'");
   $sqlDados=mysql_fetch_array(mysql_query("SELECT idben FROM registros WHERE id='".$item."'"));
   $sqlCountDados=mysql_num_rows(mysql_query("SELECT cdempres FROM prestbloqueados WHERE cdempres='".$sqlDados['idben']."'"));
   if($sqlCountDados<1){
	   $sqlDeleteCigam=odbc_exec($conCab,"DELETE FROM TE_BLOQUEIOBPASS WHERE Empresa='".$sqlDados['idben']."'");
	   }
   
	if($sql){
		$valida++;
		}
}
if($valida==$cont){
	?>
       <script type="text/javascript">
       alert("Atualização efetuada!");
       window.parent.location.reload();
       </script>
       <?php
	}else{
		?>
       <script type="text/javascript">
       alert("Ocorreu um erro. Tente Novamente!");
       window.location("boardingPass.php");
       </script>
       <?php
		}
?>