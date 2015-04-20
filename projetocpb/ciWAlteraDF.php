<?php
require "conectsqlserverci.php";
session_start();
$retorno='';
$valida=0;
$countError=0;
$errorMsg='';
$msgAlerta='';
unset($_SESSION['validComp']);
if($_POST['endereco']==1){
				 $retorno='ciWItensDComp.php';
				 $retorno2='ciWInserirItens.php';
				$msgAlerta='Item inserido com sucesso!';
				$_SESSION['cdMaterialS']='';
				$_SESSION['quantidadeItemS']='';
				$_SESSION['precoUnitS']='';
				$_SESSION['pzentS']='';
				$_SESSION['justItemS']='';
				 }elseif($_POST['endereco']==2){
				     $retorno='ciWAlteraItAp.php';
				     $retorno2='ciWAlteraItAp.php';
					 $msgAlerta='Alterado com sucesso!';
				 }elseif($_POST['endereco']==3){
				     $retorno='ciWAtuItDComp.php';
				     $retorno2='ciWItens.php';
					 $msgAlerta='Item alterado com sucesso!';
				 }elseif($_POST['endereco']==4){
				     $retorno='ciWItDCompInsAt.php';
				     $retorno2='ciWItens.php';
				 	 $msgAlerta='Item inserido com sucesso!';
				 }else{
					 $retorno='ciWItensDComplementar.php';
				 	 $retorno2='ciWInserirItens.php';
					 $msgAlerta='Item alterado com sucesso!';
					 }
$solicitacao=$_POST['solicitacao'];
$sequencia=$_POST['sequencia'];
$pr_unitario=str_replace(".","",$_POST['pr_unitario']);
$pr_unitario=str_replace(",",".",$pr_unitario);
$pr_unitario=str_replace("'","\"",$pr_unitario);
$_SESSION['prUnitSC']=$pr_unitario;

$_SESSION['redContCompS']=trim($_POST['redcont']);
$usuario=$_POST['user'];
	$sqlUsuario="select Campo20, Nome
			from GEUSUARI (nolock)
			where cd_usuario = '".$usuario."' ";
	$resSqlUsuario=odbc_exec($conCab, $sqlUsuario) or die("<p>".odbc_errormsg());
	$arraySqlUsuario=odbc_fetch_array($resSqlUsuario);
$userSolic=$arraySqlUsuario['Campo20'];

