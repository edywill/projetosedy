<?php 
	$meses = array (1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
	$mesNum=(int)date('m');
	$dataHoje=date("d")." de ".$meses[$mesNum]." de ".date("Y");
	if(!empty($_GET['id'])){
	$idOrdem=$_GET['id'];
	$_SESSION['idOrdemImpPdf']=$idOrdem;
	}
$sqlOrdemGeral=mysql_query("SELECT aquiordem.*, aquireg.cdempres FROM aquiordem INNER JOIN aquireg ON aquireg.id=aquiordem.idreg WHERE aquiordem.id='".$_SESSION['idOrdemImpPdf']."'") or die(mysql_error());
$arrayOrdemGeral=mysql_fetch_array($sqlOrdemGeral);

$sqlEmpresaEdit=odbc_fetch_array(odbc_exec($conCab,"select Cd_empresa,Nome_completo,Cnpj_cpf
from GEEMPRES (nolock) 
where Cd_empresa='".$arrayOrdemGeral['cdempres']."'"));
$numOrdem=$arrayOrdemGeral["idos"]."/".$arrayOrdemGeral["ano"];
				$empresa=str_replace("?","-",utf8_encode($sqlEmpresaEdit['Nome_completo']))." - ".mask($sqlEmpresaEdit['Cnpj_cpf'],'##.###.###/####-##');
			$processo=str_replace("?","-",utf8_encode($arrayOrdemGeral['doc']));
			$faturamento=str_replace("?","-",utf8_encode($arrayOrdemGeral['fatura']));
			$evento=str_replace("?","-",utf8_encode($arrayOrdemGeral['evento']));
			$tabelaMaterial='';
			$sqlPedidosOrdem=mysql_query("SELECT aquipedidoitem.id AS iditor,aquipedidoitem.qtd,aquimat.quant,aquimat.vlunit,aquicadmat.nome,aquigrupo.descricao,aquimat.id AS idmat
	FROM aquipedidoitem LEFT JOIN aquimat ON aquimat.id=aquipedidoitem.idmat
	LEFT JOIN aquicadmat ON aquicadmat.id=aquimat.cdmat
	LEFT JOIN aquigrupo ON
aquigrupo.id=aquicadmat.grupo
WHERE aquipedidoitem.idos='".$idOrdem."'");
	$valorTotal=0;
	$valorTotalUnit=0;
	while($objPedidoOrdem=mysql_fetch_object($sqlPedidosOrdem)){
		$valorItem=0;
		$valorItem=str_replace(",",".",str_replace(".","",$objPedidoOrdem->vlunit));
		$valorTotalItem=(float)$valorItem*$objPedidoOrdem->qtd;
		$valorTotalUnit+=$valorItem;
		$valorTotal+=$valorTotalItem;
		$tabelaMaterial.="<tr><td align='left'><font>".utf8_encode($objPedidoOrdem->nome)."</font></td><td align='center'><font>".$objPedidoOrdem->qtd."</font></td><td align='center'><font>".number_format($valorItem,2,",",".")."</font></td><td align='center'><font>".number_format($valorTotalItem,2,",",".")."</font></td></tr>";
		}
		$tabelaMaterial.='<tr>
      <td colspan="2" align="center"><strong>TOTAL</strong></td><td align="center"><strong>'.number_format($valorTotalUnit,2,",",".").'</strong></td><td align="center"><strong>'.number_format($valorTotal,2,",",".").'</strong></td></tr>';
	  $descricao=html_entity_decode(utf8_encode($arrayOrdemGeral['descric']));
	  $valorDaOrdem=$arrayOrdemGeral['vlunit'];
	  $dtlcentrega=html_entity_decode(utf8_encode($arrayOrdemGeral['dtentrega']));
	  $obsComp=html_entity_decode(utf8_encode($arrayOrdemGeral['comp']));
	  $complemento="O pagamento ser&aacute; efetuado por meio de ordem banc&aacute;ria ou qualquer outro meio id&ocirc;neo adotado pelo CPB, mediante a apresenta&ccedil;&atilde;o de Nota Fiscal / Fatura devidamente atestada (respons&aacute;vel pelo recebimento), no prazo de at&eacute; <u>10 (dez) dias &uacute;teis a contar do seu recebimento</u>, devendo ser efetuada a reten&ccedil;&atilde;o na fonte dos tributos e contribui&ccedil;&otilde;es determinadas pelos &oacute;rg&atilde;os fiscais e fazend&aacute;rios em conformidade com a legisla&ccedil;&atilde;o vigente, quando for o caso.<br>
Pela inadimpl&ecirc;ncia total ou parcial da presta&ccedil;&atilde;o dos servi&ccedil;os ou entrega do bem, a CONTRATADA se sujeitar&aacute; &aacute;s seguintes san&ccedil;&otilde;es, sendo-lhe assegurado o contradit&oacute;rio e a ampla defesa: <br><br>

I - advert&ecirc;ncia, para os casos de infra&ccedil;&atilde;o de menor potencial, e desde que n&atilde;o haja preju&iacute;zo para o CPB;<br>
II - multa, administrativa, gradual conforme a gravidade da infra&ccedil;&atilde;o, n&atilde;o excedente a 20% (vinte por cento) do valor do contrato;<br>
III - multa morat&oacute;ria de 1% (um por cento) do valor do contrato por dia de atraso na execu&ccedil;&atilde;o dos servi&ccedil;os, at&eacute; o 10º dia, e de 2% (dois por cento) a partir do 11&ordm; at&eacute; o 30&ordm;, ap&oacute;s o que ensejar&aacute; a rescis&atilde;o;<br>
IV - suspens&atilde;o do direito de contratar com o CPB, pelo prazo de 2 (dois) anos.";
	  $assinaturaEletronica="Assinado Eletronicamente <br><b>".utf8_encode($arrayOrdemGeral['emissor'])."</b> <br><b> ".$arrayOrdemGeral['data']."</b>";
	  
	  $codigoHash=geraSenha(15);
?>
