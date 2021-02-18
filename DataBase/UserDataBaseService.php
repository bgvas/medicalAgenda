<?php
    ob_start();
    include_once "Connect.php";
   
    var_dump("Users");


  function getAllUsers(){
    
    $connect = ConnectToDB();
        
    $sql = "SELECT * FROM user";

    $allUsers = [];
   
    if($result = mysqli_query($connect, $sql)){
        while($row = mysqli_fetch_array($result)){
            if($row['role'] == 'admin'){
                continue;
            }
            $list = new stdClass();
        
            $list->id = $row['id'];
            $list->username = $row['username'];
            $list->createdat = $row['createdat'];
            $list->modifiedat = $row['modifiedat'];
            $list->fname = $row['firstname'];
            $list->lname = $row['lastname'];
            $list->role = $row['role'];
            $list->email = $row['email'];
            $list->active = $row['isactive'];

            $allUsers[] = $list;
          
        }
        return $allUsers;
    }
    DisconnectFromDB($connect);
    return -1;
}
  
             
    function CheckUser($username, $password){
        $connect = ConnectToDB();
        
        $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
        if($result = mysqli_query($connect, $sql)){
            if(mysqli_num_rows($result) <= 0){
                exit;
                DisconnectFromDB($connect);
                return false;
                
            }
               else{
                DisconnectFromDB($connect);
                return true;
               }
        }
        else{
            DisconnectFromDB($connect);
            return false;
        }
    }

    function GetUserIdByUsernameAndPassword($username, $password){
        $connect = ConnectToDB();
        $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
        if($result = mysqli_query($connect, $sql)){
            while($row = mysqli_fetch_array($result)){
                return $row['id'];
                DisconnectFromDB($connect);
                exit;
            }
        }
        else{
            DisconnectFromDB($connect);
            return -1;
            exit;
        }
    }

    function GenerateToken($userId){
        $connect = ConnectToDB();
        $dateNow = date('Y-m-d H:i:s');
        $token = bin2hex(openssl_random_pseudo_bytes(64));
        $sql = "UPDATE user SET token = '$token', modifiedat = '$dateNow' WHERE id = $userId";
        if(mysqli_query($connect, $sql)){
            return $token;
        }
        DisconnectFromDB($connect);
        return -1; 
    }

    function GetUserIdByToken($token){
       
        $connect = ConnectToDB();
        $sql = "SELECT * FROM user WHERE token='$token'";
        if($result = mysqli_query($connect, $sql)){
            while($row = mysqli_fetch_array($result)){
                return $row['id'];
                DisconnectFromDB($connect);
                exit;
            }
        }
        else{
            DisconnectFromDB($connect);
            return "no sql run";
            exit;
        }
    }

    function GetUserIdByEmail($email){
        $connect = ConnectToDB();
        $sql = "SELECT * FROM user WHERE email='$email'";
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

    function GetUserByToken($token){
        $connect = ConnectToDB();
        $user = new stdClass();
      
        $sql = "SELECT * FROM user WHERE token='$token'";
        if($result = mysqli_query($connect, $sql)){
            while($row = mysqli_fetch_array($result)){
               $user->id = $row['id'];
               $user->username = $row['username'];
               $user->fname = $row['firstname'];
               $user->lname = $row['lastname'];
               $user->role = $row['role'];
               $user->patientId = $row['patientId'];
               $user->email = $row['email'];
            }
            return $user;
        }
        DisconnectFromDB($connect);
        return -1;
    }

    function GetUserTokenByEmail($email){
        $connect = ConnectToDB();
        $sql = "SELECT * FROM user WHERE email='$email'";
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
        $sql = "SELECT * FROM user WHERE email='$email'";
        if($result = mysqli_query($connect, $sql)){
            if(mysqli_num_rows($result) <= 0){
                return false;
            }
            else return true;
        }
        DisconnectFromDB($connect);
        return -1;
    }

    function SaveUnRegistratedUser($username, $email, $hashingPassword, $firstname, $lastname, $role, $patientId){
        $connect = ConnectToDB();
        $dateNow = date('Y-m-d H:i:s');
        $token = bin2hex(openssl_random_pseudo_bytes(64));
        if($patientId == ""){
                $sql = "INSERT INTO user(username, email, password, firstname, lastname, token, isactive, role)VALUES ('$username','$email', '$hashingPassword', '$firstname', '$lastname', '$token', 0, '$role')";
        }
        else{
            $sql = "INSERT INTO user(username, email, password, firstname, lastname, token, isactive, role, patientId)VALUES('$username','$email', '$hashingPassword', '$firstname', '$lastname', '$token', 0, '$role', $patientId)"; 
        }
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

    function GetFirstnameAndLastnameByUserId($userId){
        $connect = ConnectToDB();
        $sql = "SELECT * FROM user WHERE id='$userId'";
        if($result = mysqli_query($connect, $sql)){
            while($row = mysqli_fetch_array($result)){
                $name = new stdClass;
                $name->Firstname = $row['firstname'];
                $name->Lastname = $row['lastname']; 
                return $name;
                exit;
            }
        }
        else{
            DisconnectFromDB($connect);
            return false;
            exit;
        }
    }

    function GetUserByUserId($userId){
        $connect = ConnectToDB();
        $sql = "SELECT * FROM user WHERE id='$userId'";
        if($result = mysqli_query($connect, $sql)){
            while($row = mysqli_fetch_array($result)){
                $name = new stdClass;
                $name->Fname = $row['firstname'];
                $name->Lname = $row['lastname'];
                $name->Username = $row['username'];
                $name->Role = $row['role'];
                $name->Email = $row['email'];  
                return $name;
                exit;
            }
        }
        else{
            DisconnectFromDB($connect);
            return false;
            exit;
        }
    }

    function UpdateUserProfile($user){
        $connect = ConnectToDB();
        $dateNow = date('Y-m-d H:i:s');
        $userId = $user->userId;
        $fname = $user->fname;
        $lname = $user->lname;
        $email = $user->email;
       
        if($user->password != null){
            $password = Hashing($user->password, $userId);
            $sql = "UPDATE user SET 
            password ='$password', 
            modifiedat = '$dateNow',
            firstname = '$fname',
            lastname = '$lname',
            email = '$email'

            WHERE id = '$userId'";
            $result = mysqli_query($connect, $sql);
           // $refreshToken = GenerateToken($userId);
            if($result == true){// && $refreshToken != -1){
                return true;
            }
            else return false;
        }else{
            $sql = "UPDATE user SET 
            modifiedat = '$dateNow',
            firstname = '$fname',
            lastname = '$lname',
            email = '$email' 
            WHERE id = '$userId'";
            $result = mysqli_query($connect, $sql);
            //$refreshToken = GenerateToken($userId);
            if($result == true){// && $refreshToken != -1){
                return true;
            }
            else return false;
        }

    }

   /* function CheckIfPatientIdExist($patientId){
        $connect = ConnectToDB();
        $sql = "SELECT * FROM pattient WHERE id = $patientId";
        if($result = mysqli_query($connect, $sql)){
            if(mysqli_num_rows($result) <= 0){
              
                exit;
                return false;
            }
            else return true;
        } 
        exit;
    }
*/
    ob_end_flush();

   
?>


