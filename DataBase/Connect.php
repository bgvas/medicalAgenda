<?php
    
    function ConnectToDB(){

        $host = "localhost";
        $user = "root";
        $password = "";
        $database = "myprojectdb";
        
        $connect = new mysqli($host, $user, $password, $database);
        if(!$connect){
            die("Error: Could not connect. ".mysqli_connect_error());
        }
        else return $connect;
    }
    
    
    function DisconnectFromDB($conn){
        
        $conn -> close();
   }
    
?>