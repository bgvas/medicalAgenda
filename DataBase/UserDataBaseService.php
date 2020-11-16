<?php
    include 'Connect.php';

        
    function CheckUser($username, $password){
        $connect = ConnectToDB();
        $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
        if($result = mysqli_query($connect, $sql)){
            if(mysqli_num_rows($result) <= 0){
                return false;
            }
               else return true;
        }
        DisconnectFromDB($connect);
        return false;
    }

    function GetUserIdByUsernameAndPassword($username, $password){
        $connect = ConnectToDB();
        $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
        if($result = mysqli_query($connect, $sql)){
            if(mysqli_num_rows($result) <= 0){
                return -1;
            }
            while($row = mysqli_fetch_array($result)){
                return $row['id'];
            }
        }
        DisconnectFromDB($connect);
        return -1;
    }

    function GenerateToken($userId){
        $token = bin2hex(openssl_random_pseudo_bytes(64));
        $connect = ConnectToDB();
        $sql = "UPDATE user SET token='$token' WHERE id='$userId'";
        if($result = mysqli_query($connect, $sql)){
            return $token;
        }
        DisconnectFromDB($connect);
        return -1; 
    }

    function GetUserIdByToken($token){
        $connect = ConnectToDB();
        $sql = "SELECT * FROM user WHERE token='$token'";
        if($result = mysqli_query($connect, $sql)){
            if(mysqli_num_rows($result) <= 0){
                return -1;
            }
            while($row = mysqli_fetch_array($result)){
                return $row['id'];
            }
        }
        DisconnectFromDB($connect);
        return -1;
    }

    function GetUserIdByEmail($email){
        $connect = ConnectToDB();
        $sql = "SELECT * FROM user WHERE username='$email'";
        if($result = mysqli_query($connect, $sql)){
            if(mysqli_num_rows($result) <= 0){
                return -1;
            }
            while($row = mysqli_fetch_array($result)){
                return $row['id'];
            }
        }
        DisconnectFromDB($connect);
        return -1;
    }

    function GetEmailByToken($token){
        $connect = ConnectToDB();
        $sql = "SELECT * FROM user WHERE token='$token'";
        if($result = mysqli_query($connect, $sql)){
            if(mysqli_num_rows($result) <= 0){
                return -1;
            }
            while($row = mysqli_fetch_array($result)){
                return $row['username'];
            }
        }
        DisconnectFromDB($connect);
        return -1;
    }

    function GetUserTokenByEmail($email){
        $connect = ConnectToDB();
        $sql = "SELECT * FROM user WHERE username='$email'";
        if($result = mysqli_query($connect, $sql)){
            if(mysqli_num_rows($result) <= 0){
                return -1;
            }
            while($row = mysqli_fetch_array($result)){
                return $row['token'];
            }
        }
        DisconnectFromDB($connect);
        return -1;
    }

    function UpdatePassword($password, $userId){
        $connect = ConnectToDB();
        $dateNow = date('Y-m-d H:i:s');
        $sql = "UPDATE user SET password ='$password', modifiedat = '$dateNow' WHERE id = '$userId'";
        $result = mysqli_query($connect, $sql);
        $refreshToken = GenerateToken($userId);
        if($result == true && $refreshToken != -1){
            return true;
        }
        else return false;

    }

    function CheckUserByEmail($email){
        $connect = ConnectToDB();
        $sql = "SELECT * FROM user WHERE username='$email'";
        if($result = mysqli_query($connect, $sql)){
            if(mysqli_num_rows($result) <= 0){
                return false;
            }
            else return true;
        }
        DisconnectFromDB($connect);
        return -1;
    }

    function SaveUnRegistratedUser($email, $password, $firstname, $lastname){
        $connect = ConnectToDB();
        $dateNow = date('Y-m-d H:i:s');
        $token = bin2hex(openssl_random_pseudo_bytes(64));
        $sql = "INSERT INTO user(username, password, createdat, firstname, lastname, token, isactive)VALUES
                                    ('$email', '$password', '$dateNow', '$firstname', '$lastname', '$token', 0)"; 
        if($result = mysqli_query($connect, $sql)){
            return true;
        }
        else{
            DisconnectFromDB($connect);
            return false;
        } 
    }

    function ActivateUnregistratedUser($userId){
        $connect = ConnectToDB();
        $dateNow = date('Y-m-d H:i:s');
        $sql = "UPDATE user SET isactive = 1, modifiedat = '$dateNow' WHERE id = '$userId'";
        $result = mysqli_query($connect, $sql);
        $refreshToken = GenerateToken($userId);
        if($result == true && $refreshToken != -1){
            return true;
        }
        else {
            DisconnectFromDB($connect);
            return false;
        }
    }
?>