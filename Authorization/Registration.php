<?php

    include '../DataBase/UserDataBaseService.php';
    
    if(!isset($_POST["password"]) || !isset($_POST["username"])){
        header("Location: Signup.html?result=emptyfields");
        exit;
    }
    
    $password = $_POST["password"];
    $email = $_POST["username"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];

    $userExists = CheckUserByEmail($email);
    if($userExists < 0){
        header("Location: Signup.html?result=error");
        exit;
    }
    if($userExists == true){
        header("Location: Signup.html?result=userexists");
        exit;
    }

    if(!SaveUnRegistratedUser($email, $password, $firstname, $lastname)){
        header("Location: Signup.html?result=error");
        exit;
    }







?>