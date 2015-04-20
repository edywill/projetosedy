<?php
$idproj=$_POST['idproj'];
$idEvento=$_POST['idEvento'];
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
$idRh=$_POST['idRh'];
$valida=0;
require("../../../../conexaomysql.php");

$sqlUpdRhPem=mysql_query("DELETE FROM convrh WHERE id='".$_POST['idRh']."'") or die(mysql_error());
	
	if($sqlUpdRhPem){
			?>
			   <script type="text/javascript">
               alert("Deletado com sucesso!");
                window.location=<?php echo "'../projec.php?id=$idproj&idmd=$tipoId&idev=$idEvento&titmod=$titMod&desp=rht&edit=RH DO EVENTO'";?>;
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
