<?php
$idproj=$_POST['idproj'];
$idEvento=$_POST['idEvento'];
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
$idAli=$_POST['idAli'];
$tiButton=utf8_encode("ALIMENTAÇÃO");
$valida=0;
require("../../../../conexaomysql.php");
$sqlUpdAli=mysql_query("DELETE FROM convali WHERE id='".$_POST['idAli']."'") or die(mysql_error());
	
	if($sqlUpdAli){
			?>
			   <script type="text/javascript">
               alert("Deletado com sucesso!");
               window.location=<?php echo "'../projec.php?id=$idproj&idmd=$tipoId&idev=$idEvento&titmod=$titMod&desp=ali&edit=$tiButton'";?>;
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
