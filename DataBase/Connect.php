<?php
    


    function ConnectToDB(){

        $host = "fdb3.freehostingeu.com";
        $user = "2084374_myprojectdb";
        $password = "Pfizer09";
        $database = "2084374_myprojectdb";
        
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