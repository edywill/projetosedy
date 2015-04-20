<?php
$pagina="functionEmailRh.php"; //aqui colocariamos o nome da pagina.
if(basename($_SERVER["PHP_SELF"])=='$pagina'){
die("<script>alert('Sem permissão de acesso !')</script>\n<script>window.location=('index.php')</script>");
}
function enviaEmailRh($assunto,$mensagemHtml,$paginaRetorno,$paraQ,$dest,$cont){
$paginaRetorno='principal.php';
$paraQ='';
//date_default_timezone_set('Etc/UTC');

require 'phpmailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
//Tell PHPMailer to use SMTP
$mail->Charset = 'UTF-8';
$mail->isSMTP();
$mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = "smtp.cpb.org.br";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 587;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = "ciweb@cpb.org.br";
//Password to use for SMTP authentication
$mail->Password = "ciweb123";
//Set who the message is to be sent from
$mail->setFrom('ciweb@cpb.org.br', 'IntranetCPB');
//Set an alternative reply-to address
$mail->addReplyTo('ciweb@cpb.org.br', 'IntranetCPB');
//Set who the message is to be sent to
$contEmail=0;
$valida=0;
$mail->addAddress("sandra@cpb.org.br");
$mail->addAddress("neide.dantas@cpb.org.br");
$mail->addAddress("teresa@cpb.org.br");
//Set the subject line
$mail->Subject = utf8_decode($assunto);
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->IsHTML(true);
//$mail->msgHTML("Mensagem de texto");
//Replace the plain text body with one created manually
$mail->AltBody = utf8_decode($mensagemHtml).'\r\n';
$mail->Body = utf8_decode($mensagemHtml);
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.gif');

//send the message, check for errors
if (!$mail->send()) {
	 $valida=0;
	 //echo "Mailer Error: " . $mail->ErrorInfo;
	}else{
		$valida=1;
		  //echo "Message sent!";
}
if($valida==1){
	?>
       <script type="text/javascript">
       alert("Solicita\u00e7\u00e3o Alterada com Sucesso");
       window.location.href='home.php';
       </script>
       <?php
	}
}
/*
//enviaEmail('Teste','Mensagem de teste','edy@cpb.org.br','index.php','edywill@hotmail.com');
function enviaEmail($assunto,$mensagemHtml,$emailRetorno,$paginaRetorno,$paraQ){
// Este sempre deverá existir para garantir a exibição correta dos caracteres
$headers = "MIME-Version: 1.1\r\n";
 
// Para enviar o e-mail em formato texto com codificação de caracteres Europeu Ocidental (usado no Brasil)
//$headers .= "Content-type: text/plain; charset=utf-8\n";
  
// Para enviar o e-mail em formato HTML com codificação de caracteres Unicode (Usado em todos os países)
$headers .= "Content-type: text/html; charset=utf-8\r\n";
 
// Para enviar o e-mail em formato HTML com codificação de caracteres Unicode (Usado em todos os países)
$headers .= "From: CPB - CIGAM <".$emailRetorno.">\r\n";

// E-mail que receberá a resposta quando se clicar no 'Responder' de seu leitor de e-mails
$headers .= "Reply-To: ".$emailRetorno."\r\n";
$headers .= "Return-Path: ".$emailRetorno."\r\n";
$envio = mail($paraQ, $assunto, $mensagemHtml, $headers,"-r".$emailRetorno);
//$envio = mail($paraQ, $assunto, $mensagemHtml, $headers,$emailRetorno);
if($envio){
	    ?>
       <script type="text/javascript">
       alert("Email enviado com sucesso!");
       window.location.href='<?php echo $paginaRetorno; ?>';
       </script>
       <?php
	}else{
		?>
       <script type="text/javascript">
       alert("CI Alterada. Ocorreu um erro ao Enviar o Email!");
       window.location.href='<?php echo $paginaRetorno; ?>';
       </script>
       <?php
		}
}

*/
?>