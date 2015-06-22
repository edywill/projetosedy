<?php 
echo "<table border='0'>";
if($abrg=='Internacional'){
	$arrayCidadeHos=explode("/",$cidadeHos);
echo "<tr><th>Cidade</th><td><input type='text' class='input' name='cidadedestino' id='cidadedestino' value='".$arrayCidadeHos[0]."'/>
</td></tr>";
echo "<tr><th>Pais</th><td>";
}else{
	echo "<input type='hidden' class='input' name='cidadedestino' id='cidadedestino' value=''/>";
echo "<tr><th>Cidade</th><td>";
	}
echo "
<div class='ui-widget'>
<select name='cidade' id='comboboxCidade' onchange='buscarValorHos()'>";
if(empty($cidadeHos)){
	echo "<option value='' selected>Selecione</option>";
	}else{
		if($abrg=='Nacional'){
		$sqlCidadeHos=mysql_fetch_array(mysql_query("SELECT id,municipio FROM municipios WHERE id='".$cidadeHos."'"));
		echo "<option value='".$sqlCidadeHos['id']."' selected>".utf8_encode($sqlCidadeHos['municipio'])."</option>";
		$sqlCidadeHosGeral=mysql_query("SELECT id,municipio FROM municipios ORDER BY municipio");
		while($objCidadeHosGeral=mysql_fetch_object($sqlCidadeHosGeral)){
			if($objCidadeHosGeral->id<>$cidadeHos){
				echo "<option value='".$objCidadeHosGeral->id."'>".utf8_encode($objCidadeHosGeral->municipio)."</option>";
				}
			}
		}else{
			$arrCidadeHos=explode("/",$cidadeHos);
			$sqlCidadeHos=mysql_fetch_array(mysql_query("SELECT iso,nome FROM paises WHERE iso='".$arrCidadeHos[1]."'"));
			echo "<option value='".$arrCidadeHos[1]."' selected>".utf8_encode($sqlCidadeHos['nome'])."</option>";
			$sqlCidadeHosGeral=mysql_query("SELECT iso,nome FROM paises ORDER BY nome");
			while($objCidadeHosGeral=mysql_fetch_object($sqlCidadeHosGeral)){
				if($objCidadeHosGeral->iso<>$arrCidadeHos[1]){
					echo "<option value='".$objCidadeHosGeral->iso."'>".utf8_encode($objCidadeHosGeral->nome)."</option>";
					}
				}
			}
		}
echo"</select></div>
</td></tr>
<tr><th>Abrang&ecirc;ncia</th><td>
".$abrg."<input type='hidden' name='abrg' value='".$abrg."'/>
</td></tr>
<tr><th>Dt. Inicio</th><td><input name='dtinicio' id='dtinicio' type='text' size='40' class='input' value='".$dtinicio."' readonly/></td></tr>
<tr><th>Dt. Fim</th><td><input name='dtfim' id='dtfim' type='text' size='40' class='input' value='".$dtfim."' readonly/></td></tr>
<tr><th>Quantidade Dias</th><td><input name='qtdDias' id='qtdDias' type='text' size='15' class='input' value='".$qtdDias."' onkeyup=\"somenteNumeros (this)\" onblur='buscarValorPasT()'/></td></tr>
<tr><th>Quantidade Pessoas</th><td><input name='qtdPes' id='qtdPes' type='text' size='15' class='input' value='".$qtdPes."' onkeyup=\"somenteNumeros (this)\" onblur='buscarValorPasT()'/></td></tr>
<tr><th>Qtd. Single</th><td><input name='qtdSingle' id='qtdSingle' type='text' size='15' class='input' value='".$qtdSingle."' onkeyup=\"somenteNumeros (this)\" onblur='buscarValorPasT()'/></td></tr>
<tr><th>Valor Unit. Single(R$):</th><td><input name='vlunits' id='vlunits' type='text' size='40' class='input' value='".$vlunits."' onblur='buscarValorPasT()'/></td></tr>
<tr><th>Qtd. Duplos</th><td><input name='qtdDuplo' id='qtdDuplo' type='text' size='15' class='input' value='".$qtdDuplo."' onkeyup=\"somenteNumeros (this)\" onblur='buscarValorPasT()'/></td></tr>
<tr><th>Valor Unit. Duplo(R$):</th><td><input name='vlunitd' id='vlunitd' type='text' size='40' class='input' value='".$vlunitd."' onblur='buscarValorPasT()'/></td></tr>
<tr><th>Valor Total (R$):</th><td><input name='total' id='total' type='text' size='40' class='input' value='".$total."'/></td></tr>
<tr><td></td><td><input id='ok' type='submit' class='button' value='".$titButton."' name='ok' /></td></tr>
</table>";
?>
