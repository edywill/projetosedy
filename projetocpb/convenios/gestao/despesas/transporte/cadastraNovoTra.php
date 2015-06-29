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
<select name='cidade' id='comboboxCidade' onchange='buscarValorTraT()'>";
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
<input type='hidden' name='abrg' value='".$abrg."'/>".$abrg."
</td></tr>
<tr><th>Tipo</th><td><select id='tipo' name='tipo' onchange='buscarValorTraT()'>";
if(empty($tipo)){
	echo "<option value='' selected>Selecione</option>
	      <option value='van'>VAN</option>
		  <option value='mic'>MICROONIBUS/CARRETINHA</option>
		  <option value='oni'>&Ocirc;NIBUS</option>";
	}elseif($tipo=='van'){
		echo "<option value=''>Selecione</option>
	      <option value='van' selected>VAN</option>
		  <option value='mic'>MICROONIBUS/CARRETINHA</option>
		  <option value='oni'>&Ocirc;NIBUS</option>";
		}elseif($tipo=='mic'){
			echo "<option value=''>Selecione</option>
	      <option value='van'>VAN</option>
		  <option value='mic' selected>MICROONIBUS/CARRETINHA</option>
		  <option value='oni'>&Ocirc;NIBUS</option>";
			}else{
				echo "<option value=''>Selecione</option>
	      <option value='van'>VAN</option>
		  <option value='mic'>MICROONIBUS/CARRETINHA</option>
		  <option value='oni' selected>&Ocirc;NIBUS</option>";
				}
echo "</td></tr>
<tr><th>Dt. Inicio</th><td><input name='dtinicio' id='dtinicio' type='text' size='40' class='input' value='".$dtinicio."' readonly/></td></tr>
<tr><th>Dt. Fim</th><td><input name='dtfim' id='dtfim' type='text' size='40' class='input' value='".$dtfim."' readonly/></td></tr>
<tr><th>Quantidade Dias</th><td><input name='qtdDias' id='qtdDias' type='text' size='15' class='input' value='".$qtdDias."' onkeyup=\"somenteNumeros (this)\" onblur='buscarValorTraT()'/></td></tr>
<tr><th>Quantidade Veic.</th><td><input name='qtdVeic' id='qtdVeic' type='text' size='15' class='input' value='".$qtdVeic."' onkeyup=\"somenteNumeros (this)\" onblur='buscarValorTraT()'/></td></tr>
<tr><th>Valor Dia(R$)</th><td><input name='vldia' id='vldia' type='text' size='40' class='input' value='".$vldia."' onblur='buscarValorTraT()'/></td></tr>
<tr><th>Valor Total (R$):</th><td><input name='total' id='total' type='text' size='40' class='input' value='".$total."'/></td></tr>
<tr><td></td><td><input id='ok' type='submit' class='button' value='".$titButton."' name='ok' /></td></tr>
</table>";
?>
