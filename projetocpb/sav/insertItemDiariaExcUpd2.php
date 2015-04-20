<?php 
$dtIdaDiariaSav=$arrayRegistro['dtida'];
$dtVoltaDiariaSav=$arrayRegistro['dtvolta'];
if($homolog==0){
	$dtIdaDiariaSav=converteData($arrayRegistro['dtida']);
$dtVoltaDiariaSav=converteData($arrayRegistro['dtvolta']);
	}
$sqlConsidDia="select MAX(id_registro) as id from TEITEMSOLDIARIAVIAGEM WITH(NOLOCK)";
			$rsConsidDia = odbc_exec($conCab2,$sqlConsidDia)or die("<p>".odbc_errormsg());
			$arrayConsidDia = odbc_fetch_array($rsConsidDia);
			$idDiaNova=$arrayConsidDia['id']+1;
		$sqlDiaNova="insert into TEITEMSOLDIARIAVIAGEM(
				   id_registro,
				   solicitacao,
				   sequencia,
				   empresa,
				   dt_inicio,
				   dt_termino,
				   valor,
				   lancamento,
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
				   ".$idDiaNova.",                           --  id_registro  int 
				   ".$solicitacao.",                          --  cd_solicitacao  float 
				   ".$sequenciaDia.",                            --  sequencia  real 
				   '".$idBenef."',                     --  cd_empresa  char(6)
				   CAST('".$dtIdaDiariaSav."' AS DATETIME),    --  dt_inicio  datetime 
				   CAST('".$dtVoltaDiariaSav."' AS DATETIME),    --  dt_fim  datetime 
				   ".$valorTotal.",                         --  valor  float 
				   0,                            --  cd_lancamento  float 
				   '".$userCriac."',                        --  usu_criacao  char(3)
				   dbo.CGFC_DATAATUAL(),    --  dt_criacao  datetime 
				   '".date("His")."',                     --  hr_criacao  char(6)
				   '   ',                        --  usu_modificacao  char(3)
				   NULL,                       --  dt_modificacao  datetime 
				   'NULL',                       --  hr_modificacao  char(6)
				   '".$cargoBenef."'                   --  cargo varchar(40)
				   )";
					$resDiaNovo = odbc_exec($conCab2, $sqlDiaNova) or die("<p>".odbc_errormsg());
		if(!$resDiaNovo){
				$valida=1;
				$countError++;
				$errorMsg.='Erro['.$countError.']: Problema ao criar o registro da diária.\\n';
			}
?>