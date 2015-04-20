<?php 
echo "<form action='alimentacao/aliNovo.php' method='post' name='formcad'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='submit' class='button' value='Nova Solicitacao' name='evento'/>
</form>";

echo "<h3>Lista de Solicitações de Alimentação</h3>";
$sqlAli=mysql_query("SELECT convali.*,convali.id AS idali FROM convali WHERE convali.idproj='".trim($id)."' AND convali.modal='".$tipoId."' AND convali.idevento='".$idEvento."'") or die(mysql_error());
echo "<div id='tabela'><table border='1' width='100%'>
<tr><th width='20%'>Cidade/Abrang</th><th width='8%'>Qtd Dias/ Qtd Pessoas</th><th width='20%'>Tipo Refeição</th><th width='11%'>Valor Unit. (R$)</th><th width='19%'>Qtd. Ref./Valor Total(R$)</th><th width='15%'>A&ccedil;&otilde;es.</th></tr>";
$tipo='';
$vlUnit='';
$vlTotAli=0;
$count=0;
while($objAli=mysql_fetch_object($sqlAli)){
	$tipo='';
   $vlUnit='';
	if($objAli->jan<>0){
		$tipo.="Jantar (1º dia)<br>";
		//$vlUnit.= ."<br>";
		}
		
	if($objAli->alm<>0){
		$tipo.="Almoço (Último dia)<br>";
		//$vlUnit.= $objAli->vlalm."<br>";
		}
		
	if($objAli->ambos<>0){
		$tipo.="Almoço/Jantar";
		//$vlUnit.= $objAli->vlamb;
		}
	if($objAli->abrg=='nac'){
		$abrg='NACIONAL';
		$sqlCidadeUf=mysql_fetch_array(mysql_query("SELECT municipio FROM municipios WHERE id='".$objAli->local."'"));
		$local=utf8_encode($sqlCidadeUf['municipio']);
		}else{
			$abrg='INTERNACIONAL';
			$local=$objAli->local;
			}
	$qtdDias=$objAli->qtddias;
	$qtdPes=$objAli->qtdpes;
	echo "<tr><td width='15%'><font size='-1'>".utf8_encode($local)." / ".$abrg."</font></td><td width='20%'>".$qtdDias."/".$qtdPes."</td><td width='15%'>".$tipo."</td><td width='15%'>".$vlUnit."</td><td width='15%'>".$objAli->qtdref." / ".$objAli->total."</td><td width='25%'>
<table border='0'><tr border='0'><td>
<form action='alimentacao/editAli.php' name='formProjConv' method='post'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' name='idAli' value='".$objAli->idali."'/>
<input type='submit' name='edit' value='Editar' class='button'/>
</form>
</td><td>
<form action='alimentacao/deletarAli.php' name='formProjConv' method='post'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='idproj'/>
<input type='hidden' value='".$idEvento."' name='idEvento'/>
<input type='hidden' value='".$titMod."' name='titMod'/>
<input type='hidden' name='idAli' value='".$objAli->idali."'/>
<input type='submit' name='delete' value='Deletar' class='button'/>
</form></td></tr></table></td></tr>";
	$vlTotAli=$vlTotAli+str_replace(",",".",str_replace(".","",$objAli->total));
	}
echo "<tr><th colspan='4' align='right'>Valor Global(R$)</th><td colspan='2'><strong>".number_format($vlTotAli,2,",",".")."</strong></td></tr>";
echo "</table></div>";
?>
</div>
</body>
</html>