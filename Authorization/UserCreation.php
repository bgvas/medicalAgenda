<?php 
ob_start();
include_once '../EmailService.php';
?>


<!DOCTYPE html>
<html>
<title>User Registration</title>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="description" content="My Project, for www univercity class" >
    <meta name="author" content="Vasileios Georgoulas">
    <meta name="keywords" content="HTML,CSS,JavaScript, PHP">
<link rel="stylesheet" href="../Decorations/style.css">
    <script src="../MyJavaScriptFile.js"></script>
</head>
<body class="body-color">
    <div class="box">
        <div class="bigTitle">
            <p style="font-size: 50px"><h3 style="text-align:center; color:black">Registration</h3></p>
            <div class="text-center">
                <img src="../Images/email.png" alt="mail" width="100" height="100"/>
            </div>
            <h5>We have send you an email with activation link.</h5>
            <p><a href="./Login.html" style="color:DarkBlue">Return to login page</a></p>
        </div>  
    </div>
</body>
</html> 



<?php ob_end_flush(); ?>