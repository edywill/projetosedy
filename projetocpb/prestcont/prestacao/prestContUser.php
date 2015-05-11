<?php
//Ajustar layout
//Fazer novos testes
//Incluir with NOLOCK nos selects e deixar (nolock) nos joins

session_start();
require "../../conectsqlserver.php";
require "../../sav/conectsqlserversav.php";
require "../../conect.php";
$obs='';
if(!empty($_POST['nome'])){
$funcionario=$_POST['nome'];
$_SESSION['funcPrestCont']=$funcionario;
}

if(!empty($_POST['id'])){
	$_SESSION['idPrestCont']=$_POST['id'];
	}
if(!empty($_GET['id'])){
	$_SESSION['idPrestCont']=$_GET['id'];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../../sav/css/estilo.css"/>
<link rel="stylesheet" href="../../datatables/estilo/table_jui.css" />
<link rel="stylesheet" href="../../datatables/estilo/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" href="../../jquery.autocomplete.css" />
<script type="text/javascript" src="../../datatables/js/jquery.mim.js"></script>
<script type="text/javascript" src="../../datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var oTable = $('#tabela4').dataTable({
		"bPaginate": true,
		"bNext":'Proximo',
		"bJQueryUI": true,
		"bDestroy":true,
		"bProcessing": true,
		"bServerSide": false,
		"sPaginationType": "full_numbers",
		"order": [[ 0, "desc" ]]
	});
});
</script>
  <script type="text/javascript">
  function mostra(){
	  if(window.onload){
		  document.getElementById('lendo').style.display="none"
		  document.getElementById('conteudo').style.visibility="visible"
		  }
	  }
	  window.onload=mostra
  </script>
  <style>
  .invisivel { display: none; }
  .visivel { visibility: visible; }
  </style>
  <style type="text/css">
  .imgpos{
	  position:absolute;
	  left:50%;
	  top:50%;
	  margin-left:-110px;
	  margin-top:-60px;
	  width:200px;
	  height:200px;
	  z-index:2;
	  }
  </style>
 <script src="../../jqueryDown/jquery-1.9.2-ui.js"type="text/javascript" language="javascript"></script>
<script src="../../jqueryupload/jquery.MultiFile.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function () {
    //hide a div after 3 seconds
    setTimeout( "jQuery('#mensagensArquivo').hide();document.getElementById('mensagensArquivo').innerHTML='';",10000 );
});
function mostraDiv(){
	jQuery('#mensagensArquivo').show();
	setTimeout( "jQuery('#mensagensArquivo').hide();					 document.getElementById('mensagensArquivo').innerHTML='';",10000 );
	}
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
valor=document.getElementById('sav').value;
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "reescreveDados.php?id="+valor;

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

// Verifica se o Ajax realizou todas as operações corretamente
if(req.readyState == 4 && req.status == 200) {

// Resposta retornada pelo busca.php
var resposta = req.responseText;

document.getElementById('conteudo').innerHTML=resposta;
}
}
req.send(null);
	}

</script>
</head>
<body onKeyDown="javascript:return bloqueioTeclas();">
<div id='box3' style="height:auto">
<div id='lendo' style="padding-top:60px; padding-left:10px">
<h1 id="h1">Carregando dados...</h1>
<img src="../../datatables/ajax-loader.gif" alt="preload" border="0" />
</div>
<div id='conteudo' style='visibility:hidden'>
    <br/>
    
<h1 id="h1">Prestação de Contas - (SAV)</h1>

