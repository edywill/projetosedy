<?php 
session_start();
//require "../conectsqlserverci.php";
require "conectAtleta.php";
$userCriac=$_SESSION['userAtleta'];
$idAtleta=$_SESSION['idAtletaSession'];
$sqlNomeProva=odbc_fetch_array(odbc_exec($conCab,"SELECT nome FROM prova(nolock) WHERE id='".$_POST['provAtleta']."'"));
$_SESSION['provAtSession']=$_POST['provAtleta'];
$_SESSION['provAtDescSession']=$sqlNomeProva['nome'];
$consultaProvas=odbc_num_rows(odbc_exec($conCab,"SELECT id FROM provasatleta (nolock) WHERE prova_id='".$_POST['provAtleta']."' AND atleta_id='".$idAtleta."'"));
if($consultaProvas<1){
				$sqlConsIdProvaAt=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id) AS id FROM provasatleta (nolock)"));
				$novoIdProvaAt=$sqlConsIdProvaAt['id']+1;
				$sqlLigaIdPrAt=odbc_exec($conCab,"SET IDENTITY_INSERT provasatleta ON");						
				$sqlInsereProvaAtleta=odbc_exec($conCab,"INSERT INTO provasatleta(id,prova_id,atleta_id) VALUES (".$novoIdProvaAt.",'".$_POST['provAtleta']."','".$idAtleta."')");
				$sqlDesligaIdPrAt=odbc_exec($conCab,"SET IDENTITY_INSERT provasatleta OFF");
				
if($sqlInsereProvaAtleta){
	$sqlConsIdLog=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id) AS id FROM log (nolock)"));
	$novoIdLog=$sqlConsIdLog['id']+1;
	$sqlLigaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log ON");
	$sqlLogAtleta=odbc_exec($conCab,"INSERT INTO log(id,atleta,usuario,dthora,acao) VALUES (".$novoIdLog.",".$idAtleta.",'".$userCriac."','".date("d/m/Y H:i:s")."','Insere prova ID ".$_POST['provAtleta']."')");
	$sqlDesligaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log OFF");
$_SESSION['provAtSession']='';
$_SESSION['provAtDescSession']='';
?>
       				<script type="text/javascript">
       				alert("Incluido com sucesso");
       				window.location="cadastraProvas.php";
       				</script>
       				<?php
}else{
					?>
       				<script type="text/javascript">
       				alert("Ocorreu um erro. Tente novamente");
       				window.location="cadastraProvas.php";
       				</script>
       				<?php
}
}else{
					?>
       				<script type="text/javascript">
       				alert("Prova encontra-se cadastrada para esse atleta.");
       				window.location="cadastraProvas.php";
       				</script>
       				<?php
	}
?>