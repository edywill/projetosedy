<?php
//Busca o tipo de usuario
function buscaTipoUser($usuario){
	include "conect.php";
	$sqlConsultaTipo=mysql_query("select orcamento from usuarios where nome='".$usuario."'");
	$retornoTipoUser=mysql_fetch_array($sqlConsultaTipo);
	return $retornoTipoUser['orcamento'];
	}


//Funcao para montar combo de contas Gerenciais
function montaComboConta(){
	require "conectsqlserverci.php";
	include "mb.php";
	$sqlContas=odbc_exec($conCab,"select cg.Pcc_classific_c AS cod, cg.Pcc_nome_conta AS nome
from CCPCC cg (nolock)
where substring(cg.livre_alfa_18,1,1) <> 'N'
and cg.pcc_tipo <> 'A'
and cg.pcc_classific_c between dbo.CGFC_BUSCA_CONFIGURACAO(35,null) and dbo.CGFC_BUSCA_CONFIGURACAO(36,null)
");

    echo "<select name='conta'>
	      <option selected value='0'>Selecione</option>";
    while( $objSelect = odbc_fetch_object($sqlContas) ){
		echo "<option value='".$objSelect->cod."'>".$objSelect->cod."-".$objSelect->nome."</option>";
		}
	}
//Buscar nome da Conta
//Funcao para montar combo de contas Gerenciais
function buscaNomeConta($codConta){
	require "conectsqlserverci.php";
	include "mb.php";
	$sqlNomeContas=odbc_exec($conCab,"select cg.Pcc_nome_conta AS nome
from CCPCC cg (nolock)
where 
cg.Pcc_classific_c='".$codConta."' 
AND substring(cg.livre_alfa_18,1,1) <> 'N'
and cg.pcc_tipo <> 'A'
and cg.pcc_classific_c between dbo.CGFC_BUSCA_CONFIGURACAO(35,null) and dbo.CGFC_BUSCA_CONFIGURACAO(36,null)") or die (mysql_error());
$retornoArray=odbc_fetch_array($sqlNomeContas);
return $retornoArray['nome'];
	}
//Função para Inserir valores de limite da conta
function insereConta($insConta,$insLei,$insPatCef,$insPatDiv,$insSiconv,$insTestesp, $insTimeRio,$insTimeSp,$insJogoSochi,$insReserva){
	require "conectOrc.php";
	$insertConta=mysql_query("INSERT INTO limites VALUES ('','".$insConta."','".$insLei."','".$insPatCef."','".$insPatDiv."','".$insSiconv."','".$insTestesp."','". $insTimeRio."','".$insTimeSp."','".$insJogoSochi."','".$insReserva."','".$insLei."','".$insPatCef."','".$insPatDiv."','".$insSiconv."','".$insTestesp."','". $insTimeRio."','".$insTimeSp."','".$insJogoSochi."','".$insReserva."')") or die(mysql_error());
	if($insertConta){
		?>
       <script type="text/javascript">
       alert("Informações inseridas com sucesso.");
       window.location="orcMenu.php";
       </script>
       <?php
		}else{
			?>
       <script type="text/javascript">
       alert("Ocorreu um erro. Tente novamente!");
       history.back();
       </script>
       <?php
			}
	}
//Função para atualizar valores de limite de conta
function atualizaConta($updConta,$updLei,$updPatCef,$updPatDiv,$updSiconv,$updTestesp, $updTimeRio,$updTimeSp,$updJogoSochi,$updReserva){
	require "conectOrc.php";
	$updateConta=mysql_query("UPDATE limites SET lei='".$updLei."',patcef='".$updPatCef."',patdiv='".$updPatDiv."',siconv='".$updSiconv."',testesp='".$updTestesp."',timerio='". $updTimeRio."',timesp='".$updTimeSp."',jogosochi='".$updJogoSochi."',reserva='".$updReserva."' WHERE conta='".$updConta."'") or die(mysql_error());
	if($updateConta){
		?>
       <script type="text/javascript">
       alert("Informações atualizadas com sucesso.");
       window.location="orcMenu.php";
       </script>
       <?php
		}else{
			?>
       <script type="text/javascript">
       alert("Ocorreu um erro. Tente novamente!");
       history.back();
       </script>
       <?php
			}
	}
?>