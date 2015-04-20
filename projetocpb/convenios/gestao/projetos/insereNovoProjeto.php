<?php
$titulo=utf8_decode($_POST['titulo']);
$nconv=$_POST['nconv'];
$nprop=$_POST['nprop'];
$inicvig=$_POST['inicvig'];
$fimvig=$_POST['fimvig'];
$valida=0;
require("../../../conexaomysql.php");
if(empty($titulo)){
				?>
			   <script type="text/javascript">
               alert("Preencha o t\u00edtulo.");
               history.back();
               </script>
               <?php
			   $valida=1;
	}else{
	$sqlInsertProjeto=mysql_query("INSERT INTO convprojetos (titulo,numconv,numprop,iniciovig,fimvig) VALUES ('".trim($titulo)."','".trim($nconv)."','".trim($nprop)."','".trim($inicvig)."','".trim($fimvig)."')") or die(mysql_error());
	if($sqlInsertProjeto){
			?>
			   <script type="text/javascript">
               alert("Inserido com sucesso!");
               window.location='../gestConv.php';
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
