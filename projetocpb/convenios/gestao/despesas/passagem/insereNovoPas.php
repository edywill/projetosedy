<?php
$idproj=$_POST['idproj'];
$idEvento=$_POST['idEvento'];
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
$qtd=$_POST['qtd'];
$tipo=$_POST['tipo'];
$dtin=$_POST['dtinicio'];
$dtfim=$_POST['dtfim'];
$vlunit=$_POST['vlunit'];
$total=$_POST['total'];
$abrg=$_POST['abrg'];
$cidadeorigem='';
$cidadedestino='';
$origem=$_POST['origem'];
$destino=$_POST['destino'];
if($abrg=='Internacional'){
	$cidadeorigem=$_POST['cidorigem'];
	$cidadedestino=$_POST['ciddestino'];
	}
$tiButton=utf8_encode("PASSAGEM AEREA");
$valida=0;
require("../../../../conexaomysql.php");
	$sqlInsertPas=mysql_query("INSERT INTO convpas (idproj,modal,idevento,origem,destino,cidadeorigem,cidadedestino,tipo,abrgpas,dtin,dtfim,qtd,total) VALUES ('".trim($idproj)."','".trim($tipoId)."','".trim($idEvento)."','".trim($origem)."','".trim($destino)."','".trim($cidadeorigem)."','".trim($cidadedestino)."','".trim($tipo)."','".trim($abrg)."','".trim($dtin)."','".trim($dtfim)."','".trim($qtd)."','".trim($total)."')") or die(mysql_error());
	if($sqlInsertPas){
			?>
			   <script type="text/javascript">
               alert("Inserido com sucesso!");
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
