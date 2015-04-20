<?php 
echo "<form action='transporte/traNovo.php' method='post' name='formcad'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='submit' class='button' value='Nova Solicitacao' name='evento'/>
</form>";

echo "<h3>Lista de Solicitações de Transporte</h3>";
$sqlTra=mysql_query("SELECT convtra.*,convtra.id AS idtra FROM convtra WHERE convtra.idproj='".trim($id)."' AND convtra.modal='".$tipoId."' AND convtra.idevento='".$idEvento."'") or die(mysql_error());
echo "<div id='tabela'><table border='1' width='100%'>
<tr><th width='20%'>Cidade</th><th width='15%'>Tipo / Abrang.</th><th width='10%'>Qtd Ve&iacute;culos/Qtd Dias</th><th width='15%'>Valor Dia(R$)</th><th width='15%'>Total(R$)</th><th width='15%'>A&ccedil;&otilde;es.</th></tr>";
$tipo='';
$vlTotTra=0;
$count=0;
while($objTra=mysql_fetch_object($sqlTra)){
	if($objTra->tipo=='van'){
	$tipo="VAN";
	}elseif($objTra->tipo=='mic'){
		$tipo="MICROONIBUS";
		}else{
			$tipo="&Ocirc;NIBUS";
			}
	$local=$objTra->local;
	if($objTra->abrg=='nac'){
		$sqlCidade=mysql_fetch_array(mysql_query("SELECT municipio FROM municipios WHERE id='".$local."'"));
		$local=$sqlCidade['municipio'];
		}
		$vlUnit='0,00';
		if($objTra->qtddias>0){
			if($objTra->qtdveic>0){
		$vlUnit=$objTra->total/($objTra->qtddias*$objTra->qtdveic);
			}
		}
	echo "<tr><td width='15%'><font size='-1'>".utf8_encode($local)." - ".strtoupper($objTra->abrg)."</font></td><td width='20%'>".$tipo."</td><td width='15%'>".$objTra->qtdveic."/".$objTra->qtddias."</td><td width='15%'>".$vlUnit."</td><td width='15%'>".$objTra->total."</td><td width='25%'>
<table border='0'><tr border='0'><td>
<form action='transporte/editTra.php' name='formProjConv' method='post'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' name='idTra' value='".$objTra->idtra."'/>
<input type='submit' name='edit' value='Editar' class='button'/>
</form>
</td><td>
<form action='transporte/deletarTra.php' name='formProjConv' method='post'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='idproj'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' name='idTra' value='".$objTra->idtra."'/>
<input type='submit' name='delete' value='Deletar' class='button'/>
</form></td></tr></table></td></tr>";
	$vlTotTra=$vlTotTra+str_replace(",",".",str_replace(".","",$objTra->total));
	}
echo "<tr><th colspan='4' align='right'>Valor Global(R$)</th><td colspan='2'><strong>".number_format($vlTotTra,2,",",".")."</strong></td></tr>";
echo "</table></div>";
?>
</div>
</body>
</html>