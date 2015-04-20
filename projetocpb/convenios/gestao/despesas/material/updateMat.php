<?php
$idproj=$_POST['idproj'];
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
$material=$_POST['material'];
$qtd=$_POST['qtd'];
$vlunitreal=$_POST['vlunitreal'];
$totalreal=$_POST['totalreal'];
$vlunitmoeda=$_POST['vlunitmoeda'];
$totalmoeda=$_POST['totalmoeda'];
$moeda=$_POST['moeda'];
$txcamb=$_POST['txcamb'];
$dtcotacao=$_POST['dtcotacao'];
$tipo=$_POST['tipo'];
$tiButton=utf8_encode("MATERIAL");
$valida=0;
require("../../../../conexaomysql.php");
if(empty($material)){
				?>
			   <script type="text/javascript">
               alert("Preencha os campos com valores válidos.");
               history.back();
               </script>
               <?php
			   $valida=1;
	}else{
	$sqlUpdMat=mysql_query("UPDATE convmat SET idproj='".trim($idproj)."',modal='".trim($tipoId)."',tipo='".trim($tipo)."',descricao='".trim(utf8_decode($material))."',qtd='".trim($qtd)."',vlunitreal='".trim($vlunitreal)."',vlunitmoeda='".trim($vlunitmoeda)."',totalmoeda='".trim($totalmoeda)."',totalreal='".trim($totalreal)."',txcamb='".trim($txcamb)."',moeda='".trim($moeda)."',dtcotacao='".trim($dtcotacao)."' WHERE id='".$_POST['idMat']."'") or die(mysql_error());
	if($sqlUpdMat){
			?>
			   <script type="text/javascript">
               alert("Atualizado com sucesso!");
                window.location=<?php echo "'../material.php?id=$idproj&idmd=$tipoId&titmod=$titMod&desp=mat&edit=$tiButton'";?>;
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