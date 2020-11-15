<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';



function SendEmail($toEmail, $bodyMessage, $subjectMessage){
    
    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->SMTPOptions = array(
       'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
       )
   );
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->Username = "medical.agenda.crm@gmail.com";
    $mail->Password = "Sofitel05";
    //$mail->SMTPDebug = 4;
    $mail->SetFrom("medical.agenda.crm@gmail.com", "Medical Agenda");
    $mail->Subject = $subjectMessage;
    $mail->isHTML(true);
    $mail->Body = $bodyMessage;
    $mail->AddAddress($toEmail);
    
    return $mail->Send();
    
}

function RegisterUserEmail ($emailtoUser, $token){

    $subject = "User regitration email";
    $body="<div></div>";

    return SendEmail($emailtoUser, $body, $subject);
}

function SendForgotPasswordEmail($emailtoUser, $token){

    $subject = "Reset Password";
    $body= "
    <!DOCTYPE html>
        <html>
            <head></head>
            <style>
                body{
                    background-color: Gainsboro;
                    width:auto;
                }
                .myDiv {
                    width: auto;
                    height: 50px;
                    padding: 25px;
                    font-size: 30px;
                    text-align: center;
                    color: Blue;
                    border: 5px outset grey;
                    background-color: lightblue;    
                }
                .messBody{
                    background-color: Gainsboro;
                    font-size: 25px; 
                    color: Blue;
                    display: block;
                    text-align: center;
                    padding: 30px;
                }
            </style>
            <body>
                <div class='myDiv'>Medical Agenda</div>
                <div class ='messBody'>
                    <p style='font-size: 15px;'>
                        <a href='https://medicalagenda.000webhostapp.com/Authorization/SetNewPassword.php?token=$token'>Reset yout password!</a>
                    </p>
                </div>
            </body>
        </html>";
  

    return SendEmail($emailtoUser, $body, $subject);
}
?>
