<?php 
echo "<div id='tabela'><table border='1' width='100%'>
<tr><th colspan='3' align='center'>TIPO</td></tr>
<tr><td align='center'>
<form action='../despesas/projec.php' name='formProjEdit' method='post'>
<input type='hidden' name='eventopas' id='eventopas'/>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='pas' name='tipoDesp'/>
<input type='submit' name='editar' value='PASSAGEM A&Eacute;REA' class='button' onclick='carregaEvento()'/>
</form>
</td>
<td align='center'>
<form action='../despesas/projec.php' name='formProjEdit' method='post'>
<input type='hidden' name='eventohos' id='eventohos' />
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='hos' name='tipoDesp'/>
<input type='submit' name='editar' value='HOSPEDAGEM' class='button' onclick='carregaEvento()'/>
</form>
</td>
<td align='center'>
<form action='../despesas/projec.php' name='formProjEdit' method='post'>
<input type='hidden' name='eventoali' id='eventoali' />
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='ali' name='tipoDesp'/>
<input type='submit' name='editar' value='ALIMENTA&Ccedil;&Atilde;O' class='button' onclick='carregaEvento()'/>
</form>
</td>
</tr>
<tr><td align='center'>
<form action='../despesas/projec.php' name='formProjEdit' method='post'>
<input type='hidden' name='eventotra' id='eventotra' />
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='tra' name='tipoDesp'/>
<input type='submit' name='editar' value='TRANSPORTE' class='button' onclick='carregaEvento()'/>
</form>
</td>
<td align='center'>
<form action='../despesas/projec.php' name='formProjEdit' method='post'>
<input type='hidden' name='eventosgv' id='eventosgv' />
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='sgv' name='tipoDesp'/>
<input type='submit' name='editar' value='SEGURO VIAGEM' class='button' onclick='carregaEvento()'/>
</form>
</td>
<td align='center' colspan='3'>
<form action='../despesas/projec.php' name='formProjEdit' method='post'>
<input type='hidden' name='eventorht' id='eventorht' />
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='rht' name='tipoDesp'/>
<input type='submit' name='editar' value='RH DO EVENTO' class='button' onclick='carregaEvento()'/>
</form>
</td>
</tr>
</table></div>";
?>