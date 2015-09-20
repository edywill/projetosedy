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

document.getElementById('tabelareg').innerHTML=resposta;
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
$sqlRegistros=mysql_query("SELECT savregistros.* FROM savregistros where savregistros.funcionario='".$funcionario."' AND savregistros.situacao<>'Cancelada' AND savregistros.numci>0");
$countReg=mysql_num_rows($sqlRegistros);
$tipo=0;
if($countReg<1){
	echo "<script>alert('Nenhuma viagem disponível!');window.location.href='prestUser.php';</script>"; 
	}

?>
<select name="sav" id="sav" onchange="reescreveTabelas()">
<option selected="selected" value="">Selecione</option>
<?php
while($objRegistros=mysql_fetch_object($sqlRegistros)){
	$sqlPrestacao=mysql_num_rows(mysql_query("select id from prestsav where savid='".$objRegistros->id."'"));
	if($sqlPrestacao==0){
echo "<option value='".$objRegistros->id."'>".utf8_encode($objRegistros->numci)."-".utf8_encode($objRegistros->evento)."-".$objRegistros->abrangencia." (Ida: ".$objRegistros->dtida." / Volta: ".$objRegistros->dtvolta.")</option>";
	}
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
	echo "<div align='left'><strong>Viagem: </strong>
	<input type='hidden' name='sav' value='".$sqlRegistros['id']."'>
	".$sqlRegistros['numci']."-".utf8_encode($sqlRegistros['evento'])."-".$sqlRegistros['abrangencia']." (Ida: ".$sqlRegistros['dtida']." / Volta: ".$sqlRegistros['dtvolta'].")</div><br>";
	}
  ?>  
    </td><td></td></tr></table>
    <hr />
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
<input type="file" name="arquivos[]" id="arquivos" multiple="multiple"  class="multi accept-png|doc|docx|pdf" maxlength="10" onchange="mostraDiv()"/>
<div id="mensagensArquivo" style="position:absolute; z-index:0; color:#F00; border-color:#F00"></div>
<font size="-2"><Br />Arquivos permitidos: .PDF .DOC .DOCX . Máximo 10 arquivos.</font></td></tr>
</table>
<hr />
<div id="tabelareg">
<?php
if($tipo==1){ 
 $sqlPassagemImp=mysql_query("SELECT savpassagem.*,savregistros.numci,savregistros.funcionario FROM savpassagem LEFT JOIN savregistros ON savpassagem.idsav=savregistros.id WHERE savpassagem.idsav='".$numSav."'");
  $countPassagemImp=mysql_num_rows($sqlPassagemImp);
  if($countPassagemImp>0){
echo '<strong>Deslocamento</strong>
<div id="tabela">
<table border="1" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    <td valign="top" align="center" width="10%"></td>
    <th valign="top" align="center" width="20%"><strong>Data/Trecho</strong></th>
    <th valign="top" align="center"><strong>Horário</strong></th>
	<th valign="top" align="center"><strong>Localizador</strong></th>
	<th valign="top" align="center"><strong>Vôo</strong></th>
	<th valign="top" align="center"><strong>Cia. Aérea</strong></th>
  </tr>';
  $countPassagemImpContador=0;
  $cont=0;
  $idPassagemAut=0;
  while($objPassagemImp=mysql_fetch_object($sqlPassagemImp)){
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
		$localizador='';
		$sqlBloqUser=odbc_fetch_array(odbc_exec($conCab2,"select GEEMXRHP.Cd_empresa from GEEMXRHP (NOLOCK) WHERE GEEMXRHP.Cd_pessoa='".$objPassagemImp->funcionario."'"));
	  $benef=$sqlBloqUser['Cd_empresa'];
	  $countPassagemImpContador++;
	  if($objPassagemImp->tipo==1){
		  if($countPassagemImpContador<$countPassagemImp || ($countPassagemImp==1 && $objPassagemImp->tipo==1)){
			  $queryDadosPassagem=mysql_query("SELECT prestsavvoo.*,cia.id AS idcia, cia.nome AS nomecia FROM prestsavvoo LEFT JOIN cia ON cia.id=prestsavvoo.cia WHERE prestsavvoo.idpass='".$objPassagemImp->id."' ORDER BY prestsavvoo.id ASC");
			  $sqlDadosPassagem=mysql_fetch_array($queryDadosPassagem);
			  $queryAut=mysql_query("SELECT registros.localizador,registros.id AS idreg,cia.nome,cia.id AS idcia FROM registros LEFT JOIN cia ON registros.idcia=cia.id WHERE registros.solicitacao='".$objPassagemImp->numci."' AND registros.idben='".$benef."' AND registros.id<>'".$idPassagemAut."' ORDER BY registros.id ASC") or die(mysql_error());
		  $buscaAutorizacao=mysql_fetch_array($queryAut);
		  $idPassagemAut=$buscaAutorizacao['idreg'];
		if(!empty($sqlDadosPassagem['loc'])){
			$localizador=$sqlDadosPassagem['loc'];
			}else{
				$localizador=$buscaAutorizacao['localizador'];
				};
		if(!empty($sqlDadosPassagem['cia'])){
			$cia=$sqlDadosPassagem['cia'];
			$nomeCia=$sqlDadosPassagem['nomecia'];
			}else{
				$cia=$buscaAutorizacao['idcia'];
				$nomeCia=$buscaAutorizacao['nome'];
				};
				if(empty($cia)){
					$cia=0;
					}
		  echo " <tr>
    			<td ><strong>IDA</strong></td>
    			<td align='center'><font size='-2'>".$objPassagemImp->dtida."<br>".utf8_encode($idaImpressao)." x ".utf8_encode($voltaImpressao)."</font></td>
    			<td align='center'><input type='hidden' size='8' class='input' name='idpas".$cont."' value='".$objPassagemImp->id."'/><input type='time' size='8' class='input' name='hora".$cont."' value='".$sqlDadosPassagem['horario']."'/></td>
				<td align='center'><input type='text' size='8' class='input' name='loc".$cont."' value='".$localizador."'/></td>
				<td align='center'><input type='text' size='8' class='input' name='voo".$cont."' value='".$sqlDadosPassagem['voo']."'/></td>
				<td align='center'><select name='cia".$cont."'>";
				if($cia==0){
					echo "<option value='0' selected='selected'>Selecione</option>";
					}else{
						echo "<option value='".$cia."' selected='selected'>".utf8_encode($nomeCia)."</option>";
						}
				$selectCias=mysql_query("select * from cia where id<>'".$cia."'");
				while($objSelectCia=mysql_fetch_object($selectCias)){
					echo "<option value='".$objSelectCia->id."'>".utf8_encode($objSelectCia->nome)."</option>";
					}
				echo "</select></td>
  				</tr>";
		  $cont++;
		  }else{
			  $queryDadosPassagem=mysql_query("SELECT prestsavvoo.*,cia.id AS idcia, cia.nome AS nomecia FROM prestsavvoo LEFT JOIN cia ON cia.id=prestsavvoo.cia WHERE prestsavvoo.idpass='".$objPassagemImp->id."' ORDER BY prestsavvoo.id DESC");
			  $sqlDadosPassagem=mysql_fetch_array($queryDadosPassagem);
			  $queryAut=mysql_query("SELECT registros.localizador,cia.nome,cia.id AS idcia FROM registros LEFT JOIN cia ON registros.idcia=cia.id WHERE registros.solicitacao='".$objPassagemImp->numci."' AND registros.idben='".$benef."' ORDER BY registros.id DESC") or die(mysql_error());
			  $buscaAutorizacao=mysql_fetch_array($queryAut);
		if(!empty($sqlDadosPassagem['loc'])){
			$localizador=$sqlDadosPassagem['loc'];
			}else{
				$localizador=$buscaAutorizacao['localizador'];
				};
		if(!empty($sqlDadosPassagem['cia'])){
			$cia=$sqlDadosPassagem['cia'];
			$nomeCia=$sqlDadosPassagem['nomecia'];
			}else{
				$cia=$buscaAutorizacao['idcia'];
				$nomeCia=$buscaAutorizacao['nome'];
				};
				if(empty($cia)){
					$cia=0;
					}
			echo " <tr>
    			<td ><strong>VOLTA</strong></td>
    			<td align='center'><font size='-2'>".$objPassagemImp->dtvolta."<br>".utf8_encode($idaImpressao)." x ".utf8_encode($voltaImpressao)."</font></td>
    			<td align='center'><input type='hidden' size='8' class='input' name='idpas".$cont."' value='".$objPassagemImp->id."'/><input type='time' size='8' class='input' name='hora".$cont."' value='".$sqlDadosPassagem['horario']."'/></td>
				<td align='center'><input type='text' size='8' class='input' name='loc".$cont."' value='".$localizador."'/></td>
				<td align='center'><input type='text' size='8' class='input' name='voo".$cont."' value='".$sqlDadosPassagem['voo']."'/></td>
				<td align='center'><select name='cia".$cont."'>";
				if($cia==0){
					echo "<option value='0' selected='selected'>Selecione</option>";
					}else{
						echo "<option value='".$cia."' selected='selected'>".utf8_encode($nomeCia)."</option>";
						}
				$selectCias=mysql_query("select * from cia where id<>'".$cia."'");
				while($objSelectCia=mysql_fetch_object($selectCias)){
					echo "<option value='".$objSelectCia->id."'>".utf8_encode($objSelectCia->nome)."</option>";
					}
				echo "</select></td>
  				</tr>";
			$cont++;
			}
	 	}else{
			for($j=0;$j<=1;$j++){
			   if($j==0){
				   $queryDadosPassagem=mysql_query("SELECT prestsavvoo.*,cia.id AS idcia, cia.nome AS nomecia FROM prestsavvoo LEFT JOIN cia ON cia.id=prestsavvoo.cia WHERE prestsavvoo.idpass='".$objPassagemImp->id."' ORDER BY prestsavvoo.id ASC");
			  $sqlDadosPassagem=mysql_fetch_array($queryDadosPassagem);
				   $queryAut=mysql_query("SELECT registros.localizador,cia.nome,cia.id AS idcia FROM registros LEFT JOIN cia ON registros.idcia=cia.id WHERE registros.solicitacao='".$objPassagemImp->numci."' AND registros.idben='".$benef."' ORDER BY registros.id ASC") or die(mysql_error());
			   $buscaAutorizacao=mysql_fetch_array($queryAut);
		if(!empty($sqlDadosPassagem['loc'])){
			$localizador=$sqlDadosPassagem['loc'];
			}else{
				$localizador=$buscaAutorizacao['localizador'];
				};
		if(!empty($sqlDadosPassagem['cia'])){
			$cia=$sqlDadosPassagem['cia'];
			$nomeCia=$sqlDadosPassagem['nomecia'];
			}else{
				$cia=$buscaAutorizacao['idcia'];
				$nomeCia=$buscaAutorizacao['nome'];
				};
				if(empty($cia)){
					$cia=0;
					}
			   echo " <tr>
    			<td ><strong>IDA</strong></td>
    			<td align='center'><font size='-2'>".$objPassagemImp->dtida."<br>".utf8_encode($idaImpressao)." x ".utf8_encode($voltaImpressao)."</font></td>
    			<td align='center'><input type='hidden' size='8' class='input' name='idpas".$cont."' value='".$objPassagemImp->id."'/><input type='time' size='8' class='input' name='hora".$cont."' value='".$sqlDadosPassagem['horario']."'/></td>
				<td align='center'><input type='text' size='8' class='input' name='loc".$cont."' value='".$localizador."'/></td>
				<td align='center'><input type='text' size='8' class='input' name='voo".$cont."' value='".$sqlDadosPassagem['voo']."'/></td>
				<td align='center'><select name='cia".$cont."'>";
				if($cia==0){
					echo "<option value='0' selected='selected'>Selecione</option>";
					}else{
						echo "<option value='".$cia."' selected='selected'>".utf8_encode($nomeCia)."</option>";
						}
				$selectCias=mysql_query("select * from cia where id<>'".$cia."'");
				while($objSelectCia=mysql_fetch_object($selectCias)){
					echo "<option value='".$objSelectCia->id."'>".utf8_encode($objSelectCia->nome)."</option>";
					}
				echo "</select></td>
  				</tr>";
			   $cont++;
			   }else{
				   $queryDadosPassagem=mysql_query("SELECT prestsavvoo.*,cia.id AS idcia, cia.nome AS nomecia FROM prestsavvoo LEFT JOIN cia ON cia.id=prestsavvoo.cia WHERE prestsavvoo.idpass='".$objPassagemImp->id."' ORDER BY prestsavvoo.id DESC");
			  $sqlDadosPassagem=mysql_fetch_array($queryDadosPassagem);
				   $queryAut=mysql_query("SELECT registros.localizador,cia.nome,cia.id AS idcia FROM registros LEFT JOIN cia ON registros.idcia=cia.id WHERE registros.solicitacao='".$objPassagemImp->numci."' AND registros.idben='".$benef."' ORDER BY registros.id DESC") or die(mysql_error());
				   $buscaAutorizacao=mysql_fetch_array($queryAut);
		if(!empty($sqlDadosPassagem['loc'])){
			$localizador=$sqlDadosPassagem['loc'];
			}else{
				$localizador=$buscaAutorizacao['localizador'];
				};
		if(!empty($sqlDadosPassagem['cia'])){
			$cia=$sqlDadosPassagem['cia'];
			$nomeCia=$sqlDadosPassagem['nomecia'];
			}else{
				$cia=$buscaAutorizacao['idcia'];
				$nomeCia=$buscaAutorizacao['nome'];
				};
				if(empty($cia)){
					$cia=0;
					}
			echo " <tr>
    			<td ><strong>VOLTA</strong></td>
    			<td align='center'><font size='-2'>".$objPassagemImp->dtvolta."<br>".utf8_encode($voltaImpressao)." x ".utf8_encode($idaImpressao)."</font></td>
    			<td align='center'><input type='hidden' size='8' class='input' name='idpas".$cont."' value='".$objPassagemImp->id."'/><input type='time' size='8' class='input' name='hora".$cont."' value='".$sqlDadosPassagem['horario']."'/></td>
				<td align='center'><input type='text' size='8' class='input' name='loc".$cont."' value='".$localizador."'/></td>
				<td align='center'><input type='text' size='8' class='input' name='voo".$cont."' value='".$sqlDadosPassagem['voo']."'/></td>
				<td align='center'><select name='cia".$cont."'>";
				if($cia==0){
					echo "<option value='0' selected='selected'>Selecione</option>";
					}else{
						echo "<option value='".$cia."' selected='selected'>".utf8_encode($nomeCia)."</option>";
						}
				$selectCias=mysql_query("select * from cia where id<>'".$cia."'");
				while($objSelectCia=mysql_fetch_object($selectCias)){
					echo "<option value='".$objSelectCia->id."'>".utf8_encode($objSelectCia->nome)."</option>";
					}
				echo "</select></td>
  				</tr>";
				   $cont++;
				   }
			   }
			}
	  }
echo "<input type='hidden' size='8' class='input' name='cont' value='".$cont."'/></table></div>";
}
}
?>
</div>
<hr />
<table border="0" width="100%">
<tr>

  <td colspan="2">
    <strong>Descrição das atividades:</strong></td>
</tr><tr><td colspan="2">
<textarea name="obs" rows="10" cols="80"><?php echo $obs; ?></textarea>
</td></tr>
<tr><td align="left"><a href="prestUser.php"><input type="button" name="voltar" value="<<Voltar"></a></td><td align="right">
<input type="submit" class="button" value="ATUALIZAR" />
</td>
</tr>
</table>
</form>
</div>
</body>
</html>
