<table border='0'>
		  <tr><td colspan='2'><strong><font size='+1'>RPA - Recibo Pagamento Aut&ocirc;nomo</font></strong></td></tr>
	<div align='right'><font size='-2' color=red>*Campos obrigat&oacute;rios</font></div>
		  <tr><td><strong><font color=red>*</font>Benefici&aacute;rio:</strong> </td><td colspan='2'> <input class='input' name='rpaCod' id='rpaCod' type='text' size='80' value=''/>
  </td></tr>
  <tr><td>
	<strong>Fun&ccedil&atildeo:</strong></td><td colspan='2'><input class='input' name='cargoRpa' id='cargoRpa' type='text' size='35' maxlength='39' value='' /><font size='-2'>Preencher somente se quiser alterar a fun&ccedil&atildeo para essa solicita&ccedil;&atilde;o.</font>
  </td></tr>
  
  <tr><td>
	<strong><font color=red>*</font>In&iacute;cio:</strong></td><td><input class='input' name='inicioRpa' id='inicioRpa' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" readonly value=''/>
	<strong><font color=red>*</font>Fim:</strong><input class='input' name='fimRpa' id='fimRpa' type='text' size='10' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" readonly  value=''/>
  </td></tr>
  <tr><td>
  <strong><font color=red>*</font>Valor:</strong></td><td><input class='input' name='valorRpa' id='valorRpa' type='text' value='' size='10' maxlength='11' onkeyup=\"somenteNumeros(this)\"/><br />
  </td></tr>
  </table>
