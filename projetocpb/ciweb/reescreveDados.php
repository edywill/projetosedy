<h2 id="h2">DADOS GERAIS</h2>
<table border="0" width="100%" class="tabelasimples">
<tr height="34"><td width="21%">
<strong>CI Nº:</strong></td><td width="79%"><font color="#FF0000">8040</font></td></tr>
<tr height="34"><td width="21%">
<strong>DESCRIÇÃO:</strong></td><td width="79%"><input type="text" class="input" name="desc" id="desc" size="50" maxlength="50" value='ARBITRAGEM DO OPEN DE ATLETISMO' onBlur="this.value=this.value.toUpperCase()"/></td></tr>
<tr height="34"><td width="21%">
<strong>LOCAL:</strong></td><td width="79%"><input type="text" class="input" name="local" id="local" size="50" maxlength="50" value='PORTO ALEGRE/RS' onBlur="this.value=this.value.toUpperCase()"/></td></tr>
<tr height="44"><td height="48">
<strong>GESTOR RESPONSÁVEL:</strong></td><td>
<select name="gestor" id="gestor">
<option value="0" >Selecione</option>
<option value="0" >CARLOS VIEIRA</option>
<option value="0" selected="selected">EDILSON ALVES</option>
</select>
</td></tr>
<tr height="34"><td colspan="2">
<strong>JUSTIFICATIVA DA CI:</strong> 
</td></tr><tr><td colspan="2">
<textarea name="justificativa" id="justificativa" cols="74" rows="5" onKeyPress="javascript:limita('objetivo',450);">Solicitação de Cotratação do árbitro do pen de atletismo em Porto Alegre.</textarea>
</td></tr></table>
<hr />
<div id="divResultado" align="center" style="backface-visibility:visible; background-color:#FBE5E6; height:auto"></div>
<div id="itens">
<div id="tabela">
<table border='1' width='100%'>
		<tr><th colspan='4'>ITENS</th></tr>
		<tr><th width='45%'>DESCRIÇÃO</th><th width='10%'>QTD</th><th width='15%'>VL. UNIT(R$)</th><th width='30%'>AÇÕES</th></tr>
<tr><td>RPA - PAGAMENTO DE AUTONOMOS + IMPOSTOS</td><td align='center'>1</td><td align='right'>4.000,00</td><td>
<table border='0' width='100%' style='border: 0px !important'><tr align='center'><td><img src='css/exclusivos.png' width='32' height='32' alt='Exclusivos' title='Exclusivos' onclick="clickModal()"/></td><td><img src='css/iconeEditar.png' width='32' height='32' alt='Editar' title='Editar' onClick="buscarDadosItem()"/></td><td><img src='css/icone_excluir.png' width='32' height='32' alt='Excluir' title='Excluir'/></td></tr></table>
</td>

<tr><th>TOTAL</th><td align='center'><strong>1</strong></td><td align='right'><strong>4.000,00</strong></td><th></th></tr>
</table>
</div>
</div>
<BR><BR>
<div id="caditem">
<table border="0" width="100%">
<tr height="34"><td colspan="4"><h2 id="h2"> CADASTRO DE ITENS</h2></td></tr>
<tr height="34">
  <td width="21%"><strong>MATERIAL:</strong></td><td colspan="3"><input type="text" class="input" name="material" id="material" size="50" maxlength="50" value='' onblur="this.value=this.value.toUpperCase()" style="background: url(css/icone_lupa.png) no-repeat right;" autocomplete='off'/></td></tr>
<td><strong>QUANTIDADE:</strong></td><td><input type="text" class="input" name="material" id="material" size="20" maxlength="10" value=''/></td><td><strong>VALOR UNITÁRIO :</strong></td><td>R$<input type="text" class="input" name="vlunit" id="vlunit" size="20" maxlength="10" value=''/></td></tr>
<tr>
<td><strong>PRAZO DE ENTREGA:</strong></td><td colspan="3"><input type="text" class="input" name="prazo" id="prazo" size="20" maxlength="20" value='' onblur="this.value=this.value.toUpperCase()" style="background: url(css/icone_calendario.png) no-repeat right;"/></td></tr>
<tr><td><strong>GERENCIAL:</strong></td><td colspan="3"><input type="text" class="input" name="material" id="material" size="50" maxlength="50" value='' onblur="this.value=this.value.toUpperCase()" style="background: url(css/icone_lupa.png) no-repeat right;" autocomplete='off'/></td></tr>
<tr>
<td><strong>ARQUIVOS:</strong></td><td colspan="3">
<form action="upload.php" class="dropzone" enctype="multipart/form-data" method='post'>
</form>
</td></tr>
<tr>
  <td colspan="4"><strong>DETALHAMENTO DO ITEM:</strong></td></tr>
<tr><td colspan="4"><textarea name="justificativa" id="justificativa" cols="74" rows="5" onKeyPress="javascript:limita('objetivo',450);"></textarea></td></tr>
<tr height="34"><td colspan="2"></td><td colspan="2" align="right"><input type="submit" id='ok' name="ok" class="button" value="INCLUIR ITEM" onClick="ButtonClicked()"/></td></tr>
</table>
</div>
<br />
<table border='0' width="100%">
<tr><td><a href="../home.php"><input type="button" class="button" name="voltar" value="<<Voltar" /></a></td><td align="right">
<div id="formsubmitbutton">
<input type="submit" id='ok' name="ok" class="button" value="CONCLUIR" onClick="ButtonClicked()"/>
</div>
<div id="buttonreplacement" style="margin-left:30px; display:none;">
<img src="../imagens/loading.gif" alt="loading...">
</div>
<script type="text/javascript">
/*
   Replacing Submit Button with 'Loading' Image
   Version 2.0
   December 18, 2012

   Will Bontrager Software, LLC
   http://www.willmaster.com/
   Copyright 2012 Will Bontrager Software, LLC

   This software is provided "AS IS," without 
   any warranty of any kind, without even any 
   implied warranty such as merchantability 
   or fitness for a particular purpose.
   Will Bontrager Software, LLC grants 
   you a royalty free license to use or 
   modify this software provided this 
   notice appears on all copies. 
*/
function ButtonClicked()
{
   document.getElementById("formsubmitbutton").style.display = "none"; // to undisplay
   document.getElementById("buttonreplacement").style.display = ""; // to display
   return true;
}
var FirstLoading = true;
function RestoreSubmitButton()
{
   if( FirstLoading )
   {
      FirstLoading = false;
      return;
   }
   document.getElementById("formsubmitbutton").style.display = ""; // to display
   document.getElementById("buttonreplacement").style.display = "none"; // to undisplay
}
// To disable restoring submit button, disable or delete next line.
document.onfocus = RestoreSubmitButton;
</script>
</td></tr>
</table>
</div>