<form action="salvaPrestCont.php" name="nova" enctype="multipart/form-data" method="post">
<table border="0" width="100%">
<tr>
<?php 
if(empty($_SESSION['idPrestCont'])){
?>
<td colspan="2">
<h2 id="h2">Iniciar Prestação de Contas</h2>
</td></tr><tr><td>
<strong>Viagem:</strong> 
<input type="hidden" class="input" name="tp" id="tp" value="criar"/>
<?php 
$sqlRegistros=mysql_query("SELECT savregistros.* FROM savregistros where savregistros.funcionario='".$funcionario."' AND situacao<>'Cancelada'");
$countReg=mysql_num_rows($sqlRegistros);
$tipo=0;
if($countReg<1){
	echo "<script>alert('Nenhuma viagem disponível!');window.location.href='prestUser.php';</script>"; 
	}

?>
<select name="sav" id="sav">
<option selected="selected" value="">Selecione</option>
<?php
while($objRegistros=mysql_fetch_object($sqlRegistros)){
echo "<option value='".$objRegistros->id."'>".utf8_encode($objRegistros->numci)."-".utf8_encode($objRegistros->evento)."-".$objRegistros->abrangencia." (Ida: ".$objRegistros->dtida." / Volta: ".$objRegistros->dtvolta.")</option>";
}
?>

    </select>
  <?php 
}else{
	$tipo=1;
	$sqlRegistros=mysql_fetch_array(mysql_query("SELECT savregistros.*,prestsav.obs FROM savregistros LEFT JOIN prestsav ON savregistros.id=prestsav.savid where prestsav.id='".$_SESSION['idPrestCont']."'"));
	$numSav=$sqlRegistros['id'];
	$obs=utf8_encode($sqlRegistros['obs']);
	echo '<td colspan="2">
<h2 id="h2">Alterar Prestação de Contas</h2>
';
	echo "<div align='center'>
	<input type='hidden' name='sav' value='".$sqlRegistros['id']."'>
	<strong>".utf8_encode($sqlRegistros['evento'])."-".$sqlRegistros['abrangencia']." (Ida: ".$sqlRegistros['dtida']." / Volta: ".$sqlRegistros['dtvolta'].")</strong></div><br>";
	}
  ?>  
    </td><td></td></tr></table>
    <?php 
	if(!empty($_SESSION['idPrestCont'])){
		$sqlArquivos=mysql_query("SELECT * FROM prestsavarq WHERE idprest='".$_SESSION['idPrestCont']."'");
		$countArquivos=mysql_num_rows($sqlArquivos);
		if($countArquivos>0){
		echo "<table border='0' width='100%'>
		<tr bgcolor='#336699'><td><font color='white'><strong>Arquivos da Prestação de Contas</strong></font></td><tr>";
		while($objArquivos=mysql_fetch_object($sqlArquivos)){
			$linkarquivo=utf8_encode($objArquivos->arquivo);
			$nomeArr=explode("/",$linkarquivo);
			$nomeArquivo=$nomeArr[1];
			echo "<tr bgcolor='white'><td><a href='".$linkarquivo."' target='_blank'>".$nomeArquivo."</a> <a href='excluiArq.php?idarq=".$objArquivos->id."'><img src='../../imagens/excluir_mini.jpg' width='15px' height='15px'/></a></td><tr>";
			}
		echo "</table>";
		}
		}	
	?>
   <p></p>
 
<table border="0" width="100%">
<tr>
  <td width="10%"><strong>Arquivos:</strong></td><td>
  <input type="hidden" name="MAX_FILE_SIZE" value="200000" />
