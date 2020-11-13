<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

function SendForgotPasswordEmail($emailtoUser, $token){

    $mail = new PHPMailer();

    $mail->isSMTP();
    //$mail->SMTPOptions = array(
    //   'ssl' => array(
    //        'verify_peer' => false,
    //        'verify_peer_name' => false,
    //        'allow_self_signed' => true
    //   )
    // );
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->Username = "medical.agenda.crm@gmail.com";
    $mail->Password = "Sofitel05";
    //$mail->SMTPDebug = 4;
   
    $mail->SetFrom("medical.agenda.crm@gmail.com", "Medical Agenda");
    $mail->Subject = "Hello World";
    $mail->isHTML(true);
    $mail->Body = "<div style='color:blue;text-align:center; margin: 0 auto;'>
                   <h4>A test email</h4>
                   <a href=https://www.google.com?a=1>Reset</a>
                   </div>";
    $mail->AddAddress($emailtoUser);
    
    return $mail->Send();
    
}
?>
