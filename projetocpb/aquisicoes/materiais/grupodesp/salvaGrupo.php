<?php 
session_start();
require "../../../conect.php";
	$userCriac=$_SESSION['userAquis'];
	$countError=0;
	$errorMsg='';
	$valida=0;
$codigo=$_POST['codigo'];
$descricao=utf8_decode($_POST['descricao']);
$tipo=$_POST['criar'];
if(empty($codigo)){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']:Informe o codigo do grupo de despesa.\\n';
	}
	if(empty($descricao) || strlen($descricao)<4){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']:Informe a descricao para grupo, com pelo menos 4 caracteres.\\n';
	}
	
if($valida==0 && $tipo==0){
	$insertGrupo=mysql_query("INSERT INTO aquigrupo (codigo,descricao,inativo) VALUES ('".$codigo."','".$descricao."',0)");
	$insertLog=mysql_query("INSERT INTO aquilog VALUES('','".date("d/m/Y H:i:s")."','G','".$userCriac."','Criado Grupo de Despesa ".$codigo."-".$descricao."')");
	if(!$insertGrupo){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']:Problema ao inserir o registro. '.mysql_error().'\\n';
	}
	}else{
		$updateGrupo=mysql_query("UPDATE aquigrupo SET codigo='".$codigo."',descricao='".$descricao."' where id='".$tipo."'");
		$insertLog=mysql_query("INSERT INTO aquilog VALUES ('','".date("d/m/Y H:i:s")."','G','".$userCriac."','Alterado Grupo de Despesa para ".$codigo."-".$descricao."')") or die(mysql_error());
		if(!$updateGrupo){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']:Problema ao atualizar o registro. '.mysql_error().'\\n';
	}
		}

if($valida==1)
{
	?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="novoGrupo.php";
       </script>
       <?php
		}else{
		?>
        <script type="text/javascript">
       alert("Processado com sucesso!");
       window.location="index.php";
       </script>
        <?php
		}
?>