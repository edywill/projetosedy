<?php
//Inclui a classe.
require_once('phplot.php');

//Define o Objeto da Classe
$graph =& new PHPlot(1024, 500);

//Define quais valores serуo mostrados
$data = array(
     array('Fevereiro 2010'	,0), 
     array('Janeiro 2010'		,0), 
     array('Dezembro 2009'	,31), 
     array('Novembro 2009'	,31), 
     array('Outubro 2009'	,31), 
     array('Setembro 2009'	,31), 
);

$graph->SetImageBorderType('plain');
$graph->SetDataValues($data);
$graph->SetTitle('Registros Mensais'); // seta o nome do grafico
#$graph->SetXGridLabelType("time"); // seta o label no eixo x usa "time", "title", "none", "default" or "data".
$graph->SetXTitle('Mes'); // seta o eixo X e seu nome
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

$graph->DrawGraph(); // gera o grсfico.
?>