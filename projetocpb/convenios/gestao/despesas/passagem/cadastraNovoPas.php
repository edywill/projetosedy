<?php 
echo "<table border='0'>
<tr><th>Tipo</th><td><input name='tipo' id='tipo' type='hidden' size='10' class='input' value='2'/><input name='idref' id='idref' type='hidden' size='10' class='input' value=''/>IDA e VOLTA</td></tr>";
	if($abrangencia=='Nacional'){
	$sqlOrigemEventoCidade=mysql_fetch_array(mysql_query("SELECT municipio FROM municipios WHERE id='".$origem."'"));
	echo "<tr><th>Origem</th><td>
	<div class='ui-widget'>
	<select name='origem' id='comboboxOrigem' onclick='buscarValorPas()'>";
	if(!empty($origem)){
	echo "<option value='".$origem."' selected>".utf8_encode($sqlOrigemEventoCidade['municipio'])."</option>";
		}else{
	echo "<option value='".$origem."' selected>Selecione</option>";
		}
	$sqlCidadesPasOrigem=mysql_query("SELECT * FROM municipios ORDER BY municipio");
	while($objCidadesPasOrigem=mysql_fetch_object($sqlCidadesPasOrigem)){
		if($objCidadesPasOrigem->id<>$origem){
			echo "<option value='".$objCidadesPasOrigem->id."'>".utf8_encode($objCidadesPasOrigem->municipio)."/".$objCidadesPasOrigem->uf."</option>";
			}
		}
	echo "</select></div></td></tr>
	<tr><th>Destino</th><td><input type='hidden' class='input' name='cidorigem' name='cidorigem' value=''/><input type='hidden' class='input' name='ciddestino' name='cidstino' value=''/>
	<div class='ui-widget'>
	<select name='destino' id='comboboxDestino' onclick='buscarValorPas()' >";
	$sqlDestinoEventoCidade=mysql_fetch_array(mysql_query("SELECT municipio FROM municipios WHERE id='".$destino."'"));
	if(!empty($destino)){
	echo "<option value='".$destino."' selected>".utf8_encode($sqlDestinoEventoCidade['municipio'])."</option>";
		}else{
	echo "<option value='".$origem."' selected>Selecione</option>";
		}
	$sqlCidadesPasDestino=mysql_query("SELECT * FROM municipios ORDER BY municipio");
	while($objCidadesPasDestino=mysql_fetch_object($sqlCidadesPasDestino)){
		if($objCidadesPasDestino->id<>$destino){
			echo "<option value='".$objCidadesPasDestino->id."'>".utf8_encode($objCidadesPasDestino->municipio)."/".$objCidadesPasDestino->uf."</option>";
			}
		}
	echo "</select></div></td></tr>";
	}else{
	$sqlOrigemEventoPais=mysql_fetch_array(mysql_query("SELECT nome FROM paises WHERE iso='".$origem."'"));
	echo "
	<tr><th>Cidade Origem</th><td><input type='text' class='input' name='cidorigem' id='cidorigem' value='".$cidorigem."' onclick='buscarValorPas()'/></td></tr>
	<tr><th>Pa&iacute;s Origem</th><td>
	<div class='ui-widget'>
	<select name='origem' id='comboboxOrigem' onclick='buscarValorPas()'>";
	if(!empty($origem)){
	echo "<option value='".$origem."' selected>".utf8_encode($sqlOrigemEventoPais['nome'])."</option>";
		}else{
	echo "<option value='".$origem."' selected>Selecione</option>";
		}
	$sqlPaisPasOrigem=mysql_query("SELECT * FROM paises ORDER BY nome");
	while($objPaisPasOrigem=mysql_fetch_object($sqlPaisPasOrigem)){
		if($objPaisPasOrigem->iso<>$origem){
			echo "<option value='".$objPaisPasOrigem->iso."'>".utf8_encode($objPaisPasOrigem->nome)."/".$objPaisPasOrigem->iso."</option>";
			}
		}
	echo "</select></div></td></tr>
	<tr><th>Cidade Destino</th><td><input type='text' class='input' onclick='buscarValorPas()' name='ciddestino' name='ciddestino' value='".$ciddestino."'/></td></tr>
	<tr><th>Pa&iacute;s Destino</th><td>
	<div class='ui-widget'>
	<select name='destino' id='comboboxDestino' onclick='buscarValorPas()'>";
	if(!empty($destino)){
	$sqlDestinoEventoPais=mysql_fetch_array(mysql_query("SELECT nome FROM paises WHERE iso='".$destino."'"));
	echo "<option value='".$destino."' selected>".utf8_encode($sqlDestinoEventoPais['nome'])."</option>";
		}else{
	echo "<option value='".$destino."' selected>Selecione</option>";
		}
	$sqlPaisPasDestino=mysql_query("SELECT * FROM paises ORDER BY nome");
	while($objPaisPasDestino=mysql_fetch_object($sqlPaisPasDestino)){
		if($objPaisPasDestino->iso<>$origem){
			echo "<option value='".$objPaisPasDestino->iso."'>".utf8_encode($objPaisPasDestino->nome)."/".$objPaisPasDestino->iso."</option>";
			}
		}
		echo "</select></div></td></tr>";
		}
echo "<tr><th>Abrang&ecirc;ncia</th><td>
".$abrangencia."
</td></tr>
<tr><th>Dt. Partida</th><td><input name='dtinicio' id='dtinicio' type='text' size='40' class='input' value='".$dtinicio."' readonly/></td></tr>
<tr><th>Dt. Retorno</th><td><input name='dtfim' id='dtfim' type='text' size='40' class='input' value='".$dtfim."' readonly/></td></tr>
<tr><th>Quantidade</th><td><input name='qtd' id='qtd' type='text' size='15' class='input' value='".$qtd."' onkeyup=\"somenteNumeros (this)\" onclick='buscarValorPas()' onblur='buscarValorPasV()'/></td></tr>
<tr><th>Valor do Trecho(R$):</th><td><input name='vlunit' id='vlunit' type='text' size='40' class='input' value='".$vlunit."' onclick='buscarValorPas()' onblur='buscarValorPasV()'/></td></tr>
<tr><th>Valor Total (R$):</th><td><input name='total' id='total' type='text' size='40' class='input' value='".$total."' readonly='readonly'/></td></tr>
<tr><td></td><td><input id='ok' type='submit' class='button' value='".$titButton."' name='ok' /></td></tr>
</table>";
?>
