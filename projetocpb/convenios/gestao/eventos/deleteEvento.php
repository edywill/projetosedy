<?php
$id=$_POST['idEv'];
$idproj=$_POST['idproj'];
$tipoId=$_POST['tipoId'];
require("../../../conexaomysql.php");
	//Quando houver vinculaçoes, deverá colocar uma mensagem de confirmação antes, e depois apagar todas as referências ao evento
	$sqlDelProjeto=mysql_query("DELETE FROM conveventos WHERE id='".$id."'") or die(mysql_error());
	if($sqlDelProjeto){
			?>
			   <script type="text/javascript">
               alert("Evento deletado com sucesso!");
               window.location='../modalidades/index.php?id=<?php echo $idproj; ?>&idmd=<?php echo $tipoId; ?>';
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
