<?php
session_start();
require "../../conectsqlserver.php";
require "../../sav/conectsqlserversav.php";
require "../../conect.php";
$numSav=$_GET['id'];
echo '<table border="1" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    <td valign="top" align="center"></td>
    <th valign="top" align="center"><strong>Data</strong></th>
    <th valign="top" align="center"><strong>Trecho</strong></th>
    <th valign="top" align="center"><strong>Horário</strong></th>
  </tr>';
  $sqlPassagemImp=mysql_query("SELECT * FROM savpassagem WHERE idsav='".$numSav."'");
  $countPassagemImp=mysql_num_rows($sqlPassagemImp);
  $countPassagemImpContador=0;
  while($objPassagemImp=mysql_fetch_object($sqlPassagemImp)){ 
	  if($objPassagemImp->inter<>'itn'){
				  $sqlTrechoNacImpIda=mysql_fetch_array(mysql_query("SELECT municipio,uf FROM municipios WHERE id='".$objPassagemImp->origem."'"));
				  $sqlTrechoNacImpVolta=mysql_fetch_array(mysql_query("SELECT municipio,uf FROM municipios WHERE id='".$objPassagemImp->destino."'"));
				  $idaImpressao=$sqlTrechoNacImpIda['municipio']."(".$sqlTrechoNacImpIda['uf'].")";
				  $voltaImpressao=$sqlTrechoNacImpVolta['municipio']."(".$sqlTrechoNacImpVolta['uf'].")";
				  }else{
					  $idaImpressao=$objPassagemImp->cidorigem."(".$objPassagemImp->origem.")";
				  	  $voltaImpressao=$objPassagemImp->ciddestino."(".$objPassagemImp->destino.")";
					  }
		$horarioViagem='';
		
	  $countPassagemImpContador++;
	  if($objPassagemImp->tipo==1){
		  if($objPassagemImp->horarioida=='manha'){
			  $horarioViagem='Manhã (4h-12h)';
			  }elseif($objPassagemImp->horarioida=='tarde'){
			  			$horarioViagem='Tarde (12h01-18h)';
			  }elseif($objPassagemImp->horarioida=='noite'){
			  			$horarioViagem='Noite (18h01-3h59)';
			  }
		  
		  if($countPassagemImpContador<$countPassagemImp || ($countPassagemImp==1 && $objPassagemImp->tipo==1)){
		  echo " <tr>
    			<td ><strong>IDA</strong></td>
    			<td align='center'>".$objPassagemImp->dtida."</td>
    			<td align='center'>".utf8_encode($idaImpressao)." x ".utf8_encode($voltaImpressao)."</td>
    			<td align='center'>".$horarioViagem."</td>
  				</tr>";
		  }else{
			echo " <tr>
    			<td ><strong>VOLTA</strong></td>
    			<td align='center'>".$objPassagemImp->dtida."</td>
    			<td align='center'>".utf8_encode($idaImpressao)." x ".utf8_encode($voltaImpressao)."</td>
    			<td align='center'>".$horarioViagem."</td>
  				</tr>";
			}
	 	}else{
			for($i=0;$i<=1;$i++){
			   if($i==0){
			   if($objPassagemImp->horarioida=='manha'){
			  $horarioViagem='Manhã (4h-12h)';
			  }elseif($objPassagemImp->horarioida=='tarde'){
			  			$horarioViagem='Tarde (12h01-18h)';
			  }elseif($objPassagemImp->horarioida=='noite'){
			  			$horarioViagem='Noite (18h01-3h59)';
			  }
			   echo " <tr>
    			<td ><strong>IDA</strong></td>
    			<td align='center'>".$objPassagemImp->dtida."</td>
    			<td align='center'>".utf8_encode($idaImpressao)." x ".utf8_encode($voltaImpressao)."</td>
    			<td align='center'>".$horarioViagem."</td>
  				</tr>";
			   }else{
				  if($objPassagemImp->horariovolta=='manha'){
			  $horarioViagem='Manhã (4h-12h)';
			  }elseif($objPassagemImp->horariovolta=='tarde'){
			  			$horarioViagem='Tarde (12h01-18h)';
			  }elseif($objPassagemImp->horariovolta=='noite'){
			  			$horarioViagem='Noite (18h01-3h59)';
			  }
				  echo " <tr>
    			<td ><strong>VOLTA</strong></td>
    			<td align='center'>".$objPassagemImp->dtvolta."</td>
    			<td align='center'>".utf8_encode($voltaImpressao)." x ".utf8_encode($idaImpressao)."</td>
    			<td align='center'>".$horarioViagem."</td>
  				</tr>";
				   }
			   }
			}
	  }
echo "</table>";
?>