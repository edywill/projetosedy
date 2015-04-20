<?php 
session_start();
include "../mb.php";
//require "../conectsqlserverci.php";
require "conectAtleta.php";
$userCriac=$_SESSION['userAtleta'];
$idAtleta=$_SESSION['idAtletaAval'];
$valida=0;
$_SESSION['justAtAval']=$_POST['justificativa'];
$sqlAvalia=odbc_fetch_array(odbc_exec($conCab,"SELECT id FROM avalia (nolock) WHERE atleta_id='".$idAtleta."'"));
if(!empty($sqlAvalia['id'])){
	$updateAvalia=odbc_exec($conCab,"UPDATE avalia SET parecer='".$_POST['parecer']."', justificativa='".utf8_decode($_POST['justificativa'])."' WHERE id=".$sqlAvalia['id']."");
	}else{
		$sqlMaxIdAval=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id) AS id FROM avalia"));
		$novoIdAval=$sqlMaxIdAval['id']+1;
		$sqlLigaIdAvalia=odbc_exec($conCab,"SET IDENTITY_INSERT avalia ON");
		$insereAvalia=odbc_exec($conCab,"INSERT INTO avalia (id,atleta_id,responsavel,parecer,justificativa) VALUES (".$novoIdAval.",".$idAtleta.",'".$userCriac."','".$_POST['parecer']."','".utf8_decode($_POST['justificativa'])."')") or die("<p>".odbc_errormsg());
		$sqlDesLigaIdAvalia=odbc_exec($conCab,"SET IDENTITY_INSERT avalia OFF");
		}
if($valida==0){
	$sqlConsIdLog=odbc_fetch_array(odbc_exec($conCab,"SELECT max(id) AS id FROM log (nolock)"));
	$novoIdLog=$sqlConsIdLog['id']+1;
	$sqlLigaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log ON");
	$sqlLogAtleta=odbc_exec($conCab,"INSERT INTO log(id,atleta,usuario,dthora,acao) VALUES ('".$novoIdLog."','".$idAtleta."','".$userCriac."','".date("d/m/Y H:i:s")."','avaliação inserida para o atleta')");
	$sqlDesligaIdLog=odbc_exec($conCab,"SET IDENTITY_INSERT log OFF");
$nomeCampo='';
$valida=0;
$countError=0;
$errorMsg='';
$sqlDadosAtleta=odbc_fetch_array(odbc_exec($conCab,"SELECT atleta.*,modalidade.descricao,(SELECT nome FROM prova (nolock) WHERE id=atleta.pmelhormarcaprov) AS provamelhor, (SELECT nome FROM prova (nolock) WHERE id=atleta.princprova) AS provaprincipal, (SELECT nome FROM prova (nolock) WHERE id=atleta.memarcprova) AS provamelhormarca FROM atleta (nolock) LEFT JOIN modalidade (nolock) ON modalidade.id=atleta.id_modal WHERE atleta.id=".$_SESSION['idAtletaAval'].""));

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
      $('#bolsa').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
	  $('#mmarcpos').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: '.'
      });
	$('#pmelhormarcapos').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: '.'
      });
	$('#dtatleta').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: ''
      });
	$('#dtheroi').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: ''
      });
    });
	 </script>
     <script src="../ckeditor/ckeditor.js"></script>
<style type="text/css">
<!--
.titulo {
	font-size: 18px;
}
.titulo_footer {
	font-weight: bold;
	text-align: center;
}
-->
body{
	font:70% verdana; 
	color:#000000;
}
</style>

<style media="print">
.botao {
display: none;
}
body{
	font:70% verdana; 
	font-color:#000000;
}
#tabela table{
	font-family:verdana;
	width:100%;
	border-collapse:collapse;
}
#tabela  table td, th
{
	/*border:1px solid #2424FF;*/
	border:1px solid #215D63;
	padding:3px 7px 2px 7px;
}
#tabela  table th
{
	font-size:13px;
	text-align:left;
	padding-top:5px;
	padding-bottom:4px;
	/*background-color:#0080FF;*/
	background-color:#E6E6E6;
	color:#000000;
	
}
#tabela  table tr.alt td
{
	color:#000;
	background-color:#D6EDFF;
}
</style>

