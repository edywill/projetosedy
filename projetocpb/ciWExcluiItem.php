<?php
require "conectsqlserverci.php";
session_start();
$solic=$_POST['solic'];
$sequencia=$_POST['sequencia'];
$retorno=$_POST['retorno'];
$readOnly=1;
if(empty($_SESSION['readOnly'])){
	$readOnly=0;
	}else{
		if($_SESSION['readOnly']==''){
			$readOnly=0;
			}
		}
$sqlLanFin=odbc_exec($conCab,"SELECT tipo_documento FROM GFLANCAM (nolock) WHERE tipo_documento='8' AND ltrim(rtrim(documento)) = ltrim(rtrim(cast('".$solic."' as varchar(20)))) AND ltrim(rtrim(usrlanc1))=ltrim(rtrim(cast('".$sequencia."' as varchar (5))))");
$arrayLanFin=odbc_num_rows($sqlLanFin);

$sqlItBaix=odbc_exec($conCab,"SELECT sequencia FROM COISOLIC (nolock) WHERE cd_especie_esto='B' AND cd_solicitacao= '".$solic."' AND sequencia='".$sequencia."'");
$arrayItBaix=odbc_num_rows($sqlItBaix);

$sqlSalZero=odbc_exec($conCab,"SELECT  qt_saldo FROM COISOLIC (nolock) WHERE cd_especie_esto='E' and qt_saldo=0 and cd_solicitacao='".$solic."' and sequencia='".$sequencia."'");
$arraySalZero=odbc_num_rows($sqlSalZero);
$sqlRpaDia=odbc_exec($conCab,"SELECT solicitacao FROM TEITEMSOLDIARIAVIAGEM (nolock) WHERE lancamento>0 AND solicitacao='".$solic."' and sequencia='".$sequencia."'
							union all SELECT cd_solicitacao from TEITEMSOLRPA (nolock) WHERE cd_lancamento>0 and cd_solicitacao='".$solic."' AND sequencia='".$sequencia."'");
$arrayRpaDia=odbc_num_rows($sqlRpaDia);
$validarSaldo=1;
if($arraySalZero>0){
	   $sqlTipo=odbc_exec($conCab,"Select
  TEANALIVERMATERIAL.*
From
  TEANALIVERMATERIAL(nolock) Inner Join
  COISOLIC(nolock) On TEANALIVERMATERIAL.material = COISOLIC.Cd_material
Where
  COISOLIC.Cd_solicitacao='".$solic."' AND
  COISOLIC.Sequencia='".$sequencia."'");
	   $arrayTipo=odbc_fetch_array($sqlTipo);
	   if($arrayTipo['habilitar_rpa']=='1' || $arrayTipo['habilitar_hotel']=='1' ||$arrayTipo['habilitar_passagem']=='1'|| $arrayTipo['habilitar_diaria']=='1' || $arrayTipo['habilitar_auxilio_viagem']=='1' || $arrayTipo['habilitar_ajuda_custo']=='1'){
		   $validarSaldo=0;
		   }
	}else{
		$validarSaldo=0;
		}
if($arrayRpaDia<1 && $validarSaldo<1 &&$arrayItBaix<1 && $arrayLanFin<1 && $readOnly<1){
	//mysql_query("BEGIN;");
$delRpa="DELETE FROM TEITEMSOLRPA WHERE cd_solicitacao='".$solic."' AND sequencia='".$sequencia."'";
$rsdelRpa = odbc_exec($conCab,$delRpa) or die(odbc_error());

$delDiaria="DELETE FROM TEITEMSOLDIARIAVIAGEM WHERE solicitacao='".$solic."' AND sequencia='".$sequencia."'";
$rsdelDiaria = odbc_exec($conCab,$delDiaria) or die(odbc_error());

$delPassagem="DELETE FROM TEITEMSOLPASSAGEM WHERE cd_solicitacao='".$solic."' AND sequencia='".$sequencia."'";
$rsdelPassagem = odbc_exec($conCab,$delPassagem) or die(odbc_error());

$delHotel="DELETE FROM TEITEMSOLHOTEL WHERE cd_solicitacao='".$solic."' AND sequencia='".$sequencia."'";
$rsdelHotel = odbc_exec($conCab,$delHotel) or die(odbc_error());


$ciUpdateItensSol=str_pad($solic, 8, "0", STR_PAD_LEFT);
$ciUpdateItensSeq=str_pad($sequencia, 3, "0", STR_PAD_LEFT);
$embarque_pedido=$ciUpdateItensSol."/".$ciUpdateItensSeq;

$delAcomp="DELETE FROM GEACOMP WHERE embarque_pedido='".$embarque_pedido."'";
$rsdelAcomp = odbc_exec($conCab,$delAcomp) or die(odbc_error());

$delItem="DELETE FROM COISOLIC WHERE cd_solicitacao='".$solic."' AND sequencia='".$sequencia."' ";
$rsdelItem = odbc_exec($conCab,$delItem) or die(odbc_error());
       if($rsdelItem){
		   $delTeItem="DELETE FROM TECOMPITEMSOLIC WHERE cd_solicitacao='".$solic."' AND sequencia='".$sequencia."' ";
		   $rsdeTelItem = odbc_exec($conCab,$delTeItem) or die(odbc_error());
		   $delCOCOTACA="DELETE FROM COCOTACA WHERE solicitacao='".$solic."' AND campo57='".$sequencia."' ";
		   $rsdelCOCOTACA = odbc_exec($conCab,$delCOCOTACA) or die(odbc_error());
	   ?>
       <script type="text/javascript">
       alert("Item exclu\u00eddo com sucesso.");
       window.location="<?php echo $retorno; ?>";
       </script>
       <?php
	   }else{
		   ?>
       <script type="text/javascript">
       alert("Ocorreu um erro.");
       window.location="<?php echo $retorno; ?>";
       </script>
       <?php
		   }
}else{
	?>
       <script type="text/javascript">
       alert("Esse registro n\u00e3o pode ser exclu\u00eddo.");
       window.location="<?php echo $retorno; ?>";
       </script>
       <?php
	}
?>
