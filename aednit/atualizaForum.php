<?php 
require "conect.php";
require 'PasswordHash.php';
echo "erro";
$t_hasher = new PasswordHash(8, FALSE);
$sqlUser=mysql_query("SELECT * FROM usuarios") or die(mysql_error);
$cont=53;
while($objUser=mysql_fetch_object($sqlUser)){
$hash = $t_hasher->HashPassword($objUser->pass);
$sqlInsertForum=mysql_query("INSERT INTO  phpbb_users VALUES (".$cont.",0,2,'',0,'187.104.219.40','1411935756','".$objUser->user."','".$objUser->user."','".$hash."','1411935756','0','".$objUser->email."','','','0','','0','','','0','0','0','0','0','0','0','pt_br','-3.00','0','D M d, Y h:i','1','0','','0','0','0','0','-3','0','0','t','d','0','t','a','0','1','0','1','1','1','1','230271','','0','0','0','','','','','','','','','','','','','','','9056a079fca18bd2',1,0,0)")or die (mysql_error());
$sqlGroup1=mysql_query("INSERT INTO phpbb_user_group VALUES (7,".$cont.",0,0)") or die(mysql_error());
$sqlGroup2=mysql_query("INSERT INTO phpbb_user_group VALUES(2,".$cont.",0,0)")or die(mysql_error());
$cont++;
}
?>