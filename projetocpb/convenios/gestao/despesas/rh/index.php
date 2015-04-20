<?php 
echo "<form action='rh/rhNovo.php' method='post' name='formcad'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='submit' class='button' value='Novo RH ' name='evento'/>
</form>";

echo "<h3>Lista de RH ".$titMod."</h3>";
$sqlRhPerm=mysql_query("SELECT convrh.*,convrhreferencia.funcao FROM convrh,convrhreferencia WHERE convrh.idproj='".trim($id)."' AND convrh.modal='".$tipoId."' AND convrh.nome=convrhreferencia.id AND convrh.idevento='".$idEvento."'") or die(mysql_error());
//$arrayEventos=mysql_fetch_array($sqlEventos);
echo "<div id='tabela'><table border='1' width='100%'>
<tr><th width='20%'>Fun&ccedil;&atilde;o</th><th width='20%'>Qtd/Tempo</th><th width='15%'>Valor Unit.(R$)</th><th width='15%'>Tributo Unit.(R$)</th><th width='15%'>Valor Total(R$)</th><th width='15%'>A&ccedil;&otilde;es.</th></tr>";
$vlTotRh=0;
while($objRhPerm=mysql_fetch_object($sqlRhPerm)){
	echo "<tr><td width='15%'>".utf8_encode($objRhPerm->funcao)."</td><td width='20%'>".$objRhPerm->qtdpes."/".$objRhPerm->qtdtem." ".utf8_encode($objRhPerm->um)."</td><td width='15%'>".$objRhPerm->vlunit."</td><td width='15%'>".$objRhPerm->tributos."</td><td width='15%'>".$objRhPerm->total."</td><td width='25%'>
<table border='0'><tr border='0'><td>
<form action='rh/editRh.php' name='formProjConv' method='post'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' name='idRh' value='".$objRhPerm->id."'/>
<input type='submit' name='edit' value='Editar' class='button'/>
</form>
</td><td>
<form action='rh/deletarRh.php' name='formProjConv' method='post'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='idproj'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' name='idRh' value='".$objRhPerm->id."'/>
<input type='submit' name='delete' value='Deletar' class='button'/>
</form></td></tr></table></td></tr>";

$vlTotRh=$vlTotRh+str_replace(",",".",str_replace(".","",$objRhPerm->total));
	}
echo "<tr><th colspan='4' align='right'>Valor Global(R$)</th><td colspan='2'><strong>".number_format($vlTotRh,2,",",".")."</strong></td></tr>";
echo "</table></div>";
?>
</div>
</body>
</html>