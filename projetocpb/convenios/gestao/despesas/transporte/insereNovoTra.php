<?php
$idproj=$_POST['idproj'];
$idEvento=$_POST['idEvento'];
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
$abrg='';
$tipo=$_POST['tipo'];
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
$qtdVeic=$_POST['qtdVeic'];
$total=$_POST['total'];
$tiButton=utf8_encode("TRANSPORTE");
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
	$sqlInsertTra=mysql_query("INSERT INTO convtra (idproj,modal,idevento,local,dtin,dtfim,total,qtddias,qtdveic,tipo,abrg) VALUES ('".trim($idproj)."','".trim($tipoId)."','".trim($idEvento)."','".trim(utf8_decode($cidade))."','".trim($dtin)."','".trim($dtfim)."','".trim($total)."','".trim($qtdDias)."','".trim($qtdVeic)."','".trim($tipo)."','".trim($abrg)."')") or die(mysql_error());
	if($sqlInsertTra){
			?>
			   <script type="text/javascript">
               alert("Inserido com sucesso!");
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
	}
?>
