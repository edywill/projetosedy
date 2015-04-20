<?php
require('conectsqlserver.php');
$a=' ';
$b=1;
$stmt    = odbc_prepare($conCab, 'CALL CG_PR_ULTSOLICT(?,?)');
$success = odbc_execute($stmt, array($a, $b));
echo $success;
?>