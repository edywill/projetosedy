<?php 
session_start();
require "../conectsqlserverci.php";
require "../conect.php";
$userCriac=$_SESSION['userAquis'];
			    if(($_SESSION['tipoAcao']=='inserir') && !empty($_POST['idos'])){
				$sqlDadosReg=mysql_query("SELECT * FROM aquireg WHERE id='".$_SESSION['idRegAqui']."'");
				$arrayDadosReg=mysql_fetch_array($sqlDadosReg);
				$_SESSION['idRegOrdem']=$_POST['idos'];
				$_SESSION['eventodoc']='';
				$_SESSION['docordem']='';
				$_SESSION['fatordem']="<b>COMITÊ PARAOLÍMPICO BRASILEIRO - CPB<br />
CNPJ n.º 00.700.114/0001-44<br />
Setor Bancário Norte, Quadra 02, Lote 12, Bloco “F”, 14º Andar<br />
Brasília-DF - Cep. 70.040-020</b>";
				$_SESSION['descordem']='';
				$_SESSION['vlunitordem']='';
				$_SESSION['dtentordem']='';
				$_SESSION['compordem']="<p align='justify'>O pagamento será efetuado por meio de ordem bancária ou qualquer outro meio idôneo adotado pelo CPB, mediante a apresentação de Nota Fiscal / Fatura devidamente atestada (responsável pelo recebimento), no prazo de até <u>10 (dez) dias úteis a contar do seu recebimento</u>, devendo ser efetuada a retenção na fonte dos tributos e contribuições determinadas pelos órgãos fiscais e fazendários em conformidade com a legislação vigente, quando for o caso.</p>";
				$_SESSION['emissordem']=$userCriac;
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
				}elseif(($_SESSION['tipoAcao']='editar') && !empty($_POST['idOrdemEdit'])){
				$_SESSION['idRegOrdem']=$_POST['idOrdemEdit'];
				$sqlDadosReg=mysql_query("SELECT * FROM aquireg WHERE id='".$_SESSION['idRegAqui']."'");
				$arrayDadosReg=mysql_fetch_array($sqlDadosReg);
				$sqlDadosOrd=mysql_query("SELECT * FROM aquiordem WHERE id='".$_SESSION['idRegOrdem']."'");
				$arrayDadosOrd=mysql_fetch_array($sqlDadosOrd);
				$_SESSION['docordem']=$arrayDadosOrd['doc'];
				$_SESSION['fatordem']=$arrayDadosOrd['fatura'];
				$_SESSION['descordem']=$arrayDadosOrd['descric'];
				$_SESSION['vlunitordem']=$arrayDadosOrd['vlunit'];
				$_SESSION['dtentordem']=$arrayDadosOrd['dtentrega'];
				$_SESSION['compordem']=$arrayDadosOrd['comp'];
				$_SESSION['emissordem']=$arrayDadosOrd['emissor'];
				$_SESSION['eventodoc']=$arrayDadosOrd['evento'];
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
					}else{
					$empresa=$_SESSION['empresaAquis'];
				    $proc=$_SESSION['procAquis'];
				    $dtinicio=$_SESSION['dtinicioAquis'];
				    $dtfim=$_SESSION['dtfimAquis'];
					}
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
<script type='text/javascript' src='../jquery_price.js'></script>
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
     <script src="../ckeditor/ckeditor.js"></script>
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
$sqlOrdem=mysql_query("SELECT aquipedidoitem.*,aquimat.* FROM aquipedidoitem INNER JOIN aquimat ON aquimat.id=aquipedidoitem.idmat WHERE idos='".$_SESSION['idRegOrdem']."'") or die(mysql_error());
$countOrd=mysql_num_rows($sqlOrdem);
	}
