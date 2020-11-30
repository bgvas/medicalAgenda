<?php
    ob_start();
    Require_once '../DataBase/UserDataBaseService.php';
    Require_once '../DataBase/PattientDataBaseService.php';
      
    if(!isset($_COOKIE['token'])){
        header("Location: ../Authorization/Login.html?result=errorlogin");
        exit;
    }
    
    $userId =  GetUserIdByToken($_COOKIE['token']);
    if($userId <= 0){
        header("Location: ../Authorization/Login.html?result=usernotfound");
        exit;
    }

    // List of all pattients //
    $totalnumber = GetNumberOfPattientsByUserId($userId);
    $pages = $totalnumber/15;
    if($pages - round($pages) > 0){
        $pages = round($pages) + 1;
    }
    else $pages = round($pages);
    $selection = 1;
    $allPattientsByUser = GetPattientsByUserId($userId, $selection);
    
    if(!$allPattientsByUser){
        echo "No Data From DataBase";
        exit;
    }
    $aa = 1;
    echo "<table>
            <tr><td>A/A</td>
                <td>Lastname</td>
                <td>Firstname</td>
                <td>PattientId</td>
                <td>Age</td>
                <td>Gender</td>
                <td>Insurance</td>
                <td>AMKA</td>
                <td>Address</td>
                <td>Town</td>
                <td>Phone</td>
                <td>Active from</td>
                <td>Last visit</td>
            </tr>";

    foreach($allPattientsByUser as $pattient){
        echo "<tr>
                <td>"."$aa"."</td>
                <td>".$pattient->Lastname."</td>
                <td>".$pattient->Firstname."</td>
                <td>".$pattient->Id."</td>
                <td>".$pattient->Age."</td>
                <td>".$pattient->Gender."</td>
                <td>".$pattient->Insurance."</td>
                <td>".$pattient->Amka."</td>
                <td>".$pattient->Address."</td>
                <td>".$pattient->Town."</td>
                <td>".$pattient->Phone."</td>
                <td>".$pattient->CreatedAt."</td>
                <td>".$pattient->LastVisitAt."</td>
        </tr>";
                       
      $aa++;         
                
    }
    echo "</table>";
    // List Of All Pattients ^^^^^^ //

    
    // Average Age of All Pattients //
    if(GetAverageAgeOfPattientsByUserId($userId) == false){
        echo "false";
    }
    else echo GetAverageAgeOfPattientsByUserId($userId);
    

    // number of males and fmales //
    $total =  GetNumberOfFmalesAndMalesByUserId($userId);
    echo $total->Males."   ".$total->Fmales; 
?>
   
    
    <?php ob_end_flush();?>

