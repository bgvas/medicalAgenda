<?php
    include '../DataBase/UserDataBaseService.php';
    include '../EmailService.php';
    
    $email = $_POST["email"];
    if(GetUserIdByEmail($email) <= 0){
        header("Location: Login.html?result=errorEmail");
        exit;
    }
       
    $token = GetUserTokenByEmail($email);
    if($token == null){
       header("Location: Login.html?result=errorEmail");
        exit;
    }
    $resultOfSend = null;
    $mailResponse = SendForgotPasswordEmail($email, $token);
    if($mailResponse){
        $resultOfSend = true;
    }
    else $resultOfSend = false;
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
            <h1>Restore Password</h1>
            <?php 
                    if($resultOfSend){
                        echo"<p style='color:Green;'>Ok. Delivered</p>";
                    }
                    else if(!$resultOfSend){
                        echo"<p style='color:Red;'>Problem while sending email. Try again</p>";
                    }
            ?>
            <img src="../Images/email.png" alt="mail" width="100" height="100"/>
            <h4>We have send you an email with a reset link.</h4>
            <h5>If you didn't receive it, press button to resend.</h5>
            <form method="POST" action="./ResetPassword.php" name="resendEmail">
                <input type="hidden" name="email" value="<?php echo $email; ?>" />
                <p><input type="submit" class="buttons" value="Resend"/></p>
            </form>
            <p><a href="./Login.html">Return to login page</a></p>
        </div>  
</body>
</html> 