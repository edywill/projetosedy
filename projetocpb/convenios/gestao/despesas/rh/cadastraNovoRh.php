<?php 
echo "<table border='0'>
<tr><th>Nome Fun&ccedil;&atilde;o:</th><td><input name='nome' id='nome' type='text' size='40' class='input' value='".$nome."' onblur='buscarValorRh()'/><font color='red' size='-1'>*Digite parte do nome e selecione na lista</font></td></tr>
<tr><th>Tipo de Contrato</th><td>
<select name='tcont' id='tcont' onchange='desabilitaControle(this);'>";
if(empty($tcont)){
echo "<option value='pont' selected>Pontual</option>
		 <option value='clt'>C.L.T</option>";
}else{
	if($tcont=='pont'){
	echo "<option value='pont' selected>Pontual</option>
		 <option value='clt'>C.L.T</option>";
	    }else{
			echo "<option value='pont'>Pontual</option>
		 <option value='clt' selected>C.L.T</option>";
			}
	}
echo "</select>
</td></tr>
<tr><th>Quantidade (Profissionais)</th><td><input name='qtdpes' id='qtdpes' type='text' size='15' class='input' value='".$qtdpes."' onkeyup=\"somenteNumeros (this)\" onblur='buscarValorRhV()'/></td></tr>
<tr><th>Quantidade (Tempo)</th><td><input name='qtdtem' id='qtdtem' type='text' size='15' class='input' value='".$qtdtem."' onkeyup=\"somenteNumeros (this)\" onblur='buscarValorRhV()'/>
<select name='um'>";
if(empty($um)){
echo "<option value='' selected>Selecione</option>";
}else{
	echo "<option value='".utf8_encode($um)."' selected>".utf8_encode($um)."</option>";
	}
echo "
<option value='Dias'>Dias</option>
<option value='M&ecirc;s'>M&ecirc;s</option>
<option value='Horas'>Horas</option>
</select>
</td></tr>
<tr><th>Valor Unit.(R$):</th><td><input name='vlunit' readonly id='vlunit' type='text' size='40' class='input' value='".$vlunit."' onblur='buscarValorRhV()'/></td></tr>
<tr><th>Tributos Unit.(R$):</th><td><input name='tributo' id='tributo' readonly type='text' size='40' class='input' value='".$tributos."' onblur='buscarValorRhT()'/></td></tr>
<tr><th>Valor Total (R$):</th><td><input name='total' id='total' type='text' size='40' class='input' value='".$total."' readonly='readonly'/></td></tr>
<tr><td></td><td><input id='ok' type='submit' class='button' value='".$titButton."' name='ok' /></td></tr>
</table>";
?>
