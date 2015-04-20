<?php 
//  Configurações do Script
// ==============================
$_SG['conectaServidor'] = true;    // Abre uma conexão com o servidor MySQL?
$_SG['abreSessao'] = true;         // Inicia a sessão com um session_start()?

$_SG['caseSensitive'] = false;

$_SG['validaSempre'] = true;       // Deseja validar o usuário e a senha a cada carregamento de página?
// Evita que, ao mudar os dados do usuário no banco de dado o mesmo contiue logado.

$_SG['servidor'] = '186.202.152.147';    // Servidor MySQL
$_SG['usuario'] = 'aednit';          // Usuário MySQL
$_SG['senha'] = 'dnit14';                // Senha MySQL
$_SG['banco'] = 'aednit';            // Banco de dados MySQL

//$_SG['servidor'] = 'localhost';    // Servidor MySQL
//$_SG['usuario'] = 'cpb_user';          // Usuário MySQL
//$_SG['senha'] = 'rio2016';                // Senha MySQL
//$_SG['banco'] = 'aednit';            // Banco de dados MySQL

$_SG['paginaLogin'] = 'login.php'; // Página de login

$_SG['tabela'] = 'usuarios';       // Nome da tabela onde os usuários são salvos
// ==============================

// ======================================
//   ~ Não edite a partir deste ponto ~
// ======================================

// Verifica se precisa fazer a conexão com o MySQL
if ($_SG['conectaServidor'] == true) {
    $_SG['link'] = mysql_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha']) or die("MySQL: Não foi possível conectar-se ao servidor [".$_SG['servidor']."].");
    mysql_select_db($_SG['banco'], $_SG['link']) or die("MySQL: Não foi possível conectar-se ao banco de dados [".$_SG['banco']."].");
}
?>