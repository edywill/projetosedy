<?Php 
session_start();
$_SESSION['idItemSession']='';
$_SESSION['abrangenciaEventoSession']='';
$_SESSION['idEventoSession']='';
$_SESSION['editarSession']='';
$_SESSION['tipoDespSessionConv']='';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../css/estilo.css" rel="stylesheet" type="text/css" media="screen" />
<title>Untitled Document</title>
</head>
<body>
<div id='box3'>
<?php 
require "../../common/tagsConv.php";
require "../../../conexaomysql.php";
echo $titulo;

$tipoId='';
$id=0;
$titMod='';
if(empty($_SESSION['tipoIdSessionConv'])){
if(!empty($_POST['idAt'])){
	$id=$_POST['idAt'];
	$tipoId='at';
	$titMod='Atletismo';
	}
	
if(!empty($_POST['idBf'])){
	$id=$_POST['idBf'];
	$tipoId='bf';
	$titMod='Basquete Feminino';
	}
	if(!empty($_POST['idBm'])){
	$id=$_POST['idBm'];
	$tipoId='bm';
	$titMod='Basquete Masculino';
	}
	if(!empty($_POST['idBoc'])){
	$id=$_POST['idBoc'];
	$tipoId='boc';
	$titMod='Bocha';
	}
	if(!empty($_POST['idCic'])){
	$id=$_POST['idCic'];
	$tipoId='cic';
	$titMod='Ciclismo';
	}
	if(!empty($_POST['idEsg'])){
	$id=$_POST['idEsg'];
	$tipoId='esg';
	$titMod='Esgrima';
	}
	if(!empty($_POST['idFuc'])){
	$id=$_POST['idFuc'];
	$tipoId='fuc';
	$titMod='Futebol de 5';
	}
	if(!empty($_POST['idFus'])){
	$id=$_POST['idFus'];
	$tipoId='fus';
	$titMod='Futebol de 7';
	}
	if(!empty($_POST['idGof'])){
	$id=$_POST['idGof'];
	$tipoId='gof';
	$titMod='Goalball Feminino';
	}
	if(!empty($_POST['idGom'])){
	$id=$_POST['idGom'];
	$tipoId='gom';
	$titMod='Goalball Masculino';
	}
			
if(!empty($_POST['idHalt'])){
	$id=$_POST['idHalt'];
	$tipoId='halt';
	$titMod='Halterofilismo';
	}
	if(!empty($_POST['idHip'])){
	$id=$_POST['idHip'];
	$tipoId='hip';
	$titMod='Hipismo';
	}
	if(!empty($_POST['idJud'])){
	$id=$_POST['idJud'];
	$tipoId='jud';
	$titMod='Jud&ocirc;';
	}
if(!empty($_POST['idNat'])){
	$id=$_POST['idNat'];
	$tipoId='nat';
	$titMod='Nata&ccedil;&atilde;o';
	}
	if(!empty($_POST['idCan'])){
	$id=$_POST['idCan'];
	$tipoId='can';
	$titMod='Paracanoagem';
	}
	if(!empty($_POST['idThl'])){
	$id=$_POST['idThl'];
	$tipoId='thl';
	$titMod='Paratriathlon';
	}
	if(!empty($_POST['idRem'])){
	$id=$_POST['idRem'];
	$tipoId='rem';
	$titMod='Remo';
	}
	if(!empty($_POST['idRug'])){
	$id=$_POST['idRug'];
	$tipoId='rug';
	$titMod='Rugby';
	}
	if(!empty($_POST['idTen'])){
	$id=$_POST['idTen'];
	$tipoId='ten';
	$titMod='T&ecirc;nis';
	}
	if(!empty($_POST['idTar'])){
	$id=$_POST['idTar'];
	$tipoId='tar';
	$titMod='Tiro Arco';
	}
	if(!empty($_POST['idTes'])){
	$id=$_POST['idTes'];
	$tipoId='tes';
	$titMod='Tiro Esportivo';
	}
	if(!empty($_POST['idVel'])){
	$id=$_POST['idVel'];
	$tipoId='vel';
	$titMod='Vela';
	}
	if(!empty($_POST['idVof'])){
	$id=$_POST['idVof'];
	$tipoId='vof';
	$titMod='Volei. Feminino';
	}
	if(!empty($_POST['idVom'])){
	$id=$_POST['idVom'];
	$tipoId='vom';
	$titMod='Volei. Masculino';
	}
	$_SESSION['tipoIdSessionConv']=$tipoId;
}else{
	$id=$_SESSION['projetoConvS'];
	$tipoId=$_SESSION['tipoIdSessionConv'];
	if($tipoId=='nat'){
		$titMod='Nata&ccedil;&atilde;o';
		}elseif($tipoId=='at'){
			$titMod='Atletismo';
			}elseif($tipoId=='halt'){
			$titMod='Halterofilismo';
			}elseif($tipoId=='bf'){
			  $titMod='Basquete Feminino';
				}elseif($tipoId=='bm'){
			  $titMod='Basquete Masculino';
				}elseif($tipoId=='boc'){
			  $titMod='Bocha';
				}elseif($tipoId=='cic'){
			  $titMod='Ciclismo';
				}elseif($tipoId=='esg'){
			  $titMod='Esgrima';
				}elseif($tipoId=='fuc'){
			  $titMod='Futebol 5';
				}elseif($tipoId=='fus'){
			  $titMod='Futebol 7';
				}elseif($tipoId=='gof'){
			  $titMod='Goalball Feminino';
				}elseif($tipoId=='gom'){
			  $titMod='Goalball Masculino';
				}elseif($tipoId=='hip'){
			  $titMod='Hipismo';
				}elseif($tipoId=='jud'){
			  $titMod='Jud&ecirc;';
				}elseif($tipoId=='can'){
			  $titMod='Paracanoagem';
				}elseif($tipoId=='thl'){
			  $titMod='Paratriathlon';
				}elseif($tipoId=='rem'){
			  $titMod='Remo';
				}elseif($tipoId=='rug'){
			  $titMod='Rugby';
				}elseif($tipoId=='ten'){
			  $titMod='T&ecirc;nis';
				}elseif($tipoId=='tar'){
			  $titMod='Tiro Arco';
				}elseif($tipoId=='tes'){
			  $titMod='Tiro Esportivo';
				}elseif($tipoId=='vel'){
			  $titMod='Vela';
				}elseif($tipoId=='vof'){
			  $titMod='Volei. Feminino';
				}elseif($tipoId=='vom'){
			  $titMod='Volei. Masculino';
				}
	}

