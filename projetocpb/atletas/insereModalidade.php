<?php 
session_start();
//require "../conectsqlserverci.php";
require "conectAtleta.php";
$userCriac=$_SESSION['userAtleta'];
$valida=0;
$countError=0;
$errorMsg='';
if(empty($_POST['descricao'])){
	$valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Informe o nome da modalidade.\\n';
	}
if($valida==0){
$consultaMod=odbc_num_rows(odbc_exec($conCab,"SELECT id FROM modalidade (nolock) WHERE descricao LIKE '".trim($_POST['descricao'])."'"));
  if($consultaMod>0){
    $valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Modalidade cadastrada.\\n';
  }
}
if($valida==0){
				$sqlConsIdMod=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id) AS id FROM modalidade (nolock)"));
				$novoIdMod=$sqlConsIdMod['id']+1;
				$sqlLigaIdMod=odbc_exec($conCab,"SET IDENTITY_INSERT modalidade ON");
				$sqlInsereMod=odbc_exec($conCab,"INSERT INTO modalidade(id,descricao) VALUES (".$novoIdMod.",'".trim(utf8_decode($_POST['descricao']))."')");
				$sqlDesligaIdMod=odbc_exec($conCab,"SET IDENTITY_INSERT modalidade OFF");
if(!$sqlInsereMod){
	$valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Ocorreu um erro ao cadatrar. Tente novamente.\\n';
	}
}

if($valida==0){
	$sqlConsIdLog=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id) AS id FROM log (nolock)"));
	$novoIdLog=$sqlConsIdLog['id']+1;
	$sqlLigaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log ON");
	$sqlLogAtleta=odbc_exec($conCab,"INSERT INTO log(id,atleta,usuario,dthora,acao) VALUES (".$novoIdLog.",0,'".$userCriac."','".date("d/m/Y H:i:s")."','Insere modalidade : ".utf8_decode($_POST['descricao'])."')");
	$sqlDesligaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log OFF");
?>
       				<script type="text/javascript">
       				alert("Incluido com sucesso");
       				window.location="modalidades.php";
       				</script>
       				<?php
}else{
					?>
       				<script type="text/javascript">
       				alert("<?php echo $errorMsg; ?>");
       				window.location="modalidades.php";
       				</script>
       				<?php
}
?>