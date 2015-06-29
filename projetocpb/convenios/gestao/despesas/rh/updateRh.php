<?php
$idproj=$_POST['idproj'];
$idEvento=$_POST['idEvento'];
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
$idRh=$_POST['idRh'];
$idcargo=$_POST['cargo'];
$qtdpes=$_POST['qtdpes'];
$qtdtem=$_POST['qtdtem'];
$um=utf8_decode($_POST['um']);
$vlunit=$_POST['vlunit'];
$tributos=$_POST['tributo'];
$total=$_POST['total'];
$tcont=$_POST['tcont'];
$valida=0;
require("../../../../conexaomysql.php");
if($idcargo=='0' || empty($qtdpes) || empty($qtdtem)|| empty($vlunit)){
				?>
			   <script type="text/javascript">
               alert("Todos os campos são obrigatórios.");
               history.back();
               </script>
               <?php
			   $valida=1;
	}else{
		
	$sqlUpdRhPem=mysql_query("UPDATE convrh SET idproj='".trim($idproj)."', modal='".trim($tipoId)."', idcargo='".trim($idcargo)."',tcont='".trim($tcont)."',qtdpes='".trim($qtdpes)."',qtdtem='".trim($qtdtem)."',um='".trim($um)."',vlunit='".trim($vlunit)."',tributos='".trim($tributos)."',total='".trim($total)."' WHERE id='".$_POST['idRh']."'") or die(mysql_error());
	
	if($sqlUpdRhPem){
			?>
			   <script type="text/javascript">
               alert("Atualizado com sucesso!");
                window.location=<?php echo "'../projec.php?id=$idproj&idmd=$tipoId&idev=$idEvento&titmod=$titMod&desp=rht&edit=RH DO EVENTO'";?>;
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
