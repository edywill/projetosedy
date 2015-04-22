<?php 
session_start();
require "../../../conectsqlserverci.php";
require "../../../conect.php";
$userCriac=$_SESSION['userAquis'];
			    if(!empty($_GET['idos'])){
				$sqlDadosReg=mysql_query("SELECT * FROM aquilic WHERE id='".$_SESSION['idRegAqui']."'");
				$arrayDadosReg=mysql_fetch_array($sqlDadosReg);
				$_SESSION['idRegOrdem']=$_GET['idos'];
				$sqlDadosOrdem=mysql_fetch_array(mysql_query("SELECT * FROM aquiordemlic WHERE idos='".$_SESSION['idRegOrdem']."'"));
				
$sqlMaterialCount=mysql_query("SELECT aquimatlic.id,aquimatlic.cdmat,aquimatlic.quant,aquimatlic.vlunit,aquigrupo.codigo,aquigrupo.descricao,aquicadmat.nome FROM aquimatlic LEFT JOIN aquicadmat ON aquimatlic.cdmat=aquicadmat.id
LEFT JOIN aquigrupo ON aquicadmat.grupo=aquigrupo.id WHERE aquimatlic.idreg='".$_SESSION['idRegAqui']."'") or die(mysql_error());
$countMatOrdem=mysql_num_rows($sqlMaterialCount);
				
				if(empty($sqlDadosOrdem['fatura'])){
				$idAnoOrdem=date("Y");
				$_SESSION['eventodoc']='';
				$_SESSION['docordem']='';
				$_SESSION['fatordem']="<b>COMITÊ PARAOLÍMPICO BRASILEIRO - CPB<br />
CNPJ n.º 00.700.114/0001-44<br />
Setor Bancário Norte, Quadra 02, Lote 12, Bloco \"F\", 14º Andar<br />
Brasília-DF - Cep. 70.040-020</b>";
				$_SESSION['descordem']='';
				$_SESSION['vlunitordem']='';
				$_SESSION['dtentordem']='';
				$_SESSION['compordem']="O pagamento ser&aacute; efetuado por meio de ordem banc&aacute;ria ou qualquer outro meio id&ocirc;neo adotado pelo CPB, mediante a apresenta&ccedil;&atilde;o de Nota Fiscal / Fatura devidamente atestada (respons&aacute;vel pelo recebimento), no prazo de at&eacute; <u>10 (dez) dias &uacute;teis a contar do seu recebimento</u>, devendo ser efetuada a reten&ccedil;&atilde;o na fonte dos tributos e contribui&ccedil;&otilde;es determinadas pelos &oacute;rg&atilde;os fiscais e fazend&aacute;rios em conformidade com a legisla&ccedil;&atilde;o vigente, quando for o caso.<br>
Pela inadimpl&ecirc;ncia total ou parcial da presta&ccedil;&atilde;o dos servi&ccedil;os ou entrega do bem, a CONTRATADA se sujeitar&aacute; &aacute;s seguintes san&ccedil;&otilde;es, sendo-lhe assegurado o contradit&oacute;rio e a ampla defesa: <br><br>

I - advert&ecirc;ncia, para os casos de infra&ccedil;&atilde;o de menor potencial, e desde que n&atilde;o haja preju&iacute;zo para o CPB;<br>
II - multa, administrativa, gradual conforme a gravidade da infra&ccedil;&atilde;o, n&atilde;o excedente a 20% (vinte por cento) do valor do contrato;<br>
III - multa morat&oacute;ria de 1% (um por cento) do valor do contrato por dia de atraso na execu&ccedil;&atilde;o dos servi&ccedil;os, at&eacute; o 10º dia, e de 2% (dois por cento) a partir do 11&ordm; at&eacute; o 30&ordm;, ap&oacute;s o que ensejar&aacute; a rescis&atilde;o;<br>
IV - suspens&atilde;o do direito de contratar com o CPB, pelo prazo de 2 (dois) anos.";
				$_SESSION['emissordem']=$userCriac;
				
				}else{
				$idAnoOrdem=$sqlDadosOrdem['ano'];
				$_SESSION['eventodoc']=$sqlDadosOrdem['evento'];
				$_SESSION['docordem']=utf8_encode($sqlDadosOrdem['doc']);
				$_SESSION['fatordem']=utf8_encode($sqlDadosOrdem['fatura']);
				$_SESSION['descordem']=utf8_encode($sqlDadosOrdem['descric']);;
				$_SESSION['vlunitordem']=utf8_encode($sqlDadosOrdem['vlunit']);;
				$_SESSION['dtentordem']=utf8_encode($sqlDadosOrdem['dtentrega']);;
				$_SESSION['compordem']=utf8_encode($sqlDadosOrdem['comp']);;
				$_SESSION['emissordem']=utf8_encode($sqlDadosOrdem['emissor']);;	
					}
				$dtinicio=$arrayDadosReg['dtinicio'];
				$idEmpresa=$arrayDadosReg['cdempres'];
				$idProc=$arrayDadosReg['proc'];
				$licit=$arrayDadosReg['nlicit'];
				
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
				$_SESSION['licitSessionDesc']=$licit;
				}else{
					$empresa=$_SESSION['empresaAquis'];
				    $proc=$_SESSION['procAquis'];
				    $dtinicio=$_SESSION['dtinicioAquis'];
					$licit=$_SESSION['licitSessionDesc'];
				    
					}
if($countMatOrdem<1){
	?>
       <script type="text/javascript">
       alert("Erro[1]: Nenhum item cadastrado!");
       window.location="insereItensLic.php";
       </script>
       <?php
	}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="../../../ajax/funcs.js"></script>
<!-- <link rel="stylesheet" href="jqueryDown/jquery-ui.css" /> -->
<script src="../../../jqueryDown/jquery-1.8.2.js"></script> 
<script src="../../../jqueryDown/jquery-1.9.0-ui.js"></script>
<link rel="stylesheet" href="../../../jqueryDown/jquery-1.9.0-ui.css" /> 
<script type='text/javascript' src='../../../jquery.autocomplete.js'></script>
  <link rel="stylesheet" type="text/css" href="../../../jquery.autocomplete.css" />
<script type="text/javascript">
  $().ready(function() {
	  $("#proc").autocomplete("../../suggest_projeto.php", {
		  width: 510,
		  matchContains: true,
		  selectFirst: false
	  });
  });
</script>
<script type="text/javascript">
  $().ready(function() {
	  $("#empresa").autocomplete("../../../suggest_user.php", {
		  width: 510,
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
<script type='text/javascript' src='../../../jquery_price.js'></script>
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
     <script src="../../../ckeditor/ckeditor.js"></script>
</head>
       
<body>
<div id='box3' style="height:auto">
    <br/>
    
<h2>AQUISIÇÕES</h2>
<h3>Ordem de Compra/Serviço -Nº:  <u><?php 
echo $_SESSION['idosSession']."/".date("Y")." (".$_SESSION['tipoLicSession'].")";
?>
</u>
</h3> 
<br />
<div id='tabela'>
<table width="100%" border="0">
<tr>
  <th colspan="2">DADOS DA ORDEM DE SERVIÇO</th></tr>
<tr><th width="30%">Processo</th><td><?php echo utf8_encode($proc); ?></td></tr>
<?php 
if($_SESSION['tipoSession']<>'cd'){
?>
<tr><th width="20%">Nº Licitação:</th><td>
<?php echo $_SESSION['licitSessionDesc']; ?>
</td></tr>
<?php 
}
?>
<tr><th width="30%">Empresa</th><td><?php echo utf8_encode($empresa); ?></td></tr>
<tr><th width="30%">Prev. Entrega</th><td><?php echo $dtinicio; ?></td>
</table>
</div>
<div id='tabela'>
<?php
$countOrd=0;
$continuaLancOrdem='';
if(!empty($_SESSION['idRegOrdem'])){
$sqlOrdem=mysql_query("SELECT aquimatlic.id,aquimatlic.cdmat,aquimatlic.quant,aquimatlic.vlunit,aquigrupo.codigo,aquigrupo.descricao,aquicadmat.nome FROM aquimatlic LEFT JOIN aquicadmat ON aquimatlic.cdmat=aquicadmat.id
LEFT JOIN aquigrupo ON aquicadmat.grupo=aquigrupo.id WHERE aquimatlic.idreg='".$_SESSION['idRegAqui']."'") or die(mysql_error());
$countOrd=mysql_num_rows($sqlOrdem);
	}
if($countOrd>0){
?>
<h4>ITENS CADASTRADOS TOTAIS</h4>
<table border="1" width="100%">
<tr>
<th>MATERIAL</th><th>QUANTIDADE</th><th>VL. UNIT.</th><th>TOTAL</th><th>EDITAR</th><th>DELETAR</th></tr>
<?php 
$valorTotalGeral=0;
while($objMat2=mysql_fetch_object($sqlOrdem)){
  $totalInicial=$objMat2->quant*str_replace(",",".",str_replace(".","",$objMat2->vlunit));
	$valorTotalGeral+=$totalInicial;
	echo "<tr><td>".utf8_encode($objMat2->nome)."<br>".utf8_encode($objMat2->descricao)."</td><td>".$objMat2->quant."</td><td>".$objMat2->vlunit."</td><td>".number_format($totalInicial,2,",",".")."</td><td><form action='novaOrdem.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMat2->id."'/><input type='submit' name='edit' value='Editar' class='button'/></form></td><td><form action='deleteItemOrd.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMat2->id."'/><input type='submit' name='edit' value='Deletar' class='button'/></form></td></tr>";
	}
echo "<tr><th align='right' colspan='3'>TOTAL GERAL</th><td><strong>R$ ".number_format($valorTotalGeral,2,",",".")."</strong></td><th colspan='2'></th></tr>";
echo "</table>";

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
<?php 
echo utf8_encode($_SESSION['compordem']);
?>
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
<?php 
	}
?>