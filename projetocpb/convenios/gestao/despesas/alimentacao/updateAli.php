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
$vljant=$_POST['vljant'];
$vlalm=$_POST['vlalm'];
$vlamb=$_POST['vlambos'];
$qtdref=$_POST['qtdref'];
$total=$_POST['total'];
$tiButton=utf8_encode("ALIMENTA&Ccedil;&Atilde;O");
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
		
	$sqlUpdAli=mysql_query("UPDATE convali SET local='".trim(utf8_decode($cidade))."',dtin='".trim($dtin)."',dtfim='".trim($dtfim)."',qtdpes='".trim($qtdPes)."',qtdref='".trim($qtdref)."',alm='".trim($alm)."',jan='".trim($jant)."',total='".trim($total)."',qtddias='".trim($qtdDias)."',vljant='".trim($vljant)."',vlalm='".trim($vlalm)."',vlambos='".trim($vlamb)."' WHERE id='".$_POST['idAli']."'") or die(mysql_error());
	
	if($sqlUpdAli){
			?>
			   <script type="text/javascript">
               alert("Atualizado com sucesso!");
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
