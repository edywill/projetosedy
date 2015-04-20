<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
$email=$_POST['emailRem']; //email do usuário que aprovou
$nome=$_POST['user_ci']; //Usuário que aprovou
$dest=$_POST['dest_ci'];//Nome do destinatário da CI
$emailDest=$_POST['email_ci']; //Email do destinatário
$ci=$_POST['id_ci']; //Identificador da CI
$desc=$_POST['desc_ci']; //Descrição da CI
$contAnt=$_POST['controleAnterior']; //Controle anterior da CI
$descContAnt=$_POST['descControleAnterior']; //Descrição do controle anterior da CI
$contNovo=$_POST['controleNovo'];//Controle novo da CI
$descContNovo=$_POST['descControleNovo']; //Controle novo da CI
$pgRetorno=$_POST['retorno'];
//Enviar email
enviaEmailCI($email,$nome,$dest,$emailDest,$ci,$desc,$contAnt,$descContAnt,$contNovo,$descContNovo,$pgRetorno);
//Função de enviar e-mail
function enviaEmailCI($emailRem,$nomeRem,$destNome,$emailDestino,$ciNum,$descCi,$contAnterior,$descContAnterior,$contNovo1,$descContNovo1,$retornarPara){
	//destinatario
        $para3 = $emailDestino;
        //para o envio em formato HTML
        $headers3 = "MIME-Version: 1.0";
        $headers3 = "Content-type: text/html; charset=utf-8\r\n";
        //endereço do remitente
        $headers3 .= "From: ".$emailRem."";


        //corpo do email
        $mensagem3 = "Prezado (a) <strong>".strtoupper($destNome)."</strong>";
        $mensagem3 .= "<br \><br \>Favor analisar a C.I numero ".$ciNum.", para continuidade no processo . 
<br><br><strong>Ci Aprovada por:</strong> ".$nomeRem."<br> 
<strong>Controle Anterior:</strong>".$contAnterior."-".$descContAnterior." <br>
<strong>Controle Novo:</strong>".$contNovo1."-".$descContNovo1." <br>
<strong>Material:</strong>".$descCi." <br>
<br>
Atenciosamente<br><br>

<strong>".strtoupper($nomeRem)."</strong>
";
        //envia a senha para o email com a função mail
        $envia3 = mail($para3,"[CIGAM]CI nº".$ciNum." - ENCAMINHADA VIA WEB",$mensagem3,$headers3,"-r".$emailRem);
        
        if($envia3){
			?>
       <script type="text/javascript">
	     alert("Email Enviado com Sucesso!");
         <?php echo $retornarPara; ?>
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