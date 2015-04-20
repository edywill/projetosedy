<?php 
session_start();
//require "../conectsqlserverci.php";
require "conectAtleta.php";
$userCriac=$_SESSION['userAtleta'];
$idAtleta=$_SESSION['idAtletaSession'];
$_SESSION['projAtDescSession']=$_POST['projeto'];
$_SESSION['projVlDescSession']=$_POST['vlproj'];
$valida=0;
$countError=0;
$errorMsg='';
if(empty($_POST['projeto'])){
	$valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Informe o nome do projeto.\\n';
	}
if(empty($_POST['vlproj'])){
	$valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Informe o valor do projeto.\\n';
	}
if($valida==0){
$consultaProjeto=odbc_num_rows(odbc_exec($conCab,"SELECT id FROM projetos (nolock) WHERE descproje LIKE '".trim($_POST['projeto'])."' AND atleta_id='".$idAtleta."' AND valor='".$_POST['vlproj']."'"));
  if($consultaProjeto>0){
    $valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Projeto cadastrado para esse atleta.\\n';
  }
}
if($valida==0){
				$sqlConsIdProjAt=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id) AS id FROM projetos (nolock)"));
				$novoIdProjAt=$sqlConsIdProjAt['id']+1;
				$sqlLigaIdProjAt=odbc_exec($conCab,"SET IDENTITY_INSERT projetos ON");
				$sqlInsereProjAtleta=odbc_exec($conCab,"INSERT INTO projetos(id,atleta_id,descproje,valor) VALUES (".$novoIdProjAt.",'".$idAtleta."','".trim(utf8_decode($_POST['projeto']))."','".$_POST['vlproj']."')");
				$sqlDesligaIdProjAt=odbc_exec($conCab,"SET IDENTITY_INSERT projetos OFF");
if(!$sqlInsereProjAtleta){
	$valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Ocorreu um erro ao cadatrar. Tente novamente.\\n';
	}
}

if($valida==0){
	$sqlConsIdLog=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id) AS id FROM log (nolock)"));
	$novoIdLog=$sqlConsIdLog['id']+1;
	$sqlLigaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log ON");
	$sqlLogAtleta=odbc_exec($conCab,"INSERT INTO log(id,atleta,usuario,dthora,acao) VALUES (".$novoIdLog.",".$idAtleta.",'".$userCriac."','".date("d/m/Y H:i:s")."','Insere projeto : ".utf8_decode($_POST['projeto'])."')");
	$sqlDesligaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log OFF");
	$_SESSION['projAtDescSession']='';
	$_SESSION['projVlDescSession']='';
?>
       				<script type="text/javascript">
       				alert("Incluido com sucesso");
       				window.location="cadastraProvas.php";
       				</script>
       				<?php
}else{
					?>
       				<script type="text/javascript">
       				alert("<?php echo $errorMsg; ?>");
       				window.location="cadastraProvas.php";
       				</script>
       				<?php
}
?>