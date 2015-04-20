<?php 
require "conectsqlserverci.php";
session_start();
$valida=0;
$countError=0;
$errorMsg='';
$endRet='';
if($_GET['tp']==1){
	$arquivoEnd=$_GET['end'];
	$endRet='ciWResCons.php';
	$add='';
	$embarquePedido=str_pad($_GET['ci'], 8, " ", STR_PAD_LEFT);
	$consSqlDel="(codigo_titulo='801')";
	}elseif($_GET['tp']==2){
		$arquivoEnd=utf8_decode($_GET['end']);
		$endRet='ciWResCons.php';
		$add='';
		$embarquePedido=str_pad($_GET['ci'], 8, " ", STR_PAD_LEFT);
		$consSqlDel="(codigo_titulo='801')";
		}elseif($_GET['tp']==3){
			$arquivoEnd=$_GET['end'];
			$endRet='ciWItens.php';
			$add=$_GET['sq'].'\\';
			$solicAcomp=str_pad($_GET['ci'], 8, "0", STR_PAD_LEFT);
			$seqAcomp=str_pad($_GET['sq'], 3, "0", STR_PAD_LEFT);
			$embarquePedido=$solicAcomp."/".$seqAcomp;
			$consSqlDel="(codigo_titulo='802' OR codigo_titulo='803')";
			}elseif($_GET['tp']==4){
	$arquivoEnd=$_GET['end'];
	$endRet='ciWInserir.php';
	$add='';
	$embarquePedido=str_pad($_GET['ci'], 8, " ", STR_PAD_LEFT);
	$consSqlDel="(codigo_titulo='801')";
				$_SESSION['del']=1;
				}
 		$quebra = chr(13).chr(10);
		require("conectftp.php"); 
		$caminho_absoluto = 'CIWEB\\'.$_GET['ci'].'\\'.$add;
		$caminho_absoluto_web = 'Anexos\\'.$caminho_absoluto;
		if(!ftp_delete( $con_id, str_replace("\\","/",$caminho_absoluto.$arquivoEnd)) || !unlink($caminho_absoluto_web.$arquivoEnd)){
									$valida=1;
					 				$countError++;
	    			 				$errorMsg.='Erro['.$countError.']: Problema ao fazer upload do ANEXO.\\n'; 
						}
			  $endArquivo="An:W:\\Anexos_CI\\".$caminho_absoluto.$arquivoEnd."";															
		ftp_close($con_id);
		
if($valida==0 && $_GET['tp']<>4){
$consultaAcomp=odbc_exec($conCab,"SELECT historico FROM GEACOMP 
					WHERE tipo_acompanham='R'
					AND  ".$consSqlDel." 
					AND rtrim(ltrim(embarque_pedido))='".trim($embarquePedido)."'");
$arrayAcomp=odbc_fetch_array($consultaAcomp);
//$justificativa=mb_convert_encoding($justificativa,"ISO-8859-1","UTF-8");
$justificativa=str_replace($quebra.$quebra,"",str_replace ($caminho_absoluto.$arquivoEnd,"",$arrayAcomp['historico']));
$justificativa=str_replace("<<An:W:\\Anexos_CI\\>>","",str_replace("<br>","",$justificativa));
	$sqlAcomp=odbc_exec($conCab,"UPDATE GEACOMP set historico='".trim($justificativa)."'
					WHERE tipo_acompanham='R'
					AND  ".$consSqlDel."
					AND rtrim(ltrim(embarque_pedido))='".trim($embarquePedido)."'") or die("Erro");
if($sqlAcomp){
	$valida=0;
	}else{
	 								$valida=1;
					 				$countError++;
	    			 				$errorMsg.='Erro['.$countError.']: Problema ao atulizar o acompanhamento.\\n'; 
		}
}

if($valida==0){
	?>
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
alert ("Deletado com Sucesso!")
window.location="<?php echo $endRet; ?>";
</SCRIPT>
<?php
	}else{
	?>
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
alert ("<?php echo $errorMsg; ?>")
window.location="<?php echo $endRet; ?>";
</SCRIPT>
<?php
	}
?>