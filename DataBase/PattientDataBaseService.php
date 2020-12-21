<?php
    Include_once "Connect.php";
        

    function GetNumberOfPattientsByUserId($userId){
        $connect = ConnectToDB();
        $sql = "SELECT * FROM pattient WHERE userid = '$userId'";
        if($result = mysqli_query($connect, $sql)){
            $total = mysqli_num_rows($result);
            if($total < 0){
                return -1;
                DisconnectFromDB($connect);
                exit;
            }
            return $total;
        }
        return -1;
        DisconnectFromDB($connect);
        exit;
    }


    function GetPatientsByUserId($userId){
        $connect = ConnectToDB();
       
        $sql = "SELECT * FROM pattient WHERE userid = '$userId' ORDER BY lastname ASC";
        if($result = mysqli_query($connect, $sql)){
        
            $pattients = array();
            while($row = mysqli_fetch_array($result)){
                
                $pat = new stdClass();
                $pat->Id = $row['id'];
                $pat->Lastname = $row['lastname'];
                $pat->Firstname = $row['firstname'];
                $pat->Gender = $row['gender'];
                $pat->Age = $row['age'];
                $pat->Address = $row['address'];
                $pat->Town = $row['town'];
                $pat->Phone = $row['phone'];
                $pat->Amka = $row['amka'];
                $pat->Insurance = $row['insurance'];
                $pat->CreatedAt = $row['createdat'];
                $pat->LastVisitAt = $row['lastvisitat'];
                $pat->UserId = $row['userid'];
                $pat->Email = $row['email'];
                            
                $pattients[] = $pat;
            }
            return $pattients;
            DisconnectFromDB($connect);
            exit;
        }
        
        return false;
        DisconnectFromDB($connect);
        exit;
    }

    function GetAverageAgeOfPattientsByUserId($userId){
        $connect = ConnectToDB();
        $sql = "SELECT AVG(age) AS averageage FROM pattient WHERE userid = '$userId'";
        if($result = mysqli_query($connect, $sql)){
            $row = mysqli_fetch_assoc($result);
            return intval($row['averageage']);
            DisconnectFromDB($connect);
            exit;
        }
        else{
            return false;
            DisconnectFromDB($connect);
            exit;
        }
    }

    function GetNumberOfFmalesAndMalesByUserId($userId){
        $connect = ConnectToDB();
        $males = 0;
        $fmales = 0;
        $totals = new stdClass;
        $maleSql = "SELECT * FROM pattient WHERE userid = '$userId' AND gender = 'Male'";
        if($maleResult = mysqli_query($connect, $maleSql)){
            $males = mysqli_num_rows($maleResult);
        }
        $fmaleSql = "SELECT * FROM pattient WHERE userid = '$userId' AND gender = 'Fmale'";
        if($fmaleResult = mysqli_query($connect, $fmaleSql)){
            $fmales = mysqli_num_rows($fmaleResult);
        }
        else{
            return -1;
            DisconnectFromDB($connect);
            exit;
        }
        $totals->Males = $males;
        $totals->Fmales = $fmales;
        return $totals;
        DisconnectFromDB($connect);
        exit;

    }

    function GetRecentPatientsByUserId($userId){
        $connect = ConnectToDB();
        $sql = "SELECT * FROM pattient WHERE userid = '$userId' AND lastvisitat = createdat ORDER BY lastname ASC";
        if($result = mysqli_query($connect, $sql)){
        
            $pattients = array();
            while($row = mysqli_fetch_array($result)){
                
                $pat = new stdClass();
                $pat->Id = $row['id'];
                $pat->Lastname = $row['lastname'];
                $pat->Firstname = $row['firstname'];
                $pat->Gender = $row['gender'];
                $pat->Age = $row['age'];
                $pat->Address = $row['address'];
                $pat->Town = $row['town'];
                $pat->Phone = $row['phone'];
                $pat->Amka = $row['amka'];
                $pat->Insurance = $row['insurance'];
                $pat->CreatedAt = $row['createdat'];
                $pat->LastVisitAt = $row['lastvisitat']; 
                $pat->UserId = $row['userid'];
                
                            
                $pattients[] = $pat;
            }
            return $pattients;
            DisconnectFromDB($connect);
            exit;
        }
        
        return false;
        DisconnectFromDB($connect);
        exit;
    }
    
?>