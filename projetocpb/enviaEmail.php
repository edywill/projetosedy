<?php 
require "functionEmail.php";
include "mb.php";

function ciAprovadaEmail($nome,$dest,$emailDest,$ci,$desc,$contAnt,$descContAnt,$contNovo,$descContNovo,$pag,$cont){
	//$emailDest='edy@cpb.org.br';
	require "conectsqlserverci.php";
	$descContAnt=mb_convert_encoding($descContAnt,"ISO-8859-1","UTF-8");
	$descContNovo=mb_convert_encoding($descContNovo,"ISO-8859-1","UTF-8"); //Controle novo da CI
   	$sqlDesc=odbc_exec($conCab,"Select
  COSOLICI.Desc_cond_pag
From
  COSOLICI  (nolock)
  WHERE COSOLICI.Solicitacao='".$ci."'") or die("Erro");
	$arrayDesc=odbc_fetch_array($sqlDesc);
	$desc=$arrayDesc['Desc_cond_pag'];
	$assunto="[CIGAM] CI : ".$ci." - ENCAMINHADA VIA WEB";

	$mensagem3 = "Prezado (a) <strong>".strtoupper($dest)."</strong>";
	$mensagem3 .= "<br \><br \>Favor analisar a C.I numero ".$ci.", para continuidade no processo . 
<br><br><strong>Ci Aprovada por:</strong> ".$nome."<br> 
<strong>Controle Anterior:</strong>".$contAnt."-".$descContAnt." <br>
<strong>Controle Novo:</strong>".$contNovo."-".$descContNovo." <br>
<strong>Descri&ccedil;&atilde;o:</strong>".$desc." <br>
<br>
Atenciosamente<br><br>

<strong>".strtoupper($nome)."</strong>";
	$confirmacao='CI alterada com sucesso!';
//$endRet=$_POST['retorno'].'?usuario='.$_POST['user_ci'];
if($pag=='ciweb'){
	$endRet="ciWeb.php?usuario=".strtoupper($nome);
}elseif($pag=='sav'){
	$endRet="aprovacaoGestor.php";
	}else{
	$endRet="ciWMenu.php?usuario=".strtoupper($nome);
	}
	$assunto=mb_convert_encoding($assunto,"UTF-8","ISO-8859-1");
	enviaEmail($assunto,$mensagem3,$endRet,$emailDest,$dest,$cont);
}
function ciReprovadaEmail($nome,$dest,$emailDest,$ci,$desc,$contAnt,$descContAnt,$contNovo,$descContNovo,$pag,$cont,$recusa){
	//$emailDest='edy@cpb.org.br';
	require "conectsqlserverci.php";
	$descContAnt=mb_convert_encoding($descContAnt,"ISO-8859-1","UTF-8");
	$descContNovo=mb_convert_encoding($descContNovo,"ISO-8859-1","UTF-8");
	$mensagemGestor=utf8_encode($recusa);
	 //Controle novo da CI
   	$sqlDesc=odbc_exec($conCab,"Select
  COSOLICI.Desc_cond_pag
From
  COSOLICI  (nolock)
  WHERE COSOLICI.Solicitacao='".$ci."'") or die("Erro");
	$arrayDesc=odbc_fetch_array($sqlDesc);
	$desc=$arrayDesc['Desc_cond_pag'];
	$assunto="[CIGAM] CI : ".$ci." - RECUSADA VIA WEB";

	$mensagem3 = "Prezado (a) <strong>".strtoupper($dest)."</strong>";
	$mensagem3 .= "<br \><br \>A C.I numero ".$ci.", foi recusada.<br>
	O gestor deixou a seguinte observa&ccedil;&atilde;o: ".$recusa." 
<br><br><strong>Ci Recusada por:</strong> ".$nome."<br> 
<strong>Controle Anterior:</strong>".$contAnt."-".$descContAnt." <br>
<strong>Controle Novo:</strong>".$contNovo."-".$descContNovo." <br>
<strong>Descri&ccedil;&atilde;o:</strong>".$desc." <br>
<br>
Atenciosamente<br><br>

<strong>".strtoupper($nome)."</strong>";
	$confirmacao='CI alterada com sucesso!';
//$endRet=$_POST['retorno'].'?usuario='.$_POST['user_ci'];
if($pag=='ciweb'){
	$endRet="ciWeb.php?usuario=".strtoupper($nome);
}elseif($pag=='sav'){
	$endRet="aprovacaoGestor.php";
	}else{
	$endRet="ciWMenu.php?usuario=".strtoupper($nome);
	}
	$assunto=mb_convert_encoding($assunto,"UTF-8","ISO-8859-1");
	enviaEmail($assunto,$mensagem3,$endRet,$emailDest,$dest,$cont);
}
?>