<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="1
" cellspacing="0" cellpadding="0">
  <tr>
    <td width="64"><a href="https://phpmyadmin.locaweb.com.br/sql.php?db=aednit&amp;table=usuarios&amp;sql_query=SELECT+%2A+FROM+%60usuarios%60+ORDER+BY+%60usuarios%60.%60id%60+ASC&amp;session_max_rows=30&amp;token=cef0b76db1ac751fec44208f281cf4cb" title="Ordenar">id</a></td>
    <td width="64"><a href="https://phpmyadmin.locaweb.com.br/sql.php?db=aednit&amp;table=usuarios&amp;sql_query=SELECT+%2A+FROM+%60usuarios%60+ORDER+BY+%60usuarios%60.%60name%60+ASC&amp;session_max_rows=30&amp;token=cef0b76db1ac751fec44208f281cf4cb" title="Ordenar">name</a></td>
    <td width="64"><a href="https://phpmyadmin.locaweb.com.br/sql.php?db=aednit&amp;table=usuarios&amp;sql_query=SELECT+%2A+FROM+%60usuarios%60+ORDER+BY+%60usuarios%60.%60matsiape%60+ASC&amp;session_max_rows=30&amp;token=cef0b76db1ac751fec44208f281cf4cb" title="Ordenar">matsiape</a></td>
  </tr>
  <?php 
 require 'conect.php';
 $sql=mysql_query("SELECT * FROM usuarios");
 while($obj=mysql_fetch_object($sql)){
	 echo "<tr><td>".$obj->id."</td><td>".mb_convert_encoding($obj->name, "UTF-8", "ISO-8859-1")."</td><td>".$obj->matsiape."</td></tr>";
	 }
  ?>
</table>
</body>
</html>