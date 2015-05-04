<?php 
session_start();
require "../conectsqlserver.php";
require "conectsqlserversav.php";
require "../conect.php";
$idFunc=$_SESSION['idFuncSav'];
$abrangencia=$_SESSION['abrangenciaSav'];
extract($_GET);
$valida=0;
$acao='';
$countError=0;
$errorMsg='';
if(empty($_SESSION['numSav'])){
	//Criar
$acao=1;
$cgeren=utf8_decode($geren);
$arrayCgeren=explode("-",$cgeren);
$cgeren=$arrayCgeren[0];
$_SESSION['gerenSav']=$cgeren;
$gestor=utf8_decode($gestor);
$arrayGestor=explode("-",$gestor);
$gestor=$arrayGestor[0];
$_SESSION['gestorSav']=$gestor;
$_SESSION['gerenSav']=$cgeren;
$_SESSION['diariaSolSav']=$soldia;
$_SESSION['valorTransSav']='';
$_SESSION['valorPasSav']='';
$_SESSION['idaeVoltaSav']='';
$_SESSION['tipoQuartoSav']='';
$_SESSION['eventoSav']=utf8_decode($evento);
$_SESSION['objetivoSav']=utf8_decode($objetivo);
$_SESSION['idaeVoltaSav5']='';
$_SESSION['cadeiranteSav5']='';
$_SESSION['origemidaSav5']='';
$_SESSION['destinoidaSav5']='';
$_SESSION['horarioidaSav5']='';
$_SESSION['horariovoltaSav5']='';
$_SESSION['dtidaSav5']='';
$_SESSION['dtvoltaSav5']='';
$_SESSION['valorPasSav5']='';

//Busco se o usuário tem outras SAVs
//Caso haja SAV, pego os dados dela, caso não, busco por meio da tabela TEITEMSOLPASSAGEM e pego o Trecho
//Caso não exista mesmo, o campo fica em branco.
//Caso encontre, pego o número da CI e verifico na relação de boarding pass, verifico se o ticket em questão foi devolvido o bilhete para marcar.
$scriptConsultaSavs=mysql_query("SELECT id AS maxid FROM savregistros WHERE funcionario='".$idFunc."' AND dtvolta<='".date("d/m/Y")."' ORDER BY dtvolta DESC LIMIT 1") or die(mysql_error());
$sqlConsultaSavs=mysql_fetch_array($scriptConsultaSavs);
if(!empty($sqlConsultaSavs)){
	$consultaCdEmpres=odbc_fetch_array(odbc_exec($conCab2,"Select
  Campo20
From
  GEUSUARI
  where Cd_usuario='".$_SESSION['userCigamSav']."'"));
	$scriptBPass=mysql_query("select registros.bdpass from registros where registros.idben='".$consultaCdEmpres['Campo20']."' ORDER BY registros.datafinal DESC LIMIT 1") or die(mysql_error());
	$consultaBPass=mysql_fetch_array($scriptBPass);
	
	if($consultaBPass['bdpass']==1){
		$_SESSION['bilheteSav']='sim';
		}else{
			$_SESSION['bilheteSav']='nao';
			}
	}else{
		$_SESSION['bilheteSav']='sim';
		}

			$_SESSION['passagemSav']=$passag;
			$_SESSION['idaeVoltaSav5']='';
			$_SESSION['origemidaSav5']='';
			$_SESSION['destinoidaSav5']='';
			$_SESSION['horarioidaSav5']='';
			$_SESSION['horariovoltaSav5']='';
			$_SESSION['dtidaSav5']='';
			$_SESSION['dtvoltaSav5']='';
			$_SESSION['valorPasSav5']='';
			$_SESSION['cadeiranteSav5']='';
if($abrangencia=='Internacional'){
//$_SESSION['passagemSav2']=$_POST['passag2'];
	if(empty($_SESSION['cotacaoDiaSav'])){
		include "buscaCotacao.php";
	}
}
$_SESSION['diariaSav']=$diar;
$_SESSION['transladoSav']=$trans;
$_SESSION['observacaoSav']=utf8_decode($observacao);
//insert novo registro
	
	}elseif($_SESSION['tpSav']=='2'){
		//atualiza
$acao=2;
$cgeren=utf8_decode($geren);
$arrayCgeren=explode("-",$cgeren);
$cgeren=$arrayCgeren[0];
$_SESSION['gerenSav']=$cgeren;
$gestor=utf8_decode($gestor);
$arrayGestor=explode("-",$gestor);
$gestor=$arrayGestor[0];
$_SESSION['gestorSav']=$gestor;
$_SESSION['gerenSav']=$cgeren;
$_SESSION['valorTransSav']='';
$_SESSION['valorPasSav']='';
$_SESSION['idaeVoltaSav']='';
$_SESSION['tipoQuartoSav']='';
$_SESSION['diariaSolSav']=$soldia;
$_SESSION['eventoSav']=utf8_decode($evento);
$_SESSION['objetivoSav']=utf8_decode($objetivo);
			$_SESSION['idaeVoltaSav5']='';
			$_SESSION['cadeiranteSav5']='';
			$_SESSION['origemidaSav5']='';
			$_SESSION['destinoidaSav5']='';
			$_SESSION['horarioidaSav5']='';
			$_SESSION['horariovoltaSav5']='';
			$_SESSION['dtidaSav5']='';
			$_SESSION['dtvoltaSav5']='';
			$_SESSION['valorPasSav5']='';
$_SESSION['passagemSav']=$passag;
if($abrangencia=='Internacional'){
	if(empty($_SESSION['cotacaoDiaSav'])){
		include "buscaCotacao.php";
	}
}
$_SESSION['diariaSav']=$diar;
$_SESSION['transladoSav']=$trans;
$_SESSION['observacaoSav']=utf8_decode($observacao);
//Update registro
}

$cgeren=$_SESSION['gerenSav'];
$sqlConscGeren1="select cg.Pcc_classific_c, cg.Pcc_nome_conta
					from CCPCC cg (nolock)
					where cg.pcc_classific_c = '".$cgeren."'";
	$rsConscGeren1 = odbc_exec($conCab2,$sqlConscGeren1) or die(odbc_error());
	$arrayConscGeren1 = odbc_fetch_array($rsConscGeren1);
	$contarConscGeren1=odbc_num_rows($rsConscGeren1);
	$sqlConscGerenAtivo="select 1
						from CCPCC cg (nolock)
						where cg.pcc_classific_c ='".$cgeren."'
						and substring(cg.livre_alfa_18,1,1) <> 'N'";
	$rsConscGerenAtivo = odbc_exec($conCab2,$sqlConscGerenAtivo) or die(odbc_error());
	$contarConscGerenAtivo=odbc_num_rows($rsConscGerenAtivo);
	$sqlConscGerenAnl="select 1
						from CCPCC cg (nolock)
						where cg.pcc_classific_c ='".$cgeren."'
						and cg.pcc_tipo = 'A'";
	$rsConscGerenAnl = odbc_exec($conCab2,$sqlConscGerenAnl) or die(odbc_error());
	$contarConscGerenAnl=odbc_num_rows($rsConscGerenAnl);
	$sqlConscGerenInt=" select 1
						from CCPCC cg (nolock)
						where cg.pcc_classific_c = '".$cgeren."'
						and cg.pcc_classific_c between dbo.CGFC_BUSCA_CONFIGURACAO(35,null) 
						and dbo.CGFC_BUSCA_CONFIGURACAO(36,null)";
	$rsConscGerenInt = odbc_exec($conCab2,$sqlConscGerenInt) or die(odbc_error());
	$contarConscGerenInt=odbc_num_rows($rsConscGerenInt);
	if ($cgeren == "") {
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a conta gerencial.<br>';
	   }
	   
	   if(empty($contarConscGeren1)){
		   $valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Conta gerencial inválida.<br>';
			
		}
		
		if(empty($contarConscGerenAtivo) && $valida==0){
				$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Conta gerencial inativa.<br>';
				
			}
			
			if(empty($contarConscGerenAnl) && $valida==0){
				$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Conta gerencial não analítica.<br>';
			}
			if(empty($contarConscGerenInt)){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Conta gerencial fora dos intervalos aceitos.<br>';
			
			}
			
			if($valida==0){
				$cgeren=$arrayConscGeren1['Pcc_classific_c'];
			 }
if(empty($_SESSION['eventoSav'])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Evento não informado.<br>';
	 }
	 if(empty($_SESSION['gestorSav'])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Gestor não informado.<br>';
	 }
		$gestor=$_SESSION['gestorSav'];
if($gestor<>'' || is_numeric($gestor)){
	$sqlConsGestor="select *
			  from GEEMPRES (nolock)
			  WHERE cd_empresa='".$gestor."'";
	$rsConsGestor = odbc_exec($conCab2,$sqlConsGestor) or die(odbc_error());
	$contarConsGestor=odbc_num_rows($rsConsGestor);
	$sqlConsGestorAtivo="select 1
			  from GEEMPRES (nolock) 
			  where ativo = 1 AND 
			  cd_empresa='".$gestor."'";
	$rsConsGestorAtivo = odbc_exec($conCab2,$sqlConsGestorAtivo) or die(odbc_error());
	$contarConsGestorAtivo=odbc_num_rows($rsConsGestorAtivo);

if($contarConsGestor<1){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Gestor inválido.<br>';
	 }
if($contarConsGestorAtivo<1){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Gestor inativo.<br>';
	 }
	}
	if(empty($_SESSION['objetivoSav'])){
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Necessário informar o objetivo da viagem.<br>';
	 }	
if($valida==0 && $acao<>0){
	if($acao==1){
		$consultaUltimoRegistro=mysql_fetch_array(mysql_query("SELECT max(id) AS maxid FROM savregistros"));
		$numSavCria=$consultaUltimoRegistro['maxid']+1;
		//Insert
		$sqlRegistro="INSERT INTO  savregistros(id,numci,funcionario,evento,gestor,abrangencia,objetivo,ultimaviagem,devbilhete,passagem,hospedagem,translado,observ,cgeren,status,situacao) VALUES (".$numSavCria.",0,'".$idFunc."','".$_SESSION['eventoSav']."','".$gestor."','".$abrangencia."','".$_SESSION['objetivoSav']."','".$_SESSION['ultimaViagSav']."','".$_SESSION['bilheteSav']."','".$_SESSION['passagemSav']."','".$_SESSION['diariaSav']."','".$_SESSION['transladoSav']."','".$_SESSION['observacaoSav']."','".$cgeren."','Elaboracao','".utf8_decode('Elaboração')."')";
		$queryRegistro=mysql_query($sqlRegistro) or die(mysql_error());
		if(!$queryRegistro){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Falha ao inserir o registro.<br>';
		}else{
			$_SESSION['numSav']=$numSavCria;
			}
		}elseif($acao==2){
			$status2=utf8_decode("Elaboração");
			//Update
			$sqlRegistro="UPDATE savregistros SET evento='".$_SESSION['eventoSav']."',gestor='".$gestor."',objetivo='".$_SESSION['objetivoSav']."',passagem='".$_SESSION['passagemSav']."',hospedagem='".$_SESSION['diariaSav']."',translado='".$_SESSION['transladoSav']."',observ='".$_SESSION['observacaoSav']."',cgeren='".$cgeren."',situacao='".$status2."' WHERE id='".$_SESSION['numSav']."'";
			$queryRegistro=mysql_query($sqlRegistro) or die (mysql_error());
			if(!$queryRegistro){
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Falha ao atualizar o registro.<br>';
				}
			}
	}
if($valida>0){
	$_SESSION['tpSav']=2;
	if($_SESSION['tpSav']<>3){
$_SESSION['eventoSav']=utf8_encode($_SESSION['eventoSav']);
$_SESSION['gestorSav']=utf8_encode($_SESSION['gestorSav']);
$_SESSION['objetivoSav']=utf8_encode($_SESSION['objetivoSav']);
$_SESSION['gerenSav']=utf8_encode($_SESSION['gerenSav']);
$_SESSION['ultimaViagSav']=utf8_encode($_SESSION['ultimaViagSav']);
$_SESSION['observacaoSav']=utf8_encode($_SESSION['observacaoSav']);

}
	echo $errorMsg;
	}else{
		$_SESSION['dtidaSav2']='';
		$_SESSION['dtvoltaSav2']='';
		$_SESSION['cidorigemPasSav']='';
		$_SESSION['origemidaSav2']='';
		$_SESSION['ciddestinoPasSav']='';
		$_SESSION['destinoidaSav2']='';
		$_SESSION['destinoidaSav3']='';
		$_SESSION['horarioidaSav2']='';
		$_SESSION['horariovoltaSav2']='';
		$_SESSION['valorPasSav']='';
		$_SESSION['dtidaSav3']='';
		$_SESSION['dtvoltaSav3']='';
		$_SESSION['cidHosSav']='';
		$_SESSION['valorHosSav']='';
		$_SESSION['dtidaSav4']='';
		$_SESSION['dtvoltaSav4']='';
		
		if($_SESSION['diariaSav']<>'sim'){
				$sqlDeleteDiaria=mysql_query("DELETE FROM savhospedagem WHERE idsav='".$_SESSION['numSav']."'");
		}
		if($_SESSION['transladoSav']<>'sim'){
				$sqlDeleteTranslado=mysql_query("DELETE FROM savtranslado WHERE idsav='".$_SESSION['numSav']."'");
		}
		if($_SESSION['passagemSav']<>'sim'){
				$sqlDeletePassagem=mysql_query("DELETE FROM savpassagem WHERE idsav='".$_SESSION['numSav']."'");
		}
if($_SESSION['tpSav']<>3){
$_SESSION['eventoSav']=utf8_encode($_SESSION['eventoSav']);
$_SESSION['gestorSav']=utf8_encode($_SESSION['gestorSav']);
$_SESSION['objetivoSav']=utf8_encode($_SESSION['objetivoSav']);
$_SESSION['gerenSav']=utf8_encode($_SESSION['gerenSav']);
$_SESSION['ultimaViagSav']=utf8_encode($_SESSION['ultimaViagSav']);
$_SESSION['observacaoSav']=utf8_encode($_SESSION['observacaoSav']);
		}
		echo "1";
		$_SESSION['tpSav']=3;
	}
?>