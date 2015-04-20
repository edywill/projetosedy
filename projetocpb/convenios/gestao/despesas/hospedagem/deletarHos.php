<?php
$idproj=$_POST['idproj'];
$idEvento=$_POST['idEvento'];
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
$idHos=$_POST['idHos'];
$tiButton=utf8_encode("HOSPEDAGEM");
$valida=0;
require("../../../../conexaomysql.php");
$sqlUpdHos=mysql_query("DELETE FROM convhos WHERE id='".$_POST['idHos']."'") or die(mysql_error());
	
	if($sqlUpdHos){
			?>
			   <script type="text/javascript">
               alert("Deletado com sucesso!");
               window.location=<?php echo "'../projec.php?id=$idproj&idmd=$tipoId&idev=$idEvento&titmod=$titMod&desp=hos&edit=$tiButton'";?>;
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
