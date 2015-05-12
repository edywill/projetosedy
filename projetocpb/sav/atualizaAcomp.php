<?php 
//Atualiza acompanhamento da Capa da CI
		$solicitacaoAcomp=str_pad($solicitacao, 8, " ", STR_PAD_LEFT);
		$justificativa="Solicitação criada a partir da SAV do funcionário ".$_SESSION['nomeSav']." para o evento ".utf8_encode($arrayRegistro['evento']).".  
		Objetivo: ";
		$justificativa.=utf8_encode($arrayRegistro['objetivo'])."
		";
		if(!empty($arrayRegistro['observ'])){
			$justificativa.="Observações: ".utf8_encode($arrayRegistro['observ'])."";
			}
		//$justificativa=mb_convert_encoding($justificativa,"ISO-8859-1","UTF-8");
		$justificativa=str_replace("?","-",$justificativa);
		$justificativa=str_replace("'","\"",$justificativa);
		$justificativa=addslashes($justificativa);
		$justificativa=str_replace("\\\\","\\",$justificativa);
$sqlInsAcomp="UPDATE GEACOMP SET 
   usuario='".$userCriac."',
   data=dbo.CGFC_DATAATUAL(), 
   hora='".date("His")."',
   historico='".utf8_decode($justificativa)."'
   WHERE embarque_pedido='".$solicitacaoAcomp."'"; 
   $resSqlInsAcomp=odbc_exec($conCab2, $sqlInsAcomp) or die("<p>".odbc_errormsg());
?>