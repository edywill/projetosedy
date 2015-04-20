<?php
$campo = $_GET['campo'];
$valor = $_GET['valor'];
require "../conectsqlserverci.php";

// Verificando a Conta Financeira
if ($campo == "contaF") {
    $valor=str_replace(".","",$valor);
	$sqlConsContaF="select *
			  from GFCONTA (nolock)
			  WHERE cd_conta='".$valor."'";
	$rsConsContaF = odbc_exec($conCab,$sqlConsContaF) or die(odbc_error());
	$arrayConsContaF = odbc_fetch_array($rsConsContaF);
	$contarConsContaF=odbc_num_rows($rsConsContaF);
	$sqlConsContaFAtivo="select 1
			  from GFCONTA (nolock) 
			  where ativo = 1 AND 
			  cd_conta='".$valor."'";
	$rsConsContaFAtivo = odbc_exec($conCab,$sqlConsContaFAtivo) or die(odbc_error());
	$contarConsContaFAtivo=odbc_num_rows($rsConsContaFAtivo);
	$sqlConsContaFAnalitico="select 1
			  from GFCONTA (nolock) 
			  WHERE
			  tipo_conta = 'A' AND 
			  cd_conta='".$valor."'";
	$rsConsContaFAnalitico = odbc_exec($conCab,$sqlConsContaFAnalitico) or die(odbc_error());
	$contarConsContaFAnalitico=odbc_num_rows($rsConsContaFAnalitico);
	if ($valor == "") {
		echo "";
	}elseif(empty($contarConsContaF)){
		echo "<strong>Erro:</strong> Conta Financeira Inválida.";
		}elseif(empty($contarConsContaFAtivo)){
			echo "<strong>Erro:</strong> Conta Financeira Inativa.";
			}elseif(empty($contarConsContaFAnalitico)){
			echo "<strong>Erro:</strong> Conta Financeira deve ser analítica.";
			}else{
				echo "<strong>Descrição da Conta:</strong>".$arrayConsContaF['Descricao'];
				}
	
}
// Verificando o Gestor
if ($campo == "gestor") {
    $valor=str_replace(".","",$valor);
	$sqlConsGestor="select *
			  from GEEMPRES (nolock)
			  WHERE cd_empresa='".$valor."'";
	$rsConsGestor = odbc_exec($conCab,$sqlConsGestor) or die(odbc_error());
	$arrayConsGestor = odbc_fetch_array($rsConsGestor);
	$contarConsGestor=odbc_num_rows($rsConsGestor);
	$sqlConsGestorAtivo="select 1
			  from GEEMPRES (nolock) 
			  where ativo = 1 AND 
			  cd_empresa='".$valor."'";
	$rsConsGestorAtivo = odbc_exec($conCab,$sqlConsGestorAtivo) or die(odbc_error());
	$contarConsGestorAtivo=odbc_num_rows($rsConsGestorAtivo);
	if ($valor == "") {
		echo "";
	}elseif(empty($contarConsGestor)){
		echo "<strong>Erro:</strong> Gestor Inválido.";
		}elseif(empty($contarConsGestorAtivo)){
			echo "<strong>Erro:</strong> Gestor Inativo.";
			}else{
				echo $arrayConsGestor['Nome_completo'];
				}
	
}
// Verificando o Portador
if ($campo == "portador") {
    $valor=str_replace(".","",$valor);
	$sqlConsPortador="select *
			  from GFPORTAD (nolock)
			  WHERE Cd_portador='".$valor."'";
	$rsConsPortador = odbc_exec($conCab,$sqlConsPortador) or die(odbc_error());
	$arrayConsPortador = odbc_fetch_array($rsConsPortador);
	$contarConsPortador=odbc_num_rows($rsConsPortador);
	$sqlConsPortadorAtivo="select 1
			  from GFPORTAD (nolock) 
			  where ativo = 1 AND 
			  Cd_portador='".$valor."'";
	$rsConsPortadorAtivo = odbc_exec($conCab,$sqlConsPortadorAtivo) or die(odbc_error());
	$contarConsPortadorAtivo=odbc_num_rows($rsConsPortadorAtivo);
	if ($valor == "") {
		echo "";
	}elseif(empty($contarConsPortador)){
		echo "<strong>Erro:</strong> Portador Inválido.";
		}elseif(empty($contarConsPortadorAtivo)){
			echo "<strong>Erro:</strong> Portador Inativo.";
			}else{
				echo $arrayConsPortador['Nome'];
				}
	
}
// Verificando a Código material
if ($campo == "cdMaterial") {
    $valor=str_replace(".","",$valor);
	if(strlen($valor)>=1 && strlen($valor)<4){
	    $sqlConsCdMat="Select
  ESMATERI.Cd_material,
  ESMATERI.Descricao,
  ESUMEDID.Descricao As Descricao1
From
  ESUMEDID Inner Join
  ESMATERI (nolock) On ESUMEDID.Cd_unidade_medi = ESMATERI.Cd_unidade_medi
  WHERE
  ESMATERI.Cd_reduzido = '".$valor."'";
		$rsConsCdMat = odbc_exec($conCab,$sqlConsCdMat) or die(odbc_error());
		$arrayConsCdMat = odbc_fetch_array($rsConsCdMat);
	    if(empty($arrayConsCdMat)){
			echo "<strong>Erro:</strong> C&oacute;digo Inválido";
			}else{
				$cdMaterial=$arrayConsCdMat['Cd_material'];
		echo "<strong>Reduzido do C&oacute;d. Material :</strong>".$arrayConsCdMat['Cd_material']." - ".$arrayConsCdMat['Descricao']."</br><strong>Unid. de Medida: </strong>".$arrayConsCdMat['Descricao1'];
		    }
		}else{
	$sqlConsCdMat1="Select
  ESMATERI.Cd_material,
  ESMATERI.Descricao,
  ESUMEDID.Descricao As Descricao1
From
  ESUMEDID Inner Join
  ESMATERI On ESUMEDID.Cd_unidade_medi = ESMATERI.Cd_unidade_medi
  WHERE
  ESMATERI.Cd_material ='".$valor."'";
	$rsConsCdMat1 = odbc_exec($conCab,$sqlConsCdMat1) or die(odbc_error());
	$arrayConsCdMat1 = odbc_fetch_array($rsConsCdMat1);
	$contarConsCdMat1=odbc_num_rows($rsConsCdMat1);
	$sqlConsCdMatAtivo="select 1
						from ESMATERI (nolock) 
						where cd_material = '".$valor."'
						and tipo <> 'I'";
	$rsConsCdMatAtivo = odbc_exec($conCab,$sqlConsCdMatAtivo) or die(odbc_error());
	$contarConsCdMatAtivo=odbc_num_rows($rsConsCdMatAtivo);
	$sqlConsCdMatObs="select 1
					  from ESMATERI (nolock) 
					  where cd_material = '".$valor."'
					  and (tipo <> 'O' and dbo.CGFC_BUSCA_CONFIGURACAO(1772,null) = 0 
     				  or dbo.CGFC_BUSCA_CONFIGURACAO(1772,null) = 1)";
	$rsConsCdMatObs = odbc_exec($conCab,$sqlConsCdMatObs) or die(odbc_error());
	$contarConsCdMatObs=odbc_num_rows($rsConsCdMatObs);
	if ($valor == "") {
		echo "";
	}elseif(empty($contarConsCdMat1)){
		echo "<strong>Erro:</strong> C&oacute;d. Material Inv&aacute;lido.";
		}elseif(empty($contarConsCdMatAtivo)){
			echo "<strong>Erro:</strong> Material Inativo.";
			}elseif(empty($contarConsCdMatObs)){
			echo "<strong>Erro:</strong> Material Registrado como Obsoleto.";
			}else{
				$cdMaterial=$arrayConsCdMat1['Cd_material'];
				echo "<strong>Descrição do Material:</strong>".$arrayConsCdMat1['Descricao']."</br><strong>Unid. de Medida: </strong>".$arrayConsCdMat1['Descricao1']."";
				}
}
}
// Verificando a Código material
if ($campo == "cgeren") {
    //$valor=str_replace(".","",$valor);
	if(strlen($valor)>=1 && strlen($valor)<9){
		$valor=str_replace(".","",$valor);
	    $sqlConscGeren="select cg.Pcc_classific_c, cg.Pcc_nome_conta
						from CCPCC cg (nolock)
						where cg.Cd_pcc_reduzid = '".$valor."' 
						AND substring(cg.livre_alfa_18,1,1) <> 'N'
						AND cg.Pcc_tipo = 'A'
						AND cg.Pcc_classific_c between dbo.CGFC_BUSCA_CONFIGURACAO(35,null) 
						AND	dbo.CGFC_BUSCA_CONFIGURACAO(36,null)";
		$rsConscGeren = odbc_exec($conCab,$sqlConscGeren) or die(odbc_error());
		$arrayConscGeren = odbc_fetch_array($rsConscGeren);
	    if(empty($arrayConscGeren)){
			echo "<strong>Erro:</strong> Reduzido da conta gerencial Inválido";
			}else{
		echo "<strong>Reduzido do C&oacute;d. Gerencial :</strong>".$arrayConscGeren['Pcc_classific_c']." - ".$arrayConscGeren['Pcc_nome_conta'];
		    }
		}else{
	$sqlConscGeren1="select cg.Pcc_classific_c, cg.Pcc_nome_conta
					from CCPCC cg (nolock)
					where cg.pcc_classific_c = '".$valor."'";
	$rsConscGeren1 = odbc_exec($conCab,$sqlConscGeren1) or die(odbc_error());
	$arrayConscGeren1 = odbc_fetch_array($rsConscGeren1);
	$contarConscGeren1=odbc_num_rows($rsConscGeren1);
	$sqlConscGerenAtivo="select 1
						from CCPCC cg (nolock)
						where cg.pcc_classific_c ='".$valor."'
						and substring(cg.livre_alfa_18,1,1) <> 'N'";
	$rsConscGerenAtivo = odbc_exec($conCab,$sqlConscGerenAtivo) or die(odbc_error());
	$contarConscGerenAtivo=odbc_num_rows($rsConscGerenAtivo);
	$sqlConscGerenAnl="select 1
						from CCPCC cg (nolock)
						where cg.pcc_classific_c ='".$valor."'
						and cg.pcc_tipo = 'A'";
	$rsConscGerenAnl = odbc_exec($conCab,$sqlConscGerenAnl) or die(odbc_error());
	$contarConscGerenAnl=odbc_num_rows($rsConscGerenAnl);
	$sqlConscGerenInt=" select 1
						from CCPCC cg (nolock)
						where cg.pcc_classific_c = '".$valor."'
						and cg.pcc_classific_c between dbo.CGFC_BUSCA_CONFIGURACAO(35,null) 
						and dbo.CGFC_BUSCA_CONFIGURACAO(36,null)";
	$rsConscGerenInt = odbc_exec($conCab,$sqlConscGerenInt) or die(odbc_error());
	$contarConscGerenInt=odbc_num_rows($rsConscGerenInt);
	if ($valor == "") {
		echo "";
	}elseif(empty($contarConscGeren1)){
		echo "<strong>Erro:</strong> C&oacute;d. Gerencial Inv&aacute;lida.";
		}elseif(empty($contarConscGerenAtivo)){
			echo "<strong>Erro:</strong> Conta gerencial Inativa.";
			}elseif(empty($contarConscGerenAnl)){
			echo "<strong>Erro:</strong> Conta gerencial deve ser analitica.";
			}elseif(empty($contarConscGerenInt)){
			echo "<strong>Erro:</strong> Conta gerencial n&atilde;o se encontra no intervalo v&aacute;lido.";
			}else{
				echo "<strong>Descri&ccedil;&atilde;o Conta Gerencial:</strong>".$arrayConscGeren1['Pcc_nome_conta'];
				}
}
}
// Verificando o Red. Contabil
if ($campo == "redcont") {
    $valor=str_replace(".","",$valor);
	$sqlConsRedCont="select cc.cd_pcc_reduzid,cc.Pcc_nome_conta
					 from CCPCC cc (nolock)
					 where cc.cd_pcc_reduzid ='".$valor."'";
	$rsConsRedCont = odbc_exec($conCab,$sqlConsRedCont) or die(odbc_error());
	$arrayConsRedCont = odbc_fetch_array($rsConsRedCont);
	$contarConsRedCont=odbc_num_rows($rsConsRedCont);
	$sqlConsRedContAtivo="select 1
from CCPCC cc (nolock)
where cc.cd_pcc_reduzid = '".$valor."'
and substring(cc.livre_alfa_18,1,1) <> 'N'";
	$rsConsRedContAtivo = odbc_exec($conCab,$sqlConsRedContAtivo) or die(odbc_error());
	$contarConsRedContAtivo=odbc_num_rows($rsConsRedContAtivo);
	$sqlConsRedContAnalitico="select 1
from CCPCC cc (nolock)
where cc.cd_pcc_reduzid = '".$valor."'
and cc.pcc_tipo = 'A'";
	$rsConsRedContAnalitico = odbc_exec($conCab,$sqlConsRedContAnalitico) or die(odbc_error());
	$contarConsRedContAnalitico=odbc_num_rows($rsConsRedContAnalitico);
	if ($valor == "") {
		echo "";
	}elseif(empty($contarConsRedCont)){
		echo "<strong>Erro:</strong> Reduzido Cont&aacute;bil Inválido.";
		}elseif(empty($contarConsRedContAtivo)){
			echo "<strong>Erro:</strong> Red. Cont&aacute;bil Inativo.";
			}elseif(empty($contarConsRedContAnalitico)){
			echo "<strong>Erro:</strong> O Reduzido Cont&aacute;bil deve ser analítico.";
			}else{
				echo "<strong>Descrição do Reduzido:</strong>".$arrayConsRedCont['Pcc_nome_conta'];
				}
	
}
// Verificando o Solicitante
if ($campo == "userSol") {
    $valor=str_replace(".","",$valor);
	$sqlConsuserSol="select Nome_completo
from GEEMPRES (nolock) 
where cd_empresa ='".$valor."'";
	$rsConsuserSol = odbc_exec($conCab,$sqlConsuserSol) or die(odbc_error());
	$arrayConsuserSol = odbc_fetch_array($rsConsuserSol);
	$contarConsuserSol=odbc_num_rows($rsConsuserSol);
	$sqlConsuserSolAtivo="select 1
from GEEMPRES (nolock) 
where cd_empresa = '".$valor."'
and ativo = 1";
	$rsConsuserSolAtivo = odbc_exec($conCab,$sqlConsuserSolAtivo) or die(odbc_error());
	$contarConsuserSolAtivo=odbc_num_rows($rsConsuserSolAtivo);
	if ($valor == "") {
		echo "";
	}elseif(empty($contarConsuserSol)){		
		echo "<strong>Erro:</strong> Solicitante Inv&aacute;lido.";
		}elseif(empty($contarConsuserSolAtivo)){
			echo "<strong>Erro:</strong> Solicitante Inativo.";
			}else{
				echo $arrayConsuserSol['Nome_completo'];
				}
	
}
// Verificando o Beneficiario RPA
if ($campo == "rpaCod") {
    $valor=str_replace(".","",$valor);
	$sqlConsrpaCod="select Nome_completo
from GEEMPRES (nolock) 
where cd_empresa ='".$valor."'";
	$rsConsrpaCod = odbc_exec($conCab,$sqlConsrpaCod) or die(odbc_error());
	$arrayConsrpaCod = odbc_fetch_array($rsConsrpaCod);
	$contarConsrpaCod=odbc_num_rows($rsConsrpaCod);
	$sqlConsrpaCodAtivo="select 1
from GEEMPRES (nolock) 
where cd_empresa = '".$valor."'
and ativo = 1";
	$rsConsrpaCodAtivo = odbc_exec($conCab,$sqlConsrpaCodAtivo) or die(odbc_error());
	$contarConsrpaCodAtivo=odbc_num_rows($rsConsrpaCodAtivo);
	$sqlConsrpaCodCargo="select cargo from GEPFISIC (nolock) where cd_empresa ='".$valor."'";
	$rsConsrpaCodCargo = odbc_exec($conCab,$sqlConsrpaCodCargo) or die(odbc_error());
	$arrayConsrpaCodCargo = odbc_fetch_array($rsConsrpaCodCargo);
	if ($valor == "") {
		echo "";
	}elseif(empty($contarConsrpaCod)){		
		echo "<strong>Erro:</strong> Benefici&aacute;rio Inv&aacute;lido.";
		}elseif(empty($contarConsrpaCodAtivo)){
			echo "<strong>Erro:</strong> Benefici&aacute;rio Inativo.";
			}else{
				echo $arrayConsrpaCod['Nome_completo'];
				echo "<br><tr><td><strong><font color='black'>Cargo/Fun&ccedil;&atilde;o:</font></strong> <input class='input' name='cargoRpa' id='cargoRpa' type='text' size='20' value='".$arrayConsrpaCodCargo['cargo']."' maxlength='40'/><br /></td></tr>";
				}
	
}
// Verificando o Beneficiario Diaria
if ($campo == "diaCod") {
    $valor=str_replace(".","",$valor);
	$sqlConsdiaCod="select Nome_completo
from GEEMPRES (nolock) 
where cd_empresa ='".$valor."'";
	$rsConsdiaCod = odbc_exec($conCab,$sqlConsdiaCod) or die(odbc_error());
	$arrayConsdiaCod = odbc_fetch_array($rsConsdiaCod);
	$contarConsdiaCod=odbc_num_rows($rsConsdiaCod);
	$sqlConsdiaCodAtivo="select 1
from GEEMPRES (nolock) 
where cd_empresa = '".$valor."'
and ativo = 1";
	$rsConsdiaCodAtivo = odbc_exec($conCab,$sqlConsdiaCodAtivo) or die(odbc_error());
	$contarConsdiaCodAtivo=odbc_num_rows($rsConsdiaCodAtivo);
	$sqlConsdiaCodCargo="select cargo from GEPFISIC (nolock) where cd_empresa ='".$valor."'";
	$rsConsdiaCodCargo = odbc_exec($conCab,$sqlConsdiaCodCargo) or die(odbc_error());
	$arrayConsdiaCodCargo = odbc_fetch_array($rsConsdiaCodCargo);
	if ($valor == "") {
		echo "";
	}elseif(empty($contarConsdiaCod)){		
		echo "<strong>Erro:</strong> Benefici&aacute;rio Inv&aacute;lido.";
		}elseif(empty($contarConsdiaCodAtivo)){
			echo "<strong>Erro:</strong> Benefici&aacute;rio Inativo.";
			}else{
				echo $arrayConsdiaCod['Nome_completo'];
				echo "<br><tr><td><strong><font color='black'>Cargo/Fun&ccedil;&atilde;o:</font></strong> <input class='input' name='cargoDia' id='cargoDia' type='text' size='20' value='".$arrayConsdiaCodCargo['cargo']."' maxlength='40'/><br /></td></tr>";
				}
	
}
// Verificando o Passageiro Viagem
if ($campo == "pasCod") {
    $valor=str_replace(".","",$valor);
	$sqlConspasCod="select Nome_completo
from GEEMPRES (nolock) 
where cd_empresa ='".$valor."'";
	$rsConspasCod = odbc_exec($conCab,$sqlConspasCod) or die(odbc_error());
	$arrayConspasCod = odbc_fetch_array($rsConspasCod);
	$contarConspasCod=odbc_num_rows($rsConspasCod);
	$sqlConspasCodAtivo="select 1
from GEEMPRES (nolock) 
where cd_empresa = '".$valor."'
and ativo = 1";
	$rsConspasCodAtivo = odbc_exec($conCab,$sqlConspasCodAtivo) or die(odbc_error());
	$contarConspasCodAtivo=odbc_num_rows($rsConspasCodAtivo);
	$sqlConspasCodCargo="select cargo from GEPFISIC (nolock) where cd_empresa ='".$valor."'";
	$rsConspasCodCargo = odbc_exec($conCab,$sqlConspasCodCargo) or die(odbc_error());
	$arrayConspasCodCargo = odbc_fetch_array($rsConspasCodCargo);
	if ($valor == "") {
		echo "";
	}elseif(empty($contarConspasCod)){		
		echo "<strong>Erro:</strong> Passageiro Inv&aacute;lido.";
		}elseif(empty($contarConspasCodAtivo)){
			echo "<strong>Erro:</strong> Passageiro Inativo.";
			}else{
				echo $arrayConspasCod['Nome_completo'];
				echo "<br><tr><td><strong><font color='black'>Cargo/Fun&ccedil;&atilde;o:</font></strong> <input class='input' name='cargoPas' id='cargoPas' type='text' size='20' value='".$arrayConspasCodCargo['cargo']."' maxlength='40'/><br /></td></tr>";
				}
	
}
// Verificando o Passageiro Hotel
if ($campo == "hotCod") {
    $valor=str_replace(".","",$valor);
	$sqlConshotCod="select Nome_completo
from GEEMPRES (nolock) 
where cd_empresa ='".$valor."'";
	$rsConshotCod = odbc_exec($conCab,$sqlConshotCod) or die(odbc_error());
	$arrayConshotCod = odbc_fetch_array($rsConshotCod);
	$contarConshotCod=odbc_num_rows($rsConshotCod);
	$sqlConshotCodAtivo="select 1
from GEEMPRES (nolock) 
where cd_empresa = '".$valor."'
and ativo = 1";
	$rsConshotCodAtivo = odbc_exec($conCab,$sqlConshotCodAtivo) or die(odbc_error());
	$contarConshotCodAtivo=odbc_num_rows($rsConshotCodAtivo);
	$sqlConshotCodCargo="select cargo from GEPFISIC (nolock) where cd_empresa ='".$valor."'";
	$rsConshotCodCargo = odbc_exec($conCab,$sqlConshotCodCargo) or die(odbc_error());
	$arrayConshotCodCargo = odbc_fetch_array($rsConshotCodCargo);
	if ($valor == "") {
		echo "";
	}elseif(empty($contarConshotCod)){		
		echo "<strong>Erro:</strong> H&oacute;spede Inv&aacute;lido.";
		}elseif(empty($contarConshotCodAtivo)){
			echo "<strong>Erro:</strong> H&oacute;spede Inativo.";
			}else{
				echo $arrayConshotCod['Nome_completo'];
				echo "<br><tr><td><strong><font color='black'>Cargo/Fun&ccedil;&atilde;o:</font></strong> <input class='input' name='cargoHot' id='cargoHot' type='text' size='20' value='".$arrayConshotCodCargo['cargo']."' maxlength='40'/><br /></td></tr>";
				}
	
}


// Acentuação
header("Content-Type: text/html; charset=ISO-8859-1",true);
?>