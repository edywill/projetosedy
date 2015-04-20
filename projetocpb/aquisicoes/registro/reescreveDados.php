<?php
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";
$sqlMaterial2=mysql_query("SELECT aquimat.id,aquimat.cdmat,aquimat.quant,aquimat.vlunit,aquigrupo.codigo,aquigrupo.descricao,aquicadmat.nome FROM aquimat LEFT JOIN aquicadmat ON aquimat.cdmat=aquicadmat.id
LEFT JOIN aquigrupo ON aquicadmat.grupo=aquigrupo.id WHERE aquimat.idreg='".$_SESSION['idRegAqui']."'") or die(mysql_error());
echo '<h4>ITENS CADASTRADOS</h4>
<table border="1" width="100%">
<tr>
<th>GR. DESPESA</th><th>MATERIAL</th><th>QUANTIDADE</th><th>VALOR UNITARIO(R$)</th><th>EDITAR</th><th>DELETAR</th></tr>';
while($objMat=mysql_fetch_object($sqlMaterial2)){
	echo "<tr><td>".$objMat->codigo."<br>".utf8_encode($objMat->descricao)."</td><td>".utf8_encode($objMat->nome)."</td><td>".$objMat->quant."</td><td>R$ ".$objMat->vlunit."</td><td><form action='insereItensSrp.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMat->id."'/><input type='submit' name='edit' value='Editar' class='button'/></form></td><td><form action='deleteItemSrp.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMat->id."'/><input type='submit' name='edit' value='Deletar' class='button'/></form></td></tr>";
	}

echo "</table>";
?>