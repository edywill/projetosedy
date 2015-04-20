<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
$email="priscila@cpb.org.br";
$nome=$_POST['user_ci'];
$controle="W-Aprovação Ordem de Compra Web";
$ci=$_POST['id_ci'];
$desc=$_POST['desc_ci'];
//$qtd=$_POST['qtd'];
//$prz=$_POST['prz'];
enviaEmailOc($email,$nome,$controle,$ci,$desc);
//Enviar email com nova senha
function enviaEmailOc($emailUser,$nomeUser,$controleAtual,$numCi,$descMaterial){
	//destinatario
        $para3 = $emailUser;
        //para o envio em formato HTML
        $headers3 = "MIME-Version: 1.0";
        $headers3 = "Content-type: text/html; charset=utf-8\r\n";
        //endereço do remitente
        $headers3 .= "From: cigam@cpb.org.br";


        //corpo do email
        $mensagem3 = "Caro Usuário ";
        $mensagem3 .= ".<br \><br \>Favor analisar a Ordem de Compra numero ".$numCi.", para aprovação no Cigam . 
<br><br><strong>OC Aprovada por:</strong> ".$nomeUser."<br> 
<strong>Controle Atual :</strong>".$controleAtual." <br>
<strong>Material:</strong>".$descMaterial." <br>
Obrigado!
";
        //envia a senha para o email com a função mail
        $envia3 = mail($para3,"OC nº".$numCi." - Aprovada via WEB",$mensagem3,$headers3,"-r"."cigam@cpb.org.br");
        
        if($envia3){
			?>
       <script type="text/javascript">
	     alert("Email Enviado com Sucesso!");
         window.history.go(-3);
       </script>
       <?php
			}else{
				alerta("E-mail nao enviado ao usuario. Tente novamente!","javascript:history.back(-2)");
				}
	}
//Função Alerta
function alerta($mensagem, $caminho){  
echo "<script>alert('".$mensagem."');top.location.href='".$caminho."';</script>"; 
global $_SG;
}
?>
</body>
</html>