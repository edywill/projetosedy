<?php
  $sqlAliEvento=mysql_query("SELECT * FROM convali LEFT JOIN convalireferencia ON convali.idref=convalireferencia.id WHERE convali.idevento='".$idEvento."'") or die(mysql_error());
  $countAliEvento=mysql_num_rows($sqlAliEvento);
if($countAliEvento>0){
echo "<tr bgcolor='#999999'><td colspan='14'><h3 align='center'><font color='white'>ALIMENTA&Ccedil;&Atilde;O</font></h3></td></tr>
<tr>
    <th width='48%' nowrap='nowrap' colspan='7' valign='bottom'><p align='center'>PROJETADO</p></td>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='48%' nowrap='nowrap' colspan='6' valign='bottom'><p align='center'>REALIZADO</p></th>
  </tr>
  <tr>
    <th width='30%' nowrap='nowrap'><p align='center'><strong>TIPO</strong></p></th>
    <th width='20%' colspan='2' nowrap='nowrap'><p align='center'><strong>LOCAL</strong></p></th>
    <th width='23%' nowrap='nowrap'><p align='center'><strong>QUANTIDADE</strong></p></th>
    <th width='8%' nowrap='nowrap'><p align='center'><strong>PAX</strong></p></th>
    <th width='14%'><p align='center'><strong>DI&Aacute;RIA</strong></p></th>
    <th width='18%' nowrap='nowrap'><p align='center'><strong>CONSOLIDADO </strong></p></th>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='20%' colspan='2' nowrap='nowrap'><p align='center'><strong>LOCAL</strong></p></th>
    <th width='23%' nowrap='nowrap'><p align='center'><strong>QUANTIDADE</strong></p></th>
    <th width='8%' nowrap='nowrap'><p align='center'><strong>PAX</strong></p></th>
    <th width='14%'><p align='center'><strong>DI&Aacute;RIA</strong></p></th>
    <th width='18%' nowrap='nowrap'><p align='center'><strong>CONSOLIDADO </strong></p></th>
  </tr>
  ";
  $qtdAliNac=0;
  $vltotAliNac=0;
  $qtdAliInt=0;
  $vltotAliInt=0;
  $nacionalAli="<tr>
    <th width='48%' nowrap='nowrap' colspan='7'><p align='center'><strong>NACIONAL</strong></p></th>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='48%' nowrap='nowrap' colspan='6'><p align='center'><strong>NACIONAL</strong></p></th>
  </tr>";
  $interNacionalAli="<tr>
    <th width='48%' nowrap='nowrap' colspan='7'><p align='center'><strong>INTERNACIONAL</strong></p></th>
    <td width='2%' nowrap='nowrap' valign='bottom'></td>
    <th width='48%' nowrap='nowrap' colspan='6'><p align='center'><strong>INTERNACIONAL</strong></p></th>
  </tr>";
  while($objAliEv=mysql_fetch_object($sqlAliEvento)){
  $tipo="";
  $vlDiaAli=0;
	  if($objAliEv->jan==1){
			  $tipo.="Jantar 1&ordm; dia<br>";
			  $vlDiaAli=$vlDiaAli+(float)$objAliEv->vljant;
			  }
		   if($objAliEv->alm==1){
			   $tipo.="Almo&ccedil;o &Uacute;ltimo dia<br>";
			   $vlDiaAli=$vlDiaAli+(float)$objAliEv->vlalm;
			   }
			 if($objAliEv->ambos==1){
			 $tipo.="Almo&ccedil;o/Jantar";
			 $vlDiaAli=$vlDiaAli+(float)$objAliEv->vlamb;
			 }
	  if($objAliEv->abrg=='nac'){
  $nacionalAli.="<tr>
    <td nowrap='nowrap'><p align='center'><font size='-2'>".utf8_encode($tipo)."</font></p></td>
    <td nowrap='nowrap' colspan='2'><p align='center'><font size='-1'>".utf8_encode($objAliEv->local)."</font></p></td>
    <td nowrap='nowrap'><p align='center'>".$objAliEv->qtdref."</p></td>
    <td nowrap='nowrap'><p align='center'>".$objAliEv->qtdpes."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".number_format($vlDiaAli,2,",",".")."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".$objAliEv->total."</p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <td nowrap='nowrap' colspan='2'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
  </tr>";
  $qtdAliNac=$qtdAliNac+$objAliEv->qtdref;
  $vltotAliNac=$vltotAliNac+(float)$objAliEv->total;
		}elseif($objAliEv->abrg=='int'){
			$interNacionalAli.="<tr>
    <td nowrap='nowrap'><p align='center'>".$tipo."</p></td>
	<td nowrap='nowrap' colspan='2'><p align='center'><font size='-1'>".utf8_encode($objAliEv->local)."</font></p></td>
    <td nowrap='nowrap'><p align='center'>".$objAliEv->qtdref."</p></td>
    <td nowrap='nowrap'><p align='center'>".$objAliEv->qtdpes."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".number_format($vlDiaAli,2,",",".")."</p></td>
    <td nowrap='nowrap'><p align='right'>R$ ".$objAliEv->total."</p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <td nowrap='nowrap' colspan='2'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
    <td nowrap='nowrap'><p align='center'>&nbsp;</p></td>
  </tr>";
  $qtdAliInt=$qtdAliInt+$objAliEv->qtdref;
  $vltotAliInt=$vltotAliInt+(float)$objAliEv->total;
			}
  }
	$nacionalAli.="<tr>
    <th colspan='3' nowrap='nowrap' valign='bottom'><p><strong>TOTAL NACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>".$qtdAliNac."</strong></p></td>
    <th nowrap='nowrap' valign='bottom'><p><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' colspan='2'><p align='right'><strong>R$ ".number_format($vltotAliNac,2,",",".")."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p><strong>TOTAL NACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p><strong>&nbsp;</strong></p></td>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>";
    $interNacionalAli.="<tr>
    <th nowrap='nowrap'  colspan='3' valign='bottom'><p><strong>TOTAL INTERNACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>".$qtdAliInt."</strong></p></td>
    <th nowrap='nowrap' valign='bottom'><p><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap'  colspan='2'><p align='right'><strong>R$ ".number_format($vltotAliInt,2,",",".")."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p align='center'><strong>TOTAL INTERNACIONAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <th nowrap='nowrap' valign='bottom' colspan='2'><p align='center'><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>";
  $totalQtdGeralAli=$qtdAliInt+$qtdAliNac;
  $totalGeralValorAli=$vltotAliInt+$vltotAliNac;
  if($totalQtdGeralAli>0){
	  if($qtdAliNac>0){
		  echo $nacionalAli;
		  }
	   if($qtdAliInt>0){
		   echo $interNacionalAli;
		   }
  echo "
  <tr><td colspan='14' height='5'></td></tr>
    <tr>
    <th nowrap='nowrap' colspan='3' valign='bottom'><p><strong>TOTAL GERAL ALIMENTA&Ccedil;&Atilde;O</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>".$totalQtdGeralAli."</strong></p></td>
    <th nowrap='nowrap' valign='bottom'><p><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' colspan='2' valign='bottom'><p align='right'><strong>R$ ".number_format($totalGeralValorAli,2,",",".")."</strong></p></td>
    <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p align='center'><strong>TOTAL GERAL</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <th nowrap='nowrap' valign='bottom' colspan='2'><p align='center'><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>
  <tr>
    <td nowrap='nowrap' colspan='7' valign='bottom'></td>
     <td nowrap='nowrap' valign='bottom'></td>
    <th nowrap='nowrap' colspan='2' valign='bottom'><p align='center'><strong>DIFEREN&Ccedil;A</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='center'><strong>0</strong></p></td>
    <th nowrap='nowrap' valign='bottom' colspan='2'><p align='center'><strong>&nbsp;</strong></p></th>
    <td nowrap='nowrap' valign='bottom'><p align='right'><strong>R$ 0,00</strong></p></td>
  </tr>";
  }
}
?>