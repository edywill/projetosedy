<?php 
echo "<form action='hospedagem/hosNovo.php' method='post' name='formcad'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='submit' class='button' value='Nova Solicitacao' name='evento'/>
</form>";

echo "<h3>Lista de Solicitações</h3>";
$sqlHos=mysql_query("SELECT convhos.*,convhos.id AS idhos FROM convhos WHERE convhos.idproj='".trim($id)."' AND convhos.modal='".$tipoId."' AND convhos.idevento='".$idEvento."'") or die(mysql_error());
echo "<div id='tabela'><table border='1' width='100%'>
<tr><th width='20%'>Cidade</th><th width='15%'>Tipo / Abrang.</th><th width='10%'>Qtd Dias/Qtd Pessoas</th><th width='15%'>Vl.Unit.Single(R$)-Qtd</th><th width='15%'>Vl.Unit.Duplo R$-Qtd</th><th width='15%'>Total(R$)</th><th width='15%'>A&ccedil;&otilde;es.</th></tr>";
$tipo='';
$vlTotHos=0;
$count=0;
while($objHos=mysql_fetch_object($sqlHos)){
	if(!empty($objHos->qtdduplo) && !empty($objHos->qtdsingle)){
		$tipo='Single - Duplo';
		}elseif(!empty($objHos->qtdduplo)){
			$tipo='Duplo';
			}else{
				$tipo='Single';
				}
	$local='';
	$vlS=$objHos->vlunits;
	$vlD=$objHos->vlunitd;
	$abrangencia=$objHos->abrg;
	if($objHos->abrg=='nac'){
		$abrangencia="Nacional";
		$sqlCidadeGeral=mysql_fetch_array(mysql_query("SELECT municipio FROM municipios WHERE id='".$objHos->local."'"));
		$local=$sqlCidadeGeral['municipio'];
		}else{
			$abrangencia="Internacional";
			$local=$objHos->local;
			}
	
	echo "<tr><td width='15%'><font size='-1'>".utf8_encode($local)."</font></td><td width='20%'>".$tipo."/".$abrangencia."</td><td width='15%'>".$objHos->qtdpes."/".$objHos->qtddias."</td><td width='15%'>".$vlS." x ".$objHos->qtdsingle."</td><td width='15%'>".$vlD." x ".$objHos->qtdduplo."</td><td width='15%'>".$objHos->total."</td><td width='25%'>
<table border='0'><tr border='0'><td>
<form action='hospedagem/editHos.php' name='formProjConv' method='post'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' name='idHos' value='".$objHos->idhos."'/>
<input type='submit' name='edit' value='Editar' class='button'/>
</form>
</td><td>
<form action='hospedagem/deletarHos.php' name='formProjConv' method='post'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='idproj'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' name='idHos' value='".$objHos->idhos."'/>
<input type='submit' name='delete' value='Deletar' class='button'/>
</form></td></tr></table></td></tr>";
	$vlTotHos=$vlTotHos+str_replace(",",".",str_replace(".","",$objHos->total));
	}
echo "<tr><th colspan='4' align='right'>Valor Global(R$)</th><td colspan='2'><strong>".number_format($vlTotHos,2,",",".")."</strong></td></tr>";
echo "</table></div>";
?>
</div>
</body>
</html>