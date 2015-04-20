<?php
$idproj=$_POST['idproj'];
$tipoId=$_POST['tipoId'];
$nome=utf8_decode($_POST['nome']);
$tipoLoc=$_POST['tipoLoc'];
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
	$sqlInsertEvento=mysql_query("INSERT INTO conveventos (idproj,modal,nome,cidade,uf,pais,dtinicio,dtfim,tipoloc) VALUES ('".trim($idproj)."','".trim($tipoId)."','".trim($nome)."','".trim($cidade)."','".trim($uf)."','".trim($pais)."','".trim($dtinicio)."','".trim($dtfim)."','".trim($tipoLoc)."')") or die(mysql_error());
	if($sqlInsertEvento){
			?>
			   <script type="text/javascript">
               alert("Inserido com sucesso!");
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
