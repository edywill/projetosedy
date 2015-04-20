<?php
$idproj=$_POST['idproj'];
$idEvento=$_POST['idEvento'];
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
$idSgv=$_POST['idSgv'];
$tiButton=utf8_encode("SEGURO VIAGEM");
$valida=0;
require("../../../../conexaomysql.php");
$sqlUpdHos=mysql_query("DELETE FROM convsgv WHERE id='".$_POST['idSgv']."'") or die(mysql_error());
	
	if($sqlUpdHos){
			?>
			   <script type="text/javascript">
               alert("Deletado com sucesso!");
               window.location=<?php echo "'../projec.php?id=$idproj&idmd=$tipoId&idev=$idEvento&titmod=$titMod&desp=sgv&edit=$tiButton'";?>;
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
