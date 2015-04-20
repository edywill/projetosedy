<?php

include "conect.php";
// EXEMPLO do uso dessa função
$server = "londres"; //IP ou nome do servidor
$dominio = "@cpb.org.br"; //Dominio Ex: @gmail.com
$user = $_POST['login'].$dominio;
$pass = $_POST['senha'];
if(empty($_POST['login'])||empty($pass)){
echo "<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
alert ('Digite usuario e senha para acessar')
window.history.back();
</SCRIPT>";
				  
				  }else{
$nusuario = addslashes($_POST['login']);
//Verifica se o usuario esta cadstrado na Intraner
$sql = "SELECT id, nome FROM usuarios WHERE `usuario` = '".$nusuario."' LIMIT 1";
$query = mysql_query($sql);
$resultado = mysql_fetch_assoc($query);
$sqlUsuarioIntra=mysql_query("SELECT 1 FROM usuarios WHERE usuario='".$nusuario."'") or die(mysql_error());
$numRowsUsuarios=mysql_num_rows($sqlUsuarioIntra);
if($numRowsUsuarios<1){
	alerta("Usu\u00e1rio n\u00e3o cadastrado na Intranet. Solicite cadastro junto ao RH..", "loginad.php");
	}else{
// Verifica se precisa iniciar a sessão
if ($_SG['abreSessao'] == true) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Salva duas variáveis com o que foi digitado no formulário
    // Detalhe: faz uma verificação com isset() pra saber se o campo foi preenchido
    $usuario = (isset($_POST['login'])) ? $_POST['login'] : '';
    $senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';
            $_SESSION['usuario'] = $usuario;
			$_SESSION['senha'] = $senha;
			// Definimos dois valores na sessão com os dados do usuário
        $_SESSION['usuarioID'] = $resultado['id']; // Pega o valor da coluna 'id do registro encontrado no MySQL
        $_SESSION['usuarioNome'] = $resultado['nome']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
		$_SESSION['usuarioLogin'] = $usuario;
        $_SESSION['usuarioSenha'] = $senha;
    // Utiliza uma função criada no seguranca.php pra validar os dados digitados
	
if (valida_ldap($server, $user, $pass)) {
header("Location: principal.php");
//alerta("Bem vindo a IntranetCPB.", "principal.php");
//exit;
}else {
 alerta("Usuario ou senha invalido.", "loginad.php");//Chamada da mensagem  
}
}
}
}
/*********************************************
Função de validação no AD via protocolo LDAP
como usar:
valida_ldap("servidor", "domínio\usuário", "senha");

*********************************************/

function valida_ldap($srv, $usr, $pwd){
$ldap_server = $srv;
$auth_user = $usr;
$auth_pass = $pwd;

// Tenta se conectar com o servidor
if (!($connect = @ldap_connect($ldap_server))) {
return FALSE;
}

// Tenta autenticar no servidor
if (!($bind = @ldap_bind($connect, $auth_user, $auth_pass))) {
// se não validar retorna false
return FALSE;
} else {
// se validar retorna true
return TRUE;
}

}

function alerta($mensagem, $caminho){  
echo "<script>alert('".$mensagem."');top.location.href='".$caminho."';</script>"; 
global $_SG;

    // Remove as variáveis da sessão (caso elas existam)
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
 
}

?>