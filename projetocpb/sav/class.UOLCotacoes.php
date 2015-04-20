<?php
/*
   class.uolCotacoes.php - classe usada para extrair as cotações de moedas 
   do dia junto ao site de Economia da UOL - economia.uol.com.br/cotacoes/

   Autor: Fábio Berbert de Paula <fberbert@gmail.com>
   http://www.vivaolinux.com.br/~fabio

   17/01/2013
   Versão: 1.0
*/

class UOLCotacoes {

	public function pegaValores() {

		// o fopen também funciona para arquivos da rede, uau!
		if(!$fp=fopen("http://economia.uol.com.br/cotacoes/" ,"r" )) { 
			echo "Erro ao abrir a página de cotação" ; 
			return(0);
		} 

		//variáveis de classe
		$arrayValores = array();

		//inicio do processamento - ler página
		$uolHTML = "";
		while(!feof($fp)) { // leia o conteúdo da página, uma linha por vez, armazene na variável uolHTML
			$uolHTML .= fgets($fp); 
		}
		fclose($fp);

		/* o bloco do código HTML referente a cotação é assim:

		<td class="pg-color4"><a href="http://economia.uol.com.br/cotacoes/cambio/dolar-comercial-estados-unidos/">Dólar com.</a></td>
		<td>2,0435</td>
		<td>2,0442</td>

		Então o que farei é extrair os valores 2,0435 (compra) e 2,0442 (venda)
		O mesmo conceito se repete para as demais cotações
		*/

		//array contendo as expressoes regulares que indicam cada moeda
		$patterns = array(
			"dolarComercial" => "/pg-color4.*dolar-comercial-estados-unidos/",
			"dolarTurismo"   => "/pg-color4.*dolar-turismo-estados-unidos/",
			"euro"  => "/pg-color4.*euro-uniao-europeia/",
			"libra" => "/pg-color4.*libra-esterlina/",
			"pesos" => "/pg-color4.*peso-argentina/",
		);


		$uolHTML = preg_replace("/.*div id=.cambio.>/", "", $uolHTML); 
		$uolHTML = preg_replace("/<tr>/", "\n<tr>", $uolHTML); //acrescentar quebra de linha
		$uolHTML = preg_replace("/<td/", "\n<td", $uolHTML); //acrescentar quebra de linha

		$arrayHTML = explode("\n", $uolHTML);


		//loop para cada moeda
		while( list($moeda, $pattern) = each($patterns) ) {

			$arrayHTML = explode("\n", $uolHTML);

			//loop por cada linha da pagina HTML
			while ( list($indice, $linha) = each($arrayHTML) ) {

				//se bloco HTML casa com a pattern da moeda do looping atual...
				if (preg_match($pattern, $linha)) {

					//print "Encontrei '$pattern' em: $linha\n\n";

					//ler proxima linha
					$linha = $arrayHTML[++$indice]; 

					//pegar cotacao compra
					preg_match("/<td>(.*)<\/td>/", $linha, $valor);
					$compra = $valor[1];

					//ler proxima linha
					$linha = $arrayHTML[++$indice]; 

					//pegar cotacao venda
					preg_match("/<td>(.*)<\/td>/", $linha, $valor);
					$venda = $valor[1];

					//atribuindo valores ao array de retorno
					array_push($arrayValores, $compra, $venda);
				}

			} // fim while

		} // fim while

		return($arrayValores);

	} //fim function pegaValores

} //fim classe
?> 

