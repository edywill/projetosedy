<?php
$id=$_POST['idDel'];
require("../../../conexaomysql.php");
	//Quando houver vincula�oes, dever� colocar uma mensagem de confirma��o antes, e depois apagar todas as refer�ncias ao projeto
	$sqlDelProjeto=mysql_query("DELETE FROM convprojetos WHERE id='".$id."'") or die(mysql_error());
	if($sqlDelProjeto){
			?>
			   <script type="text/javascript">
               alert("Projeto deletado com sucesso!");
               window.location="../../gestConv.php";
               </script>
               <?php
		}else{
			?>
			   <script type="text/javascript">
               alert("Ocorreu um erro! Tente novamente.");
               history.back();
               </script>
               <?php
			}
?>
