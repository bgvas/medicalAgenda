<?php
    include '../DataBase/UserDataBaseService.php';
    include '../Hellpers/AuthorizationHelper.php';
    
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
<link rel="stylesheet" href="../style.css">
<script src="../MyJavaScriptFile.js"></script>
</head>
    <body>
        <div class="bigTitle">
            <h1>Set your new password</h1>
            <form action="../Authorization/SetNewPassword.php" name="setnewpassword" method="POST">
                <p>(Min 6 digits, 1 capital letter, 1 number)</p>
                <p><input type="text" required name="password" class="inputFields" placeholder="Password" id="pass" onkeyup="passwordValidation()" ></p>
                <p style="text-align:center"id="passwordvalidator"></p>
                <p><input type="text" required name="password2" class="inputFields" placeholder="Retype Password" id="re-pass" onkeyup="equality()"></p>
                <p style="text-align:center" id="checkEquality"></p>
                <input type="hidden" value="<?PHP echo $userId; ?>" name="userId"/>
                <p><input type="submit" id="sbutton" class="buttons" value="Save password" disabled="true"/></p>
            </form>
        </div>
    </body>
</html> 