<input type="file" name="arquivos[]" id="arquivos" multiple="multiple"  class="multi" accept="jpg|png|pdf|doc|docx" maxlength="10" onchange="mostraDiv()"/>
<div id="mensagensArquivo" style="position:absolute; z-index:0; color:#F00; border-color:#F00"></div>
<font size="-2"><Br />Arquivos permitidos: .PDF .JPG .PNG .DOC .DOCX . Máximo 10 arquivos.</font></td></tr>
</table>
<div id="conteudo">
<?php
if($tipo==1){ 
echo '
Informe os dados do Vôo:
<div id="tabela">
<table border="1" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    <td valign="top" align="center"></td>
    <th valign="top" align="center"><strong>Data</strong></th>
    <th valign="top" align="center"><strong>Trecho</strong></th>
    <th valign="top" align="center"><strong>Horário</strong></th>
	<th valign="top" align="center"><strong>Vôo</strong></th>
	<th valign="top" align="center"><strong>Cia. Aérea</strong></th>
  </tr>';
  $sqlPassagemImp=mysql_query("SELECT * FROM savpassagem WHERE idsav='".$numSav."'");
  $countPassagemImp=mysql_num_rows($sqlPassagemImp);
  $countPassagemImpContador=0;
  $cont=0;
  while($objPassagemImp=mysql_fetch_object($sqlPassagemImp)){ 
  $sqlDadosPassagem=mysql_fetch_array(mysql_query("SELECT * FROM prestsavvoo WHERE idpass='".$objPassagemImp->id."'"));
	  if($objPassagemImp->inter<>'itn'){
				  $sqlTrechoNacImpIda=mysql_fetch_array(mysql_query("SELECT municipio,uf FROM municipios WHERE id='".$objPassagemImp->origem."'"));
				  $sqlTrechoNacImpVolta=mysql_fetch_array(mysql_query("SELECT municipio,uf FROM municipios WHERE id='".$objPassagemImp->destino."'"));
				  $idaImpressao=$sqlTrechoNacImpIda['municipio']."(".$sqlTrechoNacImpIda['uf'].")";
				  $voltaImpressao=$sqlTrechoNacImpVolta['municipio']."(".$sqlTrechoNacImpVolta['uf'].")";
				  }else{
					  $idaImpressao=$objPassagemImp->cidorigem."(".$objPassagemImp->origem.")";
				  	  $voltaImpressao=$objPassagemImp->ciddestino."(".$objPassagemImp->destino.")";
					  }
		$horarioViagem='';
		
	  $countPassagemImpContador++;
	  if($objPassagemImp->tipo==1){
		  if($objPassagemImp->horarioida=='manha'){
			  $horarioViagem='Manhã (4h-12h)';
			  }elseif($objPassagemImp->horarioida=='tarde'){
			  			$horarioViagem='Tarde (12h01-18h)';
			  }elseif($objPassagemImp->horarioida=='noite'){
			  			$horarioViagem='Noite (18h01-3h59)';
			  }
		  
		  if($countPassagemImpContador<$countPassagemImp || ($countPassagemImp==1 && $objPassagemImp->tipo==1)){
		  echo " <tr>
    			<td ><strong>IDA</strong></td>
    			<td align='center'>".$objPassagemImp->dtida."</td>
    			<td align='center'>".utf8_encode($idaImpressao)." x ".utf8_encode($voltaImpressao)."</td>
    			<td align='center'>".$horarioViagem."</td>
				<td align='center'><input type='text' size='15' class='input' name='voo".$cont."' value='".$sqlDadosPassagem['voo']."'/></td>
				<td align='center'><input type='text' size='15' class='input' name='cia".$cont."' value='".$sqlDadosPassagem['cia']."'/></td>
  				</tr>";
		  }else{
			echo " <tr>
    			<td ><strong>VOLTA</strong></td>
    			<td align='center'>".$objPassagemImp->dtida."</td>
    			<td align='center'>".utf8_encode($idaImpressao)." x ".utf8_encode($voltaImpressao)."</td>
    			<td align='center'>".$horarioViagem."</td>
				<td align='center'><input type='text' size='15' class='input' name='voo".$cont."' value='".$sqlDadosPassagem['voo']."'/></td>
				<td align='center'><input type='text' size='15' class='input' name='cia".$cont."' value='".$sqlDadosPassagem['cia']."'/></td>
  				</tr>";
			}
	 	}else{
			for($j=0;$j<=1;$j++){
			   if($j==0){
			   if($objPassagemImp->horarioida=='manha'){
			  $horarioViagem='Manhã (4h-12h)';
			  }elseif($objPassagemImp->horarioida=='tarde'){
			  			$horarioViagem='Tarde (12h01-18h)';
			  }elseif($objPassagemImp->horarioida=='noite'){
			  			$horarioViagem='Noite (18h01-3h59)';
			  }
			   echo " <tr>
    			<td ><strong>IDA</strong></td>
    			<td align='center'>".$objPassagemImp->dtida."</td>
    			<td align='center'>".utf8_encode($idaImpressao)." x ".utf8_encode($voltaImpressao)."</td>
    			<td align='center'>".$horarioViagem."</td>
				<td align='center'><input type='text' size='15' class='input' name='voo".$cont."' value='".$sqlDadosPassagem['voo']."'/></td>
				<td align='center'><input type='text' size='15' class='input' name='cia".$cont."' value='".$sqlDadosPassagem['cia']."'/></td>
  				</tr>";
			   }else{
				  if($objPassagemImp->horariovolta=='manha'){
			  $horarioViagem='Manhã (4h-12h)';
			  }elseif($objPassagemImp->horariovolta=='tarde'){
			  			$horarioViagem='Tarde (12h01-18h)';
			  }elseif($objPassagemImp->horariovolta=='noite'){
			  			$horarioViagem='Noite (18h01-3h59)';
			  }
				  echo " <tr>
    			<td ><strong>VOLTA</strong></td>
    			<td align='center'>".$objPassagemImp->dtvolta."</td>
    			<td align='center'>".utf8_encode($voltaImpressao)." x ".utf8_encode($idaImpressao)."</td>
    			<td align='center'>".$horarioViagem."</td>
				<td align='center'><input type='text' size='15' class='input' name='voo".$cont."' value='".$sqlDadosPassagem['voo']."'/></td>
				<td align='center'><input type='text' size='15' class='input' name='cia".$cont."' value='".$sqlDadosPassagem['cia']."'/></td>
  				</tr>";
				   }
			   }
			   $cont++;
			}
	  }
echo "</table></div>";
}
?>
</div>
<table border="0" width="100%">
<tr>

  <td colspan="2">
    <strong>Descrição das atividades:</strong></td>
</tr><tr><td colspan="2">
<textarea name="obs" rows="10" cols="80"><?php echo $obs; ?></textarea>
</td></tr>
<tr><td align="left"><a href="prestUser.php"><input type="button" name="voltar" value="<<Voltar"></a></td><td align="right">
<input type="submit" class="button" value="INCLUIR" />
</td>
</tr>
<tr><td align="center" colspan="2"><a href="prestUser.php"><input type="button" name="voltar" class="button" value="CONCLUIR"></a></td>
</tr>
</table>
</form>
</div>
</body>
</html>
