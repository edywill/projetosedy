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
$qtdPes=$_POST['qtdPes'];
$alm=0;
$jant=0;
if(isset($_POST['alm'])){
	$alm=1;
	}
if(isset($_POST['jant'])){
	$jant=1;
	}
$qtdref=$_POST['qtdref'];
$total=$_POST['total'];
$tiButton=utf8_encode("ALIMENTA&Ccedil;&Atilde;O");
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
	$sqlInsertAli=mysql_query("INSERT INTO convali (idproj,modal,idevento,local,dtin,dtfim,qtdpes,qtdref,alm,jan,ambos,total,qtddias,abrg) VALUES ('".trim($idproj)."','".trim($tipoId)."','".trim($idEvento)."','".trim(utf8_decode($cidade))."','".trim($dtin)."','".trim($dtfim)."','".trim($qtdPes)."','".trim($qtdref)."','".trim($alm)."','".trim($jant)."','1','".trim($total)."','".trim($qtdDias)."','".trim($abrg)."')") or die(mysql_error());
	if($sqlInsertAli){
			?>
			   <script type="text/javascript">
               alert("Inserido com sucesso!");
                window.location=<?php echo "'../projec.php?id=$idproj&idmd=$tipoId&idev=$idEvento&titmod=$titMod&desp=ali&edit=$tiButton'";?>;
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
