<?php
if(basename($_SERVER["PHP_SELF"])=='$pagina'){
die("<script>alert('Sem permissão de acesso !')</script>\n<script>window.location=('index.php')</script>");
}
include 'phpmailer\PHPMailerAutoload.php';

function enviaEmail($dest,$nomeDest,$assunto,$msg,$confirmacao,$endRet){
//echo $dest."/".$nomeDest."/".$assunto."/".$msg."/".$confirmacao."/".$endRet;

$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
//$mail->Host = 'mail.gmail.com';  // Specify main and backup server
$mail->SMTPDebug=0;
$mail->SMTPAuth = true;                               // Enable SMTP authentication

$mail->Host = 'mobile.dnit.gov.br';
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
//$mail->Port = 25;
$mail->Username = 'dnit.movel';                            // SMTP username
$mail->Password = 'Inovacao';                           // SMTP password
$mail->From = 'dnit.movel@dnit.gov.br';
$mail->FromName = 'DNIT Movel';
$mail->addAddress($dest, $nomeDest);  // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('dnit.movel@dnit.gov.br', 'DNIT Movel');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = utf8_decode($assunto);
$mail->Body    = utf8_decode($msg);
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
return $mail->ErrorInfo;
}else{
	return 1;
	
  }
}
?>