$_SESSION['modalRef']=$tipoId;
include "../projetos/detalhesProj.php";
echo "<br>
<h2>".$titMod."</h2>
<table border='0' width='100%' align='left'>
<tr>
<td>
<form action='../despesas/material.php' method='post' name='formcad'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='idproj'/>
<input type='hidden' name='titMod' value='".$titMod."'/>
<input type='submit' class='button' value='Material Esportivo ".$titMod."' name='evento'/>
</form><br>
</td>";
echo "<td>
<form action='../eventos/listaEventos.php' method='post' name='formcad'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' name='titMod' value='".$titMod."'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='submit' class='button' value='Eventos ".$titMod."' name='evento'/>
</form><br>
</td>
<td>
<form action='../despesas/index.php' method='post' name='formcad'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' name='titMod' value='".$titMod."'/>
<input type='hidden' value='".$id."' name='id'/>
<input type='submit' class='button' value='Proje&ccedil;&otilde;es ".$titMod."' name='evento'/>
</form><br>
</td>
</tr>
<tr>
<td>
<form action='../relatorios/index.php' method='post' target='_blank' name='formcad'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='idproj'/>
<input type='hidden' name='titMod' value='".$titMod."'/>
<input type='submit' class='button' value='Relat&oacute;rio por Evento ".$titMod."' name='evento'/>
</form><br>
</td>
</tr>
</table>";
/*echo "<td colspan='2'><form action='../relatorios/indexDes.php' method='post' target='_blank' name='formcad'>
<input type='hidden' value='".$tipoId."' name='tipoId'/>
<input type='hidden' value='".$id."' name='idproj'/>
<input type='hidden' name='titMod' value='".$titMod."'/>
<input type='submit' class='button' value='Relat&oacute;rio por Despesa ".$titMod."' name='evento'/>
</form><br>
</td>"; */
?>
<br /><br />
<a href="../projetos/indexProjeto.php"><input type="button" name="voltar" value="<<Voltar"/></a>
<br /><br /><br />
</div>
</body>
</html>