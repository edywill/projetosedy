<?php
 //include_once("verifica.php");
 //$loginClube=$_SESSION['login'];
$host = "localhost"; //Local onde o MySQL está instalado, no nosso caso no LOCALHOST
$basededados = "cpb"; // Nome do banco de Dados
$login = "cpb_user"; // Login do MySQL, no EasyPHP o login padrão é "root"
$senha = "rio2016"; // Senha do MySQL, no EasyPHP  não temos senha por padrão, mas nada te impede de colocar.

//Conexão com o Banco de Dados
$conexao = mysql_connect($host, $login, $senha) or die(mysql_error());

mysql_select_db($basededados) or die("MySQL: Não foi possível conectar-se ao banco de dados [".$basededados."].");

if ( !isset($_REQUEST['term']) )
    exit;

$rs = mysql_query('select * from usuarios where nome like "%'. mysql_real_escape_string($_REQUEST['term']) .'%" order by nome asc limit 0,10');

$data = array();
if ( $rs && mysql_num_rows($rs) )
{
    while( $row = mysql_fetch_array($rs, MYSQL_ASSOC) )
    {
        $data[] = array(
            'label' => $row['nome'],
            'value' => $row['nome']
        );
    }
}

echo json_encode($data);
flush();

