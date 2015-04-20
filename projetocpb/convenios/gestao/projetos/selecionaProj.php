<?php 
echo "<form action='projetos/indexProjeto.php' name='formProjConv' method='post'>
<strong>Projetos:</strong><br /><br />
<select id='projeto' name='projeto'>
<option value='0' selected='selected'>Selecione o Projeto</option>";
$sqlProj=mysql_query("SELECT id,titulo FROM convprojetos") or die(mysql_error());
while($objProj=mysql_fetch_object($sqlProj)){
	echo "<option value='".$objProj->id."'>".utf8_encode ($objProj->titulo)."</option>";
	}
echo"</select>
<input type='submit' class='button' name='ok' value='OK' />
</form>";
?>