</head>
<body>
<div id='box3' style="height:auto">
    <br/>
<div id='impressao'>
<div id='container2'>
<p align="center"><img src="../prestcont/css/Logo_CPB_transparente.png" style="border:hidden" width="113" height="140"/></p>
<h3 align="center">Avaliac&atilde;o de Atletas - DITEC/CPB</h3> 
<p align="right">Brasília-DF, <?php echo date("d/m/Y"); ?></p>
<br />
<div align="right"><a href='javascript:;' class='botao' onclick='window.print();return false'><strong>Imprimir</strong></a></div>
<div id='tabela'>
<table width="100%" border="0">
<tr><th colspan="2">DADOS DO ATLETA</th></tr>
<tr><th width="30%">Nome</th><td><?php echo utf8_encode($sqlDadosAtleta['nome']); ?></td></tr>
<tr><th width="30%">Classe</th><td><?php echo utf8_encode($sqlDadosAtleta['classe']); ?></td></tr>
<tr><th width="30%">Modalidade</th><td><?php echo utf8_encode($sqlDadosAtleta['descricao']); ?></td></tr>
<tr><th width="30%">Categoria</th><td><?php echo utf8_encode($sqlDadosAtleta['categoria']); ?></td></tr>
<tr><th width="30%">Bolsa Atual (R$)</th><td><?php echo utf8_encode($sqlDadosAtleta['bolsaatual']); ?></td></tr>
<tr><th width="30%">Entrada no Programa</th><td><strong>Atleta:</strong> <?php echo utf8_encode($sqlDadosAtleta['dtatleta']); ?><br />
												<strong>Her&oacute;i:</strong> <?php echo utf8_encode($sqlDadosAtleta['dtheroi']); ?></td></tr>
<tr><th width="30%">Primeira Melhor Posi&ccedil;&atilde;o no Programa</th><td><?php
echo utf8_encode($sqlDadosAtleta['pmelhormarcapos'])."&ordf;/".utf8_encode($sqlDadosAtleta['provamelhor']); ?></td></tr>
<tr><th width="30%">Provas que Participa</th><td>
<table border="0" width="50%">
<?php 
$sqlProvasAt=odbc_exec($conCab,"SELECT prova.nome FROM provasatleta (nolock) INNER JOIN prova (nolock) ON provasatleta.prova_id=prova.id WHERE provasatleta.atleta_id='".$sqlDadosAtleta['id']."'");
while($objProvasAt=odbc_fetch_object($sqlProvasAt)){
	echo "<tr><td>".utf8_encode($objProvasAt->nome)."</td></tr>";
	}
?>
</table>
</td></tr>
<tr><th width="30%">Principal Prova</th><td><?php echo utf8_encode($sqlDadosAtleta['provaprincipal']); ?></td></tr>
<tr><th width="30%">Melhor Marca da Vida</th><td><strong>Marca/Pos/Ranking:</strong><?php echo utf8_encode($sqlDadosAtleta['memarcapos']); ?><br /><strong>Prova: </strong> <?php echo utf8_encode($sqlDadosAtleta['provamelhormarca']); ?><br /><strong>Evento: </strong> <?php echo utf8_encode($sqlDadosAtleta['memarcaevento']); ?></td></tr>
<tr><th width="30%">Projetos</th><td>
<table border="0" width="50%" id="tabela3">
<?php 
$sqlProjetosAt=odbc_exec($conCab,"SELECT * FROM projetos (nolock) WHERE atleta_id='".$sqlDadosAtleta['id']."'");
while($objProjetosAt=odbc_fetch_object($sqlProjetosAt)){
	echo "<tr><td>".utf8_encode($objProjetosAt->descproje)."</td><td>R$".$objProjetosAt->valor."</td></tr>";
	}
?>
</table>

