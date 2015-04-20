<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<style media="print">
.botao {
display: none;
}
</style>
<link href="../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />

<body>
<?php 
// Determina que o arquivo é uma planilha do Excel
   header("Content-type: application/vnd.ms-excel");   

   // Força o download do arquivo
   header("Content-type: application/force-download");  

   // Seta o nome do arquivo
   header("Content-Disposition: attachment; filename=dadosBoardingPass.xls");

   header("Pragma: no-cache");

echo "<table  width='100%'>
<tr>
        <th width='6%'>Data</th><td width='8%' valign='middle'>".date("d/m/Y H:i:s")."</td><th width='30%' colspan='4'><h2>RELATÓRIO DE BOARDING PASS PENDENTES</h2></th>
    </tr>
<tr>
        <th width='6%'>CI / Aut.</th><th width='8%'>Processo</th><th width='30%'>Nome</th><th>Data</th><th width='12%'>Localizador</th><th width='9%'>CIA Aerea</th><th width='9%'>Valor Final</th>
    </tr>";
	require "../conectsqlserverciprod.php";
	require "../conexaomysql.php";
	require "../somarDatas.php";
	$sqlReg=mysql_query("select registros.id,registros.solicitacao, registros.autorizacao, registros.projeto, registros.idben, registros.datainicial, registros.datafinal, registros.localizador, cia.nome ,registros.vltot from registros LEFT JOIN cia ON registros.idcia=cia.id where registros.bdpass=0 ORDER BY registros.idben") or die(mysql_error());
	$countReg=mysql_num_rows($sqlReg);
	if($countReg<1){
		?>
       <script type="text/javascript">
       alert("Nao existe Boarding Pass pendente!");
       window.parent.location.reload();
       </script>
       <?php
		}
	$dt=0;
	$cor='';
	$idbenAnt='';
	$numRegistros=0;
	$count=0;
	while($objReg=mysql_fetch_object($sqlReg)){
		$cor='';
		$numRegistros=0;
		$sqlNome=odbc_exec($conCab,"SELECT Nome_completo FROM GEEMPRES (nolock) WHERE Cd_empresa='".$objReg->idben."'");
		$arrayNome=odbc_fetch_array($sqlNome);
		$sqlProc=odbc_exec($conCab,"select assunto
from GMPROCDOC (nolock) 
where (projeto LIKE '".$objReg->projeto."%')");
		$arrayProc=odbc_fetch_array($sqlProc);
		$dataSomada='';
		  if(!empty($objReg->datafinal)){
			    	if($objReg->datafinal<>'0000-00-00'){ 
					if($objReg->datafinal<>'1969-12-31'){
		$dataSomada=somar_data($objReg->datafinal, 10, 0, 0);
			  }}}
			  if(empty($dataSomada)){
				 $dataSomada=somar_data($objReg->datainicial, 10, 0, 0);
				  }
			if(strtotime(date("Y-m-d")) >= strtotime($dataSomada)){
				$sqlBloqAut=mysql_num_rows(mysql_query("SELECT * FROM prestbloqueados WHERE cdempres='".$objReg->idben."' AND idaut='".$objReg->id."'"));
				if($sqlBloqAut==0){
				$insertIntoBloqueio=mysql_query("INSERT INTO prestbloqueados (cdempres,idaut,status) VALUES ('".$objReg->idben."','".$objReg->id."','1')");
				//insert do cigam
				}
				$numRegistros++;
				$count++;
		   		$cor="bgcolor='yellow'";
				}
		if($idbenAnt==$objReg->idben){
			$tipoPas='VOLTA';
			$dataPassagem=date('d/m/Y',strtotime($objReg->datafinal));
			}else{
				$tipoPas='IDA';
				$dataPassagem=date('d/m/Y',strtotime($objReg->datainicial));
				}
$idbenAnt=$objReg->idben;
					echo "<tr ".$cor."><td>".$objReg->solicitacao."<br>".$objReg->autorizacao."</td><td><span title='".mb_convert_encoding($arrayProc['assunto'],"UTF-8","ISO-8859-1")."'>".$objReg->projeto."</span></td><td>".trim(utf8_encode($arrayNome['Nome_completo']))."</td><td>".$tipoPas.": ".$dataPassagem."</td><td>".$objReg->localizador."</td><td>".$objReg->nome."</td><td>".$objReg->vltot."</td></tr>";
				
		}
    echo "</table>";
?>
</body>
</html>