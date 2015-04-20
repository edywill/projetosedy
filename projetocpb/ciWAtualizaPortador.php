<?php
require "conectsqlserverciprod.php";
include "function.php";
$usuario=$_POST['user'];

$solicitacao=$_POST['solicitacao'];
$portador=trim($_POST['portador']);

$descricao=$_POST["desc_ci"];
$controle=$_POST["controle"];

$arPortador = explode('-', $portador);
$portador=$arPortador[0];
 if(!empty($portador)){
	$sqlConsPortador="select *
			  from GFPORTAD (nolock)
			  WHERE Cd_portador='".$portador."'";
	$rsConsPortador = odbc_exec($conCab,$sqlConsPortador) or die(odbc_error());
	$contarConsPortador=odbc_num_rows($rsConsPortador);
	$sqlConsPortadorAtivo="select 1
			  from GFPORTAD (nolock) 
			  where ativo = 1 AND 
			  Cd_portador='".$portador."'";
	$rsConsPortadorAtivo = odbc_exec($conCab,$sqlConsPortadorAtivo) or die(odbc_error());
	$contarConsPortadorAtivo=odbc_num_rows($rsConsPortadorAtivo);
	
	if(empty($contarConsPortador)){
		?>
       <script type="text/javascript">
       alert("Erro: O código: <?php echo $portador; ?> não se refere a um portador válido.");
       history.back();
       </script>
       <?php
		}
		
		if(empty($contarConsPortadorAtivo)){
			?>
       <script type="text/javascript">
       alert("Erro: O código:<?php echo $portador; ?> refere-se a um portador inativo.");
       history.back();
       </script>
       <?php
	}else{

	$selectPortador=odbc_exec($conCab, "SELECT cd_portador FROM TEPORTADORSOL WHERE solicitacao='".$solicitacao."'") or die("<p>".odbc_errormsg());
	$resSelectPortador=odbc_fetch_array($selectPortador);
	if(empty($resSelectPortador)){
		$SQLPortadorAt ="insert into TEPORTADORSOL(
	   solicitacao,
	   cd_portador,
	   dt_ocorrencia)
	   VALUES(
	   ".$solicitacao.",        --  solicitacao  float 
	   '".$portador."',         --  cd_portador  char(3)
	   dbo.CGFC_DATAATUAL()  		--  dt_ocorrencia  datetime 
	   )";
		$resPortadorAt = odbc_exec($conCab, $SQLPortadorAt) or die("<p>".odbc_errormsg());
	                  }else{
						  $SQLPortadorAt ="update TEPORTADORSOL SET cd_portador='".$portador."' WHERE solicitacao='".$solicitacao."'";
		$resPortadorAt = odbc_exec($conCab, $SQLPortadorAt) or die("<p>".odbc_errormsg());
						  
						  }
if($controle==0){
			?>
       <script type="text/javascript">
       alert("Portador atualizado com sucesso!");
      window.location.href = 'ciWAlteraItAp.php';
       </script>
<?php 			 
			 }else{
//Atualiza Controle da CI
$pgRetornoUp="ciweb";
$idTipoUp='IN';

updateCi($solicitacao,$usuario,$descricao,$controle,$pgRetornoUp,$idTipoUp);
		}
		 
	}
 }
function converteData($data){
       if (strstr($data, "/")){//verifica se tem a barra /
           $d = explode ("/", $data);//tira a barra
           $rstData = "$d[2]-$d[1]-$d[0]";//separa as datas $d[2] = ano $d[1] = mes etc...
           return $rstData;
       }
       else if(strstr($data, "-")){
          $data = substr($data, 0, 10);
          $d = explode ("-", $data);
          $rstData = "$d[2]/$d[1]/$d[0]";
          return $rstData;
       }
       else{
           return '';
      }
}
?>