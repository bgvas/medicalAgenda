<?php
    include 'Connect.php';

        
    function CheckUser($username, $password){
        $connect = ConnectToDB();
        $sql = "Select * from user where username='$username' and password='$password'";
        if($result = mysqli_query($connect, $sql)){
            if(mysqli_num_rows($result) <= 0){
                return false;
            }
               else return true;
        }
        DisconnetFromDB($connect);
        return false;
    }

    function GetUserIdByUsernameAndPassword($username, $password){
        $connect = ConnectToDB();
        $sql = "Select * from user where username='$username' and password='$password'";
        if($result = mysqli_query($connect, $sql)){
            if(mysqli_num_rows($result) <= 0){
                return -1;
            }
            while($row = mysqli_fetch_array($result)){
                return $row['id'];
            }
        }
        DisconnetFromDB($connect);
        return -1;
    }

    function GenerateToken($userId){
        $token = bin2hex(openssl_random_pseudo_bytes(64));
        $connect = ConnectToDB();
        $sql = "update user set token='$token' where id='$userId'";
        if($result = mysqli_query($connect, $sql)){
            return $token;
        }
        DisconnetFromDB($connect);
        return -1; 
    }

    function GetUserIdByToken($token){
        $connect = ConnectToDB();
        $sql = "Select * from user where token='$token'";
        if($result = mysqli_query($connect, $sql)){
            if(mysqli_num_rows($result) <= 0){
                return -1;
            }
            while($row = mysqli_fetch_array($result)){
                return $row['id'];
            }
        }
        DisconnetFromDB($connect);
        return -1;
    }

    function GetUserIdByEmail($email){
        $connect = ConnectToDB();
        $sql = "Select * from user where username='$email'";
        if($result = mysqli_query($connect, $sql)){
            if(mysqli_num_rows($result) <= 0){
                return -1;
            }
            while($row = mysqli_fetch_array($result)){
                return $row['id'];
            }
        }
        DisconnetFromDB($connect);
        return -1;
    }

    function GetUserTokenByEmail($email){
        $connect = ConnectToDB();
        $sql = "Select * from user where username='$email'";
        if($result = mysqli_query($connect, $sql)){
            if(mysqli_num_rows($result) <= 0){
                return -1;
            }
            while($row = mysqli_fetch_array($result)){
                return $row['token'];
            }
        }
        DisconnetFromDB($connect);
        return -1;
    }

?>