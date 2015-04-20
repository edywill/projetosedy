<?php 
session_start();
require "../../conect.php";
require "../../conectsqlserverci.php";
	$userCriac=$_SESSION['userAquis'];
	$countError=0;
	$errorMsg='';
	$valida=0;
    extract($_GET);
//echo $grupo;
//echo $cigam;
//echo $nome;
//echo $criar;
if(empty($grupo) || $grupo==0){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']:Informe o grupo de despesa.<br>';
	}
if(empty($nome)){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']:Informe um nome para o material.<br>';
	}
if(empty($cigam)){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']:Informe o material referência do CIGAM.<br>';
	}
	$cigam=trim($cigam);
$arrayCigam=explode("-",$cigam);
if(!is_numeric($arrayCigam[0])){
	$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']:Material informado inválido. Seleciona na lista.<br>';
	}else{
		$sqlMaterialCigam=odbc_exec($conCab,"SELECT Descricao
FROM ESMATERI (nolock) 
WHERE Cd_reduzido='".$arrayCigam[0]."'");
		$countMaterialCigam=odbc_num_rows($sqlMaterialCigam);
if($countMaterialCigam<1){
	$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']:Material não possui referencia no CIGAM.<br>';
	}
		}
if($valida==0){
	if($criar==0){
		$sqlRepetido=mysql_num_rows(mysql_query("SELECT id FROM aquicadmat WHERE grupo='".$grupo."' AND cdmat='".$arrayCigam[0]."' AND nome='".$nome."'"));
	if($sqlRepetido>0){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']:Material já cadastrado com os dados informados.<br>';
		}else{
	$insertMaterial=mysql_query("INSERT INTO aquicadmat (grupo,cdmat,nome,inativo) VALUES ('".$grupo."','".$arrayCigam[0]."','".utf8_decode($nome)."',0)");
	$insertLog=mysql_query("INSERT INTO aquilog VALUES('','".date("d/m/Y H:i:s")."','M','".$userCriac."','Inserido Material ".$nome."')");
	if(!$insertMaterial){
			$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']:Problema ao inserir o registro. '.mysql_error().'<br>';
			}
	}
	}else{
		$updateMaterial=mysql_query("UPDATE aquicadmat SET grupo='".$grupo."',nome='".utf8_decode($nome)."',cdmat='".$arrayCigam[0]."' where id='".$criar."'");
		$insertLog=mysql_query("INSERT INTO aquilog VALUES ('','".date("d/m/Y H:i:s")."','M','".$userCriac."','Alterado Material ".$nome."')") or die(mysql_error());
		
		if(!$updateMaterial){
			$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']:Problema ao atualizar o registro. '.mysql_error().'<br>';
			}
		}
}
if($valida==1)
{
	echo $errorMsg;
		}else{
		$_SESSION['idGrupoSession']=$grupo;
		$sqlDadoGrupo=mysql_fetch_array(mysql_query("SELECT * FROM aquigrupo WHERE id='".$grupo."'"));
				$_SESSION['dadosGrupoSession']=$sqlDadoGrupo['codigo'].'-'.utf8_encode($sqlDadoGrupo['descricao']);
		echo "1";
		}
?>