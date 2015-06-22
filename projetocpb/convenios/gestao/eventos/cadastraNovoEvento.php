<?php 
echo "
<table border='0'>
<tr><th>Nome do Evento:</th><td><input name='nome' type='text' size='40' class='input' value='".$nome."'/></td></tr>
<tr><th>Abrang&ecirc;ncia</th><td><input name='tipoLoc' type='hidden' size='40' class='input' value='".$abrang."'/>";
if($abrang=='nac'){
	echo "Nacional";
	}else{
		echo "Internacional";
		}
echo "</td></tr>";
if($abrang=='nac'){
echo "<tr><th>Cidade:</th><td>
<div class='ui-widget'>
<select name='cidade' id='combobox'>";
if(empty($cidade)){
echo "<option value='0' selected></option>";
}else{
	$sqlCidadeAt=mysql_fetch_array(mysql_query("SELECT id,municipio FROM municipios WHERE id='".$cidade."'"));
	echo "<option value='".$cidade."' selected>".utf8_encode($sqlCidadeAt['municipio'])."</option>";
	}
$sqlCidadeGeral=mysql_query("SELECT * FROM municipios ORDER BY municipio");
while($objCidadeGeral=mysql_fetch_object($sqlCidadeGeral)){
	if($cidade<>$objCidadeGeral->id){
		echo "<option value='".$objCidadeGeral->id."'>".utf8_encode($objCidadeGeral->municipio)."</option>";
		}
	}
echo "</select></div>

</td></td></tr>
<tr><th>Estado:</th><td>
<select name='uf'>";
if(empty($uf)){
echo "<option value='0' selected>Selecione o Estado</option>";
}else{
	echo "<option value='".$uf."' selected>".utf8_encode($estado)."</option>";
	}
$sqlUf=mysql_query("SELECT * FROM estados");
while($objUf=mysql_fetch_object($sqlUf)){
	if($uf<>$objUf->uf){
		echo "<option value='".$objUf->uf."'>".utf8_encode($objUf->nome)."</option>";
		}
	}
echo "</select></td></tr>";
}else{
echo "<tr><th>Cidade:</th><td><input name='cidint' type='text' size='40' class='input' value='".$cidade."'/></td></tr>
<tr><th>Pa&iacute;s:</th><td>
<div class='ui-widget'>
<select name='pais' id='combobox'>";
		$sqlPaisAt=mysql_fetch_array(mysql_query("SELECT iso,nome FROM paises WHERE iso='".$pais."'"));
		echo "<option value='".$pais."' selected>".utf8_encode($sqlPaisAt['nome'])."</option>";
		$sqlPaisGeral=mysql_query("SELECT iso,nome FROM paises ORDER BY nome");
		while($objPaisGeral=mysql_fetch_object($sqlPaisGeral)){
			if($objPaisGeral->iso<>$pais){
			echo "<option value='".$objPaisGeral->iso."'>".utf8_encode($objPaisGeral->nome)."</option>";
				}
			}
echo "</select></div>

</td></tr>";
}

echo "<tr><th>Data de In&iacute;cio:</th><td><input name='dtinicio' id='dtinicio' readonly='readonly' type='text' size='40' class='input' value='".$dtinicio."'/></td></tr>
<tr><th>Data de T&eacute;rminio:</th><td><input name='dtfim' id='dtfim' type='text' readonly='readonly' size='40' class='input' value='".$dtfim."'/></td></tr>
<tr><td></td><td><input id='ok' type='submit' class='button' value='".$titButton."' name='ok' /></td></tr>
</table>";
?>
