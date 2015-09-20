<?php
session_start();
require "../../conectsqlserver.php";
require "../../sav/conectsqlserversav.php";
require "../../conect.php";
$numSav=$_GET['id'];
  $sqlPassagemImp=mysql_query("SELECT savpassagem.*,savregistros.numci,savregistros.funcionario FROM savpassagem LEFT JOIN savregistros ON savpassagem.idsav=savregistros.id WHERE savpassagem.idsav='".$numSav."'");
  $countPassagemImp=mysql_num_rows($sqlPassagemImp);
  if($countPassagemImp>0){
echo '<strong>Deslocamento</strong>
<div id="tabela">
<table border="1" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    <td valign="top" align="center" width="10%"></td>
    <th valign="top" align="center" width="20%"><strong>Data/Trecho</strong></th>
    <th valign="top" align="center"><strong>Horário</strong></th>
	<th valign="top" align="center"><strong>Localizador</strong></th>
	<th valign="top" align="center"><strong>Vôo</strong></th>
	<th valign="top" align="center"><strong>Cia. Aérea</strong></th>
  </tr>';
  $countPassagemImpContador=0;
  $cont=0;
  $idPassagemAut=0;
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
		$localizador='';
		$sqlBloqUser=odbc_fetch_array(odbc_exec($conCab2,"select GEEMXRHP.Cd_empresa from GEEMXRHP (NOLOCK) WHERE GEEMXRHP.Cd_pessoa='".$objPassagemImp->funcionario."'"));
	  $benef=$sqlBloqUser['Cd_empresa'];
	  $countPassagemImpContador++;
	  if($objPassagemImp->tipo==1){
		  if($countPassagemImpContador<$countPassagemImp || ($countPassagemImp==1 && $objPassagemImp->tipo==1)){
			  $queryDadosPassagem=mysql_query("SELECT prestsavvoo.*,cia.id AS idcia, cia.nome AS nomecia FROM prestsavvoo LEFT JOIN cia ON cia.id=prestsavvoo.cia WHERE prestsavvoo.idpass='".$objPassagemImp->id."' ORDER BY prestsavvoo.id ASC");
			  $sqlDadosPassagem=mysql_fetch_array($queryDadosPassagem);
			  $queryAut=mysql_query("SELECT registros.localizador,registros.id AS idreg,cia.nome,cia.id AS idcia FROM registros LEFT JOIN cia ON registros.idcia=cia.id WHERE registros.solicitacao='".$objPassagemImp->numci."' AND registros.idben='".$benef."' AND registros.id<>'".$idPassagemAut."' ORDER BY registros.id ASC") or die(mysql_error());
		$buscaAutorizacao=mysql_fetch_array($queryAut);
		$idPassagemAut=$buscaAutorizacao['idreg'];
		if(!empty($sqlDadosPassagem['loc'])){
			$localizador=$sqlDadosPassagem['loc'];
			}else{
				$localizador=$buscaAutorizacao['localizador'];
				};
		if(!empty($sqlDadosPassagem['cia'])){
			$cia=$sqlDadosPassagem['cia'];
			$nomeCia=$sqlDadosPassagem['nomecia'];
			}else{
				$cia=$buscaAutorizacao['idcia'];
				$nomeCia=$buscaAutorizacao['nome'];
				};
				if(empty($cia)){
					$cia=0;
					}
		  echo " <tr>
    			<td ><strong>IDA</strong></td>
    			<td align='center'><font size='-2'>".$objPassagemImp->dtida."<br>".utf8_encode($idaImpressao)." x ".utf8_encode($voltaImpressao)."</font></td>
    			<td align='center'><input type='hidden' size='8' class='input' name='idpas".$cont."' value='".$objPassagemImp->id."'/><input type='time' size='8' class='input' name='hora".$cont."' value='".$sqlDadosPassagem['horario']."'/></td>
				<td align='center'><input type='text' size='8' class='input' name='loc".$cont."' value='".$localizador."'/></td>
				<td align='center'><input type='text' size='8' class='input' name='voo".$cont."' value='".$sqlDadosPassagem['voo']."'/></td>
				<td align='center'><select name='cia".$cont."'>";
				if($cia==0){
					echo "<option value='0' selected='selected'>Selecione</option>";
					}else{
						echo "<option value='".$cia."' selected='selected'>".utf8_encode($nomeCia)."</option>";
						}
				$selectCias=mysql_query("select * from cia where id<>'".$cia."'");
				while($objSelectCia=mysql_fetch_object($selectCias)){
					echo "<option value='".$objSelectCia->id."'>".utf8_encode($objSelectCia->nome)."</option>";
					}
				echo "</select></td>
  				</tr>";
		  $cont++;
		  }else{
			  $queryDadosPassagem=mysql_query("SELECT prestsavvoo.*,cia.id AS idcia, cia.nome AS nomecia FROM prestsavvoo LEFT JOIN cia ON cia.id=prestsavvoo.cia WHERE prestsavvoo.idpass='".$objPassagemImp->id."' ORDER BY prestsavvoo.id DESC");
			  $sqlDadosPassagem=mysql_fetch_array($queryDadosPassagem);
			  $queryAut=mysql_query("SELECT registros.localizador,registros.id AS idreg,cia.nome,cia.id AS idcia FROM registros LEFT JOIN cia ON registros.idcia=cia.id WHERE registros.solicitacao='".$objPassagemImp->numci."' AND registros.idben='".$benef."' AND registros.id<>'".$idPassagemAut."' ORDER BY registros.id DESC") or die(mysql_error());
			  $buscaAutorizacao=mysql_fetch_array($queryAut);
			  $idPassagemAut=$sqlDadosPassagem['idreg'];
		if(!empty($sqlDadosPassagem['loc'])){
			$localizador=$sqlDadosPassagem['loc'];
			}else{
				$localizador=$buscaAutorizacao['localizador'];
				};
		if(!empty($sqlDadosPassagem['cia'])){
			$cia=$sqlDadosPassagem['cia'];
			$nomeCia=$sqlDadosPassagem['nomecia'];
			}else{
				$cia=$buscaAutorizacao['idcia'];
				$nomeCia=$buscaAutorizacao['nome'];
				};
				if(empty($cia)){
					$cia=0;
					}
				if(empty($objPassagemImp->dtvolta)){
					$voltaData=$objPassagemImp->dtida;
					}else{
						$voltaData=$objPassagemImp->dtvolta;
						}
			echo " <tr>
    			<td ><strong>VOLTA</strong></td>
    			<td align='center'><font size='-2'>".$voltaData."<br>".utf8_encode($voltaImpressao)." x ".utf8_encode($idaImpressao)."</font></td>
    			<td align='center'><input type='hidden' size='8' class='input' name='idpas".$cont."' value='".$objPassagemImp->id."'/><input type='time' size='8' class='input' name='hora".$cont."' value='".$sqlDadosPassagem['horario']."'/></td>
				<td align='center'><input type='text' size='8' class='input' name='loc".$cont."' value='".$localizador."'/></td>
				<td align='center'><input type='text' size='8' class='input' name='voo".$cont."' value='".$sqlDadosPassagem['voo']."'/></td>
				<td align='center'><select name='cia".$cont."'>";
				if($cia==0){
					echo "<option value='0' selected='selected'>Selecione</option>";
					}else{
						echo "<option value='".$cia."' selected='selected'>".utf8_encode($nomeCia)."</option>";
						}
				$selectCias=mysql_query("select * from cia where id<>'".$cia."'");
				while($objSelectCia=mysql_fetch_object($selectCias)){
					echo "<option value='".$objSelectCia->id."'>".utf8_encode($objSelectCia->nome)."</option>";
					}
				echo "</select></td>
  				</tr>";
			$cont++;
			}
	 	}else{
			for($j=0;$j<=1;$j++){
			   if($j==0){
				   $queryDadosPassagem=mysql_query("SELECT prestsavvoo.*,cia.id AS idcia, cia.nome AS nomecia FROM prestsavvoo LEFT JOIN cia ON cia.id=prestsavvoo.cia WHERE prestsavvoo.idpass='".$objPassagemImp->id."' ORDER BY prestsavvoo.id ASC");
			  $sqlDadosPassagem=mysql_fetch_array($queryDadosPassagem);
				   $queryAut=mysql_query("SELECT registros.localizador,cia.nome,cia.id AS idcia FROM registros LEFT JOIN cia ON registros.idcia=cia.id WHERE registros.solicitacao='".$objPassagemImp->numci."' AND registros.idben='".$benef."' ORDER BY registros.id ASC") or die(mysql_error());
			   $buscaAutorizacao=mysql_fetch_array($queryAut);
		if(!empty($sqlDadosPassagem['loc'])){
			$localizador=$sqlDadosPassagem['loc'];
			}else{
				$localizador=$buscaAutorizacao['localizador'];
				};
		if(!empty($sqlDadosPassagem['cia'])){
			$cia=$sqlDadosPassagem['cia'];
			$nomeCia=$sqlDadosPassagem['nomecia'];
			}else{
				$cia=$buscaAutorizacao['idcia'];
				$nomeCia=$buscaAutorizacao['nome'];
				};
				if(empty($cia)){
					$cia=0;
					}
			   echo " <tr>
    			<td ><strong>IDA</strong></td>
    			<td align='center'><font size='-2'>".$objPassagemImp->dtida."<br>".utf8_encode($idaImpressao)." x ".utf8_encode($voltaImpressao)."</font></td>
    			<td align='center'><input type='hidden' size='8' class='input' name='idpas".$cont."' value='".$objPassagemImp->id."'/><input type='time' size='8' class='input' name='hora".$cont."' value='".$sqlDadosPassagem['horario']."'/></td>
				<td align='center'><input type='text' size='8' class='input' name='loc".$cont."' value='".$localizador."'/></td>
				<td align='center'><input type='text' size='8' class='input' name='voo".$cont."' value='".$sqlDadosPassagem['voo']."'/></td>
				<td align='center'><select name='cia".$cont."'>";
				if($cia==0){
					echo "<option value='0' selected='selected'>Selecione</option>";
					}else{
						echo "<option value='".$cia."' selected='selected'>".utf8_encode($nomeCia)."</option>";
						}
				$selectCias=mysql_query("select * from cia where id<>'".$cia."'");
				while($objSelectCia=mysql_fetch_object($selectCias)){
					echo "<option value='".$objSelectCia->id."'>".utf8_encode($objSelectCia->nome)."</option>";
					}
				echo "</select></td>
  				</tr>";
			   $cont++;
			   }else{
				   $queryDadosPassagem=mysql_query("SELECT prestsavvoo.*,cia.id AS idcia, cia.nome AS nomecia FROM prestsavvoo LEFT JOIN cia ON cia.id=prestsavvoo.cia WHERE prestsavvoo.idpass='".$objPassagemImp->id."' ORDER BY prestsavvoo.id DESC");
			  $sqlDadosPassagem=mysql_fetch_array($queryDadosPassagem);
				   $queryAut=mysql_query("SELECT registros.localizador,cia.nome,cia.id AS idcia FROM registros LEFT JOIN cia ON registros.idcia=cia.id WHERE registros.solicitacao='".$objPassagemImp->numci."' AND registros.idben='".$benef."' ORDER BY registros.id DESC") or die(mysql_error());
				   $buscaAutorizacao=mysql_fetch_array($queryAut);
		if(!empty($sqlDadosPassagem['loc'])){
			$localizador=$sqlDadosPassagem['loc'];
			}else{
				$localizador=$buscaAutorizacao['localizador'];
				};
		if(!empty($sqlDadosPassagem['cia'])){
			$cia=$sqlDadosPassagem['cia'];
			$nomeCia=$sqlDadosPassagem['nomecia'];
			}else{
				$cia=$buscaAutorizacao['idcia'];
				$nomeCia=$buscaAutorizacao['nome'];
				};
				if(empty($cia)){
					$cia=0;
					}
			echo " <tr>
    			<td ><strong>VOLTA</strong></td>
    			<td align='center'><font size='-2'>".$objPassagemImp->dtvolta."<br>".utf8_encode($voltaImpressao)." x ".utf8_encode($idaImpressao)."</font></td>
    			<td align='center'><input type='hidden' size='8' class='input' name='idpas".$cont."' value='".$objPassagemImp->id."'/><input type='time' size='8' class='input' name='hora".$cont."' value='".$sqlDadosPassagem['horario']."'/></td>
				<td align='center'><input type='text' size='8' class='input' name='loc".$cont."' value='".$localizador."'/></td>
				<td align='center'><input type='text' size='8' class='input' name='voo".$cont."' value='".$sqlDadosPassagem['voo']."'/></td>
				<td align='center'><select name='cia".$cont."'>";
				if($cia==0){
					echo "<option value='0' selected='selected'>Selecione</option>";
					}else{
						echo "<option value='".$cia."' selected='selected'>".utf8_encode($nomeCia)."</option>";
						}
				$selectCias=mysql_query("select * from cia where id<>'".$cia."'");
				while($objSelectCia=mysql_fetch_object($selectCias)){
					echo "<option value='".$objSelectCia->id."'>".utf8_encode($objSelectCia->nome)."</option>";
					}
				echo "</select></td>
  				</tr>";
				   $cont++;
				   }
			   }
			}
	  }
echo "<input type='hidden' size='8' class='input' name='cont' value='".$cont."'/></table></div>";
}
?>