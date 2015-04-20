<?php 
require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->isSMTP();              // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'edywill';                            // SMTP username
$mail->Password = '110463';// SMTP password

$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

//$mail->From = 'edy@cpb.org.br';
//$mail->FromName = 'Edy William';
$mail->SetFrom('edywill@hotmail.com','Edy Teste');
$mail->addAddress('edy@cpb.org.br', 'Edy');  // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('noreply@gmail.com', 'Edy');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Aqui é o título';
$mail->Body    = 'Texto negrito <b>Texto em negrito!</b>';
$mail->AltBody = 'Texto sem formatação';

if(!$mail->send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}

echo 'Message has been sent';
?>