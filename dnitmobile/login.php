<?php 
session_start();
$_SESSION['usuario']='';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Salva duas variáveis com o que foi digitado no formulário
    // Detalhe: faz uma verificação com isset() pra saber se o campo foi preenchido
    $usuarioLogin = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
    $senhaLogin = (isset($_POST['senha'])) ? $_POST['senha'] : '';
            // Utiliza uma função criada no seguranca.php pra validar os dados digitados
    if (validaUsuario($usuarioLogin, $senhaLogin) == true) {
        // O usuário e a senha digitados foram validados, manda pra página interna
		header("Location: principal.php");
    } else {
        // O usuário e/ou a senha são inválidos, manda de volta pro form de login
        // Para alterar o endereço da página de login, verifique o arquivo seguranca.php
       alerta("Usu\u00e1rio ou senha inv\u00e1lido.", "index.php");//Chamada da mensagem  
    }
}

//Valida Usuario

function validaUsuario($usuarioLogin, $senhaLogin) {
	require ("conexaobd/conectbd.php");
    // Usa a função addslashes para escapar as aspas
    $nusuario = addslashes($usuarioLogin);
    $nsenha = addslashes($senhaLogin);

    // Monta uma consulta SQL (query) para procurar um usuário
    $sql = "SELECT id_login FROM login WHERE usuario = '".$nusuario."' AND senha = '".$nsenha."'";
    $query = odbc_exec($conCab,$sql);
    $resultado = odbc_fetch_array($query);

    // Verifica se encontrou algum registro
    if (empty($resultado)) {
        // Nenhum registro foi encontrado =< o usuário é inválido
        return false;

    } else {
        // O registro foi encontrado =< o usuário é valido

        // Definimos dois valores na sessão com os dados do usuário
        $_SESSION['usuarioID'] = $resultado['id_login']; // Pega o valor da coluna 'id do registro encontrado no MySQL
        $_SESSION['usuario'] = $nusuario;
        return true;
    }
}

function alerta($mensagem, $caminho){  
echo "<script>alert('".$mensagem."');top.location.href='".$caminho."';</script>"; 
global $_SG;

    // Remove as variáveis da sessão (caso elas existam)
    unset($_SESSION['usuarioID'],$_SESSION['usuario'],$_SESSION['nomeUserSession'],$_SESSION['perfilSession']);
 
}
?>