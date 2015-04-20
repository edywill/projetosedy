<?php
session_start();
require "../../conectsqlserverci.php";
require "../../conect.php";
$sqlOrdem2=mysql_query("SELECT aquipedidoitem.id AS iditor,aquipedidoitem.qtd AS qtdor,aquimat.quant,aquimat.vlunit,aquicadmat.nome,aquigrupo.descricao,aquimat.id AS idmat
	FROM aquipedidoitem LEFT JOIN aquimat ON aquimat.id=aquipedidoitem.idmat
	LEFT JOIN aquicadmat ON aquicadmat.id=aquimat.cdmat
	LEFT JOIN aquigrupo ON
aquigrupo.id=aquicadmat.grupo
WHERE aquipedidoitem.idos='".$_SESSION['idRegOrdem']."'") or die(mysql_error());
$countOrd=mysql_num_rows($sqlOrdem2);
if($countOrd>0){
	$continuaLancOrdem="<form action='ordemDados.php' method='post' name='ordem'><input type='hidden' name='".$_SESSION['idOrdemEdit']."' value='".$_SESSION['idRegOrdem']."'/><input type='submit' class='button' name='button' value='CONTINUAR>>'/></form>";
echo "<h3> ORDEM Nº <font color='#FF0000'>".$_SESSION['idOsImpSession']."/".$_SESSION['anoOsImpSession']."</font></h3>";
echo "<h4>ITENS CADASTRADOS TOTAIS</h4>
<table border='1' width='100%'>
<tr>
<th>MATERIAL</th><th>QUANTIDADE</th><th>OBS.</th><th>EDITAR</th><th>DELETAR</th></tr>";
 $atualizaSaldo=0;
  $saldo=0;
 $solicitado=0; 
while($objMat2=mysql_fetch_object($sqlOrdem2)){
  $observ="<td></td>";
  $atualizaSaldo=0;
  $saldo=0;
  $sqlPedidos2=mysql_query("SELECT qtd FROM aquipedidoitem WHERE idmat='".$objMat2->idmat."'") or die(mysql_error());
	$solicitado=0;
	while($objPedidos2=mysql_fetch_object($sqlPedidos2)){
		$solicitado=$solicitado+$objPedidos2->qtd;
		}
  $saldo=$objMat2->quant-$solicitado;
  $atualizaSaldo=$saldo;
  if($atualizaSaldo<0){
	  $observ="<td bgcolor='red'><font color='white'>Limite Ultrapassado<br>SALDO: ".$atualizaSaldo."</font></td>";
	  }
	echo "<tr><td>".utf8_encode($objMat2->nome)."<br>".utf8_encode($objMat2->descricao)."</td><td>".$objMat2->qtdor."</td>".$observ."<td><form action='novaOrdem.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMat2->iditor."'/><input type='submit' name='edit' value='Editar' class='button'/></form></td><td><form action='deleteItemOrd.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMat2->iditor."'/><input type='submit' name='edit' value='Deletar' class='button'/></form></td></tr>";
	}

echo "</table>";

		}
echo '<br />
<div id="divResultado"></div>
<br />';

echo "<form action='insereNovoItemOrd.php' name='insere' method='post' id='insere' onSubmit=\"setarCampos(this); enviarForm('insereNovoItemOrd.php', campos, 'divResultado'); return false;\">
<h4>CADASTRAR PEDIDO DE MATERIAL/SERVIÇO</h4>
<table border=\"0\" width=\"50%\"><tr>
<th width=\"30%\">Material</th><td>
<input type=\"hidden\" name=\"idatl\" id='idatl' value='".$_SESSION['idatlSession']."' />
<select name='material' id='material'>
<option selected='selected' value='".$_SESSION['materialComp']."'>".$_SESSION['materialCompDesc']."</option>";
$SQLMaterial=mysql_query("SELECT aquimat.id,aquimat.cdmat,aquimat.quant,aquimat.vlunit,aquigrupo.codigo,aquigrupo.descricao,aquicadmat.nome FROM aquimat LEFT JOIN aquicadmat ON aquimat.cdmat=aquicadmat.id
LEFT JOIN aquigrupo ON aquicadmat.grupo=aquigrupo.id WHERE aquimat.idreg='".$_SESSION['idRegAqui']."'");
 while( $objMaterial = mysql_fetch_array($SQLMaterial) )
    {	 
			echo "<option value='".$objMaterial['id']."'>".utf8_encode($objMaterial['nome'])."</option>";
			}
echo "</select>
</td></tr>
<tr>
<th width='30%'>Quantidade</th><td><input type='text' size='20' name='qtd' id='qtd' class='input' value='".$_SESSION['qtdMat']."'></td>
</tr>
<tr><td width='30%'><a href='index.php'><input type='button' name='submit' class='button' value='<<Voltar' /></a></td><td align='right'><input type='submit' name='submit' class='button' value='";

if(empty($_SESSION['idatlSession'])){
	echo "Incluir";
}else{
	echo "Atualizar";
	}
echo "'/></td></tr>
</table>
</form>
<div align='right'>
<p align='right'>".$continuaLancOrdem."</p>
</div>
</div>
</div>
";
?>