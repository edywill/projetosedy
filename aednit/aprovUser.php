<?php 
$id=$_GET['id'];
$status=$_GET['status'];
require "conect.php";
$st='A';
if($status=='A'){
	$st='I';
	}elseif($status=='N'){
		$st='D';
		}

$updUser=mysql_query("UPDATE usuarios SET status='".$st."',dtalt='".date("d/m/Y")."' WHERE id=".$id."") or die(mysql_error());

if($updUser){
	?>
												   <script type="text/javascript">
                                                   alert("Atualizado com sucesso");
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