<tr><th width="30%">Marcas Por Ano</th><td>
<table border="0" width="100%" id="tabela3">
<?php 
$sqlMarcasAt=odbc_exec($conCab,"SELECT marcas.ano FROM marcas (nolock) WHERE marcas.atleta_id='".$sqlDadosAtleta['id']."' GROUP BY marcas.ano");
while($objMarcasAt=odbc_fetch_object($sqlMarcasAt)){
	echo "<tr><th colspan='3'>".utf8_encode(trim($objMarcasAt->ano))."</th></tr>";
	$sqlDadosMarca=odbc_exec($conCab,"SELECT marcas.*,prova.nome FROM marcas (nolock) LEFT JOIN prova (nolock) ON marcas.prova_id=prova.id WHERE marcas.ano='".$objMarcasAt->ano."' AND marcas.atleta_id=".$sqlDadosAtleta['id']."");
	echo "<tr><td><strong>PROVA</strong></td><td><strong>MARCA</strong></td><td><strong>POSI&Ccedil;&Atilde;O/RANK</strong></td></tr>";
	while($objDadosMarca=odbc_fetch_object($sqlDadosMarca)){
		if(trim($objDadosMarca->tipo)=='m'){
		$marcaAtleta=number_format($objDadosMarca->marca,3,",",".");
		}else{
			$marcaAtleta=number_format($objDadosMarca->marca,0,"","");
			$marcaAtletaArr=str_split(str_pad($marcaAtleta, 8, "0", STR_PAD_LEFT), 2);
			$marcaAtleta=$marcaAtletaArr[0].":".$marcaAtletaArr[1].":".$marcaAtletaArr[2].".".$marcaAtletaArr[3];
			}
		echo "<tr><td>".utf8_encode($objDadosMarca->nome)."</td><td>".$marcaAtleta."</td><td>".$objDadosMarca->posicao."&ordf;</td></tr>";
		}
	}
?>
</table>
</td></tr>
<tr><th width="30%">GRÁFICOS</th><td align="right">
<iframe src="grafmesImp.php" width="500" height="450" style="border:hidden" scrolling="no"></iframe>
</td></tr>
</table>
</div>
<div id='tabela'>
<form action="insereAvaliacao.php" method="post" name="avalia">
<table width="100%" border="0">
<tr><th colspan="2">AVALIAÇÃO</th></tr>
<tr>
	<th width="20%">PARECER</th>
    <td>
		<?php 
		$sqlAvaliaQuery=odbc_exec($conCab,"SELECT * FROM avalia WHERE atleta_id='".$_SESSION['idAtletaAval']."'") or die("<p>".odbc_errormsg());
		$sqlAvaliacao=odbc_fetch_array($sqlAvaliaQuery);
		if($sqlAvaliacao['parecer']=='RENOVA'){
		    echo "<h3><font color='green'>RENOVA</font></h3>";	
			}elseif($sqlAvaliacao['parecer']=='CANCELA'){
				echo "<h3><font color='red'>CANCELA</font></h3>";	
				}
        ?>
	</td>
</tr>
<tr>
	<th colspan="2">JUSTIFICATIVA</th>
</tr>
<tr>
	<td colspan="2">
        <?php
		if(empty($_SESSION['justAtAval'])){
				$_SESSION['justAtAval']=utf8_encode($sqlAvaliacao['justificativa']);
				}
		echo nl2br($_SESSION['justAtAval']);
		?>
	</td>
</tr>
<tr>
	<td colspan="2">
        ANALISADO POR:<BR />
		
		<p align="center">___________________________________________<br /><?php
			echo $userCriac;
		?>
        </p>
        APROVADO POR:<BR />
		
		<p align="center">___________________________________________<br /><?php
			echo "EDILSON ALVES DA ROCHA"
		?>
        </p>
	</td>
</tr>
</table>
</div>
<div 
<table border="0" width="100%">
<tr>
<td width="30%">
<a href="avaliacao.php"><input type="button" class='botao'  name='voltar' value="<<Voltar" /></a></td>
<td align="right"><div align="right"><a href='javascript:;' class='botao' onclick='window.print();return false'><strong>Imprimir</strong></a></div></td></tr>
</table>
</form>
</div></div>
</div>
</body>
</html>
       				<?php
}else{
					?>
       				<script type="text/javascript">
       				alert("<?php echo $errorMsg; ?>");
       				window.location="index.php";
       				</script>
       				<?php
}
?>