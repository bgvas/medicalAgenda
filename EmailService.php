<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


function SendForgotPasswordEmail($emailtoUser, $token){

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.google.com';
    $mail->Port = '465';
    $mail->isHTML();
    $mail->Username = 'medical.agenda.crm@gmail.com';
    $mail->Password = 'Sofitel04';
    $mail->SetFrom('medical.agenda.crm@gmail.com');
    $mail->Subject = 'Hello World';
    $mail->Body = 'A test email';
    $mail->AddAddress('b_gvas@yahoo.gr');
    
    $mail->Send();
}
?>
