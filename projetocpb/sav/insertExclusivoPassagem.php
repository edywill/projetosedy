<?php 
			 $sqlRegistrosPassagem=mysql_query("SELECT savpassagem.* FROM savpassagem WHERE idsav='".$numSav."'");
			 $countErrorPas=0;
			 while($objRegistrosPas=mysql_fetch_object($sqlRegistrosPassagem)){			
					$sqlConsidPas="select MAX(id_registro) as id from TEITEMSOLPASSAGEM WITH(NOLOCK)";
					$rsConsidPas= odbc_exec($conCab2,$sqlConsidPas) or die(odbc_error());
					$arrayConsidPas = odbc_fetch_array($rsConsidPas);
					$idPasNova=$arrayConsidPas['id']+1;
					$fimPas='null';
					$horaRetPas='';
					$dtIdaPassagemSav=$objRegistrosPas->dtida;
$dtVoltaPassagemSav=$objRegistrosPas->dtvolta;
if($homolog==0){
	$dtIdaPassagemSav=converteData($objRegistrosPas->dtida);
$dtVoltaPassagemSav=converteData($objRegistrosPas->dtvolta);
	}
					if(!empty($objRegistrosPas->dtvolta)){
					$fimPas="CAST('".$dtVoltaPassagemSav."' AS DATETIME)";
					if($objRegistrosPas->horariovolta=='manha'){
						$horaRetPas='090000';
						}elseif($objRegistrosPas->horariovolta=='tarde'){
							$horaRetPas='150000';
							}elseif($objRegistrosPas->horariovolta=='noite'){
								$horaRetPas='200000';
								}
					}
					$horaPtPas='';
					if($objRegistrosPas->horarioida=='manha'){
						$horaPtPas='090000';
						}elseif($objRegistrosPas->horarioida=='tarde'){
							$horaPtPas='150000';
							}elseif($objRegistrosPas->horarioida=='noite'){
								$horaPtPas='200000';
								}
					$trechoPas='';
					if($_SESSION['abrangenciaSav']=='Nacional'){
						$sqlOrigem=mysql_fetch_array(mysql_query("SELECT uf,municipio FROM municipios WHERE id='".$objRegistrosPas->origem."'"));
						$sqlDestino=mysql_fetch_array(mysql_query("SELECT uf,municipio FROM municipios WHERE id='".$objRegistrosPas->destino."'"));
					if($objRegistrosPas->tipo==1){
						$trechoPas=$sqlOrigem['municipio']."/".$sqlOrigem['uf']." X ".$sqlDestino['municipio']."/".$sqlDestino['uf'];
						}else{
							$trechoPas=$sqlOrigem['municipio']."/".$sqlOrigem['uf']." X ".$sqlDestino['municipio']."/".$sqlDestino['uf']." X ".$sqlOrigem['municipio']."/".$sqlOrigem['uf'];
							}
					}else{
						$sqlOrigem=mysql_fetch_array(mysql_query("SELECT iso,nome FROM paises WHERE iso='".$objRegistrosPas->origem."'"));
						$sqlDestino=mysql_fetch_array(mysql_query("SELECT iso,nome FROM paises WHERE iso='".$objRegistrosPas->destino."'"));
					if($objRegistrosPas->tipo==1){
						$trechoPas=$objRegistrosPas->cidorigem."-".$sqlOrigem['nome']."/".$sqlOrigem['iso']." X ".$objRegistrosPas->ciddestino."-".$sqlDestino['nome']."/".$sqlDestino['iso'];
						}else{
							$trechoPas=$objRegistrosPas->cidorigem."-".$sqlOrigem['nome']."/".$sqlOrigem['iso']." X ".$objRegistrosPas->ciddestino."-".$sqlDestino['nome']."/".$sqlDestino['iso']." X ".$objRegistrosPas->cidorigem."-".$sqlOrigem['nome']."/".$sqlOrigem['iso'];
							}
						}
					$sqlPasNova="insert into TEITEMSOLPASSAGEM(
						   id_registro,
						   cd_solicitacao,
						   sequencia,
						   cd_empresa,
						   dt_partida,
						   hr_partida,
						   dt_chegada,
						   hr_chegada,
						   cadeirante,
						   observacao,
						   trecho,
						   usu_criacao,
						   dt_criacao,
						   hr_criacao,
						   usu_modificacao,
						   dt_modificacao,
						   hr_modificacao,
						   valor,
						   cargo
						   )
						values
						   (
						   ".$idPasNova.",                           --  id_registro  int 
						   ".$solicitacao.",                          --  cd_solicitacao  float 
						   ".$sequenciaPas.",                            --  sequencia  real 
						   '".$idBenef."',                     --  cd_empresa  char(6)
						   CAST('".$dtIdaPassagemSav."' AS DATETIME),    --  dt_inicio  datetime 
						   '".$horaPtPas."',   --hr_partida
						   ".$fimPas.",    --  dt_fim  datetime 
						   '".$horaRetPas."',   --hr_retorno
						   ".$objRegistrosPas->cadeirante.", --Cadeirante 
						   '', --Observacao
						   '".$trechoPas."', --Trecho
						   '".$userCriac."',                        --  usu_criacao  char(3)
						   dbo.CGFC_DATAATUAL(),    --  dt_criacao  datetime 
						   '".date("His")."',                     --  hr_criacao  char(6)
						   '   ',                        --  usu_modificacao  char(3)
						   NULL,                       --  dt_modificacao  datetime 
						   'NULL',                       --  hr_modificacao  char(6)
						   ".(float)str_replace(",",".",str_replace(".","",$objRegistrosPas->valor)).",--  valor  float
						   '".$cargoBenef."'                   --  cargo varchar(40)
						   )";
				$resPasNovo = odbc_exec($conCab2, $sqlPasNova) or die("<p>".odbc_errormsg());
					if(!$resPasNovo){
						$countErrorPas++;
						}
				}
?>