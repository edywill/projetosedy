<?php 
require "conect.php";
$id='';
if( isset( $_GET['id'] ) ){
	$sql=mysql_query("select id from cimulttemp where ci='".$_GET['ci']."' AND seq='".$_GET['seq']."' AND id='".$_GET['id']."'");
	$array=mysql_fetch_array($sql);
	//$id = getGet('id');
	//$status=getGet('status');
	if(empty($array)){
	mysql_query ("INSERT INTO cimulttemp VALUES ('".$_GET['ci']."','".$_GET['seq']."','".$_GET['id']."','".$_GET['status']."')") or die(mysql_error());
	}else{
		mysql_query("UPDATE cimulttemp SET status='".$_GET['status']."' where ci='".$_GET['ci']."' AND seq='".$_GET['seq']."' AND id='".$_GET['id']."'");
		}
}
function getGet( $key ){
		return isset( $_GET[ $key ] ) ? filter( $_GET[ $key ] ) : null;
	}
function filter( $str ){
		return trim($str);//deixo a implementação desta por conta de vcs.
	}
?>