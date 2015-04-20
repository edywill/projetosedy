<?php
require "conectsqlserverciprod.php";
session_start();
$retorno='';
if($_POST['endereco']==1){
				 $retorno='ciWItensDComp.php';
				 $retorno2='ciWInserirItens.php';
				 }elseif($_POST['endereco']==2){
				     $retorno='ciWAlteraItAp.php';
				     $retorno2='ciWAlteraItAp.php';
				 }else{
					 $retorno='ciWInserirItens.php';
					 $retorno2='ciWInserirItens.php';
					 }
$solicitacao=$_POST['solicitacao'];
$sequencia=$_POST['sequencia'];
$pr_unitario=str_replace(",",".",$_POST['pr_unitario']);
$pr_unitario=str_replace("'","\"",$pr_unitario);
$usuario=$_POST['user'];
	$sqlUsuario="select Campo20, Nome
			from GEUSUARI (nolock)
			where cd_usuario = '".$usuario."' ";
	$resSqlUsuario=odbc_exec($conCab, $sqlUsuario) or die("<p>".odbc_errormsg());
	$arraySqlUsuario=odbc_fetch_array($resSqlUsuario);
$userSolic=$arraySqlUsuario['Campo20'];

$cgeren=trim($_POST['cgeren']);
$arcgeren = explode('-', $cgeren);
$cgeren=$arcgeren[0];
$cgeren=str_replace("'","\"",$cgeren);

	
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
		?>
       <script type="text/javascript">
       alert("Conta gerencial nao pode ser vazia.");
       window.location="<?php echo $retorno; ?>";
       </script>
       <?php	
	   break;
	   }elseif(empty($contarConscGeren1)){
			?>
       <script type="text/javascript">
       alert("Conta gerencial invalida.");
       window.location="<?php echo $retorno; ?>";
       </script>
       <?php
	   break;
		}elseif(empty($contarConscGerenAtivo)){
				?>
       <script type="text/javascript">
       alert("Conta gerencial inativa.");
       window.location="<?php echo $retorno; ?>";
       </script>
       <?php
	   break;
			}elseif(empty($contarConscGerenAnl)){
				?>
       <script type="text/javascript">
       alert("A conta gerencial deve ser analitica.");
       window.location="<?php echo $retorno; ?>";
       </script>
       <?php
	   break;
			}elseif(empty($contarConscGerenInt)){
				?>
       <script type="text/javascript">
       alert("Conta gerencial nao se encontra dentro do intervalo valido.");
       window.location="<?php echo $retorno; ?>";
       </script>
       <?php
			break;
			}else{
				$cgeren=$arrayConscGeren1['Pcc_classific_c'];
			 }
    $redcont=trim($_POST['redcont']);
    $arRedCont = explode('-', $redcont);
	$redcont=$arRedCont[0];
	$redcont=str_replace("'","\"",$redcont);

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
	if ($redcont == "") {
		?>
       <script type="text/javascript">
       alert("O reduzido contabil nao deve ser vazio.");
       window.location="<?php echo $retorno; ?>";
       </script>
       <?php
	   break;
	}elseif(empty($contarConsRedCont)){
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
       alert("Inclusao efetuada com sucesso.");
       window.location="<?php echo $retorno2; ?>";
       </script>
       <?php
       
	   }
?>
