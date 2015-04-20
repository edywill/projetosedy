<?php
if(!isset($_SESSION)){
session_start();
}
$evento=$_GET['valor'];
$_SESSION['idEvento']=$evento;
?>