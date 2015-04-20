<?php 
session_start();
//require "../conectsqlserverci.php";
require "conectAtleta.php";
$userCriac=$_SESSION['userAtleta'];
$valida=0;
$countError=0;
$errorMsg='';
if($_POST['modalidade']=='0'){
	$valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Selecione a modalidade.\\n';
	}
if(empty($_POST['descricao'])){
	$valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Informe o nome da prova.\\n';
	}
if($valida==0){
$consultaProv=odbc_num_rows(odbc_exec($conCab,"SELECT id FROM prova (nolock) WHERE nome LIKE '".trim($_POST['descricao'])."' AND modalidade_id='".$_POST['modalidade']."'"));
  if($consultaProv>0){
    $valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Prova cadastrada.\\n';
  }
}
if($valida==0){
				$sqlConsIdProv=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id) AS id FROM prova (nolock)"));
				$novoIdProv=$sqlConsIdProv['id']+1;
				$sqlLigaIdProv=odbc_exec($conCab,"SET IDENTITY_INSERT prova ON");
				$sqlInsereProv=odbc_exec($conCab,"INSERT INTO prova(id,modalidade_id,nome) VALUES (".$novoIdProv.",'".$_POST['modalidade']."','".trim(utf8_decode($_POST['descricao']))."')");
				$sqlDesligaIdProv=odbc_exec($conCab,"SET IDENTITY_INSERT prova OFF");
if(!$sqlInsereProv){
	$valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Ocorreu um erro ao cadatrar. Tente novamente.\\n';
	}
}

if($valida==0){
	$sqlConsIdLog=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id) AS id FROM log (nolock)"));
	$novoIdLog=$sqlConsIdLog['id']+1;
	$sqlLigaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log ON");
	$sqlLogAtleta=odbc_exec($conCab,"INSERT INTO log(id,atleta,usuario,dthora,acao) VALUES (".$novoIdLog.",0,'".$userCriac."','".date("d/m/Y H:i:s")."','Insere Prova : ".utf8_decode($_POST['descricao'])."')");
	$sqlDesligaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log OFF");
?>
       				<script type="text/javascript">
       				alert("Incluido com sucesso");
       				window.location="provas.php";
       				</script>
       				<?php
}else{
					?>
       				<script type="text/javascript">
       				alert("<?php echo $errorMsg; ?>");
       				window.location="provas.php";
       				</script>
       				<?php
}
?>