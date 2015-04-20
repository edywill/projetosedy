<?php 
include "../../conect.php";
 
$codGrupo = $_GET['grupo'];
 
$sql = "SELECT * FROM aquicadmat WHERE grupo='".$codGrupo."' AND inativo=0";
$res = mysql_query($sql) or die(mysql_error()); 
echo '<select name="material" id="material">';
echo "<option value='0' selected='selected'>Selecione o Material</option>";
while($objMaterial=mysql_fetch_object($res)){
	echo "<option value='".$objMaterial->id."'>".utf8_encode($objMaterial->nome)."</option>";
	}
echo '</select>';

?>