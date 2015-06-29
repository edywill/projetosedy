<?php
$idproj=$_POST['idproj'];
$idEvento=$_POST['idEvento'];
$tipoId=$_POST['tipoId'];
$titMod=$_POST['titMod'];
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
	$sqlInsertRhPem=mysql_query("INSERT INTO convrh (idproj,modal,idevento,idcargo,tcont,qtdpes,qtdtem,um,vlunit,tributos,total) VALUES ('".trim($idproj)."','".trim($tipoId)."','".trim($idEvento)."','".trim($idcargo)."','".trim($tcont)."','".trim($qtdpes)."','".trim($qtdtem)."','".trim($um)."','".trim($vlunit)."','".trim($tributos)."','".trim($total)."')") or die(mysql_error());
	if($sqlInsertRhPem){
			?>
			   <script type="text/javascript">
               alert("Inserido com sucesso!");
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
