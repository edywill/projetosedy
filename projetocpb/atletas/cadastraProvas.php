<?php 
session_start();
//require "../conectsqlserverci.php";
require "conectAtleta.php";
$userCriac=$_SESSION['userAtleta'];
$nomeCampo='';
$valida=0;
$countError=0;
$errorMsg='';

$idAtleta=$_SESSION['idAtletaSession'];

if(!empty($_POST['update'])){
$_SESSION['provAtDescSession']='Selecione';
$_SESSION['provAtSession']='0';
$_SESSION['projAtDescSession']='';
$_SESSION['projVlDescSession']='';
$_SESSION['provMaDescSession']='Selecione';
$_SESSION['provMaSession']='0';
$_SESSION['anoMarcSession']='';
$_SESSION['marcaAtSession']='';
$_SESSION['posMarcSession']='';
$classe=$_POST['classe'];
$_SESSION['classeSession']=$classe;

$modalidade=$_POST['modalidade'];
$_SESSION['idmodSession']=$modalidade;
$sqlModSession=odbc_fetch_array(odbc_exec($conCab,"SELECT descricao FROM modalidade  (nolock) WHERE id='".$modalidade."'"));
$_SESSION['descModSession']=$sqlModSession['descricao'];

$categoria=$_POST['categoria'];
$_SESSION['categoriaSession']=$categoria;

$bolsa=$_POST['bolsa'];
$_SESSION['bolsaSession']=$bolsa;

$dtatleta=$_POST['dtatleta'];
$_SESSION['dtatletaSession']=$dtatleta;

$dtheroi=$_POST['dtheroi'];
$_SESSION['dtheroiSession']=$dtheroi;

$priMelhorMarca=$_POST['pmelhormarcaprova'];
$_SESSION['primProvaSession']=$priMelhorMarca;
$sqlPrimMarcaSession=odbc_fetch_array(odbc_exec($conCab,"SELECT nome FROM prova (nolock) WHERE id='".$priMelhorMarca."'"));
$_SESSION['primProvaDescSession']=$sqlPrimMarcaSession['nome'];

$priMelhorMarcaPos=$_POST['pmelhormarcapos'];
$_SESSION['primProvaPosSession']=$priMelhorMarcaPos;

$princprova=$_POST['princprova'];
$_SESSION['princProvaSession']=$princprova;
$sqlPrincSession=odbc_fetch_array(odbc_exec($conCab,"SELECT nome FROM prova (nolock) WHERE id='".$princprova."'"));
$_SESSION['princProvaDescSession']=$sqlPrincSession['nome'];

$mmarcprova=$_POST['mmarcprova'];
$_SESSION['mmarcprovaSession']=$mmarcprova;
$sqlMmarcaSession=odbc_fetch_array(odbc_exec($conCab,"SELECT nome FROM prova (nolock) WHERE id='".$mmarcprova."'"));
$_SESSION['mmarcprovaDescSession']=$sqlMmarcaSession['nome'];

$mmarcpos=$_POST['mmarcpos'];
$_SESSION['mmarcaPosSession']=$mmarcpos;

$mmarcevento=$_POST['mmarcevento'];
$_SESSION['mmarcaEventoSession']=$mmarcevento;

$sqlUpdateAtleta=odbc_exec($conCab,"UPDATE atleta SET classe='".utf8_decode($classe)."' ,id_modal='".$modalidade."',categoria='".utf8_decode($categoria)."', bolsaatual='".$bolsa."',dtatleta='".utf8_decode($dtatleta)."',dtheroi='".utf8_decode($dtheroi)."',pmelhormarcaprov='".$priMelhorMarca."' ,pmelhormarcapos='".$priMelhorMarcaPos."',princprova='".$princprova."',memarcprova='".$mmarcprova."',memarcapos='".$mmarcpos."',memarcaevento='".utf8_decode($mmarcevento)."' WHERE id='".$idAtleta."'") or die("<p>".odbc_errormsg());
if(!$sqlUpdateAtleta){
					$valida=1;
					$countError++;
					$errorMsg.='Erro['.$countError.']: Erro ao atualizar dados.\\n';
	}else{
		$sqlConsIdLog=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id) AS id FROM log (nolock)"));
		$novoIdLog=$sqlConsIdLog['id']+1;
		$sqlLigaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log ON");
		$sqlInsertLogUpdate=odbc_exec($conCab,"INSERT INTO log(id,atleta,usuario,dthora,acao) VALUES (".$novoIdLog.",".$idAtleta.",'".utf8_decode($userCriac)."','".date("d/m/Y H:i:s")."','dados comp.')");
		$sqlDesligaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log OFF");
		}
}
if($valida==1){
?>
       				<script type="text/javascript">
       				alert("<?php echo $errorMsg; ?>");
       				window.location="novoAtleta.php";
       				</script>
       				<?php
}else{
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../ajax/funcs.js"></script>
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='../jquery.autocomplete.js'></script>
  <link rel="stylesheet" type="text/css" href="../jquery.autocomplete.css" />
<script type="text/javascript">
  $().ready(function() {
	  $("#proc").autocomplete("suggest_projeto.php", {
		  width: 510,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script type="text/javascript">
  $().ready(function() {
	  $("#empresa").autocomplete("../suggest_user.php", {
		  width: 510,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script type="text/javascript">
  $().ready(function() {
	  $("#material").autocomplete("suggest_material_ordem.php", {
		  width: 352,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script>
  $(function() {
	  $( "#datainicial" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
  <script>
  $(function() {
	  $( "#datafinal" ).datepicker({dateFormat: 'dd/mm/yy'});
  });
  </script>
<style>
    .sel { width: 70px; }
    
</style>
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
<script type='text/javascript' src='../jquery_price.js'></script>
<script type='text/javascript'>
  	  $(document).ready(function(){
      $('#vlproj').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
	   $('#ano').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: ''
      });
	$('#marca').priceFormat({
        prefix: '',
		centsLimit: 3,
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	 </script>
</head>
       
<body>
<div id='box3' style="height:auto">
    <br/>
    
<h2>DITEC - Atletas</h2>
<h3>Cadastro de Atletas de Alto Rendimento</h3> 
<br />
<div id='tabela'>
<table width="100%" border="0">
<tr><th colspan="4">DADOS DO ATLETA</th></tr>
<tr><th width="20%">Nome</th><td colspan="3"><input type="hidden" class="input" name="update" size="20" value="1"/><strong><?php echo $_SESSION['atletaSession']; ?></strong></td></tr>
<tr><th width="20%">Classe</th><td width="20%"><strong><?php echo strtoupper($_SESSION['classeSession']) ?></strong></td><th width="20%">Modalidade</th><td width="40%"><strong><?php echo strtoupper($_SESSION['descModSession']) ?></strong></td></tr>
</table>
<br /><br />
<?php 
$sqlProvaAtleta=odbc_exec($conCab,"SELECT prova.*,provasatleta.id AS ident FROM provasatleta (nolock) LEFT JOIN prova (nolock) ON provasatleta.prova_id=prova.id WHERE atleta_id='".$idAtleta."'");
$numProvaAtleta=odbc_num_rows($sqlProvaAtleta);
if($numProvaAtleta>0){
?>
<hr><hr>
<h2>PROVAS</h2>
<table width="50%" border="0">
<tr><th colspan="3">PROVAS DO ATLETA</th></tr>
<tr><th width="10%">Nº</th><th width="80%">Prova</th><th width="10%">Excluir</th></tr>
<?php 
$contProvaAtleta=0;
while($objProvaAtleta=odbc_fetch_object($sqlProvaAtleta)){
	$contProvaAtleta++;
	echo "<tr><td>".$contProvaAtleta."</td><td>".utf8_encode($objProvaAtleta->nome)."</td><td><a href='excluiProvaAtleta.php?id=".$objProvaAtleta->ident."&descr=".utf8_encode($objProvaAtleta->nome)."'>EXCLUIR</a></td></tr>";
	}
?>
</table>
<?php 
}
?>
<br/><br/>
<form action="insereProvaAtleta.php" method="post" name="patleta">
<table width="50%" border="0">
<tr><th colspan="2">INCLUIR PROVA PARA ATLETA</th></tr>
<tr><th width="30%">Prova</th><td>
<div id="select">
<select name="provAtleta">
<?php 
echo "<option selected value='".$_SESSION['provAtSession']."'>".$_SESSION['provAtDescSession']."</option>";
$sqlProvasAtleta=odbc_exec($conCab,"SELECT * FROM prova (nolock) WHERE modalidade_id='".$_SESSION['idmodSession']."'");
while($objProvasAtleta=odbc_fetch_object($sqlProvasAtleta)){
	if($objProvasAtleta->id<>$_SESSION['provAtSession']){
	echo "<option value='".$objProvasAtleta->id."'>".utf8_encode($objProvasAtleta->nome)."</option>";
		}
	}
?>
</select>
</div>
<input type="submit" name="patleta" class="buttonVerde" value="Inserir" />
</td></tr>
</table>
</form>
<br /><br />
<h2>PROJETOS</h2>
<?php 
$sqlProjAtleta=odbc_exec($conCab,"SELECT * FROM projetos (nolock) WHERE atleta_id='".$idAtleta."'");
$numProjAtleta=odbc_num_rows($sqlProjAtleta);
if($numProjAtleta>0){
?>
<table width="50%" border="0">
<tr><th colspan="3">PROJETOS VINCULADOS</th></tr>
<tr><th width="70%">PROJETO</th><th width="20%">VALOR(R$)</th><th width="10%">Excluir</th></tr>
<?php 
while($objProjAtleta=odbc_fetch_object($sqlProjAtleta)){
	echo "<tr><td>".utf8_encode($objProjAtleta->descproje)."</td><td>".$objProjAtleta->valor."</td><td><a href='excluiProjAtleta.php?id=".$objProjAtleta->id."&descr=".utf8_encode($objProjAtleta->descproje)."'>EXCLUIR</a></td></tr>";
	}
?>
</table>
<?php 
}
?>
<br/><br/>
<form action="insereProjetoAtleta.php" method="post" name="projatleta">
<table width="50%" border="0">
<tr><th colspan="2">INCLUIR PROJETO</th></tr>
<tr><th width="30%">Projeto</th><td>
<input type="text" size="36" name="projeto" class="input" value="<?php echo utf8_encode($_SESSION['projAtDescSession']); ?>"/>
</td></tr>
<tr><th width="30%">Valor (R$)</th><td>
<input type="text" size="26" name="vlproj" id="vlproj" class="input" value="<?php echo $_SESSION['projVlDescSession']; ?>" />

<input type="submit" class="buttonVerde" name="projatleta" value="Inserir" />
</td></tr>
</table>
</form>
<br /><br />
<h2>MARCAS</h2>
<?php 
$sqlMarcaAtleta=odbc_exec($conCab,"SELECT marcas.*,prova.nome FROM marcas (nolock) LEFT JOIN prova (nolock) ON marcas.prova_id=prova.id WHERE atleta_id='".$idAtleta."' ORDER BY marcas.ano DESC");
$numMarcaAtleta=odbc_num_rows($sqlMarcaAtleta);
if($numMarcaAtleta>0){
?>
<table width="50%" border="0">
<tr><th colspan="5">MARCAS DO ATLETA</th></tr>
<tr><th width="20%">ANO</th><th width="40%">PROVA</th><th width="20%">MARCA</th><th width="20%">POS/RANK</th><th width="10%">Excluir</th></tr>
<?php 
while($objMarcaAtleta=odbc_fetch_object($sqlMarcaAtleta)){
	$chave=$objMarcaAtleta->prova_id."-".$objMarcaAtleta->atleta_id."-".$objMarcaAtleta->ano;
	if(trim($objMarcaAtleta->tipo)=='m'){
		$marcaAt=number_format($objMarcaAtleta->marca,2,".","");
		}else{
			$marcaAt=number_format($objMarcaAtleta->marca,0,"","");
			$marcaAtArr=str_split(str_pad($marcaAt, 8, "0", STR_PAD_LEFT), 2);
			$marcaAt=$marcaAtArr[0].":".$marcaAtArr[1].":".$marcaAtArr[2].".".$marcaAtArr[3];
			}
	echo "<tr><td>".utf8_encode($objMarcaAtleta->ano)."</td><td>".utf8_encode($objMarcaAtleta->nome)."</td><td>".$marcaAt."</td><td>".utf8_encode($objMarcaAtleta->posicao)."</td><td><a href='excluiMarcaAtleta.php?id=".$chave."'>EXCLUIR</a></td></tr>";
	}
?>
</table>
<?php 
}
?><br/><br/>
<form action="insereMarcaAtleta.php" method="post" name="projatleta">
<table width="50%" border="0">
<tr><th colspan="2">INCLUIR MARCA</th></tr>
<tr><th width="30%">Prova</th><td>
<div id='select'>
<select name="provaMarca">
<?php 
echo "<option selected value='".$_SESSION['provMaSession']."'>".$_SESSION['provMaDescSession']."</option>";
$sqlProvMarcasAtleta=odbc_exec($conCab,"SELECT * FROM prova (nolock) WHERE modalidade_id='".$_SESSION['idmodSession']."'");
while($objProvMarcasAtleta=odbc_fetch_object($sqlProvMarcasAtleta)){
	if($objProvMarcasAtleta->id<>$_SESSION['provMaSession']){
	echo "<option value='".$objProvMarcasAtleta->id."'>".utf8_encode($objProvMarcasAtleta->nome)."</option>";
		}
	}
?>
</select></div>
</td></tr>
<tr><th width="30%">Ano</th><td>
<input type="text" size="8" name="ano" id="ano" class="input" maxlength="4" value="<?php echo $_SESSION['anoMarcSession']; ?>"/>
</td></tr>
<tr><th width="30%">Marca</th><td>
<input type="text" size="16" name="marca" id="marc" class="input" value="<?php echo $_SESSION['marcaAtSession']; ?>"/><BR /> <input type="radio" name="tipo" value='tempo' />TEMPO <input type="radio" name="tipo" value='dist'/>DISTÂNCIA
</td></tr>
<tr><th width="30%">Posição/Ranking</th><td>
<input type="text" size="16" name="posicao" id="posicao" class="input" value="<?php echo $_SESSION['posMarcSession']; ?>"/>
<input type="submit" class="buttonVerde" name="projatleta" value="Inserir" />
</td></tr>
</table>
</form>
</div><br/><br/><br/>
<form action="index.php" name="principal" method="post">
<table border="0" width="100%">
<tr><td width="30%"><a href="novoAtleta.php"><input type="button" class='buttonVerde' name='voltar' value="<<Voltar" /></a></td><td align="right"><input type="submit" class="button" value="Concluir" /></td></tr>
</table>
</form>
</div>
</body>
</html>
    <?php
	}
?>
