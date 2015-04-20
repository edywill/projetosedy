<?php
function pegaCotacao($moeda){	
	$link = "http://download.finance.yahoo.com/d/quotes.csv?s=".$moeda."BRL=X&f=sl1d1t1ba&e=.csv"; //link para pegar a cotacao no formato CSv
	
	if (@fopen($link,"r")) { // abre o arquivo CSV
	  $arq = file($link);
	}
   
		if (is_array($arq)) { // Se o arquivo retornar um array continua
	
		   for ($x=0;$x<count($arq);$x++) { // Passa por todas as chaves do array
		   
			  $linha = explode(",",$arq[$x]); // Separa os valores do arquivo CSV
			  
			  $result['cotacao']  = $linha[1]; // Pega o valor que o Yahoo usa para fazer a conversao
			  $result['data'] = str_replace('"','',$linha[2]); // Retira as aspas da data
			  $result['data'] = date('F d Y',strtotime($result['data']));
			 
			  $result['hora'] = str_replace('"','',$linha[3]); // Retira as aspas do horario da cotacao
			  $result['bid']  = $linha[4]; // Pega o valor de compra da moeda
			  $result['ask']  = $linha[5]; // Pega o valor de venda da moeda
		   }
		}
	
		else{ // Se o arquivo nao retornar nenhum array
		
			$result['cotacao'] = "N/A"; // Define not avaiable para os campos
			$result['data'] = "N/A";
			$result['hora'] = "N/A";
			$result['bid']  = "N/A";
			$result['ask']  = "N/A";
		}
return result;
}
?>