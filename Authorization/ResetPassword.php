<?php
    include '../DataBase/UserDataBaseService.php';
    include '../EmailService.php';
    if(GetUserIdByEmail($_POST["email"]) <= 0){
        header("Location: Login.html?result=errorEmail");
        exit;
    }
    $email = $_POST["email"];
    $token = GetUserTokenByEmail($email);
    //if($token <= 0){
     //   header("Location: Login.html?result=errorEmail");
    //    exit;
    //}
    if(!SendForgotPasswordEmail($email, $token)){
        echo "<h3 style='color: red; text-align: center;' >Problem while sending email</h3>";
    }

?>

<!DOCTYPE html>
<html>
<title>Reset Password</title>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="description" content="My Project, for www univercity class" >
    <meta name="author" content="Vasileios Georgoulas">
    <meta name="keywords" content="HTML,CSS,JavaScript, PHP">
    <link rel="stylesheet" href="../style.css">
    <script src="../MyJavaScriptFile.js"></script>
</head>
<body>
        <div class="bigTitle">
            <h1>Restore Forgotten Password</h1>
            <img src="../Images/email.png" alt="mail" width="150" height="150"/>
            <h3>We have send you an email with a reset link.</h3>
            <h3>Please check your inbox.</h3>
            <h3>If you didn't receive it, press button to resend.</h3>
            <p><input type="button" class="buttons" onclick="resendEmail($email, $token)" value="Resend email..." /></p>
        </div>  
</body>
</html> 