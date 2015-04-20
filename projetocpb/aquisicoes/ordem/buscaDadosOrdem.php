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
	  $complemento="O pagamento será efetuado por meio de ordem bancária ou qualquer outro meio idôneo adotado pelo<br> CPB, mediante a apresentação de Nota Fiscal/Fatura devidamente atestada (responsável pelo recebimento),<br> no prazo de até <u>10 (dez) dias úteis a contar do seu recebimento</u>, devendo ser efetuada a retenção na fonte<br> dos tributos e contribuições determinadas pelos órgãos fiscais e fazendários em conformidade com a<br> legislação vigente, quando for o caso.";
	  $assinaturaEletronica="Assinado Eletronicamente <br><b>".utf8_encode($arrayOrdemGeral['emissor'])."</b> <br><b> ".$arrayOrdemGeral['data']."</b>";
	  
	  $codigoHash=geraSenha(15);
?>
