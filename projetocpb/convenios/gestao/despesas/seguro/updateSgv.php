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
$vlperi=$_POST['vlperi'];
$total=$_POST['total'];
$tiButton=utf8_encode("SEGURO VIAGEM");
$valida=0;
require("../../../../conexaomysql.php");
if(empty($cidade)){
				?>
			   <script type="text/javascript">
               alert("Preencha todos os campos com valores válidos.");
               history.back();
               </script>
               <?php
			   $valida=1;
	}else{
		
	$sqlUpdTra=mysql_query("UPDATE convsgv SET local='".trim(utf8_decode($cidade))."',dtin='".$dtin."',dtfim='".$dtfim."',qtdpes='".trim($qtdPes)."',total='".trim($total)."',qtddias='".trim($qtdDias)."',abrg='".$abrg."',vlperi='".trim($vlperi)."' WHERE id='".$_POST['idSgv']."'") or die(mysql_error());
	
	if($sqlUpdTra){
			?>
			   <script type="text/javascript">
               alert("Atualizado com sucesso!");
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
