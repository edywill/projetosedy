<table border="0" width="100%">
<tr height="34"><td colspan="4"><h2 id="h2"> CADASTRO DE ITENS</h2></td></tr>
<tr height="34">
  <td width="21%"><strong>MATERIAL:</strong></td><td colspan="3"><input type="text" class="input" name="material" id="material" size="50" maxlength="50" value='RPA - PAGAMENTO DE AUTONOMOS + IMPOSTOS' onblur="this.value=this.value.toUpperCase()" style="background: url(css/icone_lupa.png) no-repeat right;" autocomplete='off'/></td></tr>
<td><strong>QUANTIDADE:</strong></td><td><input type="text" class="input" name="material" id="material" size="20" maxlength="10" value='1'/></td><td><strong>VALOR UNITÁRIO :</strong></td><td>R$<input type="text" class="input" name="vlunit" id="vlunit" size="20" maxlength="10" value='4.000,00'/></td></tr>
<tr>
<td><strong>PRAZO DE ENTREGA:</strong></td><td colspan="3"><input type="text" class="input" name="prazo" id="prazo" size="20" maxlength="20" value='24/07/2015' onblur="this.value=this.value.toUpperCase()" style="background: url(css/icone_calendario.png) no-repeat right;"/></td></tr>
<tr><td><strong>GERENCIAL:</strong></td><td colspan="3"><input type="text" class="input" name="material" id="material" size="50" maxlength="50" value='8.01.02.80-MANUTENÇÃO SUAFC' onblur="this.value=this.value.toUpperCase()" style="background: url(css/icone_lupa.png) no-repeat right;" autocomplete='off'/></td></tr>
<tr>
<td><strong>ARQUIVOS:</strong></td><td colspan="3">
<form action="upload.php" class="dropzone" enctype="multipart/form-data" method='post'>
</form>
</td></tr>
<tr>
  <td colspan="4"><strong>DETALHAMENTO DO ITEM:</strong></td></tr>
<tr><td colspan="4"><textarea name="justificativa" id="justificativa" cols="74" rows="5" onKeyPress="javascript:limita('objetivo',450);">Rpa para pagamento de Árbitro no Open de Atletismo</textarea></td></tr>
<tr height="34"><td colspan="2"></td><td colspan="2" align="right"><input type="submit" id='ok' name="ok" class="button" value="ATUALIZAR ITEM" onClick="ButtonClicked()"/></td></tr>
</table>