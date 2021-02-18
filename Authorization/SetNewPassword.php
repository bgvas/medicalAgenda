<?php
    ob_start();
    include_once '../DataBase/UserDataBaseService.php';
    include_once '../Hellpers/AuthorizationHelper.php';
    
    if(!isset($_POST["password"])){
        if(!isset($_GET["token"])){
           header("Location: Login.html?result=errorEmail");
           exit;
        }
        $token = $_GET["token"];
        $userId = GetUserIdByToken($token);
        if($userId <= 0){
            header("Location: Login.html?result=usernotfound");
            exit;
        }
    }
    else{
        if(!isset($_POST["userId"]) || $_POST['userId'] <= 0){
            header("Location: Login.html?result=usernotfound");
            exit;
        }
        $userId = $_POST['userId'];
        $password = $_POST["password"];
        if(!UpdatePassword(Hashing($password), $userId)){
            echo "<p align='center' style='color:Red;'>Error While Updating Password!!!</p>";
        }
        else{
            header("Location: Login.html?result=updated");
            exit;
        }
    }

?>

<!DOCTYPE html>
<html>
<title>Change password</title>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<meta name="description" content="My Project, for www univercity class" >
<meta name="author" content="Vasileios Georgoulas">
<meta name="keywords" content="HTML,CSS,JavaScript, PHP">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<link rel="stylesheet" href="../Decorations/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<script src="../MyJavaScriptFile.js"></script>
</head>
    <body class="body-color">
        <div class="box">
            <div class="bigTitle">
                <p style="font-size: 50px; color:black; text-align:center" >
                    Set your new password
                </p>
                <form action="../Authorization/SetNewPassword.php" name="setnewpassword" method="POST">
                    <p>(Min 6 digits, 1 capital letter, 1 number)</p>
                    <p style="text-align:left; padding-left:30px">Password</p>
                    <p><input type="text" required name="password" class="inputFields" required placeholder="Password" id="pass" onkeyup="passwordValidation()" ></p>
                    <p style="text-align:center"id="passwordvalidator"></p>
                    <p style="text-align:left; padding-left:30px">Type again</p>
                    <p><input type="text" required name="password2" class="inputFields" required placeholder="Retype Password" id="re-pass" onkeyup="equality()"></p>
                    <p style="text-align:center" id="checkEquality"></p>
                    <input type="hidden" value="<?PHP echo $userId; ?>" name="userId"/>
                    <p><input type="submit" id="sbutton" class="btn btn-primary" value="Save password" disabled="true"/></p>
                </form>
            </div>
        </div>
    </body>
<!--
    <body onload="Responses()" class="body-color">
    <div class="box">
        <div class="bigTitle">
            <p style="font-size: 50px; color:black">Sign in</p>
             <h5><p id="messages"></p></h5>
             <form action="../DashBoard.php" name="loginForm" method="POST">
                <p style="text-align: left; padding-left: 10%;">Username</p>
                <p><input type="text" required name="username" class="inputFields" placeholder="Username" id="username"></p>
                <p style="text-align: left; padding-left: 10%;">Password</p>
                <p><input type="password" required name="password" class="inputFields" placeholder="Password" id="password" onkeyup="passwordValidator()"></p>
                <p><input type="submit" class="buttons" value="Press to Login..." /></p>
            </form>
            <p><a href="ForgotPassword.html" class="linkHref">Forgot your password?</a></p>
            <p><a href="Signup.html" class="linkHref">Sign up if you are new here.</a></p>
        </div>
        <p><h6>(doctor=> username = 'doctor', password = 'A11111')</h6></p>
        <p><h6>(admin=> username = 'admin', password = 'A11111')</h6></p>
        <p><h6>(visitor=> username = 'visitor', password = 'A11111')</h6></p>
    </div>
</body>
-->





</html> 
<?php ob_end_flush();?>