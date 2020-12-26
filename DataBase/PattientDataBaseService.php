<?php
    Include_once "Connect.php";
        

    function GetNumberOfPatientsByUserId($userId){
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

    function GetAverageAgeOfPatientsByUserId($userId){
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
        
            $patients = array();
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
                
                            
                $patients[] = $pat;
            }
            return $patients;
            DisconnectFromDB($connect);
            exit;
        }
        
        return false;
        DisconnectFromDB($connect);
        exit;
    }
    

    function GetPatientsAgeAnalysis($userId){
        $connect = ConnectToDB();
        $a18To30 = 0;
        $a31To50 = 0;
        $a51To70 = 0;
        $a70plus = 0;
        $sql = "SELECT * FROM pattient WHERE userid = '$userId'";
        if($result = mysqli_query($connect, $sql)){
        
            $patients = new stdClass();
            while($row = mysqli_fetch_array($result)){
                if($row['age'] >= 18 && $row['age'] < 31){
                    $a18To30++;
                    continue;
                }
                else if($row['age'] < 51){
                    $a31To50++;
                    continue;
                }
                else if($row['age'] <= 70 ){
                    $a51To70++;
                    continue;
                }
                else if($row['age'] > 70){
                    $a70plus++;
                    continue;
                }
            }
           
            $patients->a18To30 = $a18To30;
            $patients->a31To50 = $a31To50;
            $patients->a51To70 = $a51To70;
            $patients->a70plus = $a70plus;
            
            return $patients;
            
            DisconnectFromDB($connect);
            exit;
        }
        
        return false;
        DisconnectFromDB($connect);
        exit;
    }

    function GetPatientByUserIdAndPatientId($userId, $id){
        $connect = ConnectToDB();
       
        $sql = "SELECT * FROM pattient WHERE userid = '$userId' AND  id = $id";
        if($result = mysqli_query($connect, $sql)){
            $pat = new stdClass();
            //$patients = array();
            while($row = mysqli_fetch_array($result)){
                
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
                $pat->MedicalBio = $row['medicalBio'];
                $pat->ZipCode = $row['zipcode'];
                $pat->Profession = $row['profession'];

                            
                //$patient[] = $pat;
            }
            return $pat;//$patients;
            DisconnectFromDB($connect);
            exit;
        }
        
        return false;
        DisconnectFromDB($connect);
        exit;
    }
?>