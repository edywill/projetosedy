<?php 
//while dos registros de passagem para criar os itens de passagens exclusivos
			$sqlRegistrosHospedagem=mysql_query("SELECT savhospedagem.* FROM savhospedagem WHERE idsav='".$numSav."'");
			 $countErrorHot=0;
			 while($objRegistrosHos=mysql_fetch_object($sqlRegistrosHospedagem)){			
					$dtIdaHospSav=$objRegistrosHos->dtida;
$dtVoltaHospSav=$objRegistrosHos->dtvolta;
if($homolog==0){
	$dtIdaHospSav=converteData($objRegistrosHos->dtida);
$dtVoltaHospSav=converteData($objRegistrosHos->dtvolta);
	}
					$sqlConsidHos="select MAX(id_registro) as id from TEITEMSOLHOTEL WITH(NOLOCK)";
					$rsConsidHos= odbc_exec($conCab2,$sqlConsidHos) or die(odbc_error());
					$arrayConsidHos = odbc_fetch_array($rsConsidHos);
					$idHosNova=$arrayConsidHos['id']+1;
					if($_SESSION['abrangenciaSav']=='Nacional'){
					$sqlDestino=mysql_fetch_array(mysql_query("SELECT uf,municipio FROM municipios WHERE id='".$objRegistrosHos->destino."'"));
					$destino=$sqlDestino['municipio']."-".$sqlDestino['uf'];
					}else{
						$sqlDestino=mysql_fetch_array(mysql_query("SELECT iso,nome FROM paises WHERE iso='".$objRegistrosHos->destino."'"));
						$destino=$objRegistrosHos->cidhos."/".$sqlDestino['nome']."-".$sqlDestino['iso'];
						}
					$sqlHotNova="insert into TEITEMSOLHOTEL(
					   id_registro,
					   cd_solicitacao,
					   sequencia,
					   cd_empresa,
					   reserva,
					   dt_entrada,
					   dt_saida,
					   usu_criacao,
					   dt_criacao,
					   hr_criacao,
					   usu_modificacao,
					   dt_modificacao,
					   hr_modificacao,
					   cargo
					   )
					values
					   (
					   ".$idHosNova.",                           --  id_registro  int 
					   ".$solicitacao.",                          --  cd_solicitacao  float 
					   ".$sequenciaHos.",                            --  sequencia  real 
					   '".$idBenef."',                     --  cd_empresa  char(6)
					   '0',
					   CAST('".$dtIdaHospSav."' AS DATETIME),    --  dt_inicio  datetime 
					   CAST('".$dtVoltaHospSav."' AS DATETIME),    --  dt_fim  datetime 
					   '".$userCriac."',                        --  usu_criacao  char(3)
					   dbo.CGFC_DATAATUAL (),    --  dt_criacao  datetime 
					   '".date("His")."',                     --  hr_criacao  char(6)
					   '   ',                        --  usu_modificacao  char(3)
					   NULL,                       --  dt_modificacao  datetime 
					   'NULL',                       --  hr_modificacao  char(6)
					   '".$cargoBenef."'                   --  cargo varchar(40)
					   )";
						$resHotNovo = odbc_exec($conCab2, $sqlHotNova) or die("<p>".odbc_errormsg());
					if(!$resHotNovo){
						$countErrorHot++;
						}
				}
?>