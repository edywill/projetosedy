<?php 
// content="text/plain; charset=utf-8"
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_bar.php');

$data1y=array($_GET['ac'],
$_GET['al'],
$_GET['ap'],
$_GET['am'],
$_GET['ba'],
$_GET['ce'],
$_GET['df'],
$_GET['es'],
$_GET['go'],
$_GET['ma'],
$_GET['mt'],
$_GET['ms'],
$_GET['mg'],
$_GET['pa'],
$_GET['pb'],
$_GET['pr'],
$_GET['pe'],
$_GET['pi'],
$_GET['rj'],
$_GET['rn'],
$_GET['rs'],
$_GET['ro'],
$_GET['rr'],
$_GET['sc'],
$_GET['sp'],
$_GET['se'],
$_GET['to'],
$_GET['in']);

// Create the graph. These two calls are always required
$graph = new Graph(862,500,'auto');
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);

//$graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
$graph->SetBox(false);

$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(
array('AC',
'AL',
'AP',
'AM',
'BA',
'CE',
'DF',
'ES',
'GO',
'MA',
'MT',
'MS',
'MG',
'PA',
'PB',
'PR',
'PE',
'PI',
'RJ',
'RN',
'RS',
'RO',
'RR',
'SC',
'SP',
'SE',
'TO',
'IN'));
$graph->yaxis->HideLine(false);
//$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$b1plot = new BarPlot($data1y);

// Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot));
// ...and add it to the graPH
$graph->Add($gbplot);


$b1plot->SetColor("white");
$b1plot->SetFillColor("#4fd58b");

$graph->yaxis->title->Set("Quantidade");

// Display the graph
$graph->Stroke();
?>