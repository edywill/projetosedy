<?php
$idproj=$_POST['idproj'];
$idEvento=$_POST['idEvento'];
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];

$cidade=$_POST['cidade'];
$cidadestino=$_POST['cidadedestino'];
$abrg='';
if($_POST['abrg']=='Nacional'){
	$abrg='nac';
	}else{
		$abrg='inter';
		$cidade=$cidadestino."/".$cidade;
		}
$dtin=$_POST['dtinicio'];
$dtfim=$_POST['dtfim'];
$qtdDias=$_POST['qtdDias'];
$qtdPes=$_POST['qtdPes'];
$qtdSingle=$_POST['qtdSingle'];
$qtdDuplo=$_POST['qtdDuplo'];
$vlunits=$_POST['vlunits'];
$vlunitd=$_POST['vlunitd'];

$total=$_POST['total'];
$tiButton=utf8_encode("HOSPEDAGEM");
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
	$sqlInsertPas=mysql_query("INSERT INTO convhos (idproj,modal,idevento,local,abrg,dtin,dtfim,qtdpes,total,qtddias,qtdsingle,qtdduplo,vlunits,vlunitd) VALUES ('".trim($idproj)."','".trim($tipoId)."','".trim($idEvento)."','".trim(utf8_decode($cidade))."','".trim($abrg)."','".trim($dtin)."','".trim($dtfim)."','".trim($qtdPes)."','".trim($total)."','".trim($qtdDias)."','".trim($qtdSingle)."','".trim($qtdDuplo)."','".trim($vlunits)."','".trim($vlunitd)."')") or die(mysql_error());
	if($sqlInsertPas){
			?>
			   <script type="text/javascript">
               alert("Inserido com sucesso!");
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
	}
?>
