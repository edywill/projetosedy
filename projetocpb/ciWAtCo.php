<?php 
header('Content-Type: text/html; charset=ISO-8859-1');
include "function.php";
require "conect.php";
$user=$_POST['user'];
$sqlUser=mysql_query("SELECT usuario FROM usuarios WHERE cigam='".$user."'");
$userNome=mysql_fetch_array($sqlUser);
$numCi=$_POST['numCi'];
$descCi=$_POST['descCi'];
$controleNovo=$_POST['controleNovo'];
$pgRetorno="'ciWMenu.php'";
$idTipoUp='AT';
//$pgRetorno="window.location.href = 'http://intranetcpb.cpb.org.br/projetocpb/ciWResCons.php';";
updateCi($numCi,$userNome['usuario'],$descCi,$controleNovo,$pgRetorno,$idTipoUp);
?>