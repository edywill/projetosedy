<?php
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";

if(!empty($_SESSION['idGrupoSession'])){
$sqlMateriaisGrupo=mysql_query("SELECT aquigrupo.codigo,aquigrupo.descricao,aquicadmat.id,aquicadmat.nome,aquicadmat.cdmat FROM aquicadmat LEFT JOIN aquigrupo ON aquicadmat.grupo=aquigrupo.id
WHERE aquigrupo.inativo=0 AND aquicadmat.inativo=0 AND aquigrupo.id='".$_SESSION['idGrupoSession']."'
ORDER BY aquigrupo.id") or die(mysql_error());
$countMateriais=mysql_num_rows($sqlMateriaisGrupo);
if($countMateriais>0){
echo '<table border="1" width="100%">
<tr><th colspan="4">MATERIAIS DO GRUPO DE DESPESA <u>'.$_SESSION['dadosGrupoSession'];
echo '</u></th></tr>
<tr><th width="35%">MATERIAL</th><th  width="35%">MATERIAL (CIGAM)</th><th  width="15%">EDITAR</th><th  width="15%">INATIVAR</th></tr>';

while($objMateriaisGrupo=mysql_fetch_object($sqlMateriaisGrupo)){
	$buscaMatCigam=odbc_fetch_array(odbc_exec($conCab,"SELECT Descricao
FROM ESMATERI (nolock) 
WHERE Cd_reduzido='".$objMateriaisGrupo->cdmat."'"));
	echo "<tr><td>".utf8_encode($objMateriaisGrupo->nome)."</td><td>".$objMateriaisGrupo->cdmat."-".utf8_encode($buscaMatCigam['Descricao'])."</td><td><form action='novoGrupo.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMateriaisGrupo->id."'/><input type='submit' name='edit' value='Editar' class='button'/></form></td><td><form action='inativarGrupo.php' method='post' name='rel'><input type='hidden' name='idinat' value='".$objMateriaisGrupo->id."'/><input type='submit' name='inat' value='Inativar' class='button'/></form></td></tr>";
	}
echo "</table>";
 }
}
?>