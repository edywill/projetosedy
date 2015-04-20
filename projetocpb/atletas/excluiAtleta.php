<?php 
session_start();
//require "../conectsqlserverci.php";
require "conectAtleta.php";
$userCriac=$_SESSION['userAtleta'];
$idAtleta=$_GET['id'];
$valida=0;
$sqlDeletaAtleta=FALSE;
$sqlDeletaAtletaProjetos=FALSE;
$sqlDeletaAtletaProvas=FALSE;
$sqlDeletaAtletaMarcas=FALSE;
odbc_autocommit($conCab, FALSE);

$sqlDeletaAtleta=odbc_exec($conCab,"DELETE FROM atleta WHERE id='".$idAtleta."'") or die("Erro Atleta");
$sqlDeletaAtletaProjetos=odbc_exec($conCab,"DELETE FROM projetos WHERE atleta_id='".$idAtleta."'") or die("Erro Atleta Projeto");
$sqlDeletaAtletaProvas=odbc_exec($conCab,"DELETE FROM provasatleta WHERE atleta_id='".$idAtleta."'") or die("Erro Atleta Prova");
$sqlDeletaAtletaMarcas=odbc_exec($conCab,"DELETE FROM marcas WHERE atleta_id='".$idAtleta."'") or die("Erro Atleta Marcas");

if(!$sqlDeletaAtleta){
	$valida=1;
	}
if(!$sqlDeletaAtletaProjetos){
	$valida=1;
	}
if(!$sqlDeletaAtletaProvas){
	$valida=1;
	}
if(!$sqlDeletaAtletaMarcas){
	$valida=1;
	}
if($valida==0){
	$sqlConsIdLog=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id) AS id FROM log (nolock)"));
	$novoIdLog=$sqlConsIdLog['id']+1;
	$sqlLigaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log ON");
	$sqlLogAtleta=odbc_exec($conCab,"INSERT INTO log(id,atleta,usuario,dthora,acao) VALUES (".$novoIdLog.",".$idAtleta.",'".$userCriac."','".date("d/m/Y H:i:s")."','Exclui Atleta ID: ".$idAtleta."')");
	$sqlDesligaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log OFF");
odbc_commit($conCab);
?>
       				<script type="text/javascript">
       				alert("Excluido com sucesso");
       				window.location="index.php";
       				</script>
       				<?php
}else{
	odbc_rollback($conCab);
					?>
       				<script type="text/javascript">
       				alert("Ocorreu um erro. Tente novamente");
       				window.location="index.php";
       				</script>
       				<?php
}
?>