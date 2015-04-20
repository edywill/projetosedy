<?php 
date_default_timezone_set('America/Sao_Paulo');
if($_SESSION['abrangenciaSav']=='Nacional'){
		include "calcularDiariasNac.php";	
	 }else{
		 include "calcularDiariasInt.php";	
		 }
//Guarda os valores para criação da CI
$setor="";
if($valida==0){
	//Busca dados Funcionários
	include "buscaDadosFunc.php";
$toperacao=str_pad("200", 5, " ", STR_PAD_RIGHT);
$tgCigam="0";
$unidadeNeg="001";
$controle="03";
$cidadeUf='';
  //Se não houver CI (criação)
  if(empty($numCi)){
	//Cria a CI e os itens no CIGAM
	include "criarCi.php";
	if(!$resCriaCi){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Problema ao criar a CI.\\n';
	}else{
		//Cria acompanhamento da Capa da CI
		include "criaAcompCi.php";
		//Criar itens
		 $quantidade=1;
		 $unidadeMedida='';
		 $descMaterial='';
		 $sqlConsIncIpi="Select
					  GETOPERA.Incidencia_ipi,
					  GETOPERA.Pe_ipi
					From
					  GETOPERA (nolock)
					  Where Cd_tipo_operaca='".$toperacao."'";
	$resConsIncIpi = odbc_exec($conCab2, $sqlConsIncIpi) or die("<p>".odbc_errormsg());
	$arrayConsIncIpi = odbc_fetch_array($resConsIncIpi);
$incidenciaIPI=$arrayConsIncIpi['Incidencia_ipi'];
$peIPI=0;
//Verifica a abrangencia para internacional ou nacional
		
		if($_SESSION['abrangenciaSav']=='Nacional'){
					include "criacaoNacional.php";
		}
		//Abrangencia Internacional
		elseif($_SESSION['abrangenciaSav']=='Internacional'){
			//criacao Internacional
		include "criacaoInternacional.php";
		}
	}

}else{
	//Atualiza a CI com os dados informados
	include "atualizaCi.php";
	if(!$resAtCi){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Problema ao atualizar a CI.\\n';
	}else{
		//AtualizaAcompanhamento
	include "atualizaAcomp.php";	
	$quantidade=1;
		 $unidadeMedida='';
		 $descMaterial='';
		 $sqlConsIncIpi="Select
					  GETOPERA.Incidencia_ipi,
					  GETOPERA.Pe_ipi
					From
					  GETOPERA (nolock)
					  Where Cd_tipo_operaca='".$toperacao."'";
		$resConsIncIpi = odbc_exec($conCab2, $sqlConsIncIpi) or die("<p>".odbc_errormsg());
		$arrayConsIncIpi = odbc_fetch_array($resConsIncIpi);
		$incidenciaIPI=$arrayConsIncIpi['Incidencia_ipi'];
		$peIPI=0;
	  }
	include "atualizacaoSav.php";
	//echo "Atualiza";
	}
 }
?>