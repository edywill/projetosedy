<?php 
session_start();
$cor=[ "#6495ED", "#B22222", "#FF1493", "#007ad8","#CC9933","#003366", "#FFFF66", "#99FF99", "#9999CC" ];
$idAtleta=$_SESSION['idAtletaAval'];
$conCab = odbc_connect("DRIVER={SQL Server}; SERVER=10.67.16.103; DATABASE=Atletas;", "sa","abyz.");
$sqlAnoAt=odbc_exec($conCab,"SELECT marcas.ano FROM marcas (nolock) WHERE marcas.atleta_id='".$idAtleta."' GROUP BY marcas.ano ORDER BY marcas.ano");
$nomeAtleta=odbc_fetch_array(odbc_exec($conCab,"SELECT atleta.nome FROM atleta (nolock) WHERE atleta.id=".$idAtleta.""));
$sqlProvas=odbc_exec($conCab,"SELECT DISTINCT prova.nome FROM marcas (nolock) LEFT JOIN prova (nolock) ON marcas.prova_id=prova.id WHERE marcas.atleta_id='".$idAtleta."' GROUP BY prova.nome ORDER BY prova.nome") or die("<p>".odbc_errormsg());
$ano[]=0;
$countAno=0;
while($objAnoAt=odbc_fetch_object($sqlAnoAt)){
	$ano[$countAno]=$objAnoAt->ano;
	$countAno++;
	}
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
// Setup the graph
$graph = new Graph(1024,768);
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('GRÁFICO DE EVOLUÇÃO DO ATLETA: '.utf8_encode($nomeAtleta['nome']).'');
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel(false);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xaxis->SetTickLabels($ano);
$graph->xgrid->SetColor('#E3E3E3');
$prova[]='';
$countProva=0;
$countMarca=0;
while($objProvaAt=odbc_fetch_object($sqlProvas)){
	$prova[$countProva]=utf8_encode($objProvaAt->nome);
	$p1=0;
	$sqlMarcaAtleta=odbc_exec($conCab,"SELECT marcas.marca,marcas.tipo,marcas.ano FROM marcas (nolock) INNER JOIN prova (nolock) ON marcas.prova_id=prova.id WHERE marcas.atleta_id='".$idAtleta."' AND prova.nome='".$objProvaAt->nome."' ORDER BY marcas.ano");
	unset($marcaProva);
	$anoMarca=$countAno;
	$countMarca=0;
	$tipoMarca='';
	for($i=0;$i<($countAno-1);$i++){
		$marcaProva[$i]=0;
		}
	while($objMarca=odbc_fetch_object($sqlMarcaAtleta)){
		$marcador=$countMarca;
		$tipoMarca=trim($objMarca->tipo);
		$marcador=array_search(trim($objMarca->ano), $ano);
		$marcaProva[$marcador]=number_format($objMarca->marca,2,".","");
		$countMarca++;
		}
	$p1 = new LinePlot($marcaProva);
	$graph->Add($p1);
	$p1->SetColor($cor[$countProva]);
	$p1->SetLegend($prova[$countProva]);
	$p1->value->HideZero();
	if($tipoMarca=='m'){
		$p1->value->SetFormatCallback('metrosValueFormat'); 
	}elseif($tipoMarca=='t'){
		$p1->value->SetFormatCallback('tempoValueFormat');
		}
	$p1->value->SetColor($cor[$countProva],"black");
	$p1->value->Show();
	$countProva++;
	}
	$graph->legend->SetFrameWeight(1);
    $graph->legend->SetColumns(2);
	$graph->legend->SetPos(0.5,0.98,'center','bottom');
// Output line
$graph->Stroke();
	
	function metrosValueFormat($aLabel) { 
    // Format '1000 english style 
    	//return number_format($aLabel) 
    // Format '1000 french style 
       return number_format($aLabel, 2, '.', ' '); 
	}
	function tempoValueFormat($bLabel) { 
    // Format '1000 english style 
    	//return number_format($aLabel) 
    // Format '1000 french style 
       		$marcaAtleta=number_format($bLabel,0,"","");
			$marcaAtletaArr=str_split(str_pad($marcaAtleta, 8, "0", STR_PAD_LEFT), 2);
			$bLabel=$marcaAtletaArr[0].":".$marcaAtletaArr[1].":".$marcaAtletaArr[2].".".$marcaAtletaArr[3];
	   return $bLabel; 
	}
?>