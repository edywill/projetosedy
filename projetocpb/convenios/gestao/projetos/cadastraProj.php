<?php 
echo "
<table border='0'>
<tr>
<td>T&iacute;tulo do Projeto:</td>
<td> <input name='titulo' id='titulo' maxlenght='70' class='input' size='30' value='".utf8_encode($titulo)."'/></td>
</tr>
<tr>
<td>N&ordm; do Conv&ecirc;nio:</td>
<td> <input name='nconv' id='nconv' maxlenght='49' class='input' size='30' value='".$nconv."'/></td>
</tr>
<tr>
<td>N&ordm; da Proposta:</td>
<td> <input name='nprop' id='nprop' maxlenght='49' class='input' size='30' value='".$nprop."'/></td>
</tr>
<tr>
<td>Vig&ecirc;ncia:</td>
<td> In&iacute;cio:<input name='inicvig' readonly='readonly' id='inicvig' class='input' size='24' value='".$inicvig."'/><br />
     Fim:&nbsp;&nbsp;<input name='fimvig' id='fimvig' readonly='readonly' class='input' size='24' value='".$fimvig."'/></td>
</tr>
<tr><td></td><td align='right'><input class='button' type='submit' name='ok' value='".$titButton."' />
</table>";
?>
