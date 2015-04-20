<?php 
session_start();
require "../../conect.php";
$idReg=$_POST['idatu'];
$sqlReg=mysql_query("DELETE FROM aquimat where id='".$idReg."'");
if($sqlReg){
?>
       <script type="text/javascript">
       alert("Item deletado com sucesso.");
       window.location="insereItensSrp.php";
       </script>
       <?php
}else{
		?>
       <script type="text/javascript">
       alert("Erro ao deletar o arquivo.");
       window.location="insereItensSrp.php";
       </script>
       <?php
	
	}
?>
