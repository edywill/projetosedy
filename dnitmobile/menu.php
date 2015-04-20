<?php 
echo '<table border="0" cellpadding="2" cellspacing="0" width="80%">
  <tr align="center" valign="top">
    <td height="34" valign="bottom">
    <a href="principal.php" style="border:hidden"> <img src="imagens/butpainel.png" /></a></td>
    <td valign="bottom"><a href="usuarios.php" style="border:hidden"> <img src="imagens/butusuarios.png" /></a></td>
    <td valign="bottom"><a href="#" style="border:hidden"> <img src="imagens/butrel.png" /></a></td>';
 
	if($_SESSION['perfilSession']=='adm'){
	
    echo '<td valign="bottom"><a href="admin.php" style="border:hidden"> <img src="imagens/butadm.png" /></a></td>';
    
	}
    echo '<td valign="bottom"><a href="logout.php" style="border:hidden"> <img src="imagens/butsair.png" /></a></td>
  </tr>
</table>';
?>