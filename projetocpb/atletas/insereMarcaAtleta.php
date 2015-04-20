<?php 
session_start();
//require "../conectsqlserverci.php";
require "conectAtleta.php";
$userCriac=$_SESSION['userAtleta'];
$idAtleta=$_SESSION['idAtletaSession'];
$sqlNomeProva=odbc_fetch_array(odbc_exec($conCab,"SELECT nome FROM prova (nolock) WHERE id='".$_POST['provaMarca']."'"));
$_SESSION['provMaSession']=$_POST['provaMarca'];
$_SESSION['provMaDescSession']=$sqlNomeProva['nome'];
$_SESSION['anoMarcSession']=$_POST['ano'];
$_SESSION['marcaAtSession']=$_POST['marca'];
$_SESSION['posMarcSession']=$_POST['posicao'];
$valida=0;
$countError=0;
$errorMsg='';
if($_POST['provaMarca']=='0'){
	$valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Informe a prova.\\n';
	}
if(empty($_POST['ano'])){
	$valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Informe o ano.\\n';
	}
if(empty($_POST['marca']) || empty($_POST['posicao'])){
	$valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Informe a marca ou o ranking.\\n';
	}
if($valida==0){
$sqlConsMarca=odbc_exec($conCab,"SELECT ano FROM marcas (nolock) WHERE ano='".trim($_POST['ano'])."' AND atleta_id='".$idAtleta."' AND prova_id='".$_POST['provaMarca']."'");
$consultaMarca=odbc_num_rows($sqlConsMarca);
  if($consultaMarca>0){
    $valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Marca cadastrada para esse atleta.\\n';
  }
}
if(!isset($_POST['tipo'])){
	$valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Escolha o tipo de marca.\\n';
	}
if($valida==0){
	$marcaAt=str_replace(",",".",$_POST['marca']);
	$tipoMarca='m';
	if($_POST['tipo']=='tempo'){
		$marcaAt=str_replace(":","",str_replace(".","",$_POST['marca']));
		$tipoMarca='t';
		}
$sqlInsereMarcaAtleta=odbc_exec($conCab,"INSERT INTO marcas(prova_id,atleta_id,ano,marca,posicao,tipo) VALUES ('".$_POST['provaMarca']."','".$idAtleta."','".trim($_POST['ano'])."','".$marcaAt."','".$_POST['posicao']."','".$tipoMarca."')") or die("<p>".odbc_errormsg());
if(!$sqlInsereMarcaAtleta){
	$valida=1;
	$countError++;
	$errorMsg.='Erro['.$countError.']: Ocorreu um erro ao cadatrar. Tente novamente.\\n';
	}
}

if($valida==0){
	$sqlConsIdLog=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id) AS id FROM log (nolock)"));
	$novoIdLog=$sqlConsIdLog['id']+1;
	$sqlLigaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log ON");
	$sqlLogAtleta=odbc_exec($conCab,"INSERT INTO log(id,atleta,usuario,dthora,acao) VALUES (".$novoIdLog.",".$idAtleta.",'".$userCriac."','".date("d/m/Y H:i:s")."','Marca inserida Prova : ".utf8_encode($sqlNomeProva['nome'])." Ano: ".$_POST['ano']."')");
	$sqlDesligaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log OFF");
	$_SESSION['provMaDescSession']='';
	$_SESSION['provMaSession']='';
	$_SESSION['anoMarcSession']='';
	$_SESSION['marcaAtSession']='';
	$_SESSION['posMarcSession']='';
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