$cgeren=trim($_POST['cgeren']);
$_SESSION['geremCompS']=$cgeren;
$arcgeren = explode('-', $cgeren);
$cgeren=$arcgeren[0];
$cgeren=str_replace("'","\"",$cgeren);
if(isset($_POST['checkGeren']) && $_POST['endereco']==4 ){
					$_SESSION['geremCompPadrao']=trim($_POST['cgeren']);
					}elseif($_POST['endereco']==1 && isset($_POST['checkGeren'])){
						$_SESSION['geremCompPadrao']=mb_convert_encoding(trim($_POST['cgeren']), "UTF-8", mb_detect_encoding(trim($_POST['cgeren']), "UTF-8, ISO-8859-1, ISO-8859-15", true));
						}
	
	$sqlConscGeren1="select cg.Pcc_classific_c, cg.Pcc_nome_conta
					from CCPCC cg (nolock)
					where cg.pcc_classific_c = '".$cgeren."'";
	$rsConscGeren1 = odbc_exec($conCab,$sqlConscGeren1) or die(odbc_error());
	$arrayConscGeren1 = odbc_fetch_array($rsConscGeren1);
	$contarConscGeren1=odbc_num_rows($rsConscGeren1);
	$sqlConscGerenAtivo="select 1
						from CCPCC cg (nolock)
						where cg.pcc_classific_c ='".$cgeren."'
						and substring(cg.livre_alfa_18,1,1) <> 'N'";
	$rsConscGerenAtivo = odbc_exec($conCab,$sqlConscGerenAtivo) or die(odbc_error());
	$contarConscGerenAtivo=odbc_num_rows($rsConscGerenAtivo);
	$sqlConscGerenAnl="select 1
						from CCPCC cg (nolock)
						where cg.pcc_classific_c ='".$cgeren."'
						and cg.pcc_tipo = 'A'";
	$rsConscGerenAnl = odbc_exec($conCab,$sqlConscGerenAnl) or die(odbc_error());
	$contarConscGerenAnl=odbc_num_rows($rsConscGerenAnl);
	$sqlConscGerenInt=" select 1
						from CCPCC cg (nolock)
						where cg.pcc_classific_c = '".$cgeren."'
						and cg.pcc_classific_c between dbo.CGFC_BUSCA_CONFIGURACAO(35,null) 
						and dbo.CGFC_BUSCA_CONFIGURACAO(36,null)";
	$rsConscGerenInt = odbc_exec($conCab,$sqlConscGerenInt) or die(odbc_error());
	$contarConscGerenInt=odbc_num_rows($rsConscGerenInt);
	if ($cgeren == "") {
		$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Informe a conta gerencial.\\n';
	   }
	   
	   if(empty($contarConscGeren1)){
		   $valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Conta gerencial inv\\u00e1lida.\\n';
			
		}
		
		if(empty($contarConscGerenAtivo) && $valida==0){
				$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Conta gerencial inativa.\\n';
				
			}
			
			if(empty($contarConscGerenAnl) && $valida==0){
				$valida=1;
		$countError++;
		$errorMsg.='Erro['.$countError.']: Conta gerencial n\\u00e3o anal\\u00edtica.\\n';
			}
			if(empty($contarConscGerenInt)){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Conta gerencial fora dos intervalos aceitos.\\n';
			
			}
			
			if($valida==0){
				$cgeren=$arrayConscGeren1['Pcc_classific_c'];
			 }
		
    $redcont=trim($_POST['redcont']);
	$_SESSION['redContCompS']=$redcont;
    $arRedCont = explode('-', $redcont);
	$redcont=$arRedCont[0];
	$redcont=str_replace("'","\"",$redcont);
    
	if(!empty($redcont)){
	//$redcont=str_replace(".","",$redcont);
	$sqlConsRedCont="select cc.cd_pcc_reduzid,cc.Pcc_nome_conta
					 from CCPCC cc (nolock)
					 where cc.cd_pcc_reduzid ='".$redcont."'";
	$rsConsRedCont = odbc_exec($conCab,$sqlConsRedCont) or die(odbc_error());
	$arrayConsRedCont = odbc_fetch_array($rsConsRedCont);
	$contarConsRedCont=odbc_num_rows($rsConsRedCont);
	$sqlConsRedContAtivo="select 1
from CCPCC cc (nolock)
where cc.cd_pcc_reduzid = '".$redcont."'
and substring(cc.livre_alfa_18,1,1) <> 'N'";
	$rsConsRedContAtivo = odbc_exec($conCab,$sqlConsRedContAtivo) or die(odbc_error());
	$contarConsRedContAtivo=odbc_num_rows($rsConsRedContAtivo);
	$sqlConsRedContAnalitico="select 1
from CCPCC cc (nolock)
where cc.cd_pcc_reduzid = '".$redcont."'
and cc.pcc_tipo = 'A'";
	$rsConsRedContAnalitico = odbc_exec($conCab,$sqlConsRedContAnalitico) or die(odbc_error());
	$contarConsRedContAnalitico=odbc_num_rows($rsConsRedContAnalitico);
	 if(empty($contarConsRedCont)){
		
		?>
       <script type="text/javascript">
       alert("Reduzido contabil invalido.");
       window.location="<?php echo $retorno; ?>";
       </script>
       <?php
	   break;
		}elseif(empty($contarConsRedContAtivo)){
			?>
       <script type="text/javascript">
       alert("Reduzido contabil inativo.");
       window.location="<?php echo $retorno; ?>";
       </script>
       <?php
	   break;
			}elseif(empty($contarConsRedContAnalitico)){
			?>
       <script type="text/javascript">
       alert("O reduzido contabil deve ser analitico.");
       window.location="<?php echo $retorno; ?>";
       </script>
       <?php
	   break;
			}else{
				$redcont=$arrayConsRedCont['cd_pcc_reduzid'];
				}

	 }else{
		 $redcont=0;
		 }
	if($valida==0){
$sqlInsertItem="UPDATE COISOLIC SET 
   cd_conta_gerenc='".$cgeren."',
   pr_unitario='".$pr_unitario."',
   campo41='".$redcont."',
   usuario_modific='".$usuario."',
   dt_modificacao=dbo.CGFC_DATAATUAL ()
where cd_solicitacao='".$solicitacao."' and
sequencia='".$sequencia."'";
   $resInsertItem = odbc_exec($conCab, $sqlInsertItem) or die("<p>".odbc_errormsg());
if($resInsertItem){
?>
       <script type="text/javascript">
       alert("<?php echo $msgAlerta; ?>");
       window.location="<?php echo $retorno2; ?>";
       </script>
       <?php
       
	   }
	}else{
		?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="<?php echo $retorno; ?>";
       </script>
       <?php
		}
?>
