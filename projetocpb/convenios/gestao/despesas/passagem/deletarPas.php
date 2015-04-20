<?php
$idproj=$_POST['idproj'];
$idEvento=$_POST['idEvento'];
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
$idPas=$_POST['idPas'];
$tiButton=utf8_encode("PASSAGEM AEREA");
$valida=0;
require("../../../../conexaomysql.php");

$sqlUpdPas=mysql_query("DELETE FROM convpas WHERE id='".$_POST['idPas']."'") or die(mysql_error());
	
	if($sqlUpdPas){
			?>
			   <script type="text/javascript">
               alert("Deletado com sucesso!");
               window.location=<?php echo "'../projec.php?id=$idproj&idmd=$tipoId&idev=$idEvento&titmod=$titMod&desp=pas&edit=$tiButton'";?>;
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
