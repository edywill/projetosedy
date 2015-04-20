<?php
$idproj=$_POST['idproj'];
$idEvento=$_POST['idEvento'];
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
$idTra=$_POST['idTra'];
$tiButton=utf8_encode("HOSPEDAGEM");
$valida=0;
require("../../../../conexaomysql.php");
$sqlUpdHos=mysql_query("DELETE FROM convtra WHERE id='".$_POST['idTra']."'") or die(mysql_error());
	
	if($sqlUpdHos){
			?>
			   <script type="text/javascript">
               alert("Deletado com sucesso!");
               window.location=<?php echo "'../projec.php?id=$idproj&idmd=$tipoId&idev=$idEvento&titmod=$titMod&desp=tra&edit=$tiButton'";?>;
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
