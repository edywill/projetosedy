<?php
$idproj=$_POST['idproj'];
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
$idMat=$_POST['idMat'];
$tiButton=utf8_encode("MATERIAL");
$valida=0;
require("../../../../conexaomysql.php");
$sqlUpdHos=mysql_query("DELETE FROM convmat WHERE id='".$_POST['idMat']."'") or die(mysql_error());
	
	if($sqlUpdHos){
			?>
			   <script type="text/javascript">
               alert("Deletado com sucesso!");
              window.location=<?php echo "'../material.php?id=$idproj&idmd=$tipoId&titmod=$titMod&desp=mat&edit=$tiButton'";?>;
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
