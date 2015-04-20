<?php 
$sqlDetProj=mysql_query("SELECT * FROM convprojetos WHERE id='".trim($id)."'") or die(mysql_error());
$arrayDetProj=mysql_fetch_array($sqlDetProj);
echo "<div id='tabela'><table border='1' width='100%'>
<tr><th width='20%'>T&iacute;tulo do Projeto:</th><td colspan='3'>".utf8_encode($arrayDetProj['titulo'])."</td></tr>
<tr><th>N&ordm;. Conv.:</th><td width='20%'>".$arrayDetProj['numconv']."</td><th width='20%'>N&ordm;. Proposta:</th><td width='20%'>".$arrayDetProj['numprop']."</td><tr>
<tr><th>In&iacute;cio da Vig.:</th><td width='20%'>".$arrayDetProj['iniciovig']."</td><th width='20%'>Fim da Vig.:</th><td width='20%'>".$arrayDetProj['fimvig']."</td><tr>
<tr><td align='center' colspan='2'><form action='../projetos/editProj.php' name='formProjEdit' method='post'><input type='hidden' name='idEdit' value='".$arrayDetProj['id']."'/><input type='submit' name='editar' value='Editar' class='button'/></form></td><td align='center' colspan='2'><form action='../projetos/delProjeto.php' name='formProjDel' method='post'><input type='hidden' name='idDel' value='".$arrayDetProj['id']."'/><input type='submit' name='editar' value='Excluir' class='button'/></form></td></tr>
</table></div>";
//echo "<tr><td align='center' colspan='2'><form action='../relatorio.php' target='_blank' name='formProjEdit' method='post'><input type='hidden' name='idEdit' value='".$arrayDetProj['id']."'/><input type='submit' name='editar' value='Consolidado' class='button'/></form></td><td align='center' colspan='2'></td></tr>";
?>