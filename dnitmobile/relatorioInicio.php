<?php 
require ("conexaobd/conectbd.php");
$sqlReports=odbc_exec($conCab,"select report.datetime_2
FROM report");
$dez14=0;
$jan15=0;
$fev15=0;
$mar15=0;
$abr15=0;
while ($objReports=odbc_fetch_object($sqlReports)){
	if(!empty($objReports->datetime_2)){
	$splitData=explode(" ",$objReports->datetime_2);
	$arrayMes=explode("/",$splitData[0]);
	if(!empty($arrayMes[1])){
	switch ($arrayMes[1]){
			case "12":
			$dez14++;
			switch ($arrayMes[1]){
				case "12":
				$dez14++;
				break;
			
				case "01":
				$jan15++;
				break;
			
				case "02":
				$fev15++;
				break;
			
				case "03":
				$mar15++;
				break;
			
				case "04":
				$abr15++;
				break;
			}
			break;
			
			case "01":
			$jan15++;
			break;
			
			case "02":
			$fev15++;
			break;
			
			case "03":
			$mar15++;
			break;
			
			case "04":
			$abr15++;
			break;
			}
	     }
	  }
	}

echo "Dezembro/14: ".$dez14."<br>";
echo "Janeiro/15: ".$jan15."<br>";
echo "Fevereiro/15: ".$fev15."<br>";
echo "Março/15: ".$mar15."<br>";
echo "Abril/15: ".$abr15."<br>";
?>