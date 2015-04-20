<?php 
echo "<form action='passagem/pasNovo.php' method='post' name='formcad'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='submit' class='button' value='Novo Trecho Nacional' name='evento'/>
</form>";
echo "<form action='passagem/pasNovo.php' method='post' name='formcad'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='submit' class='button' value='Novo Trecho Internacional' name='evento'/>
</form>";

echo "<h3>Lista de Trechos</h3>";
$sqlPas=mysql_query("SELECT convpas.*,convpas.id AS idpas FROM convpas WHERE convpas.idproj='".trim($id)."' AND convpas.modal='".$tipoId."' AND convpas.idevento='".$idEvento."'") or die(mysql_error());
echo "<div id='tabela'><table border='1' width='100%'>
<tr><th width='30%'>Itinerário</th><th width='15%'>Tipo / Abrang.</th><th width='10%'>Quantidade</th><th width='20%'>Valor do Trecho(R$)</th><th width='15%'>Valor Total(R$)</th><th width='15%'>A&ccedil;&otilde;es.</th></tr>";
$tipo='';
$itinerario='';
$vlTotPas=0;
$edit='editPas.php';
while($objPas=mysql_fetch_object($sqlPas)){
	if($objPas->abrgpas=='Nacional'){
		$abrang='Nacional';
		$sqlReferenciaPreco=mysql_fetch_array(mysql_query("SELECT * FROM convpasintreferencia WHERE origem='".$objPas->origem."' AND destino='".$objPas->destino."'"));
		$sqlPasRef=mysql_query("SELECT municipio,uf FROM municipios WHERE id='".$objPas->origem."'") or die(mysql_error());
		$arrayPasRef=mysql_fetch_array($sqlPasRef);
		$origem=utf8_encode($arrayPasRef['municipio'])."/".utf8_encode($arrayPasRef['uf']);
		$sqlPasRefDest=mysql_query("SELECT municipio,uf FROM municipios WHERE id='".$objPas->destino."'") or die(mysql_error());
		$arrayPasRefDest=mysql_fetch_array($sqlPasRefDest);
		$destino=utf8_encode($arrayPasRefDest['municipio'])."/".utf8_encode($arrayPasRefDest['uf']);
		$itinerario=$origem." X ".$destino;
		if($objPas->tipo==1){
		$tipo='IDA';
		}else{
			$tipo='IDA e VOLTA';
			$itinerario=$origem." X ".$destino." X ".$origem;
			}
		}else{
			$abrang='Internacional';
			$sqlReferenciaPreco=mysql_fetch_array(mysql_query("SELECT * FROM convpasintreferencia WHERE origem='".$objPas->cidadeorigem."-".$objPas->origem."' AND destino='".$objPas->cidadedestino."-".$objPas->destino."'"));
			$origem=utf8_encode($objPas->cidadeorigem)."/".utf8_encode($objPas->origem);
			$destino=utf8_encode($objPas->cidadedestino)."/".utf8_encode($objPas->destino);
			$itinerario=$origem." X ".$destino;
			}
	echo "<tr><td width='15%'><font size='-2'>".$itinerario."</font></td><td width='20%'>".$tipo."/".$abrang."</td><td width='15%'>".$objPas->qtd."</td><td width='15%'>".$sqlReferenciaPreco['valor']."</td><td width='15%'>".$objPas->total."</td><td width='25%'>
<table border='0'><tr border='0'><td>
<form action='passagem/".$edit."' name='formProjConv' method='post'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='".$abrang."' name='abrg'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' name='idPas' value='".$objPas->idpas."'/>
<input type='submit' name='edit' value='Editar' class='button'/>
</form>
</td><td>
<form action='passagem/deletarPas.php' name='formProjConv' method='post'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='idproj'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' name='idPas' value='".$objPas->idpas."'/>
<input type='submit' name='delete' value='Deletar' class='button'/>
</form></td></tr></table></td></tr>";
	$vlTotPas=$vlTotPas+str_replace(",",".",str_replace(".","",$objPas->total));
	}
echo "<tr><th colspan='4' align='right'>Valor Global(R$)</th><td colspan='2'><strong>".number_format($vlTotPas,2,",",".")."</strong></td></tr>";
echo "</table></div>";
?>
</div>
</body>
</html>