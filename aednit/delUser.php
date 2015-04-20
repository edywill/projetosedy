<?php 
$id=$_GET['id'];
require "conect.php";

$updUser=mysql_query("DELETE FROM usuarios WHERE id=".$id."") or die(mysql_error());
if($updUser){
	?>
												   <script type="text/javascript">
                                                   alert("Usuario apagado com sucesso");
                                                   window.location="gerUsers.php";
                                                   </script>
                                                   <?php
	}else{
		?>
												   <script type="text/javascript">
                                                   alert("Ocorreu um erro! Tente novamente!");
                                                   window.location="gerUsers.php";
                                                   </script>
                                                   <?php
		}

?>
