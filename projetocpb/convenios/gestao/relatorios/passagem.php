<?php
$sqlPasEventoNac=mysql_query("SELECT *,convpas.tipo as tipopas FROM convpas LEFT JOIN convpasreferencia ON convpasreferencia.id=convpas.trecho WHERE convpas.idevento='".$idEvento."' AND convpas.abrgpas='nac'") or die(mysql_error());
$countPasEventoNac=mysql_num_rows($sqlPasEventoNac);
  $sqlPasEventoInt=mysql_query("SELECT *,convpas.tipo as tipopas,convpasintreferencia.trecho as trechoint FROM convpas LEFT JOIN convpasintreferencia ON convpasintreferencia.id=convpas.trecho WHERE convpas.idevento='".$idEvento."' AND convpas.abrgpas='int'") or die(mysql_error());
  $countPasEventoInt=mysql_num_rows($sqlPasEventoInt);
if($countPasEventoNac>0 || $countPasEventoInt>0){
echo "<tr bgcolor='#999999'><td colspan='14'><h3 align='center'><font color='white'>PASSAGEM A&Eacute;REA</font></h3></td></tr>
<tr>
    <th width='48%' nowrap='nowrap' colspan='7' valign='bottom'><p align='center'>PROJETADO</p></td>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='48%' nowrap='nowrap' colspan='6' valign='bottom'><p align='center'>REALIZADO</p></th>
  </tr>
  <tr>
    <th width='30%' nowrap='nowrap'><p align='center'><strong>ITINER&Aacute;RIO</strong></p></th>
    <th width='20%' nowrap='nowrap'><p align='center'><strong>ORIGEM</strong></p></th>
    <th width='23%' nowrap='nowrap'><p align='center'><strong>DESTINO</strong></p></th>
    <th width='10%' nowrap='nowrap'><p align='center'><strong>TIPO</strong></p></th>
    <th width='8%' nowrap='nowrap'><p align='center'><strong>PAX</strong></p></th>
    <th width='14%'><p align='center'><strong>CUSTO UNITARIO</strong></p></th>
    <th width='18%' nowrap='nowrap'><p align='center'><strong>CONSOLIDADO </strong></p></th>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='30%' nowrap='nowrap'><p align='center'><strong>ITINER&Aacute;RIO</strong></p></th>
    <th width='20%' nowrap='nowrap'><p align='center'><strong>PAX</strong></p></th>
    <th width='23%'><p align='center'><strong>CUSTO UNITARIO</strong></p></th>
    <th width='10%'><p align='center'><strong>DESCONTO </strong></p></th>
    <th width='8%'><p align='center'><strong>TX DE EMBARQUE</strong></p></th>
    <th width='14%' nowrap='nowrap'><p align='center'><strong>CONSOLIDADO </strong></p></th>
  </tr>";
  $qtdPasNac=0;
  $vltotPasNac=0;
  $countPasEventoNac=mysql_num_rows($sqlPasEventoNac);
  if($countPasEventoNac>0){
  echo "<tr>
    <th width='48%' nowrap='nowrap' colspan='7'><p align='center'><strong>NACIONAL</strong></p></th>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='48%' nowrap='nowrap' colspan='6'><p align='center'><strong>NACIONAL</strong></p></th>
  </tr>";
  while($objPasEvNac=mysql_fetch_object($sqlPasEventoNac)){
  $qtdPasNac=$qtdPasNac+$objPasEvNac->qtd;
  $trecho='';
  $tipo='';
  if($objPasEvNac->tipopas==2){
	  $trecho=$objPasEvNac->origem."/".$objPasEvNac->destino."/".$objPasEvNac->origem;
	  $tipo='Ida e Volta';
	  }else{
		  $trecho=$objPasEvNac->origem."/".$objPasEvNac->destino;
		  $tipo='Ida';
		  }
  echo "<tr>
    <td nowrap='nowrap'><p align='center'><font size='-2'>".utf8_encode($trecho)."</font></p></td>
    <td nowrap='nowrap'><p align='center'><font size='-1'>".utf8_encode($objPasEvNac->origem)."</font></p></td>
    <td nowrap='nowrap'><p align='center'><font size='-1'>".utf8_encode($objPasEvNac->destino)."</font></p></td>
    <td nowrap='nowrap'><p align='center'>".$tipo."</p></td>
    <td nowrap='nowrap'><p align='center'>".$objPasEvNac->qtd."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".$objPasEvNac->valor."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".$objPasEvNac->total."</p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
  </tr>";
  $vltotPasNac=$vltotPasNac+(float)$objPasEvNac->total;
  }
	echo "<tr>
    <th colspan='4' nowrap='nowrap' valign='bottom'><p><strong>TOTAL NACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>".$qtdPasNac."</strong></p></td>
    <th nowrap='nowrap' valign='bottom'><p><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap'><p align='right'><strong>R$ ".number_format($vltotPasNac,2,",",".")."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' valign='bottom'><p><strong>TOTAL NACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <th nowrap='nowrap' colspan='3' valign='bottom'><p><strong>&nbsp;</strong></p></td>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>";
  }
  $qtdPasInt=0;
  $vltotPasInt=0;
  if($countPasEventoInt>0){
  echo "<tr>
    <th width='48%' nowrap='nowrap' colspan='7'><p align='center'><strong>INTERNACIONAL</strong></p></th>
    <th width='2%' nowrap='nowrap' valign='bottom'></th>
    <th width='48%' nowrap='nowrap' colspan='6'><p align='center'><strong>INTERNACIONAL</strong></p></th>
  </tr>";
  while($objPasEvInt=mysql_fetch_object($sqlPasEventoInt)){
  $qtdPasInt=$qtdPasInt+$objPasEvInt->qtd;
  $vltotPasInt=$vltotPasInt+(float)$objPasEvInt->total;
  $tipoI='';
  $arrayTrecho=explode("/",$objPasEvInt->trechoint);
  if($objPasEvInt->tipopas==2){
	  $tipoI='Ida e Volta';
	  $origem=$arrayTrecho[0];
	  $destino=$arrayTrecho[1];
	  }else{
		  $tipoI='Ida';
		  $origem=$arrayTrecho[0];
		  if(!empty($arrayTrecho[2])){
	  	  $destino=$arrayTrecho[2];
		  }else{
			  $destino=$arrayTrecho[1];
			  }
		  }

  echo "<tr>
    <td nowrap='nowrap'><p align='center'>".utf8_encode($objPasEvInt->trechoint)."</p></td>
    <td nowrap='nowrap'><p align='center'>".utf8_encode($origem)."</p></td>
    <td nowrap='nowrap'><p align='center'>".utf8_encode($destino)."</p></td>
    <td nowrap='nowrap'><p align='center'>".$tipoI."</p></td>
    <td nowrap='nowrap'><p align='center'>".$objPasEvInt->qtd."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".$objPasEvInt->valor."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".$objPasEvInt->total."</p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='right'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='right'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
  </tr>";
  }
  
  echo "<tr>
    <th nowrap='nowrap' colspan='4' valign='bottom'><p><strong>TOTAL INTERNACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>".$qtdPasInt."</strong></p></td>
    <th nowrap='nowrap' valign='bottom'><p><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap'><p align='right'><strong>R$ ".number_format($vltotPasInt,2,",",".")."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='3' valign='bottom'><p align='center'><strong>TOTAL INTERNACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <th nowrap='nowrap' valign='bottom'><p align='center'><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>";
  }
  $totalQtdGeralPas=$qtdPasInt+$qtdPasNac;
  $totalGeralValorPas=$vltotPasInt+$vltotPasNac;
  echo "
  <tr><td colspan='14' height='5'></td></tr>
    <tr>
    <th nowrap='nowrap' colspan='4' valign='bottom'><p><strong>TOTAL GERAL PASSAGEM</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>".$totalQtdGeralPas."</strong></p></td>
    <th nowrap='nowrap' valign='bottom'><p><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ ".number_format($totalGeralValorPas,2,",",".")."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='4' valign='bottom'><p align='center'><em>TOTAL GERAL</em></p></th>
    <td nowrap='nowrap' colspan='2' valign='bottom'><p align='center'><strong>R$ </strong></p></td>
  </tr>
  <tr>
    <td nowrap='nowrap' colspan='7' valign='bottom'></td>
     <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='4' valign='bottom'><p align='center'><em>DIFEREN&Ccedil;A</em></p></th>
    <td nowrap='nowrap' colspan='2' valign='bottom'><p align='center'>R$ </p></td>
  </tr>";
}
?>