<?php
//Inclui a classe.
require_once('phplot/phplot.php');
//Define o Objeto da Classe
$graph =& new PHPlot(862, 500);
//Define quais valores serуo mostrados
$data = array(
     array('AC'	,$_GET['ac']),
	 array('AL'	,$_GET['al']),
	 array('AP'	,$_GET['ap']),
	 array('AM'	,$_GET['am']),
	 array('BA'	,$_GET['ba']),
	 array('CE'	,$_GET['ce']),
	 array('DF'	,$_GET['df']),
	 array('ES'	,$_GET['es']),
	 array('GO'	,$_GET['go']),
	 array('MA'	,$_GET['ma']),
	 array('MT'	,$_GET['mt']),
	 array('MS'	,$_GET['ms']),
	 array('MG'	,$_GET['mg']),
	 array('PA'	,$_GET['pa']),
	 array('PB'	,$_GET['pb']),
	 array('PR'	,$_GET['pr']),
	 array('PE'	,$_GET['pe']),
	 array('PI'	,$_GET['pi']),
	 array('RJ'	,$_GET['rj']),
	 array('RN'	,$_GET['rn']),
	 array('RS'	,$_GET['rs']),
	 array('RO'	,$_GET['ro']),
	 array('RR'	,$_GET['rr']),
	 array('SC'	,$_GET['sc']),
	 array('SP'	,$_GET['sp']),
	 array('SE'	,$_GET['se']),
	 array('TO'	,$_GET['to']),
	 array('IN'	,$_GET['in']),
     
);

$graph->SetImageBorderType('plain');
$graph->SetDataValues($data);
$graph->SetTitle('Registros Estaduais - 2014'); // seta o nome do grafico
#$graph->SetXGridLabelType("time"); // seta o label no eixo x usa "time", "title", "none", "default" or "data".
$graph->SetXTitle('UF'); // seta o eixo X e seu nome
$graph->SetYTitle('Quantidade'); // seta o einxo Y e seu nome
$graph->SetPlotType('bars'); // essa funчуo serve para escolher o tipo do grafico que pode ser: bars, lines, linepoints, area, points e pie.
#$graph->SetLegend('leg'); // gera as legendas do grafico
$graph->SetDataType("text-data"); // nescessario usar esse parametro no grafico com barras
#$graph->SetVertTickIncrement(5); // espaчamento entre os pontos na regua vertical
$graph->SetHorizTickIncrement(1); // espaчamento entre os pontos na regua horizontal
#$graph->SetLegendPixels(0,0,0); // muda a legenda de lugar
$graph->SetFileFormat('GIF'); // cria o arquivo no formato especificado GIF, JPG e PNG
$graph->SetBackgroundColor('#A5BCC2'); // muda a cor de fundo do grafico
#$graph->SetDataColors('green'); // seta as cores utilizads pelo grafico
#$graph->SetPlotAreaWorld(0, null, null, null);

#$teste = array('blue', 'red', 'black');
#$graph->SetRGBArray($teste);

$graph->SetDrawXGrid(True);
$graph->SetDrawYGrid(True);

$graph->DrawGraph();

?>