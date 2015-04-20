<?php
$idEvento=$_POST['idevento'];
$idproj=$_POST['idproj'];
$tipoId=$_POST['tipoId'];
$tipoLoc=$_POST['tipoLoc'];
$nome=utf8_decode($_POST['nome']);

$uf='';
if($tipoLoc=='nac'){
$uf=$_POST['uf'];
$cidade=utf8_decode($_POST['cidade']);
}
$dtinicio=$_POST['dtinicio'];
$dtfim=$_POST['dtfim'];
$pais='BR';
if($tipoLoc=='inter'){
$pais=$_POST['pais'];
$cidade=utf8_decode($_POST['cidint']);
}

$valida=0;
require("../../../conexaomysql.php");
if(empty($nome)){
				?>
			   <script type="text/javascript">
               alert("Preencha o nome do evento.");
               history.back();
               </script>
               <?php
			   $valida=1;
	}else{
	$sqlInsertEvento=mysql_query("UPDATE conveventos SET idproj='".trim($idproj)."',modal='".trim($tipoId)."',nome='".trim($nome)."',cidade='".trim($cidade)."',uf='".trim($uf)."',pais='".trim($pais)."',dtinicio='".trim($dtinicio)."',dtfim='".trim($dtfim)."',tipoloc='".trim($tipoLoc)."' WHERE id='".$idEvento."'") or die(mysql_error());
	if($sqlInsertEvento){
			?>
			   <script type="text/javascript">
               alert("Atualizado com sucesso!");
              window.location='listaEventos.php';
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
