<?php

    include '../DataBase/UserDataBaseService.php';
    include '../Hellpers/AuthorizationHelper.php';
    include '../EmailService.php';
    
    if(isset($_GET["token"])){
        $token = $_GET["token"];
        $userId = GetUserIdByToken($token);
        if($userId <= 0){
            header("Location: Signup.html?result=usernotfound");
            exit; 
        }
        $email = GetEmailByToken($token);
        if($email == null || $email == -1){
            header("Location: Signup.html?result=usernotfound");
            exit; 
        }
        
        ActivateUnregistratedUser($userId);
        header("Location: Login.html?result=usercreated");
        exit; 
    }

    
    if(!isset($_POST["password"]) || !isset($_POST["username"])){
        header("Location: Signup.html?result=emptyfields");
        exit;
    }
    else{
        $password = $_POST["password"];
        $email = $_POST["username"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];

        $userExists = CheckUserByEmail($email);
        if($userExists == true){
            header("Location: Signup.html?result=userexists");
            exit;
        }
           
        $hashingPassword = Hashing($password);
        if(!SaveUnRegistratedUser($email, $hashingPassword, $firstname, $lastname)){
            header("Location: Signup.html?result=errorProcess");
            exit;
        }

        $resultOfSend = null;
        $token = GetUserTokenByEmail($email);
        $mailResponse = RegisterUserEmail($email, $token);
        if(!$mailResponse){
            header("Location: Signup.html?result=registrationerror");
            exit; 
        }
        else{
            header("Location: UserCreation.php");
            exit;
        }


    }







?>