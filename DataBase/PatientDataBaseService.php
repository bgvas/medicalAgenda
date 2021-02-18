<?php
    ob_start();
    Include_once "Connect.php";
        
    var_dump("db");
    function GetNumberOfPatientsByUserId($userId){
        $connect = ConnectToDB();
        $sql = "SELECT * FROM pattient WHERE userid = '$userId'";
        if($result = mysqli_query($connect, $sql)){
            $total = mysqli_num_rows($result);
            if($total < 0){
                DisconnectFromDB($connect);
                return -1;
            }
            return $total;
        }
        DisconnectFromDB($connect);
        return -1;
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

            DisconnectFromDB($connect);
            return $pattients;
        }
        DisconnectFromDB($connect);
        return false;
    }

    function GetAverageAgeOfPatientsByUserId($userId){
        $connect = ConnectToDB();
        $sql = "SELECT AVG(age) AS averageage FROM pattient WHERE userid = '$userId'";
        if($result = mysqli_query($connect, $sql)){
            $row = mysqli_fetch_assoc($result);

            DisconnectFromDB($connect);
            return intval($row['averageage']);
        }
        else{
            DisconnectFromDB($connect);
            return false;
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
            DisconnectFromDB($connect);
            return -1;
        }
        $totals->Males = $males;
        $totals->Fmales = $fmales;

        DisconnectFromDB($connect);
        return $totals;
    }

    function GetRecentVisitsByUserId($userId){
        $connect = ConnectToDB();
        $monthNow = date("m");
        $sql = "SELECT * FROM visits WHERE MONTH(visitAt) = ".$monthNow." AND userId = $userId";
        $i = 0;
        $ids = [];
        $dates = [];
        $patients = [];
        if($result = mysqli_query($connect, $sql)){ 
            while($row = mysqli_fetch_array($result)){
                $ids[] = $row['patientId'];
                $dates[] = $row['visitAt'];
            }
        }
        foreach($ids as $id){
            $pat = new stdClass();
            $sql = "SELECT * FROM pattient WHERE userId = $userId AND id = $id";
            if($result = mysqli_query($connect, $sql)){
                while($row = mysqli_fetch_array($result)){
                    $pat->Lastname = $row['lastname'];
                    $pat->Firstname = $row['firstname'];
                    $pat->Age = $row['age'];
                    $pat->Address = $row['address'];
                    $pat->Town = $row['town'];
                    $pat->Phone = $row['phone'];
                    $pat->Amka = $row['amka'];
                    $pat->VisitAt = $dates[$i];

                    $patients[] =  $pat;
                   
                }
            }
            $i++;
        }
        DisconnectFromDB($connect);
        return $patients;
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

            DisconnectFromDB($connect);
            return $patients;
        }
        DisconnectFromDB($connect);
        return false;
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
            DisconnectFromDB($connect);
            return $pat;//$patients;
        }

        DisconnectFromDB($connect);
        return false;
    }

    function UpdatePatientById($patientToUpdate){
        $connect = ConnectToDB();

        $sql = "UPDATE pattient
            SET lastname = '$patientToUpdate->Lastname', 
            firstname = '$patientToUpdate->Firstname',
            age = '$patientToUpdate->Age',
            address = '$patientToUpdate->Address',
            town = '$patientToUpdate->Town',
            phone = '$patientToUpdate->Phone',
            zipcode = '$patientToUpdate->ZipCode',
            profession = '$patientToUpdate->Profession',
            email = '$patientToUpdate->Email',
            medicalBio = '$patientToUpdate->MedicalBio'
            WHERE id = '$patientToUpdate->Id'";

        if($result = mysqli_query($connect, $sql)){
            DisconnectFromDB($connect);
            return true;
        }
        else{
            DisconnectFromDB($connect);
            return false;
        }
    }

    function DeletePatient($patientId){
        $connect = ConnectToDB();

        $sql = "DELETE FROM pattient WHERE id = '".$patientId."'";
        if($result = mysqli_query($connect, $sql)) {
            DisconnectFromDB($connect);
            return true;
        }
        else{
            DisconnectFromDB($connect);
            return false;
        }
    }

    function AddNewVisit($newVisit){
       
        $patientId = $newVisit->patientId;
        $userId = $newVisit->userId;
        $visitAt = $newVisit->visitAt;
        $glucose = $newVisit->glucose;
        $systolic = $newVisit->systolic;
        $diastolic = $newVisit->diastolic;
        $txtArea = $newVisit->comments;
       
        $connect = ConnectToDB();

        $sql = "INSERT INTO visits (userId, patientId, visitAt, systolic, diastolic, glucose, comments)VALUES
        ($userId, $patientId, '".$visitAt."', $systolic, $diastolic, $glucose, '".$txtArea."')";

        $updateSql = "UPDATE pattient SET lastvisitat = '".$visitAt."' WHERE id = ".$patientId."";
      
        if($result = mysqli_query($connect, $sql) && $updateResult = mysqli_query($connect, $updateSql)){
            DisconnectFromDB($connect);
            return true;
        }
        else{
            DisconnectFromDB($connect);
            return false;
        }
    }

    function AddNewPatient($newPatient){

        $userId = $newPatient->userId;
        $fname = $newPatient->fname;
        $lname = $newPatient->lname;
        $age = $newPatient->age;
        $gender = $newPatient->gender;
        $address = $newPatient->address;
        $zipCode = $newPatient->zipCode;
        $town = $newPatient->town;
        $email = $newPatient->email;
        $phone = $newPatient->phone;
        $insurance = $newPatient->insurance;
        $amka = $newPatient->amka;
        $createdAt = date("Y-m-d  H:m:s");
        $connect = ConnectToDB();



        $sql = "INSERT INTO pattient(firstname, lastname, age, address, gender, town, phone, insurance, amka, createdat, userid, email, zipcode, lastvisitat)
        VALUES ('".$fname."','".$lname."', $age,'".$address."', '".$gender."','".$town."', '".$phone."', '".$insurance."', '".$amka."', '".$createdAt."', $userId, '".$email."', $zipCode, '".$createdAt."')";
        
        if($result = mysqli_query($connect, $sql)){
            DisconnectFromDB($connect);
            return true;
        }
        else {
            DisconnectFromDB($connect);
            return false;
        }

    }

    function VisitsPerMonth($userId, $month){
        $connect = ConnectToDB();
        
        $sql = "SELECT * FROM visits WHERE MONTH(visitAt) = $month AND userId = $userId";
        if($result = mysqli_query($connect, $sql)){
            $total = mysqli_num_rows($result);
            return $total;
        }
        else return 0;

    }

    function TotalVisits($userId){
        $connect = ConnectToDB();
        
        $sql = "SELECT * FROM visits WHERE userId = $userId";
        if($result = mysqli_query($connect, $sql)){
            $total = mysqli_num_rows($result);
            return $total;
        }
        else return 0; 
    }

    function PatientsWithOneVisit($userId){
        $connect = ConnectToDB();
              
        $sql = "SELECT * FROM visits WHERE userId = $userId GROUP BY patientId having COUNT(*) < 2";
        if($result = mysqli_query($connect, $sql)){
            $total = mysqli_num_rows($result);
            return $total;
        }
        else return 0; 
    }

    function ReturningPatients($userId){
        
        return (TotalVisits($userId) - PatientsWithOneVisit($userId));
    }

    function GetListOfAllVisitsByUserId($userId){
        $connect = ConnectToDB();
      
        $sql = "SELECT * FROM visits WHERE userId = $userId ORDER BY visitAt";
        $i = 0;
        $ids = [];
        $dates = [];
        $patients = [];
        if($result = mysqli_query($connect, $sql)){ 
            while($row = mysqli_fetch_array($result)){
                $ids[] = $row['patientId'];
                $dates[] = $row['visitAt'];
            }
        }
        
        foreach($ids as $id){
            $pat = new stdClass();
            $sql = "SELECT * FROM pattient WHERE userId = $userId AND id = $id";
            if($result = mysqli_query($connect, $sql)){
                while($row = mysqli_fetch_array($result)){
                    $pat->Lastname = $row['lastname'];
                    $pat->Firstname = $row['firstname'];
                    $pat->Age = $row['age'];
                    $pat->Address = $row['address'];
                    $pat->Town = $row['town'];
                    $pat->Phone = $row['phone'];
                    $pat->Amka = $row['amka'];
                    $pat->VisitAt = $dates[$i];

                    $patients[] =  $pat;
                   
                }
            }
            $i++;
        }
        DisconnectFromDB($connect);
        return $patients;
         
    }

    function GetListOfAllVisitsOfPatientByUserId($id, $userId){
        $connect = ConnectToDB();
        $monthNow = date("m");
        $sql = "SELECT * FROM visits WHERE userId = $userId AND patientId = $id ORDER BY visitAt";
    
        if($result = mysqli_query($connect, $sql)){
        
            $patients = array();
            $pat = new stdClass();
            while($row = mysqli_fetch_array($result)){
                $pat->VisitAt = $row['visitAt'];
                $pat->Systolic = $row['systolic'];
                $pat->Diastolic = $row['diastolic'];
                $pat->Glucose = $row['glucose'];
                $pat->Comments = $row['comments'];
                                    
                $patients[] = $pat;
            
            }
            
            DisconnectFromDB($connect);
            return $patients;
        }
        DisconnectFromDB($connect);
        return false;
    }

    function CheckIfPatientIdExist($patientId){
       
        $connect = ConnectToDB();
        $sql = "SELECT * FROM pattient WHERE id = $patientId";
        if($result = mysqli_query($connect, $sql)){
            $total = mysqli_num_rows($result);
            if($total < 1){
                return false;
            }
            else return true;
        }
    }

    ob_end_flush();
?>