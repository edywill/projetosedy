<?php 
echo "<table border='0'>
<tr><th>Trecho</th><td><input name='tipo' id='tipo' type='input' size='10' class='input' value='2'/><input name='idref' id='idref' type='hidden' size='10' class='input' value='".$idRef."'/><input name='trecho' id='trecho' type='text' size='40' class='input' value='".$trecho."' onblur='buscarValorPas()'/>
<font color='red' size='-1'>*Digite parte do nome e selecione na lista</font></td></tr>
<tr><th>Abrang&ecirc;ncia</th><td>
<div id='abrg'>Internacional</spam>
</td></tr>
<tr><th>Dt. Partida</th><td><input name='dtinicio' id='dtinicio' type='text' size='40' class='input' value='".$dtinicio."' readonly/></td></tr>
<tr><th>Dt. Retorno</th><td><input name='dtfim' id='dtfim' type='text' size='40' class='input' value='".$dtfim."' readonly/></td></tr>
<tr><th>Quantidade</th><td><input name='qtd' id='qtd' type='text' size='15' class='input' value='".$qtd."' onkeyup=\"somenteNumeros (this)\" onblur='buscarValorPasV()'/></td></tr>
<tr><th>Valor do Trecho(R$):</th><td><input name='vlunit' readonly id='vlunit' type='text' size='40' class='input' value='".$vlunit."' onblur='buscarValorPasV()'/></td></tr>
<tr><th>Valor Total (R$):</th><td><input name='total' id='total' type='text' size='40' class='input' value='".$total."' readonly='readonly'/></td></tr>
<tr><td></td><td><input id='ok' type='submit' class='button' value='".$titButton."' name='ok' /></td></tr>
</table>";
?>
