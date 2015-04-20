<?php
$idproj=$_POST['idproj'];
$idEvento=$_POST['idEvento'];
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
$abrg='';
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
$tipo=$_POST['tipo'];
$tiButton=utf8_encode("TRANSPORTE");
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
		
	$sqlUpdTra=mysql_query("UPDATE convtra SET local='".trim($cidade)."',dtin='".$dtin."',dtfim='".$dtfim."',qtdveic='".trim($qtdVeic)."',total='".trim($total)."',qtddias='".trim($qtdDias)."',tipo='".trim($tipo)."',abrg='".trim($abrg)."' WHERE id='".$_POST['idTra']."'") or die(mysql_error());
	
	if($sqlUpdTra){
			?>
			   <script type="text/javascript">
               alert("Atualizado com sucesso!");
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
