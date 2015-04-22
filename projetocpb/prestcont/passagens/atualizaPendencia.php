<?php
require "../../conect.php";
if($_GET['tipo']=='x'){
	//Excluir
	$atualizarPendencia=mysql_query("DELETE FROM prestbloqueados WHERE cdempres='".$_GET['cdemp']."'") or die(mysql_error());	
	}else{
		if($_GET['tipo']=='l'){
			//Liberar
			$atualizarPendencia=mysql_query("UPDATE prestbloqueados SET status=0 WHERE cdempres='".$_GET['cdemp']."'") or die(mysql_error());	
			}else{
				//Suspender
				$atualizarPendencia=mysql_query("UPDATE prestbloqueados SET status=1 WHERE cdempres='".$_GET['cdemp']."'") or die(mysql_error());
				}
		}
if($atualizarPendencia){
?>
	   <script type="text/javascript">
       alert("Processado com sucesso!");
       window.location="gerenPendencias.php";
       </script>
       <?php 
	   
}
	   ?>