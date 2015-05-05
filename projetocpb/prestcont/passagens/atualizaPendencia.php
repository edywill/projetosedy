<?php
require "../../conect.php";
require "../../conectsqlserverciprod.php";
if($_GET['tipo']=='x'){
	//Excluir
	$atualizarPendencia=mysql_query("DELETE FROM prestbloqueados WHERE cdempres='".$_GET['cdemp']."'") or die(mysql_error());
	$atualizaCigam=odbc_exec($conCab,"DELETE FROM TE_BLOQUEIOBPASS WHERE Empresa='".trim($_GET['cdemp'])."'");
	
	}else{
		if($_GET['tipo']=='l'){
			//Liberar
			$atualizarPendencia=mysql_query("UPDATE prestbloqueados SET status=0 WHERE cdempres='".$_GET['cdemp']."'") or die(mysql_error());
			$atualizaCigam=odbc_exec($conCab,"UPDATE TE_BLOQUEIOBPASS SET Bloqueado=0 WHERE Empresa='".trim($_GET['cdemp'])."'");	
			}else{
				//Suspender
				$atualizarPendencia=mysql_query("UPDATE prestbloqueados SET status=1 WHERE cdempres='".$_GET['cdemp']."'") or die(mysql_error());
				$atualizaCigam=odbc_exec($conCab,"UPDATE TE_BLOQUEIOBPASS SET Bloqueado=1 WHERE Empresa='".trim($_GET['cdemp'])."'");	
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