<?php 
require "../conectsqlserver.php";
require "conectsqlserversav.php";
require "../conect.php";
$acao2=$_POST['acao'];
$acao='Cancelada';
$acaoCi='90';
$ret='index.php';
$idSav=$_POST['id'];
$idCi=trim($_POST['ci']);
if($acao2=='inativapc'){
		$ret='prestCont.php';
	}
$updateSav=mysql_query("UPDATE savregistros SET situacao='".utf8_decode($acao)."' where id='".$idSav."'") or die(mysql_error());
if(!empty($idCi) ||$idCi<>0 ){
	$updateCi=odbc_exec($conCab2,"UPDATE COSOLICI SET Campo27='".$acaoCi."' WHERE Solicitacao='".$idCi."'") or die("<p>".odbc_errormsg());;
	$updateItemCi=odbc_exec($conCab2,"UPDATE COISOLIC SET Campo65='".$acaoCi."' WHERE Cd_solicitacao='".$idCi."'") or die("<p>".odbc_errormsg());;
	}
if($updateSav){
	?>
       <script type="text/javascript">
       alert("Cancelada com sucesso.");
       window.location="<?php echo $ret;?>";
       </script>
       <?php
		}else{
		?>
       <script type="text/javascript">
       alert("Ocorreu um erro. Tente novamente!");
       window.location="index.php";
       </script>
       <?php
		}
?>