if($countOrd>0){
?>
<h3> ORDEM Nº <font color="#FF0000"><?php echo $_SESSION['idRegOrdem']."/".date("Y");?></font></h3>
<h4>ITENS CADASTRADOS TOTAIS</h4>
<table border="1" width="100%">
<tr>
<th>MATERIAL</th><th>QUANTIDADE</th><th>OBS.</th><th>EDITAR</th><th>DELETAR</th></tr>
<?php 
while($objMat=mysql_fetch_object($sqlOrdem)){
	$arrayDescMat=odbc_fetch_array(odbc_exec($conCab,"SELECT Descricao
FROM ESMATERI (nolock) 
WHERE Cd_reduzido='".$objMat->cdmat."'"));
	$observ="<td></td>";
	if($objMat->obs<>''){
		$observ="<td bgcolor='red'><font color='white'>".$objMat->obs."</font></td>";
		}
	echo "<tr><td>".utf8_encode($arrayDescMat['Descricao'])."</td><td>".$objMat->qtd."</td>".$observ."<td><form action='editItenOrd.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMat->id."'/><input type='submit' name='edit' value='Editar' class='button'/></form></td><td><form action='deleteItemOrd.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMat->id."'/><input type='submit' name='edit' value='Deletar' class='button'/></form></td></tr>";
	}
?>
</table>
<?php 
		}
?>
<br>
<form action="cadInfoOrd.php" name="insere" method="post">
<h4>CADASTRAR INFORMAÇÕES ADICIONAIS</h4>
<table border="0" width="100%"><tr>
<th>1.Doc. Interno de Referência</th></tr>
<tr><td><input type="text" size="50" maxlength="99" name="doc" id='doc' class="input" value='<?php echo utf8_encode($_SESSION['docordem']); ?>'/></td></tr>
<tr>
<th width="30%">2. Dados de Faturamento</th>
</tr>
<tr>
<td><textarea name="fatura" id="fatura" class="ckeditor" cols="53" rows="4">
<?php 
echo $_SESSION['fatordem'];
?>
</textarea></td>
</tr>
<tr>
<th width="30%">3. Descrição</th>
</tr>
<tr>
<th width="30%">3.1 Nome do Evento</th>
</tr>
<tr><td><input type="text" size="50" maxlength="99" name="evento" id='evento' class="input" value='<?php echo utf8_encode($_SESSION['eventodoc']); ?>'/></td></tr>
<tr>
<th width="30%">3.1 Informações Adicionais</th>
</tr>
<tr>
<td>
<textarea name="desc" id="desc" class="ckeditor" cols="53" rows="6">
<?php 
echo $_SESSION['descordem'];
?>
</textarea>
</td>
<tr>
<th width="30%">4. Valor (R$)</th>
</tr><tr><td><input type="text" size="20" name="vlunit" maxlength="100" id='vlunit' class="input" value='<?php echo utf8_encode($_SESSION['vlunitordem']); ?>'/></td>
</tr>
<tr>
<th width="30%">5. Data e Local da Entrega</th>
</tr><tr><td><input type="text" size="50" name="dtentrega" maxlength="100" id='dtentrega' class="input" value='<?php echo utf8_encode($_SESSION['dtentordem']); ?>'/></td>
</tr>
<tr>
<th width="30%">6. Informações complementares</th></tr><tr><td>
<textarea name="comp" id="comp" class="ckeditor" cols="53" rows="6">
<?php 
echo $_SESSION['compordem'];
?>
</textarea>
</td>
</tr>
<tr>
<th width="30%">7. Emissor</th></tr><tr><td><input type="text" size="50" maxlength="55" name="emissor" id='emissor' class="input" value='<?php echo utf8_encode($_SESSION['emissordem']); ?>'/></td>
</tr>
<tr><td width="30%"><a href="index.php"><input type="button" name="submit" class="button" value="<<Voltar" /></a> <input type="submit" name="submit" class="button" value="CONCLUIR" /></td></tr>
</table>
</form>
</div>
</div>
</body>
</html>