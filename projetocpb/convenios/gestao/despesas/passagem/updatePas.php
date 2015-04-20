<?php
$idproj=$_POST['idproj'];
$idEvento=$_POST['idEvento'];
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
$origem=$_POST['origem'];
$destino=$_POST['destino'];
$cidadeorigem=$_POST['cidorigem'];
$cidadedestino=$_POST['ciddestino'];
$qtd=$_POST['qtd'];
$tipo=$_POST['tipo'];
$dtin=$_POST['dtinicio'];
$dtfim=$_POST['dtfim'];
$vlunit=$_POST['vlunit'];
$total=$_POST['total'];
$abrg=$_POST['abrg'];
$tiButton=utf8_encode("PASSAGEM AEREA");
$valida=0;
require("../../../../conexaomysql.php");
	
	$sqlUpdRhPem=mysql_query("UPDATE convpas SET idproj='".trim($idproj)."', modal='".trim($tipoId)."', origem='".trim($origem)."',destino='".trim($destino)."',cidadeorigem='".trim($cidadeorigem)."',cidadedestino='".trim($cidadedestino)."',qtd='".trim($qtd)."',tipo='".$tipo."',abrgpas='".$abrg."',dtin='".$dtin."',dtfim='".$dtfim."',total='".trim($total)."' WHERE id='".$_POST['idPas']."'") or die(mysql_error());
	
	if($sqlUpdRhPem){
			?>
			   <script type="text/javascript">
               alert("Atualizado com sucesso!");
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
