<?php 
echo "<form action='seguro/sgvNovo.php' method='post' name='formcad'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='submit' class='button' value='Novo Seguro' name='evento'/>
</form>";

echo "<h3>Lista de Solicitações de Seguro Viagem</h3>";
$sqlSgv=mysql_query("SELECT convsgv.*,convsgv.id AS idsgv FROM convsgv WHERE convsgv.idproj='".trim($id)."' AND convsgv.modal='".$tipoId."' AND convsgv.idevento='".$idEvento."'") or die(mysql_error());
echo "<div id='tabela'><table border='1' width='100%'>
<tr><th width='20%'>Cidade/Abrang.</th><th width='15%'>Qtd. Dias</th><th width='10%'>Qtd. Pessoas</th><th width='15%'>Valor Período(R$)</th><th width='15%'>Total(R$)</th><th width='15%'>A&ccedil;&otilde;es.</th></tr>";
$tipo='';
$vlTotSgv=0;
$count=0;
while($objSgv=mysql_fetch_object($sqlSgv)){
	$local=$objSgv->local;
	if($objSgv->abrg=='nac'){
		$sqlCidade=mysql_fetch_array(mysql_query("SELECT municipio FROM municipios WHERE id='".$local."'"));
		$local=$sqlCidade['municipio'];
		}
		$vlUnit='0,00';
		if($objSgv->qtddias>0){
				$vlUnit=$objSgv->total/($objSgv->qtddias);
			}
	echo "<tr><td width='15%'><font size='-1'>".utf8_encode($local)."/".strtoupper($objSgv->abrg)."</font></td><td width='20%'>".$objSgv->qtddias."</td><td width='15%'>".$objSgv->qtdpes."</td><td width='15%'>".$vlUnit."</td><td width='15%'>".$objSgv->total."</td><td width='25%'>
<table border='0'><tr border='0'><td>
<form action='seguro/editSgv.php' name='formProjConv' method='post'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' name='idSgv' value='".$objSgv->idsgv."'/>
<input type='submit' name='edit' value='Editar' class='button'/>
</form>
</td><td>
<form action='seguro/deletarSgv.php' name='formProjConv' method='post'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='idproj'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' name='idSgv' value='".$objSgv->idsgv."'/>
<input type='submit' name='delete' value='Deletar' class='button'/>
</form></td></tr></table></td></tr>";
	$vlTotSgv=$vlTotSgv+str_replace(",",".",str_replace(".","",$objSgv->total));
	}
echo "<tr><th colspan='4' align='right'>Valor Global(R$)</th><td colspan='2'><strong>".number_format($vlTotSgv,2,",",".")."</strong></td></tr>";
echo "</table></div>";
?>
</div>
</body>
</html>