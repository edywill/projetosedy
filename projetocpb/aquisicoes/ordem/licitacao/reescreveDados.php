<?php
session_start();
require "../../../conectsqlserverci.php";
require "../../../conect.php";
$sqlMaterial2=mysql_query("SELECT aquimatlic.id,aquimatlic.cdmat,aquimatlic.quant,aquimatlic.vlunit,aquigrupo.codigo,aquigrupo.descricao,aquicadmat.nome FROM aquimatlic LEFT JOIN aquicadmat ON aquimatlic.cdmat=aquicadmat.id
LEFT JOIN aquigrupo ON aquicadmat.grupo=aquigrupo.id WHERE aquimatlic.idreg='".$_SESSION['idRegAqui']."'") or die(mysql_error());
echo '<h4>ITENS CADASTRADOS</h4>
<table border="1" width="100%">
<tr>
<th>GR. DESPESA</th><th>MATERIAL</th><th>QUANTIDADE</th><th>VALOR UNITARIO(R$)</th><th>VALOR TOTAL(R$)</th><th>EDITAR</th><th>DELETAR</th></tr>';
$valorTotalGeral=0;
while($objMat=mysql_fetch_object($sqlMaterial2)){
	$totalInicial=$objMat->quant*str_replace(",",".",str_replace(".","",$objMat->vlunit));
	$valorTotalGeral+=$totalInicial;
	echo "<tr><td>".$objMat->codigo."<br>".utf8_encode($objMat->descricao)."</td><td>".utf8_encode($objMat->nome)."</td><td>".$objMat->quant."</td><td>R$ ".$objMat->vlunit."</td><td>R$ ".number_format($totalInicial,2,",",".")."</td><td><form action='insereItensLic.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMat->id."'/><input type='submit' name='edit' value='Editar' class='button'/></form></td><td><form action='deleteItemSrp.php' method='post' name='editar'><input type='hidden' name='idatu' value='".$objMat->id."'/><input type='submit' name='edit' value='Deletar' class='button'/></form></td></tr>";
	}
echo "<tr><th align='right' colspan='4'>TOTAL GERAL</th><td><strong>R$ ".number_format($valorTotalGeral,2,",",".")."</strong></td><th colspan='2'></th></tr>";
echo "</table>";
echo "<div id='divResultado' style='height:auto'></div>
<br>
<form action='insereNovoItemLic.php' id='insere' name='insere' method='post' onSubmit=\"setarCampos(this); enviarForm('insereNovoItemLic.php', campos, 'divResultado'); return false;\">
<h4>CADASTRAR ITEM</h4>
<table border='0' width='50%'><tr>
<th width='30%'>Gr. Despesa</th><td>
<select name='grupo' id='grupo' onChange='CarregaMateriais(this.value)'>";
if(!empty($_SESSION['grupoComp'])){
	echo "<option selected='selected' value='".$_SESSION['grupoComp']."'>".$_SESSION['grupoCompDesc']."</option>";
	}else{
		echo "<option selected='selected' value='0'>Selecione</option>";
		}
$SQLGrupo=mysql_query("SELECT * FROM aquigrupo WHERE inativo=0");
while($objGrupo=mysql_fetch_object($SQLGrupo)){
	echo "<option value='".$objGrupo->id."'>".$objGrupo->codigo."-".utf8_encode($objGrupo->descricao)."</option>";	
	}
echo"</select>
</td></tr><tr>
<th width='30%'>Material</th><td>
<input type='hidden' name='idatl' id='idatl' value='' />
<div id='materialAjax'>
      	<select name='material' id='material'>";

if(empty($_SESSION['materialComp'])){
            echo '<option value="">Selecione o Material</option>';
			}else{
				echo '<option value="'.$_SESSION['materialComp'].'">'.$_SESSION['materialCompDesc'].'</option>';
				}
    	echo "</select>
    </div>
</td></tr>
<tr>
<th width='30%'>Quantidade</th><td><input type='text' size='20' name='qtd' id='qtd' class='input' value='".$_SESSION['qtdMat']."'></td>
</tr><tr>
<script type='text/javascript'>
  	  $(document).ready(function(){
      $('#vlunit').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
      });
    });
	</script>
<th width='30%'>Valor Unitário</th><td><input type='text' size='20' name='vlunit' id='vlunit' class='input' value='".$_SESSION['vlunitMat']."'></td>
</tr>
<tr><td width='30%'><a href='novaOrdem.php'><input type='button' name='submit' class='button' value='<<Voltar' /></a></td><td align='right'><input type='submit' name='submit' class='button' value='";
 
if($_SESSION['idatuSession']==0){
	echo 'Incluir';
	}else{
		echo 'Atualizar';
		}
echo "'/></td></tr>
</table>
</form>";
?>