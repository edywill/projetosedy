<?php 
echo "<form action='material/matNovo.php' method='post' name='formcad'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='submit' class='button' value='Novo Material' name='evento'/>
</form>";

echo "<h3>Lista de Materiais</h3>";
$sqlMat=mysql_query("SELECT convmat.* FROM convmat WHERE convmat.idproj='".trim($id)."' AND convmat.modal='".$tipoId."'") or die(mysql_error());
echo "<div id='tabela'><table border='1' width='100%'>
<tr><th width='20%'>Descri&ccedil;&atilde;o</th><th width='15%'>Qtd</th><th width='15%'>Valor Unit.(R$)</th><th width='15%'>Total(R$)</th><th width='15%'>A&ccedil;&otilde;es.</th></tr>";
$tipo='';
$vlTotMat=0;
$count=0;
while($objMat=mysql_fetch_object($sqlMat)){
	echo "<tr><td width='15%'><font size='-1'>".utf8_encode($objMat->descricao)."</font></td><td width='20%'>".$objMat->qtd."</td><td width='15%'>".$objMat->vlunitreal."</td><td width='15%'>".$objMat->totalreal."</td><td width='25%'>
<table border='0'><tr border='0'><td>
<form action='material/editMat.php' name='formProjConv' method='post'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' name='idMat' value='".$objMat->id."'/>
<input type='submit' name='edit' value='Editar' class='button'/>
</form>
</td><td>
<form action='material/deletarMat.php' name='formProjConv' method='post'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='idproj'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' name='idMat' value='".$objMat->id."'/>
<input type='submit' name='delete' value='Deletar' class='button'/>
</form></td></tr></table></td></tr>";
	$vlTotMat=$vlTotMat+str_replace(",",".",str_replace(".","",$objMat->totalreal));
	}
echo "<tr><th colspan='4' align='right'>Valor Global(R$)</th><td colspan='2'><strong>".number_format($vlTotMat,2,",",".")."</strong></td></tr>";
echo "</table></div>";
?>
</div>
</body>
</html>