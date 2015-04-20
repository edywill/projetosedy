<?php 
echo "<table border='0'>
<tr><th>Material</th><td><input name='material' id='material' type='text' size='40' class='input' value='".utf8_encode($descricao)."'/></td></tr>
<tr><th>Quantidade</th><td><input name='qtd' id='qtd' type='text' size='10' class='input' value='".$qtd."' onkeyup=\"somenteNumeros (this)\" onblur='buscarValorMat2()'/></td></tr>
<tr><th>Tipo</th><td>
<select name='tipo' id='tipo'>";
if($tipo==''){
	echo "<option value='' selected>Selecione</option>";
	}else{
		echo "<option value='".$tipo."' selected>".strtoupper($tipo)."</option>";
		}
echo "<option value='capital'>CAPITAL</option>
<option value='custeio'>CUSTEIO</option></select>
</td></tr>
<tr><th>Moeda:</th><td>
<select id='moeda' name='moeda' onchange='buscarValorMat()'>";
if($moeda==''){
	echo "<option selected value='R$'>R$</option>";
	}else{
		echo "<option selected value='".$moeda."'>".$moeda."</option>";
		}
echo "<option  value='USD'>USD</option>
<option  value='EUR'>EUR</option>
<option  value='GBP'>GBP</option>
<option  value='JPY'>JPY</option>
<option  value='Outros'>Outros</option>
</select>
</td></tr>
<tr><th>Taxa de C&acirc;mbio (%):</th><td><input name='txcamb' id='txcamb' type='text' size='10' class='input' value='".$txcamb."' onblur='buscarValorMat2()'/><input name='dtcotacao' id='dtcotacao' type='hidden' size='10' class='input' value='".$dtcotacao."'/><font size='-1' color='red'><spam id='dataText'>".$dtcotacao."</spam> - <spam id='horaText'></spam><a href='http://www4.bcb.gov.br/pec/conversao/conversao.asp' target='_blank'><input type='button' class='button' name='button' value='Conf. Cota&ccedil;&atilde;o'/>'</a></font></td></tr>

<tr><th>Valor Unit&aacute;rio(<spam id='moedaText'>R$</spam>)</th><td><input name='vlunitmoeda' id='vlunitmoeda' type='text' size='20' class='input' value='".$vlunitmoeda."' onblur='buscarValorMat2()'/></td></tr>
<tr><th>Valor Total (<spam id='moedaText1'>R$</spam>):</th><td><input name='totalmoeda' id='totalmoeda' type='text' size='20' class='input' value='".$totalreal."' readonly='readonly'/></td></tr>

<tr><th>Valor Unit&aacute;rio (R$):</th><td><input name='vlunitreal' id='vlunitreal' type='text' size='20' class='input' value='".$vlunitreal."' readonly='readonly' onblur='buscarValorMat2()'/></td></tr>
<tr><th>Valor Total (R$):</th><td><input name='totalreal' id='totalreal' type='text' size='20' class='input' value='".$totalreal."' readonly='readonly'/></td></tr>

<tr><td></td><td><input id='ok' type='submit' class='button' value='".$titButton."' name='ok' /></td></tr>
</table>";
?>
