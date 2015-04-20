<?php 
//Querys
$sqlPasNac=mysql_query("SELECT * FROM convpas LEFT JOIN convpasreferencia ON convpas.trecho= convpasreferencia.id WHERE convpas.abrgpas='nac'") or die (mysql_error());
$sqlPasInt=mysql_query("SELECT * FROM convpas LEFT JOIN convpasintreferencia ON convpas.trecho= convpasintreferencia.id WHERE convpas.abrgpas='int'") or die (mysql_error());
$sqlHosNac=mysql_query("SELECT * FROM convhos LEFT JOIN convhosreferencia ON convhos.refs= convhosreferencia.id WHERE convhosreferencia.abrg='nac'") or die (mysql_error());
$sqlHosInt=mysql_query("SELECT * FROM convhos LEFT JOIN convhosreferencia ON convhos.refs= convhosreferencia.id WHERE convhosreferencia.abrg='int'") or die (mysql_error());
$sqlAliNac=mysql_query("SELECT * FROM convali LEFT JOIN convalireferencia ON convali.idref= convalireferencia.id WHERE convalireferencia.abrg='nac'") or die (mysql_error());
$sqlAliInt=mysql_query("SELECT * FROM convali LEFT JOIN convalireferencia ON convali.idref= convalireferencia.id WHERE convalireferencia.abrg='int'") or die (mysql_error());
$sqlTraNac=mysql_query("SELECT * FROM convtra LEFT JOIN convtrareferencia ON convtra.idref= convtrareferencia.id WHERE convtrareferencia.abrg='nac'") or die (mysql_error());
$sqlTraInt=mysql_query("SELECT * FROM convtra LEFT JOIN convtrareferencia ON convtra.idref= convtrareferencia.id WHERE convtrareferencia.abrg='int'") or die (mysql_error());
$sqlSgvNac=mysql_query("SELECT * FROM convsgv LEFT JOIN convsgvreferencia ON convsgv.idref= convsgvreferencia.id WHERE convsgvreferencia.abrg='nac'") or die (mysql_error());
$sqlSgvInt=mysql_query("SELECT * FROM convsgv LEFT JOIN convsgvreferencia ON convsgv.idref= convsgvreferencia.id WHERE convsgvreferencia.abrg='int'") or die (mysql_error());
$sqlRhtNac=mysql_query("SELECT * FROM convrh LEFT JOIN convrhreferencia ON convrh.nome=convrhreferencia.funcao") or die (mysql_error());
$sqlRhtInt=mysql_query("SELECT * FROM convrh LEFT JOIN convrhreferencia ON convrh.nome=convrhreferencia.funcao") or die (mysql_error());
$sqlMat=mysql_query("SELECT * FROM convmat") or die (mysql_error());
?>