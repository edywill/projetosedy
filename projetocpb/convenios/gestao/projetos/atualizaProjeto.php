<?php
$id=$_POST['id'];
$titulo=$_POST['titulo'];
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
	$sqlUpdateProjeto=mysql_query("UPDATE convprojetos SET titulo='".trim(utf8_decode($titulo))."',numconv='".trim($nconv)."',numprop='".trim($nprop)."',iniciovig='".trim($inicvig)."',fimvig='".trim($fimvig)."' WHERE id='".$id."'") or die(mysql_error());
	if($sqlUpdateProjeto){
			?>
			   <script type="text/javascript">
               alert("Atualizado com sucesso!");
               window.location="indexProjeto.php?id=<?php echo $id; ?>";
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
