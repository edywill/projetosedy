<?php 
echo "<div id='tabela'><table border='1' width='100%'>
<tr><th colspan='4' align='center'>MODALIDADES</td></tr>
<tr><td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idAt' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='ATLETISMO' class='button'/>
</form>
</td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idBf' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='BASQ. FEM.' class='button'/>
</form>
</td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idBm' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='BASQ. MASC.' class='button'/>
</form></td>

<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idBoc' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='BOCHA' class='button'/>
</form>
</td>
</tr>
<tr><td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idCic' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='CICLISMO' class='button'/>
</form>
</td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idEsg' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='ESGRIMA' class='button'/>
</form>
</td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idFuc' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='FUTEBOL 5' class='button'/>
</form></td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idFus' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='FUTEBOL 7' class='button'/>
</form>
</td>
</tr>

<tr><td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idGof' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='GOALBALL FEM.' class='button'/>
</form>
</td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idGom' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='GOALBALL MASC.' class='button'/>
</form>
</td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idHalt' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='HALTEROFILISMO' class='button'/>
</form></td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idHip' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='HIPISMO' class='button'/>
</form>
</td>
</tr>

<tr><td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idJud' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='JUD&Ocirc;' class='button'/>
</form>
</td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idNat' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='NATA&Ccedil;&Atilde;O' class='button'/>
</form>
</td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idCan' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='PARACANOAGEM' class='button'/>
</form></td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idThl' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='PARATRIATHLON' class='button'/>
</form>
</td>
</tr>

<tr><td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idRem' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='REMO' class='button'/>
</form>
</td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idRug' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='RUGBY' class='button'/>
</form>
</td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idTen' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='T&Ecirc;NIS' class='button'/>
</form></td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idTar' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='TIRO ARCO' class='button'/>
</form>
</td>
</tr>

<tr><td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idTes' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='TIRO ESPORTIVO' class='button'/>
</form>
</td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idVeL' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='VELA' class='button'/>
</form>
</td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idVof' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='VOLEI. FEMININO' class='button'/>
</form></td>
<td align='center'>
<form action='../modalidades/index.php' name='formProjEdit' method='post'>
<input type='hidden' name='idVom' value='".$arrayDetProj['id']."'/>
<input type='submit' name='editar' value='VOLEI. MASCULINO' class='button'/>
</form>
</td>
</tr>
</table></div>";
?>