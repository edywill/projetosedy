<?php 
session_start();
require "../../conect.php";
$idReg=$_POST['idinat'];
$sqlReg=mysql_query("UPDATE aquireg SET inativo=1 where id='".$idReg."'");
if($sqlReg){
?>
       <script type="text/javascript">
       alert("Registro inativado com sucesso.");
       window.location="index.php";
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
