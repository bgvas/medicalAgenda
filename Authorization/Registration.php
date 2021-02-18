<?php

    ob_start();
    include_once '../DataBase/UserDataBaseService.php';
    include_once '../DataBase/PatientDataBaseService.php';
    include_once '../EmailService.php';
    
    function Hashing($string){

        $salt = "MyEncryptionKey";
        $enc_key = bin2hex($string);
        $enc_salt = bin2hex($salt);
        $token = hash('sha512', $enc_key.$enc_salt);
        return $token;
    }


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
        $email = $_POST["email"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $username = $_POST["username"];
        $role = $_POST["role"];
       
        if($role == "visitor" && $_POST["patientId"] == ""){
            header("Location: Signup.html?result=emptyfields");
            exit;
        }
        else if($role == "visitor" && $_POST["patientId"] != ""){
           
            $patientId = $_POST["patientId"];
            $patientIdExist = CheckIfPatientIdExist($patientId);
            if(!$patientIdExist){
                header("Location: Signup.html?result=patientIdDoesNotExist");
                exit; 
            }
            
        }
   
        $userExists = CheckUserByEmail($email);
        if($userExists == true){
            header("Location: Signup.html?result=userexists");
            exit;
        }

     
           
        $hashingPassword = Hashing($password);
        if(!SaveUnRegistratedUser($username, $email, $hashingPassword, $firstname, $lastname, $role, $patientId)){
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
            RegisterUserEmail($email, $token);
            header("Location: UserCreation.php");
            exit;
        }

     
    }

    ob_end_flush();




?>