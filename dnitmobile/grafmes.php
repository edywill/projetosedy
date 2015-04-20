<?php 
// content="text/plain; charset=utf-8"
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_bar.php');

$data1y=array($_GET['jan'],$_GET['fev'],$_GET['mar'],$_GET['abr'],$_GET['mai'],$_GET['jun'],$_GET['jul'],$_GET['ago'],$_GET['set'],$_GET['out'],$_GET['nov'],$_GET['dez']);

// Create the graph. These two calls are always required
$graph = new Graph(862,500,'auto');
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);

//$graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
$graph->SetBox(false);

$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(array('Janeiro','Fevereiro','Marco','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'));
$graph->yaxis->HideLine(false);
//$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$b1plot = new BarPlot($data1y);

// Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot));
// ...and add it to the graPH
$graph->Add($gbplot);


$b1plot->SetColor("white");
$b1plot->SetFillColor("#cc1111");

$graph->yaxis->title->Set("Quantidade");

// Display the graph
$graph->Stroke();
?>