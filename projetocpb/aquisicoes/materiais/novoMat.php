<?php 
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";
$userCriac=$_SESSION['userAquis'];
		$criar=0;
		$idGrupo='';
		$grupoDesp='';
		$idMatCigam='';
		$descMatCigam='';
		$material='';
		$botao="Cadastrar";
		if(!empty($_POST['idatu'])){
		$sqlRegAtu=mysql_fetch_array(mysql_query("SELECT aquicadmat.nome,aquicadmat.cdmat,aquicadmat.grupo,aquigrupo.codigo,aquigrupo.descricao FROM aquicadmat LEFT JOIN aquigrupo ON aquigrupo.id=aquicadmat.grupo WHERE aquicadmat.id='".$_POST['idatu']."'"));
		if(empty($sqlRegAtu)){
			?>
       <script type="text/javascript">
       alert("Registro inexistente");
       window.location="index.php";
       </script>
       <?php
			}else{
				$idGrupo=$sqlRegAtu['grupo'];
		$grupoDesp=$sqlRegAtu['codigo']."-".utf8_encode($sqlRegAtu['descricao']);
		$buscaDadosMatCigam=odbc_fetch_array(odbc_exec($conCab,"SELECT Descricao
FROM ESMATERI (nolock) 
WHERE Cd_reduzido='".$sqlRegAtu['cdmat']."'"));
$idMatCigam=$sqlRegAtu['cdmat'];
$descMatCigam=utf8_encode($buscaDadosMatCigam['Descricao']);
$material=utf8_encode($sqlRegAtu['nome']);
		$criar=$_POST['idatu'];
		$_SESSION['idGrupoSession']=$idGrupo;
		$_SESSION['dadosGrupoSession']=$grupoDesp;
		$botao="Atualizar";
			}
			}elseif(!empty($_SESSION['idGrupoSession'])){
				$idGrupo=$_SESSION['idGrupoSession'];
				$sqlDadoGrupo=mysql_fetch_array(mysql_query("SELECT * FROM aquigrupo WHERE id='".$idGrupo."'"));
				$_SESSION['dadosGrupoSession']=$sqlDadoGrupo['codigo'].'-'.utf8_encode($sqlDadoGrupo['descricao']);
				}
				$matCigam='';
				if(!empty($idMatCigam)){
					$matCigam=$idMatCigam."-".$descMatCigam;
					}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<link href="../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../../ajax/funcs.js"></script>
<script src="../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../jqueryDown/jquery-1.9.0-ui.css" />
<script src="../../jqueryDown/jquery-ui.js"></script>
<script language="javascript" src="script.js" type="text/javascript"></script>
<script src="../../sav/jquerymensagem/jquery_jui_alert.js">
</script>

<script src='../../jquery.autocomplete.js'></script>
  <link rel="stylesheet" type="text/css" href="../../jquery.autocomplete.css" />
  
  <script type="text/javascript">
  $().ready(function() {
	  $("#cigam").autocomplete("../../suggest_material.php", {
		  width: 508,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script type="text/javascript">
function  reescreveTabelas(){
// Verificando Browser
if(window.XMLHttpRequest) {
req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "reescreveDados.php";

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

document.getElementById('mensagens').innerHTML=resposta;
}
}
req.send(null);
	}

</script>
<style>
    .sel { width: 70px; }
    
</style>
<style type="text/css"><!--
	
	        /* style the auto-complete response */
	        li.ui-menu-item { font-size:12px !important; }
	
	--></style>
<script language="javascript">
<!--
function aumenta(obj){
    obj.height=obj.height*1.2;
	obj.width=obj.width*1.2;
}
 
function diminui(obj){
	obj.height=obj.height/1.2;
	obj.width=obj.width/1.2;
}
//-->
</script>

</head>
       
<body>
<div id='box3' style="height:auto">
    <br/>
    
<h2>AQUISIÇÕES</h2>
<h3>Material</h3>  

<div id='tabela'>
<form action="salvaMaterial.php" name="insere" method="post" id="insere" onSubmit="setarCampos(this); enviarForm('salvaMaterial.php', campos, 'divResultado'); return false;">
<table width="100%" border="0">
<tr><th width="20%">Referência CIGAM</th><td>
<input type="text" name="cigam" id="cigam" class="input" size="60" value="<?php echo $matCigam; ?>"/><br /><font size="-1">(*)Digite parte do nome e selecione na lista</font>
</td></tr>
<tr><th width="20%">Nome do Material</th><td><input type='hidden' name='criar' id='criar' class='input' value='<?php echo $criar; ?>'/>
<input type="text" name="nome" id="nome" class="input" size="60" value="<?php echo $material; ?>" maxlength="99"/>

</td></tr>
<tr><th width="20%">Grupo de Despesa</th><td>
<select name="grupoDesp" id="grupo">
<?php 
if(!empty($grupoDesp)){
	echo "<option value='".$idGrupo."' selected='selected'>".$grupoDesp."</option>";
	}else{
	echo "<option value='0' selected='selected'>Selecione o Grupo</option>";
	}
$sqlGrupos=mysql_query("SELECT * FROM aquigrupo WHERE inativo=0 ORDER BY descricao") or die(mysql_error());
while($objGrupos=mysql_fetch_object($sqlGrupos)){
	echo "<option value='".$objGrupos->id."'>".$objGrupos->codigo."-".utf8_encode($objGrupos->descricao)."</option>";
	}
?>
</select>
</td></tr>
<tr><td width="20%"><a href="index.php"><input type="button" name="submit" class="button" value="<<Voltar" /></a></td><td align="right"><input type="submit" name="submit" class="button" value="<?php echo $botao; ?>" /></td></tr>
</table>
</form>
<script>

//Cria a função com os campos para envio via parâmetro

function setarCampos() {
	campos = "cigam="+encodeURI(document.getElementById('cigam').value)+"&nome="+encodeURI(document.getElementById('nome').value)+"&grupo="+encodeURI(document.getElementById('grupo').value)+"&criar="+encodeURI(document.getElementById('criar').value);
}
</script>
<div id="divResultado"></div>
<br />
<div id="mensagens">
<?php
if(!empty($_SESSION['idGrupoSession'])){
$sqlMateriaisGrupo=mysql_query("SELECT aquigrupo.codigo,aquigrupo.descricao,aquicadmat.id,aquicadmat.nome,aquicadmat.cdmat FROM aquicadmat LEFT JOIN aquigrupo ON aquicadmat.grupo=aquigrupo.id
WHERE aquigrupo.inativo=0 AND aquicadmat.inativo=0 AND aquigrupo.id='".$_SESSION['idGrupoSession']."'
ORDER BY aquigrupo.id");
$countMateriais=mysql_num_rows($sqlMateriaisGrupo);
if($countMateriais>0){
?>
<table border="1" width="100%">
<tr><th colspan="4">MATERIAIS DO GRUPO DE DESPESA <u><?php echo $_SESSION['dadosGrupoSession'];?></u></th></tr>
<tr><th width="35%">MATERIAL</th><th  width="35%">MATERIAL (CIGAM)</th><th  width="15%">EDITAR</th><th  width="15%">INATIVAR</th></tr>
<?php 
while($objMateriaisGrupo=mysql_fetch_object($sqlMateriaisGrupo)){
	$buscaMatCigam=odbc_fetch_array(odbc_exec($conCab,"SELECT Descricao
FROM ESMATERI (nolock) 
WHERE Cd_reduzido='".$objMateriaisGrupo->cdmat."'"));
	echo "<tr><td>".utf8_encode($objMateriaisGrupo->nome)."</td><td>".$objMateriaisGrupo->cdmat."-".utf8_encode($buscaMatCigam['Descricao'])."</td><td><form action='novoMat.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMateriaisGrupo->id."'/><input type='submit' name='edit' value='Editar' class='button'/></form></td><td><form action='inativarMat.php' method='post' name='rel'><input type='hidden' name='idinat2' value='".$objMateriaisGrupo->id."'/><input type='submit' name='inat' value='Inativar' class='button'/></form></td></tr>";
	}
?>
</table>

<?php 
 }
}
?>
</div>
</div>
</div>
</body>
</html>