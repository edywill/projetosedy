<?php 
require "conect.php";
$sqlUser=mysql_query("SELECT * FROM usuarios WHERE status='1'");
$count=0;
while($obj=mysql_fetch_object($sqlUser)){
	$insert=mysql_query("INSERT INTO modulo VALUES ('','".$obj->id."','gest')") or die (mysql_error());
	if($insert){
		$count++;
		}
	}
$sqlUser2=mysql_query("SELECT * FROM usuarios WHERE status='2'");
$count2=0;
while($obj2=mysql_fetch_object($sqlUser2)){
	$insert2=mysql_query("INSERT INTO modulo VALUES ('','".$obj2->id."','rh')") or die (mysql_error());
	if($insert2){
		$count2++;
		}
	}
$sqlUser3=mysql_query("SELECT * FROM usuarios WHERE status='4'");
$count3=0;
while($obj3=mysql_fetch_object($sqlUser3)){
	$insert3=mysql_query("INSERT INTO modulo VALUES ('','".$obj3->id."','presi')") or die (mysql_error());
	if($insert3){
		$count3++;
		}
	}
$sqlUser4=mysql_query("SELECT * FROM usuarios WHERE status='5' OR status='6'");
$count4=0;
while($obj4=mysql_fetch_object($sqlUser4)){
	$insert4=mysql_query("INSERT INTO modulo VALUES ('','".$obj4->id."','prest')") or die (mysql_error());
	if($insert4){
		$count4++;
		}
	}
$sqlUser5=mysql_query("SELECT * FROM usuarios WHERE convenio='1' OR convenio='2'");
$count5=0;
while($obj5=mysql_fetch_object($sqlUser5)){
	$insert5=mysql_query("INSERT INTO modulo VALUES ('','".$obj5->id."','conv')") or die (mysql_error());
	if($insert5){
		$count5++;
		}
	}
echo $count." - ".$count2." - ".$count3." - ".$count4." - ".$count5;
?>