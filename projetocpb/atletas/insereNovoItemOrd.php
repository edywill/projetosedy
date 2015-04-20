<?php 
session_start();
require "../conectsqlserverci.php";
require "../conect.php";
$idRegistro=$_SESSION['idRegAqui'];
$_SESSION['materialComp']=$_POST['material'];
$_SESSION['qtdMat']=$_POST['qtd'];
$material=explode("-",$_POST['material']);
$qtd=trim($_POST['qtd']);
$valida=0;
$countError=0;
$errorMsg='';
if($_SESSION['tipoAcao']=='inserir' && empty($_SESSION['idRegOrdem'])){
	$sqlUltimaOrdem=mysql_fetch_array(mysql_query("SELECT MAX(id) AS id FROM aquiordem"));
	$ultimaOrdem=$sqlUltimaOrdem['id']+1;
	$sqlCriaOrdem=mysql_query("INSERT INTO aquiordem (id,idreg,user) VALUES ('".$ultimaOrdem."','".$idRegistro."','".$_SESSION['userAquis']."')");
	$_SESSION['idRegOrdem']=$ultimaOrdem;
	}
if(empty($material[0]) || !is_numeric($material[0])){
				    $valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Material inválido. Informe o material da lista.\\n';
	}else{
		$sqlMatDupQuery=mysql_query("SELECT id FROM aquipedidoitem WHERE idos='".$_SESSION['idRegOrdem']."' AND idmat='".$material[0]."'") or die(mysql_error());
		$sqlMatDup=mysql_num_rows($sqlMatDupQuery);
		if($sqlMatDup>0 && empty($_POST['atualizar'])){
			$valida=1;
			$countError++;
			$errorMsg.='Erro['.$countError.']: Material já cadastrado para essa Ordem.\\n';
			}
		}
if(empty($qtd) || $qtd=='0'){
				    $valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Informe a quantidade.\\n';
	}
 
if($valida==0){
	if($_SESSION['tipoAcao']=='inserir' && empty($_POST['atualizar'])){
	$sqlInsertItemMat=mysql_query("INSERT INTO aquipedidoitem(idmat,idos,qtd) VALUES ('".$material[0]."','".$_SESSION['idRegOrdem']."','".$qtd."')") or die(mysql_error());
	}else{
		$sqlInsertItemMat=mysql_query("UPDATE aquipedidoitem SET idmat='".$material[0]."',idos='".$_SESSION['idRegOrdem']."',qtd='".$qtd."' WHERE id='".$_POST['atualizar']."'") or die(mysql_error());
		}
  if(!$sqlInsertItemMat){
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Erro ao processar o registro. Tente novamente.\\n';
	    }	
	}
if($valida==1)
{
	?>
       <script type="text/javascript">
       alert("<?php echo $errorMsg; ?>");
       window.location="novaOrdem.php";
       </script>
       <?php
		}else{
$_SESSION['materialComp']='';
$_SESSION['qtdMat']='';
		?>
       <script type="text/javascript">
       alert("Item processado com sucesso.");
       window.location="novaOrdem.php";
       </script>
       <?php	
			}

?>