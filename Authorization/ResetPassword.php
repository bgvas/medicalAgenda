<?php
    ob_start();
    include '../DataBase/UserDataBaseService.php';
    include '../EmailService.php';
   
    if(!isset($_POST['email'])){
        header("Location: Login.html?result=errorEmail");
        exit;
    }

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
    <link rel="stylesheet" href="../Decorations/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../MyJavaScriptFile.js"></script>
</head>
<body class="body-color">
    <div class="box">
        <div class="bigTitle">
        <p style="font-size: 50px; color:black"><h3 style="text-align:center">Reset password</h3></p>
            <?php 
                    if($resultOfSend){
                        echo"<p style='color:DarkGreen;'><strong>Ok. Delivered</strong></p>";
                    }
                    else if(!$resultOfSend){
                        echo"<p style='color:Red;'><strong>Problem while sending email. Try again</strong></p>";
                    }
            ?>
            <div class="text-center">
                <img src="../Images/email.png" alt="mail" width="100" height="100"/>
            </div>
            <div class="bigTitle text-center">
                <h5>We have send you an email with a reset link.</h5>
                <h6>If you didn't receive it, press button to resend.</h6>
                <form method="POST" action="./ResetPassword.php" name="resendEmail">
                    <input type="hidden" name="email" value="<?php echo $email; ?>" />
                    <p><input type="submit" class="bot bot-secondary" value="Resend"/></p>
                </form>
                <p><a href="./Login.html" style="color:blue">Return to login page</a></p>
            </div>
        </div>  
    </div>

</body>
</html> 

<?php ob_end_flush();?>