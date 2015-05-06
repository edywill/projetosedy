<?php 
require ("conexaobd/conectbd.php");
$sqlReports=odbc_exec($conCab,"select report.datetime_2,category_has_report.category_id
FROM report LEFT JOIN category_has_report ON category_has_report.report_id=report.id");
$contador=1;
$jan[]=0;
$fev[]=0;
$mar[]=0;
$abr[]=0;
$dez[]=0;
while($contador<10){
$jan[$contador]=0;
$fev[$contador]=0;
$mar[$contador]=0;
$abr[$contador]=0;
$dez[$contador]=0;
$contador++;
}
while ($objReports=odbc_fetch_object($sqlReports)){
	if(!empty($objReports->datetime_2)){
	$splitData=explode(" ",$objReports->datetime_2);
	$arrayMes=explode("/",$splitData[0]);
	if(!empty($arrayMes[1]) && $objReports->category_id<10){
	switch ($arrayMes[1]){
				case "12":
				$dez[$objReports->category_id]++;
				break;
			
				case "01":
				$jan[$objReports->category_id]++;
				break;
			
				case "02":
				$fev[$objReports->category_id]++;
				break;
			
				case "03":
				$mar[$objReports->category_id]++;
				break;
			
				case "04":
				$abr[$objReports->category_id]++;
				break;
			}
	     }
	  }
	}
$contImp=1;
while($contImp<10){
	echo "Dezembro/14 (".$contImp."): ".$dez[$contImp]."<br>";
	$contImp++;
	}
$contImp=1;
while($contImp<10){
	echo "Janeiro/15 (".$contImp."): ".$jan[$contImp]."<br>";
	$contImp++;
	}
$contImp=1;
while($contImp<10){
	echo "Fevereiro/15 (".$contImp."): ".$fev[$contImp]."<br>";
	$contImp++;
	}	
$contImp=1;
while($contImp<10){
	echo "Março/15 (".$contImp."): ".$mar[$contImp]."<br>";
	$contImp++;
	}
$contImp=1;
while($contImp<10){
	echo "Abril/15 (".$contImp."): ".$abr[$contImp]."<br>";
	$contImp++;
	}	

?>