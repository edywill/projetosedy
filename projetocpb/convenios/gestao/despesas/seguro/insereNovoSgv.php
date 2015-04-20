<?php
$idproj=$_POST['idproj'];
$idEvento=$_POST['idEvento'];
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];

$cidade=$_POST['cidade'];
$cidadeDestino=$_POST['cidadedestino'];
if($_POST['abrg']=='Nacional'){
	$abrg='nac';
	}else{
		$abrg='inter';
		$cidade=$cidadeDestino."/".$cidade;
		}
$dtin=$_POST['dtinicio'];
$dtfim=$_POST['dtfim'];
$qtdDias=$_POST['qtdDias'];
$qtdPes=$_POST['qtdPes'];
$total=$_POST['total'];
$tiButton=utf8_encode("SEGURO VIAGEM");
$valida=0;
require("../../../../conexaomysql.php");
if(empty($cidade)){
				?>
			   <script type="text/javascript">
               alert("Preencha os campos com valores válidos.");
               history.back();
               </script>
               <?php
			   $valida=1;
	}else{
	$sqlInsertSgv=mysql_query("INSERT INTO convsgv (idproj,modal,idevento,local,dtin,dtfim,total,qtddias,qtdpes,abrg) VALUES ('".trim($idproj)."','".trim($tipoId)."','".trim($idEvento)."','".trim(utf8_decode($cidade))."','".trim($dtin)."','".trim($dtfim)."','".trim($total)."','".trim($qtdDias)."','".trim($qtdPes)."','".trim($abrg)."')") or die(mysql_error());
	if($sqlInsertSgv){
			?>
			   <script type="text/javascript">
               alert("Inserido com sucesso!");
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
	}
?>
