<?php 
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";
$userCriac=$_SESSION['userAquis'];
$nomeCampo='';
$valida=0;
if(!empty($_POST['empresa'])){
	$_SESSION['idatlSession']='';
				$_SESSION['tipoAcao']='inserir';
				$_SESSION['materialComp']='';
				$_SESSION['qtdMat']='';
				$_SESSION['idRegOrdem']='';
				$_SESSION['materialComp']='';
		        $_SESSION['materialCompDesc']='';
				$_SESSION['idRegAqui']=$_POST['empresa'];
				$sqlDadosReg=mysql_query("SELECT * FROM aquireg WHERE id='".$_SESSION['idRegAqui']."'");
				$arrayDadosReg=mysql_fetch_array($sqlDadosReg);
				$dtinicio=$arrayDadosReg['dtinicio'];
				$dtfim=$arrayDadosReg['dtfim'];
				$idEmpresa=$arrayDadosReg['cdempres'];
				$idProc=$arrayDadosReg['proc'];
				$sqlProcEdit=odbc_fetch_array(odbc_exec($conCab,"select projeto, assunto
from GMPROCDOC (nolock) 
where projeto='".$idProc."'"));
				$sqlEmpresaEdit=odbc_fetch_array(odbc_exec($conCab,"select Cd_empresa,Nome_completo
from GEEMPRES (nolock) 
where Cd_empresa='".$idEmpresa."'"));
				$empresa=$sqlEmpresaEdit['Cd_empresa']."-".$sqlEmpresaEdit['Nome_completo'];
				$proc=$sqlProcEdit['projeto']."-".$sqlProcEdit['assunto'];
				$_SESSION['empresaAquis']=$sqlEmpresaEdit['Cd_empresa']."-".$sqlEmpresaEdit['Nome_completo'];
				$_SESSION['procAquis']=$sqlProcEdit['projeto']."-".$sqlProcEdit['assunto'];
				$_SESSION['dtinicioAquis']=$dtinicio;
				$_SESSION['dtfimAquis']=$dtfim;
				$_SESSION['idOrdemEdit']='idos';
				}elseif(!empty($_POST['idOrdem'])){
					$_SESSION['idatlSession']='';
				$_SESSION['tipoAcao']='editar';	
				$_SESSION['materialComp']='';
		        $_SESSION['materialCompDesc']='';
				$_SESSION['idRegAqui']=$_POST['idEmpEdit'];
				$_SESSION['idRegOrdem']=$_POST['idOrdem'];
				$sqlAnoOrdem=mysql_fetch_array(mysql_query("SELECT id,idos,ano FROM aquiordem WHERE id='".$_SESSION['idRegOrdem']."'"));
				$idAnoOrdem=$sqlAnoOrdem['ano'];
				$idOsImp=$sqlAnoOrdem['idos'];
				$_SESSION['idOsImpSession']=$idOsImp;
				$_SESSION['anoOsImpSession']=$idAnoOrdem;
				$sqlDadosReg=mysql_query("SELECT * FROM aquireg WHERE id='".$_SESSION['idRegAqui']."'");
				$arrayDadosReg=mysql_fetch_array($sqlDadosReg);
				$dtinicio=$arrayDadosReg['dtinicio'];
				$dtfim=$arrayDadosReg['dtfim'];
				$idEmpresa=$arrayDadosReg['cdempres'];
				$idProc=$arrayDadosReg['proc'];
				$sqlProcEdit=odbc_fetch_array(odbc_exec($conCab,"select projeto, assunto
from GMPROCDOC (nolock) 
where projeto='".$idProc."'"));
				$sqlEmpresaEdit=odbc_fetch_array(odbc_exec($conCab,"select Cd_empresa,Nome_completo
from GEEMPRES (nolock) 
where Cd_empresa='".$idEmpresa."'"));
				$empresa=$sqlEmpresaEdit['Cd_empresa']."-".$sqlEmpresaEdit['Nome_completo'];
				$proc=$sqlProcEdit['projeto']."-".$sqlProcEdit['assunto'];
				$_SESSION['empresaAquis']=$sqlEmpresaEdit['Cd_empresa']."-".$sqlEmpresaEdit['Nome_completo'];
				$_SESSION['procAquis']=$sqlProcEdit['projeto']."-".$sqlProcEdit['assunto'];
				$_SESSION['dtinicioAquis']=$dtinicio;
				$_SESSION['dtfimAquis']=$dtfim;
				$_SESSION['materialComp']='';
				$_SESSION['qtdMat']='';
				$_SESSION['idOrdemEdit']='idOrdemEdit';
					}elseif(!empty($_SESSION['empresaAquis'])){
					$empresa=$_SESSION['empresaAquis'];
				    $proc=$_SESSION['procAquis'];
				    $dtinicio=$_SESSION['dtinicioAquis'];
				    $dtfim=$_SESSION['dtfimAquis'];
					}else{
						$valida=1;
						?>
       <script type="text/javascript">
       alert("Selecione um registro!");
       window.location="index.php";
       </script>
       <?php
						}
if($valida==0){
	$idatl=0;
	if(!empty($_POST['idatu'])){
		$idatl=$_POST['idatu'];
		$_SESSION['idatlSession']=$idatl;
		$sqlRegAt=mysql_fetch_array(mysql_query("SELECT aquipedidoitem.id,aquimat.id AS cdmat,aquipedidoitem.qtd,aquimat.vlunit,aquigrupo.id AS idgroup,aquigrupo.codigo,aquigrupo.descricao,aquicadmat.nome FROM aquipedidoitem LEFT JOIN aquimat
		ON aquipedidoitem.idmat=aquimat.id LEFT JOIN aquicadmat ON aquimat.cdmat=aquicadmat.id
LEFT JOIN aquigrupo ON aquicadmat.grupo=aquigrupo.id WHERE aquipedidoitem.id='".$idatl."'"));
	$_SESSION['materialComp']=$sqlRegAt['cdmat'];
	$_SESSION['materialCompDesc']=utf8_encode($sqlRegAt['nome']);
	$_SESSION['qtdMat']=$sqlRegAt['qtd'];
		}else{
			$_SESSION['idatlSession']='';
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
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../jqueryDown/jquery-1.9.0-ui.css" />
<script src="../../jqueryDown/jquery-ui.js"></script>
<script language="javascript" src="../materiais/script.js" type="text/javascript"></script>
<script src="../../sav/jquerymensagem/jquery_jui_alert.js">
</script> 
<script type='text/javascript' src='../../jquery.autocomplete.js'></script>
  <link rel="stylesheet" type="text/css" href="../../jquery.autocomplete.css" />
<script type="text/javascript">
  $().ready(function() {
	  $("#proc").autocomplete("../suggest_projeto.php", {
		  width: 510,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script type="text/javascript">
  $().ready(function() {
	  $("#empresa").autocomplete("../../suggest_user.php", {
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
<script type='text/javascript' src='../../jquery_price.js'></script>
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
<script type='text/javascript' src='../../jquery_price.js'></script>
<script type='text/javascript'>
  	  $(document).ready(function(){
      $('#vlunit').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	  $(document).ready(function(){
	  $('#qtd').priceFormat({
        prefix: '',
		centsLimit: 0,
        centsSeparator: '',
        thousandsSeparator: '.'
      });
    });
	 </script>
     <script type="text/javascript">
function  reescreveTabelas(){
	req=0;
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
</head>
       
<body>
<div id='box3' style="height:auto">
    <br/>
    
<h2>AQUISIÇÕES</h2>
<h3>Cadastro de Ordem de Serviço</h3>  
<br />
<div id='tabela'>
<table width="100%" border="0">
<tr><th colspan="2">DADOS DO REGISTRO DE PREÇO</th></tr>
<tr><th width="30%">Processo</th><td><?php echo utf8_encode($proc); ?></td></tr>
<tr><th width="30%">Empresa</th><td><?php echo utf8_encode($empresa); ?></td></tr>
<tr><th width="30%">Vigência</th><td><?php echo $dtinicio; ?> à <?php echo $dtfim; ?></td></tr>
<tr><td colspan="2" align="right"><form action='../registro/relatorioSrp.php' target="_blank" method='post' name='rel'><input type='hidden' name='idsrp' value='<?php echo $_SESSION['idRegAqui'];?>'/><input type='submit' name='rel' value='Relatório/Saldo' class='button'/></form></td></tr>
</table>
<?php
$countOrd=0;
$continuaLancOrdem='';
if(!empty($_SESSION['idRegOrdem'])){
$sqlOrdem=mysql_query("SELECT aquipedidoitem.id AS iditor,aquipedidoitem.qtd AS qtdor,aquimat.quant,aquimat.vlunit,aquicadmat.nome,aquigrupo.descricao,aquimat.id AS idmat
	FROM aquipedidoitem LEFT JOIN aquimat ON aquimat.id=aquipedidoitem.idmat
	LEFT JOIN aquicadmat ON aquicadmat.id=aquimat.cdmat
	LEFT JOIN aquigrupo ON
aquigrupo.id=aquicadmat.grupo
WHERE aquipedidoitem.idos='".$_SESSION['idRegOrdem']."'") or die(mysql_error());
$countOrd=mysql_num_rows($sqlOrdem);
	}
	echo "<div id='mensagens'>";
if($countOrd>0){
	$continuaLancOrdem="<form action='ordemDados.php' method='post' name='ordem'><input type='hidden' name='".$_SESSION['idOrdemEdit']."' value='".$_SESSION['idRegOrdem']."'/>
	<input type='submit' class='button' name='button' value='CONTINUAR>>'/></form>";
?>
<h3> ORDEM Nº <font color="#FF0000"><?php echo $_SESSION['idOsImpSession']."/".$_SESSION['anoOsImpSession'];?></font></h3>
<h4>ITENS CADASTRADOS TOTAIS</h4>
<table border="1" width="100%">
<tr>
<th>MATERIAL</th><th>QUANTIDADE</th><th>OBS.</th><th>EDITAR</th><th>DELETAR</th></tr>
<?php 
while($objMat=mysql_fetch_object($sqlOrdem)){
  $observ="<td></td>";
  $saldo=0;
  $atualizaSaldo=0;
  $sqlPedidos=mysql_query("SELECT qtd FROM aquipedidoitem WHERE idmat='".$objMat->idmat."'") or die(mysql_error());
	$solicitado=0;
	while($objPedidos=mysql_fetch_object($sqlPedidos)){
		$solicitado=$solicitado+$objPedidos->qtd;
		}
  $saldo=$objMat->quant-$solicitado;
  $atualizaSaldo=$saldo;
  if($atualizaSaldo<0){
	  $observ="<td bgcolor='red'><font color='white'>Limite Ultrapassado<br>SALDO: ".$atualizaSaldo."</font></td>";
	  }
	echo "<tr><td>".utf8_encode($objMat->nome)."<br>".utf8_encode($objMat->descricao)."</td><td>".$objMat->qtdor."</td>".$observ."<td><form action='novaOrdem.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMat->iditor."'/><input type='submit' name='edit' value='Editar' class='button'/></form></td><td><form action='deleteItemOrd.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMat->iditor."'/><input type='submit' name='edit' value='Deletar' class='button'/></form></td></tr>";
	}
?>
</table>
<?php 
		}
?>
<br />
<div id="divResultado"></div>
<br />
<form action="insereNovoItemOrd.php" name="insere" method="post" id='insere' onSubmit="setarCampos(this); enviarForm('insereNovoItemOrd.php', campos, 'divResultado'); return false;">
<h4>CADASTRAR PEDIDO DE MATERIAL/SERVIÇO</h4>
<table border="0" width="50%"><tr>
<th width="30%">Material</th><td>
<input type="hidden" name="idatl" id='idatl' value="<?php echo $_SESSION['idatlSession']; ?>" />
<select name="material" id="material">
<option selected='selected' value="<?php echo $_SESSION['materialComp']; ?>"><?php echo $_SESSION['materialCompDesc']; ?></option>
<?php 
$SQLMaterial=mysql_query("SELECT aquimat.id,aquimat.cdmat,aquimat.quant,aquimat.vlunit,aquigrupo.codigo,aquigrupo.descricao,aquicadmat.nome FROM aquimat LEFT JOIN aquicadmat ON aquimat.cdmat=aquicadmat.id
LEFT JOIN aquigrupo ON aquicadmat.grupo=aquigrupo.id WHERE aquimat.idreg='".$_SESSION['idRegAqui']."'");
 while( $objMaterial = mysql_fetch_array($SQLMaterial) )
    {	 
			echo "<option value='".$objMaterial['id']."'>".utf8_encode($objMaterial['nome'])."</option>";
			}
?>
</select>
</td></tr>
<tr>
<th width="30%">Quantidade</th><td><input type="text" size="20" name="qtd" id='qtd' class="input" value='<?php echo $_SESSION['qtdMat']; ?>'></td>
</tr>
<tr><td width="30%"><a href="index.php"><input type="button" name="submit" class="button" value="<<Voltar" /></a></td><td align="right"><input type="submit" name="submit" class="button" value="<?php if(empty($_SESSION['idatlSession'])){
	echo "Incluir";
}else{
	echo "Atualizar";
	}
	?>"/></td></tr>
</table>
</form>
<div align="right">
<p align="right"><?php echo  $continuaLancOrdem;?></p>
</div>
</div>
</div>
<script>

//Cria a função com os campos para envio via parâmetro

function setarCampos() {
	campos = "idatl="+encodeURI(document.getElementById('idatl').value)+"&qtd="+encodeURI(document.getElementById('qtd').value)+"&material="+encodeURI(document.getElementById('material').value);
}
</script>
</div>
</body>
</html>
<?php 
}
?>