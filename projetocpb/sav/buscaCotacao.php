<?php 
//session_start();
$json_str = file_get_contents( "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22USDBRL%22)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=" );
$data = json_decode($json_str,true);
$_SESSION['cotacaoDiaSav']=str_replace(".",",",$data['query']['results']['rate']['Rate']);
$_SESSION['cotacaoDataSav']=date("d/m/Y",strtotime($data['query']['results']['rate']['Date']))."-".$data['query']['results']['rate']['Time'];
?>