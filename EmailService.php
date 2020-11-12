<?php
$sendGridKey = "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";


function SendForgotPasswordEmail($emailtoUser, $token){
    
    ini_set('SMTP', 'ssl::smtp.gmail.com');
    ini_set('display_errors', 1);
    ini_set('smtp_port',465);
    ini_set('auth_username', 'medical.agenda.crm@gmail.com');
    ini_set('auth_password', 'Sofitel04');
    ini_set("sendmail_from", "medical.agenda.crm@google.com");
    error_reporting( E_ALL );
    $from = "medical.agenda.crm@google.com";
    $to = "b_gvas@yahoo.gr";
    $subject = "PHP Mail Test script";
    $message = "This is a test to check the PHP Mail functionality";
    $headers = "From:" . $from;
    if(mail($to,$subject,$message, $headers)){
        return true;
    }
    else return false;
}
?>
