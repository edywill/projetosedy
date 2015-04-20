<?php

include "conectLogin.php";
//include "function.php";
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
	// Utiliza uma função criada no seguranca.php pra validar os dados digitados
    if (validaUsuario($usuario, $senha) == true) {
        // O usuário e a senha digitados foram validados, manda pra página interna
		if(!empty($_POST['senhanova'])){
			$sqlUpd=mysql_query("UPDATE usuarios SET pass='".trim($_POST['senhanova'])."' WHERE user='".$usuario."'") or die(mysql_error());
			$sqlUpdForum=mysql_query("UPDATE forum_users SET password='".md5(trim($_POST['senhanova']))."' where username='".$usuario."'") or die(mysql_error());
			if($sqlUpd && $sqlUpdForum){
		      $mensagem="Senha Atualizada com Sucesso.";
			  $caminho="index.php";
			  echo "<script>alert('".$mensagem."');top.location.href='".$caminho."';</script>";
			 }
			}else{
			header("Location: index.php");
			}
    } else {
        // O usuário e/ou a senha são inválidos, manda de volta pro form de login
        // Para alterar o endereço da página de login, verifique o arquivo seguranca.php
       alerta("Usuario/senha invalido ou Nao validado pela associacao.", "login.php");//Chamada da mensagem  
    }
}

//Valida Usuario

function validaUsuario($usuario, $senha) {
    global $_SG;

    $cS = ($_SG['caseSensitive']) ? 'BINARY' : '';

    // Usa a função addslashes para escapar as aspas
    $nusuario = addslashes($usuario);
    $nsenha = addslashes($senha);

    // Monta uma consulta SQL (query) para procurar um usuário
    $sql = "SELECT `id`, `user`,`perfil` FROM `".$_SG['tabela']."` WHERE `user` = '".$nusuario."' AND  upper(`pass`) = upper('".$nsenha."') AND status<>'N' LIMIT 1";
    $query = mysql_query($sql);
    $resultado = mysql_fetch_assoc($query);

    // Verifica se encontrou algum registro
    if (empty($resultado)) {
        // Nenhum registro foi encontrado =< o usuário é inválido
        return false;

    } else {
        // O registro foi encontrado =< o usuário é valido

        // Definimos dois valores na sessão com os dados do usuário
        $_SESSION['usuarioID'] = $resultado['id']; // Pega o valor da coluna 'id do registro encontrado no MySQL
        $_SESSION['usuarioNome'] = $resultado['nome']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
		$_SESSION['usuarioPerfil'] = $resultado['perfil'];
        // Verifica a opção se sempre validar o login
        if ($_SG['validaSempre'] == true) {
            // Definimos dois valores na sessão com os dados do login
            $_SESSION['usuarioLogin'] = $usuario;
            $_SESSION['usuarioSenha'] = $senha;
        }

        return true;
    }
}

function alerta($mensagem, $caminho){  
echo "<script>alert('".$mensagem."');top.location.href='".$caminho."';</script>"; 
global $_SG;

    // Remove as variáveis da sessão (caso elas existam)
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
 
}

?>