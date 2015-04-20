<?php
session_start();
require "conectsqlserverci.php";
require "conect.php";
include "mb.php";
$user=$_POST['usuario'];
$numCi=$_POST['numCi'];
$sqlUserCigam=mysql_query("SELECT controle FROM usuarios WHERE cigam='".$user."'");
$arrayUserCigam=mysql_fetch_array($sqlUserCigam);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<script language=javascript> 
function janelaSecundaria (URL){ 
   window.open(URL,"janela1","width=400,height=300,scrollbars=NO") 
} 
</script> 
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script type="text/javascript">
function limitaTextarea(valor) {
	quantidade = 1999;
	total = valor.length;

	if(total <= quantidade) {
		resto = quantidade- total;
		document.getElementById('contador').innerHTML = resto;
	} else {
		document.getElementById('justificativa').value = valor.substr(0, quantidade);
	}
}
</script>
<script type="text/javascript">
function goBack()
  {
  window.history.back()
  }
</script>
</head>
<body>
<div id='box3'>
<br/>
<strong>CIWEB  - <?php
if($_POST['retorno']=='ciWResCons.php'){
	echo "Atualizar Solicita&ccedil;&atilde;o:";
	}else{
$_SESSION['cdMaterialS']='';
$_SESSION['quantidadeItemS']='';
$_SESSION['precoUnitS']='';
$_SESSION['pzentS']='';
$_SESSION['justItemS']='';

	echo "Criar Solicita&ccedil;&atilde;o:<br><br><ul><li>Para finalizar a CI sem alterar o controle, clique no bot&atilde;o sair. 
		<form action='home.php'><input type='submit' name='sair' value='SAIR' class='button'/></form><br><br></li>
	<li>Para continuar trabalhando na CI, sem alterar o controle clique no bot&atilde;o voltar.
		<form action='".$_POST['retorno']."'><input type='submit' class='button' value='Voltar'></form><br><br></li>
	<li>Para alterar o controle, selecione o novo controle na lista e clique em ATUALIZAR CONTROLE.<br>
	Lembre-se que CIs com controles alterado n&atilde;o podem mais ser atualizadas pela Web.</li></ul><br>";
		}
?></strong><br/>
<strong>ALTERAR CONTROLE</strong>
 <strong>CI N&ordm;:<font size="3" color="red"> <?php echo $numCi; ?></font></strong><br /><br />
<form action="ciWAtCo.php" method="post"><table><tr><td><strong>Controle Atual:</td><td><?php echo $_POST['codControle']."-".mb_convert_encoding($_POST['descControle'], "UTF-8", mb_detect_encoding($_POST['descControle'], "UTF-8, ISO-8859-1, ISO-8859-15", true)); ?></strong></td></tr>
<tr><td> <strong>Alterar Controle para: </strong></td>
<td>
<input name="user" type="hidden" value="<?php echo $user; ?>" />
<input name="numCi" type="hidden" value="<?php echo $numCi; ?>" />
<input name="codCon" type="hidden" value="<?php echo $_POST['codControle']; ?>" />
<input name="descCi" type="hidden" value="<?php echo $_POST['descCi']; ?>" />
<div id="select"><select class='select' name="controleNovo"><option selected="selected">Selecione</option>
<?php
$conf="and (con.controle = '13'
						or con.controle = '14'
						or con.controle = '15'
						or con.controle = '17'
						or con.controle = '18'
						or con.controle = '19')";
if($arrayUserCigam['controle']=='EP'){
	$conf.=" or (con.controle = 'AP'
			or con.controle = 'RP')";
	}elseif($arrayUserCigam['controle']=='05'){
		$conf.=" or (con.controle = 'EP'
						or con.controle='16')";
		}elseif($arrayUserCigam['controle']>='13' || $arrayUserCigam['controle']<='19' ){
			if($arrayUserCigam['controle']=='16'){
			$conf.=" or con.controle = 'EP'";
			  }
			}
$queryControles=odbc_exec($conCab,"select con.controle,
       con.descricao
from COCSO con (nolock)
where con.controle <> '".trim($_POST['codControle'])."'
".$conf."
and not exists(select 1
               from TEPARAMVERBA par (nolock)
               where charindex(con.controle,par.ctrl_aprov_diaria+
                                            par.ctrl_aprov_rpa,0) > 0)
order by con.controle
") or die(odbc_error());

while($objControle=odbc_fetch_object($queryControles)){
echo "<option value='".$objControle->controle."'>".$objControle->controle."-".mb_convert_encoding($objControle->descricao, "UTF-8", mb_detect_encoding($objControle->descricao, "UTF-8, ISO-8859-1, ISO-8859-15", true))."</option>";
}
?>
       <script type="text/javascript">
       alert("Aten\u00e7\u00e3o! Ao alterar o controle a CI, ela n\u00e3o podera mais ser alterada pela WEB.");
       </script>
       <?php
?>
</select></div></td></tr>
<tr><td><input class="buttonVerde" name="atJus" type="submit" value="Atualizar Controle" /></td></tr></table></form><br>
<?php 
if($_POST['retorno']=='ciWResCons.php'){
	echo "<form action='".$_POST['retorno']."'><input class='button' type='submit' value='Voltar'></form>";
	}
?>
</div>
</body>
</html>