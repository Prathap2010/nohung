<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';


$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";
$mail->SMTPDebug  = 1;  
$mail->SMTPAuth   = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port       = 587;
$mail->Host       = "mail.notioninfosoft.com";
$mail->Username   = "no-reply@notioninfosoft.com";
$mail->Password   = "08Oct@1991";

$mail->IsHTML(true);
$mail->AddAddress("test@mailinator.com");
$mail->SetFrom("no-reply@notioninfosoft.com", "Nohung");
$mail->Subject = "hali gyu";
$content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>";

$mail->MsgHTML($content); 
if(!$mail->Send()) {
  return true;
}






