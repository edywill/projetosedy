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
$tipo=$_POST['tipo'];
$dtcotacao=$_POST['dtcotacao'];
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
	$sqlInsertMat=mysql_query("INSERT INTO convmat (idproj,modal,descricao,qtd,vlunitreal,vlunitmoeda,totalmoeda,totalreal,txcamb,moeda,dtcotacao) VALUES ('".trim($idproj)."','".trim($tipoId)."','".trim(utf8_decode($material))."','".trim($qtd)."','".trim($vlunitreal)."','".trim($vlunitmoeda)."','".trim($totalmoeda)."','".trim($totalreal)."','".trim($txcamb)."','".trim($moeda)."','".trim($dtcotacao)."')") or die(mysql_error());
	if($sqlInsertMat){
			?>
			   <script type="text/javascript">
               alert("Inserido com sucesso!");
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
