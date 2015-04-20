<?php 
session_start();
$cor=[ "#6495ED", "#B22222", "#FF1493", "#007ad8" ];
$idAtleta=1;
$conCab = odbc_connect("DRIVER={SQL Server}; SERVER=CPB174\SQLEXPRESS; DATABASE=Atletas;", "sa","cigam");
$sqlAnoAt=odbc_exec($conCab,"SELECT marcas.ano FROM marcas (nolock) WHERE marcas.atleta_id='".$idAtleta."' GROUP BY marcas.ano ORDER BY marcas.ano");
$nomeAtleta=odbc_fetch_array(odbc_exec($conCab,"SELECT atleta.nome FROM atleta (nolock) WHERE atleta.id=".$idAtleta.""));
$sqlProvas=odbc_exec($conCab,"SELECT DISTINCT prova.nome FROM marcas (nolock) LEFT JOIN prova (nolock) ON marcas.prova_id=prova.id WHERE marcas.atleta_id='".$idAtleta."' GROUP BY prova.nome ORDER BY prova.nome") or die("<p>".odbc_errormsg());
$ano[]=0;
$countAno=0;
while($objAnoAt=odbc_fetch_object($sqlAnoAt)){
	$ano[$countAno]=$objAnoAt->ano;
	$countAno++;
	}
$prova[]='';
$countProva=0;
$countMarca=0;
while($objProvaAt=odbc_fetch_object($sqlProvas)){
	$prova[$countProva]=utf8_encode($objProvaAt->nome);
	$sqlMarcaAtleta=odbc_exec($conCab,"SELECT marcas.marca,marcas.tipo,marcas.ano,prova.nome FROM marcas (nolock) INNER JOIN prova (nolock) ON marcas.prova_id=prova.id WHERE marcas.atleta_id='".$idAtleta."' AND prova.nome='".$prova[$countProva]."' ORDER BY marcas.ano");
	$countMarca=0;
	$tipoMarca='';
	for($i=0;$i<$countAno;$i++){
		$marcaProva[$i]=0;
		}
	while($objMarca=odbc_fetch_object($sqlMarcaAtleta)){
		$tipoMarca=trim($objMarca->tipo);
		$marcador=array_search(trim($objMarca->ano), $ano);
		$marcaProva[$marcador]=number_format($objMarca->marca,2,".","");
		$countMarca++;
		}
	print_r($marcaProva);
	$countProva++;
	}
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